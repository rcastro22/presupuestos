<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


//aqui quite que extendiera de CI_Controller y ahora
//le pongo de mi controlador MY_Controller
class proyecto extends MY_Controller
{

   
	function __construct()
	{
		parent::__construct();
		//esto tambien si se gusta se puede agregar en el autoload y ya no seria necesario aqui
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

    //el offset lo agregue cuando hice la paginacion
    //luego quite el $page=1 cuando hice el ordenamiento
	//public function index($page=1)
	public function listado()
	{
		$this->view_data['page_title']=  'Listado de Proyectos';
		$this->view_data['activo']=  'proyectos';
		$this->load_partials();
		$this->load->view('catalogos/proyectos/listado',$this->view_data);
	}
    
    public function nuevo()
    {
    	$method = $this->input->server('REQUEST_METHOD');
    	$this->view_data['page_title']=  'Creación de Proyectos';
    	$this->view_data['activo']=  'proyectos';
		$this->load_partials();
		

		switch ($method) 
		{
			case 'GET':
				$this->load->view('catalogos/proyectos/nuevo',$this->view_data);	

				break;
			case 'POST':  //aqui entra cuando le clic al boton
				//pongo mis reglas de validación.
				$this->form_validation->set_rules('nombre','nombre','required');
				
	
				if($this->form_validation->run()==FALSE)
				{
					$this->load->view('catalogos/proyectos/nuevo',$this->view_data);

				}
				else
				{

					
					$this->load->model('MProyecto');
					
					$inserto=$this->MProyecto->grabar(array(
						   'nombre'=>$this->input->post('nombre'),
						   'CreadoPor'=>$this->session->userdata('user_id'),
						   'FechaCreado'=>date("Y-m-d H:i:s"),
						   'ModificadoPor'=>$this->session->userdata('user_id'),
						   'FechaModificado'=>date("Y-m-d H:i:s")
						   ),$err);
                    
					if($inserto)
					{
						redirect('catalogos/proyecto/listado');
					}
					else
                    {
                    	$this->view_data['mensaje']="Error: No se pudo insertar el registro: ".$err;
                    	$this->view_data['tipoAlerta']="alert-danger";
                    	$this->load->view('catalogos/proyecto/nuevo',$this->view_data);
                    }

					



				}
				break;
			default:
				die("Invalid Method");
				break;
		}
    }

	public function edit($idproyecto=-1)
    {
    	$method = $this->input->server('REQUEST_METHOD');
    	$this->view_data['page_title']=  'Modificación de Proyectos';
    	$this->view_data['activo']= 'proyectos';
		$this->load_partials();
		

		switch ($method) 
		{
			case 'GET':

				$this->load->model('MProyecto');
				$datosproyecto = $this->MProyecto->getProyecto($idproyecto);
        		$this->view_data['datosproyecto']=$datosproyecto;
				$this->load->view('catalogos/proyectos/edit',$this->view_data);
				break;
			case 'POST':  //aqui entra cuando le clic al boton
				//pongo mis reglas de validación.
			    //$bancoid=$this->input->post('BancoId');
			    $bancoid=$this->input->post('idproyecto');
			    //$this->form_validation->set_rules('BancoId','Código','required');
				$this->form_validation->set_rules('nombre','nombre','required');
				
	

				if($this->form_validation->run()==FALSE)
				{

					$datosproyecto = new stdClass();
					$datosproyecto->idproyecto = $this->input->post('idproyecto');
					$datosproyecto->nombre= $this->input->post('nombre');
					
				
					$this->view_data['datosproyecto']=$datosproyecto;
					$this->load->view('catalogos/proyectos/edit',$this->view_data);
					//$this->load->view('catalogos/bancos/nuevo',$this->view_data);
				}
				else
				{
					
					//cargo primero el modelo para poder tener acceso al metodo save.
					$this->load->model('MProyecto');
					$err="";
					$siactualizo=$this->MProyecto->modificar($this->input->post('idproyecto'),array(
						   'nombre'=>$this->input->post('nombre'),
						   'ModificadoPor'=>$this->session->userdata('user_id'),
						   'FechaModificado'=>date("Y-m-d H:i:s")
						   ),$err);
                    
                    $datosproyecto = new stdClass();
					$datosproyecto->idproyecto = $this->input->post('idproyecto');
					$datosproyecto->nombre= $this->input->post('nombre');
					
					$this->view_data['datosproyecto']=$datosproyecto;

                    if ($siactualizo)
                    {
                    	//$this->view_data['mensaje']="Registro actualizado !!!";
                    	//$this->view_data['tipoAlerta']="alert-success";
                    	redirect('catalogos/proyecto/listado');
                    }
                    else
                    {
                    	$this->view_data['mensaje']="Error: No se pudo actualizar el registro: ".$err;
                    	$this->view_data['tipoAlerta']="alert-danger";
                    	$this->load->view('catalogos/proyectos/edit',$this->view_data);
                    }
                    //carga la vista.
                    
				}
				break;
			default:
				die("Invalid Method");
				break;
		}
    }


	public function borrar($proyectoEliminar=-1)
 	{
 		$this->load->model('MProyecto');
		$sielimino=$this->MProyecto->borrar(array('idproyecto'=>$proyectoEliminar),$err);
                    
        if ($sielimino)
        {
        	redirect('catalogos/proyecto/listado');
        }
        else
        {
        	$this->view_data['page_title']=  'Listado de Proyectos';
		$this->view_data['activo']=  'proyectos';
		$this->load_partials();
        	
        	$this->view_data['mensaje']="Error: No se pudo eliminar el registro: ".$err;
            $this->view_data['tipoAlerta']="alert-danger";
            $this->load->view('catalogos/proyectos/listado',$this->view_data);
        }
			

	}
	//public function index($page=1)
	public function getProyectos()
	{
		//echo "hola controlador";
		//exit;
		//cargo el modelo de projects
		$this->load->model('MProyecto');
		//agrege los campos de orden y direccion
		$proyectos = $this->MProyecto->getProyectos();
		//print_r($bancos);
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($proyectos));
	}

	public function getProyectosPorCliente($idcliente=-1)
	{
		$this->load->model('MProyecto');
		$proyectos = $this->MProyecto->getProyectosPorCliente($idcliente);
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($proyectos));
	}

	//public function index($page=1)
	public function getProyecto($idproyecto=-1)
	{
		//cargo el modelo de projects
		$this->load->model('MProyecto');
		//agrege los campos de orden y direccion
		$proyecto = $this->MProyecto->getProyecto($idproyecto);
		//print_r($bancos);
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($proyecto));
	}



}