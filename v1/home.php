<?php
include_once "config/core.php";
include_once "config/database.php";
include_once "objects/job_order.php";

$database = new Database();
$db = $database->getConnection();

$job_order = new JobOrder($db);
$page_title= "Dashboard";

$require_login=true;

$today     = date("m/d/Y");
$yesterday = date("m/d/Y", strtotime($today . ' -1 days'));

include_once "login_check.php";
include 'template/2header.php'
?>

