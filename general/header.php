<?php
//the general header display the website name to top bar
function general_header()
{
    echo '<div class="top-bar-logo">
                <a href="index.php" class="logo-title-name">UniTas ABS</a>
            </div>';
}

//the top bar for if user is logged in
function signout()
{
    //determine the page link by current user type
    switch ($_SESSION['session_user_type']) {
        case "client":
            $page_name = "user_dashboard.php";
            break;
        case "host":
            $page_name = "host_dashboard.php";
            break;
        case "manager":
            $page_name = "manager_dashboard.php";
            break;
    }

    //create dashboard link on top bar depends the user type
    echo '<div class="top-bar-button-group">
                <span class="user-name-span"><b>Welcome,&nbsp</b></span>
                <a href="' . $page_name . '" class="user-name-span user-name-link"><b>' . $_SESSION['session_user'] . '</b></a>
                <button type="button" class="btn btn-outline-primary" id="logout-button" onclick="location.href = \'general/signout.php\'"><b>Log out</b></button>
            </div>';
}

//unique top bar for index page
function index_header()
{
    echo '<div class="top-bar-button-group">
            <button type="button" class="btn btn-outline-primary" id="registion-button" onclick="location.href = \'registration.php\'"><b>Register</b></button>
            <button type="button" class="btn btn-outline-primary" id="login-button" onclick="location.href = \'login.php\'"><b>Log in</b></button>
        </div>';

        /* dashboard debug button group
        <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <b>Dashboard</b>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="user_dashboard.php">User Dashboard</a>
                    <a class="dropdown-item" href="host_dashboard.php">Host Dashboard</a>
                    <a class="dropdown-item" href="manager_dashboard.php">Manager Dashboard</a>
                </div>
            </div>
            */
}

//unique head bar for registration page
function registration_header()
{
    if ($_SESSION['session_user'] == "") {
        echo '<div class="top-bar-button-group">
            <button type="button" class="btn btn-outline-primary" id="login-button" onclick="location.href = \'login.php\'"><b>Log in</b></button>
        </div>';
    }
}

//unique head bar for login page
function login_header()
{
    echo '<div class="top-bar-button-group">
            <button type="button" class="btn btn-outline-primary" id="registion-button" onclick="location.href = \'registration.php\'"><b>Register</b></button>
        </div>';
}
