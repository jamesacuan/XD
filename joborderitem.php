<?php
include_once "config/core.php";
include_once "config/database.php";
include_once "objects/job_order.php";

$database = new Database();
$db = $database->getConnection();

$job_order = new JobOrder($db);

if($_POST){
    $job_order->expectedJOD = $_POST['jod'];
    if(isset($_POST['status']))
        $job_order->status = $_POST['status'];
    else
        $job_order->status = "";
    $job_order->note = $_POST['note'];
    $job_order->userid = $_SESSION['userid'];

    if($_FILES["image"]["error"] == 4){
        $job_order->image_url = "";
        if($job_order->addJOItemFeedback() && $job_order->setTag()){

        }
        else{
            echo "this";
        } 
    }
    else if(isset($_FILES['image'])){
        $errors = array();
        $file_name = $_FILES['image']['name'];
        $file_size = $_FILES['image']['size'];
        $file_tmp  = $_FILES['image']['tmp_name'];
        $file_type = $_FILES['image']['type'];
        $tmp       = explode('.',$file_name);
        $file_ext  = strtolower(end($tmp));
        $expensions= array("jpeg","jpg","png");
        if(in_array($file_ext,$expensions)=== false){
            $errors[]="extension not allowed, please choose a JPEG or PNG file.";
        }
        
        if($file_size > 2097152) {
            $errors[]='File size must be excately 2 MB';
        }
        $tmptoday = new DateTime(date("m/d/Y"));
        $tmptoday = sha1($tmptoday->format('Y-m-d H:i:s'));
        $tmpfile_name = substr($tmptoday, -20) . substr(sha1($_POST['note']), -10);
        $file_name = $tmpfile_name . "." .$file_ext;
        $job_order->image_url = $file_name;

        if(empty($errors)==true && $job_order->addJOItemFeedback() && $job_order->setTag()){
            move_uploaded_file($file_tmp,"images/".$file_name);
        }
        else{
            echo "<div class=\"row\"><div class=\"col-md-12\"><div class='alert alert-danger'>";
            echo "<h4>Unable to create job order.</h4>";
            print_r($errors);
            echo "</div></div></div>";
        }
    }
}

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

$jodid = $job_order->joborderdetailsid;

if(($role=="admin" || $role=="superadmin" || $role=="hans") && isset($_GET['status'])){
    if(isset($_GET['status'])){
        $job_order->joborderdetailsid = $jodid;
        if($_GET['status'] == 'Deny')
            $job_order->status = "Denied";
        elseif($_GET['status'] == 'Approve')
            $job_order->status = "Approved";
        else
            $job_order->status = $_GET['status'];
        $job_order->approve();
    }
}


$require_login=true;

include_once "login_check.php";
include 'template/header.php';
?>
<div class="xd-snip">
    <ol class="breadcrumb">
        <li><a href="<?php echo $home_url ?>">Home</a></li>
        <li><a href="<?php echo $home_url . "joborder.php?&amp;id=" . $job_order->joborderid?>">Job Order #<?php echo $job_order->joborderid?></a></li>
        <li class="active"><a href="<?php echo $home_url . "joborderitem.php?&amp;code=" . $itemcode ?>"><?php echo $page_title ?></a></li>
    </ol>
</div>

<div class="xd-content">
    <?php 
    /*
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
                
            ?>
                <a href="#" class="btn btn-default"><span class="glyphicon glyphicon-print"></span> Print</a>
            </div>
        </div>
    </div>
    -->*/ ?>
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
                <div class="col-xs-3">Note:</div>
                <div class="col-xs-9"><?php echo $job_order->note ?></div>
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
                            echo "<a href=\"" . $home_url . "joborderitem.php?code={$page_title}&amp;status=Approve\" class=\"btn btn-primary\"><span class=\"glyphicon glyphicon-ok\"></span> Approve</a>";
                            echo "<a href=\"" . $home_url . "joborderitem.php?code={$page_title}&amp;status=Deny\" class=\"btn btn-default\">Deny</a>";
                        }
                    ?>
                        <!--
                            <a href="#" class="btn btn-default"><span class="glyphicon glyphicon-print"></span> Print</a>
                    -->
                    </div>
                </div>
            </div>
        </div>
    </div>

   <div class="row xd-page-item-messages">
        <div class="col-md-8">
        <div class="col-md-12">
            <h4>Feedback (<?php echo $job_order->getJobOrderFeedbackCount($jodid) ?>)</h4>
        </div>
        <?php       
                $stmt = $job_order->readJODFeedback($itemcode);
                $num  = $stmt->rowCount();

                if($num>0){
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        extract($row);
                        echo "<div class=\"col-md-12 xd-message\">";
                        echo "<div class=\"media\">";
                            echo "<div class=\"media-left media-top\">";
                            echo "<div class=\"xd-circle\">" . substr($username, 0, 1) . "</div>";
                            //echo "<img class=\"media-object\" src=\"{$home_url}/images/{$image_url}\" width=\"64\" height=\"64\" />";
                            echo "</div>";
                            echo "<div class=\"media-body\">";
                                echo "<b class=\"media-heading\">{$username}</b> - <span>{$created}</span> <span class='label label-default'>{$tag}</span>";
                                echo "<p>{$note}</p>";
                                if(!empty($image_url)){
                                    echo "<p><a href=\"#\"><img src=\"" . $home_url . "images/" . $image_url . "\" width=\"64\" height=\"64\"/></a></p>";
                                }
                            echo "</div>";
                        echo "</div>";
                        echo "</div>";
                    }
                }
                else echo "none";
        ?>
        <div class="col-md-12 xd-message">
            <div class="media">
                <div class="media-left media-top">
                    <!--
                        <img class="media-object" src="#" width="64" height="64" />
                        -->
                </div>
                <div class="media-body">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ."?&code=" . $itemcode;?>" method="post" enctype="multipart/form-data"> 
                    <b class="media-heading"><?php echo $_SESSION['username'] ?>:</b>
                    <fieldset>
                    <div class="form-group">
                        <textarea class="form-control" name="note" placeholder="Comment" rows="3" required></textarea>
                    </div>
                    <div class="form-group clearfix">
                        <div class="pull-left">
                        <label for="status" class="control-label">Status</label>
                        <select name="status">
                            <option></option>
                            <option>Needs Feedback</option>
                            <option>Done</option>
                        </select>
                        </div>
                        <div class="pull-right">
                            <div>
                                <input type="file" name="image" id="feedback-image" />
                            </div>
                        </div>
                    </div>
                    <!--
                    <div class="form-group">

                    </div>
                    -->
                    <?php
                    /*if($_POST){
                        echo "<input type=\"hidden\" name='joid' value='{$newJO}'/>";
                    }*/
                    ?>
                    <input type="hidden" name='jod' value='<?php echo $job_order->joborderdetailsid ?>'/>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    </fieldset>
                    </form>
                </div>
        </div>
        </div>
   </div>
    </div>
   <div class="row" style="margin-top:25px; margin-bottom:15px">
        
    </div>
    <?php  ?>
</div>
<?php
include 'template/footer.php';
?>