$(function(){
        //DATATABLE
        var table = $('.dataTable').DataTable({
            order: [0,'asc']
        });

        table.$('input[name=codigobarras]').each(function() {
        	console.log($(this).val())
        	var value = $(this).val()

        	$("#barcode"+$(this).attr('id')).barcode(
		    	value, 
		    	"ean13",
		    	{barWidth:1, barHeight:50}
		    );
        });

        //STATUS
        table.$('select[name=status]').on('change',function(){
            var id = $(this).attr('id');
            var status = $(this).val();
            $.post(url+'produtos/gerenciar/atualizarStatus',{id:id,status:status},function(data){
                console.log(data)
                if(data == true)
                    messageDialog('Status atualizado','success',false,null);
                else
                    messageDialog('Erro ao atualizar','warning',false,null);
            });

        });

        var id = '';
        var status = '';
        var modalDelete = '';
        //EXCLUIR
        table.$('.btn_excluir').on('click',function(){
            id = $(this).attr('id');
            status = $(this).data('value');
            modalDelete = $('#modalDelete').modal('show');
        });

        $('.btn_ok','#modalDelete').on('click', function(event) {
            $.post(url+'produtos/gerenciar/excluir',{id:id,status:status},function(data){
                console.log(data)
                if(data == true){
                    $('#modalDelete').modal('hide');
                    $('tr#'+id).hide();
                }else{
                    $('#modalDelete').modal('hide');
                    messageDialog(data,'warning',false,null);
                }
            });
        });


    })