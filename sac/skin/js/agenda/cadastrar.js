$(function(){
    /*MASCARAS DE CAMPOS*/
    $('input[name=data]').datepicker({ dateFormat: 'dd/mm/yy',changeMonth: true, changeYear: true,yearRange: "-3:+2" });

    //SUBMIT DO FORMULÁRIO
    $('#form_agenda').submit(function(){
        $('#form_agenda').uploadForm({
            'reload':true
        });
        return false;
    });


    /************************************/
        //campos select
    $.widget( "custom.iconselectmenu", $.ui.selectmenu, {
      _renderItem: function( ul, item ) {
        var li = $( "<li>", { text: item.label } );
 
        if ( item.disabled ) {
          li.addClass( "ui-state-disabled" );
        }
 
        $( "<span>", {
          style: item.element.attr( "data-style" ),
          "class": "ui-icon " + item.element.attr( "data-class" )
        })
          .appendTo( li );
        return li.appendTo( ul );
      }
    });

    $( "#fornecedores" )
    .iconselectmenu()
    .iconselectmenu( "menuWidget")
    .addClass( "ui-menu-icons avatar" );
    /************************************/
});