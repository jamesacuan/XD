<?php

include_once "config/core.php";
include_once "config/database.php";
include_once "objects/product.php";


$database = new Database();
$db = $database->getConnection();

$job_order  = new Product($db);
$page_title = "Add a Product";
$page_theme = "";

$require_login=true;
include_once "login_check.php";

include 'template/header.php';
?>

<div class="row xd-heading">
    <div class="clearfix">
        <div class="page-header pull-left">
            <h1><?php echo isset($page_title) ? $page_title : "Index"; ?></h1>
        </div>
    </div>
</div>

<div class="row xd-content">

</div>

<?php include 'template/footer.php'; ?>