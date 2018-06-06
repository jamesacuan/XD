<?php
include_once "config/core.php";
include_once "config/database.php";
include_once "objects/purchase_order.php";

$database = new Database();
$db = $database->getConnection();

$purchase_order = new PurchaseOrder($db);

$page_title="Purchase Orders";

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
        <table id="purchaseorders" class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th class="col-xs-1">PO</th>
                        <th class="col-xs-4">By</th>
                        <th class="col-xs-4">Date</th>
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
                        echo "<tr>";
                        echo "<td>{$id}</td>";
                        echo "<td>{$nickname}</td>";
                        $date_created = date_format(date_create($created),"m/d/Y");
                        $diff = (new DateTime($date_today))->diff(new DateTime($date_created));
                        echo "<td><span class=\"dtime\"  data-toggle=\"tooltip\" title=\"" . date_format(date_create($created),"F d, Y h:i:s A") . "\">" . date_format(date_create($created),"m-d-Y h:i:s A") . "</span>";
                        if(($diff->d)>4 && $status!="Denied"){
                            echo " <span class=\"label label-danger\">Overdue</span>";
                        }else if(($diff->d)<2){
                            echo " <span class=\"label label-primary\">New</span>";
                        }
                        echo "</td>";
                        echo "<td>{$status}</td>";
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
<?php include 'template/footer.php'?>