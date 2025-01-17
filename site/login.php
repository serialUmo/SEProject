<?php
session_start(); // Start a session to manage logged-in state

// Database connection settings
$servername = "127.0.0.1";
$username = "root";
$password = "root";
$dbname = "project";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get username and password from POST request
$user = $_POST['username'];
$pass = $_POST['password'];

// Query to find the user
$sql = "SELECT * FROM ADMIN WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user);
$stmt->execute();
$result = $stmt->get_result();

// Check if user exists and verify password
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    
    // Use password_verify if passwords are hashed
    if ($row['Password'] === $pass) { // Replace with password_verify($pass, $row['password']) for hashed passwords
        // Set session variables for logged-in state
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $user;
        
        // Redirect to admin page
        header("Location: adminoptions.php");
        exit();
    } else {
        echo "Wrong password.";
    }
} else {
    echo "Invalid credentials.";
}

// Close connection
$stmt->close();
$conn->close();
?>
