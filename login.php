<?php
require 'general/header.php';
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="css/login.css">
    <title>Login</title>
</head>

<body>
    <div class="top-bar">
        <div class="top-bar-container">
            <!--webside name header-->
            <?php general_header(); ?>

            <!--register button-->
            <?php login_header(); ?>
        </div>
    </div>
    <div class="content">
        <div class="content-container">
            <div class="main-content-container">
                <!-- main content -->
                <form class="registration-overview-item-container" action="general/account_process.php" method="post">
                    <input type="hidden" name="action" value="login" style="height: 0;">
                    <!--LINE 0,login title-->
                    <div class="profile-group">
                        <span class="login-title"><b>Login to UniTas ABS</b></span>
                    </div>
                    <!--LINE 1, email address as username field-->
                    <div class="profile-group">
                        <span class="profile-span email-address" style="margin-top: 0;">Email address</span>
                        <input type="text" class="profile-field email-address" placeholder="Enter username here" name="email" required>
                        <span class="enter-field-comment">Please enter email address as username to login</span>
                    </div>
                    <!--LINE 2, password to login field-->
                    <div class="profile-group">
                        <span class="profile-span password">Password</span>
                        <input type="password" id="password-enter" class="profile-field password" placeholder="Enter password here" name="password" required>
                    </div>
                    <!--Line2.1, error message if have any-->
                    <div class="profile-group">
                        <?php
                        if (!empty($_GET['error'])) {
                            switch($_GET['error'])
                            {
                                case "invalid_email_or_password":
                                    echo "<span class='profile-span error-message'><b>Login Email or Password is not match, please check and try again.</b></span>";
                                break;
                                case "account_banned":
                                    echo "<span class='profile-span error-message'><b>Your account has been banned, please contact system manager.</b></span>";
                                break;
                            }
                        }
                        ?>
                    </div>
                    <!--LINE 3, submit button-->
                    <div class="profile-group">
                        <input type="submit" value="Login" class="submit-button" name="submit_form">
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
    <!--<script type="text/javascript" src="js/login.js"></script>-->
</body>

</html>