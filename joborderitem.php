<?php
include_once "config/core.php";
include_once "config/database.php";
include_once "objects/job_order.php";
include_once "objects/product.php";
include_once "objects/settings.php";
include_once "objects/user.php";

$database = new Database();
$db = $database->getConnection();

$job_order = new JobOrder($db);
$product   = new Product($db);
$settings  = new Settings($db);
$user      = new User($db);

if(isset($_GET['code']))
    $itemcode = $_GET['code'];
else
    header("Location: {$home_url}404.php"); ////////////WORK ON THIS

$page_title      = $itemcode;
$role            = $_SESSION['role'];
$jodid = $job_order->joborderdetailsid;

$job_order->code = $itemcode;
$job_order->getJOItem();
$tmpuser = $job_order->userid;

if(!empty($job_order->isDeleted))
    header("Location: 404.php");

if($_POST){
    /* if pUblish 
    if($_POST['form']=="publishnew" && $_POST){
        $product->producttype     = $job_order->type;
        $product->productname     = $_POST['productname'];
        $product->productcategory = $_POST['tag'];        
        $product->note            = $_POST['note'];
        $product->userid          = $_SESSION['userid'];
        $product->setProductItem();

        $productitemid = $product->getProductItemCount();

        $product->image_url          = $_POST['image'];
        $product->code               = $itemcode;
        $product->product_colorid    = $_POST['color'];
        $product->product_itemid     = $productitemid;
        $product->joborderdetailsid  = $jodid;
        $product->setProductItemVariant();

        $job_order->tag    = "";
        $job_order->status = "Published";
        $job_order->userid = $_SESSION['userid'];
        $job_order->code   = $itemcode;
        $job_order->setTag();
        $job_order->setStatus();

        $_SESSION['modal'] = $_POST['productname'] . "has been successfully added.";

        header("Location: {$home_url}products.php");

    }


    if($_POST['form']=="publishexisting" && $_POST){
        echo $product->image_url          = $_POST['image'];
        echo $product->code               = $itemcode;
        echo $product->product_colorid    = $_POST['color'];
        echo $product->product_itemid     = $_POST['productname'];
        echo $product->jodid           = $jodid;
        echo $product->userid          = $_SESSION['userid'];
        $product->note                 = $_POST['note'];

        $product->setProductItemVariant();

        echo $job_order->tag    = "";
        echo $job_order->status = "Published";
        echo $job_order->userid = $_SESSION['userid'];
        echo $job_order->code   = $itemcode;
        $job_order->setTag();
        $job_order->setStatus();

        $_SESSION['modal'] = $_POST['productname'] . "has been successfully added.";

        header("Location: {$home_url}products.php");

    }*/


    /*IF feedback */
    if($_POST['form']=='Submit'){
        echo 'no';
        $job_order->note = $_POST['note'];
        
        if(isset($_POST['tag']))
            $job_order->tag = $_POST['tag'];
        else
            $job_order->tag = "";

        if(isset($_POST['status']))
            $job_order->status = $_POST['status'];
        else
            $job_order->status = "";
        $job_order->userid = $_SESSION['userid'];
        $job_order->expectedJOD = $_POST['jod'];
        

        $user->code      = "JOI";
        $user->content   = $_POST['note'];
        $user->fromuser  = $_SESSION['userid'];
        $user->touser    = $tmpuser;
        $user->url       = "joborderitem.php?&code=" . $itemcode;
        

        if($_FILES["image"]["error"] == 4){
            $job_order->image_url = "";
            //echo "test";
            if($job_order->addJOItemFeedback() && $job_order->setTag()){
                if($user->fromuser != $user->touser ){
                    $user->setNotification();
                }
                //$_SESSION['modal'] = 'Feedback added.';
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

            $source_properties = getimagesize($file_tmp);  //reseize
            $image_type = $source_properties[2];           //resize

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
                $tmp       = explode('.',$file_name);
                $filename  = $tmp[0];

                if( $image_type == IMAGETYPE_JPEG ) {   
                    $image_resource_id = imagecreatefromjpeg($file_tmp);  
                    $target_layer = $settings->fn_resize($image_resource_id, $source_properties[0],$source_properties[1]);
                    imagejpeg($target_layer, "images/thumbs/" . $filename . "." . $file_ext);
                }
                elseif( $image_type == IMAGETYPE_GIF )  {  
                    $image_resource_id = imagecreatefromgif($file_tmp);
                    $target_layer = $settings->fn_resize($image_resource_id, $source_properties[0],$source_properties[1]);
                    imagegif($target_layer, "images/thumbs/" . $filename . "." . $file_ext);
                }
                elseif( $image_type == IMAGETYPE_PNG ) {
                    $image_resource_id = imagecreatefrompng($file_tmp); 
                    $target_layer = $settings->fn_resize($image_resource_id, $source_properties[0],$source_properties[1]);
                    imagepng($target_layer, "images/thumbs/" . $filename . "." . $file_ext);
                }
                
                if($user->fromuser != $user->touser ){
                    $user->setNotification();
                }
                move_uploaded_file($file_tmp,"images/" . $file_name);
            }
            else{
                $_SESSION['modal'] = "Cannot add feedback.";
                /*echo "<div class=\"row\"><div class=\"col-md-12\"><div class='alert alert-danger'>";
                echo "<h4>Unable to create job order.</h4>";
                print_r($errors);
                echo "</div></div></div>";*/
            }
        }
        header("Location: {$home_url}joborderitem.php?&code=" . $_GET['code'], true, 303);
        $_SESSION['modal'] = 'Feedback added.';
    }
   

}


    /*
    if(($role=="admin" || $role=="superadmin" || $role=="hans" || $_SESSION['admin']=="Y") && isset($_GET['status'])){
        if(isset($_GET['status'])){
            $job_order->userid = $_SESSION["userid"];
            $job_order->code   = $itemcode;
            $job_order->joborderdetailsid = $jodid;

            if($_GET['status'] == 'Deny')
                $job_order->status = "Denied";
            elseif($_GET['status'] == 'Approve')
                $job_order->status = "Approved";
            else
                $job_order->status = $_GET['status'];
            //$job_order->approve();
            $job_order->setStatus();
            header("Location: {$home_url}joborderitem.php?&code={$itemcode}");
        }
    }*/

