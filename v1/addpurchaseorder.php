<?php
include_once "login_check.php";
$require_login=true;

include_once "config/core.php";
include_once "config/database.php";
include_once "objects/purchase_order.php";

$database = new Database();
$db = $database->getConnection();

$job_order = new PurchaseOrder($db);
$page_title="Create New Purchase Order";

include 'template/header.php';
?>

<div class="container">
<div align="right" style="margin-bottom:5px;">
    <button type="button" name="add" id="add_item" class="btn btn-success">Add Item</button>
   </div>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" id="purchase_order">
<!--
    <div class="form-group" id="po_table">
       
    </div>
-->
    <table class="table table-hover table-bordered table-striped">
        <thead>
            <tr>
                <th class="col-xs-1">Item</th>
                <th class="col-xs-5">Product</th>
                <th class="col-xs-2">Color</th>
                <th class="col-xs-1">Qty</th>
                <th class="col-xs-3">Actions</th>
            </tr>
        </thead>
        <tbody id="po_table">      
        </tbody>
    </table> 
    <div>
     <input type="submit" name="insert" id="insert" class="btn btn-primary" value="Save" />
    </div>
</form>
</div>

<!-- dialog -->
<div id="item_dialog" title="Add Data">
   <p class="bg-danger" id="dialog_warn"></p>
   <div class="form-group" id="item_product">
       <label>Product</label>
       <div class="radio">
            <label for="HH" class="radio-inline">
                <input type="radio" value="HH" name="product" id="HH">Helmet Holder
            </label>
            <label for="TH" class="radio-inline">
                <input type="radio" value="TH" name="product" id="TH">Ticket Holder
            </label>
        </div>
    </div>
   <div class="form-group" id="item_type">
        <label>Type</label>
        <div class="radio">
            <label for="pln">
                <input type="radio" value="plain" name="type" id="pln">Plain
            </label>
            <label for="csm">
                <input type="radio" value="custom" name="type" id="csm">Custom
            </label>
        </div>
   </div>
   <div class="form-group" id="item_color">
       <label>Color</label>
       <select class="form-control input-sm" name="color" id="colors"></select>
   </div>
   <div class="form-group" id="item_custom">
       <label>Custom Logo</label>
       <select class="form-control input-sm" name="custom" id="custom"></select>
   </div>
   <div class="form-group" id="item_quantity">
    <label>Quantity</label>
    <input type="text" name="quantity" class="form-control" />
    <span id="error_quantity" class="text-danger"></span>
   </div>
   <div class="form-group" align="center">
    <input type="hidden" name="row_id" id="hidden_row_id" />
    <button type="button" name="save" id="save" class="btn btn-info">Save</button>
   </div>
  </div>

  <div id="action_alert" title="Action">

</div>

