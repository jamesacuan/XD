<?php
if($_POST){
    if($_POST['form']=="publishnew" && $_POST){
        $product->producttype     = $job_order->type;
        $product->productname     = $_POST['productname'];
        $product->productcategory = $_POST['tag'];        
        $product->note            = $_POST['note'];
        $product->userid          = $_SESSION['userid'];
        $product->setProductItem();

        $productitemid = $product->getProductItemCount();

        $product->image_url          = $_POST['image'];
        $product->code               = $itemcode;
        $product->product_colorid    = $_POST['color'];
        $product->product_itemid     = $productitemid;
        $product->joborderdetailsid  = $jodid;
        $product->setProductItemVariant();

        $job_order->tag    = "";
        $job_order->status = "Published";
        $job_order->userid = $_SESSION['userid'];
        $job_order->code   = $itemcode;
        $job_order->setTag();
        $job_order->setStatus();

        $_SESSION['modal'] = $_POST['productname'] . "has been successfully added.";

        header("Location: {$home_url}products.php");

    }


    if($_POST['form']=="publishexisting" && $_POST){
        echo $product->image_url          = $_POST['image'];
        echo $product->code               = $itemcode;
        echo $product->product_colorid    = $_POST['color'];
        echo $product->product_itemid     = $_POST['productname'];
        echo $product->jodid           = $jodid;
        echo $product->userid          = $_SESSION['userid'];
        $product->note                 = $_POST['note'];

        $product->setProductItemVariant();

        echo $job_order->tag    = "";
        echo $job_order->status = "Published";
        echo $job_order->userid = $_SESSION['userid'];
        echo $job_order->code   = $itemcode;
        $job_order->setTag();
        $job_order->setStatus();

        $_SESSION['modal'] = $_POST['productname'] . "has been successfully added.";

        header("Location: {$home_url}products.php");

    }
}
?>