<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class empleado extends MY_Controller
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
		$this->view_data['page_title']=  'Empleados';
		$this->view_data['activo']=  'empleado';
		$this->load_partials();
		$this->load->view('catalogos/empleado/listado',$this->view_data);
	}
    
    public function nuevo()
    {
    	$method = $this->input->server('REQUEST_METHOD');
    	$this->view_data['page_title']=  'Creación de Empleado';
    	$this->view_data['activo']=  'empleado';
		$this->load_partials();
		switch ($method) 
		{
			case 'GET':
				$this->load->view('catalogos/empleado/nuevo',$this->view_data);	
				break;
			case 'POST':  //aqui entra cuando le clic al boton
				$this->form_validation->set_rules('nombre','Nombre','required');
				$this->form_validation->set_rules('apellido','Apellido','required');
				$this->form_validation->set_rules('direccion','Direccion','required');
				$this->form_validation->set_rules('telefono','Telefono','required|numeric|min_length[8]|max_length[8]');
				if($this->form_validation->run()==FALSE)
				{
					$this->load->view('catalogos/empleado/nuevo',$this->view_data);
				}
				else
				{
					$this->load->model('mempleado');
					$inserto=$this->mempleado->grabar(array(
						   'nombre'=>$this->input->post('nombre'),
						   'apellido'=>$this->input->post('apellido'),
						   'direccion'=>$this->input->post('direccion'),
						   'telefono'=>$this->input->post('telefono'),
						   'CreadoPor'=>$this->session->userdata('user_id'),
						   'FechaCreado'=>date("Y-m-d H:i:s"),
						   'ModificadoPor'=>$this->session->userdata('user_id'),
						   'FechaModificado'=>date("Y-m-d H:i:s")
						   ),$err);
              		if($inserto)
					{
						redirect('catalogos/empleado/listado');
					}
					else
                    {
                    	$this->view_data['mensaje']="Error: No se pudo insertar el registro: ".$err;
                    	$this->view_data['tipoAlerta']="alert-danger";
                    	$this->load->view('catalogos/empleado/nuevo',$this->view_data);
                    }
				}
				break;
			default:
				die("Invalid Method");
				break;
		}
    }

	public function edit($idempleado=-1)
    {
    	$method = $this->input->server('REQUEST_METHOD');
    	$this->view_data['page_title']=  'Modificación de Empleados';
    	$this->view_data['activo']= 'empleado';
		$this->load_partials();
		switch ($method) 
		{
			case 'GET':
				$this->load->model('mempleado');
				$datosempleado = $this->mempleado->getEmpleadoId($idempleado);
        		$this->view_data['datosempleado']=$datosempleado;
				$this->load->view('catalogos/empleado/edit',$this->view_data);
				break;
			case 'POST':
				$this->form_validation->set_rules('nombre','nombre','required');
				$this->form_validation->set_rules('apellido','apellido','required');
				$this->form_validation->set_rules('direccion','direccion','required');
				$this->form_validation->set_rules('telefono','telefono','required|numeric|min_length[8]|max_length[8]');
				if($this->form_validation->run()==FALSE)
				{
					$datosempleado = new stdClass();
					$datosempleado->idempleado=$this->input->post('idempleado');
					$datosempleado->nombre=$this->input->post('nombre');
					$datosempleado->apellido=$this->input->post('apellido');
					$datosempleado->direccion=$this->input->post('direccion');
					$datosempleado->telefono=$this->input->post('telefono');
					$this->view_data['datosempleado']=$datosempleado;
					$this->load->view('catalogos/empleado/edit',$this->view_data);
				}
				else
				{
					$this->load->model('mempleado');
					$err="";
					$siactualizo=$this->mempleado->modificar($this->input->post('idempleado'),
						    array(
							   'nombre'=>$this->input->post('nombre'),
							   'apellido'=>$this->input->post('apellido'),
							   'direccion'=>$this->input->post('direccion'),
							   'telefono'=>$this->input->post('telefono'),
							   'ModificadoPor'=>$this->session->userdata('user_id'),
							   'FechaModificado'=>date("Y-m-d H:i:s")
						        ),$err);
                    
                    $datosempleado = new stdClass();
					$datosempleado->idempleado=$this->input->post('idempleado');
					$datosempleado->nombre=$this->input->post('nombre');
					$datosempleado->apellido=$this->input->post('apellido');
					$datosempleado->direccion=$this->input->post('direccion');
					$datosempleado->telefono=$this->input->post('telefono');
					$this->view_data['datosempleado']=$datosempleado;
                    if ($siactualizo)
                    {
                    	redirect('catalogos/empleado/listado');
                    }
                    else
                    {
                    	$this->view_data['mensaje']="Error: No se pudo actualizar el registro ".$err;
                    	$this->view_data['tipoAlerta']="alert-danger";
                    	$this->load->view('catalogos/empleado/edit',$this->view_data);
                    }
				}
				break;
			default:
				die("Invalid Method");
				break;
		}
    }


	public function borrar($idempleado=-1)
 	{
 		$this->load->model('mempleado');
		$sielimino=$this->mempleado->borrar(array('idempleado'=>$idempleado),$err);
        

		if ($sielimino)
        {
        	redirect('catalogos/empleado/listado');
        }
        else
        {
        	$this->view_data['page_title']=  'Empleados';
    		$this->view_data['activo']= 'empleado';
			$this->load_partials();
        	$this->view_data['mensaje']="Error: No se pudo eliminar el registro: ".$err;
            $this->view_data['tipoAlerta']="alert-danger";
            $this->load->view('catalogos/empleado/listado',$this->view_data);
        }
	}
	
	//public function index($page=1)
	public function getEmpleado()
	{
		$this->load->model('mempleado');
		$empleado = $this->mempleado->getEmpleados();	
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($empleado));
	}

	
}