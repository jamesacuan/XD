<?php
include_once "login_check.php";
$require_login=true;

include_once "config/core.php";
include_once "config/database.php";
include_once "objects/user.php";

$database = new Database();
$db = $database->getConnection();

$user = new User($db);
$page_title="Settings";

include 'template/header.php'
?>

<?php include 'template/footer.php' ?>