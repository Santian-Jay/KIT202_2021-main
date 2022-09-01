<?php
include 'connection.php';

//query database
$query = "SELECT CAST(AVG(review.ReviewRate) AS INT) AS averagerate, users.AverageRate AS useraveragerate, accommodation.* FROM review RIGHT JOIN accommodation ON review.AccommodationID = accommodation.AccommodationID INNER JOIN users ON accommodation.OwnerID = users.UserID WHERE State = 'awaiting' GROUP BY accommodationID ORDER BY accommodationID DESC";

$result = $mysqli->query($query);

while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
    $rows[] = $row;
}

$result_row = $rows;

//data return
echo json_encode(array("res"=>$result_row));
?>