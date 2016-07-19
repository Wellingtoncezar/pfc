$(function(){
    $("input[name=preco_custo],input[name=preco_venda]").maskMoney({symbol:"R$",decimal:",",thousands:"."});
	$("input[name=markup]").maskMoney({decimal:",",thousands:""});
    // //$("input[name=markup]").wvmask('numero')
    
    // $("#barcode").kendoBarcode({
    //     value: $('#barCodeGti').val(),
    //     type: "ean8",
    //     background: "transparent"
    // });
    $('#barCodeGti').keydown(function(event) {
    	console.log($(this).val().length)
    	if($(this).val().length == 13)
    	{
    		changeBarcode()
    	}
    });
    function changeBarcode()
    {
	    $("#barcode").barcode(
	    	$('#barCodeGti').val(), 
	    	"ean13",
	    	{barWidth:1, barHeight:50}
	    ); 
    	
    }

    changeBarcode();


    $('.addFornecedor').click(function(){

    	// 
     //    $('.groupUnidades').append(elem);
      	var idFornecedor = $('select[name=listafornecedores]').val();//fornecedor selecionado

    	
      	var idFornecedores = Array();//fornecedores já incluidos
      	$('input[name=idFornecedor]').each(function(){
      		idFornecedores.push($(this).val())
      	});




      	//verifica se ja existe o fornecedor adicionado
      	if($.inArray(idFornecedor,idFornecedores) == -1)
      	{
      		idFornecedores.push(idFornecedor)
      			
	  		var nomeFornecedor = $('select[name=listafornecedores] option:selected').attr('nome');
	  		var fotoFornecedor = $('select[name=listafornecedores] option:selected').attr('foto');
	  		var elemFornec = $('.modeloFornecedor').clone(true);
        	elemFornec.addClass('group_fornecedor').removeClass('modeloFornecedor hide');
        	elemFornec.attr('id',idFornecedor);
        	$('input[name=idFornecedor]',elemFornec).val(idFornecedor);
        	$('.fotoFornecedor', elemFornec).attr('src',fotoFornecedor);
        	$('#nomeFornecedor', elemFornec).html(nomeFornecedor);
        	
        	$('.removeFornecedor', elemFornec).attr('id',idFornecedor);
        	
	  		$('.listFornecedores').append(elemFornec);	
	  		//checkfirstfornec();
      	}
  		
  	});

  	// $(document).on('click','.removeFornecedor', function(){
  	// 	var id = $(this).attr('id');
  	// 	$('#fornec_'+id).remove();
  	// 	checkfirstfornec()	
  	// });


  	// function checkfirstfornec()
  	// {
  	// 	if($('input[name=principal]').is(':checked') == false){
  	// 		$('input[name=principal]').each(function(i,v){
  	// 			if(i == 0)
  	// 			{
  	// 				$(this).prop('checked',true)
  	// 				return false;
  	// 			}
  	// 		})
  	// 	}
  	// }

	//preco de venda automático
  	$('input[name=precoVendaAutomatico]').change(function(){
  		if($(this).is(':checked')){
		    $('input[name=markup]').val('0,00')
		    $('.boxmarkup').show()
		    $('input[name=preco_venda]').attr('disabled','disabled');
		    //calcprecovenda()
  		}else{
		    $('.boxmarkup').hide();
		    $('input[name=markup]').val('0,00')
		    $('input[name=preco_venda]').removeAttr('disabled');
		    //calcprecovenda()
	  	}
  	});



    $('.btn_addUnidade').on('click', function(event) {
        var elem = $('.modeloUnidadeMedida').clone(true);
        elem.addClass('unidMed').removeClass('modeloUnidadeMedida hide');
        $('.groupUnidades').append(elem);
    });

    $('.btn_removeUnidMed').on('click', function(event) {
        $(this).parent().parent().parent().parent().remove();
    });
    


    $('#form_produto').uploadImage();
    $('#form_produto').submit(function(){

    	  //unidade de medida
        var unidadeMedida = Object();
        var iUnid = 0;
        var ordem = 0;
        $('.groupUnidades .unidMed').each(function(){
            var aux = Object();
            var idUnidadeMedidaProduto = $('input[name=idUnidadeMedidaProduto]',this).val();
            var idUnidadeMedida = $('select[name=unidadeMedida]',this).val();
            var fator_unidade = $('input[name=fator_unidade]',this).val();
            var venda = $('input[name=venda]',this).is(':checked');
            var estoque = $('input[name=estoque]',this).is(':checked');
            aux['idUnidadeMedidaProduto'] = idUnidadeMedidaProduto;
            aux['idUnidadeMedida'] = idUnidadeMedida;
            aux['fator_unidade'] = fator_unidade;
            aux['venda'] = venda;
            aux['estoque'] = estoque;
            aux['ordem'] = ordem;
            unidadeMedida[iUnid] = aux;
            iUnid++;
            ordem++;
        });


        //fornecedores
        var fornecedores = Object();
        var iFornec = 0;
        $('.group_fornecedor').each(function(){
            var aux = Object();
            var id_fornecedor = $('input[name=idFornecedor]',this).val();
            aux['id'] = id_fornecedor;
            fornecedores[iFornec] = aux;
            iFornec++;
        });

    	var parameters = Object();
        parameters['fornecedores'] = fornecedores;
        parameters['unidadeMedidaEstoque'] = unidadeMedida;

        console.log(parameters);
        //parameters['preco_venda'] = $('input[name=preco_venda]').val()
        $('#form_produto').uploadForm({
            'reload':true,
            'parameters' : parameters
        });
        return false;
    });

})   