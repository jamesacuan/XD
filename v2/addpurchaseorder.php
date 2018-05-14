<?php
include_once "template/login_check.php";
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
<div class="xd-ribbon"></div>
<div class="xd-main">
    
    <div class="xd-wrapper">
        <div class="xd-title"><h2>test</h2></div>
        <div class="container">
            test
        </div>
    </div>
</div>