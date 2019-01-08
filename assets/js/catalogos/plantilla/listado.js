var base_url;
var principalEliminar;
var secundariaEliminar;
var descriptivaEliminar;
$(document).ready(function()
{
	base_url=$('base').attr('href');
	$("#gvBuscar").tabla(base_url+'catalogos/plantilla/getPlantillas');
	
});


$(document).on('click','#gvBuscar>tbody>tr>td>button',function()
													{
														var principal = $(this).parent().siblings(":eq(0)").text();
														var secundaria = $(this).parent().siblings(":eq(1)").text();
														var descriptiva = $(this).parent().siblings(":eq(2)").text();
														var operacion = $(this).text();
														if (operacion=='Modificar')
														{
															window.location=base_url+"catalogos/plantilla/edit/"+principal+"/"+secundaria+"/"+descriptiva;	
														}
														if (operacion=='Eliminar')
														{	
														    principalEliminar=principal;
														    secundariaEliminar=secundaria;
														    descriptivaEliminar=descriptiva;
															$('#myModal').modal('toggle');
														}
														//alert("hola"+carrera);
													});

$(document).on('click','#botonEliminar',function()
	                                   {
	                                   		window.location=base_url+"catalogos/plantilla/borrar/"+principalEliminar+"/"+secundariaEliminar+"/"+descriptivaEliminar;
	                                   });