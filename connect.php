


<?php
$servername = "localhost"; // Alternatively, try "localhost" if "127.0.0.1" doesn’t work
$username = "root";        // Your MySQL username
$password = "";            // Your MySQL password (leave it empty if there's no password)
$dbname = "shoe_laundry";  // Ensure this is the correct database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
