<?php
include 'session.php';

if (!isset($_REQUEST['submit_form'])) {
    return;
} else {
    //depends the action field data to determine function to go
    switch ($_REQUEST['action']) {
        case "delete":
            delete();
            break;
        case "edit":
            edit();
            break;
    }
}

function delete()
{
    require_once 'connection.php';

    //get the review id that need to modify
    $review_id = intval($_POST['table_id']);

    //query to delete the row with that accommodation id
    $query = $mysqli->prepare("DELETE FROM review WHERE ReviewID = ?;");
    $query->bind_param('i', $review_id);
    $query->execute();

    //jump back to dashboard and show succeeded message depends user type
    switch ($_SESSION['session_user_type']) {
        case "client":
            header("Location: ../user_dashboard.php?result=review_update_succeeded");
            die;
            break;
        case "host":
            header("Location: ../host_dashboard.php?result=delete_succeeded");
            die;
            break;
        case "manager":
            header("Location: ../manager_dashboard.php?result=review_delete_succeeded");
            die;
            break;
    }
}

function edit()
{
    require_once 'connection.php';

    //get the review id that need to modify
    $review_id = intval($_POST['table_id']);

    //query the selected review by id to modify
    $query = $mysqli->prepare("SELECT * FROM review WHERE ReviewID = ?");
    $query->bind_param('i', $review_id);
    $query->execute();
    $row = $query->get_result()->fetch_array(MYSQLI_NUM);

    //data from submitted form, form to a new array depends if the data is exist
    $form = array(
        $row[0],
        !empty($_POST['review_rate']) ? intval($_POST['review_rate']) : $row[1],
        !empty($_POST['review_comment']) ? trim($_POST['review_comment']) : $row[2],
        !empty($_POST['accommodation_id']) ? intval($_POST['accommodation_id']) : $row[3],
        $row[4]
    );

    //query to update data collected from submitted form into database
    $query =  $mysqli->prepare("UPDATE review SET
        ReviewRate = ?,
        ReviewComment = ?,
        AccommodationID = ?
        WHERE ReviewID = ?"
    );
    $query->bind_param('isii', $form[1], $form[2], $form[3], $review_id);
    $query->execute();

    //jump back to dashboard and show succeeded message depends user type
    switch ($_SESSION['session_user_type']) {
        case "client":
            header("Location: ../user_dashboard.php?result=review_update_succeeded");
            die;
            break;
        case "host":
            header("Location: ../host_dashboard.php?result=review_update_succeeded");
            die;
            break;
        case "manager":
            header("Location: ../manager_dashboard.php?result=review_update_succeeded");
            die;
            break;
    }
}
