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
		var elemProduto = '<div class="col-sm-6 col-md-2" id=produto_'+idProduto+'>'
                       +' <div class="thumbnail">'
                        + ' <img src="..." alt="...">'
                         + '<div class="caption">'
                           +' <div class="form-group">'
							    +'<label>Produto</label>'
							  	+'<input type="text" readonly="readonly" name="produto" value="'+nomeproduto+'" class="form-control" idProduto="'+idProduto+'">'
							  +'</div>'
							  +' <div class="form-group">'
							    +'<label>Quantidade</label>'
							    +'<input type="number" name="quantidade" value="0" class="form-control" >	'
							    + '<div class="input-group-addon">.00</div>'
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

