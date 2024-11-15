<?php
  session_start(); // Start the session
  
  // Check if the user is logged in
  if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
      header("Location: adminlogin.html"); // Redirect to login if not logged in
      exit();
  }
?>

<html>
<body>
<a href="adminview.php">Manage Requests and Appointments</a>
<a href="admingallery.php">Manage Gallery</a>
</body>
</html>
