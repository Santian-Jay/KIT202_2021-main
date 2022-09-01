<?php
include 'session.php';

if (!isset($_REQUEST['submit_form'])) {
    return;
} else {
    //depends the action field data to determine function to go
    switch ($_REQUEST['action']) {
        case "add":
            add();
            break;
        case "delete":
            delete();
            break;
        case "edit":
            edit();
            break;
    }
}

function add()
{
    require_once 'connection.php';

    //use the largest id number plus one as new id number for this new accommodation
    $query = "SELECT MAX(AccommodationID) FROM accommodation";
    $result = $mysqli->query($query);
    $row = mysqli_fetch_array($result);
    $accommodation_id = $row[0] + 1;

    //data from submitted form
    $house_name = trim($_POST['house_name']);
    $postage_address = trim($_POST['postage_address']);
    $city = trim($_POST['city']);
    $description = trim($_POST['description']);
    $price = intval($_POST['price']);
    $bedroom_number = intval($_POST['bedroom_number']);
    $bathroom_number = intval($_POST['bathroom_number']);
    $check_in_date = $_POST['check_in_date'];
    $check_out_date = $_POST['check_out_date'];
    $garage_available = $_POST['garage_available'] == "yes" ? 1 : 0;
    $smoke_allowabillity = $_POST['smoke_allowabillity'] == "yes" ? 1 : 0;
    $pet_allowabillity = $_POST['pet_allowabillity'] == "yes" ? 1 : 0;
    $internet_provision = $_POST['internet_provision'] == "yes" ? 1 : 0;
    $max_accommodate = intval($_POST['max_accommodate']);
    $state = "awaiting";
    $image_address = !isset($_POST['image_address']) ? $_POST['image_address'] : NULL;

    //query to store data collected from submitted form into database
    $query = $mysqli->prepare(
        "INSERT INTO accommodation (
        AccommodationID,
        AccommodationName,
        Address,
        City,
        Description,
        Price,
        BedroomNumber,
        BathroomNumber,
        CheckInDate,
        CheckOutDate,
        Garage,
        Smoking,
        Pet,
        Internet,
        MaxAccommodate,
        State,
        Photo,
        OwnerID)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
    );
    $query->bind_param(
        "issssiiissiiiiissi",
        $accommodation_id,
        $house_name,
        $postage_address,
        $city,
        $description,
        $price,
        $bedroom_number,
        $bathroom_number,
        $check_in_date,
        $check_out_date,
        $garage_available,
        $smoke_allowabillity,
        $pet_allowabillity,
        $internet_provision,
        $max_accommodate,
        $state,
        $image_address,
        $_SESSION['session_user_id']
    );
    $query->execute();

    //jump back to dashboard and show succeeded message
    header("Location: ../host_dashboard.php?result=add_succeeded");
    die;
}

function delete()
{
    require_once 'connection.php';

    //get the accommodation id that need to modify
    $accommodation_id = intval($_POST['table_id']);

    //query to delete the row with that accommodation id
    $query = $mysqli->prepare("DELETE FROM accommodation WHERE AccommodationID = ?;");
    $query->bind_param('i', $accommodation_id);
    $query->execute();

    //jump back to dashboard and show succeeded message depends user type
    switch ($_SESSION['session_user_type']) {
        case "host":
            header("Location: ../host_dashboard.php?result=delete_succeeded");
            die;
            break;
        case "manager":
            header("Location: ../manager_dashboard.php?result=accommodation_delete_succeeded");
            die;
            break;
    }
}

