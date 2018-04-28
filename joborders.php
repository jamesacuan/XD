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

include_once "login_check.php";
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

<ul class="nav nav-tabs clearfix" role="tablist">
    <li role="presentation" <?php if($type=="") echo "class=\"active\"" ?>><a href="<?php echo $home_url ?>joborders.php">View All</a></li>
    <li role="presentation" <?php if($type=="HH") echo "class=\"active\"" ?>><a href="<?php echo $home_url ?>joborders.php?type=HH">Helmet Holder</a></li>
    <li role="presentation" <?php if($type=="TH") echo "class=\"active\"" ?>><a href="<?php echo $home_url ?>joborders.php?type=TH">Ticket Holder</a></li>
    <div class="btn-group pull-right">
        <button type="button" onclick="location.href='addjoborder.php'" class="btn btn-primary">+ Job Order</button>
    </div>
</ul>

  <div role="tabpanel" class="tab-pane active" id="home">
    <table id="joborders" class="table table-hover table-bordered table-striped">
            <thead>
                <tr>
                    <th class="col-xs-1">Job Order</th>
                    <th class="col-xs-1">Code</th>
                    <th class="col-xs-1">By</th>
                    <th class="col-xs-4">Note</th>
                    <th class="col-xs-2">Date</th>
                    <th class="col-xs-1">Status</th>
                    <th class="col-xs-2">Action</th>
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

                            echo "<th scope=\"row\"><a href=\"joborder.php?&amp;id={$JOID}\">{$JOID}</th>";
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

<div class="modal fade" id="image" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <img class="job-order-for-render" />"
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="warn" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        <h4 class="modal-title">Are you sure</h4>
      </div>
      <div class="modal-footer">
        <a href="#" class="btn btn-sm btn-default delmodal">Yes</a>
        <a href="#" class="btn btn-primary" data-dismiss="modal">No</a>
      </div>
    </div>
  </div>
</div>

<script src="js/script.js"></script>

<?php
include 'template/footer.php';
?>