<script>  
$(document).ready(function(){ 
 var count = 0;
 $('#item_dialog').dialog({
  autoOpen:false,
  width:400
 });

 $('#add_item').click(function(){
    clearAddDialog();
    $('#item_dialog').dialog('option', 'title', 'Add Item');
    $('#item_dialog').dialog('open');
    $('#item_type').hide();
    $('#item_color').hide();
    $('#item_custom').hide();
 });

 $('input[name="product"]').click(function(){
    $('#item_type').show();
    $('#item_color').show();
    fetch_colors();
    fetch_products(type);
 });
 

 $('#csm').click(function(){
    $('#item_custom').show();
    type=$('input[name="product"]:checked').val();
    fetch_products(type);
 });
 $('#pln').click(function(){
    $('#item_custom').hide();
 });

$(document).on('click', '.view_details', function(){
  var row_id = $(this).attr("id");
  var first_name = $('#first_name'+row_id+'').val();
  var last_name = $('#last_name'+row_id+'').val();
  $('#first_name').val(first_name);
  $('#last_name').val(last_name);
  $('#save').text('Edit');
  $('#hidden_row_id').val(row_id);
  $('#item_dialog').dialog('option', 'title', 'Edit Data');
  $('#item_dialog').dialog('open');
 });

 $('#save').click(function(){
    var err=0;
    var product = "";
    var type = "";
    var color = "";
    var quantity = "";
    var custom = "";

    if($("input[name='product']").is(":checked")==false){
        $('#item_product').addClass('has-error');
        err+=1;
    }else{
        if($("input[name='product']:checked").val()=='HH')
        product = "Helmet Holder";
        else
        product = "Ticket Holder";
    }

    if($("input[name='type']").is(":checked")==false){
        $('#item_type').addClass('has-error');
        err+=1;
    }else{
        type = $("input[name='type']:checked").val();
    }
    if($("input[name='quantity']").val()==""){
        $('#item_quantity').addClass('has-error');
        err+=1;
    }else{
        quantity = $("input[name='quantity']").val();
    }
    if(err!=0){
        $('#dialog_warn').text('Please fill-in required fields');
    }

    if (err==0){
        if($('#save').text() == 'Save'){
            count = count + 1;
            color = $("#colors option:selected").text();
            custom = $("#custom option:selected").text();
            output = '<tr id="row_'+count+'">';
            output += '<td></td>';
            output += '<td>'+product+' - '+type+' - '+custom+'</td>';
            output += '<td>'+color+'</td>';
            output += '<td>'+quantity+'</td>';
            output += '<td><a href="#" class="btn btn-warning btn-xs view_details">View</a> <a href="#" class="btn btn-danger btn-xs">Delete</a></td>';
            output += '</tr>';
            $('#po_table').append(output);
            
            /*
            count = count + 1;
            output = '<div class="row row_'+count+'">';
            output += '<div class="col-md-1">';
            output += '<span class="glyphicon glyphicon-picture"></span>';
            output += '</div>';
            output += '<div class="col-md-7">';
            output += '<div>title</div>';
            output += '<div>type - custom</div>';
            output += '</div>';
            output += '<div class="col-md-2">';
            output += '<div>Qty: 1</div>';
            output += '</div>';
            output += '<div class="col-md-2">';
            output += '<div><a href="#" class="btn btn-warning btn-xs">View</a><a href="#" class="btn btn-danger btn-xs">Delete</a></div>';
            output += '</div>';
            output += '</div>';
            $('#po_table').append(output);
            */    
                /*output = '<tr id="row_'+count+'">';
                output += '<td>'+first_name+' <input type="hidden" name="hidden_first_name[]" id="first_name'+count+'" class="first_name" value="'+first_name+'" /></td>';
                output += '<td>'+last_name+' <input type="hidden" name="hidden_last_name[]" id="last_name'+count+'" value="'+last_name+'" /></td>';
                output += '<td><button type="button" name="view_details" class="btn btn-warning btn-xs view_details" id="'+count+'">View</button></td>';
                output += '<td><button type="button" name="remove_details" class="btn btn-danger btn-xs remove_details" id="'+count+'">Remove</button></td>';
                output += '</tr>';
                */
            }
            else
            {
                var row_id = $('#hidden_row_id').val();
                output = '<td>'+first_name+' <input type="hidden" name="hidden_first_name[]" id="first_name'+row_id+'" class="first_name" value="'+first_name+'" /></td>';
                output += '<td>'+last_name+' <input type="hidden" name="hidden_last_name[]" id="last_name'+row_id+'" value="'+last_name+'" /></td>';
                output += '<td><button type="button" name="view_details" class="btn btn-warning btn-xs view_details" id="'+row_id+'">View</button></td>';
                output += '<td><button type="button" name="remove_details" class="btn btn-danger btn-xs remove_details" id="'+row_id+'">Remove</button></td>';
                $('#row_'+row_id+'').html(output);
            }
            $('#item_dialog').dialog('close');
    }
 });


function clearAddDialog(){
    $('input[name="product"]').prop('checked',false);
    $('input[name="type"]').prop('checked',false);
    $('select[name="color"]').empty();
    $('select[name="custom"]').empty();
    $('input[name="quantity"]').val('');
    $('.form-group').removeClass('has-error');
    $('#dialog_warn').text('');
}

function fetch_products(type){
  $.ajax({
   url:"objects/products/fetch.php",
   method:"POST",
   data:{type:type},
   success:function(data)
   {
    $('#custom').html(data);
   }
  })
}

function fetch_colors(type){
  $.ajax({
   url:"objects/products/fetch_colors.php",
   method:"POST",
   success:function(data)
   {
    $('#colors').html(data);
   }
  })
}

}); 
</script>

<?php 
include 'template/footer.php';
?>