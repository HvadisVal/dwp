$(document).ready(function () {
  // Function to handle reCAPTCHA execution and form submission
  function handleCaptchaAndSubmit(formId, action, successCallback) {
    grecaptcha.ready(function () {
      grecaptcha
        .execute("6Ld1cpoqAAAAALcO07tjTnYTDe4_py7LbfM09gZ1", {
          action: action,
        })
        .then(function (token) {
          // Set the token value in the hidden input field
          $("#" + formId + " #g-recaptcha-response").val(token);

          // Submit the form data via AJAX
          $.ajax({
            url: "/dwp/user/" + action, // Adjust the path based on action (login or new_user)
            type: "POST",
            data: $("#" + formId).serialize(),
            success: function (response) {
              if (response.success) {
                successCallback(response);
              } else {
                $("#" + formId + " .error-message")
                  .text(response.message)
                  .show();
              }
            },
            error: function (xhr, status, error) {
              console.error(action + " error:", status, error);
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
