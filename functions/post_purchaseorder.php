<?php
include_once "config/core.php";
include_once "config/database.php";
include_once "objects/purchase_order.php";

$database = new Database();
$db = $database->getConnection();

$purchase_order = new PurchaseOrder($db);

if($_POST){
    $userid   = $_SESSION['userid'];
    $product  = $_POST['product'];
    $type     = $_POST['type'];
    $color    = $_POST['color'];
    $custom   = $_POST['custom'];
    $quantity = $_POST['quantity'];
    $note     = $_POST['note'];
    
    $purchase_order->userid = $userid;
    $purchase_order->create();
    $poid    = $purchase_order->getLastPurchaseOrder();
    $purchase_order->purchase_orderid = $poid;

    foreach($product as $key => $n ) {
        print "The product is ".$n."<br>";
        print "&nbsp;&nbsp;&nbsp;&nbsp;product is ".$product[$key];
        print "&nbsp;&nbsp;&nbsp;&nbsp;custom is ".$custom[$key];
        print "<br>&nbsp;&nbsp;&nbsp;&nbsp;type is ".$type[$key];
        print "<br>&nbsp;&nbsp;&nbsp;&nbsp;color is ".$color[$key];
        print "<br>&nbsp;&nbsp;&nbsp;&nbsp;quantity is ".$quantity[$key];
        print "<br>&nbsp;&nbsp;&nbsp;&nbsp;note is ".$note[$key];
        print "<br><br><br>";
        $purchase_order->product  = $product[$key];
        $purchase_order->type     = $type[$key];
        if($custom[$key]=="undefined")
       print    $purchase_order->productitemid = 0;
       else
        print    $purchase_order->productitemid = $custom[$key];
        $purchase_order->quantity = $quantity[$key];
        $purchase_order->color    = $color[$key];
        $purchase_order->note     = $note[$key];
        $purchase_order->addItem();
    }

    $purchase_order->status = "New";
    $purchase_order->setStatus();
    $_SESSION['modal'] = "Successfully added Purchase order #" . $poid . ".";
    header("Location: {$home_url}purchaseorders.php");
}?>