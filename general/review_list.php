<?php
function print_my_review()
{
    require 'connection.php';

    $userID = intval($_SESSION['session_user_id']);

    //query for reviews published by current user
    $result = $mysqli->query("SELECT review.*, accommodation.Address FROM review
                            INNER JOIN accommodation ON review.AccommodationID=accommodation.AccommodationID
                            WHERE ReviewerID = $userID");

    //print all rows from query result
    while ($row = $result->fetch_array()) {
        //create rate string
        $rate = "";
        for ($i = 0; $i < intval($row['ReviewRate']); $i++) {
            $rate = $rate . "★";
        }

        echo '<div class="my-reviews-overview-item-container">
                <!--the address of the accommodation-->
                <div class="review-accommodation-address-container dashboard-reviews">
                    <span>My review for </span>
                    <span><b>"' . $row['Address'] . '"</b></span>
                </div>
                <!--the review content of the accommodation-->
                <div class="review-content-container dashboard-reviews">
                    <textarea rows="8" onchange="refresh_review_comment(this, ' . $row['ReviewID'] . ');">' . $row['ReviewComment'] . '</textarea>
                </div>
                <!--the rate of the accommodation-->
                <div class="review-rate-container dashboard-reviews">
                    <span>Room Rate:</span>
                    <span><b>' . $rate . '</b></span>
                </div>
                <!--operation buttons to change this review-->
                <form class="operation-button-group-container" action="general/review_process.php" method="post">
                    <input type="hidden" class="submit-value" name="action" value="" style="height: 0;">
                    <input type="hidden" class="submit-id" name="table_id" value="' . $row['ReviewID'] . '" style="height: 0;">
                    <input type="hidden" id="review_comment' . $row['ReviewID'] . '" name="review_comment" value="" style="height: 0;">
                    <button class="btn btn-outline-primary review-save-button" onclick="submitButtonValue(this, \'edit\')" name="submit_form"><b>Save</b></button>
                    <button class="btn btn-outline-primary review-delete-button" onclick="submitButtonValue(this, \'delete\')" name="submit_form"><b>Delete</b></button>
                </form>
            </div>';
    }
}
