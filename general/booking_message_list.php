<?php
function print_booking_message()
{
    //load different type of booking message for different type of user
    switch ($_SESSION['session_user_type']) {
        case "client":
            client_booking_message();
            break;
        case "host":
            host_booking_message();
            break;
    }
}

function client_booking_message()
{
    require 'connection.php';
    $userID = $_SESSION['session_user_id'];

    //query for 'processed', 'payment' and 'review' type of booking message for client user
    $result = $mysqli->query(
        "SELECT booking.*, accommodation.OwnerID, accommodation.Address, users.Email FROM booking
                            INNER JOIN accommodation ON booking.AccommodationID=accommodation.AccommodationID
                            INNER JOIN users ON booking.SenderID=users.UserID
                            WHERE booking.SenderID = $userID
                            AND booking.Stage = 'processed'
                            OR booking.Stage = 'payment'
                            OR booking.Stage = 'review'"
    );

    //print all rows from query result
    while ($row = $result->fetch_array()) {
        //only show the message were not readed
        if ($row['State'] == "noread") {
            switch ($row['Stage']) {
                case "processed":
                    echo '<div class="message-inbox-overview-item-container">
                            <!--message type-->
                            <div class="accommodation-denied-message dashboard-inbox-message">
                                <!--heading of the message-->
                                <div class="message-heading-container">
                                    <span>One of your booking request has been denied.</span>
                                </div>
                                <!--content of the message-->
                                <div class="message-content-container">
                                    <span>Unfortunately, your booking request for the accommodation</span>
                                    <span><b>"' . $row['Address'] . '"</b></span>
                                    <span>has been dnied by the host.</span>
                                    <br>
                                    <br>
                                    <!--span>There are no reason commented by the host.</span-->
                                    <span>The reason commented by the host is:</span>
                                    <br>
                                    <span><b>"' . $row['RefuseComment'] . '"</b></span>
                                </div>
                                <form action="general/booking_message_process.php" method="post">
                                    <input type="hidden" name="action" value="hide" style="height: 0;">
                                    <input type="hidden" name="booking_id" value="' . $row['BookingID'] . '" style="height: 0;">
                                    <button class="btn btn-outline-primary message-button" name="submit_form"><b>Delete</b></button>
                                </form>
                            </div>
                        </div>';
                    break;
                case "payment":
                    echo '<div class="message-inbox-overview-item-container">
                            <!--message type-->
                            <div class="accommodation-accepted-message dashboard-inbox-message">
                                <!--heading of the message-->
                                <div class="message-heading-container">
                                    <span>One of your booking request has been accepted!</span>
                                </div>
                                <!--content of the message-->
                                <div class="message-content-container">
                                    <span>Congratulations! Your booking request for the accommodation</span>
                                    <span><b>"' . $row['Address'] . '"</b></span>
                                    <span>has been accepted by the host!</span>
                                </div>
                            </div>
                            <form action="general/booking_message_process.php" method="post">
                                <input type="hidden" name="action" value="payment" style="height: 0;">
                                <input type="hidden" name="booking_id" value="' . $row['BookingID'] . '" style="height: 0;">
                                <button class="btn btn-outline-primary message-button" name="submit_form"><b>Confirmed and Pay</b></button>
                            </form>
                            <form action="general/booking_message_process.php" method="post">
                                <input type="hidden" name="action" value="cancel" style="height: 0;">
                                <input type="hidden" name="booking_id" value="' . $row['BookingID'] . '" style="height: 0;">
                                <button class="btn btn-outline-primary message-button" name="submit_form"><b>Cancel Application</b></button>
                            </form>
                        </div>';
                    break;
                case "review":
                    echo '<div class="message-inbox-overview-item-container">
                            <!--message type-->
                            <div class="accommodation-review-message dashboard-inbox-message">
                                <!--heading of the message-->
                                <div class="message-heading-container">
                                    <span>Thank you for your stay! Please rate the accommodation!</span>
                                </div>
                                <!--content of the message-->
                                <div class="message-content-container">
                                    <span>Thank you for living at our accommodation of</span>
                                    <span><b>"' . $row['Address'] . '"</b>,</span>
                                    <span>your feedback is important for us. Please rate us and leave a comment for our further
                                        improvement! Thank you!</span>
                                    <br>
                                    <br>
                                    <span>Room Rate:</span>
                                    <!--select accommodation rate-->
                                    <select id="accommodation-review-rate" class="review-rate-field" onchange="refresh_review_rate(this, ' . $row['BookingID'] . ');">
                                        <option value="5" selected>5 Star&nbsp<b>★★★★★</b></option>
                                        <option value="4">4 Star&nbsp<b>★★★★☆</b></option>
                                        <option value="3">3 Star&nbsp<b>★★★☆☆</b></option>
                                        <option value="2">2 Star&nbsp<b>★★☆☆☆</b></option>
                                        <option value="1">1 Star&nbsp<b>★☆☆☆☆</b></option>
                                    </select>
                                    <br>
                                    <span>Host Rate:</span>
                                    <!--select host rate-->
                                    <select id="accommodation-review-rate" class="review-rate-field" onchange="refresh_host_rate(this, ' . $row['BookingID'] . ');">
                                        <option value="5" selected>5 Star&nbsp<b>★★★★★</b></option>
                                        <option value="4">4 Star&nbsp<b>★★★★☆</b></option>
                                        <option value="3">3 Star&nbsp<b>★★★☆☆</b></option>
                                        <option value="2">2 Star&nbsp<b>★★☆☆☆</b></option>
                                        <option value="1">1 Star&nbsp<b>★☆☆☆☆</b></option>
                                    </select>
                                    <br>
                                    <span>Comment:</span>
                                    <br>
                                    <textarea cols="62" rows="6" onchange="refresh_review_comment(this, ' . $row['BookingID'] . ');"></textarea>
                                </div>
                                <!--publish review button-->
                                <form action="general/booking_message_process.php" method="post">
                                    <input type="hidden" name="action" value="review" style="height: 0;">
                                    <input type="hidden" name="booking_id" value="' . $row['BookingID'] . '" style="height: 0;">
                                    <input type="hidden" id="review_comment' . $row['BookingID'] . '" name="review_comment" value="" style="height: 0;">
                                    <input type="hidden" id="review_rate' . $row['BookingID'] . '" name="review_rate" value="" style="height: 0;">
                                    <input type="hidden" id="host_rate' . $row['BookingID'] . '" name="host_rate" value="" style="height: 0;">
                                    <button class="btn btn-outline-primary message-button" name="submit_form"><b>Publish Review</b></button>
                                </form>
                            </div>
                        </div>';
                    break;
            }
        }
    }
}

