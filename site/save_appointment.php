<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "project";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['RequestID'], $_POST['date'], $_POST['cost'], $_POST['desc'])) {
    $appointmentID = uniqid();
    $requestID = $_POST['RequestID'];
    $appointmentDate = $_POST['date'];
    $cost = $_POST['cost'];
    $desc = $_POST['desc'];
}

// Prepare the SQL statement
$sql = "INSERT INTO APPOINTMENT (AppointmentID, RequestID, AppointmentDate, Cost, Description)
        VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssds", $appointmentID, $requestID, $appointmentDate, $cost, $desc);

// Execute the statement
if ($stmt->execute()) {
    echo "Appointment saved successfully!";
    header("Location: adminview.php");
} 
else {
    echo "Error: " . $stmt->error;
}

// Close connections
$stmt->close();
$conn->close();
?>
