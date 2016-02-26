$(function(){
  
    $('#form_categoria').submit(function(){

        $('#form_categoria').uploadForm({
                    'reload':true
        });
        return false;
    });

 })   