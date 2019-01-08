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
							
							<form action="<?php echo site_url('catalogos/plantillaproyecto/edit'); ?>" method="post">
				
								<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
										value="<?php echo $this->security->get_csrf_hash(); ?>">
								
								<div class="form-group <?php if(form_error('idplantillaproyecto')) echo 'has-error'; ?>" style="display:none;">
									<label class="control-label" for="name"> Código: </label>
									<input class="form-control" readonly type="text" name="idplantillaproyecto" id="idplantillaproyecto" value="<?php echo $datosplantillaproyecto->idplantillaproyecto; ?>" maxlength="30">
									<?php echo form_error('idplantillaproyecto','<div class="help-block" >','</div>'); ?>
								</div>
								<div class="form-group">
									<label class="control-label" for="name"> Pagina: </label>
									<input class="form-control" readonly type="text" name="pagina" id="pagina" value="<?php echo $pagina; ?>" maxlength="30">
								</div>
								<div class="form-group <?php if(form_error('idproyecto')) echo 'has-error'; ?>">
									<label class="control-label" for="name"> ID Proyecto*: </label>
									<input class="form-control" type="text" name="idproyecto" id="idproyecto"  readonly value="<?php echo $datosplantillaproyecto->idproyecto; ?>">
									<?php echo form_error('idproyecto','<div class="help-block" >','</div>'); ?>
								</div>
								<div class="form-group <?php if(form_error('nomproyecto')) echo 'has-error'; ?>">
									<label class="control-label" for="name"> Proyecto*: </label>
									<input class="form-control" type="text" name="nomproyecto" id="nomproyecto"  readonly value="<?php echo $datosplantillaproyecto->nomproyecto; ?>">
									<?php echo form_error('nomproyecto','<div class="help-block" >','</div>'); ?>
								</div>
								<div class="form-group <?php if(form_error('principal')) echo 'has-error'; ?>">
									<label class="control-label" for="name"> Principal*: </label>
									<input class="form-control" type="text" name="principal" id="principal" readonly value="<?php echo $datosplantillaproyecto->principal; ?>" maxlength="3">
									<?php echo form_error('principal','<div class="help-block" >','</div>'); ?>
								</div>
								<div class="form-group <?php if(form_error('secundaria')) echo 'has-error'; ?>">
									<label class="control-label" for="name"> Secundaria*: </label>
									<input class="form-control" type="text" name="secundaria" id="secundaria" readonly value="<?php echo $datosplantillaproyecto->secundaria; ?>" maxlength="3">
									<?php echo form_error('secundaria','<div class="help-block" >','</div>'); ?>
								</div>
								<div class="form-group <?php if(form_error('descriptiva')) echo 'has-error'; ?>">
									<label class="control-label" for="name"> Descriptiva*: </label>
									<input class="form-control" type="text" name="descriptiva" id="descriptiva" readonly value="<?php echo $datosplantillaproyecto->descriptiva; ?>" maxlength="3">
									<?php echo form_error('descriptiva','<div class="help-block" >','</div>'); ?>
								</div>
								<div class="form-group <?php if(form_error('nombre')) echo 'has-error'; ?>">
									<label class="control-label" for="name"> Nombre: </label>
									<input class="form-control" type="text" name="nombre" id="nombre" value="<?php echo $datosplantillaproyecto->nombre; ?>" maxlength="100">
									<?php echo form_error('nombre','<div class="help-block" >','</div>'); ?>
								</div>
								<div class="form-group <?php if(form_error('presupuestado')) echo 'has-error'; ?>">
									<label class="control-label" for="name"> Presupuestado: </label>
									<input class="form-control" type="text" name="presupuestado" id="presupuestado" value="<?php echo $datosplantillaproyecto->presupuestado; ?>" maxlength="12">
									<?php echo form_error('presupuestado','<div class="help-block" >','</div>'); ?>
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
	