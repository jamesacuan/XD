<?php
// core configuration
include_once "config/core.php";
include_once "config/database.php";
include_once "objects/job_order.php";
include_once "objects/purchase_order.php";
include_once "objects/settings.php";
include_once "objects/user.php";

$database = new Database();
$db = $database->getConnection();

$job_order = new JobOrder($db);
$settings  =  new Settings($db);
$purchase_order = new PurchaseOrder($db);

$page_title= "Dashboard";

$page_ribbon="F";

$today     = date("m/d/Y");
$yesterday = date("m/d/Y", strtotime($today . ' -1 days'));

if(!isset($_SESSION["username"])){
    $require_login=true ;
include_once "functions/login_check.php";
    include_once "template/home.php";
}
else{
if($_SESSION['role']=="superadmin" && isset($_GET['truncate'])){
    if(isset($_GET['truncate'])){
        $settings->truncate();
    }
    $current_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $current_url = explode('?', $current_url);
    header("Location: {$current_url[0]}");
}
include 'template/header.php';
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
<div class="xd-dash row" style="margin-left: -31px">
<?php
    if($_SESSION['role']=="superadmin"){
        echo "<a href=\"#\" class=\"btn btn-danger\" data-id=\"truncate\" data-toggle=\"modal\" data-target=\"#clear\">Truncate</a>";
    }
?>
<div class="col-md-3">
<h3>Good Morning, <?php echo $_SESSION['nickname'] ?></h3>
<p>June 23, Saturday</p>
</div>

<div class="col-md-9">
    <div class="row">
        <div class="col-md-3">
            <p>test</p>
        </div>
        <div class="col-md-3">
            <p>test</p>
        </div>
        <div class="col-md-3">
            <p>test</p>
        </div>
    </div>
</div>
</div>
<div class="row home-approval">
    <div class="col-md-3">
        <ul>
            <li>Activity</li>
        </ul>
    </div>
    <div class="col-md-9">
        <?php
        echo "<div class=\"panel-group\" id=\"accordion\" role=\"tablist\">";
        //if($_SESSION["admin"]=='Y')
            $stmt = $job_order->readJODActivityStream();
        //else
            //$stmt = $job_order->readJODwithUserandStatus($_SESSION['userid'], "For Approval");
        $num  = $stmt->rowCount();

        if($num>0){
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                extract($row);

                if($XTABLE=="JO"){
                    echo "<div class=\"panel panel-info\" style=\"margin:30px 0\">";
                        echo "<div class=\"panel-heading clearfix\" role=\"tab\">";
                        //echo "<div class=\"xd-circle pull-left\" style=\"background-color: #" . $settings->getColor(substr($nickname, 0, 1)) . "\">" . substr($nickname, 0, 1) . "</div>";
                        //echo "<div class=\"pull-left\" style=\"margin-left:20px\">";
                        echo "<div class=\"pull-left\">";
                            echo "<a href=\"{$home_url}joborder.php?&id={$ID}\" >";
                            echo "<h4 style=\"margin: 2px 0\">Job Order #{$ID}</h4>";
                            echo "</a>";
                            echo "<span class=\"text-muted\">By {$nickname} | On " . date_format(date_create($created),"F d, Y") . " at " . date_format(date_create($created),"h:i a") . "</span>";
                        echo "</div></div>";
                        //echo "<div class=\"panel-body\">";
                        echo "<table class=\"table table-hover\">";
                    $stmt2 = $job_order->readJOD($ID);
                    $num2 = $stmt2->rowCount();
                    $i = 0;
                    $tempjod = $ID;
                    if($num2>0){
                        while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
                            extract($row2);
                            if($i < 4){
                                echo "<tr>";
                                if($image_url=="") $image_url = "def.png";
                                echo "<td class=\"col-xs-1\" style=\"padding-left: 15px\"><a href=\"{$home_url}joborderitem.php?&code={$code}\"><img class=\"img-rounded\" src=\"{$home_url}images/thumbs/{$image_url}\" width=\"40\" height=\"40\" /></a></td>";
                                echo "<td class=\"col-xs-9\"><a href=\"{$home_url}joborderitem.php?&code={$code}\">{$code}</a><br/>{$note}</td>";
                                echo "<td class=\"col-xs-2\">{$status}</td>";
                                echo "</tr>";
                            }
                            else{
                                echo "<tr>";
                                echo "<td colspan=\"3\"><a href=\"{$home_url}joborder.php?&id={$tempjod}\" >Show All...</a></td>";
                                echo "</tr>";
                                break;
                            }
                            $i++;
                        }
                    }
                    echo "</table>";
                    echo "</div>";
                }
                else if($XTABLE == "PO"){
                    echo "<div class=\"panel panel-success\" style=\"margin:30px 0\">";
                        echo "<div class=\"panel-heading clearfix\" role=\"tab\">";
                        //echo "<div class=\"xd-circle pull-left\" style=\"background-color: #" . $settings->getColor(substr($nickname, 0, 1)) . "\">" . substr($nickname, 0, 1) . "</div>";
                        //echo "<div class=\"pull-left\" style=\"margin-left:20px\">";
                        echo "<div class=\"pull-left\">";
                            echo "<a href=\"{$home_url}purchaseorder.php?&id={$ID}\">";
                            echo "<h4 style=\"margin: 2px 0\">Purchase Order #{$ID}</h4>";
                            echo "</a>";
                            echo "<span class=\"text-muted\">By {$nickname} | On " . date_format(date_create($created),"F d, Y") . " at " . date_format(date_create($created),"H:i a") . "</span>";
                        echo "</div></div>";
                        echo "<table class=\"table table-hover\">";
                    $stmt2 = $purchase_order->readPOItem($ID);
                    $num2 = $stmt2->rowCount();
                    if($num2>0){
                        while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
                            extract($row2);
                            //echo $JODID . " " . $code;
                            echo "<tr>";
                            if($image_url=="undefined") $image_url = "def.png";
                            echo "<td class=\"col-xs-1\" style=\"padding-left: 15px\"><img class=\"img-rounded\" src=\"{$home_url}images/{$image_url}\" width=\"40\" height=\"40\" /></td>";
                            echo "<td class=\"col-xs-11\">{$productname} - {$type}<br/>{$note} x {$quantity}</td>";
                            echo "</tr>";
                        }
                    }
                    echo "</table>";
                    echo "</div>";
                }
            }
        }
        else echo "<div class='alert alert-info'>No recent activity.</div>";
        
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
  <div class="modal-dialog modal-sm" role="document">
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
    };
?>