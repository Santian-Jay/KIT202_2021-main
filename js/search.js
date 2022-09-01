function search() {

    //get the value passed in the HTML page
    var destination_city = document.getElementById("destination-city-id").value;
    var check_in = document.getElementById("check-in-id").value;
    var check_out = document.getElementById("check-out-id").value;
    var number_guests = document.getElementById("number-of-guests").value;

    //set the minimum value of check out date to check in date
    document.getElementById("check-out-id").setAttribute("min", check_in);

    //create a string array and convert it according to 0 and 1
    const state = ['NO', 'YES'];
    const review_rate = '★★★★★';

    //all search field must not be empty
    if (check_in != null && check_in != "" && check_out != null && check_out != "" && number_guests != null && number_guests != "") {
        //AJAX function, transfer data to php for database access and receive data return
        $.ajax({
            url: './general/accommodation_list.php',  //target page url
            type: 'POST',  //upload method
            dataType: 'JSON',  //type of data uploaded

            //uploaded data
            data: {
                check_in: check_in,
                check_out: check_out,
                destination_city: destination_city,
                number_guests: number_guests
            },
            success: function (res) {  //receive data after successful data return
                //read every piece of data
                $("#overview").html("");
                console.log(res);
                $(res.res).each(function (i, val) {
                    if (document.querySelector(`#acc-${val.AccommodationID}`) == null) {  //query whether there is a target element in the HTML page
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
                            <span class="accommodation-price"><b>${val.Price}</b></span>\
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
                            <div class="accommodation-room-rate">\
                                <span>Room Rate:&nbsp</span>\
                                <span><b>${review_rate.substring(0, val.averagerate)}</b></span>\
                            </div>\
                            <button onclick="showReview(${val.AccommodationID})" type="button" class="btn btn-outline-primary" id="accommodation-review-modal-button"><b>See Review</b>\
                            </button>\
                        </div>\
                        <!--LINE 4, address of the accommodation-->\
                        <div class="accommodation-description-line-container">\
                            <div class="accommodation-address">\
                                <span>${val.Address}, ${val.City}</span>\
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
                            <div class="accommodation-pet">\
                                <span>Pet allowability:&nbsp</span>\
                                <span><b>${state[val.Pet]}</b></span>\
                            </div>\
                        </div>\
                        <!--LINE 8, booking request button-->\
                        <!--<form class="accommodation-booking-button-container" action="general/book_process.php" method="post">\
                            <button name="submit_form" class="btn btn-outline-primary" id="accommodation-booking-button"><b>Book Now!</b></button>\
                        </form>\-->
                        <div class="accommodation-booking-button-container"  >
                            <button type="button" onclick=send("${check_in}","${check_out}","${number_guests}",${val.Price},${val.AccommodationID}) class="btn btn-outline-primary" id="accommodation-booking-button"><b>Book Now!</b></button>\
                        </div>
                        <div class="hidden_value">\
                        <input type="hidden" value="${val.AccommodationID}" name="accommodationID" id="accommodationID"/>\
                        </div>\
                    </div>\
                </div>`);
                    }
                });
                return false;
            },
            error: function () {  //data return failed
                //alert(error);
                alert("No result found, please try to search with other information.");
                return false;
            }
        });
    }
    else {
        alert("Please enter all infomation to search.")
    }
}


//if no information is filtered
function send_null() {
    alert("Please login first then enter your booking required into the search filter, then press the'Search' button to confirm and locate the specific accommodation.");
}

