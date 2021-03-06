$("#sidebar-wrapper").click(function(event) {
    console.log('yes');
    fetch_info();
});

$(".xd-bar").click(function(event) {
    console.log('yes');
    fetch_info();
});

$('#purchaseorders tbody tr').click(function(event){
    var id = $(this).attr('data-code');
    fetch_preview(id);
    event.stopPropagation();
})

function fetch_info(){
    $.ajax({
        url:"functions/fetch_purchaseorder_pane.php",
        method:"POST",
        success:function(data){
            $('.xd-info-pane').html(data);
        }
    })
}
function fetch_preview(data){
    console.log(data);
    $.ajax({
        url:"functions/fetch_purchaseorder_preview.php",
        method:"POST",
        data:{code:data},
        success:function(data){
            $('.xd-info-pane').html(data);
        }
    })
   }

$(document).ready(function(){
    var potable = $('#purchaseorders').DataTable({
        "aLengthMenu": [[10, 25, 50, 75, -1], [10, 25, 50, 75, "All"]],
        "pageLength": 25
    });

    var filteredpotable = potable
        .columns(3)
        .data()
        //.search('^(?:(?!Published).)*$\r?\n?', true, false) //The RegExp search all string that not cointains USA
        .filter(function (value, index) {
            //return value != 20 ? true : false;
            if(value != "Done"){
                console.log( 'y');
                return true;
            }
            else return false;
        })
        .draw();

    $.fn.dataTable.ext.search.push(
        function(settings, data, dataIndex) {
            return $(potable.row(dataIndex).node()).attr('data-status') != 'Done';
            }
    );
    potable.draw();


    $("input[name='filterpublish']").on('click', function(){
        if ( $(this).is(':checked') ) {
            $.fn.dataTable.ext.search.pop();
            potable.draw();
        } 
        else {
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    return $(potable.row(dataIndex).node()).attr('data-status') != 'Done';
                }
            );
            potable.draw();
        }
    });

    $("input[name='filterme']").on('click', function(){
        if ( $(this).is(':checked') ) {
             $.fn.dataTable.ext.search.push(
                 function(settings, data, dataIndex) {
                     return $(potable.row(dataIndex).node()).attr('data-user') == 'mine';
                   }
               );
               potable.draw();
         } 
         else {
             $.fn.dataTable.ext.search.pop();
             potable.draw();
             //alert('no');
         }
     });
     $(".nav-search input[type='search'").keyup(function() {
        potable.search($(this).val()).draw();
     });

});