var base_url;
base_url=$('base').attr('href');

var newArray = [];
var newArray2 = [];
var arrTotales =new Array();

var cantidadMeses = 0;
var nb_mes = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];



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

$tamanoVector =0;
$("#btnConsultar").click(function() 
{   
	
	
    //GENERA EL ENCABEZADO DE LOS MESES
    $.get(
			base_url+'reportes/ejecutadomes/getEjecutadoMesRango/'+$("#proyectos").val()		
		)
		.done(function(data)
		{
		    arrTotales =new Array();
		    newArray2 =new Array();
		    cantidadMeses=0;
			$.each(data,function(i,linea)
			{
                //cantidadMeses = linea.maxcuotas;
				//alert(linea.maxcuotas);
				$("#gvReporte > thead > tr").remove();

				var tr = $(document.createElement('tr'));
				$("#gvReporte > thead").append(tr);				

                
				var th = $(document.createElement('th'));
				th.html("CUENTA");
				$("#gvReporte > thead > tr").append(th);

				var th = $(document.createElement('th'));
				th.html("NOMBRE");
				$("#gvReporte > thead > tr").append(th);
                
				var fechatxt = linea.fechamin;
				var fechadiv = fechatxt.split("-");
				var fecha = new Date(fechadiv[0],fechadiv[1]-1,fechadiv[2]);
				var mes = fecha.getMonth();
				mes += 1;
				var anio = fecha.getYear();
				if ( anio < 1900 ) {
					anio = 1900 + fecha.getYear();
				}

				var fechamaxtxt = linea.fechamax;
				var fechamaxdiv = fechamaxtxt.split("-");
				var fechamax = new Date(fechamaxdiv[0],fechamaxdiv[1]-1,fechamaxdiv[2]);
				var mesmax = fechamax.getMonth();
				mesmax += 1;
				var aniomax = fechamax.getYear();
				if ( aniomax < 1900 ) {
					aniomax = 1900 + fechamax.getYear();
				}

				var contador = 0;
				do{
					contador++;
					var th = $(document.createElement('th'));
					//th.html("Mes "+i);
					th.html(nb_mes[mes-1] + '-' + anio);

					newArray2.push(nb_mes[mes-1] + '-' + anio);

					if(mes !=  mesmax || anio != aniomax)
					{
						mes += 1;
						if(mes > 12){ mes = 1; anio += 1; }
					}

					$("#gvReporte > thead > tr").append(th);

					newArray[contador-1] = 0;					
				}while(mes !=  mesmax || anio != aniomax);	

				if(contador > 1)
				{
					contador++;
					var th = $(document.createElement('th'));
					//th.html("Mes "+i);
					th.html(nb_mes[mes-1] + '-' + anio);

					newArray2.push(nb_mes[mes-1] + '-' + anio);

					mes += 1;
					if(mes > 12){ mes = 1; anio += 1; }

					$("#gvReporte > thead > tr").append(th);

					newArray[contador-1] = 0;
				}

				cantidadMeses = contador;
				
			})
            
			for(i = 0;i<cantidadMeses;i++ )
			{

				arrTotales[i]=0.00;
			}

		})
		.fail(function(data)
		{
			
			console.log('error proyectos!!!');
		});
     
	// GENERA LOS DATOS
	var cuenta = "";
	var idinmueble = "";
	var nombre = "";
	var cont = 0;
	var cont2 = 0;
	var sumCuenta = 0.00;
	var monto = 0;

	var tr = $(document.createElement('tr'));

    
    var arrDetalle =new Array();
    
    /*console.log(cantidadMeses);
    for(i = 0;i<cantidadMeses;i++ )
	{

		arrTotales[i]=0.00;
	}*/

    var contDetalle=0;
	$.get(
			base_url+'reportes/ejecutadomes/getPresupuestoXProyectoMes/'+$("#proyectos").val()		
		)
		.done(function(data)
		{
			
			$("#gvReporte > tbody > tr").remove();
			$.each(data,function(i,linea)
			{

				contDetalle=0;
				
				// En cada linea de datos se trae el idnegociacion, si el idnegociacion cambia es una nueva linea, 
				// sino es se agregan los td a la linea en curso
				
				if(cuenta != linea.cuenta)
				{
					if(cuenta != "")
					{
						//******poner el detalle del arreglodetalle*******
						tr = $(document.createElement('tr'));
						$("#gvReporte > tbody").append(tr);
						var td = $(document.createElement('td'));
						td.html(cuenta);
						tr.append(td);

						var td = $(document.createElement('td'));
						td.html(nombre);
						tr.append(td);
						for(i = 0;i<cantidadMeses;i++ )
						{
							var td = $(document.createElement('td'));
							td.html(arrDetalle[i]);
							tr.append(td);
							arrTotales[i]=parseFloat(arrTotales[i])+parseFloat(arrDetalle[i]);
							arrTotales[i]=arrTotales[i].toFixed(2);
							arrDetalle[i]=0.00;

						}
						//poner la suma por linea
						var td = $(document.createElement('td'));
						sumCuenta=parseFloat(sumCuenta);
						sumCuenta=sumCuenta.toFixed(2);
						td.html(sumCuenta);
						tr.append(td);
						sumCuenta=0.00;

					}


					// Al cambiar de negociacion se genera una nueva linea y reinicia los contadores.

					cuenta = linea.cuenta;
					nombre = linea.nombre;
				}

				// Recorre desde 0 hasta la cantidad de meses y donde valla cazando las fechas de los pagos va colocando los montos de pago,
				// si no caza coloca el campo vacio
				
				var fechatxt = linea.fechaejecutado;
				
					cont=0;
				for(xx = 0;xx<cantidadMeses;xx++ )
				{
					
					// Obtiene la fecha descompuesta en mes y año del pago
					    if (fechatxt!=null)
					    {
							var fechadiv = fechatxt.split("-");
							var fecha = new Date(fechadiv[0],fechadiv[1]-1,fechadiv[2]);

							var mes = fecha.getMonth();
							mes += 1;
							var anio = fecha.getYear();
							if ( anio < 1900 ) {
								anio = 1900 + fecha.getYear();
							}
							// Si la fecha del pago obteniza coincide con la fecha guardada en el array imprime el monto
							if(newArray2[cont] == nb_mes[mes-1]+'-'+anio)
							{
								//console.log("entro*****************");
								//console.log(contDetalle);

								if ((arrDetalle[contDetalle]>0))
								{
									arrDetalle[contDetalle]=parseFloat(arrDetalle[contDetalle])+parseFloat(linea.ejecutadosubpartida);
									arrDetalle[contDetalle]=arrDetalle[contDetalle].toFixed(2);	
								}
								else
								{
									arrDetalle[contDetalle]=parseFloat(linea.ejecutadosubpartida);
									arrDetalle[contDetalle]=arrDetalle[contDetalle].toFixed(2);
								}
								sumCuenta=parseFloat(sumCuenta)+parseFloat(linea.ejecutadosubpartida);
								sumCuenta=sumCuenta.toFixed(2);

								
								cont++;
								//break;
							}
							else	// si no coincide la fecha crea el td vacio
							{
								//alert(arrDetalle[contDetalle]);
								if (!(arrDetalle[contDetalle]>0))
								{
									if (cuenta!="")
									{
										arrDetalle[contDetalle]=parseFloat(0);	
									}
										
								}
							}
						}
						else
						{
							arrDetalle[contDetalle]=0.00;
						}
						cont++;
						contDetalle=contDetalle+1;
				}
			})

           
           	//********poner la ultima linea del detalle
           	//******poner el detalle del arreglodetalle*******
			tr = $(document.createElement('tr'));
			$("#gvReporte > tbody").append(tr);
			var td = $(document.createElement('td'));
			td.html(cuenta);
			tr.append(td);

			var td = $(document.createElement('td'));
			td.html(nombre);
			tr.append(td);
			for(i = 0;i<cantidadMeses;i++ )
			{
				var td = $(document.createElement('td'));
				td.html(arrDetalle[i]);
				tr.append(td);
				arrTotales[i]=parseFloat(arrTotales[i])+parseFloat(arrDetalle[i]);
				arrTotales[i]=arrTotales[i].toFixed(2);
				arrDetalle[i]=0.00;
			}
			var td = $(document.createElement('td'));
						td.html(sumCuenta);
						tr.append(td);

			//**************poner los totales verticales

			
			 tr = $(document.createElement('tr'));
			$("#gvReporte > tbody").append(tr);
			var td = $(document.createElement('td'));
			td.html("TOTAL");
			tr.append(td);

			var td = $(document.createElement('td'));
			td.html("");
			tr.append(td);

			for(i = 0;i<cantidadMeses;i++ )
			{
				var td = $(document.createElement('td'));
				td.html(arrTotales[i]);
				tr.append(td);
			}

		})
		.fail(function(data)
		{
			console.log('error proyectos!!!');
		});





});

$(document).ready(function()
{
	
	base_url = $('base').attr('href');

	if($('#proyectos').length > 0)
		cargarProyecto();

});

$(document).on('click','#btnExport',function(e)
	                                   {
	                                        //window.open('data:application/vnd.ms-excel,' + $('#tabla1').html());
	                                        window.open('data:application/vnd.ms-excel,' + encodeURIComponent($('#divexp').html()));
   											e.preventDefault();
	                                   });

