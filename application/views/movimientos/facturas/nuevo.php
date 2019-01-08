<?php echo $headermov;?>
	<div class="container">
		<div class="row" style="display:<?php if (!isset($mensaje) || $mensaje=="") echo "none"; ?>">
			<div class="col-lg-10 col-lg-offset-1">
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
			  		<div class="panel-heading" > <?php echo $page_title;?>  </div>
			  			<div class="panel-body">
							
							<form action="<?php echo site_url('movimientos/facturas/nuevo'); ?>" method="post">
				
								<!--<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
										value="<?php echo $this->security->get_csrf_hash(); ?>">
								-->
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group">
											<input type="hidden" name="hproyecto" id="hproyecto" value="<?php echo $datosfactura->idproyecto; ?>" />
											<label class="control-label" for="name"> Proyecto: </label>
											<select class="form-control" name="proyectos" id="proyectos"></select>										
										</div>
									</div>		
									<div class="col-lg-6">
										<div class="form-group">
											<input type="hidden" name="htipodocumento" id="htipodocumento" value="<?php echo $datosfactura->idtipodocumento; ?>" />
											<label class="control-label" for="name"> Tipo de Documento: </label>
											<select class="form-control" name="tiposdocumentos" id="tiposdocumentos"></select>										
										</div>
									</div>							
								</div>	
								<div class="row">								
									<div class="col-lg-6">
										<div class="form-group <?php if(form_error('noserie')) echo 'has-error'; ?>">
											<label class="control-label" for="name"> Serie: </label>
											<input class="form-control" type="text" name="noserie" id="noserie" value="<?php echo set_value('noserie'); ?>" maxlength="20">
											<?php echo form_error('noserie','<div class="help-block" >','</div>'); ?>
										</div>
									</div>		
									<div class="col-lg-6">
										<div class="form-group <?php if(form_error('nofactura')) echo 'has-error'; ?>">
											<label class="control-label" for="name"> Número de documento: </label>
											<input class="form-control" type="text" name="nofactura" id="nofactura" value="<?php echo set_value('nofactura'); ?>" maxlength="20">
											<?php echo form_error('nofactura','<div class="help-block" >','</div>'); ?>
										</div>
									</div>							
								</div>
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group <?php if(form_error('nit')) echo 'has-error'; ?>">
											<label class="control-label" for="name"> NIT: </label>
											<input class="form-control" type="text" name="nit" id="nit" value="<?php echo set_value('nit'); ?>" maxlength="15">
											<?php echo form_error('nit','<div class="help-block" >','</div>'); ?>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group <?php if(form_error('proveedor')) echo 'has-error'; ?>">
											<label class="control-label" for="name"> Nombre proveedor: </label>
											<input class="form-control" type="text" name="proveedor" id="proveedor" value="<?php echo set_value('proveedor'); ?>" maxlength="60">
											<?php echo form_error('proveedor','<div class="help-block" >','</div>'); ?>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-6">
										<div class="form-group <?php if(form_error('fecha')) echo 'has-error'; ?>">
											<label class="control-label" for="name"> Fecha: </label>
											<input class="form-control" type="text" name="fecha" id="fecha" value="<?php echo set_value('fecha'); ?>" maxlength="30">
											<?php echo form_error('fecha','<div class="help-block" >','</div>'); ?>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="form-group <?php if(form_error('tipocambio')) echo 'has-error'; ?>">
											<label class="control-label" for="name"> Tipo de cambio: </label>
											<input class="form-control" type="text" name="tipocambio" id="tipocambio" value="<?php echo set_value('tipocambio'); ?>" maxlength="13">
											<?php echo form_error('tipocambio','<div class="help-block" >','</div>'); ?>
										</div>
									</div>									
								</div>
								<div class="row">									
									<div class="col-lg-6">
										<div class="form-group">
											<input type="hidden" name="hempleado" id="hempleado" value="<?php echo $datosfactura->idempleado; ?>" />
											<label class="control-label" for="name"> Empleado: </label>
											<select class="form-control" name="empleados" id="empleados"></select>										
										</div>
									</div>									
								</div>



								<div style="text-align:center">
									<button class="btn btn-lg btn-negro">Guardar</button>
								</div>
							</form>


						</div>
    				
				</div>
			</div>
		</div>
	</div>

	<script src="<?php echo base_url().'assets/js/tabla.js';?>"></script> 
	<script src="<?php echo base_url().'assets/js/movimientos/facturas/nuevo.js';?>"></script> 
	
	<?php echo $footer;?>
	<script>
		$('select[name=proyectos]').focus();
		$('#fecha').datepicker({'format':'yyyy-mm-dd'});
	</script>
