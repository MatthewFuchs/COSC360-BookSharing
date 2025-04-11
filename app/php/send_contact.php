<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL);
    $message = strip_tags(trim($_POST["message"]));

    if (!$name || !$email || !$message) {
        header("Location: ../contact.php?status=error");
        exit;
    }

    $to = "matthewfuchs@outlook.com";
    $subject = "New Contact Form Message from BookTrade";

    $email_content = "You received a new message from BookTrade:\n\n";
    $email_content .= "Name: $name\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Message:\n$message\n";

    $headers = "From: BookTrade Contact <noreply@booktrade.ca>\r\n";
    $headers .= "Reply-To: $email\r\n";

    if (mail($to, $subject, $email_content, $headers)) {
        header("Location: ../contact.php?status=success");
        exit;
    } else {
        header("Location: ../contact.php?status=fail");
        exit;
    }
} else {
    header("Location: ../contact.php");
    exit;
}
?>