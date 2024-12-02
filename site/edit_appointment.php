<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: adminlogin.html"); // Redirect to login if not logged in
    exit();
}

// Connect to the database
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "project";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if AppointmentID is passed via the URL
if (isset($_GET['AppointmentID'])) {
    $AppointmentID = $_GET['AppointmentID'];

    // Fetch the current appointment details along with the associated customer details from the REQUEST table
    $sql = "SELECT a.*, r.FirstName, r.LastName, r.Phone, r.Email, r.Location, 
                    r.Powerwashing, r.Painting, r.Drywall
            FROM APPOINTMENT a
            LEFT JOIN REQUEST r ON a.RequestID = r.RequestID
            WHERE a.AppointmentID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $AppointmentID); // Bind the AppointmentID parameter
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the appointment data into an associative array
        $appointment = $result->fetch_assoc();
    } else {
        echo "Appointment not found.";
        exit;
    }
} else {
    echo "No AppointmentID specified.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Appointment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            max-width: 600px;
            margin: 50px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333333;
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
            color: #444444;
        }

        input[type="date"],
        input[type="number"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #cccccc;
            border-radius: 5px;
            font-size: 14px;
        }

        textarea {
            resize: none;
        }

        input[type="date"]:focus,
        input[type="number"]:focus,
        textarea:focus {
            border-color: #007bff;
            outline: none;
        }

        p {
            margin: 10px 0;
            color: #333333;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 15px;
        }

        button:hover {
            background-color: #0056b3;
        }

        .delete-btn {
            background-color: #ff4d4d;
        }

        .delete-btn:hover {
            background-color: #cc0000;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Appointment</h2>
        <form action="update_appointment.php" method="POST">
            <!-- Hidden input for AppointmentID -->
            <input type="hidden" name="AppointmentID" value="<?php echo $appointment['AppointmentID']; ?>">

            <!-- Editable Fields -->
            <label for="AppointmentDate">Appointment Date:</label>
            <input type="date" name="AppointmentDate" value="<?php echo $appointment['AppointmentDate']; ?>" required>

            <label for="Description">Description:</label>
            <textarea name="Description" rows="4" cols="50" required><?php echo $appointment['Description']; ?></textarea>

            <label for="Cost">Cost:</label>
            <input type="number" name="Cost" value="<?php echo $appointment['Cost']; ?>" required>

            <!-- Non-editable fields (for reference) -->
            <p><strong>Customer Name:</strong> <?php echo $appointment['FirstName'] . " " . $appointment['LastName']; ?></p>
            <p><strong>Phone:</strong> <?php echo $appointment['Phone']; ?></p>
            <p><strong>Email:</strong> <?php echo $appointment['Email']; ?></p>
            <p><strong>Location:</strong> <?php echo $appointment['Location']; ?></p>
            <p><strong>Services:</strong>
                <?php 
                echo $appointment['Powerwashing'] ? "Powerwashing " : "";
                echo $appointment['Painting'] ? "Painting " : "";
                echo $appointment['Drywall'] ? "Drywall " : "";
                ?>
            </p>

            <button type="submit">Update Appointment</button>
        </form>

        <!-- Delete Button -->
        <form action="delete_appointment.php" method="POST" style="margin-top: 20px;">
            <input type="hidden" name="AppointmentID" value="<?php echo $appointment['AppointmentID']; ?>">
            <button 
                type="submit" 
                class="delete-btn"
                onclick="return confirm('Are you sure you want to delete this appointment? This will also delete the associated request!');">
                Delete Appointment
            </button>
        </form>
    </div>
</body>
</html>
