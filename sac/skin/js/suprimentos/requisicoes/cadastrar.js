$(function(){

	$('.addProduto').click(function(){
		var idProdutos = Array();
		$('input[name=id_produto]').each(function(){
			idProdutos.push($(this).val())
		});


		var idProduto = $('select[name=listaproduto]').val();




		console.log(idProdutos)
		//verifica se ja existe o produto adicionado
		if($.inArray(idProduto,idProdutos) == -1)
		{
			$.post(url+'suprimentos/requisicoes/gerenciar/getItemRequisicao',{idProduto: idProduto},function(data){
				console.log(data);
				if(data != null)
				{
					data = jQuery.parseJSON(data);
					idProdutos.push(idProduto);
					var nomeproduto = data.productname;
					var imgProduto = data.imgProduct;
					var unidadeMedida = data.unidadeMedida;
					var idUnidadeMedida = data.idUnidadeMedida;
					var elemProduto =  $('.modeloItemProduto').clone(true);
						elemProduto.addClass('itemProduto').removeClass('modeloItemProduto hide');
						elemProduto.attr('id','produto_'+idProduto);
						$('input[name=id_produto]',elemProduto).val(idProduto);
						$('.imgProduct',elemProduto).attr('src',imgProduto);
						$('.productname',elemProduto).html(nomeproduto);
						$('.unidadeMedida',elemProduto).html(unidadeMedida);
						$('input[name=idUnidadeMedida]',elemProduto).val(idUnidadeMedida);
						$('.btn_excluir',elemProduto).attr('id',idProduto);
						$('.listProdutos').append(elemProduto);	
				}
			});
		}
		
		$('.btn_excluir').on('click', function(){
	  		var id = $(this).attr('id');
	  		$('#produto_'+id).remove();	
	  		return false;
	  	});

	});


	
	$('#form_requisicao').submit(function(){
    	//email
        var produtos = Object();
        var quantidade = 1;
        var cont = 0;
        $('.listProdutos .itemProduto').each(function(){
            var aux = Object();

            var id_produto_requisicao = $('input[name=id_produto_requisicao]', this).val();
			var id_produto = $('input[name=id_produto]', this).val();
			var quantidade = $('input[name=quantidade]', this).val();
			var idUnidadeMedida = $('input[name=idUnidadeMedida]', this).val();


            aux['id_produto_requisicao'] = id_produto_requisicao;
            aux['id_produto'] = id_produto;
            aux['quantidade'] = quantidade;
            aux['idUnidadeMedida'] = idUnidadeMedida;
            produtos[cont] = aux;
            cont++;
        });

		console.log(produtos);



    	var parameters = Object();
        parameters['produtos'] = produtos;

        //parameters['preco_venda'] = $('input[name=preco_venda]').val()
        $('#form_requisicao').uploadForm({
            'reload':true,
            'parameters' : parameters
        });
        
        return false;
    });
})
