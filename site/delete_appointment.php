<?php
session_start();

// Database connection
$servername = "127.0.0.1";
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

    // First, get the associated RequestID
    $sql = "SELECT RequestID FROM APPOINTMENT WHERE AppointmentID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $appointmentID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $requestID = $row['RequestID'];

        // Delete the appointment
        $deleteAppointmentSql = "DELETE FROM APPOINTMENT WHERE AppointmentID = ?";
        $deleteStmt = $conn->prepare($deleteAppointmentSql);
        $deleteStmt->bind_param("s", $appointmentID);
        $deleteStmt->execute();

        // Delete the associated request
        $deleteRequestSql = "DELETE FROM REQUEST WHERE RequestID = ?";
        $deleteRequestStmt = $conn->prepare($deleteRequestSql);
        $deleteRequestStmt->bind_param("s", $requestID);
        $deleteRequestStmt->execute();

        // Redirect back to the admin view page
        header("Location: admin_view.php");
        exit();
    } else {
        echo "Appointment not found.";
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>
