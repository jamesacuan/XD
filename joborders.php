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

<div class="row xd-heading">
    <div class="clearfix">
        <div class="page-header pull-left">
            <h1><?php echo isset($page_title) ? $page_title : "Index"; ?></h1>
        </div>
        <div class="btn-group pull-right">
            <?php if($_SESSION['role']=="user")
                echo "<button type=\"button\" onclick=\"location.href='addjoborder.php'\" class=\"btn btn-primary pull-right\">+ Job Order</button>";
            ?>
        </div>
    </div>
</div>



<div class="row xd-content">
<ul class="nav nav-tabs clearfix" role="tablist">
    <li role="presentation" <?php if($type=="") echo "class=\"active\"" ?>><a href="<?php echo $home_url ?>joborders.php">View All</a></li>
    <li role="presentation" <?php if($type=="HH") echo "class=\"active\"" ?>><a href="<?php echo $home_url ?>joborders.php?type=HH">Helmet Holder</a></li>
    <li role="presentation" <?php if($type=="TH") echo "class=\"active\"" ?>><a href="<?php echo $home_url ?>joborders.php?type=TH">Ticket Holder</a></li>
</ul>

  <div role="tabpanel" class="tab-pane active" id="home">
    <table id="joborders" class="table table-hover table-striped">
            <thead style="background-color: #fff">
                <tr>
                    <th class="col-xs-1">JO</th>
                    <th class="col-xs-1">Image</th>
                    <th class="col-xs-1">Code</th>
                    <th class="col-xs-1">By</th>
                    <th class="col-xs-4">Note</th>
                    <th class="col-xs-2">Last Modified</th>
                    <th class="col-xs-1">Status</th>
                    <th class="col-xs-1">Actions</th>
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
                            //if($date_today == $date_created) $date_created = date_format(date_create($created),"h:i A");
                            //else $date_created = date_format(date_create($created),"F d");;
                            echo "<th scope=\"row\"><a href=\"joborder.php?&amp;id={$JOID}\">{$JOID}</a></th>";
                            echo "<td><img src=\"{$home_url}images/{$image_url}\" class=\"xd-thumbnail\" width=\"50\" height=\"35\" /></td>";
                            echo "<td><a href=\"joborderitem.php?&amp;code={$code}\">{$code}</a></td>";
                            echo "<td>{$username}</td>";
                            echo "<td class=\"clearfix\"><span>{$note}</span> <span class=\"label label-warning\">{$tag}</span>";
                            //if($date_today == $date_created) echo " <span class=\"label label-default\">New</span>";
                            //echo  $date_today . " - " . $date_created;
                            //$datediff = $date_today - $date_created;
                            $diff = (new DateTime($date_today))->diff(new DateTime($date_created));
                            if(($diff->d)>4 && $status!="Denied"){
                                echo " <span class=\"label label-danger\">Overdue</span>";
                            }
                            else if(($diff->d)<2){
                                echo " <span class=\"label label-primary\">New</span>";
                            }
                            //echo "<span class=\"glyphicon glyphicon-picture pull-right\" data-toggle=\"modal\" data-target=\"#image\" data-file=\"{$image_url}\" title=\"{$image_url}\"></span></td>";
                            //echo "<td><span title=\"" . date_format(date_create($created),"F d, Y h:i:s A") . "\">{$date_created}</span></td>";
                            echo "<td><span class=\"dtime\"  data-toggle=\"tooltip\" title=\"" . date_format(date_create($created),"F d, Y h:i:s A") . "\">" . date_format(date_create($modified),"m-d-Y h:i:s A") . "</span></td>";
                            echo "<td><span ";
                            /*    if     ($status=="For Approval") echo "label-primary";
                                elseif ($status=="Approved") echo "label-success";
                                elseif ($status=="Denied") echo "label-danger";
                                else   echo "label-default"; */
                            echo "\">{$status}</span></div>";
                            echo "<td>";
                            echo "<div class=\"btn-group\">";

                            ?>
                            <?php
                                echo "<a href=\"joborderitem.php?&amp;code={$code}\" class=\"btn btn-xs btn-default\">View</a>";
                                if(($status=="For Approval" && $role=="user" && $_SESSION['username']==$username) || ($role=="hans" || $role=="admin" || $role=="superadmin") && $status=="For Approval"){ 
                                ?>
                                    <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                    <span class="glyphicon glyphicon-option-vertical"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu">
                                <?php 
                                if(($role=="hans" || $role=="admin" || $role=="superadmin") && $status=="For Approval"){
                                    echo "<li><a href=\"" . $home_url . "joborders.php?id={$JODID}&amp;status=Approve\">Approve</a></li>";
                                    echo "<li><a href=\"" . $home_url . "joborders.php?id={$JODID}&amp;status=Deny\">Deny</a></li>";
                                }
                                if(($status=="For Approval" && $role=="user" && $_SESSION['username']==$username) || ($status=="For Approval" && $role=="superadmin")){
                                    echo "<li><a href=\"#\" data-id={$JODID} data-toggle=\"modal\" data-target=\"#warn\">Delete</a></li>";
                                }?></ul>
                                </div>
                                <?php
                                    }
                                ?>
                            <?php
                            echo "</div>";
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

<script src="js/dataTables.fixedHeader.min.js"></script>
<script src="js/script.js"></script>
</div>
<?php
include 'template/footer.php';
?>