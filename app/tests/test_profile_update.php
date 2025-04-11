<?php
require_once '../php/config.php';

$userId = 1;
$newLocation = "Updated Location";

$stmt = $conn->prepare("UPDATE users SET location = ? WHERE id = ?");
$stmt->bind_param("si", $newLocation, $userId);
$stmt->execute();

$result = $conn->query("SELECT location FROM users WHERE id = $userId");
$row = $result->fetch_assoc();

echo "Profile Update Test\n";
echo $row['location'] === $newLocation ? "Location updated correctly\n" : "Location update failed\n";