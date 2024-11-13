<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: adminlogin.html"); // Redirect to login if not logged in
    exit();
}

// Connect to the database and fetch the request data
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "project";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin View</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
	<a href="logout.php">Logout</a>
   	<h2>Pending Requests</h2> 
   	<table>
        <tr>
            <th>Date</th>
            <th>Name</th>
            <th>Location</th>
            <th>Phone</th>
            <th>Email</th>
            <th>P.W</th>
            <th>Paint</th>
            <th>D.W</th>
            <th>Description</th>
        </tr>

        <?php
        // Fetch requests from the database
		$sql = "SELECT r.RequestID, r.FirstName, r.LastName, r.RequestDate, 
				r.Location, r.Phone, r.Email, r.Description, 
				r.Powerwashing, r.Painting, r.Drywall
				FROM REQUEST r
				LEFT JOIN APPOINTMENT a ON r.RequestID = a.RequestID
				WHERE a.AppointmentID IS NULL;";
		$result = $conn->query($sql);

        // Loop through the result and display the rows in the table
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
		        echo "<tr>";
		        echo "<td>" . $row['RequestDate'] . "</td>";
		        echo "<td>" . $row['FirstName'] . " " . $row['LastName'] . "</td>"; 
		        echo "<td>" . $row['Location'] . "</td>";
		        echo "<td>" . $row['Phone'] . "</td>";
		        echo "<td>" . $row['Email'] . "</td>";
		        echo "<td>" . ($row['Powerwashing'] ? 'X' : '') . "</td>";
		        echo "<td>" . ($row['Painting'] ? 'X' : '') . "</td>";
		        echo "<td>" . ($row['Drywall'] ? 'X' : '') . "</td>";
		        echo "<td>" . $row['Description'] . "</td>";

		    	// Email and Take Request Buttons
				echo "<td>
                    <a href='mailto:" . $row['Email'] . "'><button>Email</button></a>
                    <form action='take_request.php' method='POST' style='display:inline;'>
                        <input type='hidden' name='RequestID' value='" . $row['RequestID'] . "'>
                        <button type='submit'>Take Request</button>
                    </form>
                  </td>";
                
                echo "</tr>";
			}
		} else {
            echo "<tr><td colspan='9'>No requests found</td></tr>";
        }
        ?>
        
    </table>
	<br> <br>
	
	<h2>Appointments</h2> 
   	<table>
        <tr>
            <th>Date</th>
            <th>Name</th>
            <th>Location</th>
            <th>Phone</th>
            <th>Email</th>
            <th>P.W</th>
            <th>Paint</th>
            <th>D.W</th>
            <th>Description</th>
            <th>Cost</th>
        </tr>

        <?php
        // Fetch appointments from the database
			$sql = "SELECT r.FirstName, r.LastName, r.Location, r.Phone, r.Email, 
                    r.Powerwashing, r.Painting, r.Drywall,  
                    a.AppointmentDate, a.Description, a.Cost
		            FROM REQUEST r
		            JOIN APPOINTMENT a ON r.RequestID = a.RequestID";    		
            $result = $conn->query($sql);
    
        // Loop through the result and display the rows in the table
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
            	echo "<tr>";
		        echo "<td>" . $row['AppointmentDate'] . "</td>";
		        echo "<td>" . $row['FirstName'] . " " . $row['LastName'] . "</td>"; 
		        echo "<td>" . $row['Location'] . "</td>";
		        echo "<td>" . $row['Phone'] . "</td>";
		        echo "<td>" . $row['Email'] . "</td>";
		        echo "<td>" . ($row['Powerwashing'] ? 'X' : '') . "</td>";
		        echo "<td>" . ($row['Painting'] ? 'X' : '') . "</td>";
		        echo "<td>" . ($row['Drywall'] ? 'X' : '') . "</td>";
		        echo "<td>" . $row['Description'] . "</td>";
		        echo "<td>" . $row['Cost'] . "</td>";
				
				// Email Button
				echo "<td><a href='mailto:" . $row['Email'] . "'><button>Email</button></a></td>";

		        echo "</tr>";
    }        } else {
            echo "<tr><td colspan='10'>No appointments found</td></tr>";
        }
        ?>
    </table>
    <br>
	<a href="modifyappt.php">Modify Appointment Information</a>
	
	</body>
</html>

<?php
// Close the connection
$conn->close();
?>
