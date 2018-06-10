$(document).ready(function(){ 

var currentTab = 0; // Current tab is set to be the first tab (0)

showTab(currentTab);
console.log(currentTab);

});

function showTab(n) {
    var x = document.getElementsByClassName("tab");
        if(n==1){
            hideTab(0);
            hideTab(2);
        }
        else if(n==2){
            hideTab(1);
            hideTab(0);
        }
        else if(n==0){
            hideTab(1);
            hideTab(2);
        }
x[n].style.display = "block";
}
        
function hideTab(n){
    var x = document.getElementsByClassName("tab");
    x[n].style.display = "none";
}

function fetch_colors(type){
    console.log(type);
    $.ajax({
        url:"functions/fetch_colors_new.php",
        method:"POST",
        data:{type:type},
        success:function(data){
            $('#publishNewForm #colors').html(data);
        }
    })
}

function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
  
      reader.onload = function(e) {
        $('#blah').attr('src', e.target.result);
      }
  
      reader.readAsDataURL(input.files[0]);
    }
}
  
  $("input[type='file']").change(function() {
    //readURL(this);
  });
