<?php
session_start();
require_once 'config.php';

// Check if request is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["signup-email"]);
    $username = trim($_POST["signup-username"]);
    $password = $_POST["signup-password"];

    if (empty($email) || empty($username) || empty($password)) {
        die("All fields are required.");
    }

    // Check if user already exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? OR username = ?");
    $stmt->bind_param("ss", $email, $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        die("User with this email or username already exists.");
    }

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert user
    $stmt = $conn->prepare("INSERT INTO users (email, username, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $email, $username, $hashedPassword);

    if ($stmt->execute()) {
        $_SESSION["user"] = [
            "id" => $conn->insert_id,
            "username" => $username,
            "email" => $email,
            'role' => $user['role']
        ];
        header("Location: ../browse.php");
        exit;
    } else {
        die("Something went wrong. Try again later.");
    }
}
?>