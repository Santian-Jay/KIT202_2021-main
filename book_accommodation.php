<?php
require 'general/header.php';
include 'general/session.php';
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="css/book_accommodation.css">
    <title>Book Accommodation</title>
</head>

<body>
    <div class="top-bar">
        <div class="top-bar-container">
            <!--webside name header-->
            <?php general_header(); ?>

            <!-- display profile link and logout button -->
            <?php signout(); ?>
        </div>
    </div>
    <div class="content">
        <div class="content-container">
            <div class="main-content-container">
                <!-- main content -->
                <form class="registration-overview-item-container" action="" method="post">
                    <input type="hidden" name="action" value="login" style="height: 0;">
                    <!--LINE 0,login title-->
                    <div class="profile-group">
                        <span class="login-title"><b>Book Accommodation</b></span>
                    </div>

                    <div class="profile-group"></div>
                    <div class="profile-group profile-data">
                        <span class="confirm-title">Check in date:</span>
                        <span><b>aa</b></span>
                    </div>
                    <div class="profile-group profile-data">
                        <span class="confirm-title">Check out date:</span>
                        <span><b>aa</b></span>
                    </div>
                    <div class="profile-group profile-data">
                        <span class="confirm-title">Number of people:</span>
                        <span><b>aa</b></span>
                    </div>
                    <div class="profile-group profile-data">
                        <span class="confirm-title">Price per week:</span>
                        <span><b>$111</b></span>
                    </div>
                    <div class="profile-group"></div>

                    <!--LINE 2, first name field-->
                    <div class="profile-group">
                        <span class="profile-span first-name">First Name</span>
                        <input type="text" class="profile-field first-name" placeholder="Enter your first name here" name="first_name" required>
                    </div>
                    <!--LINE 3, last name field-->
                    <div class="profile-group">
                        <span class="profile-span last-name">Last Name</span>
                        <input type="text" class="profile-field last-name" placeholder="Enter your last name here" name="last_name" required>
                    </div>
                    <!--LINE 1, email address as username field-->
                    <div class="profile-group">
                        <span class="profile-span email-address" style="margin-top: 0;">Email address</span>
                        <input type="text" class="profile-field email-address" placeholder="Enter email here" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" name="email" required>
                        <span class="enter-field-comment">Please enter email address with xxx@xxx.xxx
                    </div>
                    <!--LINE 5, phone number field-->
                    <div class="profile-group">
                        <span class="profile-span phone-number">Phone Number</span>
                        <input type="tel" class="profile-field phone-number" placeholder="Enter your mobile phone number here" pattern="[0][45][0-9]{8}" name="phone" required>
                        <span class="enter-field-comment">Please enter phone number with 04xx xxx xxx or 05xx xxx xxx
                            format</span>
                    </div>
                    <!--LINE 3, submit button-->
                    <div class="profile-group">
                        <input type="submit" value="Confirm and Book!" class="submit-button" name="submit_form">
                    </div>
                </form>
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
    <script type="text/javascript" src="js/login.js"></script>
</body>

</html>