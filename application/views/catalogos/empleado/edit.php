<?php echo $headercat;?>
   <div class="row" style="display:<?php if (!isset($mensaje) || $mensaje=="") echo "none"; ?>">
		<div class="col-lg-10 col-lg-offset-1">
			<div class="alert <?php echo $tipoAlerta;?>">
				<a href="#" class="close" data-dismiss="alert">&times;</a>
				<?php echo $mensaje;?>	
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-lg-6 col-lg-offset-3" >
				<div class="panel panel-default">
			  	<!-- Default panel contents -->
			  		<div class="panel-heading" > <?php echo $page_title;?>  </div>
			  			<div class="panel-body">
							
							<form action="<?php echo site_url('catalogos/empleado/edit'); ?>" method="post">
				
								<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
										value="<?php echo $this->security->get_csrf_hash(); ?>">
							
								<div class="form-group <?php if(form_error('idempleado')) echo 'has-error'; ?>">
									<label class="control-label" for="name"> Código: </label>
									<input class="form-control" readonly type="text" name="idempleado" id="idempleado" value="<?php echo $datosempleado->idempleado; ?>" maxlength="30">
									<?php echo form_error('idempleado','<div class="help-block" >','</div>'); ?>
								</div>
								<div class="form-group <?php if(form_error('nombre')) echo 'has-error'; ?>">
									<label class="control-label" for="name"> Nombre: </label>
									<input class="form-control" type="text" name="nombre" id="nombre" value="<?php echo $datosempleado->nombre; ?>" maxlength="40">
									<?php echo form_error('nombre','<div class="help-block" >','</div>'); ?>
								</div>
								<div class="form-group <?php if(form_error('apellido')) echo 'has-error'; ?>">
									<label class="control-label" for="name"> Apellido: </label>
									<input class="form-control" type="text" name="apellido" id="apellido" value="<?php echo $datosempleado->apellido; ?>" maxlength="40">
									<?php echo form_error('apellido','<div class="help-block" >','</div>'); ?>
								</div>
								<div class="form-group <?php if(form_error('direccion')) echo 'has-error'; ?>">
									<label class="control-label" for="name"> Dirección: </label>
									<input class="form-control" type="text" name="direccion" id="direccion" value="<?php echo $datosempleado->direccion; ?>" maxlength="100">
									<?php echo form_error('direccion','<div class="help-block" >','</div>'); ?>
								</div>
								<div class="form-group <?php if(form_error('telefono')) echo 'has-error'; ?>">
									<label class="control-label" for="name"> Telefono: </label>
									<input class="form-control" type="text" name="telefono" id="telefono" value="<?php echo $datosempleado->telefono; ?>" maxlength="20">
									<?php echo form_error('telefono','<div class="help-block" >','</div>'); ?>
								</div>
								
								<div style="text-align:center">
									<button class="btn btn-lg btn-negro">Modificar</button>
								</div>
							</form>


						</div>
    				
				</div>
			</div>
		</div>
	<div>
	<script src="<?php echo base_url().'assets/js/tabla.js';?>"></script> 
	
	<?php echo $footer;?>
	<script>
		$('input[name=nombre]').focus();
	</script>