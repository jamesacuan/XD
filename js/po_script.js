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
       $('#save').text('Save');
    });
   
    $('input[name="product"]').click(function(){
       $('#item_type').show();
       $('#item_color').show();
       fetch_colors();
       $('#item_custom').hide();
       $('input[name="type"]').prop('checked',false);
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
     $('#item_dialog').dialog('option', 'title', 'Edit Item');
     $('#item_dialog').dialog('open');
    });
   
    $(document).on('click', '.remove_details', function(){
     var row_id = $(this).attr("id");
     if(confirm("Are you sure you want to remove this row data?"))
     {
      $('#row_'+row_id+'').remove();
     }
     else
     {
      return false;
     }
    });
    
    $('#save').click(function(){
       var err=0;
       var product = "";
       var type = "";
       var color = "";
       var quantity = "";
       var custom = "";
       var note   = "";
   
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
       note = $('textarea[name="note"]').val();
   
       if (err==0){
           if($('#save').text() == 'Save'){
               count = count + 1;
               color = $("#colors option:selected").text();
               custom = $("#custom option:selected").text();
               output = '<tr id="row_'+count+'">';
               output += '<td></td>';
               if(type=='custom'){
                   output += '<td><b>'+product+' - '+custom+'</b>';
               }
               else
                   output += '<td><b>'+product+' - '+type+'</b>';
               if(note=="")
                   output += "";
               else
                   output += '<br/><span>'+note+'</span>';
               output += '<input type="hidden" name="hidden_product[]" id="product'+count+'" value="'+$("input[name='product']:checked").val()+'" /></td>';
               output += '<td>'+color+'</td>';
               output += '<td>'+quantity+'</td>';
               output += '<td><button type="button" name="view_details" class="btn btn-warning btn-xs view_details" id="'+count+'">View</button>';
               output += '<button type="button" name="remove_details" class="btn btn-danger btn-xs remove_details" id="'+count+'">Remove</button></td>';
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
       $('#colors').html("errororor");
      }
     })
   }
   
});