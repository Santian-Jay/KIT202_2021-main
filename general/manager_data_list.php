<?php
function print_manager_accommodation_list()
{
    require 'connection.php';

    //query all rows of accommodation
    $result = $mysqli->query("SELECT * FROM accommodation");

    //print all accommodation data from database
    while ($row = $result->fetch_array()) {
        echo '<tr>
                <form action="general/accomodation_process.php" method="post">
                    <input type="hidden" class="accommodation-profile-submit-value" name="action" value="" style="height: 0;">
                    <input type="hidden" class="accommodation-profile-submit-id" name="table_id" value="' . $row['AccommodationID'] . '" style="height: 0;">
                    <th><input type="submit" value="Save Change" onclick="submitButtonValue(this, \'edit\')" name="submit_form"></th>
                    <th><input type="submit" value="Delete" onclick="submitButtonValue(this, \'delete\')" name="submit_form"></th>
                    <th>' . $row['AccommodationID'] . '</th>
                    <th><input type="text" class="input-field" value="' . $row['AccommodationName'] . '" name="house_name"></th>
                    <th><input type="text" class="input-field" value="' . $row['Address'] . '" name="postage_address"></th>
                    <th><input type="text" class="input-field" value="' . $row['City'] . '" name="city"></th>
                    <th><input type="text" class="input-field" value="' . $row['Description'] . '" name="description"></th>
                    <th><input type="number" class="input-field" value="' . $row['Price'] . '" name="price"></th>
                    <th><input type="number" class="input-field" value="' . $row['BedroomNumber'] . '" name="bedroom_number"></th>
                    <th><input type="number" class="input-field" value="' . $row['BathroomNumber'] . '" name="bathroom_number"></th>
                    <th><input type="text" onfocus="(this.type=\'date\')" onblur="(this.type=\'text\')" value="' . $row['CheckInDate'] . '" name="check_in_date"></th>
                    <th><input type="text" onfocus="(this.type=\'date\')" onblur="(this.type=\'text\')" value="' . $row['CheckOutDate'] . '" name="check_out_date"></th>
                    <th>
                        <select name="garage_available">
                            <option value="' . $row['Garage'] . '" selected disabled>' . $row['Garage'] . ' (0: NO, 1: YES)</option>
                            <option value="yes">YES</option>
                            <option value="no">NO</option>
                        </select>
                    </th>
                    <th>
                        <select name="smoke_allowabillity">
                            <option value="' . $row['Smoking'] . '" selected disabled>' . $row['Smoking'] . ' (0: NO, 1: YES)</option>
                            <option value="yes">YES</option>
                            <option value="no">NO</option>
                        </select></th>
                    </th>
                    <th>
                        <select name="pet_allowabillity">
                            <option value="' . $row['Pet'] . '" selected disabled>' . $row['Pet'] . ' (0: NO, 1: YES)</option>
                            <option value="yes">YES</option>
                            <option value="no">NO</option>
                        </select>
                    </th>
                    <th>
                        <select name="internet_provision">
                            <option value="' . $row['Internet'] . '" selected disabled>' . $row['Internet'] . ' (0: NO, 1: YES)</option>
                            <option value="yes">YES</option>
                            <option value="no">NO</option>
                        </select></th>
                    </th>
                    <th><input type="number" class="input-field" value="' . $row['MaxAccommodate'] . '" name="max_accommodate"></th>
                    <th>
                        <select name="accommodation_state">
                            <option value="' . $row['State'] . '" selected disabled>' . $row['State'] . '</option>
                            <option value="awaiting">Awaiting</option>
                            <option value="onliving">Onliving</option>
                        </select></th>
                    </th>
                    <th><input type="text" class="input-field" value="' . $row['Photo'] . '" name="image_address"></th>
                    <th><input type="number" class="input-field" value="' . $row['OwnerID'] . '" name="owner_id"></th>
                    <th><input type="number" class="input-field" value="' . $row['StayerID'] . '" name="stayer_id"></th>
                </tr>
            </form>';
    }
}

