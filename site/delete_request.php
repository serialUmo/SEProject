<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: adminlogin.html"); // Redirect to login if not logged in
    exit();
}

// Include database connection
$servername = "127.0.0.1";
$username = "root";
$password = "root";
$dbname = "project";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if RequestID is set
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['RequestID'])) {
    $requestID = $_POST['RequestID'];

    // Delete the request from the database
    $sql = "DELETE FROM REQUEST WHERE RequestID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $requestID);

    if ($stmt->execute()) {
        echo "Request deleted successfully.";
        header("Location: adminview.php"); // Redirect back to admin view
        exit();
    } else {
        echo "Error deleting request: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "Invalid request.";
}

$conn->close();
?>