<?php
//require_once 'general/connection.php';
require 'general/header.php';
include 'general/session.php';
?>
<!DOCTYPE html>
<html>

<head>
    <script>
        window.onload = function() {
            const state = ['NO', 'YES'];
            const review_rate = '★★★★★';

            $.ajax({
                url: './general/windowonload.php', //target page url
                type: 'GET', //upload method
                dataType: 'JSON', //type of data uploaded

                success: function(res) { //receive data after successful data return
                    console.log(res);
                    //read every piece of data
                    $(res.res).each(function(i, val) {
                        //if (document.querySelector(`#acc-${val.AccommodationID}`) == null) { //query whether there is a target element in the HTML page
                        if (val.averagerate == null) {
                            val.averagerate = 5;
                        }
                        //print house information
                        $("#overview").append(`<div id="acc-${val.AccommodationID}" class="accommodation-overview-item-container">\
                    <!--picture of the accommodation-->\
                    <div class="accommodation-picture-container">\
                    </div>\
                    <div class="accommodation-description-container">\
                        <!--LINE 1, price and host rate-->\
                        <div class="accommodation-description-line-container">\
                            <span class="accommodation-price" name="price" id = "price_" value="${val.Price}"><b>${val.Price}</b></span>\
                            <div class="accommodation-host-rate">\
                                <span>Host Rate:&nbsp</span>\
                                <span><b>${review_rate.substring(0, val.useraveragerate)}</b></span>\
                            </div>\
                        </div>\
                        <!--LINE 2, bedroom, bathroom and garage number-->\
                        <div class="accommodation-description-line-container">\
                            <div class="accommodation-number-of-room-container">\
                                <div class="number-of-room">\
                                    <span>Bedroom:&nbsp</span>\
                                    <span>${val.BedroomNumber}</span>\
                                </div>\
                                <div class="number-of-room">\
                                    <span>Bathroom:&nbsp</span>\
                                    <span>${val.BathroomNumber}</span>\
                                </div>\
                                <div class="number-of-room">\
                                    <span>Garage:&nbsp</span>\
                                    <span><b>${state[val.Garage]}</b></span>\
                                </div>\
                            </div>\
                        </div>\
                        <!--LINE 3, room rate and see review button-->\
                        <div class="accommodation-description-line-container">\
                            <div class="accommodation-room-rate" id="room-rate">\
                            <span>Room Rate:&nbsp</span>\
                                <span><b>${review_rate.substring(0, val.averagerate)}</b></span>
                            </div>\
                            <button onclick=showReview("${val.AccommodationID}") type="button" class="btn btn-outline-primary" id="accommodation-review-modal-button"><b>See Review</b>\
                            </button>\
                        </div>\
                        <!--LINE 4, address of the accommodation-->\
                        <div class="accommodation-description-line-container">\
                            <div class="accommodation-address">\
                                <span>${val.Address} , ${val.City}</span>\
                            </div>\
                        </div>\
                        <!--LINE 5, smoke allowbility of the accommodation-->\
                        <div class="accommodation-description-line-container">\
                            <div class="accommodation-smoke">\
                                <span>Smoke allowability:&nbsp</span>\
                                <span><b>${state[val.Smoking]}</b></span>\
                            </div>\
                        </div>\
                        <!--LINE 6, newtwork provision of the accommodation-->\
                        <div class="accommodation-description-line-container">\
                            <div class="accommodation-network">\
                                <span>Network provision:&nbsp</span>\
                                <span><b>${state[val.Internet]}</b></span>\
                            </div>\
                        </div>\
                        <!--LINE 7, pre allowability of the accommodation-->\
                        <div class="accommodation-description-line-container">\
                            <div class="accommodation-pet">
                                <span>Pet allowability:&nbsp</span>
                                <span><b>${state[val.Pet]}</b></span>
                            </div>
                        </div>
                        <!--LINE 8, booking request button-->
                        <!--<form class="accommodation-booking-button-container" action="general/book_process.php" method="post">
                            <button name="submit_form" class="btn btn-outline-primary" data-toggle="modal" id="accommodation-booking-button"><b>Book Now!</b></button>
                        </form>-->
                        <div class="accommodation-booking-button-container"  >
                            <button type="button" onclick=send_null() class="btn btn-outline-primary" id="accommodation-booking-button"><b>Book Now!</b></button>\
                        </div>
                        <div class="hidden_value">
                        <input type="hidden" value="${val.AccommodationID}" name="accommodationID" id="accommodationID"/>
                        </div>
                    </div>
                </div>`);
                    });
                    return false;
                },
                error: function() { //data return failed
                    alert("There are no accommodation available.");
                    return false;
                }
            });
        }
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="css/index.css">
    <title>Utas ABS</title>
</head>

<body>
    <div class="book-infor-container" id="book-infor-input">

    </div>
    <div class="top-bar">
        <div class="top-bar-container">
            <!--webside name header-->
            <?php general_header(); ?>

            <!--header button section-->
            <?php
            //if user is not yet loged in
            if ($_SESSION['session_user_id'] == "") {
                //display rigister and login buttons
                index_header();
            }
            //otherwise user is loged in
            else {
                //display profile link and logout button
                signout();
            }
            ?>

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
                <div class="side-bar-sticky-item-container" action="general/accommodation_list.php" method="post">
                    <div class="side-bar-item-container">
                        <!--search section title-->
                        <span class="side-bar-search-title"><b>Search Filter</b></span>
                    </div>
                    <div class="side-bar-item-container">
                        <!--city search text input field-->
                        <input type="text" class="destination-input-field" placeholder="Destination City" id="destination-city-id" required>
                    </div>
                    <div class="side-bar-item-container">
                        <!-- check in date -->
                        <!--check in must be before check out-->
                        <span class="check-in-date-span">Check in Date</span>
                        <input type="date" class="check-in-date-field" min="2021-01-01" max="2110-01-01" id="check-in-id" required>
                    </div>
                    <div class="side-bar-item-container">
                        <!-- check out date -->
                        <!--check out must be after check in-->
                        <span class="check-out-date-span">Check out Date</span>
                        <input type="date" class="check-out-date-field" min="2021-01-01" max="2110-01-01" id="check-out-id" required>
                    </div>
                    <div class="side-bar-item-container">
                        <!-- number of guests -->
                        <select name="number-of-guests" id="number-of-guests" required>
                            <option value="" selected disabled>Guest Number</option>
                            <option value="Any">Any</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                        </select>
                    </div>
                    <div class="side-bar-item-container">
                        <!--side bar search section button-->
                        <button onclick="search()" class="btn btn-outline-primary" id="side-bar-search-button"><b>Search</b></button>
                    </div>
                </div>
            </div>
            <div class="main-content-container" id="overview">
                <!-- main content -->
                <!--accommodation list will append under here-->
            </div>
        </div>
    </div>
    <div class="bottom-bar">
        <div class="bottom-bar-container">
            <!-- footer -->
        </div>
    </div>
    <!--modal window for review-->
    <div class="modal fade" id="comment" tabindex="-1" role="dialog" aria-labelledby="Reviews" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Reviews</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal_comment_content">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <!--button type="button" class="btn btn-primary">Save changes</button-->
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/search.js"></script>
    <script type="text/javascript" src="js/review.js"></script>
    <script type="text/javascript" src="js/send.js"></script>
</body>

</html>