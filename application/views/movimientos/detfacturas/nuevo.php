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
		  			<div class="panel-heading panel-heading-extras" > </div>
		  				<div class="panel-body">
							<div>								
								<div class="col-lg-6 form-horizontal">
									<div class="form-group">
										<label class="control-label col-lg-3" for="name"> Factura: </label>						
										<div class="col-lg-9">
											<input readonly type="text" class="form-control" name="hfactura" id="hfactura" value="<?php echo $idfactura; ?>" />
											<!--<select class="form-control" readonly name="dfactura" id="dfactura"></select>-->	
											<input type="hidden" class="form-control" name="hproyecto" id="hproyecto" value="" />
										</div>
									</div>
								</div>								
							</div>
						</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-10 col-lg-offset-1" >
				<div class="panel panel-default">
			  	<!-- Default panel contents -->
			  		<div class="panel-heading" > <?php echo $page_title;?>  </div>
			  			<div class="panel-body">
							
							<form action="<?php echo site_url('movimientos/detfacturas/nuevo/'.$idfactura); ?>" method="post">
				
								<!--<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
										value="<?php echo $this->security->get_csrf_hash(); ?>">
								-->
								<div class="row">
									<div class="col-lg-3">
										<div class="form-group">
											<input type="hidden" name="hplantilla" id="hplantilla" value="<?php echo $datosdetfactura->idplantillaproyecto; ?>" />
											<label class="control-label" for="name"> Plantilla: </label>
											<select class="form-control" name="plantillas" id="plantillas"></select>										
										</div>
									</div>									
								</div>	
								<div class="row">								
									<div class="col-lg-4">
										<div class="form-group <?php if(form_error('descripcion')) echo 'has-error'; ?>">
											<label class="control-label" for="name"> Descripción: </label>
											<input class="form-control" type="text" name="descripcion" id="descripcion" value="<?php echo set_value('descripcion'); ?>" maxlength="200">
											<?php echo form_error('descripcion','<div class="help-block" >','</div>'); ?>
										</div>
									</div>		
									<div class="col-lg-4">
										<div class="form-group <?php if(form_error('monto')) echo 'has-error'; ?>">
											<label class="control-label" for="name"> Monto: </label>
											<input class="form-control" type="text" name="monto" id="monto" value="<?php echo set_value('monto'); ?>" maxlength="20">
											<?php echo form_error('monto','<div class="help-block" >','</div>'); ?>
										</div>
									</div>				
									<div class="col-lg-4">
										<div class="form-group <?php if(form_error('fechaejecutado')) echo 'has-error'; ?>">
											<label class="control-label" for="name"> Fecha ejecutado: </label>
											<input class="form-control" type="text" name="fechaejecutado" id="fechaejecutado" value="<?php echo set_value('fechaejecutado'); ?>" maxlength="20">
											<?php echo form_error('fechaejecutado','<div class="help-block" >','</div>'); ?>
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
	<script src="<?php echo base_url().'assets/js/movimientos/detfacturas/nuevo.js';?>"></script> 
	
	<?php echo $footer;?>
	<script>
		$('select[name=proyectos]').focus();
		$('#fechaejecutado').datepicker({'format':'yyyy-mm-dd'});
	</script>
