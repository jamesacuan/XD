<?php
// core configuration
include_once "config/core.php";
include_once "config/database.php";
include_once "objects/job_order.php";

$database = new Database();
$db = $database->getConnection();

$job_order = new JobOrder($db);

$page_title= "Dashboard";

$require_login=true;

$today     = date("m/d/Y");
$yesterday = date("m/d/Y", strtotime($today . ' -1 days'));

if($_SESSION['role']=="superadmin" && isset($_GET['truncate'])){
    if(isset($_GET['truncate'])){
        $job_order->truncate();
    }
    $current_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $current_url = explode('?', $current_url);
    header("Location: {$current_url[0]}");
}

include_once "login_check.php";
include 'template/header.php'
?>

<?php
/*
echo "<div class='col-md-12'>";
$action = isset($_GET['action']) ? $_GET['action'] : "";
if($action=='login_success'){
        echo "<h3>Hi, " . $_SESSION['nickname'] . ". Welcome back!</h3>";
}
echo "</div>";
*/
?>
<div>
<div class="container">

<div class="row">
    <div class="col-md-12 clearfix">
        <div class="pull-left">
        <h3>Activity</h3>
        </div>

        <div class="pull-right btn-group">
        <?php
            if($_SESSION['role']=="user"){        
                echo "<button type=\"button\" onclick=\"location.href='addjoborder.php'\" class=\"btn btn-default\">+ Job Order</button>";
                echo "<button type=\"button\" onclick=\"location.href='addpurchaseorder.php'\" class=\"btn btn-default\">+ Purchase Order</button>";
            }
        ?>
        <?php
            if($_SESSION['role']=="superadmin"){
                echo "<a href=\"#\" class=\"btn btn-danger\" data-id=\"truncate\" data-toggle=\"modal\" data-target=\"#clear\">Truncate</a>";
            }
        ?>
        </div>
    </div>
</div>

<div class="row home-approval">
    <div class="col-md-6">

        <?php       
            $stmt = $job_order->readJODwithUserandStatus($_SESSION['userid'], "For Approval");
            $num  = $stmt->rowCount();
            $temp=0;

            if($num>0){
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    extract($row);
                    if    ($today == date_format(date_create($modified),"m/d/Y") && ($temp!=1)){
                        echo "<b>Today</b>";
                        $temp = 1;
                    }
                    if($temp!=2 && $yesterday == date_format(date_create($modified),"m/d/Y")){ 
                        $temp=2;
                        echo "<b>Yesterday</b>";
                    }
                    if($yesterday != date_format(date_create($modified),"m/d/Y") && ($temp!=1)){ 
                        echo "<b>Past</b>";
                        $temp = 1;
                    }

                    echo "<div class=\"row\">";
                        echo "<div class=\"col-sm-1\" style='text-align:center'>";
                        echo "<span class=\"glyphicon glyphicon-picture\" data-toggle=\"modal\" data-target=\"#image\" data-file=\"{$image_url}\" title=\"{$image_url}\"></span>";
                        echo "</div>";
                        echo "<div class=\"col-sm-9\">";
                            echo "<div class=\"title\"><a href=\"joborderitem.php?&amp;code={$code}\">{$code}</a>";
                            echo " - <span class=\"note\">{$note}</span> <span class=\"label ";
                                if     ($status=="For Approval") echo "label-primary";
                                elseif ($status=="Approve") echo "label-success";
                                elseif ($status=="Deny") echo "label-danger";
                                else   echo "label-default";
                            echo "\">{$status}</span></div>";
                            echo "<div class=\"info\"><span class=\"text-muted\">From <a href=\"joborder.php?&amp;id={$JOID}\">Job Order #{$JOID}</a> by {$username} on " . date_format(date_create($modified),"F d, Y") . "</div>";
                        echo "</div>";
                        echo "<div class=\"col-sm-2\">";
                         echo "</div>";
                    echo "</div>";
                }
            }
            else{
                echo "<div class='alert alert-info'>No products found.</div>";
            }
        ?>
  
  </div>
</div>

</div>
        </div>

<div class="modal fade" id="clear" tabindex="-1" role="dialog">
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

<div class="modal fade" id="image" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
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
<script src="js/script.js"></script>
<?php
    //include 'template/content.php';
    include 'template/footer.php';
?>