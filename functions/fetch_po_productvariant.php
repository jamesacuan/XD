<?php
include('dbcon.php');

$query = "SELECT * FROM `product_item_variant` WHERE `product_itemid` = " . $_POST['name'];

$result = mysqli_query($connect, $query);

while($row = mysqli_fetch_array($result)){
    $output .= '<option value="' . $row["id"] . '"><img src={$home_url}thumbs/"' . $row["image_url"] . ' width=50 height=50 /></option>';
}

echo $output;
?>