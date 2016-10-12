/*
@author wellington cezar
Plugin para upload de imagens, junto com cropper
Este plugin tem como dependência os plugin: 'ajaxForm', 'jquery ui' e 'cropper'.
*/
(function($){
	var fn = 0;
	$.fn.uploadImage = function(settings) {
		
        var config = {
			'width' : 50,
			'height' : 50,
			'cortar' : true,
			'original' : true,
			'sendInfo':'',
			'redirect':null,
			'resetform' : true,
			'reload' : false,
			'submitform' : false
        };

        //var settings = $.extend( {}, config, options );
        if (settings){$.extend(config, settings);}
        return this.each(function(){
            
        	
	        var formImg = $(this);
	        var cortar = '';
	        var original = '';
	        var cancelar = false;

		    'use strict';
	  		var console = window.console || { log: function () {} },
	      	$alert = $('.docs-alert'),
	      	$message = $alert.find('.message'),
	      	showMessage = function (message, type) {
	        	$message.text(message);
	        	if (type) {
	          		$message.addClass(type);
	        	}
		        $alert.fadeIn();
		        setTimeout(function () {
	    		    $alert.fadeOut();
	        	}, 3000);
	      	};
	      	//$('.box_panel_cropper').remove();
	      	var panelCrop = '<div class="box_panel_cropper"> <div class="panel panel-default panel_cropper"> <div class="panel-heading"> <h4 class="modal-title" id="avatar-modal-label">Editar imagem</h4> <button class="close cancelCrop" data-dismiss="modal" type="button">×</button> </div> <div class="container panel-body"> <div class="row"> <div class="col-md-9"> <!-- <h3 class="page-header">Demo:</h3> --> <div class="img-container"> <img src="../assets/img/picture.jpg" alt="Picture"> </div> </div> <div class="col-md-3"> <!-- <h3 class="page-header">Preview:</h3> --> <div class="docs-preview clearfix"> <div class="img-preview preview-lg"></div> <div class="img-preview preview-md"></div> <div class="img-preview preview-sm"></div> <div class="img-preview preview-xs"></div> </div> <!-- <h3 class="page-header">Data:</h3> --> <div class="docs-data">  </div> </div> </div> <div class="row"> <div class="col-md-9 docs-buttons"> <!-- <h3 class="page-header">Toolbar:</h3> --> <div class="btn-group"> <button class="btn btn-primary" data-method="setDragMode" data-option="move" type="button" title="Move"> <span class="docs-tooltip" data-toggle="tooltip" title="Mover"> <span class="glyphicon glyphicon-move"></span> </span> </button> <button class="btn btn-primary" data-method="zoom" data-option="0.1" type="button" title="Zoom In"> <span class="docs-tooltip" data-toggle="tooltip" title="zoom in"> <span class="glyphicon glyphicon-zoom-in"></span> </span> </button> <button class="btn btn-primary" data-method="zoom" data-option="-0.1" type="button" title="Zoom Out"> <span class="docs-tooltip" data-toggle="tooltip" title="zoom out"> <span class="glyphicon glyphicon-zoom-out"></span> </span> </button> </div> <!-- Show the cropped image in modal --> <div class="modal fade docs-cropped" id="getCroppedCanvasModal" aria-hidden="true" aria-labelledby="getCroppedCanvasTitle" role="dialog" tabindex="-1"> <div class="modal-dialog"> <div class="modal-content"> <div class="modal-header"> <button class="close" data-dismiss="modal" type="button" aria-hidden="true">&times;</button> <h4 class="modal-title" id="getCroppedCanvasTitle">Cropped</h4> </div> <div class="modal-body"></div> <!-- <div class="modal-footer"> <button class="btn btn-primary" data-dismiss="modal" type="button">Close</button> </div> --> </div> </div> </div><!-- /.modal --> <!-- <button class="btn btn-primary" data-method="getCropBoxData" data-option="" data-target="#putData" type="button"> <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;getCropBoxData&quot;)"> Get Crop Box Data </span> </button> <button class="btn btn-primary" data-method="setCropBoxData" data-target="#putData" type="button"> <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;setCropBoxData&quot;, data)"> Set Crop Box Data </span> </button> --> <button class="btn btn-success saveCrop" type="button"> <span class="docs-tooltip" data-toggle="tooltip" title="Salvar"> Salvar </span> </button> <input class="form-control" id="putData" type="hidden" placeholder="Get data to here or set data with this value" name="putData"> </div><!-- /.docs-buttons --> </div> </div> <!-- Alert --> <div class="docs-alert"><span class="warning message"></span></div> </div> </div>';
	      	var inputsCrop = '<div style="display:none"><div class="input-group"> <input class="form-control" id="dataX" type="text" placeholder="x" name="x1" style="display:none"> </div> <div class="input-group"> <input class="form-control" id="dataY" type="text" placeholder="y" name="y1" style="display:none"> </div> <div class="input-group"> <input class="form-control" id="dataWidth" type="text" placeholder="width" name="w" style="display:none"> </div> <div class="input-group"> <input class="form-control" id="dataHeight" type="text" placeholder="height" name="h" style="display:none"> </div></div>';
	      	formImg.append(inputsCrop);
	      	//$('body').append(panelCrop);
	      	formImg.append(panelCrop);



		  	// -------------------------------------------------------------------------
		  	(function () {
		    var $image = $('.img-container > img',formImg),
		        $dataX = $('#dataX',formImg),
		        $dataY = $('#dataY',formImg),
		        $dataHeight = $('#dataHeight',formImg),
		        $dataWidth = $('#dataWidth',formImg),
		        $dataRotate = $('#dataRotate',formImg),

				
				
				
		        options = {
					// strict: false,
					// responsive: false,
					// checkImageOrigin: false

					// modal: false,
					// guides: false,
					// highlight: false,
					// background: false,

					// autoCrop: false,
					// autoCropArea: 0.5,
					// dragCrop: false,
					// movable: false,
					// resizable: false,
					// rotatable: false,
					// zoomable: false,
					// touchDragZoom: false,
					// mouseWheelZoom: false,

					// minCanvasWidth: 320,
					// minCanvasHeight: 180,
					// minCropBoxWidth: 160,
					// minCropBoxHeight: 90,
					// minContainerWidth: 320,
					// minContainerHeight: 180,

					// build: null,
					// built: null,
					// dragstart: null,
					// dragmove: null,
					// dragend: null,
					// zoomin: null,
					// zoomout: null,

					aspectRatio: config.width / config.height,
					preview: $('.img-preview',formImg),
					crop: function (data) {
						$dataX.val(Math.round(data.x));
						$dataY.val(Math.round(data.y));
						$dataHeight.val(Math.round(data.height));
						$dataWidth.val(Math.round(data.width));
						$dataRotate.val(Math.round(data.rotate));
					}
		        };

		    $image.on({
				'build.cropper': function (e) {
					console.log(e.type);
				},
				'built.cropper': function (e) {
					console.log(e.type);
				},
				'dragstart.cropper': function (e) {
					console.log(e.type, e.dragType);
				},
				'dragmove.cropper': function (e) {
					console.log(e.type, e.dragType);
				},
				'dragend.cropper': function (e) {
					console.log(e.type, e.dragType);
				},
				'zoomin.cropper': function (e) {
					console.log(e.type);
				},
				'zoomout.cropper': function (e) {
					console.log(e.type);
				}
		    }).cropper(options);

		    
		    // Methods
		    $(document.body).on('click', '[data-method]', function () {
			    var data = $(this).data(),
			        $target,
			        result;

			    if (data.method) {
			        data = $.extend({}, data); // Clone a new one

			        if (typeof data.target !== 'undefined'){
			    	    $target = $(data.target);

				        if (typeof data.option === 'undefined') {
				            try {
				              	data.option = JSON.parse($target.val());
				            } catch (e) {
				              	console.log(e.message);
				            }
				        }
			        }

			        result = $image.cropper(data.method, data.option);

			        if (data.method === 'getCroppedCanvas') {
			          	$('#getCroppedCanvasModal',formImg).modal().find('.modal-body').html(result);
			        }
			        if ($.isPlainObject(result) && $target) {
			          	try {
			            	$target.val(JSON.stringify(result));
			          	} catch (e) {
			            	console.log(e.message);
			          	}
			        }
			    }
			 })
			//.on('keydown', function (e) {
			//     switch (e.which) {
			//         case 37:
			//     	    e.preventDefault();
			//         	$image.cropper('move', -1, 0);
			//         break;

			//         case 38:
			//           	e.preventDefault();
			//           	$image.cropper('move', 0, -1);
			//         break;

			//         case 39:
			//           	e.preventDefault();
			//           	$image.cropper('move', 1, 0);
			//         break;

			//         case 40:
			//           	e.preventDefault();
			//           	$image.cropper('move', 0, 1);
			//         break;
			//     }

		 //    });


		    // Import image
		    var $inputImage = $('input[type=file]',formImg),
		        URLL = window.URL || window.webkitURL,
		        blobURL;

		    if (URLL) {
		      	$inputImage.change(function () {
			        var files = this.files,
			            file;

			        if (files && files.length) {
			          	file = files[0];

			          	if (/^image\/\w+$/.test(file.type)) {
			            	blobURL = URLL.createObjectURL(file);
			            	$image.one('built.cropper', function () {
			              		URLL.revokeObjectURL(blobURL); // Revoke when load complete
			            	}).cropper('reset', true).cropper('replace', blobURL);
			            	$('body').css('overflow','hidden');
			            	$('.box_panel_cropper',formImg).slideDown();

			            	//$inputImage.val('');
			          	} else {
			            	showMessage('Por favor, escolha um arquivo de imagem.');
			          	}
			        }
		     	});
		    } else {
		      	$inputImage.parent().remove();
		    }

		    $('.cancelCrop',formImg).on('click', function(event) {
		    	event.preventDefault();
		    	$('.box_panel_cropper',formImg).slideUp();
		    	$inputImage.val('');
		    	$('body').css('overflow','auto');
		    });

		    $('.saveCrop',formImg).on('click', function(event) {
		    	event.preventDefault();
		    	$('.box_panel_cropper',formImg).slideUp();
		    	$('body').css('overflow','auto');
		    });


		    /*
		    // Options
		    $('.docs-options :checkbox').on('change', function () {
		      var $this = $(this);

		      options[$this.val()] = $this.prop('checked');
		      $image.cropper('destroy').cropper(options);
		    });
		    */

		    // Tooltips
		    $('[data-toggle="tooltip"]').tooltip();

		  	}());
			
			if(config.submitform == true)
			{
				$('[type=submit]',formImg).on('click', function(event) {
					event.preventDefault();
					formImg.submit();
				});


				formImg.ajaxForm(function(data) { 
					$('#carregando').fadeIn();
					if(data != true)
					{
						$("#result").html(data);
						$("#result").dialog({
							autoOpen: true,
							buttons: [
								{
									text: "Ok",
									click: function() {
										$( this ).dialog( "close" );
										$('#carregando').fadeOut();
										location.reload();
									}
								}
							]
						});
					}else
					{
						formImg.get(0).reset();
						location.reload();
					}
			    });
			}


		});


    }
})(jQuery);


