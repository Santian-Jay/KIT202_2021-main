<?php
include "connection.php";

//get the value sent by AJAX
$accommodation_ID = intval($_POST['accommodation_ID']);

//query database
$query = $mysqli->prepare("SELECT review.*, users.Email FROM review INNER JOIN users ON review.ReviewerID=users.UserID WHERE review.AccommodationID = ?");
$query -> bind_param('i', $accommodation_ID);
$query-> execute();
$result = $query->get_result();


//read all data and save
while($row = $result->fetch_assoc())
{
	$rearray[] = $row;
}

$a = $rearray;

//return AJAX data
echo json_encode(array("res"=>$a)); 
?>