function edit()
{
    require_once 'connection.php';

    //get the accommodation id that need to modify
    $accommodation_id = intval($_POST['table_id']);

    //query the selected accommodation by id to modify
    $query = $mysqli->prepare("SELECT * FROM accommodation WHERE AccommodationID = ?");
    $query->bind_param('i', $accommodation_id);
    $query->execute();
    $row = $query->get_result()->fetch_array(MYSQLI_NUM);

    //data from submitted form, form to a new array depends if the data is exist
    $form = array(
        $row[0],
        !empty($_POST['house_name']) ? trim($_POST['house_name']) : $row[1],
        !empty($_POST['postage_address']) ? trim($_POST['postage_address']) : $row[2],
        !empty($_POST['city']) ? trim($_POST['city']) : $row[3],
        !empty($_POST['description']) ? trim($_POST['description']) : $row[4],
        !empty($_POST['price']) ? intval($_POST['price']) : $row[5],
        !empty($_POST['bedroom_number']) ? intval($_POST['bedroom_number']) : $row[6],
        !empty($_POST['bathroom_number']) ? intval($_POST['bathroom_number']) : $row[7],
        !empty($_POST['check_in_date']) ? $_POST['check_in_date'] : $row[8],
        !empty($_POST['check_out_date']) ? $_POST['check_out_date'] : $row[9],
        !empty($_POST['garage_available']) ? $_POST['garage_available'] : $row[10],
        !empty($_POST['smoke_allowabillity']) ? $_POST['smoke_allowabillity'] : $row[11],
        !empty($_POST['pet_allowabillity']) ? $_POST['pet_allowabillity'] : $row[12],
        !empty($_POST['internet_provision']) ? $_POST['internet_provision'] : $row[13],
        !empty($_POST['max_accommodate']) ? intval($_POST['max_accommodate']) : $row[14],
        !empty($_POST['accommodation_state']) ? $_POST['accommodation_state'] : $row[15],
        !empty($_POST['image_address']) ? $_POST['image_address'] : $row[16],
        !empty($_POST['owner_id']) ? $_POST['owner_id'] : $row[17],
        !empty($_POST['stayer_id']) ? $_POST['stayer_id'] : $row[18]
    );

    //convert string data to 1 and 0 prepare to store in database
    if (gettype($form[10]) == "string") {
        $form[10] == "yes" ? $form[10] = 1 : $form[10] = 0;
    }
    if (gettype($form[11]) == "string") {
        $form[11] == "yes" ? $form[11] = 1 : $form[11] = 0;
    }
    if (gettype($form[12]) == "string") {
        $form[12] == "yes" ? $form[12] = 1 : $form[12] = 0;
    }
    if (gettype($form[13]) == "string") {
        $form[13] == "yes" ? $form[13] = 1 : $form[13] = 0;
    }

    //query to update data collected from submitted form into database
    $query =  $mysqli->prepare("UPDATE accommodation SET
    AccommodationName = ?,
    Address = ?,
    City = ?,
    Description = ?,
    Price = ?,
    BedroomNumber = ?,
    BathroomNumber = ?,
    CheckInDate = ?,
    CheckOutDate = ?,
    Garage = ?,
    Smoking = ?,
    Pet = ?,
    Internet = ?,
    MaxAccommodate = ?,
    State = ?,
    Photo = ?
    WHERE AccommodationID = ?"
    );
    $query->bind_param(
        'ssssiiissiiiiissi',
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
        $form[13],
        $form[14],
        $form[15],
        $form[16],
        $accommodation_id
    );
    $query->execute();

    //only update ownerID and stayerID if currently login as manager
    if ($_SESSION['session_user_type'] == "manager") {
        $query = $mysqli->prepare("UPDATE accommodation SET OwnerID = ?, StayerID = ? WHERE AccommodationID = ?");
        $query->bind_param('iii', $form[17], $form[18], $accommodation_id);
        $query->execute();
    }

    //jump back to dashboard and show succeeded message depends user type
    switch ($_SESSION['session_user_type']) {
        case "client":
            break;
        case "host":
            header("Location: ../host_dashboard.php?result=update_succeeded");
            die;
            break;
        case "manager":
            header("Location: ../manager_dashboard.php?result=accommodation_update_succeeded");
            die;
            break;
    }
}
