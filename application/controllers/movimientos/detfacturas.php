<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class detfacturas extends MY_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		if(!$this->session->userdata('logged_in'))
		{
			redirect('sesion');
		}
		else
		{
			$this->view_data['usuario']= $this->session->userdata('user_id');
		}

	}

	public function listado($idfactura=-1)
	{
		$this->load->model('mdetfactura');
    	$datosdetfactura = $this->mdetfactura->getTotalFactura($idfactura);
    	$monto = $datosdetfactura->monto;

		$this->view_data['page_title']=  'Detalle de factura';
		$this->view_data['activo']=  'regfacturas';
		$this->view_data['idfactura']= $idfactura;
		$this->view_data['montototal']= $monto;
		$this->load_partials();
		$this->load->view('movimientos/detfacturas/listado',$this->view_data);
	}
    
    public function nuevo($idfactura=-1)
    {
    	$method = $this->input->server('REQUEST_METHOD');
    	$this->view_data['page_title']=  'Nueva linea';
    	$this->view_data['activo']=  'regfacturas';
    	$this->view_data['idfactura']= $idfactura;
		$this->load_partials();
		switch ($method) 
		{
			case 'GET':
				$datosdetfactura = new stdClass();
				$this->view_data['datosdetfactura']=$datosdetfactura;

				$datosdetfactura->idfactura=$this->input->post('hfactura');
				$datosdetfactura->iddetalle=$this->input->post('iddetalle');
				$datosdetfactura->idplantillaproyecto=$this->input->post('idplantillaproyecto');
				$datosdetfactura->descripcion=$this->input->post('descripcion');
				$datosdetfactura->monto=$this->input->post('monto');		
				$datosdetfactura->fechaejecutado=$this->input->post('fechaejecutado');		

				$this->load->view('movimientos/detfacturas/nuevo',$this->view_data);	
				break;
			case 'POST':  //aqui entra cuando le clic al boton
				//$this->form_validation->set_rules('idplantillaproyecto','Plantilla','required');
				$this->form_validation->set_rules('descripcion','Descripción','required');
				$this->form_validation->set_rules('monto','Monto','required');
				$this->form_validation->set_rules('fechaejecutado','Fecha ejecutado','required');
				
				if($this->form_validation->run()==FALSE)
				{
					$datosdetfactura = new stdClass();	

					$datosdetfactura->idfactura=$this->input->post('hfactura');
					$datosdetfactura->iddetalle=$this->input->post('iddetalle');
					$datosdetfactura->idplantillaproyecto=$this->input->post('plantillas');
					$datosdetfactura->descripcion=$this->input->post('descripcion');
					$datosdetfactura->monto=$this->input->post('monto');
					$datosdetfactura->fechaejecutado=$this->input->post('fechaejecutado');

					$this->view_data['datosdetfactura']=$datosdetfactura;
					$this->view_data['idfactura']= $idfactura;
					$this->load->view('movimientos/detfacturas/nuevo',$this->view_data);
				}
				else
				{
					$this->load->model('mdetfactura');
					$inserto=$this->mdetfactura->grabar(array(
						   'idfactura'=>$idfactura,
						   'idplantillaproyecto'=>$this->input->post('plantillas'),
						   'descripcion'=>$this->input->post('descripcion'),
						   'monto'=>$this->input->post('monto'),
						   'fechaejecutado'=>date('Y-m-d',strtotime($this->input->post('fechaejecutado'))),						  						  
						   //Auditoria
						   'creadopor'=>$this->session->userdata('user_id'),
						   'fechacreado'=>date("Y-m-d H:i:s"),
						   'modificadopor'=>$this->session->userdata('user_id'),
						   'fechamodificado'=>date("Y-m-d H:i:s")
						   ),$err);
              		if($inserto)
					{
						redirect('movimientos/detfacturas/listado/'.$idfactura);
					}
					else
                    {
                    	$datosdetfactura = new stdClass();	
						
						$datosdetfactura->idfactura=$this->input->post('hfactura');
						$datosdetfactura->iddetalle=$this->input->post('iddetalle');
						$datosdetfactura->idplantillaproyecto=$this->input->post('plantillas');
						$datosdetfactura->descripcion=$this->input->post('descripcion');
						$datosdetfactura->monto=$this->input->post('monto');
						$datosdetfactura->fechaejecutado=$this->input->post('fechaejecutado');

                    	$this->view_data['mensaje']="Error: No se pudo insertar el registro: ".$err;
                    	$this->view_data['tipoAlerta']="alert-danger";
                    	$this->view_data['idfactura']= $idfactura;
                    	$this->load->view('movimientos/detfacturas/nuevo',$this->view_data);
                    }
				}
				break;
			default:
				die("Invalid Method");
				break;
		}
    }

	public function edit($idlinea=-1)
    {
    	$this->load->model('mdetfactura');
    	$datosdetfactura = $this->mdetfactura->getDetFacturaId($idlinea);

    	//Tuve problemas porque el $idlinea venia con un dato incorrecto, y getDetFacturaId devolvia vacio
    	
    	$idfactura = $datosdetfactura->idfactura;
    	
    	$method = $this->input->server('REQUEST_METHOD');
    	$this->view_data['page_title']=  'Modificación de detalle';
    	$this->view_data['activo']= 'detfacturas';
    	$this->view_data['idfactura']= $idfactura;
    	$this->view_data['idlinea']= $idlinea;
		$this->load_partials();
		switch ($method) 
		{
			case 'GET':
				$this->load->model('mdetfactura');
				$datosdetfactura = $this->mdetfactura->getDetFacturaId($idlinea);
        		$this->view_data['datosdetfactura']=$datosdetfactura;
				$this->load->view('movimientos/detfacturas/edit',$this->view_data);
				break;
			case 'POST':				
				$this->form_validation->set_rules('descripcion','Descripción','required');
				$this->form_validation->set_rules('monto','Monto','required');
				$this->form_validation->set_rules('fechaejecutado','Fecha ejecutado','required');
				if($this->form_validation->run()==FALSE)
				{
					$datosdetfactura = new stdClass();					
					$datosdetfactura->idfactura=$this->input->post('hfactura');
					$datosdetfactura->iddetalle=$this->input->post('iddetalle');
					$datosdetfactura->idplantillaproyecto=$this->input->post('plantillas');
					$datosdetfactura->descripcion=$this->input->post('descripcion');
					$datosdetfactura->monto=$this->input->post('monto');
					$datosdetfactura->fechaejecutado=$this->input->post('fechaejecutado');
					$this->view_data['datosdetfactura']=$datosdetfactura;
					$this->load->view('movimientos/detfacturas/edit',$this->view_data);
				}
				else
				{
					$this->load->model('mdetfactura');
					$err="";
					$siactualizo=$this->mdetfactura->modificar($this->input->post('iddetalle'),
						    array(							   
							   
							   'idplantillaproyecto'=>$this->input->post('plantillas'),
							   'descripcion'=>$this->input->post('descripcion'),
							   'monto'=>$this->input->post('monto'),
							   'fechaejecutado'=>date('Y-m-d',strtotime($this->input->post('fechaejecutado'))),
							   // Auditoria
							   'modificadopor'=>$this->session->userdata('user_id'),
							   'fechamodificado'=>date("Y-m-d H:i:s")
						        ),$err);
                    
                    $datosdetfactura = new stdClass();					
					$datosdetfactura->idfactura=$this->input->post('hfactura');
					$datosdetfactura->iddetalle=$this->input->post('iddetalle');
					$datosdetfactura->idplantillaproyecto=$this->input->post('plantillas');
					$datosdetfactura->descripcion=$this->input->post('descripcion');
					$datosdetfactura->monto=$this->input->post('monto');
					$datosdetfactura->fechaejecutado=$this->input->post('fechaejecutado');
					$this->view_data['datosdetfactura']=$datosdetfactura;
                    if ($siactualizo)
                    {
                    	redirect('movimientos/detfacturas/listado/'.$idfactura);
                    }
                    else
                    {
                    	$this->view_data['mensaje']="Error: No se pudo actualizar el registro ".$err;
                    	$this->view_data['tipoAlerta']="alert-danger";
                    	$this->load->view('movimientos/detfacturas/edit',$this->view_data);
                    }
				}
				break;
			default:
				die("Invalid Method");
				break;
		}
    }


	public function borrar($idlinea=-1)
 	{
 		$this->load->model('mdetfactura');
    	$datosdetfactura = $this->mdetfactura->getDetFacturaId($idlinea);
    	$idfactura = $datosdetfactura->idfactura;

 		$this->load->model('mdetfactura');
		$sielimino=$this->mdetfactura->borrar(array('iddetalle'=>$idlinea),$err);
        

		if ($sielimino)
        {
        	redirect('movimientos/detfacturas/listado/'.$idfactura);
        }
        else
        {
        	$this->view_data['page_title']=  'Facturas';
    		$this->view_data['activo']= 'regfacturas';
			$this->load_partials();
        	$this->view_data['mensaje']="Error: No se pudo eliminar el registro: ".$err;
            $this->view_data['tipoAlerta']="alert-danger";
            $this->load->view('movimientos/detfacturas/listado/'.$idfactura,$this->view_data);
        }
	}
	
	//public function index($page=1)
	public function getDetFactura($idfactura=-1)
	{
		$this->load->model('mdetfactura');
		$factura = $this->mdetfactura->getDetFacturas($idfactura);	
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($factura));
	}

	public function getFacturaPorProyecto($idproyecto=-1)
	{
		$this->load->model('mfactura');
		$factura = $this->mfactura->getFacturasPorProyecto($idproyecto);	
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($factura));
	}
}