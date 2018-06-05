var home_url = "http://localhost/xd/";
//var home_url = "http://taxcalculator.pe.hu/";

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

$('#joborders tr').click(function(event) {
    if (event.target.type !== 'checkbox') {
      $(':checkbox', this).trigger('click');
      $(this).toggleClass('active');
    }
  });
$('#joborders tr').dblclick(function(){
    var id = $(this).attr('id');
    alert('test');
})
$(document).ready( function () {
    var jobordertable = $('#joborders').DataTable({
        fixedHeader: {
            header: true
        },
        order: [[1, 'asc']],
        rowGroup: {
            startRender: function ( rows, group ) {
               
                return  $('<tr>')
                .append( '<td colspan="7"><a href="joborder?&amp;id='+group+'">Job Order #' + group + '</a></td></tr>' );
            },
            dataSrc: 1
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

    $.fn.dataTable.ext.search.push(
        function(settings, data, dataIndex) {
            return $(jobordertable.row(dataIndex).node()).attr('data-status') != 'published';
          }
      );
      jobordertable.draw();

     $('[data-toggle="tooltip"]').tooltip();
     $('[data-toggle="popover"]').popover();  

     $("#search").keyup(function() {
        jobordertable.search($(this).val()).draw();
     });

    $("input[name='filterme']").on('click', function(){
       if ( $(this).is(':checked') ) {
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    return $(jobordertable.row(dataIndex).node()).attr('data-user') == 'mine';
                  }
              );
              jobordertable.draw();
        } 
        else {
            $.fn.dataTable.ext.search.pop();
            jobordertable.draw();
            //alert('no');
        }
    });
    $('select[name="selpublish"]').on('change', function() {
        //var optionSelected = $("option:selected", this);
        //var valueSelected = optionSelected.val();
        //alert(valueSelected);
        if(this.value==1){
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    return $(jobordertable.row(dataIndex).node()).attr('data-status') != 'published';
                  }
              );
              jobordertable.draw();
            console.log(1);
        }
        else if(this.value==2){
            $.fn.dataTable.ext.search.pop();
            jobordertable.draw();
            console.log(2);
        }
        else if(this.value==3){
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    return $(jobordertable.row(dataIndex).node()).attr('data-status') == 'published';
                  }
              );
              jobordertable.draw();
              console.log(3); 
        }
      })
    $("input[name='filterpublish']").on('click', function(){
        if ( $(this).is(':checked') ) {
            $.fn.dataTable.ext.search.pop();
            jobordertable.draw();
        } 
        else {
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    return $(jobordertable.row(dataIndex).node()).attr('data-status') != 'published';
                }
            );
            jobordertable.draw();
        }


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