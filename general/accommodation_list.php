<?php
include 'connection.php';

//get the value sent by AJAX
$check_in = $_POST['check_in'];
$check_out = $_POST['check_out'];
$destination_city = trim($_POST['destination_city']);
$number_guests = $_POST['number_guests'] == "Any" ? 0 : $_POST['number_guests'];

//query database
$query = $mysqli->prepare("SELECT
							CAST(AVG(review.ReviewRate) AS INT) AS averagerate,
							users.AverageRate AS useraveragerate,
							accommodation.*
							FROM
							review
							RIGHT JOIN accommodation ON review.AccommodationID = accommodation.AccommodationID
							INNER JOIN users ON accommodation.OwnerID = users.UserID
							WHERE
							City = ? AND MaxAccommodate >= ? AND CheckInDate <= ? AND CheckOutDate >= ? AND State = 'awaiting'
							GROUP BY
							accommodationID
							ORDER BY
							accommodationID
							DESC");
$query -> bind_param('siss', $destination_city, $number_guests, $check_in, $check_out);
$query-> execute();
$result = $query->get_result();


//read all data and save
while($row = $result->fetch_assoc())
{
	$rows[] = $row;
}
	$result_row = $rows;

//return AJAX data
	echo json_encode(array("res"=>$result_row));

?>
