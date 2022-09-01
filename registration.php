<?php
require 'general/header.php';
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="css/registration.css">
    <title>Registration</title>
</head>

<body>
    <div class="top-bar">
        <div class="top-bar-container">
            <!--webside name header-->
            <?php general_header(); ?>

            <!--login button-->
            <?php registration_header(); ?>
        </div>
    </div>
    <div class="content">
        <div class="content-container">
            <div class="main-content-container">
                <!-- main content -->
                <form class="registration-overview-item-container" action="general/account_process.php" method="post">
                    <input type="hidden" name="action" value="register" style="height: 0;">
                    <!--LINE 0, register title-->
                    <div class="profile-group">
                        <span class="register-title"><b>Create an account on UniTas ABS</b></span>
                    </div>
                    <!--LINE 1, type of the account selection-->
                    <div class="profile-group">
                        <span class="profile-span account-type">Account type registering to</span>
                        <select id="account-type-enter" class="profile-field" name="account_type" onchange="accountType()" required>
                            <option value="" selected disabled>Select your choice</option>
                            <option value="client">Client</option>
                            <option value="host">Host</option>
                        </select>
                    </div>
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
                    <!--LINE 4, email address field-->
                    <div class="profile-group">
                        <span class="profile-span email-address">Email address</span>
                        <input type="text" class="profile-field email-address" placeholder="Enter email here" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" name="email" required>
                        <span class="enter-field-comment">Please enter email address with xxx@xxx.xxx<br>Emaill address
                            will becomes your login username</span>
                    </div>
                    <!--LINE 5, phone number field-->
                    <div class="profile-group">
                        <span class="profile-span phone-number">Phone Number</span>
                        <input type="tel" class="profile-field phone-number" placeholder="Enter your mobile phone number here" pattern="[0][45][0-9]{8}" name="phone" required>
                        <span class="enter-field-comment">Please enter phone number with 04xx xxx xxx or 05xx xxx xxx
                            format</span>
                    </div>
                    <!--LINE 6, password field-->
                    <div class="profile-group">
                        <span class="profile-span password">Password</span>
                        <input type="password" id="password-enter" class="profile-field password" placeholder="Create your password here" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%]).{6,12}" name="password" required>
                        <span class="enter-field-comment">Please enter:<br>At least 1 lowercase letter<br>At least 1
                            uppercase letter<br>At least 1 number<br>At least 1 special character from !@#$%</span>
                    </div>
                    <!--LINE 7, confirm password field-->
                    <div class="profile-group">
                        <span class="profile-span confirm-password">Confirm Password</span>
                        <input type="password" id="confirm-password-enter" class="profile-field confirm-password" placeholder="Re-type your password" onkeyup="setPassword()" required>
                        <span class="enter-field-comment">Please make sure enter the same password as above</span>
                    </div>
                    <!--LINE 8, postage address field-->
                    <div class="profile-group">
                        <span class="profile-span postage-address">Postage Address</span>
                        <input type="text" class="profile-field postage-address" placeholder="Your postage address here" name="address" required>
                    </div>
                    <!--LINE 9, ABN field-->
                    <div class="profile-group" id="ABN-profile-group">
                        <span class="profile-span ABN">ABN</span>
                        <input type="text" class="profile-field ABN" placeholder="Your Australia Business Number here" pattern="\d{11}" name="abn" required>
                        <span class="enter-field-comment">Please enter 11 digit number only</span>
                    </div>
                    <!--Line9.1, error message if have any-->
                    <div class="profile-group">
                        <?php
                        if (!empty($_GET['error'])) {
                            echo "<span class='profile-span error-message'><b>Please make sure your email or phone number is not already in used.</b></span>";
                        }
                        ?>
                    </div>
                    <!--LINE 10, submit button-->
                    <div class="profile-group">
                        <input type="submit" value="Submit" class="submit-button" name="submit_form">
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
    <script type="text/javascript" src="js/registration.js"></script>
</body>

</html>