<?php echo $headerrep;?>
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
		<div class="col-lg-10 col-lg-offset-1">
			<div class="panel panel-default">
		  		<div class="panel-heading"> 
	  				<div style="text-align:center;">
	  					<?php echo $page_title;?> del Proyecto: 
	  				</div>
	  				<div>
	  					 <select class="form-control"   name="proyectos" id="proyectos"></select>
	  				</div>
	  				<div>		
						<select class="form-control" name="plantillas" id="plantillas"></select>																		
					</div>
	  				<br/>
	  				<div style="text-align:center;">
	  					 <button id="btnConsultar" class="btn btn-sm btn-negro">Consultar</button>
	  				</div>
		  		</div>
	  			<div class="panel-body" style="overflow-x: auto">
					<div class="form-search pull-right input-group" data-tabla="gvBuscar" style="display:none;">
						<span class="input-group-addon">Buscar</span>
                		<input type="text" class="search-query form-control" placeholder="Ingrese su búsqueda" />
        			</div>	
        			<div style="text-align:center;">
        				<button type="button" id="btnExport" name="btnExport" class="btn btn-primary">Exportar Excel</button>
	        			</div>
	        			    <div id="divexp" name="divexp">
								<table class="table table-striped table-bordered table-hover tabla" data-orden="true" data-filtro="true" data-fuente="dtLlenar" id="gvBuscar">
									<thead>
										<tr>
				              				
				              				<th data-tipo="string" data-campo="principal" data-alineacion="izquierda" style="text-align:center">PRINCIPAL</th>
				              				<th data-tipo="string" data-campo="secundaria" data-alineacion="izquierda" style="text-align:center">SECUNDARIA</th>
				              				<th data-tipo="string" data-campo="descriptiva" data-alineacion="izquierda" style="text-align:center">DESCRIPTIVA</th>
				              				<th data-tipo="string" data-campo="tipodocumento" data-alineacion="izquierda" style="text-align:center">TIPO</th>
				              				<th data-tipo="string" data-campo="noserie" data-alineacion="izquierda" style="text-align:center">SERIE</th>
				              				<th data-tipo="string" data-campo="nofactura" data-alineacion="izquierda" style="text-align:center">DOCUMENTO</th>
				              				<th data-tipo="datetime" data-formato="dd/MM/yyyy" data-campo="fechafactura" data-alineacion="izquierda" style="text-align:center">FECHA DOC</th>
				              				<th data-tipo="string" data-campo="proveedor" data-alineacion="izquierda" style="text-align:center">PROVEEDOR</th>
				              				<th data-tipo="decimal"  data-campo="monto" data-alineacion="derecha" style="text-align:right" data-formato="#,##0.00">MONTO</th>
				              				<th data-tipo="datetime" data-formato="dd/MM/yyyy" data-campo="fechaejecutado" data-alineacion="izquierda" style="text-align:center">FECHA EJECUTADO</th>
				         				</tr>
				 					</thead>
			    					<tbody>
			    					</tbody>
								</table>


								
							</div>
						</div>

   					
						<div style="text-align:center">
							<div class="pagination">
								<ul class="pagination pagination-centered" data-tabla="gvBuscar" data-cantidad="10000" data-grupo="8"></ul>
							</div>
						</div>
					</div>
				</div>
			</div>
			<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" >
		</div>
	</div>
</div>

<script src="<?php echo base_url().'assets/js/tabla.js';?>"></script> 
<script src="<?php echo base_url().'assets/js/reportes/detalleejecutado/detalleejecutado.js';?>"></script> 

<?php echo $footer;?>