<?php
  session_start(); // Start the session
  
  // Check if the user is logged in
  if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
      header("Location: adminlogin.html"); // Redirect to login if not logged in
      exit();
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .dashboard-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 300px;
        }

        .dashboard-container h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .dashboard-container a {
            display: block;
            text-decoration: none;
            color: #ffffff;
            background-color: #007bff;
            padding: 10px 15px;
            border-radius: 4px;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .dashboard-container a:hover {
            background-color: #0056b3;
        }

        .logout-button {
            background-color: #dc3545;
            color: #ffffff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            width: 100%;
        }

        .logout-button:hover {
            background-color: #c82333;
        }
    </style>
</head>

<body>
    <div class="dashboard-container">
        <h2>Admin Dashboard</h2>
        <a href="adminview.php">Manage Requests and Appointments</a>
        <a href="admingallery.php">Manage Gallery</a>
        <form action="logout.php" method="POST">
            <button type="submit" class="logout-button">Log Out</button>
        </form>
    </div>
</body>

</html>
