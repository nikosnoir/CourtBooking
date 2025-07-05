<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>UiTM Court Booking</title>
  <link rel="stylesheet" href="style.css"/>
  <link rel="manifest" href="manifest.json"/>
  <script src="https://accounts.google.com/gsi/client" async defer></script>
</head>
<body>
<?php include 'navbar.php'; ?>
  <div class="nav-buttons">
  <a href="login.php" class="nav-btn">Login</a>
</div>


  <section class="courts">
    <div class="court-card" onclick="window.location.href='booking.html?court=takraw'">
      <img src="https://i0.wp.com/www.ukuransaiz.com/wp-content/uploads/2025/02/Ukuran-Gelanggang-Sepak-Takraw-Rasmi-Sekolah-Rekreasi.webp" alt="Takraw Court">
      <h3>Takraw Court</h3>
    </div>
    <div class="court-card" onclick="window.location.href='booking.html?court=futsal'">
      <img src="https://cdn1.npcdn.net/userfiles/21669/image/01(3).jpg" alt="Futsal Court">
      <h3>Futsal Court</h3>
    </div>
    <div class="court-card" onclick="window.location.href='booking.html?court=volleyball'">
      <img src="https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEhoLjDRcc34BbV77mJhUJwGS0gw84aX_GLEnqmejyqsAZOGXChyphenhyphenlP5b7qX3LhyGgfVH8BsVIzmsq384Jr6FrdqE62B1hjUasHcmj3vbnbRW7mpdnYIZ676YR3_ULMcME0QfI9kvbStnmdI/s1600/Photo0015.jpg" alt="Volleyball Court">
      <h3>Volleyball Court</h3>
    </div>
  </section>

  <script>
    function handleGoogleLogin(response) {
      fetch('google_login.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ token: response.credential })
      })
      .then(res => res.json())
      .then(data => {
        if (data.status === 'success') {
          window.location.href = 'dashboard.php';
        } else {
          alert(data.message || 'Login failed');
        }
      });
    }
  </script>

</body>
</html>
