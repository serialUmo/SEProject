<?php
  session_start(); // Start the session
  
  // Check if the user is logged in
  if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
      header("Location: adminlogin.html"); // Redirect to login if not logged in
      exit();
  }

    $servername = "127.0.0.1";
    $username = "root";
    $password = "root";
    $dbname = "project";

    $conn = new mysqli($servername, $username, $password, $dbname);

// If upload button is clicked ...
    if (isset($_POST['upload'])) {

        $filename = $_FILES["newgallimg"]["name"];
        $tempname = $_FILES["newgallimg"]["tmp_name"];
        $folder = "./gallimages/" . $filename;

        // Get all the submitted data from the form
        $sql = "INSERT INTO image (filename) VALUES ('$filename');";

        // Execute query
        mysqli_query($conn, $sql);  

        // Now let's move the uploaded image into the folder: image
        if (move_uploaded_file($tempname, $folder)) {
            echo "<h3>&nbsp; Image uploaded successfully!</h3>";
        } else {
            echo "<h3>&nbsp; Failed to upload image!</h3>";
        }
    }

    if (isset($_POST['remove'])) {
        $file_remove = $_POST['photo'];
        $sql = "DELETE FROM image WHERE filename='$file_remove'";
        mysqli_query($conn, $sql);
        if(!unlink("./gallimages/" . $file_remove)){
            echo("$file_remove could not be deleted");
        }
        else{
            echo ("$file_remove has been removed"); 
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Gallery Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px;
            margin-bottom: 20px;
        }

        .header a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        label {
            font-weight: bold;
        }

        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        button {
            background-color: #007bff;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .btn-danger {
            background-color: #dc3545;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f8f9fa;
        }

        .iframe-container {
            margin: 20px auto;
            width: 100%;
            max-width: 1200px;
            overflow: hidden;
        }

        iframe {
            width: 100%;
            height: 600px;
            border: none;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

<div class="header">
    <a href="adminoptions.php">Admin Options</a>
    <a href="logout.php">Logout</a>
</div>

<div class="container">
    <h2>Upload Image</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <label for="imgFile">Select Image:</label>
        <input type="file" id="imgFile" name="newgallimg" accept="image/*" required>
        <button type="submit" class="btn" name="upload">Update Gallery</button>
    </form>
</div>

<div class="container">
    <h2>Manage Gallery</h2>
    <p>Select photos to remove:</p>
    <table>
        <thead>
            <tr>
                <th>Image Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM image";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['filename']) . "</td>";
                    echo "<td>
                            <form method='POST' action=''>
                                <input type='hidden' name='photo' value='" . htmlspecialchars($row['filename']) . "'>
                                <button type='submit' class='btn btn-danger' name='remove'>Remove Photo</button>
                            </form>
                        </td>";
                    echo "</tr>";
                }
            }
            ?>
        </tbody>
    </table>
</div>

<div class="iframe-container">
    <iframe src="photogallery.php" title="Photo Gallery"></iframe>
</div>

</body>
</html>


<?php
    $conn->close();
?>



