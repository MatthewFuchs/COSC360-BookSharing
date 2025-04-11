<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit();
}

$userId = $_SESSION['user']['id'];
$full_name = trim($_POST['full_name']);
$email = trim($_POST['email']);
$phone = trim($_POST['phone_number']);
$location = trim($_POST['location']);

$profilePicPath = null;

// Handle image upload
if (isset($_FILES['profile-picture']) && $_FILES['profile-picture']['error'] === UPLOAD_ERR_OK) {
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $maxSize = 2 * 1024 * 1024;

    if (!in_array($_FILES['profile-picture']['type'], $allowedTypes)) {
        header("Location: ../profile.php?error=invalid_type");
        exit;
    }

    if ($_FILES['profile-picture']['size'] > $maxSize) {
        header("Location: ../profile.php?error=too_large");
        exit;
    }

    $uploadDir = '../uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $extension = pathinfo($_FILES['profile-picture']['name'], PATHINFO_EXTENSION);
    $filename = 'user_' . $userId . '_' . time() . '.' . $extension;
    $targetFile = $uploadDir . $filename;

    if (move_uploaded_file($_FILES['profile-picture']['tmp_name'], $targetFile)) {
        $profilePicPath = 'uploads/' . $filename;
    } else {
        header("Location: ../profile.php?error=upload_failed");
        exit;
    }
}

// Update database
if ($profilePicPath) {
    $stmt = $conn->prepare("UPDATE users SET full_name=?, email=?, phone_number=?, location=?, profile_image=? WHERE id=?");
    $stmt->bind_param("sssssi", $full_name, $email, $phone, $location, $profilePicPath, $userId);
} else {
    $stmt = $conn->prepare("UPDATE users SET full_name=?, email=?, phone_number=?, location=? WHERE id=?");
    $stmt->bind_param("ssssi", $full_name, $email, $phone, $location, $userId);
}

if ($stmt->execute()) {
    // Update session to reflect new values
    $_SESSION['user']['full_name'] = $full_name;
    $_SESSION['user']['email'] = $email;
    $_SESSION['user']['phone_number'] = $phone;
    $_SESSION['user']['location'] = $location;

    if ($profilePicPath) {
        $_SESSION['user']['profile_image'] = $profilePicPath;
    }

    header("Location: ../profile.php?updated=1");
    exit();
} else {
    header("Location: ../profile.php?error=db");
    exit();
}
?>