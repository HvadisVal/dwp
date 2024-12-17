document.addEventListener("DOMContentLoaded", function () {
  var modals = document.querySelectorAll(".modal");
  M.Modal.init(modals);

  const applyCouponButton = document.getElementById("applyCoupon");
  if (applyCouponButton) {
    applyCouponButton.addEventListener("click", function () {
      const couponCode = document.getElementById("couponCode").value.trim();
      const couponMessage = document.getElementById("couponMessage");
      if (!couponMessage) {
        console.error("Element with id 'couponMessage' not found in the DOM.");
        return;
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

  const paymentRadios = document.querySelectorAll(".payment-radio");
  const paymentContents = document.querySelectorAll(".payment-content");

  paymentContents.forEach((content) => {
    content.style.display = "none";
  });

  paymentRadios.forEach((radio) => {
    radio.addEventListener("change", function () {
      paymentContents.forEach((content) => {
        content.style.display = "none";
      });

      if (radio.value === "card") {
        document.getElementById("cardDetails").style.display = "block";
      } else if (radio.value === "mobilepay") {
        document.getElementById("mobilePayDetails").style.display = "block";
      }
    });
  });

  const checkoutButton = document.getElementById("checkoutButton");
  if (checkoutButton) {
    checkoutButton.addEventListener("click", function () {
      const selectedPaymentMethod = document.querySelector(
        'input[name="paymentMethod"]:checked'
      );
      if (!selectedPaymentMethod) {
        alert("Please select a payment method before proceeding to checkout.");
        return;
      }

      window.location.href = "/dwp/checkout";
    });
  }
});
