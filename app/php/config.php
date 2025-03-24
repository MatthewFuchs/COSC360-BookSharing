<?php
// Define the path to the .env file
$envPath = $_SERVER['HOME'] . '/.env';

// Ensure the file exists
if (!file_exists($envPath)) {
    die("Environment file not found at $envPath");
}

// Parse the file
$env = parse_ini_file($envPath);
if (!$env || !isset($env['DB_HOST'], $env['DB_USER'], $env['DB_PASS'], $env['DB_NAME'])) {
    die("Missing or invalid database configuration in .env");
}

// Assign DB values
$servername = $env['DB_HOST'];
$username = $env['DB_USER'];
$password = $env['DB_PASS'];
$dbname   = $env['DB_NAME'];

// Attempt DB connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Handle connection error
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>