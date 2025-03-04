<?php
$host = "localhost";
$user = "root";  // Default XAMPP user
$password = "";  // Default XAMPP password (empty)
$database = "url_shortner"; 

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
