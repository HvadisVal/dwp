document.addEventListener('DOMContentLoaded', function () {
   
    var modals = document.querySelectorAll('.modal');
    M.Modal.init(modals);

    const logoutButton = document.getElementById('logoutButton');
    if (logoutButton) {
        logoutButton.addEventListener('click', function () {
            $.ajax({
                type: 'POST',
                url: '/dwp/user/logout',
                success: function (response) {
                    const data = JSON.parse(response);
                    if (data.success) {
                        location.reload();
                    } else {
                        console.error("Logout failed");
                    }
                },
                error: function () {
                    console.error("An error occurred during logout");
                }
            });
        });
    }

    
    const switchUserButton = document.getElementById('switchUserButton');
    if (switchUserButton) {
        switchUserButton.addEventListener('click', function () {
            $.ajax({
                type: 'POST',
                url: '/dwp/user/switch',
                success: function (response) {
                    try {
                        const data = typeof response === "string" ? JSON.parse(response) : response;
                        if (data.success) {
                            location.reload();
                        } else {
                            M.toast({ html: data.message || "Failed to switch user. Please try again." });
                        }
                    } catch (e) {
                        console.error("Invalid JSON response:", response);
                        M.toast({ html: "An unexpected error occurred." });
                    }
                },
                error: function () {
                    console.error("AJAX request failed");
                    M.toast({ html: "Unable to switch user at the moment. Try again later." });
                }
            });
        });
    }



    const payButton = document.getElementById('payButton');
    if (payButton) {
        payButton.addEventListener('click', function (e) {
            e.preventDefault(); 

            const paymentConfirmationModal = document.getElementById('paymentConfirmationModal');
            const modalInstance = M.Modal.getInstance(paymentConfirmationModal);
            modalInstance.open();
        });
    }
});
