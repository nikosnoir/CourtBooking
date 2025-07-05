<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Court Booking</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>

  <nav class="navbar">
    <h1 id="courtName">Court Booking</h1>
  </nav>

  <section class="booking-section">
    <h2>Select Date</h2>
    <input type="date" id="datePicker" class="date-input" />

    <h2>Available Time Slots</h2>
    <div class="time-grid" id="timeGrid"></div>

    <button id="confirmBooking" class="submit-btn">Confirm Booking</button>
  </section>

  <script src="booking.js"></script>
</body>
</html>
