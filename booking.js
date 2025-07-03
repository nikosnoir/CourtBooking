const court = new URLSearchParams(window.location.search).get('court');
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
    alert(`Booking confirmed for ${court} on ${date} at ${selectedSlot}:00`);
    // Here, you'd send to backend (API) to save booking
};

createTimeSlots();
