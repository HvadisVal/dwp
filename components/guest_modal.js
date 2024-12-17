document.addEventListener("DOMContentLoaded", function () {
  var modals = document.querySelectorAll(".modal");
  M.Modal.init(modals);
});

$("#guestForm").on("submit", function (e) {
  e.preventDefault();
  grecaptcha.ready(function () {
    grecaptcha
      .execute("6Ld1cpoqAAAAALcO07tjTnYTDe4_py7LbfM09gZ1", {
        action: "guest_checkout",
      })
      .then(function (token) {
        $("#guestForm #g-recaptcha-response").val(token);

        var formData = $("#guestForm").serialize();

        $.ajax({
          url: "/dwp/user/guest",
          type: "POST",
          data: formData,
          success: function (response) {
            response = JSON.parse(response);
            if (response.success) {
              location.reload();
            } else {
              $(".error-message").text(response.message).show();
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
