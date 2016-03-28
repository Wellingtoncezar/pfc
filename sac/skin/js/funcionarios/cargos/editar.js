$(function(){
  
    $('#form_cargo').submit(function(){

        $('#form_cargo').uploadForm({
                    'reload':true
        });
        return false;
    });

 })   