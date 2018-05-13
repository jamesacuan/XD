<?php
include_once "config/core.php";
include_once "config/database.php";

$database = new Database();
$db = $database->getConnection();

$page_title= "Dashboard";

$require_login=true;

$today     = date("m/d/Y");
$yesterday = date("m/d/Y", strtotime($today . ' -1 days'));

include_once "template/login_check.php";
include 'template/header.php'
?>

