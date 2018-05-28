<?php
include_once "config/core.php";
include_once "config/database.php";
include_once "objects/purchase_order.php";

$database       = new Database();
$db             = $database->getConnection();
$purchase_order = new PurchaseOrder($db);

$require_login =true;
$role          = $_SESSION['role'];
$id = $_GET['id'];

$stmt = $purchase_order->readPOD($id);
$num  = $stmt->rowCount();

if($num>0){
    $page_title    = "Purchase Order #" . $id;
}
else{
    header("Location: {$home_url}404.php");
}

$jocount="";
$i = 1;
include_once "login_check.php";
include 'template/header.php';
?>

<div class="xd-snip">
    <ol class="breadcrumb">
        <li><a href="<?php echo $home_url ?>">Home</a></li>
        <li><a href="<?php echo $home_url . "purchaseorder.php?&amp;id=" . $id?>" class="active">Purchase Order #<?php echo $id?></a></li>
    </ol>
</div>

<div class="xd-content">
        <?php      
            /*$purchase_order->getJobOrderDetailsCount($id);
            $jocount = $job_order->answer;

            $job_order->readJO($id);
            */
            $purchase_order->readPOD($id);
        ?>
    <div class="row" style="margin: 20px 0">
        <div class="col-md-12">
            <div class="row">
                <div class="col-xs-12"><h2><?php echo $page_title ?></h2></div>
            </div>
            <div class="row">
                <div class="col-xs-3">Requested By:</div>
                <div class="col-xs-9"><?php echo $purchase_order->nickname?></div>
            </div>
            <div class="row">
                <div class="col-xs-3">Date added:</div>
                <div class="col-xs-9"><?php echo date_format(date_create($purchase_order->created),"F d, Y h:i A"); ?></div>
            </div>
        </div>
    </div>
<div class="row">
    <div class="col-md-12">
    <table id="purchaseorder" class="table table-hover table-bordered table-striped">
        <thead>
            <tr>
                <th class="col-xs-1">#</th>
                <th class="col-xs-5">Name</th>
                <th class="col-xs-2">Custom</th>
                <th class="col-xs-2">Color</th>
                <th class="col-xs-2">Quantity</th>
            </tr>
        </thead>
        <tbody>


    <?php       
        $stmt = $purchase_order->readPOItem($id);
        $num  = $stmt->rowCount();
        echo "<div class=\"panel-group\" id=\"accordion\" role=\"tablist\">";
        
        if($num>0){
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                extract($row);
                echo "<tr>";
                //echo "<td>{$i}</td>";

                if(strpos($image_url, "define") == true )
                    echo "<td><img src=\"{$home_url}images/def.png\" width=\"75\" height=\"75\" /></td>";
                else
                    echo "<td><img src=\"{$home_url}images/{$image_url}\" width=\"75\" height=\"75\" /></td>";
                echo "<td><b>";
                if($product == "HH") echo "Helmet Holder";
                else if($product == "TH") echo "Ticket Holder";
                echo " - {$type}</b>";
                echo "<p/>Note: {$note}</p></td>";
                echo "<td>";
                if(strpos($productname, "define") == true) echo "";
                else echo "{$productname} </td>";
                echo "<td>{$color}</td>";
                echo "<td>{$quantity}</td>";
                echo "</tr>";
                $i+=1;
                //echo $num;
            }
            
        }
        else{
            echo "<div class='alert alert-info'>No products found.</div>";
        }
        echo "</div>";

    ?>
        </div>
    </div>
</div>
