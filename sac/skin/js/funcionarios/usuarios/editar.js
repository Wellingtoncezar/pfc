$(function(){
  
    $('#form_usuarios').submit(function(){

        $('#form_usuarios').uploadForm({
                    'reload':true
        });
        return false;
    });

 })   