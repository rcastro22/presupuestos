var base_url;
base_url=$('base').attr('href');

function cargarProyecto()
{
	$.get(
			base_url + 'catalogos/proyecto/getProyectos'		
		)
		.done(function(data)
		{
			
			var $option ='';
			$option =$('<option>');
			$option.val(0);
			$option.html('Seleccione proyecto');
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
			base_url + 'catalogos/plantillaproyecto/getPlantillaPorProyecto/'+$("#proyectos").val()
			//base_url + 'catalogos/plantillaproyecto/getPlantillaPorProyecto/1'
		)
		.done(function(data)
		{
			var $option ='';			
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

	var idproy = idproyecto.toString();

		
}

$("#btnConsultar").click(function() {   
	$("#gvBuscar").tabla(base_url+'reportes/detalleejecutado/getDetalleEjecutado/'+$("#plantillas").val());
	
});

$(document).ready(function()
{
	
	base_url = $('base').attr('href');

	if($('#proyectos').length > 0)
		cargarProyecto();
	

});

$(document).on('change','#proyectos',function()
{

	//if($('#plantillas').length > 0)
		cargarPlantillas();	
});

$(document).on('click','#btnExport',function(e)
	                                   {
	                                        //window.open('data:application/vnd.ms-excel,' + $('#tabla1').html());
	                                        window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#divexp').html()));
   											e.preventDefault();
	                                   });

