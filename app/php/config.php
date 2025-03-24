<?php
$envPath = '/home/mfuchs02/.env';

if (!file_exists($envPath)) {
    die("Environment file not found at $envPath");
}

$env = parse_ini_file($envPath);
if (!$env) {
    die("Failed to parse .env file.");
}

$servername = $env['DB_HOST'] ?? 'localhost';
$username = $env['DB_USER'] ?? '';
$password = $env['DB_PASS'] ?? '';
$dbname = $env['DB_NAME'] ?? '';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>