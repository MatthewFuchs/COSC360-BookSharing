<?php
$name = "Unit Test";
$email = "test@unit.com";
$message = "This is a test message.";

$body = "Name: $name\nEmail: $email\nMessage: $message";
$isFormatted = strpos($body, "Email:") !== false && strpos($body, "Message:") !== false;

echo "Contact Form Test\n";
echo $isFormatted ? "Email format looks valid\n" : "Email format invalid\n";