function host_booking_message()
{
    require 'connection.php';
    $userID = $_SESSION['session_user_id'];

    //query for 'apply' and 'cancel' type of booking message for host user
    $result = $mysqli->query(
        "SELECT booking.*, accommodation.OwnerID, accommodation.Address, users.Email FROM booking
                            INNER JOIN accommodation ON booking.AccommodationID=accommodation.AccommodationID
                            INNER JOIN users ON booking.SenderID=users.UserID
                            WHERE accommodation.OwnerID = $userID
                            AND booking.Stage = 'apply'
                            OR booking.Stage = 'cancel'"
    );

    //print all rows from query result
    while ($row = $result->fetch_array()) {
        //only show the message were not readed
        if ($row['State'] == "noread") {
            switch ($row['Stage']) {
                case "apply":
                    echo '<div class="message-inbox-overview-item-container">
                            <!--message type-->
                            <div class="accommodation-request-message dashboard-inbox-message">
                                <!--heading of the message-->
                                <div class="message-heading-container">
                                    <span>You have received an accommodation booking request!</span>
                                </div>
                                <!--content of the message-->
                                <div class="message-content-container">
                                    <span>Your published accommodation</span>
                                    <span><b>"' . $row['Address'] . '"</b></span>
                                    <span>has received a booking request by user</span>
                                    <span><b>"' . $row['Email'] . '"</b>.</span><br><br>
                                    <span>The user information are below:</span><br>
                                    <span><b>"' . $row['BookerInfo'] . '"</b></span>
                                </div>
                                <!--buttons for accept or denie booking request-->
                                <div class="message-button-group">
                                    <form action="general/booking_message_process.php" method="post">
                                        <input type="hidden" name="action" value="accept" style="height: 0;">
                                        <input type="hidden" name="booking_id" value="' . $row['BookingID'] . '" style="height: 0;">
                                        <button class="btn btn-outline-primary" id="message-booking-accept-button" name="submit_form"><b>Accept the Request</b></button>
                                    </form>
                                    <button type="button" class="btn btn-outline-primary" id="message-booking-denie-button" data-toggle="modal" data-target="#message-booking-denie-modal' . $row['BookingID'] . '"><b>Denie the Request</b>
                                    </button>
                                </div>
                                <!--modal section for denie booking request button-->
                                <div class="modal fade" id="message-booking-denie-modal' . $row['BookingID'] . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Denie Reason Message</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="modal-denie-group">
                                                    <textarea cols="64" rows="6" onchange="refresh_denie_message(this, ' . $row['BookingID'] . ');"></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <form action="general/booking_message_process.php" method="post">
                                                    <input type="hidden" name="action" value="denie" style="height: 0;">
                                                    <input type="hidden" name="booking_id" value="' . $row['BookingID'] . '" style="height: 0;">
                                                    <input type="hidden" id="denie_message' . $row['BookingID'] . '" name="denie_message" value="" style="height: 0;">
                                                    <button class="btn btn-primary" name="submit_form">Send</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';
                    break;
                case "cancel":
                    echo '<div class="message-inbox-overview-item-container">
                            <!--message type-->
                            <div class="accommodation-cancel-message dashboard-inbox-message">
                                <!--heading of the message-->
                                <div class="message-heading-container">
                                    <span>One of the application has been canceled.</span>
                                </div>
                                <!--content of the message-->
                                <div class="message-content-container">
                                    <span>An application of accommodation </span>
                                    <span><b>"' . $row['Address'] . '"</b></span>
                                    <span> has been canceled by </span>
                                    <span><b>"' . $row['Email'] . '"</b>.</span>
                                </div>
                                <form action="general/booking_message_process.php" method="post">
                                    <input type="hidden" name="action" value="hide" style="height: 0;">
                                    <input type="hidden" name="booking_id" value="' . $row['BookingID'] . '" style="height: 0;">
                                    <button class="btn btn-outline-primary message-button" name="submit_form"><b>Delete</b></button>
                                </form>
                            </div>
                        </div>';
                    break;
            }
        }
    }
}

