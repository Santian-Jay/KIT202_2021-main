<?php
require 'general/header.php';
require 'general/manager_data_list.php';
require 'general/message_list.php';
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="css/manager_dashboard.css">
    <title>Dashboard</title>
</head>

<body>
    <div class="top-bar">
        <div class="top-bar-container">
            <!--webside name header-->
            <?php general_header(); ?>
        </div>
    </div>
    <div class="content">
        <div class="content-container">
            <div class="side-bar-container">
                <!-- side bar normal item -->
                <div class="side-bar-standard-item-container" style="height: 0px;">

                    <!-- reserved -->

                </div>
                <!-- side bar sticky item -->
                <div class="side-bar-sticky-item-container">
                    <div class="side-bar-item-container">
                        <!--accommodation list section radio button-->
                        <label class="dashboard-side-bar-radio active">
                            <input type="radio" class="dashboard-side-bar-radio-button" name="dashboard-side-bar-radio-button" onclick="houseList()" checked>House List
                        </label>
                    </div>
                    <div class="side-bar-item-container">
                        <!--booking list section radio button-->
                        <label class="dashboard-side-bar-radio">
                            <input type="radio" class="dashboard-side-bar-radio-button" name="dashboard-side-bar-radio-button" onclick="bookingList()">Booking List
                        </label>
                    </div>
                    <div class="side-bar-item-container">
                        <!--review list section radio button-->
                        <label class="dashboard-side-bar-radio">
                            <input type="radio" class="dashboard-side-bar-radio-button" name="dashboard-side-bar-radio-button" onclick="reviewList()">Review List
                    </div>
                    <div class="side-bar-item-container">
                        <!--review list section radio button-->
                        <label class="dashboard-side-bar-radio">
                            <input type="radio" class="dashboard-side-bar-radio-button" name="dashboard-side-bar-radio-button" onclick="inboxList()">Inbox List
                    </div>
                    <div class="side-bar-item-container">
                        <!--review list section radio button-->
                        <label class="dashboard-side-bar-radio">
                            <input type="radio" class="dashboard-side-bar-radio-button" name="dashboard-side-bar-radio-button" onclick="userList()">User List
                    </div>
                </div>
            </div>
            <div class="main-content-container">
                <!-- main content -->
                <div class="main-item-container" id="house-list-item-container">
                    <table class="horizontal-scroll-wrapper data-table">
                        <?php totalAccommodation() ?>
                        <?php
                        if (!empty($_GET['result'])) {
                            switch ($_GET['result']) {
                                case "accommodation_update_succeeded":
                                    echo "<br><span class='profile-span error-message'><b>Accommodation profile update successful!</b></span>";
                                    break;
                                case "accommodation_delete_succeeded":
                                    echo "<br><span class='profile-span error-message'><b>Accommodation profile delete successful.</b></span>";
                                    break;
                            }
                        }
                        ?>
                        <tr class="table-title">
                            <th>Edit</th>
                            <th>Delete</th>
                            <th>AccommodationID</th>
                            <th>AccommodationName</th>
                            <th>Address</th>
                            <th>City</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>BedroomNumber</th>
                            <th>BathroomNumber</th>
                            <th>CheckInDate</th>
                            <th>CheckOutDate</th>
                            <th>Garage</th>
                            <th>Smoking</th>
                            <th>Pet</th>
                            <th>Internet</th>
                            <th>MaxAccommodate</th>
                            <th>State</th>
                            <th>Photo</th>
                            <th>OwnerID</th>
                            <th>StayerID</th>
                        </tr>
                        <?php print_manager_accommodation_list() ?>
                    </table>
                </div>

                <div class="main-item-container" id="booking-list-item-container">
                    <table class="horizontal-scroll-wrapper data-table">
                        <?php totalBooking() ?>
                        <?php
                        if (!empty($_GET['result'])) {
                            switch ($_GET['result']) {
                                case "booking_message_update_succeeded":
                                    echo "<br><span class='profile-span error-message'><b>Booking message update successful.</b></span>";
                                    break;
                            }
                        }
                        ?>
                        <tr class="table-title">
                            <th>Save Change</th>
                            <th>Cancel</th>
                            <th>BookingID</th>
                            <th>State</th>
                            <th>Stage</th>
                            <th>RefuseComment</th>
                            <th>BookerInfo</th>
                            <th>SenderID</th>
                            <th>AccommodationID</th>
                        </tr>
                        <?php print_manager_booking_list() ?>
                    </table>
                </div>

                <div class="main-item-container" id="review-list-item-container">
                    <table class="horizontal-scroll-wrapper data-table">
                        <?php totalReview() ?>
                        <?php
                        if (!empty($_GET['result'])) {
                            switch ($_GET['result']) {
                                case "review_delete_succeeded":
                                    echo "<br><span class='profile-span error-message'><b>Review delete successful.</b></span>";
                                    break;
                            }
                        }
                        ?>
                        <tr>
                            <th>Delete</th>
                            <th>ReviewID</th>
                            <th>ReviewRate</th>
                            <th>ReviewComment</th>
                            <th>AccommodationID</th>
                            <th>ReviewerID</th>
                        </tr>
                        <?php print_manager_review_list() ?>
                    </table>
                </div>

                <div class="main-item-container" id="inbox-list-item-container">
                    <?php print_message_list() ?>
                    <?php totalMessage() ?>
                    <table class="horizontal-scroll-wrapper data-table">
                        <?php
                        if (!empty($_GET['result'])) {
                            switch ($_GET['result']) {
                                case "update_successful":
                                    echo "<br><span class='profile-span error-message'><b>Message update successful.</b></span>";
                                    break;
                            }
                        }
                        ?>
                        <tr>
                            <th>Edit</th>
                            <th>MessageID</th>
                            <th>State</th>
                            <th>Content</th>
                            <th>SenderID</th>
                            <th>ReceiverID</th>
                        </tr>
                        <?php print_manager_message_list() ?>
                    </table>
                </div>

                <div class="main-item-container" id="user-list-item-container">
                    <table class="horizontal-scroll-wrapper data-table">
                        <?php totalUser() ?>
                        <?php
                        if (!empty($_GET['result'])) {
                            switch ($_GET['result']) {
                                case "invalid_email":
                                    echo "<br><span class='profile-span error-message'><b>This email is already used by others.</b></span>";
                                    break;
                                case "invalid_phond":
                                    echo "<br><span class='profile-span error-message'><b>This phone number is already used by others.</b></span>";
                                    break;
                                case "user_update_successful":
                                    echo "<br><span class='profile-span error-message'><b>User profile information update successful!</b></span>";
                                    break;
                                case "user_delete_succeeded":
                                    echo "<br><span class='profile-span error-message'><b>User delete successful.</b></span>";
                                    break;
                            }
                        }
                        ?>
                        <tr class="table-title">
                            <th>Edit</th>
                            <th>Delete</th>
                            <th>UserID</th>
                            <th>FirstName</th>
                            <th>LastName</th>
                            <th>AccountName</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>AccountType</th>
                            <th>ABN</th>
                            <th>TotalRate</th>
                            <th>RateNumber</th>
                            <th>AverageRate</th>
                            <th>AccountState</th>
                        </tr>
                        <?php print_manager_user_list() ?>
                    </table>
                    <button class="submit-button" onclick="location.href='registration.php'">Register/Create New User</button>
                </div>
            </div>
        </div>
    </div>
    <div class="bottom-bar">
        <div class="bottom-bar-container">
            <!-- footer -->
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/manager_dashboard.js"></script>
</body>

</html>