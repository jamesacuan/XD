$(document).ready(function(){ 
    $('#publish').click(function(){
      showTab(0);
        clearDialog();
    });
    
    $('#preview').on('shown.bs.modal', function (event) {
      var button   = $(event.relatedTarget);
      var filename = button.data('value');
      var modal    = $(this);
      modal.find('.preview').attr('src', home_url + "images/" + filename);
      modal.find('.xd-download').attr('href', home_url + "images/" + filename);
      modal.find('.xd-download').attr('download', filename);
    })

    $('#finish').on('shown.bs.modal', function (event) {
      var button   = $(event.relatedTarget);

    })


    var currentTab = 0; // Current tab is set to be the first tab (0)
    showTab(currentTab); // Display the current tab
    
    console.log(currentTab);
    fetch_colors($("input[name='type']:checked").val());
    fetch_productitem('HH');

    $('#existingproductname').on('change', function() {
      var defaultselect = $('#existingproductname').val();
      console.log(defaultselect);
      fetch_remainingproductcolors(defaultselect);
    })

    function fetch_colors(type){
      console.log(type);
      $.ajax({
          url:"functions/fetch_colors.php",
          method:"POST",
          data:{type:type},
          success:function(data){
              $('#publishNewForm #colors').html(data);
          }
      })
     }

     function fetch_productitem(type){
      $.ajax({
          url:"functions/fetch_productitem.php",
          method:"POST",
          data:{type:type},
          success:function(data){
              $("select[name='productname']").html(data);
          }
      })
     }

     function fetch_remainingproductcolors(id){
       $.ajax({
          url:"functions/fetch_remainingcolors.php",
          method:"POST",
          data:{id:id},
          success:function(data){
              $("#publishExistingForm #colors").html(data);
          }
       })
     }
});

$( function() {
    $.widget( "custom.iconselectmenu", $.ui.selectmenu, {
      _renderItem: function( ul, item ) {
        var li = $( "<li>" ),
          wrapper = $( "<div>", { text: item.label } );
 
        if ( item.disabled ) {
          li.addClass( "ui-state-disabled" );
        }
 
        $( "<span>", {
          style: item.element.attr( "data-style" ),
          "class": "ui-icon " + item.element.attr( "data-class" )
        })
          .appendTo( wrapper );
 
        return li.append( wrapper ).appendTo( ul );
      }
    });

 
    $( "#productimage" )
      .iconselectmenu()
      .iconselectmenu( "menuWidget")
        .addClass( "ui-menu-icons avatar" );

});

function clearDialog(){
    $('input[name="name"]').val('');
    $('input[name="image"]').prop('checked',false);
    $('input[name="visibility"]').prop('checked',false);
    $('.form-group').removeClass('has-error');
 }


function showTab(n) {
  // This function will display the specified tab of the form ...
  var x = document.getElementsByClassName("tab");
  var $publishtitle = $('#publishModal .modal-title').text();


  if(n==1){
    hideTab(0);
    hideTab(2);
    $('#publishModal .modal-title').text("Add New Product");
  }
  else if(n==2){
    hideTab(1);
    hideTab(0);
    $('#publishModal .modal-title').text("Add as a variant of an Existing Product");
  }
  else if(n==0){
    $("#publishNewForm")[0].reset();
    hideTab(1);
    hideTab(2);
    $('#publishModal .modal-title').text("Publish Product");
  }

  x[n].style.display = "block";
  // ... and fix the Previous/Next buttons:
  /*if (n == 0) {
    document.getElementById("prevBtn").style.display = "none";
  } else {
    document.getElementById("prevBtn").style.display = "inline";
  }
  if (n == (x.length - 1)) {
    document.getElementById("nextBtn").innerHTML = "Submit";
  } else {
    document.getElementById("nextBtn").innerHTML = "Next";
  }*/
  // ... and run a function that displays the correct step indicator:
  //fixStepIndicator(n)
}

function hideTab(n){
  var x = document.getElementsByClassName("tab");
  x[n].style.display = "none";
  /*if (n == 1 && !validateForm()) return false;
  x[currentTab].style.display = "none";
  currentTab = currentTab + n;
  if (currentTab >= x.length) {
    document.getElementById("regForm").submit();
    return false;
  }*/

}
/*function nextPrev(n) {
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
}
*/

