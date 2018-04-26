<?php
// core configuration
include_once "config/core.php";
include_once "config/database.php";
include_once "objects/job_order.php";

$database = new Database();
$db = $database->getConnection();

$job_order = new JobOrder($db);

$page_title="Purchase Orders";

$require_login=true;
include_once "login_check.php";
include 'template/header.php'
?>


<?php include 'template/footer.php'?>