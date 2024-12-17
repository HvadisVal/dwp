$("#contactForm").on("submit", function (e) {
  e.preventDefault(); // Prevent default form submission

  // Execute reCAPTCHA and get the token
  grecaptcha.ready(function () {
    grecaptcha
      .execute("6Ld1cpoqAAAAALcO07tjTnYTDe4_py7LbfM09gZ1", {
        action: "contact_form",
      })
      .then(function (token) {
        // Set the reCAPTCHA token in the hidden input field
        $("#g-recaptcha-response").val(token);

        // Submit the form via AJAX
        $.ajax({
          url: "/dwp/contact/submit", // Change to your backend endpoint
          method: "POST",
          data: $("#contactForm").serialize(),
          success: function (response) {
            try {
              // Parse the JSON response
              response = JSON.parse(response);
              if (response.success) {
                alert(response.message); // Show success message
                location.reload(); // Reload the page or redirect as needed
              } else {
                alert("Error: " + response.message);
              }
            } catch (e) {
              alert("Error: Unable to process the response.");
            }
          },
          error: function () {
            alert("An error occurred. Please try again later.");
          },
        });
      });
  });
});
