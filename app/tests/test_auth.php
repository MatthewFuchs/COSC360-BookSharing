<?php
require_once '../php/config.php';

function test_login($email, $password) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($user = $result->fetch_assoc()) {
        return password_verify($password, $user['password']);
    }
    return false;
}

echo "Login Tests\n";
echo test_login('testuser@example.com', 'correctpassword') ? "Valid login passed\n" : "Valid login failed\n";
echo !test_login('testuser@example.com', 'wrongpassword') ? "Invalid login blocked\n" : "Invalid login accepted\n";