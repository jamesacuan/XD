<?php
include_once "login_check.php";
$require_login=true;

include_once "config/core.php";
include_once "config/database.php";
include_once "objects/job_order.php";

$database = new Database();
$db = $database->getConnection();

$job_order = new JobOrder($db);
$page_title="Create Job Order";

include 'template/header.php';
?>

<?php
if($_POST){
    $job_order->type = $_POST['type'];

    if($job_order->create()){
        echo "<div class='alert alert-success'>Job Order was created.</div>";        
    }
    else{
        echo "<div class='alert alert-danger'>Unable to create product.</div>";
    }
}
?>

