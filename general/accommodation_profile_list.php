<?php
function print_accommodation_profile_list()
{
    require 'connection.php';

    $userID = $_SESSION['session_user_id'];

    //query for accommodations are owned by current user
    $result = $mysqli->query("SELECT * FROM accommodation WHERE OwnerID = $userID");

    //print all accommodation data from database
    while ($row = $result->fetch_array()) {
        //convert some data from bit to string
        $garage = $row['Garage'] == 1 ? "YES" : "NO";
        $smoking = $row['Smoking'] == 1 ? "YES" : "NO";
        $pet = $row['Pet'] == 1 ? "YES" : "NO";
        $internet = $row['Internet'] == 1 ? "YES" : "NO";

        echo '<form class="accommodation-profile-overview-item-container" action="general/accomodation_process.php" method="post">
                    <input type="hidden" class="accommodation-profile-submit-value" name="action" value="" style="height: 0;">
                    <input type="hidden" class="accommodation-profile-submit-id" name="table_id" value="' . $row['AccommodationID'] . '" style="height: 0;">
                    <!--LINE 1, house name field-->
                    <div class="profile-group">
                        <span class="profile-span house-name">House Name</span>
                        <input type="text" class="profile-field postage-address" placeholder="' . $row['AccommodationName'] . '" name="house_name" required>
                    </div>
                    <!--LINE 2, postage address field-->
                    <div class="profile-group">
                        <span class="profile-span postage-address">Postage Address</span>
                        <input type="text" class="profile-field postage-address" placeholder="' . $row['Address'] . '" name="postage_address" required>
                    </div>
                    <!--LINE 3, city field-->
                    <div class="profile-group">
                        <span class="profile-span city">City</span>
                        <input type="text" class="profile-field city" placeholder="' . $row['City'] . '" name="city" required>
                    </div>
                    <!--LINE 4, description field-->
                    <div class="profile-group">
                        <span class="profile-span description">Description</span>
                        <input type="text" class="profile-field description" placeholder="' . $row['Description'] . '" name="description" required>
                    </div>
                    <!--LINE 5, price field-->
                    <div class="profile-group">
                        <span class="profile-span price">Price</span>
                        <input type="number" class="profile-field price" placeholder="' . $row['Price'] . '" name="price" required>
                    </div>
                    <!--LINE 6, bedroom number field-->
                    <div class="profile-group">
                        <span class="profile-span bedroom-number">Bedroom Number</span>
                        <input type="number" class="profile-field bedroom-number" placeholder="' . $row['BedroomNumber'] . '" name="bedroom_number" required>
                    </div>
                    <!--LINE 7, bathroom number field-->
                    <div class="profile-group">
                        <span class="profile-span bathroom-number">Bathroom Number</span>
                        <input type="number" class="profile-field bathroom-number" placeholder="' . $row['BathroomNumber'] . '" name="bathroom_number" required>
                    </div>
                    <!--LINE 8, check in date -->
                    <div class="profile-group">
                        <span class="profile-span check-in-date">Check in Date</span>
                        <input type="text" class="profile-field check-in-date" min="2021-01-01" max="2110-01-01" onfocus="(this.type=\'date\')" onblur="(this.type=\'text\')" placeholder="' . $row['CheckInDate'] . '" name="check_in_date" required>
                    </div>
                    <!--LINE 9, check in date -->
                    <div class="profile-group">
                        <span class="profile-span check-out-date">Check in Date</span>
                        <input type="text" class="profile-field check-out-date" min="2021-01-01" max="2110-01-01" onfocus="(this.type=\'date\')" onblur="(this.type=\'text\')" placeholder="' . $row['CheckOutDate'] . '" name="check_out_date" required>
                    </div>
                    <!--LINE 10, garage number field-->
                    <div class="profile-group">
                        <span class="profile-span garage-available">Garage Available</span>
                        <select class="profile-field garage-available" name="garage_available" required>
                            <option value="' . $garage . '" selected disabled>' . $garage . '</option>
                            <option value="yes">YES</option>
                            <option value="no">NO</option>
                        </select>
                    </div>
                    <!--LINE 11, smoke allowability selection-->
                    <div class="profile-group">
                        <span class="profile-span smoke-allowabillity">Smoke Allowability</span>
                        <select class="profile-field smoke-allowabillity" name="smoke_allowabillity" required>
                            <option value="' . $smoking . '" selected disabled>' . $smoking . '</option>
                            <option value="yes">YES</option>
                            <option value="no">NO</option>
                        </select>
                    </div>
                    <!--LINE 12, pet allowability selection-->
                    <div class="profile-group">
                        <span class="profile-span pet-allowabillity">Pet Allowability</span>
                        <select class="profile-field pet-allowabillity" name="pet_allowabillity" required>
                            <option value="' . $pet . '" selected disabled>' . $pet . '</option>
                            <option value="yes">YES</option>
                            <option value="no">NO</option>
                        </select>
                    </div>
                    <!--LINE 13, network provision selection-->
                    <div class="profile-group">
                        <span class="profile-span internet-provision">Internet Provision</span>
                        <select class="profile-field internet-provision" name="internet_provision" required>
                            <option value="' . $internet . '" selected disabled>' . $internet . '</option>
                            <option value="yes">YES</option>
                            <option value="no">NO</option>
                        </select>
                    </div>
                    <!--LINE 14, max accommodate field-->
                    <div class="profile-group">
                        <span class="profile-span max-accommodate">Max Accommodate</span>
                        <input type="number" class="profile-field max-accommodate" placeholder="' . $row['MaxAccommodate'] . '" name="max_accommodate" required>
                    </div>
                    <!--LINE 15, image address field-->
                    <div class="profile-group">
                        <span class="profile-span image-address">Image Address</span>
                        <input type="file" class="profile-field image-address file" placeholder="' . $row['Photo'] . '" name="image_address">
                    </div>
                    <!--LINE 16, save change button-->
                    <div class="profile-group">
                        <input type="submit" value="Save Change" class="submit-button accommodation-edit" id="accommodation-edit-submit" onclick="removeAllRequire(this); submitButtonValue(this, \'edit\', ' . $row['AccommodationID'] . ');" name="submit_form">
                        <button type="button" class="submit-button delete-button" onclick="removeAllRequire(this); enableDeleteWarning(this);">Delete</button>
                        <input type="submit" value="Publish" class="submit-button accommodation-add" id="accommodation-add-submit" style="display: none;" onclick="submitButtonValue(this, \'add\', -1);" name="submit_form">
                    </div>

                    <div class="profile-group">
                        <span class="profile-span error-message" style="display: none;"><b>Are you sure to delete this accommodation?</b></span>
                    </div>
                    <div class="profile-group">
                        <button type="button" class="submit-button no-delete" style="display: none;" onclick="addAllRequire(this); disableDeleteWarning(this);">No</button>
                        <input type="submit" value="Yes" class="submit-button accommodation-delete" style="display: none;" id="accommodation-delete-submit" onclick="submitButtonValue(this, \'delete\', ' . $row['AccommodationID'] . ');" name="submit_form">
                    </div>
                </form>';
    }
}
