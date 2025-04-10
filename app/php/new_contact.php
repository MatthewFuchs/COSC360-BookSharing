<?php

require_once "config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['inputName']) && $_POST['inputName'] !== '') {

    $nam = $_POST['inputName'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $nam);

        if ($stmt->execute()) {
        } else {
            echo "Error: " . $stmt->error;
        }

    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $real_user = htmlspecialchars($row['username']);

    if ($result->num_rows == 1) {
        echo "<button class='real_contact' id="$real_user">$real_user</button>";
    } else {
        echo "<div>Invalid Username</div>";
    }

}

?>