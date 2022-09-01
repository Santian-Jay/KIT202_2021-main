<?php
if (empty($_SESSION['session_user_id'])) {
    require 'session.php';
}

function print_message_list()
{
    require 'connection.php';

    $userID = intval($_SESSION['session_user_id']);

    echo '<form class="message-inbox-overview-item-container" action="general/message_process.php" method="post">';

    if (!empty($_GET['result'])) {
        switch ($_GET['result']) {
            case "send_successful":
                echo "<span class='profile-span error-message'><b>Messege send successful!</b></span>";
                break;
            case "email_error":
                echo "<span class='profile-span error-message'><b>Receiver email not exits, please try again.</b></span>";
                break;
        }
    }

    echo '<div class="message-heading-container">
                <input type="text" placeholder="Receiver email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" name="email" required>
            </div>
            <div class="message-content-container">
                <textarea rows="3" placeholder="Message content" name="content" required></textarea>
            </div>
            <input type="hidden" class="submit-value" name="action" value="add" style="height: 0;">
            <button class="btn btn-outline-primary message-button" name="submit_form"><b>Send Message</b></button>';

    echo '</form>';

    //query for message needs display for current user
    $result = $mysqli->query("SELECT message.*, users.Email FROM message
                            INNER JOIN users ON message.ReceiverID=users.UserID
                            WHERE State = 'noread' AND ReceiverID = $userID");

    //print all rows from query result
    while ($row = $result->fetch_array()) {
        //find sender's email
        $sender_id = $row['SenderID'];
        $query = "SELECT * FROM users WHERE UserID = $sender_id";
        $sender_result = $mysqli->query($query);
        $sender_row = mysqli_fetch_array($sender_result);
        $sender_email = $sender_row['Email'];

        echo '<form class="message-inbox-overview-item-container" action="general/message_process.php" method="post">
                <div class="message-heading-container">
                    <span>A message from <b>' . $sender_email . '</b></span>
                </div>
                <div class="message-content-container">
                    <span>' . $row['Content'] . '</b></span>
                </div>
                <input type="hidden" class="submit-id" name="table_id" value="' . $row['MessageID'] . '" style="height: 0;">
                <input type="hidden" class="submit-value" name="action" value="read" style="height: 0;">
                <button class="btn btn-outline-primary message-button" name="submit_form"><b>Delete</b></button>
            </form>';
    }
}
