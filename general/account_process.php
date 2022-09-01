<?php
include 'session.php';

if (!isset($_REQUEST['submit_form'])) {
    return;
} else {
    switch ($_REQUEST['action']) {
            //depends the action field data to determine function to go
        case "register":
            register();
            break;
        case "login":
            login();
            break;
        case "update":
            update();
            break;
        case "edit":
            edit();
            break;
        case "delete":
            delete();
            break;
    }
}

function register()
{
    require_once 'connection.php';

    //error message going to send back to display if anything wrong
    $error = false;

    //get the data submitted from form that needs to check there are no duplication in database
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    //use the largest id number plus one as new id number for this new user
    $query = "SELECT MAX(UserID) FROM users";
    $result = $mysqli->query($query);
    $row = mysqli_fetch_array($result);
    $user_id = $row[0] + 1;

    //data submitted from form do not need to check
    $account_type = $_POST['account_type'];
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $password = trim($_POST['password']);
    $address = trim($_POST['address']);

    $account_name = "User" . $user_id;

    //only get abn number if account type is host
    if ($account_type === "host") {
        $abn = $_POST['abn'];
    } else {
        $abn = NULL;
    }

    //default total rate and number of rates
    $total_rate = 5;
    $rate_number = 1;
    $average_rate = $total_rate/$rate_number;

    $account_state = 'inuse';

    //check if the email is already exitst in database
    $error = check_duplication("Email", $email);

    //check if the phone is already exitst in database
    $error = check_duplication("Phone", $phone);

    //if there is no error message, means all data correct and ready to store
    if ($error == false) {
        //encrypt the password before store into database
        $hash = password_hash($password, PASSWORD_DEFAULT);

        //query to store data collected from submitted form into database
        $query = $mysqli->prepare("INSERT INTO users (
                                    userID,
                                    FirstName,
                                    LastName,
                                    AccountName,
                                    Email,
                                    Password,
                                    Phone,
                                    Address,
                                    AccountType,
                                    ABN,
                                    TotalRate,
                                    RateNumber,
                                    AverageRate,
                                    AccountState)
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $query->bind_param(
            "isssssssssiiis",
            $user_id,
            $first_name,
            $last_name,
            $account_name,
            $email,
            $hash,
            $phone,
            $address,
            $account_type,
            $abn,
            $total_rate,
            $rate_number,
            $average_rate,
            $account_state
        );
        $query->execute();

        //jump to succeeded page
        header("Location: ../registration_succeeded.php");
        die;
    } else {
        //otherwise email or phone number is already exists in database, show error message
        header("Location: ../registration.php?error=invalid_email_or_phone_number");
        die;
    }
}

function login()
{
    require_once 'connection.php';

    //get the data submitted from form and compare them with database
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (verify_password($email, $password)) {
        //query all rows from database to store session informations
        $query = $mysqli->prepare("SELECT * FROM users WHERE email = ?");
        $query->bind_param('s', $email);
        $query->execute();
        $row = $query->get_result()->fetch_array(MYSQLI_ASSOC);

        //check if account is banned
        if ($row['AccountState'] == 'banned') {
            //jump back to main with error
            header("Location: ../login.php?error=account_banned");
            die;
        } else {
            //store session informations
            $_SESSION['session_user_id'] = $row['UserID'];
            $_SESSION['session_user'] = $row['Email'];
            $_SESSION['session_user_type'] = $row['AccountType'];

            //jump back to main
            header("Location: ../index.php");
            die;
        }
    } else {
        //otherwise email or password is wrong, show error message
        header("Location: ../login.php?error=invalid_email_or_password");
        die;
    }
}

