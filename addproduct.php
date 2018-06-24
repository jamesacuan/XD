<?php

include_once "config/core.php";
include_once "config/database.php";
include_once "objects/product.php";


$database = new Database();
$db = $database->getConnection();

$job_order  = new Product($db);
$page_title = "Add a Product";
$page_theme = "";

$require_login=true;
include_once "functions/login_check.php";

include 'template/header.php';
?>

<div class="row xd-heading">
    <div class="clearfix">
        <div class="page-header pull-left">
            <h1><?php echo isset($page_title) ? $page_title : "Index"; ?></h1>
        </div>
    </div>
</div>

<div class="row xd-content">
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
                      <input type="radio" onchange="fetch_colors('HH')" value="HH" name="type" id="HH" />Helmet Holder
                  </label>
                  <label for="TH">
                      <input type="radio" onchange="fetch_colors('TH')" value="TH" name="type" id="TH" />Ticket Holder
                  </label>
              </div>
          </div>
              <div class="form-group" id="product_tag">
                  <label class="control-label col-sm-3">Category</label>
                  <div class="radio radio col-sm-9">
                      <label for="plain">
                          <input type="radio" value="plain" name="tag" id="plain">Plain
                      </label>
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
              <div class="form-group" id="item-img">
                  <label class="control-label col-sm-3">Product Image</label>
                  <div class="col-sm-9">                                
                    <div id="colors">
                    </div>
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
    <h4>Form for Existing should be in here</h4>
    <div class="clearfix">
          <div class="pull-left">
              <a class="btn btn-default" onClick="showTab(0)">Back</a>
          </div>

      </div>
  </div>

<!--
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
                -->
<style>
.tab {
  display: none;
}
</style>
<script>
/*
var currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab); // Display the current tab

function showTab(n) {
  // This function will display the specified tab of the form ...
  var x = document.getElementsByClassName("tab");
  x[n].style.display = "block";
  // ... and fix the Previous/Next buttons:
  if (n == 0) {
    document.getElementById("prevBtn").style.display = "none";
  } else {
    document.getElementById("prevBtn").style.display = "inline";
  }
  if (n == (x.length - 1)) {
    document.getElementById("nextBtn").innerHTML = "Submit";
  } else {
    document.getElementById("nextBtn").innerHTML = "Next";
  }
  // ... and run a function that displays the correct step indicator:
  fixStepIndicator(n)
}

function nextPrev(n) {
  // This function will figure out which tab to display
  var x = document.getElementsByClassName("tab");
  // Exit the function if any field in the current tab is invalid:
  if (n == 1 && !validateForm()) return false;
  // Hide the current tab:
  x[currentTab].style.display = "none";
  // Increase or decrease the current tab by 1:
  currentTab = currentTab + n;
  // if you have reached the end of the form... :
  if (currentTab >= x.length) {
    //...the form gets submitted:
    document.getElementById("regForm").submit();
    return false;
  }
  // Otherwise, display the correct tab:
  showTab(currentTab);
}

function validateForm() {
  // This function deals with validation of the form fields
  var x, y, i, valid = true;
  x = document.getElementsByClassName("tab");
  y = x[currentTab].getElementsByTagName("input");
  // A loop that checks every input field in the current tab:
  for (i = 0; i < y.length; i++) {
    // If a field is empty...
    if (y[i].value == "") {
      // add an "invalid" class to the field:
      y[i].className += " invalid";
      // and set the current valid status to false:
      valid = false;
    }
  }
  // If the valid status is true, mark the step as finished and valid:
  if (valid) {
    document.getElementsByClassName("step")[currentTab].className += " finish";
  }
  return valid; // return the valid status
}

function fixStepIndicator(n) {
  // This function removes the "active" class of all steps...
  var i, x = document.getElementsByClassName("step");
  for (i = 0; i < x.length; i++) {
    x[i].className = x[i].className.replace(" active", "");
  }
  //... and adds the "active" class to the current step:
  x[n].className += " active";
}*/
</script>
<script src='assets/js/addproduct.js'></script>

<?php include 'template/footer.php'; ?>