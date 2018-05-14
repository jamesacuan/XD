<?php
include_once "config/core.php";
include_once "config/database.php";
include_once "objects/job_order.php";


$database = new Database();
$db = $database->getConnection();
$type = "";
$job_order = new JobOrder($db);

$page_title="Job Orders";
$require_login=true;
$role = $_SESSION['role'];

include_once "template/login_check.php";
include 'template/header.php';

if(($role=="admin" || $role=="superadmin" || $role=="hans") && isset($_GET['status'])){
    $id = $_GET['id'];
    if(isset($_GET['status'])){
        $job_order->joborderdetailsid = $id;
        if($_GET['status'] == 'Deny')
            $job_order->status = "Denied";
        elseif($_GET['status'] == 'Approve')
            $job_order->status = "Approved";
        else
            $job_order->status = $_GET['status'];
        $job_order->approve();
    }
}

elseif($role=="user" && isset($_GET['delete']) || ($role=="superadmin" && isset($_GET['delete']))){
    $id = $_GET['id'];
    if(isset($_GET['delete'])){
        $job_order->joborderdetailsid = $id;
        $job_order->status = 'Y';
        $job_order->delete();
    }
    $current_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $current_url = explode('?', $current_url);
    header("Location: {$current_url[0]}");
}

else{
    if (!isset($_GET['type']))
        $type = "";

    else {
        if(strtolower($_GET['type'])=='hh') $type="HH";
        elseif(strtolower($_GET['type'])=='th') $type="TH";
        else $type="";
    }
}
?>

<!--*START OF BODY-->
<div class="xd-ribbon"></div>
<div class="xd-main">
    <div class="xd-wrapper">
        <div class="container">
            <div class="">
                <?php if($_SESSION['role']=="user")
                    echo "<button type=\"button\" onclick=\"location.href='addjoboorder.php'\" class=\"btn btn-primary\">+ Job Order</button>";
                ?>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table id="purchaseorders" class="mdl-data-table mdl-js-data-table mdl-data-table--selectable mdl-shadow--2dp">
                            <thead>
                                <tr>
                                    <th class="mdl-data-table__cell--non-numeric">JO</th>
                                    <th class="mdl-data-table__cell--non-numeric">Code</th>
                                    <th class="mdl-data-table__cell--non-numeric">By</th>
                                    <th class="mdl-data-table__cell--non-numeric">Note</th>
                                    <th class="mdl-data-table__cell--non-numeric">Date</th>
                                    <th class="mdl-data-table__cell--non-numeric">Status</th>
                                    <th class="mdl-data-table__cell--non-numeric">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php       
                $stmt = $job_order->read($type);
                $num  = $stmt->rowCount();
                $date_today   = date("m/d/Y");

                if($num>0){
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        extract($row);
                        echo "<tr>";
                            $date_created = date_format(date_create($created),"m/d/Y");
                            if($date_today == $date_created) $date_created = date_format(date_create($created),"h:i A");
                            else $date_created = date_format(date_create($created),"F d");;

                            echo "<th scope=\"row\"><a href=\"joborder.php?&amp;id={$JOID}\">{$JOID}</a></th>";
                            echo "<td><a href=\"joborderitem.php?&amp;code={$code}\">{$code}</a></td>";
                            echo "<td>{$username}</td>";
                            echo "<td class=\"clearfix\"><span>{$note}</span><span class=\"glyphicon glyphicon-picture pull-right\" data-toggle=\"modal\" data-target=\"#image\" data-file=\"{$image_url}\" title=\"{$image_url}\"></span></td>";
                            echo "<td><span title=\"" . date_format(date_create($created),"F d, Y h:i:s A") . "\">{$date_created}</span></td>";
                            //<span class=\"dtime\">" . date_format(date_create($modified),"m-d-Y") . "</span>
                            echo "<td><span class=\"label ";
                                if     ($status=="For Approval") echo "label-primary";
                                elseif ($status=="Approved") echo "label-success";
                                elseif ($status=="Denied") echo "label-danger";
                                else   echo "label-default";
                            echo "\">{$status}</span></div>";
                            echo "<td>";
                            ?>
                            <?php
                                echo "<a href=\"joborderitem.php?&amp;code={$code}\" class=\"btn btn-xs btn-default\">View</a>";
                                if(($role=="hans" || $role=="admin" || $role=="superadmin") && $status=="For Approval"){
                                    echo "<a href=\"" . $home_url . "joborders.php?id={$JODID}&amp;status=Approve\" class=\"btn btn-xs btn-default\">Approve</a>";
                                    echo "<a href=\"" . $home_url . "joborders.php?id={$JODID}&amp;status=Deny\" class=\"btn btn-xs btn-default\">Deny</a>";
                                }
                                if(($status=="For Approval" && $role=="user" && $_SESSION['username']==$username) || ($status=="For Approval" && $role=="superadmin")){
                                    echo "<a href=\"#\" class=\"btn btn-xs btn-default\" data-id={$JODID} data-toggle=\"modal\" data-target=\"#warn\">Delete</a>";
                                }
                                ?>
                            <?php
                            echo "</td>";
                        echo "</tr>";
                    }
                }
                else{
                   // echo "<div class='alert alert-info'>No products found.</div>";
                }
            ?>
                            </tbody>
                        </table> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="js/script.js"></script>