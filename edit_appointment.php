<?php
// Start the session and include database connection
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

// Get the AppointmentID from the query string
$appointmentID = isset($_GET['AppointmentID']) ? $_GET['AppointmentID'] : null;

if (!$appointmentID) {
    die("No appointment specified.");
}

// Fetch the appointment details
$sql = "SELECT r.FirstName, r.LastName, r.Location, r.Phone, r.Email, 
               r.Powerwashing, r.Painting, r.Drywall, 
               a.AppointmentID, a.AppointmentDate, a.Description, a.Cost 
        FROM REQUEST r
        JOIN APPOINTMENT a ON r.RequestID = a.RequestID
        WHERE a.AppointmentID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $appointmentID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Appointment not found.");
}

$appointment = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Appointment</title>
</head>
<body>
    <h2>Edit Appointment</h2>
    <form action="update_appointment.php" method="POST">
        <!-- Hidden input for AppointmentID -->
        <input type="hidden" name="AppointmentID" value="<?php echo $appointment['AppointmentID']; ?>">

        <!-- Editable Fields -->
        <label for="AppointmentDate">Appointment Date:</label>
        <input type="date" name="AppointmentDate" value="<?php echo $appointment['AppointmentDate']; ?>" required><br><br>

        <label for="Description">Description:</label>
        <textarea name="Description" rows="4" cols="50"><?php echo $appointment['Description']; ?></textarea><br><br>

        <label for="Cost">Cost:</label>
        <input type="number" name="Cost" value="<?php echo $appointment['Cost']; ?>" required><br><br>

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
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
