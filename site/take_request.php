<?php
  session_start(); // Start the session
  
  // Check if the user is logged in
  if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
      header("Location: adminlogin.html"); // Redirect to login if not logged in
      exit();
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['RequestID'])) {
      $requestID = $_POST['RequestID'];
  }
?>

<h2>Enter Appointment Details</h2>
<form action="save_appointment.php" method="POST">
  <input type="hidden" name="RequestID" value="<?php echo $requestID; ?>">

  <label for="date">Appointment Date (YYYY-MM-DD):</label>
  <input type="text" name="date">

  <label for="cost">Cost: $</label>
  <input type="text" name="cost"><br>

  <label for="description">Description:</label>
  <input type="text" name="desc"><br>

  <button type="submit">Save Appointment</button>
</form>

<h2>Delete Request</h2>
<!-- Delete Request Form -->
<form action="delete_request.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this request?');">
  <input type="hidden" name="RequestID" value="<?php echo $requestID; ?>">
  <button type="submit" style="color: red;">Delete Request</button>
</form>
