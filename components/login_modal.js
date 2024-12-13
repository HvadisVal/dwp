$(document).ready(function () {
  // Function to handle reCAPTCHA execution and form submission
  function handleCaptchaAndSubmit(formId, action, successCallback) {
    grecaptcha.ready(function () {
        grecaptcha
            .execute("6Ld1cpoqAAAAALcO07tjTnYTDe4_py7LbfM09gZ1", { action: action })
            .then(function (token) {
                $("#" + formId + " #g-recaptcha-response").val(token);

                // Include CSRF token explicitly in AJAX request
                const formData = $("#" + formId).serialize() + "&csrf_token=" + $('input[name="csrf_token"]').val();

                $.ajax({
                    url: "/dwp/user/" + action,
                    type: "POST",
                    data: formData,
                    success: function (response) {
                      console.log("Raw response:", response); // Log raw server response
                      try {
                          // Parse JSON response
                          const jsonResponse = typeof response === 'string' ? JSON.parse(response) : response;
                          if (jsonResponse.success) {
                              successCallback(jsonResponse);
                          } else {
                              $("#" + formId + " .error-message")
                                  .text(jsonResponse.message)
                                  .show();
                          }
                      } catch (e) {
                          console.error("Error parsing JSON response:", e, response);
                          $("#" + formId + " .error-message")
                              .text("Unexpected server error. Please try again.")
                              .show();
                      }
                  },
                  
                    error: function (xhr, status, error) {
                        console.error(action + " error:", status, error);
                        $("#" + formId + " .error-message")
                            .text("Error occurred while processing. Please try again.")
                            .show();
                    },
                });
            });
    });
}

  
  // Login Form Submission
  $("#loginForm").on("submit", function (e) {
    e.preventDefault();

    handleCaptchaAndSubmit("loginForm", "login", function (response) {
      // On successful login, reload the page
      location.reload();
    });
  });

  // New User Form Submission
  $("#newUserForm").on("submit", function (e) {
    e.preventDefault();

    handleCaptchaAndSubmit("newUserForm", "new_user", function (response) {
      // Close modal after successful user creation
      const modalInstance = M.Modal.getInstance(
        document.getElementById("newUserModal")
      );
      modalInstance.close(); // Close the modal after success
      M.toast({ html: "User account created successfully! Please login." });
    });
  });

  // Logout Button
  $(document).on("click", "#logoutButton", function () {
    $.ajax({
      url: "/dwp/user/logout", // Path to your logout script
      type: "POST",
      success: function (response) {
        if (response.success) {
          location.reload(); // Reload the page to show the login button
        } else {
          console.error("Logout failed:", response.message);
        }
      },
      error: function (xhr, status, error) {
        console.error("Logout error:", status, error);
      },
    });
  });

  // Initialize Materialize Modals
  document.addEventListener("DOMContentLoaded", function () {
    var modals = document.querySelectorAll(".modal");
    M.Modal.init(modals);
  });
});
