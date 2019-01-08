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


//procedimiento de cargar empleado
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


$("#btnConsultar").click(function() {   
	$("#gvBuscar").tabla(base_url+'reportes/porempleado/getPresupuestoXEmpleado/'+$("#proyectos").val()+'/'+$("#empleados").val());
	
});


$(document).ready(function()
{

	base_url = $('base').attr('href');

	if($('#proyectos').length > 0)
		cargarProyecto();
	if($('#empleados').length > 0)
		cargarEmpleado();

});

$(document).on('click','#btnExport',function(e)
	                                   {
	                                        //window.open('data:application/vnd.ms-excel,' + $('#tabla1').html());
	                                        window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#divexp').html()));
   											e.preventDefault();
	                                   });

