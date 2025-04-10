<?php
session_start();
require_once 'config.php';
$isLoggedIn = isset($_SESSION["user"]);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Messages | BookTrade</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/messages.css">
    <script src="js/headerMenu.js" defer></script>
</head>
<body>

<?php include 'nav/header.php'; ?>

<div class="message-container">
    <h1>Messages</h1>

    <div class="chats">
        <button id="new">New Contact</button>

        <div id="contacts">
        <?php include 'php/new_contact.php'; ?>

        </div>
    </div>

    <div class="chatlog">

    <script>
        const bCont = document.getElementById('contacts');

        bCont.addEventListener('click', (event) => {

            $messagelist = [];
            
            if (event.target && event.target.classList.contains('real_contact')) {
             
                const bId = event.target.getAttribute('id');

                $sentst = $conn->prepare("SELECT * FROM messagelog WHERE sending_userId = ? AND reciv_userId = ?");
                $sentst->bind_param("ss", $isLoggedIn, $bId);
                $resultsent = $sentst->get_result();

                if ($sentst->execute()) {
                } else {
                echo "Error: " . $sentst->error;
                }

                if ($resultsent->num_rows > 0) {
                    while ($row = $resultsent->fetch_assoc()) {
                        $messagelist = $row['textmessage'];
                    }
                }
                
                //check for recieved messages from this user also
                $recst = $conn->prepare("SELECT * FROM messagelog WHERE sending_userId = ? AND reciv_userId = ?");
                $recst->bind_param("ss", $bId, $isLoggedIn);
                $resultrec = $recst->get_result();

                if ($recst->execute()) {
                } else {
                echo "Error: " . $recst->error;
                }

                if ($resultrec->num_rows > 0) {
                    while ($row = $resultrec->fetch_assoc()) {
                        $messagelist = $row['textmessage'];
                    }
                }
                
                // create messages
                $messagelist.forEach(element => {
                    echo "<div class='sentmessage'>element</div>";
                });     
            }

        });
    </script>

    </div>

    <div class="textinput">
        <form method="post" action="php/post_message.php">
            <textarea name="input_message" placeholder="Type Message" required>Test</textarea>
            <input type="hidden" name="replyinput">
            <button type="submit">Send</button>
        </form>
    </div>

            
    <div id="ol"></div>

    <div id="pf">
    <form method="post" action="">
        <label for="inputName">Input new contact Username</label><br>
        <input type="text" name="inputName" required><br><br>
        <button type="submit" name="submitName">Submit</button>
    </form>
    </div>

    <script>
        const button = document.getElementById('new');
        const pF = document.getElementById('pf');
        const ovl = document.getElementById('ol');

        button.addEventListener('click', () => {
            pF.style.display = 'block';
            ovl.style.display = 'block';
        });

        ovl.addEventListener('click', () => {
            pF.style.display = 'none';
            ovl.style.display = 'none';
        });
    </script>

    

</div>

<?php include 'nav/footer.php'; ?>

</body>
</html>