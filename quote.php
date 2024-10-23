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

//Set up SQL query
$sql = "INSERT INTO REQUEST (RequestID, FirstName, LastName, RequestDate, 
							 Phone, Email, Location,
							 Powerwashing, Painting, Drywall, Description) 
		VALUES ('$id', '$fname', '$lname', '$date',
				'$phone', '$email', '$address',
				'$pwsh', '$paint', '$drwl', '$desc')";

//Run SQL query
if ($conn->query($sql) === TRUE) {
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
