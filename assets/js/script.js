var home_url = "http://localhost/xd/";
//var home_url = "http://taxcalculator.pe.hu/";

$('#image').on('shown.bs.modal', function (event) {
    var button   = $(event.relatedTarget);
    var filename = button.data('file');
    var modal    = $(this);
    modal.find('.job-order-for-render').attr('src', home_url + "images/" + filename);
})

$('#clear').on('shown.bs.modal', function (event) {
    var modal  = $(this);
    modal.find('.delmodal').attr('href', home_url + "?truncate=Y");
})


$("button[data-close='alert']").click(function(){
    console.log('closing');
    $('.xd-alert').fadeToggle();
})


$(document).ready( function () {
    $('[data-toggle="tooltip"]').tooltip();
    $('[data-toggle="popover"]').popover();  
    initMenu();
    $(document).bind('keydown', '/', function(){
        $('.nav-search input[type="search"]')[0].focus();
    });
    $(document).bind('keydown', 'shift+h', function(){
        window.location.href = home_url;
    });
    $(document).bind('keydown', 'shift+j', function(){
        window.location.href = home_url + "joborders.php";
    });
    $(document).bind('keydown', 'shift+p', function(){
        window.location.href = home_url + "purchaseorders.php";
    });
    $(document).bind('keydown', 'shift+r', function(){
        window.location.href = home_url + "products.php";
    });
    $(document).bind('keypress', 'c+j', function(){
        window.location.href = home_url + "addjoborder.php";
    });
});


moment().format();
setMoment();
function setMoment(){
    x=document.getElementsByClassName("dtime");  // Find the elements
    for(var i = 0; i < x.length; i++){
        x[i].innerText = moment(x[i].innerText, 'MM-DD-YYYY h:m:s A').fromNow();
        console.log(x[i].innerText);
    }
}

$("#menu-toggle-2").click(function(e) {
    e.preventDefault();
    $("#wrapper").toggleClass("toggled-2");
    $('#menu ul').hide();
});

function initMenu() {
    $('#menu ul').hide();
    $('#menu ul').children('.current').parent().show();
    //$('#menu ul:first').show();
    $('#menu li a').click(
        function() {
            var checkElement = $(this).next();
            if((checkElement.is('ul')) && (checkElement.is(':visible'))) {
            return false;
            }
            if((checkElement.is('ul')) && (!checkElement.is(':visible'))) {
            $('#menu ul:visible').slideUp('normal');
            checkElement.slideDown('normal');
            return false;
            }
            }
        );
}
$(window).scroll(function (event) {
    var $sbar = Math.max(document.body.scrollTop,document.documentElement.scrollTop);
    if($sbar == 0){
        $('.xd-navbar').css('box-shadow','none');
        console.log($sbar);
    }
    else{
        $('.xd-navbar').css('box-shadow','0 4px 5px 0 rgba(0,0,0,0.14),0 1px 10px 0 rgba(0,0,0,0.12),0 2px 4px -1px rgba(0,0,0,0.2)');
    }
});

var mywindow = $(window);
var mypos = mywindow.scrollTop();
var up = false;
var newscroll;
mywindow.scroll(function () {
    newscroll = mywindow.scrollTop();
    if (newscroll > mypos && !up) {
        $('#footer').stop().slideToggle();
        up = !up;
        console.log(up);
    } else if(newscroll < mypos && up) {
        $('#footer').stop().slideToggle();
        up = !up;
    }
    mypos = newscroll;
});