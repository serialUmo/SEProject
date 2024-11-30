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
    }
?>

<!DOCTYPE html>
<html>
<style>
    iframe {
        width: 90%;
        margin: 20px auto;
        padding: 20px;
        border-radius: 8px;
    }



</style>

<a href="adminoptions.php">Admin Options</a>

<div>

<form method="POST" action="" enctype="multipart/form-data">
<label for="imgFile">Upload Image</label>
<input type="file" name="newgallimg" accept="image/*">
<br>
<br>
<button type="submit" name="upload">Update Gallery</button>
</form>

</div>

<div>
    <p style="align-text: center">Select photos for removal</p>
    <table>
        <tr>
            <th>Image Name</tr>
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
                            <button type='submit' name='remove'>Remove Photo</button> 
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

</html>



