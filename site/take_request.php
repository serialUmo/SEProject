<?php
  session_start(); // Start the session
  
  // Check if the user is logged in
  if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
      header("Location: login.php"); // Redirect to login if not logged in
      exit();
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['RequestID'])) {
      $requestID = $_POST['RequestID'];
      ?>
      <h2>Enter Appointment Details</h2>
      <form action="save_appointment.php" method="POST">
          <input type="hidden" name="RequestID" value="<?php echo $requestID; ?>">
          
          <label for="date">Appointment Date:</label>
          <input type="date" name="date" required>
          
          <label for="price">Price:</label>
          <input type="number" name="price" required>
          
          <button type="submit">Save Appointment</button>
      </form>
      <?php
  }
?>
