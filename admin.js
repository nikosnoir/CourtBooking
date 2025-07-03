document.getElementById('updateStatus').onclick = () => {
    const court = document.getElementById('courtSelect').value;
    const status = document.getElementById('statusSelect').value;
    alert(`Court ${court} status set to ${status}`);
};

const bookings = [
    { court: 'takraw', date: '2025-06-28', time: '10:00', user: 'John Doe' },
    { court: 'futsal', date: '2025-06-28', time: '12:00', user: 'Jane Smith' }
];

const bookingList = document.getElementById('bookingList');
bookings.forEach(b => {
    const row = document.createElement('tr');
    row.innerHTML = `<td>${b.court}</td><td>${b.date}</td><td>${b.time}</td><td>${b.user}</td>`;
    bookingList.appendChild(row);
});