/*
@author wellington cezar
Plugin para upload de imagens, junto com crop
Este plugin tem como dependÃªncia os plugin: 'ajaxForm', 'jquery ui' e 'Jcrop'.
*/

(function($){
    $.fn.uploadForm = function(options, action) {
    	var $jquery = this;


    	var form;
        var configs = {
        	'beforeSubmit' : function(formData, jqForm, options)
			{ 
			    return true;
			},
			'afterSubmit' : function (data, status, xhr, $form)  { 
	   			$('input, select, textarea',form).css('box-shadow','none');
			    $('.generalErrors .alert').html('');
	   			try
				{
					$('#carregando').fadeOut();
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
						}else
						{
							$("#img_previous",form).attr('src','');
							if(settings.reload == true)
	                    		location.reload();
	                        if(settings.redirect != null)
	                            location.href = settings.redirect
	                        if(settings.resetform == true)
	                            form.get(0).reset();
							$('.generalErrors').removeClass('panel-danger').addClass('panel-success').html('<h4 class="panel-heading">Enviado com sucesso</h4>').css('background','#dff0d8');
							$('#alertFormModal').modal('show');

						}
				}
				catch(e)
				{
					console.log(e)
					console.log(data)
					//$('#carregando').fadeOut();
				}
				return true;
			},
			'dataType': 'json',
			'redirect':null,
			'resetform' : false,
			'clearForm' : false,
			'reload' : false,
			'parameters' : {},
			'autoSubmit' : true
        };

        





        var settings = $.extend( {}, configs, options );

        var output={
 			
            'init':function(){
            	$jquery.each(function(){
	            	form = $(this);
			        var contentpanel = '<div class="modal fade" id="alertFormModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">'
										  +'<div class="modal-dialog" role="document">'
										    +'<div class="modal-content">'
										      +'<div class="modal-header">'
										        +'<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'
										        +'<h4 class="modal-title" id="myModalLabel">Atenção</h4>'
										      +'</div>'
										      +'<div class="modal-body">'
										        	+'<div class="panel generalErrors panel-danger" style="text-align:left; background-color: #f2dede;">'
										        		+'<h4 class="panel-heading">Ocorreu(ram) o(s) seguinte(s) erro(s):</h4>'
										        		+'<div class="alert alert-danger" role="alert">'
										        		+'</div>'
										        	+'</div>'
										      +'</div>'
										     +'<div class="modal-footer">'
										        +'<button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>'
										      +'</div>'
										    +'</div>'
										  +'</div>'
										+'</div>';
			        $('body').append(contentpanel);
					
				})
            },
            'submitForm' :function(){
            	// post-submit callback 
			    form.ajaxSubmit({ 
			        //target:        '#output1',   // target element(s) to be updated with server response 
			        beforeSubmit:  settings.beforeSubmit,  // pre-submit callback 
			        success:       settings.afterSubmit,  // post-submit callback 
			 
			        // other available options: 
			        url:       form.attr('action'),         // override for form's 'action' attribute 
			        //type:      form.attr('').type        // 'get' or 'post', override for form's 'method' attribute 
			        dataType:  settings.dataType,        // 'xml', 'script', or 'json' (expected server response type) 
			        clearForm: settings.clearForm,       // clear all form fields after successful submit 
			        resetForm: settings.resetform,      // reset the form after successful submit 
			 		data:  settings.parameters,
			        // $.ajax options can be used here too, for example: 
			        //timeout:   3000
			        error : function(e,st){
			        	//console.log(e.responseText);
			        	if(e.status == 400)
			        	{
		        			data = jQuery.parseJSON(e.responseText);
				        	$('#alertFormModal').modal('show');
				        	$('.generalErrors .alert').html('');
				       			//data = $.parseJSON(data);
			       			$.each(data, function(index, value) {
						        var value = ''+value;
								var values = value.split(',');
						        $.each(values, function(id, val) {
						        	$('.generalErrors .alert').append('<p>'+val+'</p>');
						        });
						        $('[name='+index+']',form).css('box-shadow','0 0 1px 1px #F00');
							});
			        	}else
			        	{
			        		$('#alertFormModal').modal('show');
			        		$('.generalErrors .alert').html(e.responseText);
			        	}
			        }
			    });
            }
        };

        output.init();
        if(settings.autoSubmit == true)
        	output.submitForm();
        
        return output;
    }; 
})(jQuery);