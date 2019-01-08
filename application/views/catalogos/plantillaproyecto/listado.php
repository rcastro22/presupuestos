<?php echo $headercat;?>
<div class="container">
	<div class="row" style="display:<?php if (!isset($mensaje) || $mensaje=="") echo "none"; ?>">
		<div class="col-12">
			<div class="alert <?php echo $tipoAlerta;?>">
				<a href="#" class="close" data-dismiss="alert">&times;</a>
				<?php echo $mensaje;?>	
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-10 col-lg-offset-1" >
			<div class="panel panel-default">
		  	<!-- Default panel contents -->
		  		<div class="panel-heading panel-heading-extras" > 
		  			<?php echo $page_title;?>  del proyecto
		  		</div>
	  			<div class="panel-body">
					<div class="col-lg-6 col-lg-offset-3 form-horizontal">
						<div class="form-group">
							<div class="col-lg-9">
								<!--<input type="button" id="btnprueba" name="btnprueba">
								<input type="text" name="pagina" id="pagina" value="<?php echo $pagina; ?>" />-->
								<input type="hidden" name="hproyecto" id="hproyecto" value="<?php echo $hproyecto; ?>" />
								<select class="form-control" name="proyectos" id="proyectos"></select>		
							</div>
						</div>
					</div>	
					<div class="col-lg-3">
						 <button id="botonGeneraPlantilla" name="botonGeneraPlantilla" class="btn btn-negro">Generar Plantilla</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div style="text-align:center;">
		<form id="frmProyecto" action="<?php echo base_url().'catalogos/plantillaproyecto/nuevo';?>" method="get">
			<!--<a href="<?php echo base_url().'catalogos/plantillaproyecto/nuevo';?>" class="btn btn-negro">Nueva Cuenta</a>-->
		    <input type="hidden" name="idproyectoenviar" id="idproyectoenviar" value="" readonly />
		    <input type="hidden" name="nomproyectoenviar" id="nomproyectoenviar" value="" readonly/>
			<button class="btn btn-negro">Nueva cuenta</button>
		<form>
	</div>	

	<div class="row">
		<div class="col-lg-10 col-lg-offset-1">
			<div class="panel panel-default">
		  		<div class="panel-heading panel-heading-extras" height="30px"> 
		  			Cuentas
		  			
		  		</div>
	  			<div class="panel-body" style="overflow-x: auto">
					<div class="form-search pull-right input-group" data-tabla="gvBuscar">
						<span class="input-group-addon">Buscar</span>
                		<input type="text" class="search-query form-control" placeholder="Ingrese su búsqueda" />
        			</div>	
						<table class="table table-striped table-bordered table-hover tabla" data-orden="true" data-filtro="true" data-fuente="dtLlenar" id="gvBuscar">
						<thead>
		    				<tr>
		    					<th class="hide" data-tipo="string" data-campo="idplantillaproyecto" data-alineacion="izquierda" style="text-align:center">ID PLANTILLA PROYECTO</th>
	              				<th class="hide" data-tipo="string" data-campo="principal" data-alineacion="izquierda" style="text-align:center">PRINCIPAL</th>
		              			<th class="hide" data-tipo="string" data-campo="secundaria" data-alineacion="izquierda" style="text-align:center">SECUNDARIA</th>
		              			<th class="hide" data-tipo="string" data-campo="descriptiva" data-alineacion="izquierda" style="text-align:center">DESCRIPTIVA</th>
		              			<th data-tipo="string" data-campo="cuenta" data-alineacion="izquierda" style="text-align:center">CUENTA</th>
		              			<th data-tipo="string" data-campo="nombre" data-alineacion="izquierda" style="text-align:center">NOMBRE</th>
		              			<th data-tipo="decimal" data-formato="#,###,###.##" data-campo="presupuestado" data-alineacion="derecha" style="text-align:center">PRESUPUESTADO</th>
		              			<th data-tipo="int" data-campo="esgeneral" data-alineacion="centro" style="text-align:center">GENERAL</th>
		              			<th data-boton="Modificar" data-alineacion="centro" style="text-align:center"></th>
		              			<th data-boton="Eliminar" data-alineacion="centro" style="text-align:center"></th>
	         				</tr>
		 				</thead>
	    				<tbody>
	    				</tbody>
					</table>
				</div>
				<div style="text-align:center">
					<div class="pagination">
						<ul class="pagination pagination-centered" data-tabla="gvBuscar" data-cantidad="10" data-grupo="8"></ul>
						</div>
					</div>
				</div>
			<!--<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" >-->
		</div>
	</div>
</div>
<div>
	<div class="modal fade" id="myModal">
		<div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		        <h4 class="modal-title">Confirmación</h4>
		      </div>
		      <div class="modal-body">
		        <p>Seguro que desea eliminar el registro? &hellip;</p>
		      </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
		        <button type="button" id="botonEliminar" name="botonEliminar" class="btn btn-primary">Eliminar</button>
		      </div>
		    </div><!-- /.modal-content -->
	  	</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
</div>
<script src="<?php echo base_url().'assets/js/tabla.js';?>"></script> 
<script src="<?php echo base_url().'assets/js/catalogos/plantillaproyecto/listado.js';?>"></script> 

<?php echo $footer;?>


			