if(isset($_GET['status']) && $_GET['status']=="approved" && $role=='user'){
        $job_order->userid = $_SESSION["userid"];
        $job_order->code   = $itemcode;
        $job_order->joborderdetailsid = $jodid;
        $job_order->status = $_GET['status'];

        $job_order->setStatus();
        header("Location: {$home_url}joborderitem.php?&code={$itemcode}");
}

else if($role=="user" && isset($_GET['delete']) || ($role=="superadmin" && isset($_GET['delete']))){
    //$id = $_GET['id'];
    if(isset($_GET['delete'])){
        $job_order->joborderdetailsid = $jodid;
        $job_order->isDeleted = 'Y';
        $job_order->delete();
    }
    //$current_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    //$current_url = explode('?', $current_url);
    header("Location: {$home_url}joborders.php");
}

$require_login=true;

$stmt = $job_order->readJODFeedback($itemcode);
$num  = $stmt->rowCount();
$yes = 0;
if($num>0){
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        if(!empty($image_url)){
            if($role == "hans") 
                $yes = 1;
        }
    }
}

include_once "functions/login_check.php";
include_once "functions/post_publish.php";
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
        <?php if(!empty($job_order->image_url)){ ?>
            <div class="col-md-3">
                <div class="row">
                    <div class="col-xs-12"><img src="<?php echo $home_url . "images/" . $job_order->image_url?>" width="250" height="250" data-toggle="modal" data-target="#preview" data-value="<?php echo $job_order->image_url ?>" />
                    </div>
                </div>
            </div>
            <div class="col-md-6">
        <?php }
              else{ ?> <div class="col-md-9"> <?php } ?>
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
                    <div class="col-xs-3">Status:</div>
                    <div class="col-xs-9"><span class="label label-default"><?php echo $job_order->status ?></span></div>
                </div>
                <div class="row">
                    <div class="col-xs-3">Note:</div>
                    <div class="col-xs-9"><?php echo $job_order->note ?></div>
                </div>

                
                <div class="row">
                    <div class="col-xs-12">
                    <?php echo "<div class=\"md-stepper-horizontal";
                            if ($job_order->status == 'Published')
                                echo ' green ';
                        echo "\">"
                    ?>
                    <?php echo "<div class=\"md-step ";
                    if ($job_order->status == "Accepted" || $job_order->status == "approved" || $job_order->status =="Published") echo "active ";
                    echo "\">";
                    ?>
                        <div class="md-step-circle">
                        <?php if ($yes==1) echo "<span class=\"glyphicon glyphicon-ok\"></span>";
                            else echo "<span>1</span>"; ?>
                        </div>
                        <div class="md-step-title">
                        <?php if (($job_order->status=="Accepted" && $yes==0) || $job_order->status == "Approved" || $job_order->status == "Done") echo "Rendering Image";
                            else if ($yes==1) echo "Rendered Image";
                            else echo "For Render"; ?>
                        </div>
                        <!--<div class="md-step-optional">Rendered Image</div>-->
                        <div class="md-step-bar-left"></div>
                        <div class="md-step-bar-right"></div>
                    </div>
                    <?php echo "<div class=\"md-step ";
                                if ($yes==1 || $job_order->status == "approved" || $job_order->status == "Done" || $job_order->status == "Published") echo "active\">";
                                else echo "inactive\">"; ?>
                        <div class="md-step-circle">
                            <?php if ($job_order->status == "approved" || $job_order->status == "Published") echo "<span class=\"glyphicon glyphicon-ok\"></span>";
                                else echo "<span>2</span>"; ?>
                        </div>
                        <div class="md-step-title">
                        <?php if ($job_order->status == "approved" || $job_order->status == "Published") echo "Approved by Client";
                            else echo "For Approval by Client"; ?>
                        </div>
                        <!--<div class="md-step-optional">Rendered Image</div>-->
                        <div class="md-step-bar-left"></div>
                        <div class="md-step-bar-right"></div>
                    </div>
                    <?php echo "<div class=\"md-step ";
                                if ($job_order->status == "approved" || $job_order->status == "Published") echo "active\">";
                                else echo "inactive\">"; ?>

                        <div class="md-step-circle">
                            <?php if ($job_order->status == "Published") echo "<span class=\"glyphicon glyphicon-ok\"></span>";
                                else echo "<span>3</span>"; ?>
                        </div>
                        <div class="md-step-title">
                        <?php if ($job_order->status == "Published") echo "Published";
                              else echo "To Publish"; ?>
                        </div>
                        <div class="md-step-bar-left"></div>
                        <div class="md-step-bar-right"></div>
                    </div>
                    
                    </div>
                </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="row">
                    <div class="col-sm-12 clearfix">
                        <div class="pull-right btn-group xd-joitem-details-btngroup">
                        <?php
                            if ($job_order->username==$_SESSION['username'] && $job_order->status=='For Approval'){
                                echo "<a href=\"#\" class=\"btn btn-danger\" data-id=" . $jodid . " data-toggle=\"modal\" data-target=\"#warn\">Delete</a>";
                            }
                            //else{
                                //echo "<a href=\"#\" class=\"btn btn-danger disabled\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"You can no longer delete your request, once approved.\"><span class=\"glyphicon glyphicon-trash\"></span>Delete</a>";
                            //} 


                            /* TEMPORARILY REMOVED (YOU MAY USE JOBORDER PAGE INSTEAD) 
                            
                            if($job_order->status=='For Approval' && ($role=="hans" || $role=="admin" || $role=="superadmin" || $_SESSION['admin']=="Y")){
                                echo "<a href=\"" . $home_url . "joborderitem.php?code={$page_title}&amp;status=Approve\" class=\"btn btn-primary\"><span class=\"glyphicon glyphicon-ok\"></span> Approve</a>";
                                echo "<a href=\"" . $home_url . "joborderitem.php?code={$page_title}&amp;status=Deny\" class=\"btn btn-default\">Deny</a>";
                            }*/
                            

                            if($job_order->status=='Accepted' && ($job_order->username==$_SESSION['username'] || $role=="superadmin") && $yes==1){
                                echo "<button type=\"button\" class=\"btn btn-primary\" data-toggle=\"modal\" data-target=\"#finishModal\" id=\"finish\"><span class=\"glyphicon glyphicon-ok\"></span> Approved by Client</button>";
                            }


                            if($job_order->status=='Approved' && ($job_order->username==$_SESSION['username'] || $role=="superadmin")){
                                //echo "<a href=\"" . $home_url . "joborderitem.php?code={$page_title}&amp;status=Done\" class=\"btn btn-primary\" data-toggle=\"tooltip\" title=\"Launched\"><span class=\"glyphicon glyphicon-ok\"></span> Mark As Finish</a>";
                                echo "<button type=\"button\" class=\"btn btn-primary\" data-toggle=\"modal\" data-target=\"#finishModal\" id=\"finish\"><span class=\"glyphicon glyphicon-ok\"></span> Mark As Finish</button>";
                            }

                            //if($job_order->status=='Done' && ($role=="hans" || $role=="admin" || $role=="superadmin")){
                            if($job_order->status=='approved'){
                                //echo "<a href=\"" . $home_url . "joborderitem.php?code={$page_title}&amp;status=Done\" class=\"btn btn-danger\"><span class=\"glyphicon glyphicon-ok\"></span> Publish</a>";
                                echo "<button type=\"button\" class=\"btn btn-primary\" data-toggle=\"modal\" data-target=\"#publishModal\" id=\"publish\">Publish</button>";
                            }
                        ?>
                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="glyphicon glyphicon-option-vertical"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="#" onclick="window.print();">Print...</a></li>
                        <li><a href="#" data-toggle="modal" data-target="#share">Share...</a></li>
                    </ul>

                        </div>
                    </div>
                </div>
            </div>
        </div>

    <div class="row xd-page-item-messages">
            <div class="col-md-8">

            <div class="col-md-12">
                    <h4>Discussion (<?php echo $job_order->getJobOrderFeedbackCount($jodid) ?>)</h4>
            </div>
            <?php
            if($job_order->username != $_SESSION["username"] && $_SESSION['role'] != 'hans'){
                echo "<div class=\"col-md-12 xd-message bg-danger\">";
                echo "This page is not intended for you. Be civil.";
                echo "</div>";
            }?>

            <?php       
                    $stmt = $job_order->readJODFeedback($itemcode);
                    $num  = $stmt->rowCount();
                    $i = 1;
                    if($num>0){
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                            extract($row);
                            echo "<div class=\"col-md-12 xd-message\" id=\"discuss{$i}\">";
                            echo "<div class=\"media\">";
                                echo "<div class=\"media-left media-top\">";
                                echo "<div class=\"xd-circle\" style=\"background-color: #" . $settings->getColor(substr($username, 0, 1)) . "\">" . substr($username, 0, 1) . "</div>";
                                //echo "<img class=\"media-object\" src=\"{$home_url}/images/{$image_url}\" width=\"64\" height=\"64\" />";
                                echo "</div>";
                                echo "<div class=\"media-body\">";
                                    echo "<b class=\"media-heading\">{$nickname}</b> - <a href=\"" . $home_url . "joborderitem.php?code={$page_title}#discuss{$i}\"><span class=\"dtime\" data-toggle=\"tooltip\" title=\"" . date_format(date_create($created),"F d, Y h:i:s A") . "\">" . date_format(date_create($created),"m-d-Y h:i:s A") . "</span> </a> <span class='label label-default'>{$tag}</span>";
                                    echo "<p>{$note}</p>";
                                    if(!empty($image_url)){
                                        echo "<p><img src=\"" . $home_url . "images/thumbs/" . $image_url . "\" width=\"64\" height=\"64\" data-toggle=\"modal\" data-target=\"#preview\" data-value=\"". $image_url . "\" /></p>";
                                    }
                                echo "</div>";
                            echo "</div>";
                            echo "</div>";
                            $i++;
                        }
                    }
            ?>

            <div class="col-md-12 xd-message">
                <?php if($job_order->status == "Done" || $job_order->status == "approved" || $job_order->status == "Published"){
                    echo "<div class=\"col-md-12\">";
                    echo "<b>Thread is now closed.</b>";
                    echo "</div>";
                }
                else{?>
                <div class="media">
                    <div class="media-left media-top">
                    <?php 
                        echo "<div class=\"xd-circle\" style=\"background-color: #" . $settings->getColor(substr($_SESSION['username'], 0, 1)) . "\">";
                        echo  substr($_SESSION['nickname'], 0, 1) . "</div>";
                    ?>
                        <!--
                            <img class="media-object" src="#" width="64" height="64" />
                            -->
                    </div>
                    <div class="media-body">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ."?&code=" . $itemcode;?>" method="post" enctype="multipart/form-data"> 
                        <b class="media-heading"><?php echo $_SESSION['nickname'] ?>:</b>
                        <fieldset>
                        <div class="form-group">
                            <textarea class="form-control" name="note" placeholder="Comment" rows="3" required></textarea>
                        </div>
                        <div class="form-group clearfix">
                            <div class="pull-left">
                            <label for="tag" class="control-label">Tag</label>
                            <select name="tag">
                                <option></option>
                                <option>Needs Feedback</option>
                                <option>For Revision</option>
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
                        <input type="submit" name="form" class="btn btn-primary" value="Submit" />
                        </fieldset>
                        </form>
                    </div>
                </div>
            <?php } ?>
            </div>
    </div>
        </div>
