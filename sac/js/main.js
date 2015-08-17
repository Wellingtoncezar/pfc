$(function(){
	$( "button" ).tooltip({ position: { my: "center center", at: "top top-30" } });
});

$(function() {
    $('.tootip').tooltip();
    $( '#dl-menu' ).dlmenu({
       //animationClasses : { classin : 'animated fadeInLeft', classout : 'animated fadeOutLeft'}
    });

    jQuery.fn.disableForm = function(){

        return this.each(function(funcao){
            funcao;
            $('input,select,textarea',this).attr('disabled','disabled').css({
                'border':0,
                'background' : 'rgb(223, 223, 223)',
                'color' : '#000'
            });
            $('button',this).hide().attr('disabled');
        });
    };

    jQuery.fn.enableForm = function(container){
        return this.click(function(event) {
            $('input,select,textarea',container).removeAttr('disabled').css({
                'background' : '#FFF'
            });
            $('button',container).show().removeAttr('disabled');
        });
    };

    /*
    $('#dados_pessoais').disableForm(function(){
        alert('ola')
    });
    $('#dados_pessoais .editar').enableForm('#dados_pessoais');
    $('#dados_familiares').disableForm(function(){
        alert('teste');
    });
    $('#dados_familiares .editar').enableForm('#dados_familiares');

    $('#dados_contato').disableForm();
    $('#dados_contato .editar').enableForm('#dados_contato');
    */



    //ao clicar fora do menu ele fecha os submenus e retorna para o menu raiz
    var uls1 = $('#dl-menu ul li.dl-back a');
    var uls = $('#dl-menu ul ul');
    $('body').click(function(e){
        if(uls.is(':visible'))
        {
            e.stopPropagation();
            uls1.trigger('click')
            uls1.trigger('click')
        }
    });



    $(document).on('click','.cb-enable',function(){
        var parent = $(this).parents('.switch');
        console.log(parent)
        $('.cb-disable',parent).removeClass('selected');
        $(this).addClass('selected');
        //$('.checkboxStatusList',parent).attr('checked','checked');
        $('.checkboxStatusList',parent).check();
    });



    $(document).on('click','.cb-disable',function(){
        var parent = $(this).parents('.switch');
        $('.cb-enable',parent).removeClass('selected');
        $(this).addClass('selected');
        //$('.checkboxStatusList',parent).attr('checked',false);
        $('.checkboxStatusList',parent).check();
    });


    $('.checkboxStatusList').each(function(){
        var parent = $(this).parents('.switch');
        if ($(this).is(':checked')) {
            $('.cb-enable',parent).addClass('selected');
        } else {
            $('.cb-disable',parent).addClass('selected');
        }
    });




    $.fn.check = function() {
      if ($(this).is(':checked')) {
        $(this).attr('checked', 'checked');
      } else {
        $(this).removeAttr('checked');
      }
      $(this).click();
    }


}); 