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

include_once "login_check.php";
include 'template/header.php'
?>

<div class="container">
<div class="row">
    <div class="col-md-3">
        <div class="thumbnail panel panel-default">
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
            $stmt = $product->readItems();
            $num  = $stmt->rowCount();
            $temp=0;

            if($num>0){
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    extract($row);
                    echo "<div class=\"col-sm-6 col-md-4\">";
                    echo "<div class=\"thumbnail\">";    
                    echo  "<img src=\"{$home_url}images/{$image_url}\">";
                    echo  "<div class=\"caption\">";
                    echo    "<h3>{$name}</h3>";
                    echo    "<p>...</p>";
                    //echo   "<p><a href=\"#\" class=\"btn btn-primary\" role=\"button\">Button</a>";
                    echo  "</div>";
                    echo "</div>";
                    echo "</div>";
                }
            }
    ?>
    </div>
    </div>
</div>
</div>