<?php
include_once "login_check.php";
$require_login=true;

include_once "config/core.php";
include_once "config/database.php";
include_once "objects/job_order.php";

$database = new Database();
$db = $database->getConnection();

$job_order = new JobOrder($db);
$page_title="Create New Job Order";

include 'template/header.php';
$newJO ="";
?>

<div class='container'>
<?php
if(isset($_FILES['image']) && $_POST){
    $errors= array();
    $file_name = $_FILES['image']['name'];
    $file_size = $_FILES['image']['size'];
    $file_tmp  = $_FILES['image']['tmp_name'];
    $file_type = $_FILES['image']['type'];
    $tmp       = explode('.',$file_name);
    $file_ext  = strtolower(end($tmp));
    $expensions= array("jpeg","jpg","png");
    
    if(isset($_POST['joid'])){
        $newJO = $_POST['joid'];
    }
    else{
        $job_order->getJobOrderCount();
        $newJO = $job_order->jocount + 1;
    }

    $job_order->getTypeCount($_POST['type']);
    $newTY = $job_order->tycount + 1;

    $job_order->userid = $_SESSION['userid'];
    $job_order->type = $_POST['type'];
    
    if(in_array($file_ext,$expensions)=== false){
       $errors[]="extension not allowed, please choose a JPEG or PNG file.";
    }
    
    if($file_size > 2097152) {
       $errors[]='File size must be excately 2 MB';
    }
    
    if($newTY<10){
        $job_order->code = $_POST['type'] . "-000" . $newTY;
    }
    elseif($newTY<100){
        $job_order->code = $_POST['type'] . "-00" . $newTY;
    }
    elseif($newTY<1000){
        $job_order->code = $_POST['type'] . "-0" . $newTY;
    }
    else{
        $job_order->code = $_POST['type'] . "-" . $newTY;
    }
    $job_order->code;

    //rename file
    
    $file_name = substr(sha1($job_order->code), -20) . "." .$file_ext;

    $job_order->note       = $_POST['note'];
    $job_order->image_url  = $file_name;
    $job_order->status     = "For Approval";
    $job_order->expectedJO = $newJO;
    
    if(empty($errors)==true && $job_order->create()) {
       move_uploaded_file($file_tmp,"images/".$file_name);
       echo "<div class=\"row\"><div class=\"col-md-12\"><div class='alert alert-success'>";
          echo "<h4>Job Order #{$newJO} was created.</h4>";
          echo "<span>You may continue request image for render by adding it below, or go back to dashboard.</span>";
       echo "</div></div></div>";
    }else{
       echo "<div class=\"row\"><div class=\"col-md-12\"><div class='alert alert-danger'>";
       echo "<h4>Unable to create job order.</h4>";
       print_r($errors);
        echo "</div></div></div>";
    }
}
?>
<?php if($_SESSION['role']=="hans"||$_SESSION['role']=="designer"){
    echo "<div class=\"row\"><div class=\"col-md-12\"><div class='alert alert-danger'>";
    echo "<h4>This page is for users only</h4>";
    echo "</div></div></div>";
}
?>
<div class="row">
<div class="col-md-8">
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data"> 
<fieldset <?php if($_SESSION['role']=="hans"|| $_SESSION['role']=="designer") echo "disabled"; ?>>
  <div class="form-group">
    <label class="control-label">Type</label>
    <div class="radio">
        <label class="radio-inline">
            <input type="radio" name="type" value="HH">Helmet Holder
        </label>
        <label class="radio-inline">
            <input type="radio" name="type" value="TH">Ticket Holder
        </label>
    </div>
  </div>

  <div class="form-group">
    <label class="control-label" for="noteArea">Note</label>
    <textarea class="form-control" name="note" placeholder="Add a note" rows="3" id="noteArea" required></textarea>
  </div>

  <div class="form-group">
    <label for="url" class="control-label">Upload Image</label>
    <span class="help-block">Please upload supported images (.jpg or .png) of up to 2MB.</span>

    <div>
        <input type="file" name="image" id="url" required/>
        <!--
            <input type="text" name="url" class="form-control" id="url" placeholder="image url" required>
        -->
    </div>
  </div>
  <?php
  if($_POST){
    echo "<input type=\"hidden\" name='joid' value='{$newJO}'/>";
  }
  ?>
  <button type="submit" class="btn btn-primary">Submit</button>
</fieldset>
</form>
</div>
<div class="col-md-4">
<?php
  if($_POST){
    echo "<h4>Recently added to job order</h4>";
    echo "<div class='panel-group' id='accordion' role='tablist'>";
    echo "</div>";
  }
  ?>
  </div>
</div>
</div>

<?php include 'template/footer.php'; ?>

