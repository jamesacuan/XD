var home_url = "http://localhost/xd/";

$('#image').on('shown.bs.modal', function (event) {
    var button   = $(event.relatedTarget);
    var filename = button.data('file');
    var modal    = $(this);
    modal.find('.job-order-for-render').attr('src', home_url + "images/" + filename);
})

$('#warn').on('shown.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var _jodid = button.data('id');
    var modal  = $(this);
    modal.find('.delmodal').attr('href', home_url + "joborders.php?id=" + _jodid + "&delete=Y");
})

$('#clear').on('shown.bs.modal', function (event) {
    var modal  = $(this);
    modal.find('.delmodal').attr('href', home_url + "?truncate=Y");
})

$(document).ready( function () {
    var jobordertable = $('#joborders').DataTable({
        fixedHeader: {
            header: true
        },
        "pageLength": 25
    });
    var filteredjotable = jobordertable
        .columns(6)
        .data()
        //.search('^(?:(?!Published).)*$\r?\n?', true, false) //The RegExp search all string that not cointains USA
        .filter( function ( value, index ) {
            //return value != 20 ? true : false;
            if(value != "Published")
                return true;
            else return false;
        } )
        .draw();

    $('#purchaseorders').DataTable({
        "aLengthMenu": [[10, 25, 50, 75, -1], [10, 25, 50, 75, "All"]],
        "pageLength": 25
    });

     $('[data-toggle="tooltip"]').tooltip();
     $('[data-toggle="popover"]').popover();   

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