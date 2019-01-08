<?php echo $headercat;?>
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
							
							<form action="<?php echo site_url('catalogos/plantillaproyecto/nuevo'); ?>" method="post">
				
								<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
										value="<?php echo $this->security->get_csrf_hash(); ?>">
								
								<div class="form-group <?php if(form_error('idproyecto')) echo 'has-error'; ?>">
									<label class="control-label" for="name"> ID Proyecto*: </label>
									<input class="form-control" type="text" name="idproyecto" id="idproyecto"  readonly value="<?php if (isset($idproyecto)){echo $idproyecto; }else{echo set_value('idproyecto'); }?>">
									<?php echo form_error('idproyecto','<div class="help-block" >','</div>'); ?>
								</div>
								<div class="form-group <?php if(form_error('nomproyecto')) echo 'has-error'; ?>">
									<label class="control-label" for="name"> Proyecto*: </label>
									<input class="form-control" type="text" name="nomproyecto" id="nomproyecto"  readonly value="<?php if (isset($nomproyecto)){echo $nomproyecto; }else{echo set_value('nomproyecto'); }?>">
									<?php echo form_error('nomproyecto','<div class="help-block" >','</div>'); ?>
								</div>
								<div class="form-group <?php if(form_error('principal')) echo 'has-error'; ?>">
									<label class="control-label" for="name"> Principal*: </label>
									<input class="form-control" type="text" name="principal" id="principal" value="<?php echo set_value('principal'); ?>" maxlength="3">
									<?php echo form_error('principal','<div class="help-block" >','</div>'); ?>
								</div>
								<div class="form-group <?php if(form_error('secundaria')) echo 'has-error'; ?>">
									<label class="control-label" for="name"> Secundaria*: </label>
									<input class="form-control" type="text" name="secundaria" id="secundaria" value="<?php echo set_value('secundaria'); ?>" maxlength="3">
									<?php echo form_error('secundaria','<div class="help-block" >','</div>'); ?>
								</div>
								<div class="form-group <?php if(form_error('descriptiva')) echo 'has-error'; ?>">
									<label class="control-label" for="name"> Descriptiva*: </label>
									<input class="form-control" type="text" name="descriptiva" id="descriptiva" value="<?php echo set_value('descriptiva'); ?>" maxlength="3">
									<?php echo form_error('descriptiva','<div class="help-block" >','</div>'); ?>
								</div>
								<div class="form-group <?php if(form_error('nombre')) echo 'has-error'; ?>">
									<label class="control-label" for="name"> Nombre: </label>
									<input class="form-control" type="text" name="nombre" id="nombre" value="<?php echo set_value('nombre'); ?>" maxlength="100">
									<?php echo form_error('nombre','<div class="help-block" >','</div>'); ?>
								</div>
								<div class="form-group <?php if(form_error('presupuestado')) echo 'has-error'; ?>">
									<label class="control-label" for="name"> Presupuestado: </label>
									<input class="form-control" type="text" name="presupuestado" id="presupuestado" value="<?php echo set_value('presupuestado'); ?>" maxlength="12">
									<?php echo form_error('presupuestado','<div class="help-block" >','</div>'); ?>
								</div>
								
								<div style="text-align:center">
									<button class="btn btn-lg btn-negro">Guardar</button>
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
