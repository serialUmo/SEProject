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
        body {
            background-color: #E0F7FA;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .header {
            background-color: #000;
            color: white;
            padding: 20px 0;
            text-align: center;
        }

        .header img {
            max-width: 100%;
            height: auto;
        }

        /* Navbar styles */
        .navbar {
            background-color: #636363;
            padding: 15px;
            text-align: center;
        }

        .navbar a {
            text-decoration: none;
            color: #000000;
            font-weight: bold;
            margin: 0 15px;
        }

        .navbar a:hover {
            color: #007bff;
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
<body class="body">
    <div class="header">
        <img alt="Header Logo" height="164" src="./Images/New%20Project%20(9).png" width="948" />
    </div>
    <div class="navbar">
        <span class="auto-style1">
            <a href="home.html" class="auto-style6"><span class="auto-style4">Home Page</span></a>
            <a href="aboutus.html" class="auto-style6"><span class="auto-style4">About Us</span></a>
            <a href="quoteform.html" class="auto-style6"><span class="auto-style4">Get Your Free Quote!</span></a>
            <a href="photogallery.php" class="auto-style6"><span class="auto-style4">Gallery</span></a>
            <a href="ServiceArea.html" class="auto-style6"><span class="auto-style4">Service Areas</span></a>
        </span>
        <span class="auto-style3"><strong>609-224-7185</strong></span>
    </div>
    <div class="gallery">
            <?php
            $query = "SELECT * FROM image ";
            $result = mysqli_query($conn, $query);

            while ($data = mysqli_fetch_assoc($result)) {
            ?>
            <div class="gallery-item">
                <img src="./gallimages/<?php echo $data['filename']; ?>">
            </div>
            <?php
            }
            ?>
        </div>
          
    </div>
</body>
</html>
<?php
    $conn->close();
?>
