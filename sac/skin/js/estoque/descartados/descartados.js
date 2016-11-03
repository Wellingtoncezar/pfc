$("#grid").kendoGrid({
  	columns: [
    {
    	filterable: false,
        field: "id",
        title: "ID",
        width: "40px",
        template: '<p>#: id#</p>'
    },
    {
    	filterable: false,
        title: "Foto",
        width: "50px",
        template: '<img src="#: foto#" style=" width: 50px; height: 50px; margin-right:10px" class="img-circle pull-left">'
    },
    {
        field: "produto",
        title: "Produto",
        width: "300px",
        template: '<p>Código de barras: <strong>#:codigobarras#</strong></p>'
	       			+'<p>Nome: <strong>#:produto#</strong></p>'
    },
    {
        field: "qtdtotal",
        title: "Quantidade Total",
        width: "100px"
    },
    {
    	filterable: false,
        field: "nivel",
        title: "Nível",	
        width: "200px",
        template: "<div class='gauge'></div>"
    },
    {
    	filterable: false,
        field: "acoes",
        title: "Ações",
        width: "100px",
        template: '<a href="javascript:void(0)" linkAlterarLimites="#:linkAlterarLimites#" min="#:min#" max="#:max#" id="#:id#" unformatedqtdtotal="#:unformatedqtdtotal#"class="btn btn-default btnAlterLimites"><span class="glyphicons glyphicons-adjust-alt"></span></a>'

    }
  	],
    filterable: {
        extra: false,
        operators: {
            string: {
                startswith: "Começa com",
                eq: "É igual a",
                neq: "Não é igual a",
                contains: "Contém"
            }
        },
        messages: {
	      filter: "Filtrar",
	      clear: "Limpar",
	      info: "Exibir itens com valores que: "
	    }
    },
  	dataSource:{
	  	transport: {
		    read: {
		      	url: url+"estoque/descartados/gerenciar/getjsonlote",
		      	dataType: "json"
		    }
		}
	},
	pageable: {
	    pageSize: 10,
	    refresh: true
	},
  	detailTemplate: 'Lotes: <div class="grid"></div>',
  	detailInit: function(e) {
	    e.detailRow.find(".grid").kendoGrid({
	      	dataSource: {
                data: e.data.lotes,
                pageSize: 10
            },
	      	pageable: true,
	      	columns: [
	      		{ field: "id", title:"ID", width: "60px"},
	      		{ field: "codigo", title:"Código", width: "150px" },
	      		{ field: "codigogti", title:"Cód. barras gti", width: "150px" },
	      		{ field: "codigogst", title:"Cód. barras gst", width: "150px" },
	      		{ field: "validade", title:"Validade", width: "150px" },
	      		{ field: "quantidade", title:"Quantidade", width: "200px", template: "<div class='chart'></div>" },
	      		// { 
	      		// 	command: [{ 
		      	// 		text: "",
		      	// 		name: "details",
		      	// 		template: '<a href="" data-command="popup" class="k-button k-button-icontext k-grid-details"><span class="glyphicon glyphicon-transfer"></span></a>',
		      	// 		click: showDetails 
	      		// 	}
	      		// 	], 
	      		// 	title: " ", 
	      		// 	width: "180px" 
	      		// }
	        ],
	        dataBound: function(){
				var grid = this;
		    
				grid.tbody.find("tr[role='row']").each(function(){
					var model = grid.dataItem(this);

						$(this).find(".chart").kendoChart({
			                // title: {
			                //     text: "Site Visitors Stats \n /thousands/"
			                // },
			                chartArea: {
							    height: 80
							},
			                legend: {
			                    visible: false
			                },
			                seriesDefaults: {
			                    type: "bar"
			                },
			                series: [{
			                    name: model.nomeUnidadeConvertido,
			                    data: [model.qtdConvertido]
			                }],
			                valueAxis: {
			                    //	max: 10,
			                    line: {
			                        visible: false
			                    },
			                    minorGridLines: {
			                        visible: true
			                    },
			                    labels: {
			                        rotation: "auto"
			                    }
			                },
			                categoryAxis: {
			                    categories: [model.nomeUnidadeConvertido],
			                    majorGridLines: {
			                        visible: false
			                    }
			                },
			                tooltip: {
			                    visible: true,
			                    template: model.quantidade
			                }
			            });

					})
			  	}

	    });
	},
	dataBound: function(){
		var grid = this;
    
		grid.tbody.find("tr[role='row']").each(function(){
			var model = grid.dataItem(this);
			//alert(model.nivel)
		    $(this).find(".gauge").kendoLinearGauge({
                pointer: {
                    value: model.nivel,
                  shape: "arrow"
                },
                scale: {
                    
                    min: 0,
                    max: (model.maxUnformated > model.nivel) ? model.maxUnformated : model.nivel,
                    vertical: false,
                    ranges: [
                        {
                            from: 0,
                            to: model.minUnformated,
                            color: "#c20000"
                        }, {
                            from: model.minUnformated,
                            to: model.maxUnformated,
                            color: "#2798df"
                        }, {
                            from: model.maxUnformated,
                            to: (model.maxUnformated > model.nivel) ? model.maxUnformated : model.nivel,
                            color: "#ffc700"
                        }
                    ]
                }
            });




		})
  	}


});






