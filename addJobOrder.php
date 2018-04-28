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
    <div id="noteArea">
    </div>    <textarea class="form-control" name="note" placeholder="Add a note" rows="3"  required></textarea>
    <div class="btn-toolbar" data-role="editor-toolbar" data-target="#editor">
      <div class="btn-group">
        <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font"><i class="icon-font"></i><b class="caret"></b></a>
          <ul class="dropdown-menu">
          </ul>
        </div>
      <div class="btn-group">
        <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font Size"><i class="icon-text-height"></i>&nbsp;<b class="caret"></b></a>
          <ul class="dropdown-menu">
          <li><a data-edit="fontSize 5"><font size="5">Huge</font></a></li>
          <li><a data-edit="fontSize 3"><font size="3">Normal</font></a></li>
          <li><a data-edit="fontSize 1"><font size="1">Small</font></a></li>
          </ul>
      </div>
      <div class="btn-group">
        <a class="btn" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="icon-bold"></i></a>
        <a class="btn" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i class="icon-italic"></i></a>
        <a class="btn" data-edit="strikethrough" title="Strikethrough"><i class="icon-strikethrough"></i></a>
        <a class="btn" data-edit="underline" title="Underline (Ctrl/Cmd+U)"><i class="icon-underline"></i></a>
      </div>
      <div class="btn-group">
        <a class="btn" data-edit="insertunorderedlist" title="Bullet list"><i class="icon-list-ul"></i></a>
        <a class="btn" data-edit="insertorderedlist" title="Number list"><i class="icon-list-ol"></i></a>
        <a class="btn" data-edit="outdent" title="Reduce indent (Shift+Tab)"><i class="icon-indent-left"></i></a>
        <a class="btn" data-edit="indent" title="Indent (Tab)"><i class="icon-indent-right"></i></a>
      </div>
      <div class="btn-group">
        <a class="btn" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i class="icon-align-left"></i></a>
        <a class="btn" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i class="icon-align-center"></i></a>
        <a class="btn" data-edit="justifyright" title="Align Right (Ctrl/Cmd+R)"><i class="icon-align-right"></i></a>
        <a class="btn" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i class="icon-align-justify"></i></a>
      </div>
      <div class="btn-group">
		  <a class="btn dropdown-toggle" data-toggle="dropdown" title="Hyperlink"><i class="icon-link"></i></a>
		    <div class="dropdown-menu input-append">
			    <input class="span2" placeholder="URL" type="text" data-edit="createLink"/>
			    <button class="btn" type="button">Add</button>
        </div>
        <a class="btn" data-edit="unlink" title="Remove Hyperlink"><i class="icon-cut"></i></a>

      </div>
      
      <div class="btn-group">
        <a class="btn" title="Insert picture (or just drag & drop)" id="pictureBtn"><i class="icon-picture"></i></a>
        <input type="file" data-role="magic-overlay" data-target="#pictureBtn" data-edit="insertImage" />
      </div>
      <div class="btn-group">
        <a class="btn" data-edit="undo" title="Undo (Ctrl/Cmd+Z)"><i class="icon-undo"></i></a>
        <a class="btn" data-edit="redo" title="Redo (Ctrl/Cmd+Y)"><i class="icon-repeat"></i></a>
      </div>
      <input type="text" data-edit="inserttext" id="voiceBtn" x-webkit-speech="">
    </div>
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
<script src="js/script.js"></script>
<?php include 'template/footer.php'; ?>

