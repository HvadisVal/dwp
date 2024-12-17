document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("resetPasswordForm");

  if (form) {
    form.addEventListener("submit", function (e) {
      e.preventDefault(); // Prevent default form submission

      const formData = new FormData(form);

      fetch("/dwp/user/reset-password", {
        method: "POST",
        body: formData,
      })
        .then((response) => response.json())
        .then((data) => {
          console.log("Server Response:", data); // Log the server response for debugging

          if (data.success) {
            alert(data.message); // Optional: show a success message
            window.location.href = "/dwp/"; // Redirect to the homepage
          } else {
            alert(data.message); // Show error message
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
