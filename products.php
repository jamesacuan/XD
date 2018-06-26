<?php
include_once "config/core.php";
include_once "config/database.php";
include_once "objects/product.php";

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);

$page_title= "Products";

$require_login=true;
$page_ribbon="F";
$page_url = "products.php?";
include_once "functions/login_check.php";
include 'template/header.php'
?>

<div class="container">
<div class="row">
    <div class="col-md-3">
        <div class="thumbnail panel panel-default xd-products-info data-spy="affix" data-offset-top="60" data-offset-bottom="200"">
            <div class="caption">
                <span><?php echo $product->getItemCount('')?></span>
                <h3>Products</h3>
            </div>
            <ul class="list-group">
                <li class="list-group-item">Helmet Holder <span><?php echo $product->getItemCount('HH')?></span></li>
                <li class="list-group-item">Ticket Holder <span><?php echo $product->getItemCount('TH')?></span></li>
            </ul>
        </div>
    </div>
    <div class="col-md-9">
    <div class="row">
    <?php      
            $total_rows = $product->getProductItemsCount();
            $stmt = $product->readProductItems($from_record_num, $records_per_page);
            $num  = $stmt->rowCount();
            
            $temp=0;

            if($num>0){
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    extract($row);
                    echo "<div class=\"col-sm-6 col-md-3\">";
                    echo "<div class=\"thumbnail  xd-product-thumbnail\">";
                    if($image_url=="none") echo  "<img src=\"{$home_url}assets/images/def.png\">";
                    else   echo  "<img src=\"{$home_url}images/{$image_url}\">";
                        echo  "<div class=\"caption\">";
                        if($type=="HH"){
                            echo "<h4>{$name} ({$color})</h4>";
                        }
                        else if($type=='TH')
                            echo    "<h4>{$name}</h4>";
                        echo    "<p>";
                            if($type=="HH") echo "Helmet Holder";
                            else if($type=='TH') echo "Ticket Holder";
                        echo "</p>";
                        echo "<button class=\"btn btn-default glyphicon glyphicon-shopping-cart\"></button>";
                        echo  "</div>";
                    echo "</div>";
                    echo "</div>";
                }
                echo "<div class=\"row\">";
                echo "<div class=\"col-sm-12\">";
                include 'template/paging.php';
                echo "</div></div>";
            }
    ?>
    </div>
    </div>
</div>
</div>
<?php include_once "template/footer.php" ?>