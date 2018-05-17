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
<div class="row xd-heading">
    <div class="clearfix">
        <div class="page-header pull-left">
            <h1><?php echo isset($page_title) ? $page_title : "Index"; ?></h1>
        </div>
    </div>
</div>

<div class="row xd-content">
<div align="right" style="margin-bottom:5px;">
    <button type="button" name="add" id="add_item" class="btn btn-success">Add Item</button>
   </div>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" id="purchase_order">
<!--
    <div class="form-group" id="po_table">
       
    </div>
-->
    <table class="table table-hover table-bordered table-striped">
        <thead>
            <tr>
                <th class="col-xs-1">Item</th>
                <th class="col-xs-5">Product</th>
                <th class="col-xs-2">Color</th>
                <th class="col-xs-1">Qty</th>
                <th class="col-xs-3">Actions</th>
            </tr>
        </thead>
        <tbody id="po_table">      
        </tbody>
    </table> 
    <div>
     <input type="submit" name="insert" id="insert" class="btn btn-primary" value="Save" />
    </div>
</form>
</div>

<!-- dialog -->
<div id="item_dialog" title="Add Data">
   <p class="bg-danger" id="dialog_warn"></p>
   <div class="form-group" id="item_product">
       <label>Product</label>
       <div class="radio">
            <label for="HH" class="radio-inline">
                <input type="radio" value="HH" name="product" id="HH">Helmet Holder
            </label>
            <label for="TH" class="radio-inline">
                <input type="radio" value="TH" name="product" id="TH">Ticket Holder
            </label>
        </div>
    </div>
   <div class="form-group" id="item_type">
        <label>Type</label>
        <div class="radio">
            <label for="pln">
                <input type="radio" value="plain" name="type" id="pln">Plain
            </label>
            <label for="csm">
                <input type="radio" value="custom" name="type" id="csm">Custom
            </label>
        </div>
   </div>
   <div class="form-group" id="item_color">
       <label>Color</label>
       <select class="form-control input-sm" name="color" id="colors"></select>
   </div>
   <div class="form-group" id="item_custom">
       <label>Custom Logo</label>
       <select class="form-control input-sm" name="custom" id="custom"></select>
   </div>
   <div class="form-group" id="item_quantity">
    <label>Quantity</label>
    <input type="number" name="quantity" class="form-control" />
   </div>
   <div class="form-group" id="item_note">
    <label>Note</label>
    <textarea name="note" class="form-control" maxlength="100"> </textarea>
   </div>
   <div class="form-group" align="center">
    <input type="hidden" name="row_id" id="hidden_row_id" />
    <button type="button" name="save" id="save" class="btn btn-info">Save</button>
   </div>
  </div>

  <div id="action_alert" title="Action">

</div>
<script src="js/po_script.js"></script>
<?php 
include 'template/footer.php';
?>