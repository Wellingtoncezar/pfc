$(function(){

	$('.addProduto').click(function(){
		var idProdutos = Array();
		$('input[name=produto]').each(function(){
			idProdutos.push($(this).attr('idProduto'))
		});


		var idProduto = $('select[name=listaproduto]').val();

		//verifica se ja existe o produto adicionado
		if($.inArray(idProduto,idProdutos) == -1)
		{
			idProdutos.push(idProduto)
			
			var nomeproduto = $('select[name=listaproduto] option:selected').html();
			var imgProduto = $('select[name=listaproduto] option:selected').attr('img');
			var elemProduto = 	'<div class="col-sm-6 col-md-2 itemProduto" id=produto_'+idProduto+'>'
									+'<input type="hidden" name="id_produto_requisicao" value="">'
									+'<input type="hidden" name="id_produto" value="'+idProduto+'">'
		                       		+'<div class="thumbnail">'
		                        		+'<img src="'+imgProduto+'">'
		                         		+'<div class="caption">'
		                           			+'<div class="form-group">'
									    		+'<label>Produto</label>'
									  			+'<p class="form-control">'+nomeproduto+'</p>'
									  		+'</div>'
									  		+'<div class="form-group">'
									    		+'<label>Quantidade</label>'
									    		+'<input type="number" name="quantidade" value="0" class="form-control">'
									    		+'<div class="input-group-addon">.</div>'
									  		+'</div>'
		                            		+'<p><a href="javascript:void()" class="btn btn-danger btn_excluir" id='+idProduto+' role="button">Remover</a></p>'
		                         		+'</div>'
		                        	+'</div>'
		                      	+'</div>';
			

			$('.listProdutos').append(elemProduto);	
		}
		
		$('.btn_excluir').on('click', function(){
	  		var id = $(this).attr('id');
	  		$('#produto_'+id).remove();	
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


            aux['id_produto_requisicao'] = id_produto_requisicao;
            aux['id_produto'] = id_produto;
            aux['quantidade'] = quantidade;
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
