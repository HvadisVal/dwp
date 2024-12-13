document.addEventListener("DOMContentLoaded", function () {
  // Initialize Materialize modals
  var modals = document.querySelectorAll(".modal");
  M.Modal.init(modals);
});

// Guest Checkout Form Submission
$("#guestForm").on("submit", function (e) {
  e.preventDefault(); // Prevent default form submission

  grecaptcha.ready(function () {
    grecaptcha
      .execute("6Ld1cpoqAAAAALcO07tjTnYTDe4_py7LbfM09gZ1", {
        action: "guest_checkout",
      })
      .then(function (token) {
        // Set the token value in the hidden input field
        $("#guestForm #g-recaptcha-response").val(token);

        // Collect form data
        var formData = $("#guestForm").serialize(); // Serialize form data

        // Send the data to the server
        $.ajax({
          url: "/dwp/user/guest", // Adjust to your backend endpoint
          type: "POST",
          data: formData,
          success: function (response) {
            response = JSON.parse(response); // Parse response from server
            if (response.success) {
              location.reload(); // Reload page to display guest info
            } else {
              $(".error-message").text(response.message).show(); // Show error message
            }
          },
          error: function (xhr, status, error) {
            $(".error-message")
              .text("An error occurred, please try again.")
              .show();
          },
        });
      });
  });
});
