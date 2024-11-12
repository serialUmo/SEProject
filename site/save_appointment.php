<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "contracting";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['RequestID'], $_POST['date'], $_POST['price'])) {
    $requestID = $_POST['RequestID'];
    $appointmentDate = $_POST['date'];
    $price = $_POST['price'];

    // Fetch the original request data
    $sql = "SELECT * FROM REQUEST WHERE RequestID = '$requestID'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $request = $result->fetch_assoc();

        // Insert into APPOINTMENT table
        $insertSql = "INSERT INTO APPOINTMENT (RequestID, FirstName, LastName, AppointmentDate, 
                                                Phone, Email, Location, Powerwashing, Painting, 
                                                Drywall, Description, Cost)
                      VALUES ('$requestID', '" . $request['FirstName'] . "', '" . $request['LastName'] . "', 
                              '$appointmentDate', '" . $request['Phone'] . "', '" . $request['Email'] . "', 
                              '" . $request['Location'] . "', " . $request['Powerwashing'] . ", " . 
                              $request['Painting'] . ", " . $request['Drywall'] . ", 
                              '" . $request['Description'] . "', '$price')";

        if ($conn->query($insertSql) === TRUE) {
            // Delete from REQUEST table
            $deleteSql = "DELETE FROM REQUEST WHERE RequestID = '$requestID'";
            if ($conn->query($deleteSql) === TRUE) {
                echo "Appointment saved successfully!";
            } else {
                echo "Error deleting request: " . $conn->error;
            }
        } else {
            echo "Error saving appointment: " . $conn->error;
        }
    } else {
        echo "Request not found.";
    }
}

$conn->close();
?>