<?php
if($job_order->status=="Done"){
?>
    <div class="modal fade" id="publishModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            <h4 class="modal-title">Publish <?php echo $itemcode; ?> to Products</h4>
        </div>
            <div class="modal-body">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ."?&code=" . $itemcode;?>" method="post">
                <div class="form-group">
                    <label for="name" class="control-label">Product Name:</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="message-text" class="control-label">Select Image:</label><br/>
                    <!--<select name="productimage" id="productimage">
                    <?php       
                        /*$stmt = $job_order->readJODFeedback($itemcode);
                        $num  = $stmt->rowCount();

                        if($num>0){
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                extract($row);
                                if(!empty($image_url)){
                                    echo "<option value=\"{$image_url}\" data-class=\"avatar\" data-style=\"background-image: url(&apos;". $home_url . "images/" . $image_url ."&apos;);\">{$image_url}</option>";
                                }
                            }
                        }*/
                        ?>
                    </select>
                    -->
                    <?php       
                        $stmt = $job_order->readJODFeedback($itemcode);
                        $num  = $stmt->rowCount();

                        if($num>0){
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                extract($row);
                                if(!empty($image_url)){
                                    //if($role == "hans")
                                        echo "<label class=\"radio-inline\"><input type=\"radio\" name=\"image\" value=\"{$image_url}\" checked /><img title=\"added last {$created}\" src=\"" . $home_url . "images/" . $image_url . "\" style=\"width:100px; height: 100px;\"/></label>";
                                }
                            }
                        }

                        ?>
                    <label class="radio-inline"><input type="radio" name="image" value="none" required>none</label>

                </div>
                <div class="form-group">
                    <b>Visibility:</b>
                    <p class="text-muted">Have this item to be purchased by this requestor only?</p>
                        <div class="radio">
                            <label><input checked type="radio" name="visibility" value="<?php echo $job_order->userid ?>" required />To <?php echo $job_order->nickname ?> only <span class="label label-primary"><span class="glyphicon glyphicon-lock"></span> Private</span></label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" name="visibility" value="" />Allow others to make purchase order of this product <span class="label label-default"><span class="glyphicon glyphicon-globe"></span> Public</span></label>
                    </div>
                    </div>
                
            </div>
            <div class="modal-footer">
                <input type="hidden" name='jod' value='<?php echo $job_order->joborderdetailsid ?>'/>
                <input type="hidden" name='type' value='<?php echo $job_order->type ?>'/>
                <input type="hidden" name='code' value='<?php echo $itemcode ?>'/>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-primary" name="form" value="Publish" />
            </div>
            </form>
            </div>
        </div>
        </div>
