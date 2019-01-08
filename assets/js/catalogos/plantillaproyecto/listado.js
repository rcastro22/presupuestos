var base_url;
var plantillaEliminar;
$(document).ready(function()
{
	base_url=$('base').attr('href');

	if($('#proyectos').length > 0)
		cargarProyectos();

    //alert($('#hproyecto').val());
	$("#gvBuscar").tabla(base_url+'catalogos/plantillaproyecto/getPlantillaPorProyecto/'+$('#hproyecto').val());
	//alert("hola2");
	//var $vpagina=$('#pagina').val();
	//alert("hola");
	//$("div.pagination > ul > li:gt(2)").trigger("click");
	//$('div.pagination > ul > li:gt(.$vpagina)'.trigger("click");
	//$("#gvBuscar").tabla(base_url+'catalogos/cliente/getCliente');
	
});

function cargarProyectos()
{
	$.get(
			base_url + 'catalogos/proyecto/getProyectos'
		)
		.done(function(data)
		{
			var $option ='';
			$option =$('<option>');
			$option.val(0);
			$option.html('Todos');
			$('#proyectos').append($option);
			$.each(data,function(i,linea)
			{				
				if (linea.idproyecto == $('#hproyecto').val())
				{
					$option =$('<option selected>');
				}
				else
				{
					$option =$('<option>');
				}
				$option.val(linea.idproyecto);
				$option.html(linea.nombre);
				$('#proyectos').append($option);
			})
		})
		.fail(function(data)
		{
			console.log('error proyectos!!!');
		});
		
}

$(document).on('change','#proyectos',function()
{
	$('#idproyectoenviar').val($('#proyectos').val());
	$('#nomproyectoenviar').val($('#proyectos option:selected').html());
	$('#hproyecto').val($('#proyectos').val());

	if($('#hproyecto').val() == "" || $('#hproyecto').val() == null || $('#hproyecto').val() == 0){
		$("#gvBuscar").tabla(base_url+'catalogos/plantillaproyecto/getPlantillaProyectos');
	}
	else{
		$("#gvBuscar").tabla(base_url+'catalogos/plantillaproyecto/getPlantillaPorProyecto/'+$('#hproyecto').val());
	}
});



$(document).on('click','#gvBuscar>tbody>tr>td>button',function()
													{

														var idplantillaproyecto = $(this).parent().siblings(":eq(0)").text();
														var operacion = $(this).text();
														if (operacion=='Modificar')
														{
															//alert($("div.pagination > ul > li.active").text());
															window.location=base_url+"catalogos/plantillaproyecto/edit/"+idplantillaproyecto+"/"+$("div.pagination > ul > li.active").text();	
														}
														if (operacion=='Eliminar')
														{	
															var esglobal = $(this).parent().siblings(":eq(7)").text();
															
															if(esglobal==1)
															{
																alert("No se puede eliminar una cuenta que pertenece a la plantilla general")
															}
															else
															{
																plantillaEliminar=idplantillaproyecto;
																$('#myModal').modal('toggle');
															}
														  
														}
														
													});

$(document).on('click','#botonEliminar',function()
	                                   {
	                                   		window.location=base_url+"catalogos/plantillaproyecto/borrar/"+plantillaEliminar;
	                                   });

$(document).on('click','#botonGeneraPlantilla',function()
	                                   {
	                                   	//alert("a generar");
	                                   		window.location=base_url+"catalogos/plantillaproyecto/generaPlantilla/"+$('#proyectos').val();
	                                   });

$(document).on('click','#btnprueba',function()
	                                   {
	                                   		alert("llego");
	                                   		$("div.pagination > ul > li:gt(2)").trigger("click");
	                                   });