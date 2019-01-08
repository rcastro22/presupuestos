<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class plantilla extends MY_Controller
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
		$this->view_data['page_title']=  'Plantilla General';
		$this->view_data['activo']=  'plantilla';
		$this->load_partials();
		$this->load->view('catalogos/plantilla/listado',$this->view_data);
	}
    
    public function nuevo()
    {
    	$method = $this->input->server('REQUEST_METHOD');
    	$this->view_data['page_title']=  'Creación de Cuenta';
    	$this->view_data['activo']=  'plantilla';
		$this->load_partials();
		switch ($method) 
		{
			case 'GET':
				$this->load->view('catalogos/plantilla/nuevo',$this->view_data);	
				break;
			case 'POST':  //aqui entra cuando le clic al boton
				$this->form_validation->set_rules('principal','Principal','required|numeric');
				$this->form_validation->set_rules('secundaria','Secundaria','required|numeric');
				$this->form_validation->set_rules('descriptiva','Descriptiva','required|numeric');
				$this->form_validation->set_rules('nombre','Nombre','required');
				if($this->form_validation->run()==FALSE)
				{
					$this->load->view('catalogos/plantilla/nuevo',$this->view_data);
				}
				else
				{
					$this->load->model('mplantilla');
					$inserto=$this->mplantilla->grabar(array(
						   'principal'=>$this->input->post('principal'),
						   'secundaria'=>$this->input->post('secundaria'),
						   'descriptiva'=>$this->input->post('descriptiva'),
						   'nombre'=>$this->input->post('nombre'),
						   'CreadoPor'=>$this->session->userdata('user_id'),
						   'FechaCreado'=>date("Y-m-d H:i:s"),
						   'ModificadoPor'=>$this->session->userdata('user_id'),
						   'FechaModificado'=>date("Y-m-d H:i:s")
						   ),$err);
              		if($inserto)
					{
						redirect('catalogos/plantilla/nuevo');
					}
					else
                    {
                    	$this->view_data['mensaje']="Error: No se pudo insertar el registro: ".$err;
                    	$this->view_data['tipoAlerta']="alert-danger";
                    	$this->load->view('catalogos/plantilla/nuevo',$this->view_data);
                    }
				}
				break;
			default:
				die("Invalid Method");
				break;
		}
    }

	public function edit($principal=-1,$secundaria=-1,$descriptiva=-1)
    {
    	$method = $this->input->server('REQUEST_METHOD');
    	$this->view_data['page_title']=  'Modificación de Cuenta';
    	$this->view_data['activo']= 'plantilla';
		$this->load_partials();
		switch ($method) 
		{
			case 'GET':
				$this->load->model('mplantilla');
				$datosplantilla = $this->mplantilla->getPlantillaId($principal,$secundaria,$descriptiva);
        		$this->view_data['datosplantilla']=$datosplantilla;
				$this->load->view('catalogos/plantilla/edit',$this->view_data);
				break;
			case 'POST':
				$this->form_validation->set_rules('principal','principal','required|numeric');
				$this->form_validation->set_rules('secundaria','secundaria','required|numeric');
				$this->form_validation->set_rules('descriptiva','descriptiva','required|numeric');
				$this->form_validation->set_rules('nombre','nombre','required');
				if($this->form_validation->run()==FALSE)
				{
					$datosplantilla = new stdClass();
					
					$datosplantilla->principal=$this->input->post('principal');
					$datosplantilla->secundaria=$this->input->post('secundaria');
					$datosplantilla->descriptiva=$this->input->post('descriptiva');
					$datosplantilla->nombre=$this->input->post('nombre');
					$this->view_data['datosplantilla']=$datosplantilla;
					$this->load->view('catalogos/plantilla/edit',$this->view_data);
				}
				else
				{
					$this->load->model('mplantilla');
					$err="";
					$siactualizo=$this->mplantilla->modificar($this->input->post('principal'),
						                                      $this->input->post('secundaria'),
						                                      $this->input->post('descriptiva'),
						    array(
							   'nombre'=>$this->input->post('nombre'),
							   'ModificadoPor'=>$this->session->userdata('user_id'),
							   'FechaModificado'=>date("Y-m-d H:i:s")
						        ),$err);
                    
                    $datosplantilla = new stdClass();
					$datosplantilla->principal=$this->input->post('principal');
					$datosplantilla->secundaria=$this->input->post('secundaria');
					$datosplantilla->descriptiva=$this->input->post('descriptiva');
					$datosplantilla->nombre=$this->input->post('nombre');
					$this->view_data['datosplantilla']=$datosplantilla;
                    if ($siactualizo)
                    {
                    	redirect('catalogos/plantilla/listado');
                    }
                    else
                    {
                    	$this->view_data['mensaje']="Error: No se pudo actualizar el registro ".$err;
                    	$this->view_data['tipoAlerta']="alert-danger";
                    	$this->load->view('catalogos/plantilla/edit',$this->view_data);
                    }
				}
				break;
			default:
				die("Invalid Method");
				break;
		}
    }


	public function borrar($principal=-1,$secundaria=-1,$descriptiva=-1)
 	{
 		$this->load->model('mplantilla');
		$sielimino=$this->mplantilla->borrar(array('principal'=>$principal,
			                                       'secundaria'=>$secundaria,
			                                       'descriptiva'=>$descriptiva),
		                                     $err);

		if ($sielimino)
        {
        	redirect('catalogos/plantilla/listado');
        }
        else
        {
        	$this->view_data['page_title']=  'Plantilla General';
    		$this->view_data['activo']= 'plantilla';
			$this->load_partials();
        	$this->view_data['mensaje']="Error: No se pudo eliminar el registro: ".$err;
            $this->view_data['tipoAlerta']="alert-danger";
            $this->load->view('catalogos/plantilla/listado',$this->view_data);
        }
	}
	
	//public function index($page=1)
	public function getPlantillas()
	{
		$this->load->model('mplantilla');
		$plantilla = $this->mplantilla->getPlantillas();	
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($plantilla));
	}
}