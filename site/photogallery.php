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
<style>
        /* General reset */
        body, h1, h2, p, a {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        /* Navbar styles */
        .navbar {
            background-color: #333;
            overflow: hidden;
            text-align: center;
        }

        .navbar a {
            display: inline-block;
            color: white;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
            font-size: 18px;
        }

        .navbar a:hover {
            background-color: #ddd;
            color: black;
        }

        .navbar span {
            display: inline-block;
            color: white;
            padding: 14px 20px;
            font-size: 18px;
        }

        /* Body styles */
        .body {
            background-color: #f4f4f4;
            padding: 20px;
            font-size: 16px;
        }

        /* Gallery styles */
        .gallery {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            margin-top: 20px;
        }

        .gallery-item {
            margin: 10px;
            flex: 1 1 30%;
            max-width: 30%;
            box-sizing: border-box;
        }

        .gallery-item img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .navbar a, .navbar span {
                padding: 12px 15px;
                font-size: 16px;
            }

            .gallery-item {
                flex: 1 1 45%;
                max-width: 45%;
            }
        }

        @media (max-width: 480px) {
            .navbar a, .navbar span {
                padding: 10px 12px;
                font-size: 14px;
            }

            .gallery-item {
                flex: 1 1 100%;
                max-width: 100%;
            }
        }
    </style>

<head>
    <meta charset="UTF-8">
    
</head>
<div class="navbar">
    <a href="home.html"><span>Home Page</span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="Aboutus.html"><span>About Us</span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="quoteform.html"><span>Get Your Free Quote</span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <span>609-224-7185</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="photogallery.html"><span>Gallery</span></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="contact.html"><span>Contact Us</span></a>
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
</body>
</html>
