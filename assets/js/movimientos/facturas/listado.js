var base_url;
var facturaEliminar;
$(document).ready(function()
{
	base_url=$('base').attr('href');

	if($('#hproyecto').val() == "") $('#hproyecto').val('0');
	if($('#hplantilla').val() == "") $('#hplantilla').val('0');

	if($('#proyectos').length > 0)
		cargarProyectos();

	if($('#plantillas').length > 0)
		cargarPlantillas();

	$("#gvBuscar").tabla(base_url+'movimientos/facturas/getFacturaPorProyecto/'+$('#hproyecto').val()+'/'+$('#hplantilla').val());
	//$("#gvBuscar").tabla(base_url+'movimientos/facturas/getFactura');
	
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

function cargarPlantillas()
{
	$.get(
			base_url + 'catalogos/plantillaproyecto/getPlantillaPorProyecto/'+$("#hproyecto").val()
			//base_url + 'catalogos/plantillaproyecto/getPlantillaPorProyecto/1'
		)
		.done(function(data)
		{
			var $option ='';	
			$option =$('<option>');
			$option.val(0);
			$option.html('Todos');
			$('#plantillas').append($option);		
			$.each(data,function(i,linea)
			{				
				if (linea.idplantillaproyecto == $('#hplantilla').val())
				{
					$option =$('<option selected>');
				}
				else
				{
					$option =$('<option>');
				}
				$option.val(linea.idplantillaproyecto);
				$option.html(linea.cuenta + ' - ' + linea.nombre);
				$('#plantillas').append($option);
			})
		})
		.fail(function(data)
		{
			console.log('error plantilla!!!');
		});

	//var idproy = idproyecto.toString();

		
}

$(document).on('change','#proyectos',function(){
	$('#hproyecto').val($('#proyectos').val());
	document.getElementById('plantillas').options.length = 0;
	$('#hplantilla').val('0');
	cargarPlantillas();
	
	$("#gvBuscar").tabla(base_url+'movimientos/facturas/getFacturaPorProyecto/'+$('#hproyecto').val()+'/'+$('#hplantilla').val());		
});

$(document).on('change','#plantillas',function(){
	$('#hplantilla').val($('#plantillas').val());
	
	$("#gvBuscar").tabla(base_url+'movimientos/facturas/getFacturaPorProyecto/'+$('#hproyecto').val()+'/'+$('#hplantilla').val());		
});

$(document).on('click','#gvBuscar>tbody>tr>td>button',function()
													{
														var idfactura = $(this).parent().siblings(":eq(0)").text();
														var operacion = $(this).text();
														if (operacion=='Modificar')
														{
															window.location=base_url+"movimientos/facturas/edit/"+idfactura;	
														}
														if (operacion=='Eliminar')
														{	
														    facturaEliminar=idfactura;
															$('#myModal').modal('toggle');
														}
														if (operacion=='Ver')
														{
															window.location=base_url+"movimientos/detfacturas/listado/"+idfactura;	
														}
														//alert("hola"+carrera);
													});

$(document).on('click','#botonEliminar',function()
	                                   {
	                                   		window.location=base_url+"movimientos/facturas/borrar/"+facturaEliminar;
	                                   });