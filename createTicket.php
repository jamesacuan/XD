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