</div>
<?php } ?>


<?php
if($job_order->status=="approved" && $_SESSION['role']=='user'){
?>
    <div class="modal fade" id="publishModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            <h4 class="modal-title">Publish <?php echo $itemcode; ?> to Products</h4>
        </div>
            <div class="modal-body">

                <div class="tab">
                    Select:
                    <button class="btn btn-default" onClick='showTab(1)'>New</button>

                    <?php if($job_order->type != 'TH') { ?>
                        <button class="btn btn-default" onClick='showTab(2)'>Existing</button>
                    <?php } ?>
                
                </div>

                <div class="tab">
                <form id="publishNewForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ."?&code=" . $itemcode;?>" method="post">
                    <div class="form-horizontal">
                        <div class="form-group" id="product_name">
                            <label class="control-label col-sm-3">Product Name</label>
                            <div class="col-sm-9">
                                <input type="text" name="productname" class="form-control" placeholder="ex. <?php echo $job_order->note ?>" required />
                            </div>
                        </div>
                        <div class="form-group" id="product_type">
                            <label class="control-label col-sm-3">Type</label>
                            <div class="radio radio col-sm-9">
                                <label for="HH">
                                    <input type="radio" value="HH" name="type" id="TH" <?php if($job_order->type == "HH") echo "checked" ?> disabled>Helmet Holder
                                </label>
                                <label for="TH">
                                    <input type="radio" value="TH" name="type" id="HH" <?php if($job_order->type == "TH") echo "checked" ?> disabled>Ticket Holder
                                </label>
                            </div>
                        </div>
                            <div class="form-group" id="product_tag">
                                <label class="control-label col-sm-3">Category</label>
                                <div class="radio radio col-sm-9">
                                    <label for="personal">
                                        <input type="radio" value="personal" name="tag" id="personal" required>Personal
                                    </label>
                                    <label for="brands">
                                        <input type="radio" value="brands" name="tag" id="brands">Brands
                                    </label>
                                    <label for="special">
                                        <input type="radio" value="special" name="tag" id="special">Special
                                    </label>
                                </div>
                            </div>
                            <div class="form-group" id="item_color">
                                <label class="control-label col-sm-3">Color</label>
                                <div class="col-sm-9">
                                    <select class="form-control input-sm" name="color" id="colors" required></select>
                                </div>
                            </div>
                            <div class="form-group" id="item-img">
                                <label class="control-label col-sm-3">Product Image</label>
                                <div class="col-sm-9">                                
                                <?php       
                                $stmt = $job_order->readJODFeedback($itemcode);
                                $num  = $stmt->rowCount();

                                if($num>0){
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                        extract($row);
                                        if(!empty($image_url)){
                                            if($role == "hans")
                                                echo "<label class=\"radio-inline\"><input type=\"radio\" name=\"image\" value=\"{$image_url}\" checked required /><img title=\"added last {$created}\" src=\"" . $home_url . "images/thumbs/" . $image_url . "\" style=\"width:100px; height: 100px;\"/></label>";
                                        }
                                    }
                                }

                                ?>
                                </div>
                            </div>
                            <div class="form-group" id="item_note">
                                <label class="control-label col-sm-3">Note</label>
                                <div class="col-sm-9">
                                    <textarea name="note" class="form-control" maxlength="100"> </textarea>
                                </div>
                            </div>
                    </div>
                    <div class="clearfix">
                        <div class="pull-left">
                            <a class="btn btn-default" onClick="showTab(0)">Back</a>
                        </div>
                        <div class="pull-right">
                            <button class="btn btn-primary" name="form" value="publishnew">Submit</button>
                        </div>
                    </div>
                </form>
                </div>
            
            <div class="tab">
                <form id="publishExistingForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ."?&code=" . $itemcode;?>" method="post">
                    <div class="form-horizontal">
                        <div class="form-group" id="product_name">
                            <label class="control-label col-sm-3">Product Name</label>
                            <div class="col-sm-9">
                                <select class="form-control input-sm" name="productname" id="existingproductname" required></select>
                            </div>
                        </div>
                        <div class="form-group" id="product_type">
                            <label class="control-label col-sm-3">Type</label>
                            <div class="radio radio col-sm-9">
                                <label for="HH">
                                    <input type="radio" value="HH" name="type" id="TH" <?php if($job_order->type == "HH") echo "checked" ?> disabled>Helmet Holder
                                </label>
                                <label for="TH">
                                    <input type="radio" value="TH" name="type" id="HH" <?php if($job_order->type == "TH") echo "checked" ?> disabled>Ticket Holder
                                </label>
                            </div>
                        </div>
                            <div class="form-group" id="item_color">
                                <label class="control-label col-sm-3">Color</label>
                                <div class="col-sm-9">
                                    <select class="form-control input-sm" name="color" id="colors" required></select>
                                </div>
                            </div>
                            <div class="form-group" id="item-img">
                                <label class="control-label col-sm-3">Product Image</label>
                                <div class="col-sm-9">                                
                                <?php       
                                $stmt = $job_order->readJODFeedback($itemcode);
                                $num  = $stmt->rowCount();

                                if($num>0){
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                        extract($row);
                                        if(!empty($image_url)){
                                            if($role == "hans")
                                                echo "<label class=\"radio-inline\"><input type=\"radio\" name=\"image\" value=\"{$image_url}\" checked required /><img title=\"added last {$created}\" src=\"" . $home_url . "images/thumbs/" . $image_url . "\" style=\"width:100px; height: 100px;\"/></label>";
                                        }
                                    }
                                }

                                ?>
                                </div>
                            </div>
                            <div class="form-group" id="item_note">
                                <label class="control-label col-sm-3">Note</label>
                                <div class="col-sm-9">
                                    <textarea name="note" class="form-control" maxlength="100"> </textarea>
                                </div>
                            </div>
                    </div>
                    <div class="clearfix">
                    <div class="pull-left">
                        <a class="btn btn-default" onClick="showTab(0)">Back</a>
                    </div>
                    <div class="pull-right">
                        <button class="btn btn-primary" name="form" value="publishexisting">Submit</button>
                    </div>
                            </div>
                </form>
                </div>

                <!-- 
                <div style="overflow:auto;">
                <div style="float:right;">
                    <button type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                    <button type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
                </div>
                </div>

                Circles which indicates the steps of the form:
                <div style="text-align:center;margin-top:40px;">
                <span class="step"></span>
                <span class="step"></span>
                </div> -->

