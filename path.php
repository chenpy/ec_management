<?php
$servername = "127.0.0.1";
$username = "root";
$password = "064064";
$dbname = "ec1";

// Create connection
$conn = new mysqli($servername, $username, $password,$dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error ."<br>");
} 
$conn->set_charset("utf8");
?>