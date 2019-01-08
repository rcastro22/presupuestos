var base_url;
var empleadoEliminar;
$(document).ready(function()
{
	base_url=$('base').attr('href');
	$("#gvBuscar").tabla(base_url+'catalogos/empleado/getEmpleado');
	
});


$(document).on('click','#gvBuscar>tbody>tr>td>button',function()
													{
														var idempleado = $(this).parent().siblings(":eq(0)").text();
														var operacion = $(this).text();
														if (operacion=='Modificar')
														{
															window.location=base_url+"catalogos/empleado/edit/"+idempleado;	
														}
														if (operacion=='Eliminar')
														{	
														    empleadoEliminar=idempleado;
															$('#myModal').modal('toggle');
														}
														//alert("hola"+carrera);
													});

$(document).on('click','#botonEliminar',function()
	                                   {
	                                   		window.location=base_url+"catalogos/empleado/borrar/"+empleadoEliminar;
	                                   });