<?php /*
                <div class="form-group">
                    <label for="name" class="control-label">Product Name:</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="message-text" class="control-label">Select Image:</label><br/>
                    <!--<select name="productimage" id="productimage">
                    <?php       
                        /*$stmt = $job_order->readJODFeedback($itemcode);
                        $num  = $stmt->rowCount();

                        if($num>0){
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                extract($row);
                                if(!empty($image_url)){
                                    echo "<option value=\"{$image_url}\" data-class=\"avatar\" data-style=\"background-image: url(&apos;". $home_url . "images/" . $image_url ."&apos;);\">{$image_url}</option>";
                                }
                            }
                        }
                        ?>
                    </select>
                    -->
                    <?php       
                        $stmt = $job_order->readJODFeedback($itemcode);
                        $num  = $stmt->rowCount();

                        if($num>0){
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                extract($row);
                                if(!empty($image_url)){
                                    //if($role == "hans")
                                        echo "<label class=\"radio-inline\"><input type=\"radio\" name=\"image\" value=\"{$image_url}\" checked /><img title=\"added last {$created}\" src=\"" . $home_url . "images/" . $image_url . "\" style=\"width:100px; height: 100px;\"/></label>";
                                }
                            }
                        }

                        ?>
                    <label class="radio-inline"><input type="radio" name="image" value="none" required>none</label>

                </div>
                <div class="form-group">
                    <b>Visibility:</b>
                    <p class="text-muted">Have this item to be purchased by this requestor only?</p>
                        <div class="radio">
                            <label><input checked type="radio" name="visibility" value="<?php echo $job_order->userid ?>" required />To <?php echo $job_order->nickname ?> only <span class="label label-primary"><span class="glyphicon glyphicon-lock"></span> Private</span></label>
                        </div>
                        <div class="radio">
                            <label><input type="radio" name="visibility" value="" />Allow others to make purchase order of this product <span class="label label-default"><span class="glyphicon glyphicon-globe"></span> Public</span></label>
                    </div>
                    </div>
                
            </div>
            <div class="modal-footer">
                <input type="hidden" name='jod' value='<?php echo $job_order->joborderdetailsid ?>'/>
                <input type="hidden" name='type' value='<?php echo $job_order->type ?>'/>
                <input type="hidden" name='code' value='<?php echo $itemcode ?>'/>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-primary" name="form" value="Publish" />
            </div>
            */?>

        </div>
        </div>
