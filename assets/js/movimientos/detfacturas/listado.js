var base_url;
var detfacturaEliminar;
$(document).ready(function()
{
	base_url=$('base').attr('href');

	if($('#proyectos').length > 0)
		cargarProyectos();

	$("#gvBuscar").tabla(base_url+'movimientos/detfacturas/getDetFactura/'+$("#hfactura").val());
	
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



$(document).on('click','#gvBuscar>tbody>tr>td>button',function()
													{
														var iddetalle = $(this).parent().siblings(":eq(0)").text();
														var operacion = $(this).text();
														if (operacion=='Modificar')
														{
															window.location=base_url+"movimientos/detfacturas/edit/"+iddetalle;	
														}
														if (operacion=='Eliminar')
														{	
														    detfacturaEliminar=iddetalle;
															$('#myModal').modal('toggle');
														}
														//alert("hola"+carrera);
													});

$(document).on('click','#botonEliminar',function()
	                                   {
	                                   		window.location=base_url+"movimientos/detfacturas/borrar/"+detfacturaEliminar;
	                                   });