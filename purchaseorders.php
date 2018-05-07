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
<div class="container">
    <div class="btn-group pull-right">
        <?php if($_SESSION['role']=="user")
            echo "<button type=\"button\" onclick=\"location.href='addpurchaseorder.php'\" class=\"btn btn-primary\">+ Purchase Order</button>";
        ?>
    </div>

<div class="row">
    <div class="col-md-12">
        <table id="purchaseorders" class="table table-hover table-bordered table-striped">
                <thead>
                    <tr>
                        <th class="col-xs-1">PO</th>
                        <th class="col-xs-3">By</th>
                        <th class="col-xs-3">Date</th>
                        <th class="col-xs-2">Status</th>
                        <th class="col-xs-3">Action</th>
                    </tr>
                </thead>
                <tbody>      
                </tbody>
            </table> 
        </div>
    </div>
</div>
</div>
<script src="js/script.js"></script>
<?php include 'template/footer.php'?>