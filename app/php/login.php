<?php
session_start();
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["login-username"]);
    $password = $_POST["login-password"];

    if (empty($username) || empty($password)) {
        die("Username and password are required.");
    }

    // Fetch user
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Check password
    if (!$user || !password_verify($password, $user["password"])) {
        die("Invalid credentials.");
    }

    // Check if user is disabled
    if (isset($user["status"]) && $user["status"] === "disabled") {
        die("Your account has been disabled. Please contact an administrator.");
    }

    // Save session
    $_SESSION["user"] = [
        "id" => $user["id"],
        "username" => $user["username"],
        "email" => $user["email"],
        "role" => $user["role"]
    ];

    header("Location: ../browse.php");
    exit;
}
?>