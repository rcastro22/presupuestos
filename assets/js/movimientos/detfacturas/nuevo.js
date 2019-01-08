var base_url;
var idproyecto = "";

function cargarProyecto()
{
	$.get(
			base_url + 'catalogos/proyecto/getProyectos'		
		)
		.done(function(data)
		{
			var $option ='';
			/*$option =$('<option>');
			$option.val(0);
			$option.html('Seleccione Proyecto');
			$('#proyectos').append($option);*/
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
			//$('#proyectos').select2();
		})
		.fail(function(data)
		{
			console.log('error proyectos!!!');
		});
}

function cargarPlantillas()
{
	

	$.get(
			base_url + 'movimientos/facturas/getfacturaId/'+$("#hfactura").val()
		)
		.done(function(data)
		{
			/*var $option ='';			
			$.each(data,function(i,linea)
			{	
				alert(linea);			
				idproyecto = linea.idproyecto;
			})*/
			idproyecto = data.idproyecto;
			$("#hproyecto").val(idproyecto);


			$.get(
					base_url + 'catalogos/plantillaproyecto/getPlantillaPorProyecto/'+$("#hproyecto").val()
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



		})
		.fail(function(data)
		{
			console.log('error!!!');
		});


	var idproy = idproyecto.toString();

		
}

function cargarEmpleado()
{
	$.get(
			base_url + 'catalogos/empleado/getEmpleado'		
		)
		.done(function(data)
		{
			var $option ='';
			/*$option =$('<option>');
			$option.val(0);
			$option.html('Seleccione Proyecto');
			$('#proyectos').append($option);*/
			$.each(data,function(i,linea)
			{				
				if (linea.idempleado == $('#hempleado').val())
				{
					$option =$('<option selected>');
				}
				else
				{
					$option =$('<option>');
				}
				$option.val(linea.idempleado);
				$option.html(linea.nombre+' '+linea.apellido);
				$('#empleados').append($option);
			})
			//$('#proyectos').select2();
		})
		.fail(function(data)
		{
			console.log('error empleados!!!');
		});
}

$(document).ready(function()
{
	base_url = $('base').attr('href');

	if($('#proyectos').length > 0)
		cargarProyecto();
	if($('#plantillas').length > 0)
		cargarPlantillas();
	if($('#empleados').length > 0)
		cargarEmpleado();

});
