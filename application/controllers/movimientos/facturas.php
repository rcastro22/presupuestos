<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class facturas extends MY_Controller
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

	public function listado()
	{
		$this->view_data['page_title']=  'Facturas';
		$this->view_data['activo']=  'regfacturas';
		$this->load_partials();
		$this->load->view('movimientos/facturas/listado',$this->view_data);
	}
    
    public function nuevo()
    {
    	$method = $this->input->server('REQUEST_METHOD');
    	$this->view_data['page_title']=  'Nueva factura';
    	$this->view_data['activo']=  'regfacturas';
		$this->load_partials();
		switch ($method) 
		{
			case 'GET':
				$datosfactura = new stdClass();
				$this->view_data['datosfactura']=$datosfactura;

				$datosfactura->idfactura=$this->input->post('idfactura');
				$datosfactura->idproyecto=$this->input->post('proyectos');
				$datosfactura->idtipodocumento=$this->input->post('tiposdocumentos');
				$datosfactura->noserie=$this->input->post('noserie');
				$datosfactura->nofactura=$this->input->post('nofactura');
				$datosfactura->nit=$this->input->post('nit');
				$datosfactura->proveedor=$this->input->post('proveedor');
				$datosfactura->fecha=$this->input->post('fecha');
				$datosfactura->tipocambio=$this->input->post('tipocambio');
				$datosfactura->idempleado=$this->input->post('empleados');

				$this->load->view('movimientos/facturas/nuevo',$this->view_data);	
				break;
			case 'POST':  //aqui entra cuando le clic al boton
				//$this->form_validation->set_rules('noserie','Serie','required');
				$this->form_validation->set_rules('nofactura','Número de factura','required');
				//$this->form_validation->set_rules('nit','NIT','required');
				$this->form_validation->set_rules('proveedor','Nombre Proveedor','required');
				$this->form_validation->set_rules('fecha','Fecha','required');
				$this->form_validation->set_rules('tipocambio','Tipo de cambio','required');
				
				if($this->form_validation->run()==FALSE)
				{
					$datosfactura = new stdClass();	

					$datosfactura->idfactura=$this->input->post('idfactura');
					$datosfactura->idproyecto=$this->input->post('proyectos');
					$datosfactura->idtipodocumento=$this->input->post('tiposdocumentos');
					$datosfactura->noserie=$this->input->post('noserie');
					$datosfactura->nofactura=$this->input->post('nofactura');
					$datosfactura->nit=$this->input->post('nit');		
					$datosfactura->proveedor=$this->input->post('proveedor');			
					$datosfactura->fecha=$this->input->post('fecha');
					$datosfactura->tipocambio=$this->input->post('tipocambio');
					$datosfactura->idempleado=$this->input->post('empleados');

					$this->view_data['datosfactura']=$datosfactura;
					$this->load->view('movimientos/facturas/nuevo',$this->view_data);
				}
				else
				{
					$this->load->model('mfactura');
					$inserto=$this->mfactura->grabar(array(
						   'idproyecto'=>$this->input->post('proyectos'),
						   'idtipodocumento'=>$this->input->post('tiposdocumentos'),
						   'noserie'=>$this->input->post('noserie'),
						   'nofactura'=>$this->input->post('nofactura'),
						   'nit'=>$this->input->post('nit'),
						   'proveedor'=>$this->input->post('proveedor'),
						   'fecha'=>date('Y-m-d',strtotime($this->input->post('fecha'))),
						   'tipocambio'=>$this->input->post('tipocambio'),
						   'idempleado'=>$this->input->post('empleados'),						   
						   //Auditoria
						   'creadopor'=>$this->session->userdata('user_id'),
						   'fechacreado'=>date("Y-m-d H:i:s"),
						   'modificadopor'=>$this->session->userdata('user_id'),
						   'fechamodificado'=>date("Y-m-d H:i:s")
						   ),$err);
              		if($inserto)
					{
						redirect('movimientos/facturas/listado');
					}
					else
                    {
                    	$datosfactura = new stdClass();	
						
						$datosfactura->idfactura=$this->input->post('idfactura');
						$datosfactura->idproyecto=$this->input->post('proyectos');
						$datosfactura->idtipodocumento=$this->input->post('tiposdocumentos');
						$datosfactura->noserie=$this->input->post('noserie');
						$datosfactura->nofactura=$this->input->post('nofactura');
						$datosfactura->nit=$this->input->post('nit');		
						$datosfactura->proveedor=$this->input->post('proveedor');			
						$datosfactura->fecha=$this->input->post('fecha');
						$datosfactura->tipocambio=$this->input->post('tipocambio');
						$datosfactura->idempleado=$this->input->post('empleados');
						$this->view_data['datosfactura']=$datosfactura;

                    	$this->view_data['mensaje']="Error: No se pudo insertar el registro: ".$err;
                    	$this->view_data['tipoAlerta']="alert-danger";
                    	$this->load->view('movimientos/facturas/nuevo',$this->view_data);
                    }
				}
				break;
			default:
				die("Invalid Method");
				break;
		}
    }

	public function edit($idfactura=-1)
    {
    	$method = $this->input->server('REQUEST_METHOD');
    	$this->view_data['page_title']=  'Modificación de factura';
    	$this->view_data['activo']= 'regfacturas';
		$this->load_partials();
		switch ($method) 
		{
			case 'GET':
				$this->load->model('mfactura');
				$datosfactura = $this->mfactura->getFacturaId($idfactura);
        		$this->view_data['datosfactura']=$datosfactura;
				$this->load->view('movimientos/facturas/edit',$this->view_data);
				break;
			case 'POST':
				//$this->form_validation->set_rules('noserie','Serie','required');
				$this->form_validation->set_rules('nofactura','Número de factura','required');
				//$this->form_validation->set_rules('nit','NIT','required');
				$this->form_validation->set_rules('proveedor','Nombre Proveedor','required');
				$this->form_validation->set_rules('fecha','Fecha','required');
				$this->form_validation->set_rules('tipocambio','Tipo de cambio','required');
				if($this->form_validation->run()==FALSE)
				{
					$datosfactura = new stdClass();					
					$datosfactura->idfactura=$this->input->post('idfactura');
					$datosfactura->idproyecto=$this->input->post('proyectos');
					$datosfactura->idtipodocumento=$this->input->post('tiposdocumentos');
					$datosfactura->noserie=$this->input->post('noserie');
					$datosfactura->nofactura=$this->input->post('nofactura');
					$datosfactura->nit=$this->input->post('nit');				
					$datosfactura->proveedor=$this->input->post('proveedor');	
					$datosfactura->fecha=$this->input->post('fecha');
					$datosfactura->tipocambio=$this->input->post('tipocambio');
					$datosfactura->idempleado=$this->input->post('empleados');
					$this->view_data['datosfactura']=$datosfactura;
					$this->load->view('movimientos/facturas/edit',$this->view_data);
				}
				else
				{
					$this->load->model('mfactura');
					$err="";
					$siactualizo=$this->mfactura->modificar($this->input->post('idfactura'),
						    array(			
						       'idtipodocumento'=>$this->input->post('tiposdocumentos'),			   
							   'proveedor'=>$this->input->post('proveedor'),
							   'fecha'=>date('Y-m-d',strtotime($this->input->post('fecha'))),
							   'tipocambio'=>$this->input->post('tipocambio'),
							   'idempleado'=>$this->input->post('empleados'),
							   // Auditoria
							   'modificadopor'=>$this->session->userdata('user_id'),
							   'fechamodificado'=>date("Y-m-d H:i:s")
						        ),$err);
                    
                    $datosfactura = new stdClass();					
					$datosfactura->idfactura=$this->input->post('idfactura');
					$datosfactura->idproyecto=$this->input->post('proyectos');
					$datosfactura->idtipodocumento=$this->input->post('tiposdocumentos');
					$datosfactura->noserie=$this->input->post('noserie');
					$datosfactura->nofactura=$this->input->post('nofactura');
					$datosfactura->nit=$this->input->post('nit');				
					$datosfactura->proveedor=$this->input->post('proveedor');	
					$datosfactura->fecha=$this->input->post('fecha');
					$datosfactura->tipocambio=$this->input->post('tipocambio');
					$datosfactura->idempleado=$this->input->post('empleados');
					$this->view_data['datosfactura']=$datosfactura;
                    if ($siactualizo)
                    {
                    	redirect('movimientos/facturas/listado');
                    }
                    else
                    {
                    	$this->view_data['mensaje']="Error: No se pudo actualizar el registro ".$err;
                    	$this->view_data['tipoAlerta']="alert-danger";
                    	$this->load->view('movimientos/facturas/edit',$this->view_data);
                    }
				}
				break;
			default:
				die("Invalid Method");
				break;
		}
    }


	public function borrar($idfactura=-1)
 	{
 		$this->load->model('mfactura');
		$sielimino=$this->mfactura->borrar(array('idfactura'=>$idfactura),$err);
        

		if ($sielimino)
        {
        	redirect('movimientos/facturas/listado');
        }
        else
        {
        	$this->view_data['page_title']=  'Facturas';
    		$this->view_data['activo']= 'regfacturas';
			$this->load_partials();
        	$this->view_data['mensaje']="Error: No se pudo eliminar el registro: ".$err;
            $this->view_data['tipoAlerta']="alert-danger";
            $this->load->view('movimientos/facturas/listado',$this->view_data);
        }
	}
	
	//public function index($page=1)
	public function getFactura()
	{
		$this->load->model('mfactura');
		$factura = $this->mfactura->getFacturas();	
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($factura));
	}

	public function getFacturaId($idfactura=-1)
	{
		$this->load->model('mfactura');
		$factura = $this->mfactura->getFacturaId($idfactura);	
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($factura));
	}

	public function getFacturaPorProyecto($idproyecto=-1,$idplantilla=-1)
	{
		$this->load->model('mfactura');
		$factura = $this->mfactura->getFacturasPorProyecto($idproyecto,$idplantilla);	
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($factura));
	}
}