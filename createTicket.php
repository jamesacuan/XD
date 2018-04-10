<?php
include_once "login_check.php";
$require_login=true;

include_once "config/core.php";
include_once "config/database.php";
include_once "objects/ticket.php";

$database = new Database();
$db = $database->getConnection();

$ticket = new Ticket(db);
$page_title="Create Ticket";

include 'template-header.php'
?>

<?php

if($_POST){
    $product->name = $_POST['name'];
    $product->description = $_POST['description'];
    $product->category_id = $_POST['category_id'];
    $image=!empty($_FILES["image"]["name"])
    ? sha1_file($_FILES['image']['tmp_name']) . "-" . basename($_FILES["image"]["name"]) : "";
    $product->image = $image;

    // create the product
    if($product->create()){
        echo $product->uploadPhoto();
        echo "<div class='alert alert-success'>Product was created.</div>";
        // try to upload the submitted file
        // uploadPhoto() method will return an error message, if any.
        
    }
 
    // if unable to create the product, tell the user
    else{
        echo "<div class='alert alert-danger'>Unable to create product.</div>";
    }
}

?>

<form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">
<?php
    $product = isset($_GET['product']) ? $_GET['product'] : "";
    // if login was successful
    if($product=='HHP'){
        echo "<div class='col-sm-2'></div><div class='col-sm-10'><h4>Helmet Holder (Plain)</h4></div>";
    }
    else if ($product=='HHC'){
        echo "<h3>Helmet Holder (Custom Logo)</h3>";
    }
    else if ($product=='THP'){
        echo "<h3>Ticket Holder (Plain)</h3>";
    }
    else if ($product=='THC'){
        echo "<h3>Ticket Holder (Custom)</h3>";
    }
    else {
        echo "<div class=\"form-group\">";
        echo " <label for=\"inputEmail\" class=\"col-sm-2 control-label\">Type</label>";
        echo "  <div class=\"col-sm-10\">";
        echo "<select>";
        echo "<option>Helmet Holder (Plain)</option>";
        echo "<option>Helmet Holder (Custom)</option>";
        echo "<option>Ticket Holder (Plain)</option>";
        echo "<option>Ticket Holder (Custom)</option>";
        echo "</select>";
        echo "  </div>";
        echo "</div>";
    }
?>

  <div class="form-group">
    <label for="note" class="col-sm-2 control-label">Note</label>
    <div class="col-sm-10">
      <textarea class="form-control" id="note" placeholder="Add a note"></textarea>
    </div>
  </div>

  <div class="form-group">
  <label for="fileToUpload" class="col-sm-2 control-label" data-toggle="tooltip" data-placement="right" title="Upload JPG/PNG files of up to 3MB only">Upload Image</label>
  <div class="col-sm-10">
    <input type="file" name="fileToUpload" id="fileToUpload">
  </div>
  </div>

  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default btn-primary">Save</button>
    </div>
  </div>
</form>
<script>
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>

<?php include 'template-footer.php' ?>