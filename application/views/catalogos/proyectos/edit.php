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
			<div class="col-lg-10 col-lg-offset-1" >
				<div class="panel panel-default">
			  	<!-- Default panel contents -->
			  		<div class="panel-heading" > <?php echo $page_title;?>  </div>
			  			<div class="panel-body">
							
							<form action="<?php echo site_url('catalogos/proyecto/edit'); ?>" method="post">
								<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
												value="<?php echo $this->security->get_csrf_hash(); ?>">
								<div class="row">
									<div class="col-lg-3 col-lg-offset-1">
										<div class="form-group <?php if(form_error('idproyecto')) echo 'has-error'; ?>">
											<label class="control-label" for="name"> Código: </label>
											<input class="form-control" readonly type="text" name="idproyecto" id="idproyecto" value="<?php echo $datosproyecto->idproyecto; ?>" maxlength="30">
											<?php echo form_error('idproyecto','<div class="help-block" >','</div>'); ?>
										</div>
									</div>
									<div class="col-lg-7 col-lg-offset-1">
										<div class="form-group <?php if(form_error('nombre')) echo 'has-error'; ?>">
											<label class="control-label" for="name"> Nombre: </label>
											<input class="form-control" type="text" name="nombre" id="nombre" value="<?php echo $datosproyecto->nombre; ?>" maxlength="30">
											<?php echo form_error('nombre','<div class="help-block" >','</div>'); ?>
										</div>
									</div>
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