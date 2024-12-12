document.addEventListener("DOMContentLoaded", function () {
  // Initialize Materialize modals
  var modals = document.querySelectorAll(".modal");
  M.Modal.init(modals);
});

// Guest Checkout Form Submission
$("#guestForm").on("submit", function (e) {
  e.preventDefault(); // Prevent default form submission

  // Ensure CAPTCHA is completed
  

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



  function onGuestCaptchaCompleted() {
    document.getElementById('continueBtn').disabled = false; // Enable the button
  }





$('#guestForm').on('submit', function (e) {
  e.preventDefault();

  var formData = $(this).serialize();

  // Send AJAX request to server
  $.ajax({
      url: '/dwp/user/guest', // Adjust the path as needed
      type: 'POST',
      data: formData,
      success: function (response) {
          response = JSON.parse(response);
          if (!response.success) {
            $('.error-message').text(response.message).show();
          } 
      },
      error: function () {
          $('.error-message').text('An error occurred, please try again.').show();
      }
  });
});


