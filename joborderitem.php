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
$page_title      = "Job Order Item: " . $itemcode;
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
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="row">
                <div class="col-xs-12"><img src="<?php echo $home_url . "images/" . $job_order->image_url?>" width="250" height="250"/>
                </div>
            </div>
        </div>
        <div class="col-md-7">
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
                <div class="col-xs-3">By:</div>
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
        <div class="col-md-2 clearfix">
            <div class="pull-right btn-group">
            <?php
                if ($job_order->username==$_SESSION['username'] && $job_order->status=='For Approval'){
                    echo "<a href=\"#\" class=\"btn btn-danger\">Delete</a>";
                }
                if($job_order->status=='For Approval' && ($role=="hans" || $role=="admin" || $role=="superadmin")){
                    echo "<a href=\"#\" class=\"btn btn-default\">Approve</a>";
                    echo "<a href=\"#\" class=\"btn btn-default\">Deny</a>";
                }
            ?>
            </div>
        </div>
    </div>

    <?php if($role=="hans" || $role=="admin" || $role=="superadmin"){
        ?>
    <div class="row" style="margin-top:30px;">
        <div class="col-md-12">
            <h3>Feedback</h3>
        </div>
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
    <?php } ?>
</div>
<?php
include 'template/footer.php';
?>