</div>
<?php } ?>

<?php
if($yes==1 && $job_order->status=='Accepted' && ($job_order->username==$_SESSION['username'] || $role=="superadmin")){
?>
<div class="modal fade" id="finishModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
        <b>Heads Up!</b>
      </div>
      <div class="modal-body">
        <p>You are about to close this job order (<?php echo $itemcode ?>). Make sure you have reviewed
        everything as this will be considered final.</p>

        <p>Be informed, that:</p>

        <?php
        $stmt = $job_order->readJODFeedback($itemcode);
        $num  = $stmt->rowCount();
        $imagecount = 0;
        if($num>0){
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                extract($row);
                if(!empty($image_url)){
                    //if($username == $_SESSION['username'])
                    //echo "<img title=\"added last {$created}\" src=\"" . $home_url . "images/" . $image_url . "\" style=\"width:100px; height: 100px;\"/>";
                    $imagecount += 1;
                }
            }
        }
        echo "<ul>";
        echo "<li>";
        $stmt1 = $job_order->getFeedbackReviewer($itemcode);
        $num1  = $stmt1->rowCount();
        if($num1>0){
            echo "This has been reviewed by ";
            while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)){
                extract($row);
                echo $nickname;
            }
        }
        else echo "No one had reviewed this job order.";
        echo "</li>";
        echo "<li>There are " . $imagecount . " image/s in the discussion.</li>";
        echo "<li>This needs to be published, before you could proceed adding this item to purchase order.</li>";
        echo "</ul>";
        ?>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      <?php
      echo "<a href=\"" . $home_url . "joborderitem.php?code={$page_title}&amp;status=approved\" class=\"btn btn-primary\"><span class=\"glyphicon glyphicon-ok\"></span> Mark As Finish</a>";
      ?>
      </div>
    </div>
    </div>
  </div>
</div>

<?php } ?>

<div class="modal fade" id="preview" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <img class="preview" />
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <a href="#" class="btn btn-primary xd-download" download="proposal.jpg">Download</a>
      </div>
    </div>
    </div>
  </div>
</div>

<?php if ($job_order->username==$_SESSION['username'] && $job_order->status=='For Approval'){ ?>
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
<?php } ?>

<div class="modal fade" id="share" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        <h4 class="modal-title">Share</h4>
      </div>
      <div class="modal-body">
                <div class="btn-group" role="group">
                <button class="btn btn-default btn-lg">FB</button>
                <button class="btn btn-default btn-lg">Messenger</button>
                <button class="btn btn-default btn-lg">Email</button>
            
                </div>
      </div>
      <div class="modal-footer">
          <div data-dismiss="modal" class="btn btn-default">Close</div>
      </div>
    </div>
  </div>
</div>
<script src="js/joi_script.js"></script>
<script src="js/script.js"></script>

    </div>
    <?php
    include 'template/footer.php';
    ?>