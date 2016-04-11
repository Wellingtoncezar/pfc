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
		var elemProduto = '<div class="input-group group_produto" id="prod_'+idProduto+'">'
                        +'<span class="input-group-addon" id="basic-addon2">Produto: </span>'
                        +'<input type="text" readonly="readonly" name="produto" value="'+nomeproduto+'" class="form-control" idProduto="'+idProduto+'">'
                        +'<span class="input-group-addon" id="basic-addon2">Quantidade: </span>'
                          +'<input type="number" name="quantidade" value="0" class="form-control" >'
                        
                        +'<span class="input-group-addon" id="basic-addon2"><a href="javascript:void(0)" class="removeproduto" id="'+idProduto+'"><span class="glyphicons glyphicons-remove"></span></a></span>'
                    +'</div>';

		$('.listProdutos').append(elemProduto);	
	}
	
});