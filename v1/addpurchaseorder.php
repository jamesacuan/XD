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

<div class="container">
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
    <h1>test</h1>
    <div class="form-group">
    
    </div>
</form>
</div>

<?php 
include 'template/footer.php';
?>