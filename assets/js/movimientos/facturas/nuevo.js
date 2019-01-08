var base_url;

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

function cargarTipoDocumento()
{
	$.get(
			base_url + 'catalogos/tipodocumento/getTipoDocumento'		
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
				if (linea.idtipodocumento == $('#htipodocumento').val())
				{
					$option =$('<option selected>');
				}
				else
				{
					$option =$('<option>');
				}
				$option.val(linea.idtipodocumento);
				$option.html(linea.descripcion);
				$('#tiposdocumentos').append($option);
			})
			//$('#proyectos').select2();
		})
		.fail(function(data)
		{
			console.log('error tipos de documentos!!!');
		});
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
	if($('#tiposdocumentos').length > 0)
		cargarTipoDocumento();
	if($('#empleados').length > 0)
		cargarEmpleado();

});
