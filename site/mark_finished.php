<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: adminlogin.html");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "project";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if AppointmentID is provided
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['AppointmentID'])) {
    $appointmentID = mysqli_real_escape_string($conn, $_POST['AppointmentID']);

    // Update query to mark the appointment as finished
    $sql = "UPDATE APPOINTMENT SET Finished = TRUE WHERE AppointmentID = '$appointmentID'";

    if ($conn->query($sql) === TRUE) {
        header("Location: admin_view.php"); // Redirect back to the admin view page
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$conn->close();
?>
