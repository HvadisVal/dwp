$("#contactForm").on("submit", function (e) {
  e.preventDefault();

  grecaptcha.ready(function () {
    grecaptcha
      .execute("6Ld1cpoqAAAAALcO07tjTnYTDe4_py7LbfM09gZ1", {
        action: "contact_form",
      })
      .then(function (token) {
        $("#g-recaptcha-response").val(token);
        $.ajax({
          url: "/dwp/contact/submit", 
          method: "POST",
          data: $("#contactForm").serialize(),
          success: function (response) {
            try {
              response = JSON.parse(response);
              if (response.success) {
                alert(response.message); 
                location.reload(); 
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
