$(function(){
  
    $('#form_marca').submit(function(){

        $('#form_marca').uploadForm({
                    'reload':true
        });
        return false;
    });

 })   