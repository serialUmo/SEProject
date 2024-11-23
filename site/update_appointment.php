<?php
// Include database connection
session_start();
$servername = "127.0.0.1";
$username = "root";
$password = "root";
$dbname = "project";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$appointmentID = $_POST['AppointmentID'];
$appointmentDate = $_POST['AppointmentDate'];
$description = $_POST['Description'];
$cost = $_POST['Cost'];

// Sanitize inputs
$appointmentDate = mysqli_real_escape_string($conn, $appointmentDate);
$description = mysqli_real_escape_string($conn, $description);
$cost = mysqli_real_escape_string($conn, $cost);

// Update the appointment in the database
$sql = "UPDATE APPOINTMENT 
        SET AppointmentDate = ?, Description = ?, Cost = ? 
        WHERE AppointmentID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $appointmentDate, $description, $cost, $appointmentID);

if ($stmt->execute()) {
    echo "Appointment updated successfully.";
    header("Location: adminview.php"); // Redirect back to the admin view
    exit();
} else {
    echo "Error updating appointment: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
