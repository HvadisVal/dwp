document.addEventListener("DOMContentLoaded", function () {
  // Initialize Materialize Modals
  var modals = document.querySelectorAll(".modal");
  M.Modal.init(modals);

  // Apply Coupon Logic
  const applyCouponButton = document.getElementById("applyCoupon");
  if (applyCouponButton) {
    applyCouponButton.addEventListener("click", function () {
      const couponCode = document.getElementById("couponCode").value.trim();
      const couponMessage = document.getElementById("couponMessage");
      if (!couponMessage) {
        console.error("Element with id 'couponMessage' not found in the DOM.");
        return; // Exit the function to avoid further errors
      }
      const totalPriceDisplay = document.getElementById("totalPriceDisplay");

      if (!couponCode) {
        couponMessage.style.color = "red";
        couponMessage.textContent = "Please enter a coupon code.";
        couponMessage.style.display = "block";
        return;
      }

      fetch("/dwp/frontend/actions/validate_coupon.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ couponCode }),
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.valid) {
            couponMessage.style.color = "green";
            couponMessage.textContent = `Coupon applied! You saved DKK ${data.discount}.`;
            totalPriceDisplay.textContent = `DKK ${data.newTotalPrice.toFixed(
              2
            )}`;
          } else {
            couponMessage.style.color = "red";
            couponMessage.textContent = data.message;
          }
          couponMessage.style.display = "block";
        })
        .catch((error) => {
          console.error("Error applying coupon:", error);
          couponMessage.style.color = "red";
          couponMessage.textContent = "An error occurred. Please try again.";
          couponMessage.style.display = "block";
        });
    });
  }

  // Select all radio buttons and payment content sections
  const paymentRadios = document.querySelectorAll(".payment-radio");
  const paymentContents = document.querySelectorAll(".payment-content");

  // Hide all payment content initially
  paymentContents.forEach((content) => {
    content.style.display = "none";
  });

  // Add event listeners to payment method radio buttons
  paymentRadios.forEach((radio) => {
    radio.addEventListener("change", function () {
      // Hide all payment content
      paymentContents.forEach((content) => {
        content.style.display = "none";
      });

      // Show the selected payment method's content
      if (radio.value === "card") {
        document.getElementById("cardDetails").style.display = "block";
      } else if (radio.value === "mobilepay") {
        document.getElementById("mobilePayDetails").style.display = "block";
      }
    });
  });

  // Handle "Checkout" button click
  const checkoutButton = document.getElementById("checkoutButton");
  if (checkoutButton) {
    checkoutButton.addEventListener("click", function () {
      // Perform any necessary validation before redirecting
      const selectedPaymentMethod = document.querySelector(
        'input[name="paymentMethod"]:checked'
      );
      if (!selectedPaymentMethod) {
        alert("Please select a payment method before proceeding to checkout.");
        return;
      }

      // Redirect to the secondary page
      window.location.href = "/dwp/checkout"; // Update with your secondary page path
    });
  }
});
