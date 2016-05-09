$(function(){
	$("input[name=preco_custo],input[name=preco_venda]").maskMoney({symbol:"R$",decimal:",",thousands:"."});
	$("input[name=markup]").maskMoney({decimal:",",thousands:""});
	// //$("input[name=markup]").wvmask('numero')
 //  	$('.addFornecedor').click(function(){
 //  		var idFornecedores = Array();
 //  		$('input[name=fornecedor]').each(function(){
 //  			idFornecedores.push($(this).attr('idFornecedor'))
 //  		});


 //  		var idFornecedor = $('select[name=listafornecedores]').val();

 //  		//verifica se ja existe o fornecedor adicionado
 //  		if($.inArray(idFornecedor,idFornecedores) == -1)
 //  		{
 //  			idFornecedores.push(idFornecedor)
  			
	//   		var nomeFornecedor = $('select[name=listafornecedores] option:selected').html();
	//   		var elemFornec = '<div class="col-sm-6 col-md-2 group_fornecedor" id=fornec_'+idFornecedor+'>'
 //                            +'<div class="thumbnail">'
 //                              +'<img src="..." alt="...">'
 //                              + '<div class="caption">'
 //                                  +'<div class="form-group">'
 //                                    +'<label>Fornecedor</label>'
 //                                    +'<input type="text" readonly="readonly" name="fornecedor" value="'+nomeFornecedor+'" class="form-control" idFornecedor="'+idFornecedor+'">'
 //                                  +'</div>'
 //                                  +'<span class="input-group-addon" id="basic-addon1">Principal <input type="radio" value="'+idFornecedor+'" name="principal"></span>'
 //                                  +'<p><a href="javascript:void()" class="btn btn-danger removeFornecedor" id="'+idFornecedor+'" role="button">Remover</a></p>'
 //                                +'</div>'
 //                              +'</div>'
 //                        +'</div>';

	//   		$('.listFornecedores').append(elemFornec);	
	//   		checkfirstfornec();
 //  		}
  		
 //  	});

  	// $(document).on('click','.removeFornecedor', function(){
  	// 	var id = $(this).attr('id');
  	// 	$('#fornec_'+id).remove();
  	// 	checkfirstfornec()	
  	// });


 //  	function checkfirstfornec()
 //  	{
 //  		if($('input[name=principal]').is(':checked') == false){
 //  			$('input[name=principal]').each(function(i,v){
 //  				if(i == 0)
 //  				{
 //  					$(this).prop('checked',true)
 //  					return false;
 //  				}
 //  			})
 //  		}
 //  	}

	// //preco de venda automático
 //  	$('input[name=precoVendaAutomatico]').change(function(){
 //  		if($(this).is(':checked')){
 //  			$('input[name=markup]').val('0,00')
 //  			$('.boxmarkup').show()
 //  			$('input[name=preco_venda]').attr('disabled','disabled');
 //  			calcprecovenda()
 //  		}else{
 //  			$('.boxmarkup').hide();
 //  			$('input[name=markup]').val('0,00')
 //  			$('input[name=preco_venda]').removeAttr('disabled');
 //  			calcprecovenda()
 //  		}
 //  	});

 //  	function calcprecovenda()
 //  	{
 //  		if($('input[name=precoVendaAutomatico]').is(':checked'))
 //  		{
	//   		var custo = $('input[name=preco_custo]').val();
	//   		custo = custo.replace(/[R$.]+/g,'');
	//   		custo = custo.replace(',','.').replace(/(\d)(?=(\d{3})+\,)/g,"$1.");
	//   		var markup = $('input[name=markup]').val();
	//   		markup = markup.replace(/[R$.]+/g,'');
	//   		markup = markup.replace(',','.').replace(/(\d)(?=(\d{3})+\,)/g,"$1.");
	//   		markup = parseFloat(markup)
	//   		custo = parseFloat(custo);
	//   		var venda = ((custo * markup)/100) + custo;
	//   		venda = venda.toFixed(2);
	// 		venda = venda.toString();
	//   		venda = venda.replace('.',',').replace(/(\d)(?=(\d{3})+\,)/g,"$1.");
	// 		$('input[name=preco_venda]').val(venda)

 //  		}
 //  	}

 //  	$('input[name=preco_custo]').keypress(function(){
 //  		calcprecovenda()
 //  	})
 //  	$('input[name=preco_custo]').keyup(function(){
 //  		calcprecovenda()
 //  	})
 //  	$('input[name=markup]').keypress(function(){
 //  		calcprecovenda()
 //  	})
 //  	$('input[name=markup]').keyup(function(){
 //  		calcprecovenda()
 //  	});


    $('.btn_addUnidade').on('click', function(event) {
    var elem = '<div class="col-sm-6 col-md-3 unidMed">'
                        +'<input type="hidden" name="idUnidadeMedida">'
                        +'<div class="thumbnail">'
                            +'<div class="caption">'
                                +'<div class="input-group">'
                                    +'<span class="input-group-addon" id="basic-addon1">Nome</span>'
                                    +'<input type="text" class="form-control" placeholder="Nome" name="nome_unidade" value="">'
                                +'</div>'
                                +'<div class="input-group">'
                                    +'<span class="input-group-addon" id="basic-addon1">Código</span>'
                                    +'<input type="text" class="form-control" placeholder="Código" name="codigo_unidade" maxlength="6" value="">'
                                +'</div>'
                                +'<div class="input-group">'
                                    +'<span class="input-group-addon" id="basic-addon1">Fator conversão</span>'
                                    +'<input type="text" class="form-control" placeholder="Fator" name="fator_unidade" maxlength="20" value="">'
                                +'</div>'
                                +'<p><a href="#" class="btn btn-danger" role="button">Excluir</a></p>'
                            +'</div>'
                        +'</div>'
                    +'</div>';
        $('.groupUnidades').append(elem);
  });




    $('#form_produto').uploadImage();
    $('#form_produto').submit(function(){

    	//email
        var unidadeMedida = Object();
        var iUnid = 0;
        var ordem = 0;
        $('.groupUnidades .unidMed').each(function(){
            var aux = Object();
            var idUnidadeMedida = $('input[name=idUnidadeMedida]',this).val();
            var nome_unidade = $('input[name=nome_unidade]',this).val();
            var codigo_unidade = $('input[name=codigo_unidade]',this).val();
            var fator_unidade = $('input[name=fator_unidade]',this).val();
            aux['idUnidadeMedida'] = idUnidadeMedida;
            aux['nome_unidade'] = nome_unidade;
            aux['codigo_unidade'] = codigo_unidade;
            aux['fator_unidade'] = fator_unidade;
            aux['ordem'] = ordem;
            unidadeMedida[iUnid] = aux;
            iUnid++;
            ordem++;
        });



    	var parameters = Object();
        parameters['unidadeMedida'] = unidadeMedida;

        //parameters['preco_venda'] = $('input[name=preco_venda]').val()
        $('#form_produto').uploadForm({
            'reload':true,
            'parameters' : parameters
        });
        return false;
    });

 })   