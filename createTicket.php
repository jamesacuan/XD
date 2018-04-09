<?php
// core configuration
include_once "config/core.php";

// set page title
$page_title="Create Ticket";

// include login checker
$require_login=true;
include_once "login_check.php";
include 'template-header.php'
?>
<form class="form-horizontal">
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
    <label for="inputEmail3" class="col-sm-2 control-label">Customer</label>
    <div class="col-sm-10">
      <input type="email" class="form-control" id="inputEmail3" placeholder="Customer Name">
    </div>
  </div>
  <div class="form-group">
  <label for="upload" class="col-sm-2 control-label" data-toggle="tooltip" data-placement="right" title="Upload JPG/PNG files of up to 3MB only">Upload Image</label>
  <div class="col-sm-10">
    <input type='file' />
  </div>
  </div>
  <div class="form-group">
    <label for="note1" class="col-sm-2 control-label">Note</label>
    <div class="col-sm-10">
      <textarea class="form-control" id="inputPassword3" placeholder="Add a note"></textarea>
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