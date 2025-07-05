<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$court = $_GET['court'] ?? '';
$validCourts = ['takraw', 'futsal', 'volleyball'];
if (!in_array($court, $validCourts)) {
    die("Invalid court selected.");
}

function getCourtImage($courtType) {
    switch ($courtType) {
        case 'takraw':
            return "https://i0.wp.com/www.ukuransaiz.com/wp-content/uploads/2025/02/Ukuran-Gelanggang-Sepak-Takraw-Rasmi-Sekolah-Rekreasi.webp";
        case 'futsal':
            return "https://cdn1.npcdn.net/userfiles/21669/image/01(3).jpg";
        case 'volleyball':
            return "https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEhoLjDRcc34BbV77mJhUJwGS0gw84aX_GLEnqmejyqsAZOGXChyphenhyphenlP5b7qX3LhyGgfVH8BsVIzmsq384Jr6FrdqE62B1hjUasHcmj3vbnbRW7mpdnYIZ676YR3_ULMcME0QfI9kvbStnmdI/s1600/Photo0015.jpg";
        default:
            return "";
    }
}

$courtName = ucfirst($court);
$courtImage = getCourtImage($court);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $courtName ?> Court Booking</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav class="navbar">
    <h1><?= $courtName ?> Court Booking</h1>
</nav>

<section class="booking-section">
    <img src="<?= $courtImage ?>" alt="<?= $courtName ?> Court" style="width: 100%; border-radius: 8px; margin-bottom: 1rem;">

    <h2>Select Date</h2>
    <input type="date" id="datePicker" class="date-input">

    <h2>Select Time Slot</h2>
    <div class="time-grid" id="timeGrid"></div>

    <button class="submit-btn" id="confirmBooking">Confirm Booking</button>
</section>

<script>
    const court = "<?= $court ?>";
    const timeGrid = document.getElementById('timeGrid');
    const confirmBtn = document.getElementById('confirmBooking');
    let selectedSlot = null;

    function createTimeSlots() {
        for (let hour = 8; hour < 22; hour++) {
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
            time: selectedSlot
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
</script>

</body>
</html>
