<?php
include('dbcon.php');
$query = "SELECT product_color.id, product_color.name
        FROM product_color
        WHERE product_color.id <> (SELECT product_item_variant.product_colorid
                                FROM product_item_variant
                                WHERE product_item_variant.id = " . $_POST['id'] . ")
        ORDER BY product_color.name ASC";

$result = mysqli_query($connect, $query);

while($row = mysqli_fetch_array($result)){
    $output .= '<option value="'.$row["id"].'">'.$row["name"].'</option>';
}
echo $output;
?>
