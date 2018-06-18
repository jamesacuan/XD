<?php
include('dbcon.php');

$query = "SELECT id, image_url FROM `product_item_variant` WHERE `product_itemid` = " . $_POST['name'];

$result = mysqli_query($connect, $query);

while($row = mysqli_fetch_array($result)){
    $output .= '<label><input type="radio" name="products" value="' . $row["id"] . '"><img src="' . $home_url . 'images/thumbs/' . $row["image_url"] . '" width="100" height="100" /></label>';
}

echo $output;
?>