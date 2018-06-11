<?php

session_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);

$servername = "localhost";
$username = "root";
$password = "root";
$database = "MYL";
// Create connection
$con = new mysqli($servername, $username, $password, $database);
$GLOBALS['conn'] = $con;
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
require_once "helper.php";
require_once "models.php";
if (array_key_exists('user_id', $_SESSION)) {
    $active_user = new User($_SESSION['user_id']);
}