wnd = $("#details")
.kendoWindow({
    title: "Transferir para a prateleira",
    modal: true,
    visible: false,
    resizable: false,
    width: 400
}).data("kendoWindow");

function showDetails(e) {
	detailsTemplate = kendo.template($("#template").html());
    e.preventDefault();

    var dataItem = this.dataItem($(e.currentTarget).closest("tr"));
    wnd.content(detailsTemplate(dataItem));
    wnd.center().open();
}


wndesc = $("#descartar")
.kendoWindow({
    title: "Descartar Lote",
    modal: true,
    visible: false,
    resizable: false,
    width: 400
}).data("kendoWindow");

function descartar(e) {
	detailsTemplate = kendo.template($("#descartar").html());
    e.preventDefault();

    var dataItem = this.dataItem($(e.currentTarget).closest("tr"));
    wndesc.content(detailsTemplate(dataItem));
    wndesc.center().open();
}


 //Limites de estoque
$(document).on('click', '.btnAlterLimites',function(){
    var linkAlterarLimites = $(this).attr('linkAlterarLimites')
    var id = $(this).attr('id');
    var min = $(this).attr('min');
    var max = $(this).attr('max');
    var unformatedqtdtotal = parseInt($(this).attr('unformatedqtdtotal'));
    $('#formLimites').attr('action', linkAlterarLimites);
    $('#modalAlterLim input[name=qtdMin]').val(min);
    $('#modalAlterLim input[name=qtdMax]').val(max);
    $('#modalAlterLim input[name=idEstoque]').val(id);
    $('#modalAlterLim').modal('show');


    // $('input[name=qtdMin]').maskMoney({
    //     decimal:',',
    //     thousands: ''
    // });
    // $('input[name=qtdMax]').maskMoney({
    //     decimal:',',
    //     thousands: ''
    // });
    
    $('#modalAlterLim .modal-body .limites').html('');
    $('#modalAlterLim .modal-body .limites').html('<div style="width: 350px;" id="rangeslider" class="slidelimites" ><input /><input /></div>')


    var lim = (max > unformatedqtdtotal) ? max : unformatedqtdtotal;
    $("#rangeslider").kendoRangeSlider({
	    change: rangeSliderOnChange,
	    slide: rangeSliderOnSlide,
	    min: 0,
	    max: lim,
	    selectionStart: min,
	    selectionEnd: max,
	    smallStep:1,
	    largeStep:10,

	    tickPlacement: "both"
	});

	// var rangeSlider = $("#rangeslider").getKendoRangeSlider();
 //    rangeSlider.wrapper.css("width", "400px");
 //    rangeSlider.resize();
})

$('input[name=qtdMax]').change(function(event) {
	var rangeSlider = $("#rangeslider").getKendoRangeSlider();
	rangeSlider.value([$('input[name=qtdMin]').val(), $(this).val()]);
});

$('input[name=qtdMin]').change(function(event) {
	var rangeSlider = $("#rangeslider").getKendoRangeSlider();
	rangeSlider.value([$(this).val(), $('input[name=qtdMax]').val()]);
});

function rangeSliderOnSlide(e) {
    // console.log("Slide :: new slide values are: " + e.value.toString().replace(",", " - "));
    var value = e.value.toString().split(',')
    console.log(value)
    $('input[name=qtdMin]').val(value[0])
    $('input[name=qtdMax]').val(value[1])
}

