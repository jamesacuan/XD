<?php
include('dbcon.php');

$query = "SELECT id, type, product_item.name
FROM `product_item`
WHERE 
product_item.type = '" . $_POST["type"] . "'";
if ($_POST["category"] == "plain")
    $query .= "AND product_item.category = '" . $_POST["category"] . "'";
else
    $query .= "AND product_item.category <> 'plain' ";

$query .= "AND product_item.isDeleted <> 'Y'
            ORDER BY product_item.name ASC";

$result = mysqli_query($connect, $query);
$output .= '<option></option>';
while($row = mysqli_fetch_array($result)){
    $output .= '<option value="' . $row["id"] . '">'.$row["name"].'</option>';
}

echo $output;
?>