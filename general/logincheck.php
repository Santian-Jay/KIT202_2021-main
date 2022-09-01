<?php
include 'session.php';

//Determine login or not
if ($_SESSION['session_user'] == "") {
    echo json_encode(array("success"=>false));  //return false if not login yet
}else
{
    echo json_encode(array("success"=>true));   //return true if already login
}
?>