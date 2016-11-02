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
        template: '<a href="javascript:void(0)" linkAlterarLimites="#:linkAlterarLimites#" min="#:min#" max="#:max#" id="#:id#" class="btn btn-default btnAlterLimites"><span class="glyphicons glyphicons-edit"></span></a>'

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
		      	url: url+"estoque/armazem/gerenciar/getjsonlote",
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
	      		{ 
	      			command: [{ 
		      			text: "",
		      			name: "details",
		      			template: '<a href="" data-command="popup" class="k-button k-button-icontext k-grid-details"><span class="glyphicon glyphicon-transfer"></span></a>',
		      			click: showDetails 
	      			},{ 
		      			text: "",
		      			name: "descartar",
		      			template: '<a href="" data-command="popup" class="k-button k-button-icontext k-grid-descartar"><span class="glyphicons glyphicons-remove"></span></a>',
		      			click: descartar 
	      			}
	      			], 
	      			title: " ", 
	      			width: "180px" 
	      		}
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
    $('#formLimites').attr('action', linkAlterarLimites);
    $('#modalAlterLim input[name=qtdMin]').val(min);
    $('#modalAlterLim input[name=qtdMax]').val(max);
    $('#modalAlterLim input[name=idEstoque]').val(id);
    $('#modalAlterLim').modal('show');


    $('input[name=qtdMin]').maskMoney({
        decimal:',',
        thousands: ''
    });
    $('input[name=qtdMax]').maskMoney({
        decimal:',',
        thousands: ''
    });
})



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

$(document).on('submit', '#formLimites', function(event) {
    $('#formLimites').uploadForm({
    });
    return false;
});