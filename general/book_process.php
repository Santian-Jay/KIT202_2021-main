<?php
include 'session.php';
include 'connection.php';

    //use the largest id number plus one as new id number for this new bookingID
    $query = "SELECT MAX(BookingID) FROM booking";  
    $result = $mysqli->query($query);
    $row = mysqli_fetch_array($result);
    $booking_id = $row[0] + 1;

    //receive data transmitted from ajax
    $save_first_name = trim($_POST['first_name']);
    $save_last_name = trim($_POST['last_name']);
    $save_email = trim($_POST['email']);
    $save_phone_number = intval($_POST['phone']);
    $save_accommodationID = $_POST['accommodationID'];
    $save_user_id = $session_user_id;
    $save_state = "noread";
    $save_stage = "apply";
    $save_refusecomment = "";

    //consolidate data
    $save_string = $save_first_name. ", ". $save_last_name. ", ".$save_email.", ".$save_phone_number;

    ////query to store data collected from ajax into database
    $query = $mysqli->prepare(
        "INSERT INTO booking (BookingID, State, Stage, RefuseComment, Bookerinfo, SenderID, AccommodationID) VALUES
        (?, ?, ?, ?, ?, ?, ?)"
    );

    $query->bind_param("issssii", $booking_id, $save_state, $save_stage, $save_refusecomment, $save_string, $_SESSION['session_user_id'], $save_accommodationID);
    
    $query->execute();  //execute and receive the return value

    header("Location: ../index.php?result=add_succeeded");
    die;

    //echo json_encode(array("res"=>$a));  //data return

?>


