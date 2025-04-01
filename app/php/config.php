<?php
$host = "localhost";
$port = 3307;
$dbname = "booktrade";
$user = "root";
$pass = "";

$conn = new mysqli($host, $user, $pass, $dbname, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>