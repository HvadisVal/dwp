document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("resetPasswordForm");

  if (form) {
    form.addEventListener("submit", function (e) {
      e.preventDefault(); 

      const formData = new FormData(form);

      fetch("/dwp/user/reset-password", {
        method: "POST",
        body: formData,
      })
        .then((response) => response.json())
        .then((data) => {
          console.log("Server Response:", data); 

          if (data.success) {
            alert(data.message); 
            window.location.href = "/dwp/"; 
          } else {
            alert(data.message); 
          }
        })
        .catch((error) => {
          console.error("Error in fetch:", error);
          alert("An error occurred. Please try again.");
        });
    });
  } else {
    console.error("Reset password form not found.");
  }
});