function rangeSliderOnChange(e) {
    // console.log("Change :: new values are: " + e.value.toString().replace(",", " - "));
    var value = e.value.toString().split(',')
    console.log(value)
    $('input[name=qtdMin]').val(value[0])
    $('input[name=qtdMax]').val(value[1])
}



//FORM TRANSFERIR
$(document).on('submit', '#formTransferir', function(event) {
	$('.generalErrors .alert').html('')
	$('#formTransferir').uploadForm({
        'reload':false,
        afterSubmit: function(data){
        	if(data != true)
        	{

	        	$('#alertFormModal').modal('show');
	   			//data = $.parseJSON(data);
	   			$.each(data, function(index, value) {
			        var value = ''+value;
					var values = value.split(',');
			        $.each(values, function(id, val) {
			        	$('.generalErrors .alert').append('<p>'+val+'</p>');
			        });
			        $('[name='+index+']',form).css('box-shadow','0 0 1px 1px #F00');
				});
        	}else{
        		location.reload()
        	}
        }

    });
    return false;
});

//FORM DESCARTAR
$(document).on('submit', '#formDescartar', function(event) {
	$('.generalErrors .alert').html('')
	$('#formDescartar').uploadForm({
        'reload':false,
        afterSubmit: function(data){
        	if(data != true)
        	{

	        	$('#alertFormModal').modal('show');
	   			//data = $.parseJSON(data);
	   			$.each(data, function(index, value) {
			        var value = ''+value;
					var values = value.split(',');
			        $.each(values, function(id, val) {
			        	$('.generalErrors .alert').append('<p>'+val+'</p>');
			        });
			        $('[name='+index+']',form).css('box-shadow','0 0 1px 1px #F00');
				});
        	}else{
        		location.reload()
        	}
        }

    });
    return false;
});

$('.btn_enviarAlteracaoLimites').on('click', function(event) {
    var form = $('#formLimites');
    $.ajax({
    	url: $('#formLimites').attr('action'),
    	type: 'POST',
    	dataType: 'json',
    	data: $('#formLimites').serialize(),
    })
    .done(function(data) {
    	if (data != true) {
            // $('#alertFormModal').modal('show');
            $.each(data, function(index, value) {
                var value = '' + value;
                var values = value.split(',');
                $.each(values, function(id, val) {
                    //$('.generalErrors .alert').append('<p>' + val + '</p>');
                    $.notify({
                    	title: 'Atenção',
                    	icon: 'glyphicons glyphicons-warning-sign',
						message: val,
					},{
						type: "warning",
						placement: {
							from: "top",
							align: "right"
						}
					});
                });
                $('[name=' + index + ']', form).css('box-shadow', '0 0 1px 1px #F00');
            });



        } else {
            // $('#grid').data('kendoGrid').refresh();
            $('#grid').data('kendoGrid').dataSource.read();
            // location.reload();
            $('#modalAlterLim').modal('hide');
            $.notify({
            	icon: 'glyphicons glyphicons-ok',
				message: 'Niveis alterados',
			},{
				type: "success",
				placement: {
					from: "top",
					align: "right"
				}
			});
        }
    })
    .fail(function(e) {
    	//console.log(e.responseText);
    	if(e.status == 400)
    	{
			data = jQuery.parseJSON(e.responseText);
        	// $('#alertFormModal').modal('show');
        	// $('.generalErrors .alert').html('');
       			//data = $.parseJSON(data);
   			$.each(data, function(index, value) {
		        var value = ''+value;
				var values = value.split(',');
		        $.each(values, function(id, val) {
		        	// $('.generalErrors .alert').append('<p>'++'</p>');
		        	$.notify({
	                	icon: 'glyphicons glyphicons-alert',
						message: val,
					},{
						type: "danger",
						placement: {
							from: "top",
							align: "right"
						}
					});
		        	
		        });
		        $('[name='+index+']',form).css('box-shadow','0 0 1px 1px #F00');
			});
    	}else
    	{
    		$.notify({
            	icon: 'glyphicons glyphicons-alert',
				message: e.responseText,
			},{
				type: "danger",
				placement: {
					from: "top",
					align: "right"
				}
			});
    	}
    })
    .always(function() {
    	console.log("complete");
    });
    
    return false;
});