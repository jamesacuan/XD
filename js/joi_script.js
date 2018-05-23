$(document).ready(function(){ 
    $('#publish').click(function(){
        clearDialog();
    });
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
 