function print_manager_booking_list()
{
    require 'connection.php';

    //query all rows of users
    $result = $mysqli->query("SELECT * FROM booking");

    //print all user data from database
    while ($row = $result->fetch_array()) {
        echo '<tr>
                <form action="general/booking_message_process.php" method="post">
                    <input type="hidden" class="accommodation-profile-submit-value" name="action" value="" style="height: 0;">
                    <input type="hidden" class="accommodation-profile-submit-id" name="booking_id" value="' . $row['BookingID'] . '" style="height: 0;">
                    <th><input type="submit" value="Save Change" onclick="submitButtonValue(this, \'edit\')" name="submit_form"></th>
                    <th><input type="submit" value="Cancel Booking" onclick="submitButtonValue(this, \'cancel\')" name="submit_form"></th>
                    <th>' . $row['BookingID'] . '</th>
                    <th>
                        <select name="state">
                            <option value="' . $row['State'] . '" selected disabled>' . $row['State'] . '</option>
                            <option value="readed">Readed</option>
                            <option value="noread">Noread</option>
                        </select></th>
                    </th>
                    <th>
                        <select name="stage">
                            <option value="' . $row['Stage'] . '" selected disabled>' . $row['Stage'] . '</option>
                            <option value="apply">Apply</option>
                            <option value="processed">Processed</option>
                            <option value="payment">Payment</option>
                            <option value="cancel">Cancel</option>
                            <option value="review">Review</option>
                            <option value="complete">Complete</option>
                        </select></th>
                    </th>
                    <th><input type="text" class="input-field" placeholder="NULL if not processed" value="' . $row['RefuseComment'] . '" name="refuse_comment"></th>
                    <th><input type="text" class="input-field" value="' . $row['BookerInfo'] . '" name="booker_info"></th>
                    <th>' . $row['SenderID'] . '</th>
                    <th><input type="number" class="input-field" value="' . $row['AccommodationID'] . '" name="accommodation_id"></th>
                </form>
            </tr>';
    }
}

function print_manager_user_list()
{
    require 'connection.php';

    //query all rows of users
    $result = $mysqli->query("SELECT * FROM users");

    //print all user data from database
    while ($row = $result->fetch_array()) {
        echo '<tr>
                <form action="general/account_process.php" method="post">
                    <input type="hidden" class="accommodation-profile-submit-value" name="action" value="" style="height: 0;">
                    <input type="hidden" class="accommodation-profile-submit-id" name="table_id" value="' . $row['UserID'] . '" style="height: 0;">
                    <th><input type="submit" value="Save Change" onclick="submitButtonValue(this, \'edit\')" name="submit_form"></th>
                    <th><input type="submit" value="Delete" onclick="submitButtonValue(this, \'delete\')" name="submit_form"></th>
                    <th>' . $row['UserID'] . '</th>
                    <th><input type="text" class="input-field" value="' . $row['FirstName'] . '" name="first_name"></th>
                    <th><input type="text" class="input-field" value="' . $row['LastName'] . '" name="last_name"></th>
                    <th><input type="text" class="input-field" value="' . $row['AccountName'] . '" name="account_name"></th>
                    <th><input type="text" class="input-field" value="' . $row['Email'] . '" name="email"></th>
                    <th><input type="text" class="input-field" placeholder="' . $row['Password'] . '" name="new_password"></th>
                    <th><input type="text" class="input-field" value="' . $row['Phone'] . '" name="phone"></th>
                    <th><input type="text" class="input-field" value="' . $row['Address'] . '" name="address"></th>
                    <th>
                        <select name="account_type">
                            <option value="' . $row['AccountType'] . '" selected disabled>' . $row['AccountType'] . '</option>
                            <option value="client">Client</option>
                            <option value="host">Host</option>
                            <option value="manager">Manager</option>
                        </select></th>
                    </th>
                    <th><input type="text" class="input-field" value="' . $row['ABN'] . '" name="abn"></th>
                    <th><input type="number" class="input-field" value="' . $row['TotalRate'] . '" name="total_rate"></th>
                    <th><input type="number" class="input-field" value="' . $row['RateNumber'] . '" name="rate_number"></th>
                    <th>' . $row['AverageRate'] . '</th>
                    <th>
                        <select name="account_state">
                            <option value="' . $row['AccountState'] . '" selected disabled>' . $row['AccountState'] . '</option>
                            <option value="inuse">inuse</option>
                            <option value="banned">Banned</option>
                        </select></th>
                    </th>
                </form>
            </tr>';
    }
}

