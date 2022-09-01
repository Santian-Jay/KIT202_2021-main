<?php
require 'general/header.php';
require 'general/account_process.php';
require 'general/booking_message_list.php';
require 'general/message_list.php';
require 'general/review_list.php';
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="css/user_dashboard.css">
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
                        <!--profile section radio button-->
                        <label class="dashboard-side-bar-radio active">
                            <input type="radio" class="dashboard-side-bar-radio-button" name="dashboard-side-bar-radio-button" onclick="profile()" checked>Profile
                        </label>
                    </div>
                    <div class="side-bar-item-container">
                        <!--applidations section radio button-->
                        <label class="dashboard-side-bar-radio">
                            <input type="radio" class="dashboard-side-bar-radio-button" name="dashboard-side-bar-radio-button" onclick="applications()">Applications
                        </label>
                    </div>
                    <div class="side-bar-item-container">
                        <!--my reviews section radio button-->
                        <label class="dashboard-side-bar-radio">
                            <input type="radio" class="dashboard-side-bar-radio-button" name="dashboard-side-bar-radio-button" onclick="myReviews()">My Reviews
                        </label>
                    </div>
                    <div class="side-bar-item-container">
                        <!--message inbox section radio button-->
                        <label class="dashboard-side-bar-radio">
                            <input type="radio" class="dashboard-side-bar-radio-button" name="dashboard-side-bar-radio-button" onclick="messageInbox()">Message Inbox
                        </label>
                    </div>
                </div>
            </div>
            <div class="main-content-container">
                <!-- main content -->
                <!-- profile section -->
                <form class="user-profile-overview-item-container" action="general/account_process.php" method="post">
                    <input type="hidden" name="action" value="update" style="height: 0;">
                    <!--LINE 1, account name field-->
                    <div class="profile-group">
                        <span class="profile-span account-name">Account Name</span>
                        <input type="text" class="profile-field account-name" name="account_name" placeholder="<?php echo get_data('AccountName'); ?>" require>
                    </div>
                    <!--LINE 2, first name field-->
                    <div class="profile-group">
                        <span class="profile-span first-name">First Name</span>
                        <input type="text" class="profile-field first-name" name="first_name" placeholder="<?php echo get_data('FirstName'); ?>" require>
                    </div>
                    <!--LINE 3, last name field-->
                    <div class="profile-group">
                        <span class="profile-span last-name">Last Name</span>
                        <input type="text" class="profile-field last-name" name="last_name" placeholder="<?php echo get_data('LastName'); ?>" require>
                    </div>
                    <!--LINE 4, postage address field-->
                    <div class="profile-group">
                        <span class="profile-span postage-address">Postage Address</span>
                        <input type="text" class="profile-field postage-address" name="address" placeholder="<?php echo get_data('Address'); ?>" require>
                    </div>
                    <!--LINE 5, phone number field-->
                    <div class="profile-group">
                        <span class="profile-span phone-number">Phone Number</span>
                        <input type="text" class="profile-field phone-number" name="phone" pattern="[0][45][0-9]{8}" placeholder="<?php echo get_data('Phone'); ?>" require>
                    </div>
                    <!--LINE 6, email address field-->
                    <div class="profile-group">
                        <span class="profile-span email-address">Email Address</span>
                        <input type="text" class="profile-field email-address" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" name="email" placeholder="<?php echo get_data('Email'); ?>" require>
                    </div>
                    <!--space line-->
                    <div class="profile-group"></div>
                    <!--LINE 7, password field-->
                    <div class="profile-group">
                        <span class="profile-span password">Password</span>
                        <input type="password" class="profile-field password" placeholder="Enter Password Here" name="password" required>
                    </div>
                    <!--LINE 8, new password field-->
                    <div class="profile-group">
                        <span class="profile-span password">New Password</span>
                        <input type="password" id="password-enter" class="profile-field password" placeholder="New Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%]).{6,12}" name="new_password">
                    </div>
                    <div class="profile-group" style="padding-top: 0;">
                        <span class="enter-field-comment">Please enter:<br>At least 1 lowercase letter<br>At least 1
                            uppercase letter<br>At least 1 number<br>At least 1 special character from !@#$%</span>
                    </div>
                    <!--LINE 9, confirm password field-->
                    <div class="profile-group">
                        <span class="profile-span password">Confirm Password</span>
                        <input type="password" id="confirm-password-enter" class="profile-field password" placeholder="Confirm New Password" name="confirm_password">
                    </div>
                    <div class="profile-group" style="padding-top: 0;">
                        <span class="enter-field-comment">Please make sure enter the same password as above</span>
                    </div>
                    <!--Line 9.1, successful message-->
                    <div class="profile-group">
                        <?php
                        if (!empty($_GET['result'])) {
                            switch ($_GET['result']) {
                                case "update_successful":
                                    echo "<span class='profile-span error-message'><b>Profile information update successful!</b></span>";
                                    break;
                                case "password_incorrect":
                                    echo "<span class='profile-span error-message'><b>Password is incorrect, please check again.</b></span>";
                                    break;
                                case "invalid_email":
                                    echo "<span class='profile-span error-message'><b>This email is already used by others.</b></span>";
                                    break;
                                case "invalid_phone":
                                    echo "<span class='profile-span error-message'><b>This phone number is already used by others.</b></span>";
                                    break;
                                case "password_incorrect":
                                    echo "<span class='profile-span error-message'><b>The password entered is incorrect.</b></span>";
                                    break;
                                case "confirm_passwork_invalid":
                                    echo "<span class='profile-span error-message'><b>The confirm passwork is not same as new password.</b></span>";
                                    break;
                            }
                        }
                        ?>
                    </div>
                    <!--LINE 10, save change button-->
                    <div class="profile-group">
                        <input type="submit" value="Save Change" class="submit-button" name="submit_form">
                    </div>
                </form>

                <!-- applied accommodation section -->
                <?php print_application() ?>

                <!-- my reviews section -->
                <?php print_my_review() ?>

                <!-- message inbox section -->
                <?php print_booking_message() ?>
                <?php print_message_list() ?>
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
    <script type="text/javascript" src="js/user_dashboard.js"></script>
    <script type="text/javascript" src="js/booking_message.js"></script>
</body>

</html>