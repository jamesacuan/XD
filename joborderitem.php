<?php
include_once "config/core.php";
include_once "config/database.php";
include_once "objects/job_order.php";

$database = new Database();
$db = $database->getConnection();

$job_order = new JobOrder($db);

$page_title="Job Order Item: " . $_GET['code'];

$job_order->code=$_GET['code'];
$job_order->getJOItem();
$require_login=true;

include_once "login_check.php";
include 'template/header.php';
?>

<div class="row">
  <div class="col-md-6">
    <div class="row">
        <div class="col-xs-6">From Job Order</div>
        <div class="col-xs-6"><?php echo $job_order->joborderid?></div>
    </div>
    <div class="row">
        <div class="col-xs-6">By:</div>
        <div class="col-xs-6"><?php echo $job_order->username?></div>
    </div>
    <div class="row">
        <div class="col-xs-6">Date added:</div>
        <div class="col-xs-6"><?php echo $job_order->modified?></div>
    </div>
  </div>
  <div class="col-md-6">
  <?php
    if ($job_order->username==$_SESSION['username'] && $job_order->status=='For Approval'){
        echo "<a href=\"#\" class=\"btn btn-danger\">Delete</a>";
    }
    if($job_order->status=='For Approval' && $_SESSION['role']=='admin'){
        echo "<a href=\"#\" class=\"btn btn-primary\">Approve</a>";
    }
   ?>
   </div>
</div>

<div class="md-stepper-horizontal">
    <div class="md-step active">
      <div class="md-step-circle"><span>1</span></div>
      <div class="md-step-title">Request</div>
      <div class="md-step-bar-left"></div>
      <div class="md-step-bar-right"></div>
    </div>
    <div class="md-step inactive">
      <div class="md-step-circle"><span>2</span></div>
      <div class="md-step-title">Proposal</div>
      <!--<div class="md-step-optional">Rendered Image</div>-->
      <div class="md-step-bar-left"></div>
      <div class="md-step-bar-right"></div>
    </div>
    <div class="md-step inactive">
      <div class="md-step-circle"><span>3</span></div>
      <div class="md-step-title">Launch</div>
      <div class="md-step-bar-left"></div>
      <div class="md-step-bar-right"></div>
    </div>

  </div>

<h3>Comments</h3>

<?php
include 'template/footer.php';
?>