<html>
<body>
<?php
//Assign database information to variables
$servername = "127.0.0.1";
$username = "root";
$password = "root";
$dbname = "project";

// Connect to database using variables
$conn = new mysqli($servername, $username, $password, $dbname);
// Check if connection worked
if ($conn->connect_error) {
 die("Connection failed: " . $conn->connect_error);
}

//Assign form answers to variables
$id = uniqid();
$fname = $_POST["first_name"];
$lname = $_POST["last_name"];
$date = date('Y-m-d');
$email = $_POST["email"];
$phone = $_POST["phone"];
$address = $_POST["address"];
$pwsh = isset($_POST["powerwash"]) ? 1 : 0;
$paint = isset($_POST["paint"]) ? 1 : 0;
$drwl = isset($_POST["drywall"]) ? 1 : 0;
$desc = $_POST["description"];
$pic = isset($_POST["img"]) ? $_POST["img"] : NULL;

//Sanitize form answers
$sanitized_id = mysqli_real_escape_string($conn, $id);
$sanitized_fname = mysqli_real_escape_string($conn, $fname);
$sanitized_lname = mysqli_real_escape_string($conn, $lname);
$sanitized_date = mysqli_real_escape_string($conn, $date);
$sanitized_email = mysqli_real_escape_string($conn, $email);
$sanitized_phone = mysqli_real_escape_string($conn, $phone);
$sanitized_address = mysqli_real_escape_string($conn, $address);
$sanitized_desc = mysqli_real_escape_string($conn, $desc);


//Set up SQL query
$stmt = $conn->prepare("INSERT INTO REQUEST (RequestID, FirstName, LastName, RequestDate, 
	 Phone, Email, Location,
	 Powerwashing, Painting, Drywall, Description, Picture) 
	VALUES (?, ?, ?, ?, ? ,?, ?, ?, ?, ?, ?, ?)"); 

$stmt->bind_param("sssssssiiisb", $sanitized_id, $sanitized_fname, $sanitized_lname, $sanitized_date, $sanitized_phone, $sanitized_email,
	$sanitized_address, $pwsh, $paint, $drwl, $sanitized_desc, $pic);

//Run SQL query
if ($stmt->execute() === TRUE) {
 echo "Sign up successfully!";
 //Redirect to this page
 header("location: formcomplete.html");
}
else {
 echo "Error: " . $sql . "<br>" . $conn->error;
}

//Close connection
$conn->close();
?>
</body>
</html>
