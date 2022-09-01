function send(check_in, check_out, number_guests, price, accommodationID) {

    //receive data from html
    var check_in = check_in;
    var check_out = check_out;
    var number_guests = number_guests;
    var price = price;

    console.log(check_in, check_out, number_guests, price);

    //AJAX function, transfer data to php for database access and receive data return
    $.ajax({
        url: './general/logincheck.php',  //target page url
        type: 'GET',  //get method
        dataType: 'JSON',  //type of data uploaded


        success: function (res) {
            if (res.success == true) {  //receive the result of judging whether to log in
                if (check_in != null) {
                    //print booking information module if already login
                    $('#book-infor-input').append(`<!DOCTYPE html>
               <html>
               <head>
                   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
                   <link rel="stylesheet" href="css/book_accommodation.css">
                   <title>Book Accommodation</title>
               </head>
               <body>
                   <div class="content">
                       <div class="content-container">
                           <div class="book-accommodation-container" id="book-information">
                               <!-- main content -->
                               <form class="registration-overview-item-container" action="general/book_process.php" method="post">
                                   <input type="hidden" name="action" value="login" style="height: 0;">
                                   <input type="hidden" name="accommodationID" value="${accommodationID}" style="height: 0;">
                                   
                                   <div class="profile-group">
                                       <span class="login-title"><b>Book Accommodation</b></span>
                                   </div>
               
                                   <div class="profile-group"></div>
                                   <div class="profile-group profile-data">
                                       <span class="confirm-title">Check in date:</span>
                                       <span><b>${check_in}</b></span>
                                   </div>
                                   <div class="profile-group profile-data">
                                       <span class="confirm-title">Check out date:</span>
                                       <span><b>${check_out}</b></span>
                                   </div>
                                   <div class="profile-group profile-data">
                                       <span class="confirm-title">Number of people:</span>
                                       <span><b>${number_guests}</b></span>
                                   </div>
                                   <div class="profile-group profile-data">
                                       <span class="confirm-title">Price per week:</span>
                                       <span><b>$${price}</b></span>
                                   </div>
                                   <div class="profile-group"></div>
               
                                   <!--first name field-->
                                   <div class="profile-group">
                                       <span class="profile-span first-name">First Name</span>
                                       <input type="text" id="first-name-id" class="profile-field first-name" placeholder="Enter your first name here" name="first_name" required>
                                   </div>
                                   <!--last name field-->
                                   <div class="profile-group">
                                       <span class="profile-span last-name">Last Name</span>
                                       <input type="text" id="last-name-id" class="profile-field last-name" placeholder="Enter your last name here" name="last_name" required>
                                   </div>
                                   <!--email address as username field-->
                                   <div class="profile-group">
                                       <span class="profile-span email-address" style="margin-top: 0;">Email address</span>
                                       <input type="text" id="email-id" class="profile-field email-address" placeholder="Enter email here" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" name="email" required>
                                       <span class="enter-field-comment">Please enter email address with xxx@xxx.xxx
                                   </div>
                                   <!--phone number field-->
                                   <div class="profile-group">
                                       <span class="profile-span phone-number">Phone Number</span>
                                       <input type="tel" id="phone-number-id" class="profile-field phone-number" placeholder="Enter your mobile phone number here" pattern="[0][45][0-9]{8}" name="phone" required>
                                       <span class="enter-field-comment">Please enter phone number with 04xx xxx xxx or 05xx xxx xxx
                                           format</span>
                                   </div>

                                   <!--submit button-->
                                   <div class="accommodation-booking-button-container">
                                     <input type="submit" name="submit_form" value="Book Now!" class="btn btn-outline-primary" id="accommodation-confirm-book-button">
                                     <button type="button" class="btn btn-outline-primary" id="accommodation-confirm-close-button" onclick="boxclose()">Close Window</Button>
                                    </div>
                               </form>
                           </div>
                       </div>
                   </div>
                 <!--  <script type="text/javascript" src="js/confirmbook.js"></script>-->
                   <script type="text/javascript" src="js/close.js"></script>
               </body>
               </html>`);
                    $("#book-infor-input").show();  //display booking information module
                } else {
                    $('#book-infor-input').append(`Please choose first!`);
                }
            }
            else  //jump to the login page if you are not logged in
            {
                window.location.href = 'login.php';  //jump to the login page
            }
            return false;
        },
        error: function () {  //data return failed
            alert("Please refresh the page and try again!");
            return false;
        }
    });

}