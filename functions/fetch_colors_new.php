<?php
include('dbcon.php');
$query = "SELECT * FROM `product_color` ORDER BY `name` ASC";

$result = mysqli_query($connect, $query);

while($row = mysqli_fetch_array($result)){
    $output .= "<div class=\"row\">";
        $output .= "<div class=\"col-md-2\">";
        $output .= "<img src=\"{$home_url}images/def.png\" id=\"img" . $row["id"] . "\" width=100 height=100 />";
        $output .= "</div>";

        $output .= "<div class=\"col-md-10\">";
        $output .= "Color: " . $row["name"] . "<input type='file' onchange=\"readURL(this);\" value=\"" . $row["id"] . "\" name=\"image\" />";
        $output .= "</div>";
        
    $output .= "</div>";

    if($_POST['type']=='TH' && $row["name"]=="black"){
        break;
    }
}

echo $output;
?>
