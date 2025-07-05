const court = new URLSearchParams(window.location.search).get('court');
if (!court) {
    alert("❌ Court not specified in URL. Please select a court from the homepage.");
    window.location.href = "index.html";
    throw new Error("Court parameter missing");
}
document.getElementById('courtName').innerText = `${court.charAt(0).toUpperCase() + court.slice(1)} Court Booking`;

const timeGrid = document.getElementById('timeGrid');
const confirmBtn = document.getElementById('confirmBooking');

let selectedSlot = null;

function createTimeSlots() {
    const startHour = 8;
    const endHour = 22;

    for (let hour = startHour; hour < endHour; hour++) {
        const slot = document.createElement('div');
        slot.className = 'time-slot';
        slot.innerText = `${hour}:00 - ${hour + 1}:00`;
        slot.onclick = () => selectSlot(slot, hour);
        timeGrid.appendChild(slot);
    }
}

function selectSlot(element, hour) {
    document.querySelectorAll('.time-slot').forEach(slot => slot.classList.remove('selected'));
    element.classList.add('selected');
    selectedSlot = hour;
}

confirmBtn.onclick = () => {
    const date = document.getElementById('datePicker').value;
    if (!date || selectedSlot === null) {
        alert("Please select date and time slot");
        return;
    }

    const data = {
        court,
        date,
        time: `${selectedSlot}:00:00`
    };

    fetch('save_booking.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(response => {
        if (response.status === 'success') {
            alert("✅ " + response.message);
            window.location.href = 'my_bookings.php';
        } else {
            alert("❌ " + response.message);
        }
    })
    .catch(() => {
        alert("❌ Something went wrong. Please try again.");
    });
};


createTimeSlots();
