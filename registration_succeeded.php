<?php
require 'general/header.php';
require 'general/account_process.php';
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
                <div class="registration-overview-item-container" action="general/register.php" method="post">
                    <!--registration succeeded message-->
                    <div class="profile-group">
                        <span class="profile-span registration-succeeded-message"><b>Registration succeeded!</b></span>
                    </div>
                    <!--return to home page button-->
                    <div class="profile-group">
                        <button type="button" class="btn btn-outline-primary" id="back-home-button" onclick="location.href = 'index.php'"><b>Back to home</b></button>
                    </div>
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
    <script type="text/javascript" src="js/registration.js"></script>
</body>

</html>