//this function is used for user to update their user profile, password verify required
function update()
{
    require_once 'connection.php';

    //verify the password submitted from form at the first
    if (verify_password($_SESSION['session_user'], $_POST['password'])) {
        //query to get all columns for current user by session user id
        $query = $mysqli->prepare("SELECT * FROM users WHERE UserID = ?");
        $query->bind_param('i', $_SESSION['session_user_id']);
        $query->execute();
        $row = $query->get_result()->fetch_array(MYSQLI_NUM);

        /*create a complete form array of the current user, assign data from submitted form to the array,
        if there is no data from submitted form, use the data from database to ensure all array element
        is not NULL or empty*/
        $form = array(
            $row[0],
            !empty($_POST['first_name']) ? trim($_POST['first_name']) : $row[1],
            !empty($_POST['last_name']) ? trim($_POST['last_name']) : $row[2],
            !empty($_POST['account_name']) ? trim($_POST['account_name']) : $row[3],
            !empty($_POST['email']) ? trim($_POST['email']) : $row[4],
            !empty($_POST['new_password']) ? trim($_POST['new_password']) : $row[5],
            !empty($_POST['phone']) ? $_POST['phone'] : $row[6],
            !empty($_POST['address']) ? trim($_POST['address']) : $row[7],
            !empty($_POST['account_type']) ? $_POST['account_type'] : $row[8],
            !empty($_POST['abn']) ? $_POST['abn'] : $row[9]
        );

        //if email field request to update
        if (!empty($_POST['email'])) {
            //check if the email is already exitst in database
            if (check_duplication("Email", $_POST['email'])) {
                $page_result = "invalid_email";
            }
        }

        //if phone field request to update
        if (!empty($_POST['phone'])) {
            //check if the phone is already exitst in database
            if (check_duplication("Phone", $_POST['phone'])) {
                $page_result = "invalid_phone";
            }
        }

        //if new password or confirm password field is entered and submitted
        if (!empty($_POST['new_password']) || !empty($_POST['confirm_password'])) {
            //check these two value are same
            if ($_POST['new_password'] == $_POST['confirm_password']) {
                //encrypt the new password and ready to update database
                $form[5] = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
            } else {
                //return error type use to echo error message
                $page_result = "confirm_passwork_invalid";
            }
        }

        //only update submitted form data into database if there is no error
        if (empty($page_result)) {
            //query and update all column data by above completed form array
            $query = $mysqli->prepare("UPDATE users SET
            FirstName = ?,
            LastName = ?,
            AccountName = ?,
            Email = ?,
            Password = ?,
            Phone = ?,
            Address = ?,
            AccountType = ?,
            ABN = ?
            WHERE UserID = ?");
            $query->bind_param(
                'sssssssssi',
                $form[1],
                $form[2],
                $form[3],
                $form[4],
                $form[5],
                $form[6],
                $form[7],
                $form[8],
                $form[9],
                $_SESSION['session_user_id']
            );
            $query->execute();

            $page_result = "update_successful";
        }
    } else {
        $page_result = "password_incorrect";
    }

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
    $page_name = "Location: ../" . $page_name . "?result=" . $page_result;

    //jump to dashboard page depends the user type
    header($page_name);
    die;
}

//this function is used by manager to edit user profile, password not verify required
function edit()
{
    require_once 'connection.php';

    var_dump($_REQUEST);

    //query to get all columns for current user by session user id
    $query = $mysqli->prepare("SELECT * FROM users WHERE UserID = ?");
    $query->bind_param('i', $_POST['table_id']);
    $query->execute();
    $row = $query->get_result()->fetch_array(MYSQLI_NUM);

    /*create a complete form array of the current user, assign data from submitted form to the array,
    if there is no data from submitted form, use the data from database to ensure all array element
    is not NULL or empty*/
    $form = array(
        $row[0],
        !empty($_POST['first_name']) ? trim($_POST['first_name']) : $row[1],
        !empty($_POST['last_name']) ? trim($_POST['last_name']) : $row[2],
        !empty($_POST['account_name']) ? trim($_POST['account_name']) : $row[3],
        !empty($_POST['email']) ? trim($_POST['email']) : $row[4],
        !empty($_POST['new_password']) ? password_hash(trim($_POST['new_password']), PASSWORD_DEFAULT) : $row[5],
        !empty($_POST['phone']) ? $_POST['phone'] : $row[6],
        !empty($_POST['address']) ? trim($_POST['address']) : $row[7],
        !empty($_POST['account_type']) ? $_POST['account_type'] : $row[8],
        !empty($_POST['abn']) ? $_POST['abn'] : $row[9],
        !empty($_POST['total_rate']) ? $_POST['total_rate'] : $row[10],
        !empty($_POST['rate_number']) ? $_POST['rate_number'] : $row[11],
        !empty($_POST['account_state']) ? $_POST['account_state'] : $row[12]
    );

    var_dump($form);

    //if email field request to update
    if (!empty($_POST['email'])) {
        //only check duplication if submitted data not same as database stored
        if ($_POST['email'] != $row[4]) {
            //check if the email is already exitst in database
            if (check_duplication("Email", $_POST['email'])) {
                $page_result = "invalid_email";
            }
        }
    }

    //if phone field request to update
    if (!empty($_POST['phone'])) {
        //only check duplication if submitted data not same as database stored
        if ($_POST['phone'] != $row[6]) {
            //check if the phone is already exitst in database
            if (check_duplication("Phone", $_POST['phone'])) {
                $page_result = "invalid_phone";
            }
        }
    }

    //total rate must greater than 0, number of rate must greater equals than 1
    $form[10] = $form[10] < 0 ? 0 : $form[10];
    $form[11] = $form[11] < 0 ? 1 : $form[11];

    //only update submitted form data into database if there is no error
    if (empty($page_result)) {
        //query and update all column data by above completed form array
        $query = $mysqli->prepare("UPDATE users SET
        FirstName = ?,
        LastName = ?,
        AccountName = ?,
        Email = ?,
        Password = ?,
        Phone = ?,
        Address = ?,
        AccountType = ?,
        ABN = ?,
        TotalRate = ?,
        RateNumber = ?,
        AccountState = ?
        WHERE UserID = ?");
        $query->bind_param(
            'sssssssssiisi',
            $form[1],
            $form[2],
            $form[3],
            $form[4],
            $form[5],
            $form[6],
            $form[7],
            $form[8],
            $form[9],
            $form[10],
            $form[11],
            $form[12],
            $_POST['table_id']
        );
        $query->execute();

        $page_result = "user_update_successful";
    }
    header("Location: ../manager_dashboard.php?result=" . $page_result);
    die;
}

//this function is used by manager to delete the entire user
function delete()
{
    require_once 'connection.php';

    //get the user id that need to modify
    $user_id = intval($_POST['table_id']);

    //query to change state of the account of the user by userID
    $query = $mysqli->prepare("UPDATE users SET AccountState = 'banned' WHERE UserID = ?;");
    $query->bind_param('i', $user_id);
    $query->execute();

    //query to disable all accommodation made by this user
    $query = $mysqli->prepare("UPDATE accommodation SET State = 'onholding' WHERE OwnerID = ?;");
    $query->bind_param('i', $user_id);
    $query->execute();

    //jump back to dashboard and show succeeded message
    switch ($_SESSION['session_user_type']) {
        case "manager":
            header("Location: ../manager_dashboard.php?result=user_delete_succeeded");
            die;
            break;
    }
}

function check_duplication($key, $data)
{
    require 'connection.php';

    $result = false;

    //query from database of the provided data and key from parameter
    $query = $mysqli->prepare("SELECT * FROM users WHERE " . $key . " = ?");
    $query->bind_param('s', $data);
    $query->execute();
    $row = $query->get_result();

    //check if found any exists data from database
    if (mysqli_num_rows($row) > 0) {
        $result = true;
    }

    return $result;
}

function verify_password($email, $data)
{
    require 'connection.php';

    $result = false;

    //query all rows from database that email is same as the email subumitted from form
    $query = $mysqli->prepare("SELECT * FROM users WHERE email = ?");
    $query->bind_param('s', $email);
    $query->execute();
    $row = $query->get_result()->fetch_array(MYSQLI_ASSOC);

    //if there is any row in result, means there are atleast 1 row march with the email submitted from form
    if ($row != NULL) {
        //if the password stored still unencrypted
        if ($data == $row['Password']) {
            //store and has encrypt the password entered
            $hash = password_hash($data, PASSWORD_DEFAULT);

            //query and update the password in database to encrypt version
            $query = $mysqli->prepare("UPDATE users SET password = ? WHERE email = ?");
            $query->bind_param('ss', $hash, $email);
            $query->execute();

            //check the password if match to the email
            $result = password_verify($data, $hash);
        } else {
            //check the password if match to the email
            $result = password_verify($data, $row['Password']);
        }
    }

    return $result;
}

function get_data($data_name)
{
    require 'connection.php';

    //query all rows from database for current session user
    $query = $mysqli->prepare("SELECT * FROM users WHERE email = ?");
    $query->bind_param('s', $_SESSION['session_user']);
    $query->execute();
    $row = $query->get_result()->fetch_array(MYSQLI_ASSOC);

    //return the data requested by parameter
    return $row[$data_name];
}
