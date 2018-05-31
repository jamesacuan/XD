<?php
include('dbcon.php');

$query = "SELECT * FROM `product_items` WHERE `type`= '" . $_POST["type"] ."' AND ( visibility = " . $_POST["id"] ." OR visibility = 0 ) ORDER BY name ASC";
//$query = "SELECT * FROM `product_items` WHERE `type`= '" . $_POST["type"] ."' ORDER BY name ASC";
$result = mysqli_query($connect, $query);

while($row = mysqli_fetch_array($result)){
    $output .= '<option value="'.$row["id"].'">'.$row["name"].'</option>';
}

echo $output;
//echo "<option>test</option>";
?>