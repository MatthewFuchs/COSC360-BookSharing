<?php
echo "<h2>Testing database connection...</h2>";

$envPath = $_SERVER['HOME'] . '/.env';
echo "<p>Looking for .env at: $envPath</p>";

if (!file_exists($envPath)) {
    die("<p style='color:red;'>Environment file not found at $envPath</p>");
}

$env = parse_ini_file($envPath);
if (!$env || !isset($env['DB_HOST'], $env['DB_USER'], $env['DB_PASS'], $env['DB_NAME'])) {
    die("<p style='color:red;'>Failed to parse or missing DB keys in .env file.</p>");
}

$servername = $env['DB_HOST'];
$username = $env['DB_USER'];
$password = $env['DB_PASS'];
$dbname = $env['DB_NAME'];

echo "<p>Attempting connection with:</p>";
echo "<ul>";
echo "<li>Host: $servername</li>";
echo "<li>User: $username</li>";
echo "<li>Database: $dbname</li>";
echo "</ul>";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("<p style='color:red;'>Connection failed: " . $conn->connect_error . "</p>");
} else {
    echo "<p style='color:green;'>Connection successful!</p>";
}
?>