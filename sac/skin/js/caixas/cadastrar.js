$(function(){
  
    $('#form_caixa').submit(function(){

        $('#form_caixa').uploadForm({
                    'reload':true
        });
        return false;
    });

 })   