<?php
//fetch.php
include($home_url . "config/db_sqli.php");
echo $home_url . "config/db_sqli.php";
if(!empty($connect)) echo $connect;
else echo "ngeee";
$output = '';
$query = "SELECT * FROM `product_color` ORDER BY `name` ASC";

$result = mysqli_query($connect, $query);

$output .= "<option>" . $connect ."</option>";

while($row = mysqli_fetch_array($result)){
 $output .= '<option value="'.$row["id"].'">'.$row["name"].'</option>';
}
echo $output;
?>
