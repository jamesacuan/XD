<?php
//fetch.php
//if(!empty($connect)) echo $connect;
//else echo "ngeee";
//$connect = mysqli_connect("localhost", "root", "", "xd");
//$output = '';
$query = "SELECT * FROM `product_color` ORDER BY `name` ASC";

$result = mysqli_query($connect, $query);

//$output .= "<option>" . $connect ."</option>";

while($row = mysqli_fetch_array($result)){
 $output .= '<option value="'.$row["id"].'">'.$row["name"].'</option>';
}
echo "<option> tteset'</option>";
?>
