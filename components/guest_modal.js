document.addEventListener("DOMContentLoaded", function () {
  // Initialize Materialize modals
  var modals = document.querySelectorAll(".modal");
  M.Modal.init(modals);
});

// Guest Checkout Form Submission
$("#guestForm").on("submit", function (e) {
  e.preventDefault(); // Prevent default form submission

  // Ensure CAPTCHA is completed
  var captchaResponse = grecaptcha.getResponse();
  if (!captchaResponse || captchaResponse.length === 0) {
    $(".error-message").text("Please complete the CAPTCHA").show();
    return; // Stop submission if CAPTCHA is not filled
  }

  // Collect form data
  var formData = $(this).serialize(); // Serialize form data

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
      $(".error-message").text("An error occurred, please try again.").show();
    },
  });
});

// Enable the "Continue" button once CAPTCHA is completed
function onCaptchaCompleted() {
  $("#continueButton").prop("disabled", false);
  console.log("CAPTCHA verified. Continue button enabled.");
}
