<?php
include_once "config/core.php";
include_once "config/database.php";
include_once "objects/job_order.php";

$database = new Database();
$db = $database->getConnection();

$job_order = new JobOrder($db);

if(isset($_GET['code'])){
    $itemcode = $_GET['code'];
}
else{
    header("Location: {$home_url}404.php");
}
$page_title      = $itemcode;
$job_order->code = $itemcode;
$role = $_SESSION['role'];

echo $job_order->getJOItem();
$require_login=true;

include_once "login_check.php";
include 'template/header.php';
?>

<?php
if($_POST){
    echo "test";    
}
?>
<div class="xd-snip">
    <ol class="breadcrumb">
        <li><a href="<?php echo $home_url ?>">Home</a></li>
        <li><a href="<?php echo $home_url . "joborder.php?&amp;id=" . $job_order->joborderid?>">Job Order #<?php echo $job_order->joborderid?></a></li>
        <li class="active"><?php echo $page_title ?></li>
    </ol>
</div>

<div class="xd-content">
    <!--
    <div class="row">
        <div class="col-md-9"><h1><?php echo $page_title ?></h1></div>
        <div class="col-md-3 clearfix">
            <div class="pull-right btn-group xd-joitem-details-btngroup">
            <?php
            /*    if ($job_order->username==$_SESSION['username'] && $job_order->status=='For Approval'){
                    echo "<a href=\"#\" class=\"btn btn-danger\"><span class=\"glyphicon glyphicon-trash\"></span> Delete</a>";
                }
                //else{
                    //echo "<a href=\"#\" class=\"btn btn-danger disabled\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"You can no longer delete your request, once approved.\"><span class=\"glyphicon glyphicon-trash\"></span>Delete</a>";
                //} 
                if($job_order->status=='For Approval' && ($role=="hans" || $role=="admin" || $role=="superadmin")){
                    echo "<a href=\"#\" class=\"btn btn-primary\"><span class=\"glyphicon glyphicon-ok\"></span> Approve</a>";
                    echo "<a href=\"#\" class=\"btn btn-default\">Deny</a>";
                }
                */
            ?>
                <a href="#" class="btn btn-default"><span class="glyphicon glyphicon-print"></span> Print</a>
            </div>
        </div>
    </div>
    -->
    <div class="row" style="margin-top: 40px">
        <div class="col-md-3">
            <div class="row">
                <div class="col-xs-12"><img src="<?php echo $home_url . "images/" . $job_order->image_url?>" width="250" height="250"/>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-xs-12"><h2><?php echo $page_title ?></h2></div>
            </div>
            
            <div class="row">
                <div class="col-xs-3">From Job Order</div>
                <div class="col-xs-9"><a href="<?php echo $home_url . "joborder.php?&amp;id=" . $job_order->joborderid?>"><?php echo $job_order->joborderid?></a></div>
            </div>
            <div class="row">
                <div class="col-xs-3">Type:</div>
                <div class="col-xs-9"><?php if($job_order->type=="HH") echo "Helmet Holder";
                                            elseif($job_order->type=="TH") echo "Ticket Holder"; ?></div>
            </div>
            <div class="row">
                <div class="col-xs-3">Requested By:</div>
                <div class="col-xs-9"><?php echo $job_order->nickname?></div>
            </div>
            <div class="row">
                <div class="col-xs-3">Date added:</div>
                <div class="col-xs-9"><?php echo date_format(date_create($job_order->modified),"F d, Y h:i:s A"); ?></div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                <div class="md-stepper-horizontal">
                <div class="md-step active">
                    <div class="md-step-circle"><span>1</span></div>
                    <div class="md-step-title">
                    <?php if ($job_order->status == "Approved") echo "Approved";
                        else echo "Request"; ?>
                    </div>
                    <div class="md-step-bar-left"></div>
                    <div class="md-step-bar-right"></div>
                </div>
                <?php echo "<div class=\"md-step ";
                            if ($job_order->status == "Approved") echo "active\">";
                            else echo "inactive\">"; ?>
                    <div class="md-step-circle"><span>2</span></div>
                    <div class="md-step-title">Proposal</div>
                    <!--<div class="md-step-optional">Rendered Image</div>-->
                    <div class="md-step-bar-left"></div>
                    <div class="md-step-bar-right"></div>
                </div>
                <div class="md-step inactive">
                    <div class="md-step-circle"><span>3</span></div>
                    <div class="md-step-title">Launch</div>
                    <div class="md-step-bar-left"></div>
                    <div class="md-step-bar-right"></div>
                </div>
                </div>
            </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="row">
                <div class="col-sm-3 clearfix">
                    <div class="pull-right btn-group xd-joitem-details-btngroup">
                    <?php
                        if ($job_order->username==$_SESSION['username'] && $job_order->status=='For Approval'){
                            echo "<a href=\"#\" class=\"btn btn-danger\"><span class=\"glyphicon glyphicon-trash\"></span> Delete</a>";
                        }
                        //else{
                            //echo "<a href=\"#\" class=\"btn btn-danger disabled\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"You can no longer delete your request, once approved.\"><span class=\"glyphicon glyphicon-trash\"></span>Delete</a>";
                        //} 
                        if($job_order->status=='For Approval' && ($role=="hans" || $role=="admin" || $role=="superadmin")){
                            echo "<a href=\"#\" class=\"btn btn-primary\"><span class=\"glyphicon glyphicon-ok\"></span> Approve</a>";
                            echo "<a href=\"#\" class=\"btn btn-default\">Deny</a>";
                        }
                    ?>
                        <a href="#" class="btn btn-default"><span class="glyphicon glyphicon-print"></span> Print</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--
        php if(($role=="hans" || $role=="admin" || $role=="superadmin") && $job_order->status=="Approved"){
    
        -->
    <div class="row" style="margin-top:30px;">
        <div class="col-md-12">
            <h3>Feedback</h3>
        </div>
    </div>

   <div class="row">   
        <?php       
                $stmt = $job_order->readJODFeedback($itemcode);
                $num  = $stmt->rowCount();

                if($num>0){
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        extract($row);
                        echo "<div class=\"col-md-12\">";
                        echo "<div class=\"media\">";
                            echo "<div class=\"media-left media-top\">";
                            echo "<img class=\"media-object\" src=\"{$home_url}/images/{$image_url}\" width=\"64\" height=\"64\" />";
                            echo "</div>";
                        echo "</div>";
                        echo "<div class=\"media-body\">{$note} - {$username}";
                        echo "</div>";
                        echo "</div>";
                    }
                }
                else echo "none";
        ?>
   </div>
    
   <div class="row" style="margin-top:25px; margin-bottom:15px">
        <div class="col-md-12">
            <div class="media">
                <div class="media-left media-top">
                    <!--
                        <img class="media-object" src="#" width="64" height="64" />
                        -->
                </div>
                <div class="media-body">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data"> 
                    <fieldset>
                    <div class="form-group">
                        <textarea class="form-control" name="note" placeholder="Add a note" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="status" class="control-label">Status</label>
                        <select>
                            <option></option>
                            <option>Needs Feedback</option>
                            <option>Done</option>
                        </select>
                    </div>
                    <!--
                    <div class="form-group">
                        <label for="url" class="control-label">Upload Image</label>
                        <div>
                            <input type="file" name="image" id="url" />
                        </div>
                    </div>
                    -->
                    <?php
                    if($_POST){
                        echo "<input type=\"hidden\" name='joid' value='{$newJO}'/>";
                    }
                    ?>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    </fieldset>
                    </form>
                </div>
        </div>
        </div>
    </div>
    <?php  ?>
</div>
<?php
include 'template/footer.php';
?>