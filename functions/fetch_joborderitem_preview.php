<?php
include('dbcon.php');

$query = "SELECT job_order_details.`image_url`, job_order_details.code, job_order_details.note,
job_order_details.type, s1.status, users.nickname, job_order_details.created, job_order.id
FROM job_order_details
JOIN job_order ON job_order_details.job_orderid = job_order.id
JOIN users ON users.userid = job_order.userid
JOIN job_order_status s1 on s1.job_order_code = job_order_details.code
WHERE job_order_details.code = '" . $_POST['code'] . "'
AND s1.created = (SELECT MAX(s2.created)
                              FROM job_order_status s2
                              WHERE s2.job_order_code = s1.job_order_code)
LIMIT 1";

$result = mysqli_query($connect, $query);
while($row = mysqli_fetch_array($result)){
    $output .= "<div>";
    $output .= "<h3>" . $row["code"] . "</h3>";
    $output .= "<ul class=\"nav nav-tabs\">";
    $output .= "<li class=\"active\"><a data-toggle=\"tab\" href=\"#info\">Info</a></li>";
    $output .= "<li><a data-toggle=\"tab\" href=\"#discussion\">Discussion</a></li>";
    $output .= "</ul>";
    $output .= "<div class=\"tab-content\">";
    $output .= "<div id=\"info\" class=\"tab-pane fade in active\">";
    $output .= "<img data-toggle=\"modal\" data-target=\"#image\" data-file=\"" . $row["image_url"] . "\" src=\"{$home_url}images/" . $row["image_url"] . "\" alt=\"" . $row["code"] . "\"/>";
    $output .= "<dl class=\"dl-horizontal\">";
    if ($row["type"]=="HH") $type = "Helmet Holder";
    else $type = "Ticket Holder";
    $output .= "<dt>Type:</dt><dd>" . $type . "</dd>";
    $output .= "<dt>Code:</dt><dd>" . $row["code"] . "</dd>";
    $output .= "<dt>Note:</dt><dd>" . $row["note"] . "</dd>";
    $output .= "<dt>Status:</dt><dd>" . $row["status"] . "</dd>";
    $output .= "<dt>By:</dt><dd>" . $row["nickname"] . "</dd>";
    $output .= "<dt>Created:</dt><dd>" . date_format(date_create($row["created"]),"F d, Y h:i:s A") . "</dd>";
    $output .= "</dl>";
    $output .= "</div>"; //end of info
    $output .= "<div id=\"discussion\" class=\"tab-pane fade in\">";
    $output .= "<p>Hello</p>";
    $output .= "</div>"; //end of discussion
    $output .= "</div>"; //end of parent div
}

echo $output;

?>