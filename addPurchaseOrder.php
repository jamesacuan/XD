<?php
include_once "login_check.php";
$require_login=true;

include_once "config/core.php";
include_once "config/database.php";
include_once "objects/purchase_order.php";

$database = new Database();
$db = $database->getConnection();

$job_order = new PurchaseOrder($db);
$page_title="Create New Purchase Order";

include 'template/header.php';
?>
