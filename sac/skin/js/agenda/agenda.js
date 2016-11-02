$(document).ready(function() {
    var monthNames = ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];
    var dayNames = ["Seg", "Ter", "Qua", "Qui", "Sex", "Sab", "Dom"];
    $('#agendaFornecedores').bic_calendar({
        //list of events in array
        //events: events,
        //enable select
        enableSelect: false,
        //enable multi-select
        multiSelect: false,
        //set day names
        dayNames: dayNames,
        //set month names
        monthNames: monthNames,
        //show dayNames
        showDays: true,
        //set ajax call
        reqAjax: {
            type: 'post',
            //parameters : {classe: 1},
            url: url+'agenda/gerenciar/listar'
        }
        //set popover options
        //popoverOptions: {}
        //set tooltip options
        //tooltipOptions: {}
    });

    $(document).on('click', '#agendaFornecedores a[rel=tooltip]', function(event) {
        event.preventDefault();
        var href = $(this).attr('href');
        console.log(href)
        $.post(href,{}, function(data){
            $('#modalAgenda .modal-body').html(data);
            $('#modalAgenda').modal('show')
        })
    });

    
});

   
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