function print_manager_message_list()
{
    require 'connection.php';

    //query all rows of message
    $result = $mysqli->query("SELECT * FROM message");

    //print all user data from database
    while ($row = $result->fetch_array()) {
        echo '<tr>
                <form action="general/message_process.php" method="post">
                    <input type="hidden" class="accommodation-profile-submit-value" name="action" value="" style="height: 0;">
                    <input type="hidden" class="accommodation-profile-submit-id" name="table_id" value="' . $row['MessageID'] . '" style="height: 0;">
                    <th><input type="submit" value="Save Change" onclick="submitButtonValue(this, \'edit\')" name="submit_form"></th>
                    <th>' . $row['MessageID'] . '</th>
                    <th>
                        <select name="state">
                            <option value="' . $row['State'] . '" selected disabled>' . $row['State'] . '</option>
                            <option value="readed">readed</option>
                            <option value="noread">noread</option>
                        </select></th>
                    </th>
                    <th><input type="text" class="input-field" value="' . $row['Content'] . '" name="content"></th>
                    <th>' . $row['SenderID'] . '</th>
                    <th><input type="number" class="input-field" value="' . $row['ReceiverID'] . '" name="receiver_id"></th>
                </form>
            </tr>';
    }
}

function print_manager_review_list()
{
    require 'connection.php';

    //query all rows of users
    $result = $mysqli->query("SELECT * FROM review");

    //print all review data from database
    while ($row = $result->fetch_array()) {
        echo '<tr>
                <form action="general/review_process.php" method="post">
                <input type="hidden" class="accommodation-profile-submit-value" name="action" value="" style="height: 0;">
                <input type="hidden" class="accommodation-profile-submit-id" name="table_id" value="' . $row['ReviewID'] . '" style="height: 0;">
                <th><input type="submit" value="Delete" onclick="submitButtonValue(this, \'delete\')" name="submit_form"></th>
                <th>' . $row['ReviewID'] . '</th>
                <th>
                    <select name="review_rate">
                        <option value="' . $row['ReviewRate'] . '" selected disabled>' . $row['ReviewRate'] . '</option>
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                    </select>
                </th>
                <th><input type="text" class="input-field" value="' . $row['ReviewComment'] . '" name="review_comment"></th>
                <th><input type="number" class="input-field" value="' . $row['AccommodationID'] . '" name="accommodation_id"></th>
                <th><input type="number" class="input-field" value="' . $row['ReviewerID'] . '" name="reviewer_id"></th>
                </form>
            </tr>';
    }
}

function totalAccommodation()
{
    require 'connection.php';

    //query number of accommodation in database
    $result = $mysqli->query("SELECT COUNT(*) FROM accommodation");
    $accommodation_number = $result->fetch_array();

    //print out the number of accommodation in database
    echo '<span class="summary-span">Total number of Accommodation is: ' . $accommodation_number[0] . '</span>';
}

function totalBooking()
{
    require 'connection.php';

    //query number of booking in database
    $result = $mysqli->query("SELECT COUNT(*) FROM booking");
    $booking_number = $result->fetch_array();

    //print out the number of booking in database
    echo '<span class="summary-span">Total number of Booking is: ' . $booking_number[0] . '</span>';
}

function totalUser()
{
    require 'connection.php';

    //query number of users in database
    $result = $mysqli->query("SELECT COUNT(*) FROM users");
    $user_number = $result->fetch_array();

    //print out the number of users in database
    echo '<span class="summary-span">Total number of User is: ' . $user_number[0] . '</span>';
}

function totalMessage()
{
    require 'connection.php';

    //query number of message in database
    $result = $mysqli->query("SELECT COUNT(*) FROM message");
    $message_number = $result->fetch_array();

    //print out the number of message in database
    echo '<span class="summary-span">Total number of Messages is: ' . $message_number[0] . '</span>';
}

function totalReview()
{
    require 'connection.php';

    //query number of review in database
    $result = $mysqli->query("SELECT COUNT(*) FROM review");
    $review_number = $result->fetch_array();

    //print out the number of review in database
    echo '<span class="summary-span">Total number of Reviews is: ' . $review_number[0] . '</span>';
}
