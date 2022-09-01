<?php
require 'general/header.php';
require 'general/account_process.php';
require 'general/accommodation_profile_list.php';
require 'general/booking_message_list.php';
require 'general/message_list.php';
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="css/host_dashboard.css">
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
                        <!--my publishes section radio button-->
                        <label class="dashboard-side-bar-radio">
                            <input type="radio" class="dashboard-side-bar-radio-button" name="dashboard-side-bar-radio-button" onclick="myPublishes()">My Publishes
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
                    <!--LINE 6, email address field-->
                    <div class="profile-group">
                        <span class="profile-span abn">ABN</span>
                        <input type="text" class="profile-field abn" pattern="\d{11}" name="abn" placeholder="<?php echo get_data('ABN'); ?>" require>
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

                <!-- my publishes section -->
                <!--create new accommodation button-->
                <div class="accommodation-profile-overview-item-container">
                    <!--create a new form for host to fill to create a new accommodation-->
                    <button type="button" class="btn btn-outline-primary" id="accommodation-profile-create-new" onclick="instantiateAccommodationProfile()"><b>Create A New Accommodation</b></button>
                    <?php
                    if (!empty($_GET['result'])) {
                        switch ($_GET['result']) {
                            case "add_succeeded":
                                echo "<span class='profile-span error-message'><b>Accommodation added succeeded!</b></span>";
                                break;
                            case "delete_succeeded":
                                echo "<span class='profile-span error-message'><b>Accommodation delete succeeded.</b></span>";
                                break;
                            case "update_succeeded":
                                echo "<span class='profile-span error-message'><b>Accommodation update succeeded.</b></span>";
                                break;
                        }
                    }
                    ?>
                </div>

                <!--accommodation profile-->
                <!--empty profile table use to add new accommodation-->
                <div id="accommodation-profile-inserter" style="display: none;">
                    <form class="accommodation-profile-overview-item-container" id="add_accommodation_profile" action="general/accomodation_process.php" method="post">
                        <input type="hidden" id="accommodation-profile-submit-value" class="accommodation-profile-submit-value" name="action" value="" style="height: 0;">
                        <input type="hidden" id="accommodation-profile-submit-id" class="accommodation-profile-submit-id" name="table_id" value="" style="height: 0;">
                        <!--LINE 1, house name field-->
                        <div class="profile-group">
                            <span class="profile-span house-name">House Name</span>
                            <input type="text" class="profile-field postage-address" name="house_name" required>
                        </div>
                        <!--LINE 2, postage address field-->
                        <div class="profile-group">
                            <span class="profile-span postage-address">Postage Address</span>
                            <input type="text" class="profile-field postage-address" name="postage_address" required>
                        </div>
                        <!--LINE 3, city field-->
                        <div class="profile-group">
                            <span class="profile-span city">City</span>
                            <input type="text" class="profile-field city" name="city" required>
                        </div>
                        <!--LINE 4, description field-->
                        <div class="profile-group">
                            <span class="profile-span description">Description</span>
                            <input type="text" class="profile-field description" name="description" required>
                        </div>
                        <!--LINE 5, price field-->
                        <div class="profile-group">
                            <span class="profile-span price">Price</span>
                            <input type="number" class="profile-field price" name="price" required>
                        </div>
                        <!--LINE 6, bedroom number field-->
                        <div class="profile-group">
                            <span class="profile-span bedroom-number">Bedroom Number</span>
                            <input type="number" class="profile-field bedroom-number" name="bedroom_number" required>
                        </div>
                        <!--LINE 7, bathroom number field-->
                        <div class="profile-group">
                            <span class="profile-span bathroom-number">Bathroom Number</span>
                            <input type="number" class="profile-field bathroom-number" name="bathroom_number" required>
                        </div>
                        <!--LINE 8, check in date -->
                        <div class="profile-group">
                            <span class="profile-span check-in-date">Check in Date</span>
                            <input type="date" class="profile-field check-in-date" min="2021-01-01" max="2110-01-01" name="check_in_date" required>
                        </div>
                        <!--LINE 9, check in date -->
                        <div class="profile-group">
                            <span class="profile-span check-out-date">Check in Date</span>
                            <input type="date" class="profile-field check-out-date" min="2021-01-01" max="2110-01-01" name="check_out_date" required>
                        </div>
                        <!--LINE 10, garage number field-->
                        <div class="profile-group">
                            <span class="profile-span garage-available">Garage Available</span>
                            <select class="profile-field garage-available" name="garage_available" required>
                                <option value="" selected disabled>Select</option>
                                <option value="yes">YES</option>
                                <option value="no">NO</option>
                            </select>
                        </div>
                        <!--LINE 11, smoke allowability selection-->
                        <div class="profile-group">
                            <span class="profile-span smoke-allowabillity">Smoke Allowability</span>
                            <select class="profile-field smoke-allowabillity" name="smoke_allowabillity" required>
                                <option value="" selected disabled>Select</option>
                                <option value="yes">YES</option>
                                <option value="no">NO</option>
                            </select>
                        </div>
                        <!--LINE 12, pet allowability selection-->
                        <div class="profile-group">
                            <span class="profile-span pet-allowabillity">Pet Allowability</span>
                            <select class="profile-field pet-allowabillity" name="pet_allowabillity" required>
                                <option value="" selected disabled>Select</option>
                                <option value="yes">YES</option>
                                <option value="no">NO</option>
                            </select>
                        </div>
                        <!--LINE 13, internet provision selection-->
                        <div class="profile-group">
                            <span class="profile-span internet-provision">Internet Provision</span>
                            <select class="profile-field internet-provision" name="internet_provision" required>
                                <option value="" selected disabled>Select</option>
                                <option value="yes">YES</option>
                                <option value="no">NO</option>
                            </select>
                        </div>
                        <!--LINE 14, max accommodate field-->
                        <div class="profile-group">
                            <span class="profile-span max-accommodate">Max Accommodate</span>
                            <input type="number" class="profile-field max-accommodate" name="max_accommodate" required>
                        </div>
                        <!--LINE 15, image address field-->
                        <div class="profile-group">
                            <span class="profile-span image-address">Image Address</span>
                            <input type="file" class="profile-field image-address file" name="image_address">
                        </div>
                        <!--LINE 16, see reviews button-->
                        <div class="profile-group">
                            <button type="button" class="btn btn-outline-primary" id="accommodation-review-modal-button" data-toggle="modal" data-target="#accommodation-review-modal">
                                <b>See Reviews</b>
                            </button>
                        </div>
                        <!--LINE 17, save change button-->
                        <div class="profile-group">
                            <input type="submit" value="Save Change" class="submit-button accommodation-edit" id="accommodation-edit-submit" onclick="submitButtonValue(this, 'edit', -1);" name="submit_form">
                            <input type="submit" value="Delete" class="submit-button accommodation-delete" id="accommodation-delete-submit" onclick="submitButtonValue(this, 'delete', -1);" name="submit_form">
                            <input type="submit" value="Publish" class="submit-button accommodation-add" id="accommodation-add-submit" style="display: none;" onclick="submitButtonValue(this, 'add', -1);" name="submit_form">
                        </div>
                    </form>
                </div>
                <!--print all accommodation profile for current session user-->
                <?php print_accommodation_profile_list(); ?>

                <!--modal section for see review button-->
                <div class="modal fade" id="accommodation-review-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="modal-review-group">
                                    <span class="modal-review-user"><b>user firstname + lastname here</b></span>
                                    <br>
                                    <span class="modal-review-content">this is review this is review this is
                                        review this is review this is review this is review </span>
                                    <br>
                                    <span>Rate:&nbsp</span>
                                    <span><b>★★★★★</b></span>
                                    <br><br>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <!--button type="button" class="btn btn-primary">Save changes</button-->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- message inbox section -->
                <?php print_booking_message() ?>
                <?php print_message_list() ?>
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
    <script type="text/javascript" src="js/host_dashboard.js"></script>
    <script type="text/javascript" src="js/booking_message.js"></script>
</body>

</html>