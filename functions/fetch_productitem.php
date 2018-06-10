<?php
include('dbcon.php');

$query = "SELECT product_item_variant.id, type, name
FROM `product_item`
JOIN product_item_variant on product_item_variant.product_itemid = product_item.id
WHERE 
product_item.type = '" . $_POST["type"] . "'
AND product_item.isDeleted <> 'Y'
AND product_item_variant.isDeleted <> 'Y'
ORDER BY product_item.name ASC";

$result = mysqli_query($connect, $query);
$output .= '<option></option>';
while($row = mysqli_fetch_array($result)){
    $output .= '<option value="' . $row["id"] . '">'.$row["name"].'</option>';
}

echo $output;
?>