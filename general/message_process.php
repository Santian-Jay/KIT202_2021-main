<?php
include 'session.php';

if (!isset($_REQUEST['submit_form'])) {
    return;
} else {
    //depends the action field data to determine function to go
    switch ($_REQUEST['action']) {
        case "add":
            add();
            break;
        case "edit":
            edit();
            break;
        case "read":
            read();
            break;
    }
}

function add()
{
    require_once 'connection.php';

    $user_id = intval($_SESSION['session_user_id']);

    //use the largest id number plus one as new id number for this new message
    $query = "SELECT MAX(MessageID) FROM message";
    $result = $mysqli->query($query);
    $row = mysqli_fetch_array($result);
    $message_id = $row[0] + 1;

    //data from submitted form
    $state = "noread";
    $content = trim($_POST['content']);
    $sender_id = $user_id;
    $receiver_email = trim($_POST['email']);

    //use email from submitted form get userID
    $query = $mysqli->prepare("SELECT * FROM users WHERE Email = ?");
    $query->bind_param('s', $receiver_email);
    $query->execute();
    $row = $query->get_result();

    //check if email is valid
    if (mysqli_num_rows($row) > 0) {
        $row = $row->fetch_array(MYSQLI_ASSOC);
        $receiver_id = $row['UserID'];

        //query to store data collected from submitted form into database
        $query = $mysqli->prepare(
            "INSERT INTO message (
        MessageID,
        State,
        Content,
        SenderID,
        ReceiverID)
        VALUE (?, ?, ?, ?, ?)"
        );
        $query->bind_param(
            'issii',
            $message_id,
            $state,
            $content,
            $sender_id,
            $receiver_id
        );
        $query->execute();

        //jump back to dashboard depends by user type
        switch ($_SESSION['session_user_type']) {
            case "client":
                header("Location: ../user_dashboard.php?result=send_successful");
                die;
                break;
            case "host":
                header("Location: ../host_dashboard.php?result=send_successful");
                die;
                break;
            case "manager":
                header("Location: ../manager_dashboard.php?result=send_successful");
                die;
                break;
        }
    } else {
        //jump back to dashboard depends by user type
        switch ($_SESSION['session_user_type']) {
            case "client":
                header("Location: ../user_dashboard.php?result=email_error");
                die;
                break;
            case "host":
                header("Location: ../host_dashboard.php?result=email_error");
                die;
                break;
            case "manager":
                header("Location: ../manager_dashboard.php?result=email_error");
                die;
                break;
        }
    }
}

function edit()
{
    require_once 'connection.php';

    //get the booking message id that need to modify
    $message_id = intval($_POST['table_id']);

    //query the selected booking message by id to modify
    $query = $mysqli->prepare("SELECT * FROM message WHERE MessageID = ?");
    $query->bind_param('i', $message_id);
    $query->execute();
    $row = $query->get_result()->fetch_array(MYSQLI_NUM);

    //data from submitted form, form to a new array depends if the data is exist
    $form = array(
        $row[0],
        !empty($_POST['state']) ? $_POST['state'] : $row[1],
        !empty($_POST['content']) ? trim($_POST['content']) : $row[2],
        $row[3],
        !empty($_POST['receiver_id']) ? intval($_POST['receiver_id']) : $row[4]
    );

    //query to update data collected from submitted form into database
    $query =  $mysqli->prepare(
        "UPDATE message SET
        State = ?,
        Content = ?,
        ReceiverID = ?
        WHERE MessageID = ?"
    );
    $query->bind_param('ssii', $form[1], $form[2], $form[4], $message_id);
    $query->execute();

    //jump back to dashboard depends by user type
    switch ($_SESSION['session_user_type']) {
        case "client":
            header("Location: ../user_dashboard.php?result=update_successful");
            die;
            break;
        case "host":
            header("Location: ../host_dashboard.php?result=update_successful");
            die;
            break;
        case "manager":
            header("Location: ../manager_dashboard.php?result=update_successful");
            die;
            break;
    }
}

function read()
{
    require_once 'connection.php';

    $message_id = intval($_POST['table_id']);

    //query to update message state to database
    $mysqli->query("UPDATE message SET State = 'readed' WHERE MessageID = $message_id");

    //jump back to dashboard depends by user type
    switch ($_SESSION['session_user_type']) {
        case "client":
            header("Location: ../user_dashboard.php");
            die;
            break;
        case "host":
            header("Location: ../host_dashboard.php");
            die;
            break;
        case "manager":
            header("Location: ../manager_dashboard.php");
            die;
            break;
    }
}
