<?php
session_start();

if (!isset($_SESSION['session_user_id']) || !isset($_SESSION['session_user']) || !isset($_SESSION['session_user_type'])) {
    $_SESSION['session_user_id'] = "";
    $_SESSION['session_user'] = "";
    $_SESSION['session_user_type'] = "";
}

$session_user_id = $_SESSION['session_user_id'];
$session_user = $_SESSION['session_user'];
$session_user_type = $_SESSION['session_user_type'];
