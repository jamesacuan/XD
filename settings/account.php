<?php
include_once "../config/core.php";
include_once "../config/database.php";
include_once "../objects/user.php";

$require_login=true;
include_once "../functions/login_check.php";

$database = new Database();
$db = $database->getConnection();

$user = new User($db);
$page_title="Settings";
$page_ribbon="F";
$settings = "Y";
include '../template/header.php';
?>