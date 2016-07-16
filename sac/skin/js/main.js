$(document).ready(function(){
	$('.statusSelect').each(function(index, el) {
		if($('option:selected',this).hasClass('active'))
			$(this).removeClass('inactive').addClass('active');
		else
			$(this).removeClass('active').addClass('inactive');
	});
	$('.statusSelect').change(function(event) {
		if($('option:selected',this).hasClass('active'))
			$(this).removeClass('inactive').addClass('active');
		else
			$(this).removeClass('active').addClass('inactive');
	});
    


    $(window).load(function() {
        $('#loadTable').hide();
        $('.dataTable').fadeIn();
    });
    if($(this).width() <= '765')
        responsiveTable();
    $(window).resize(function() {
        //console.log($(this).width())
        if($(this).width() <= '765')
            responsiveTable();
        else
            responsiveTableRemove()
    });


    function responsiveTable(){
        var th = Array();
        $('.rwd-table thead th').each(function(){
            th.push($(this).html())
        });

        //console.log(th);
        var i = 0;
        $('.rwd-table tbody td').each(function(a,b){
            if(!$('div',$(this)).hasClass('dataTables-th')){
                $(this).prepend('<div class="dataTables-th">'+th[i]+'</div>');
                i++;
                if(i == th.length)
                    i=0;
            }
        });
    }
    function responsiveTableRemove(){
        $('.rwd-table tbody td .dataTables-th').remove()
    }

    //notificação de agendamento de fornecedores
    // $.post(url+'fornecedores/agenda/notificar',{},function(data){
        
    //     data = jQuery.parseJSON(data);
    //     if(!jQuery.isEmptyObject(data))
    //     {
    //         $.each(data, function(index, val) {
    //             var content = "<tr>"+
    //                                 "<td>"+val.data+"</td>"+
    //                                 "<td>"+val.nome_fornecedor+"</td>"+
    //                                 "<td>"+val.titulo+"</td>"+
    //                             "</th>"


    //             $('#tableNotificacaoAgendaFornec').append(content)
    //         });
    //         $('#modalNotificacaoFornecedores').modal('show')
    //     }

    // })
    
     $('[data-toggle="tooltip"]').tooltip()



});


(function( $ ) {
    $.widget( "custom.combobox", {
      _create: function() {
        this.wrapper = $( "<span>" )
          .addClass( "custom-combobox" )
          .insertAfter( this.element );
 
        this.element.hide();
        this._createAutocomplete();
        this._createShowAllButton();
      },
 
      _createAutocomplete: function() {
        var selected = this.element.children( ":selected" ),
          value = selected.val() ? selected.text() : "";
 
        this.input = $( "<input>" )
          .appendTo( this.wrapper )
          .val( value )
          .attr( "title", "" )
          .addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
          .autocomplete({
            delay: 0,
            minLength: 0,
            source: $.proxy( this, "_source" )
          })
          .tooltip({
            tooltipClass: "ui-state-highlight"
          });
 
        this._on( this.input, {
          autocompleteselect: function( event, ui ) {
            ui.item.option.selected = true;
            this._trigger( "select", event, {
              item: ui.item.option
            });
          },
 
          autocompletechange: "_removeIfInvalid"
        });
      },
 
      _createShowAllButton: function() {
        var input = this.input,
          wasOpen = false;
 
        $( "<a>" )
          .attr( "tabIndex", -1 )
          .attr( "title", "Show All Items" )
          .tooltip()
          .appendTo( this.wrapper )
          .button({
            icons: {
              primary: "ui-icon-triangle-1-s"
            },
            text: false
          })
          .removeClass( "ui-corner-all" )
          .addClass( "custom-combobox-toggle ui-corner-right" )
          .mousedown(function() {
            wasOpen = input.autocomplete( "widget" ).is( ":visible" );
          })
          .click(function() {
            input.focus();
 
            // Close if already visible
            if ( wasOpen ) {
              return;
            }
 
            // Pass empty string as value to search for, displaying all results
            input.autocomplete( "search", "" );
          });
      },
 
      _source: function( request, response ) {
        var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
        response( this.element.children( "option" ).map(function() {
          var text = $( this ).text();
          if ( this.value && ( !request.term || matcher.test(text) ) )
            return {
              label: text,
              value: text,
              option: this
            };
        }) );
      },
 
      _removeIfInvalid: function( event, ui ) {
 
        // Selected an item, nothing to do
        if ( ui.item ) {
          return;
        }
 
        // Search for a match (case-insensitive)
        var value = this.input.val(),
          valueLowerCase = value.toLowerCase(),
          valid = false;
        this.element.children( "option" ).each(function() {
          if ( $( this ).text().toLowerCase() === valueLowerCase ) {
            this.selected = valid = true;
            return false;
          }
        });
 
        // Found a match, nothing to do
        if ( valid ) {
          return;
        }
 
        // Remove invalid value
        this.input
          .val( "" )
          .attr( "title", value + " não encontrado" )
          .tooltip( "open" );
        this.element.val( "" );
        this._delay(function() {
          this.input.tooltip( "close" ).attr( "title", "" );
        }, 2500 );
        this.input.autocomplete( "instance" ).term = "";
      },
 
      _destroy: function() {
        this.wrapper.remove();
        this.element.show();
      }
    });
  })( jQuery );