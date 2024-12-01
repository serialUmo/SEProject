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
<html>
<style>
    iframe {
        width: 90%;
        margin: 20px;
        padding: 20px;
        border-radius: 8px;
    }

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

    .adminoptions {
        text-align: left;
    }

    .adminpotions a {
        text-decoration: none;
        color: #dc3545;
        font-weight: bold;
    }

</style>


<head>
    <meta charset="UTF-8"> 
</head>

<body>
<div class="adminoptions">
    <a href="adminoptions.php">Admin Options</a>
</div>
<div class="logout">
    <a href="logout.php">Logout</a>
</div>

<div class="container">
    <form action="" method="POST" enctype="multipart/form-data">
    <label for="imgFile">Upload Image</label>
    <input type="file" id="imgFile" name="newgallimg" accept="image/*">
    <br>
    <br>
    <button type="submit" class="btn"name="upload">Update Gallery</button>
    </form>
</div>

<div class="container">
    <p style="align-text: center">Select photos for removal</p>
    <table>
        <tr>
            <th>Image Name</tr>
            <th>Action</th>
        </tr>
    
    <?php
        $sql = "SELECT * FROM image";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['filename'] . "</td>";
                echo "<td>
                        <form  method='POST' action=''>
                            <input type='hidden' name='photo' value='" . $row['filename'] . "';>
                            <button type='submit' class='btn btn-danger' name='remove'>Remove Photo</button> 
                        </form>
                    </td>";
                echo "</tr>";
            }
        }
    ?>
    </table>
</div>


<div>

    <iframe src="photogallery.php" title="copyofGallery" style="height: 1200px; width: 1200px">

</div>
</body>
</html>

<?php
    $conn->close();
?>



