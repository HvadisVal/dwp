let selectedTickets = {};
let selectedSeats = [];
const maxSeats = 5;
const selectionMessage = document.getElementById('selection-message');
const continueButton = document.getElementById('continue-button');

function updateTicketSummary() {
    const totalTickets = Object.values(selectedTickets).reduce((acc, count) => acc + count, 0);
    document.getElementById("ticket-count").textContent = `${totalTickets} ticket(s)`;
    document.getElementById("total-price").textContent = `DKK ${Object.keys(selectedTickets).reduce((acc, type) => acc + (selectedTickets[type] * parseFloat(document.querySelector(`.increase-seat[data-type="${type}"]`).dataset.price)), 0).toFixed(2)}`;
    selectionMessage.textContent = totalTickets > 0 ? "Please select your seats." : "Please select the ticket quantity and type.";
    continueButton.style.display = totalTickets > 0 && selectedSeats.length > 0 ? "block" : "none";
}

document.querySelectorAll('.increase-seat').forEach(button => {
    button.addEventListener('click', () => {
        const type = button.dataset.type;
        const currentCount = selectedTickets[type] || 0;
        const totalCount = Object.values(selectedTickets).reduce((acc, count) => acc + count, 0);

        if (totalCount < maxSeats) {
            selectedTickets[type] = currentCount + 1;
            document.getElementById(`count-${type}`).textContent = selectedTickets[type];
            
            // Reset selected seats when ticket count changes
            selectedSeats = [];
            document.querySelectorAll('.seat.selected').forEach(seat => seat.classList.remove('selected'));
            
            updateTicketSummary();
            document.querySelectorAll('.seat').forEach(seat => seat.classList.remove('disabled'));
        } else {
            alert("You can select a maximum of 5 seats.");
        }
    });
});

document.querySelectorAll('.decrease-seat').forEach(button => {
    button.addEventListener('click', () => {
        const type = button.dataset.type;
        const currentCount = selectedTickets[type] || 0;

        if (currentCount > 0) {
            selectedTickets[type] = currentCount - 1;
            document.getElementById(`count-${type}`).textContent = selectedTickets[type];
            
            // Reset selected seats when ticket count changes
            selectedSeats = [];
            document.querySelectorAll('.seat.selected').forEach(seat => seat.classList.remove('selected'));
            
            updateTicketSummary();
            if (Object.values(selectedTickets).reduce((acc, count) => acc + count, 0) === 0) {
                document.querySelectorAll('.seat').forEach(seat => seat.classList.add('disabled'));
            }
        }
    });
});


// Function to preview seats in groups based on selected tickets
function previewSeats(row, startSeat) {
    const totalTickets = Object.values(selectedTickets).reduce((acc, count) => acc + count, 0);
    document.querySelectorAll('.seat.preview').forEach(seat => seat.classList.remove('preview'));

    for (let i = 0; i < totalTickets; i++) {
        const seatElement = document.querySelector(`.seat[data-row='${row}'][data-seat-number='${startSeat + i}']`);
        if (seatElement) {
            seatElement.classList.add('preview');
        }
    }
}

// Function to select seats in groups based on selected tickets
function selectSeats(row, startSeat) {
    const totalTickets = Object.values(selectedTickets).reduce((acc, count) => acc + count, 0);

    selectedSeats.forEach(pos => {
        const [r, s] = pos.split('-').map(Number);
        const seatElement = document.querySelector(`.seat[data-row='${r}'][data-seat-number='${s}']`);
        if (seatElement) seatElement.classList.remove('selected');
    });

    selectedSeats = [];
    for (let i = 0; i < totalTickets; i++) {
        const seatPosition = `${row}-${startSeat + i}`;
        selectedSeats.push(seatPosition);
        const seatElement = document.querySelector(`.seat[data-row='${row}'][data-seat-number='${startSeat + i}']`);
        if (seatElement) seatElement.classList.add('selected');
    }
    updateTicketSummary();
}

document.querySelectorAll('.seat').forEach(seat => {
    seat.addEventListener('mouseenter', () => {
        const row = parseInt(seat.getAttribute('data-row'));
        const startSeat = parseInt(seat.getAttribute('data-seat-number'));
        previewSeats(row, startSeat);
    });

    seat.addEventListener('mouseleave', () => {
        document.querySelectorAll('.seat.preview').forEach(seat => seat.classList.remove('preview'));
    });

    seat.addEventListener('click', () => {
        const row = parseInt(seat.getAttribute('data-row'));
        const startSeat = parseInt(seat.getAttribute('data-seat-number'));
        selectSeats(row, startSeat);
    });
});


// Continue Button: Separate Logic for Final Selection Check and AJAX Call
document.getElementById('continue-button').addEventListener('click', () => {
    const totalTickets = Object.values(selectedTickets).reduce((acc, count) => acc + count, 0);

    if (totalTickets === 0) {
        alert("Please select at least one ticket.");
        return;
    } else if (selectedSeats.length !== totalTickets) {
        alert(`Please select exactly ${totalTickets} seat(s) to match your ticket count.`);
        return;
    } else {
        // AJAX call to save the selected tickets and seats
        fetch('/dwp/save-selection', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ selectedTickets, selectedSeats })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Redirect to overview if saving was successful
                window.location.href = '/dwp/overview';
            } else {
                // Show error if something went wrong
                alert(data.message || "Failed to save selection. Please try again.");
            }
        })
        .catch(error => console.error("Error:", error));
    }
});