function print_application()
{
    require 'connection.php';
    $userID = $_SESSION['session_user_id'];

    //query for 'apply' and 'payment' type of booking message for client user
    $result = $mysqli->query(
        "SELECT booking.*, accommodation.*, users.Email FROM booking
                            INNER JOIN accommodation ON booking.AccommodationID=accommodation.AccommodationID
                            INNER JOIN users ON booking.SenderID=users.UserID
                            WHERE booking.SenderID = $userID
                            AND booking.Stage = 'apply'
                            OR booking.Stage = 'payment'"
    );

    //print all rows from query result
    while ($row = $result->fetch_array()) {

        $total_rate = 0;
        $rate = "";
        $accommodation_id = $row['AccommodationID'];

        //query the total rate of the accommodation
        $rate_value_result = $mysqli->query("SELECT * FROM review WHERE AccommodationID = $accommodation_id");
        while ($review = $rate_value_result->fetch_array()) {
            $total_rate += $review['ReviewRate'];
        }

        //query number of rate have of the accommodation
        $number_of_rate_result = $mysqli->query("SELECT COUNT(*) FROM review WHERE AccommodationID = $accommodation_id");
        $number_of_rate = $number_of_rate_result->fetch_array();

        //only if there are atleast one review rate
        if ($total_rate != 0 && $number_of_rate != 0) {
            //create the room rate string
            $rate_value = ceil($total_rate / $number_of_rate[0]);
            for ($i = 0; $i < $rate_value; $i++) {
                $rate = $rate . "★";
            }
        }

        //query for the average host rate by accommodation ID
        $host_rate_query = "SELECT accommodation.OwnerID, users.* FROM accommodation
                    INNER JOIN users ON accommodation.OwnerID=users.UserID
                    WHERE accommodation.accommodationID = $accommodation_id";
        $host_rate_result = $mysqli->query($host_rate_query);
        $host_rate_row = mysqli_fetch_array($host_rate_result);
        $host_rate_value = intval($host_rate_row['AverageRate']);

        //create the host rate string
        $host_rate = "";
        for ($j = 0; $j < $host_rate_value; $j++) {
            $host_rate = $host_rate . "★";
        }

        $garage = $row['Garage'] == 1 ? "YES" : "NO";
        $smoking = $row['Smoking'] == 1 ? "YES" : "NO";
        $pet = $row['Pet'] == 1 ? "YES" : "NO";
        $internet = $row['Internet'] == 1 ? "YES" : "NO";

        echo '<!--accommodation list display section-->
                <div class="accommodation-overview-item-container">
                    <!--picture of the accommodation-->
                    <div class="accommodation-picture-container">

                    </div>
                    <!--description and imformation about the accommodation-->
                    <div class="accommodation-description-container">
                        <!--LINE 1, price and host rate-->
                        <div class="accommodation-description-line-container">
                            <span class="accommodation-price"><b>$' . $row['Price'] . ' per week</b></span>
                            <div class="accommodation-host-rate">
                                <span>Host Rate:&nbsp</span>
                                <span><b>' . $host_rate . '</b></span>
                            </div>
                        </div>
                        <!--LINE 2, bedroom, bathroom and garage number-->
                        <div class="accommodation-description-line-container">
                            <div class="accommodation-number-of-room-container">
                                <div class="number-of-room">
                                    <span>Bedroom:&nbsp</span>
                                    <span>' . $row['BedroomNumber'] . '</span>
                                </div>
                                <div class="number-of-room">
                                    <span>Bathroom:&nbsp</span>
                                    <span>' . $row['BathroomNumber'] . '</span>
                                </div>
                                <div class="number-of-room">
                                    <span>Garage:&nbsp</span>
                                    <span><b>' . $garage . '</b></span>
                                </div>
                            </div>
                        </div>
                        <!--LINE 3, room rate and see review button-->
                        <div class="accommodation-description-line-container">
                            <div class="accommodation-room-rate">
                                <span>Room Rate:&nbsp</span>
                                <span><b>' . $rate . '</b></span>
                            </div>
                        </div>
                        <!--LINE 4, address of the accommodation-->
                        <div class="accommodation-description-line-container">
                            <div class="accommodation-address">
                                <span>' . $row['Address'] . '</span>
                            </div>
                        </div>
                        <!--LINE 5, smoke allowbility of the accommodation-->
                        <div class="accommodation-description-line-container">
                            <div class="accommodation-smoke">
                                <span>Smoke allowability:&nbsp</span>
                                <span><b>' . $smoking . '</b></span>
                            </div>
                        </div>
                        <!--LINE 6, newtwork provision of the accommodation-->
                        <div class="accommodation-description-line-container">
                            <div class="accommodation-network">
                                <span>Network provision:&nbsp</span>
                                <span><b>' . $internet . '</b></span>
                            </div>
                        </div>
                        <!--LINE 7, pre allowability of the accommodation-->
                        <div class="accommodation-description-line-container">
                            <div class="accommodation-pet">
                                <span>Pet allowability:&nbsp</span>
                                <span><b>' . $pet . '</b></span>
                            </div>
                        </div>
                        <!--LINE 8, booking request button-->
                        <form class="accommodation-booking-button-container" action="general/booking_message_process.php" method="post">
                            <input type="hidden" class="submit-value" name="action" value="" style="height: 0;">
                            <input type="hidden" class="submit-id" name="booking_id" value="' . $row['BookingID'] . '" style="height: 0;">
                            <button class="btn btn-outline-primary submit-button" onclick="submitButtonValue(this, \'cancel\')" name="submit_form">Cancel Booking</button>
                        </form>
                    </div>
                </div>';
    }
}
