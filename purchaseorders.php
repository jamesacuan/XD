<?php
include_once "config/core.php";
include_once "config/database.php";
include_once "objects/purchase_order.php";

$database = new Database();
$db = $database->getConnection();

$purchase_order = new PurchaseOrder($db);

$page_title="Purchase Orders";
$role = $_SESSION['role'];

$require_login=true;
include_once "functions/login_check.php";
include 'template/header.php'
?>

<div class="row xd-heading">
    <div class="clearfix">
        <div class="page-header pull-left">
            <h1><?php echo isset($page_title) ? $page_title : "Index"; ?></h1>
        </div>
        <div class="btn-group pull-right">
            <?php if($_SESSION['role']=="user")
                echo "<button type=\"button\" onclick=\"location.href='addpurchaseorder.php'\" class=\"btn btn-primary pull-right\">+ Purchase Order</button>";
            ?>
        </div>
    </div>
</div>

<div class="row xd-content">
    
    <div class="col-md-12">
    <div class="row form-inline clearfix" style="border-bottom:1px solid #ddd; padding: 10px 0;z-index:999;background-color:#fff;" data-spy="affi" data-offset-top="250">
          <div class="pull-left">  
            
                <?php 
                if($role=='hans' || $role=='designer'){
                    echo "<button name=\"submit\" value=\"accept\" class=\"btn btn-default\"><span class=\"glyphicon glyphicon-ok\"></span> Accept Request</button>";
                }
                else if($role=="user"){
                    echo "<button type=\"button\" onclick=\"location.href='addjoborder.php'\" class=\"btn btn-primary\"><span class=\"glyphicon glyphicon-plus\"></span> Create</button>";
                }
                
                ?>
            </div>
            <!--
            <div class="dropdown pull-left">
                <button class="btn btn-default" id="dLabel" type="button" data-toggle="dropdown">
                    Filter <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                    <li><a><label><input type="checkbox" name="filterme" id="filterme"/> By me</a></label></li>
                    <li><a><label><input type="checkbox" name="filterpublish" id="filterpublish"/> Show Published</a></label></li>
                    <li role="separator" class="divider"></li>
                    <li><a href="#" onclick="window.print();">Print...</a></li>
                    <li><a href="objects/functions/export.php">Export to Excel...</a></li>
                </ul>
            </div>
            -->
            <div class="pull-right">
                <label><input type="checkbox" name="filterme" id="filterme"/> By me</a></label>
                <label><input type="checkbox" name="filterpublish" id="filterpublish"/> Show Published</a></label>
                <input type="search" id="search" placeholder="search" class="form-control input-sm" />

                <!--<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="glyphicon glyphicon-option-vertical"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu">
                    <li><a href="#" onclick="window.print();">Print...</a></li>
                    <li><a href="objects/functions/export.php">Export to Excel...</a></li>
                </ul>
                -->
            </div>
          </div>
        <table id="purchaseorders" class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th class="col-xs-1"><input type="checkbox" /></th>
                        <th class="col-xs-1">PO</th>
                        <th class="col-xs-4">By</th>
                        <th class="col-xs-3">Date</th>
                        <th class="col-xs-2">Status</th>
                        <th class="col-xs-1">Action</th>
                    </tr>
                </thead>
                <tbody> 
                <?php
                $stmt = $purchase_order->read();
                $num  = $stmt->rowCount();
                $date_today   = date("m/d/Y");
                
                if($num>0){
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        extract($row);
                        echo "<tr ";
                        if($status=='paid')
                            echo "data-status='Done'";
                        echo " >";
                        echo "<td><input type=\"checkbox\" />";
                        echo "<td>{$id}</td>";
                        echo "<td>{$nickname}</td>";
                        $date_created = date_format(date_create($created),"m/d/Y");
                        $diff = (new DateTime($date_today))->diff(new DateTime($date_created));
                        echo "<td><span class=\"dtime\"  data-toggle=\"tooltip\" title=\"" . date_format(date_create($created),"F d, Y h:i:s A") . "\">" . date_format(date_create($created),"m-d-Y h:i:s A") . "</span>";
                        if(($diff->d)>4 && ($status!="Denied" && $status != 'paid')){
                            echo " <span class=\"label label-danger\">Overdue</span>";
                        }else if(($diff->d)<2){
                            echo " <span class=\"label label-primary\">New</span>";
                        }
                        echo "</td>";

                        /* STATUS */
                        echo "<td><span class=\"label ";
                        if($status == 'New' || $status == 'On-queue') echo  'label-default">On-queue';
                        else if($status == 'paid') echo 'label-success">Done';
                        else echo 'label-primary">' . $status;
                        echo "</span></td>";
                        
                        echo "<td><a href=\"purchaseorder.php?&amp;id={$id}\" class=\"btn btn-xs btn-default\">View</a></td>";
                        echo "</tr>";
                    }
                }//
                ?>    
                </tbody>
            </table> 
        </div>
    </div>
</div>
</div>
<script src="js/script.js"></script>
<script src="js/purchaseorders.js"></script>
<?php include 'template/footer.php'?>