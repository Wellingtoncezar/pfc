$(function(){
    //DATATABLE
    var table = $('.dataTable').DataTable({
        order: [0,'asc']
    });

    //STATUS
    table.$('select[name=status]').on('change',function(){
        var id = $(this).attr('id');
        var status = $(this).val();
        $.post(url+'funcionarios/gerenciar/atualizarStatus',{id:id,status:status},function(data){
            console.log(data)
            if(data == true)
                messageDialog('Status atualizado','success',false,null);
            else
                messageDialog('Erro ao atualizar','warning',false,null);
        });

    });

    //EXCLUIR
    var id;
    var status;
    table.$('.btn_excluir').on('click',function(){
        var modalDelete = $('#modalDelete').modal('show')
        id = $(this).attr('id');
        status = $(this).data('value');
    });

    $('.btn_ok','#modalDelete').on('click', function(event) {
        $.post(url+'funcionarios/gerenciar/excluir',{id:id,status:status},function(data){
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