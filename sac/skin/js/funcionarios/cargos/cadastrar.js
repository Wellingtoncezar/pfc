$(function(){
  
    $('#form_cargos').submit(function(){

        $('#form_cargos').uploadForm({
                    'reload':true
        });
        return false;
    });

 })   