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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin View</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th {
            background-color: #f8f9fa;
            text-align: left;
            padding: 12px;
        }

        td {
            padding: 10px;
            text-align: left;
        }

        .btn {
            display: inline-block;
            background-color: #007bff;
            color: #fff;
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            cursor: pointer;
            font-size: 14px;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .btn-danger {
            background-color: #dc3545;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        .logout {
            text-align: right;
        }

        .logout a {
            text-decoration: none;
            color: #dc3545;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logout">
            <a href="logout.php">Logout</a>
        </div>
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
                <th>Actions</th>
            </tr>

            <?php
            $sql = "SELECT r.RequestID, r.FirstName, r.LastName, r.RequestDate, 
                        r.Location, r.Phone, r.Email, r.Description, 
                        r.Powerwashing, r.Painting, r.Drywall
                    FROM REQUEST r
                    LEFT JOIN APPOINTMENT a ON r.RequestID = a.RequestID
                    WHERE a.AppointmentID IS NULL;";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
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
                    echo "<td>
                            <a href='mailto:" . $row['Email'] . "' class='btn'>Email</a>
                            <form action='take_request.php' method='POST' style='display:inline;'>
                                <input type='hidden' name='RequestID' value='" . $row['RequestID'] . "'>
                                <button type='submit' class='btn btn-danger'>Take Request</button>
                            </form>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='10'>No requests found</td></tr>";
            }
            ?>
        </table>

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
                <th>Actions</th>
            </tr>

            <?php
            $sql = "SELECT r.FirstName, r.LastName, r.Location, r.Phone, r.Email, 
                        r.Powerwashing, r.Painting, r.Drywall,  
                        a.AppointmentDate, a.Description, a.Cost
                    FROM REQUEST r
                    JOIN APPOINTMENT a ON r.RequestID = a.RequestID";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
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
                    echo "<td><a href='mailto:" . $row['Email'] . "' class='btn'>Email</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='11'>No appointments found</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>

<?php
    $conn->close();
?>
