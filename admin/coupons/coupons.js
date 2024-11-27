// Get CSRF token from the meta tag
const csrfToken = document
  .querySelector('meta[name="csrf-token"]')
  .getAttribute("content");

// Confirm delete action
function confirmDelete(couponId) {
  if (confirm("Are you sure you want to delete this coupon?")) {
    const form = document.createElement("form");
    form.method = "POST";
    form.innerHTML = `
            <input type="hidden" name="csrf_token" value="${csrfToken}">
            <input type="hidden" name="coupon_id" value="${couponId}">
            <input type="hidden" name="action" value="delete">
        `;
    document.body.appendChild(form);
    form.submit();
  }
}
