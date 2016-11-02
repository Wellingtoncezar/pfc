$(function(){
    $('.dataTable').show()
    
    // //DATATABLE
    var table = $('.dataTable').DataTable({
        order: [0,'asc']
    });
    //ADIAR
    table.$(' .btn_adiar').on('click',function(){
        var id = $(this).attr('iddata')
        if($(this).hasAttr('habilitar')){
            $('input[iddata='+id+']').prop('disabled',false)
            $(this).removeAttr('habilitar');
            $(this).removeClass('btn-primary').addClass('btn-success')
            $('span',this).removeClass('glyphicons-history').addClass('glyphicons-ok')
        }else{
            $.post( url+"agenda/gerenciar/adiarCompromissos", { 
                data: $('input[iddata='+id+']').val(),
                id_agenda: id
            })
              .done(function( data ) {
                if(data){
                    location.reload()
                }else
                    console.log(data)
            });
        }
        return false;
    });
    $.fn.hasAttr = function(name) {  
       return this.attr(name) !== undefined;
    };

})