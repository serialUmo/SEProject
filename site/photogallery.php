<?php
    session_start();

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

<html>
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    
</head>
<div class="navbar">
    <a class="auto-style16" href="home.html"><span class="auto-style15">Home Page</span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a class="auto-style16" href="Aboutus.html"><span class="auto-style15">About Us</span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a class="auto-style16" href="quoteform.html"><span class="auto-style15">Get Your Free Quote!</span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <span class="auto-style15">609-224-7185</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="photogallery.html" class="auto-style16"><span class="auto-style15">Gallery</span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="contact.html" class="auto-style16"><span class="auto-style15">Contact Us</span></a>
</div>
<body class="body">
    <div class="gallery">
        <div class="gallery-item">
            <?php
            $query = "SELECT * FROM image ";
            $result = mysqli_query($conn, $query);

            while ($data = mysqli_fetch_assoc($result)) {
            ?>
                <img src="./gallimages/<?php echo $data['filename']; ?>">

            <?php
            }
            ?>
        </div>
          
    </div>
