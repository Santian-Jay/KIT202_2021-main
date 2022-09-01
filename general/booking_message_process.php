<?php
include 'session.php';

if (!isset($_REQUEST['submit_form'])) {
    return;
} else {

    var_dump($_REQUEST);

    //depends the action field data to determine function to go
    switch ($_REQUEST['action']) {
        case "denie":
            //when host denie an application
            booking_denie();
            break;
        case "accept":
            //when host accept an application
            booking_accept();
            break;
        case "payment":
            //when client confirm and pay an accommodation
            booking_payment();
            break;
        case "cancel":
            //when client like to cancel an accommodation
            booking_cancel();
            break;
        case "review":
            //when client paid and successful booked an accommodation
            booking_review();
            break;
        case "hide":
            //when user like to hide and make a booking message to readed
            hide_message();
            break;
        case "edit":
            //when manager like to edit booking info
            edit_message();
            break;
    }
}

function booking_denie()
{
    require_once 'connection.php';

    $booking_id = intval($_POST['booking_id']);
    $denie_comment = trim($_POST['denie_message']);

    //query to store denie comment and update booking stage to database
    $query = $mysqli->prepare("UPDATE booking SET Stage = 'processed', RefuseComment = ? WHERE BookingID = $booking_id");
    $query->bind_param('s', $denie_comment);
    $query->execute();

    //jump back to dashboard
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

function booking_accept()
{
    require_once 'connection.php';

    $booking_id = intval($_POST['booking_id']);

    //query to update booking stage to database
    $mysqli->query("UPDATE booking SET Stage = 'payment' WHERE BookingID = $booking_id");

    //query for the submitted booking message's accommodation ID
    $query = "SELECT * FROM booking WHERE BookingID = $booking_id";
    $result = $mysqli->query($query);
    $row = mysqli_fetch_array($result);
    $accommodation_id = $row['AccommodationID'];

    //stop show accommodation to the list, query to update accommodation stage to database
    $mysqli->query("UPDATE accommodation SET Stage = 'onholding' WHERE AccommodationID = $accommodation_id");

    //jump back to dashboard
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

function booking_payment()
{
    require_once 'connection.php';

    $booking_id = intval($_POST['booking_id']);
    $stayer_id = intval($_SESSION['session_user']);

    //query to update booking stage to database
    $mysqli->query("UPDATE booking SET Stage = 'review' WHERE BookingID = $booking_id");

    //query for the submitted booking message's accommodation ID
    $query = "SELECT * FROM booking WHERE BookingID = $booking_id";
    $result = $mysqli->query($query);
    $row = mysqli_fetch_array($result);
    $accommodation_id = $row['AccommodationID'];

    //stop show accommodation to the list, query to update accommodation stage to database
    $mysqli->query("UPDATE accommodation SET State = 'onliving' WHERE AccommodationID = $accommodation_id");

    //stop show accommodation to the list, query to update accommodation stage to database
    $mysqli->query("UPDATE accommodation SET StayerID = $stayer_id WHERE AccommodationID = $accommodation_id");

    //jump back to dashboard
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

function booking_cancel()
{
    require_once 'connection.php';

    $booking_id = intval($_POST['booking_id']);

    //query to update booking stage to database
    $mysqli->query("UPDATE booking SET Stage = 'cancel' WHERE BookingID = $booking_id");

    //show back accommodation to the list, query to update accommodation stage to database
    $mysqli->query("UPDATE accommodation SET State = 'awaiting' WHERE AccommodationID = $accommodation_id");

    //jump back to dashboard
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

function booking_review()
{
    require_once 'connection.php';

    $default_comment = "The host did not leave a comment.";
    $booking_id = intval($_POST['booking_id']);
    $reviewer_id = intval($_SESSION['session_user_id']);
    $review_comment = !empty($_POST['review_comment']) ? trim($_POST['review_comment']) : $default_comment;
    $review_rate = intval($_POST['review_rate']);

    $host_rate = intval($_POST['host_rate']);

    //query for the submitted booking message's accommodation ID
    $query = "SELECT * FROM booking WHERE BookingID = $booking_id";
    $result = $mysqli->query($query);
    $row = mysqli_fetch_array($result);
    $accommodation_id = intval($row['AccommodationID']);

    //query to update booking stage to database
    $mysqli->query("UPDATE booking SET Stage = 'complete' WHERE BookingID = $booking_id");

    //use the largest id number plus one as new id number for this new review
    $query = "SELECT MAX(ReviewID) FROM review";
    $result = $mysqli->query($query);
    $row = mysqli_fetch_array($result);
    $review_id = $row[0] + 1;

    //create a new review and query to store in database
    $query = $mysqli->prepare("INSERT INTO review (ReviewID, ReviewRate, ReviewComment, AccommodationID, ReviewerID)
                                VALUES (?, ?, ?, ?, ?)");
    $query->bind_param('iisii', $review_id, $review_rate, $review_comment, $accommodation_id, $reviewer_id);
    $query->execute();

    //query to add rate for the host
    $query = "SELECT booking.*, accommodation.OwnerID, users.* FROM booking
                INNER JOIN accommodation ON booking.AccommodationID=accommodation.AccommodationID
                Inner JOIN users ON accommodation.OwnerID=users.UserID
                WHERE booking.AccommodationID = $accommodation_id";

    $result = $mysqli->query($query);
    $row = mysqli_fetch_array($result);
    $total_rate = $row['TotalRate'] + $host_rate;
    $rate_number = $row['RateNumber'] + 1;
    $average_rate = intval(ceil($total_rate / $rate_number));

    $owner_id = intval($row['UserID']);

    //query to update owner of the accommodation rate
    $query = $mysqli->prepare("UPDATE users SET
                                TotalRate = ?,
                                RateNumber = ?,
                                AverageRate = ? 
                                WHERE UserID = $owner_id");
    $query->bind_param('iii', $total_rate, $rate_number, $average_rate);
    $query->execute();

    //jump back to dashboard
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

function hide_message()
{
    require_once 'connection.php';

    $booking_id = intval($_POST['booking_id']);

    //query to update booking stage to database
    $mysqli->query("UPDATE booking SET State = 'readed' WHERE BookingID = $booking_id");

    //jump back to dashboard
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

function edit_message()
{
    require_once 'connection.php';

    //get the booking message id that need to modify
    $booking_id = intval($_POST['booking_id']);

    //query the selected booking message by id to modify
    $query = $mysqli->prepare("SELECT * FROM booking WHERE BookingID = ?");
    $query->bind_param('i', $booking_id);
    $query->execute();
    $row = $query->get_result()->fetch_array(MYSQLI_NUM);

    //data from submitted form, form to a new array depends if the data is exist
    $form = array(
        $row[0],
        !empty($_POST['state']) ? $_POST['state'] : $row[1],
        !empty($_POST['stage']) ? $_POST['stage'] : $row[2],
        !empty($_POST['refuse_comment']) ? trim($_POST['refuse_comment']) : $row[3],
        !empty($_POST['booker_info']) ? trim($_POST['booker_info']) : $row[4],
        $row[5],
        !empty($_POST['accommodation_id']) ? intval($_POST['accommodation_id']) : $row[6]
    );

    //query to update data collected from submitted form into database
    $query =  $mysqli->prepare(
        "UPDATE booking SET
        State = ?,
        Stage = ?,
        RefuseComment = ?,
        BookerInfo = ?,
        AccommodationID = ?
        WHERE BookingID = ?"
    );
    $query->bind_param('ssssii', $form[1], $form[2], $form[3], $form[4], $form[6], $booking_id);
    $query->execute();

    //jump back to dashboard and show succeeded message depends user type
    switch ($_SESSION['session_user_type']) {
        case "client":
            header("Location: ../user_dashboard.php?result=booking_message_update_succeeded");
            die;
            break;
        case "host":
            header("Location: ../host_dashboard.php?result=booking_message_update_succeeded");
            die;
            break;
        case "manager":
            header("Location: ../manager_dashboard.php?result=booking_message_update_succeeded");
            die;
            break;
    }
}
