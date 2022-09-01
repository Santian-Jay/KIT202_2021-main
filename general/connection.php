<?php
$serverName = "localhost";
$userName = "root";
$password = "";
$database = "utasabs";

//connection to mysql database
global $mysqli;
$mysqli = new mysqli($serverName, $userName, $password, $database);