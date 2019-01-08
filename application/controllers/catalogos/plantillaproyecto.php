<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class plantillaproyecto extends MY_Controller
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

	public function listado($idproyecto=-1,$pagina=-1)
	{
		
		$this->view_data['page_title']=  'Plantilla';
		$this->view_data['activo']=  'plantillaproyecto';
		$this->view_data['hproyecto']=  $idproyecto;
		$this->view_data['pagina']=  $pagina;		
		$this->load_partials();
		$this->load->view('catalogos/plantillaproyecto/listado',$this->view_data);
	}
    
    public function nuevo()
    {
    	$method = $this->input->server('REQUEST_METHOD');
    	$this->view_data['page_title']=  'Creación de Plantillas por Proyecto';
    	$this->view_data['activo']=  'plantillaproyecto';
		$this->load_partials();
		switch ($method) 
		{
			case 'GET':
			    //echo $this->input->get('nomproyectoenviar');
			    //exit;
			    $this->view_data['idproyecto']=$this->input->get('idproyectoenviar');
			    $this->view_data['nomproyecto']=$this->input->get('nomproyectoenviar');
     			$this->load->view('catalogos/plantillaproyecto/nuevo',$this->view_data);	
				break;
			case 'POST':  //aqui entra cuando le clic al boton
			    $this->form_validation->set_rules('idproyecto','idProyecto','required');
			    $this->form_validation->set_rules('nomproyecto','Proyecto','required');
				$this->form_validation->set_rules('principal','Principal','required|numeric');
				$this->form_validation->set_rules('secundaria','Secundaria','required|numeric');
				$this->form_validation->set_rules('descriptiva','Descriptiva','required|numeric');
				$this->form_validation->set_rules('nombre','Nombre','required');
				$this->form_validation->set_rules('presupuestado','Presupuestado','required|numeric');
				if($this->form_validation->run()==FALSE)
				{
					$this->load->view('catalogos/plantillaproyecto/nuevo',$this->view_data);
				}
				else
				{
					$this->load->model('mplantillaproyecto');
					$inserto=$this->mplantillaproyecto->grabar(array(
						   'idProyecto'=>$this->input->post('idproyecto'),
						   //'idProyecto'=>1,
						   'principal'=>$this->input->post('principal'),
						   'secundaria'=>$this->input->post('secundaria'),
						   'descriptiva'=>$this->input->post('descriptiva'),
						   'nombre'=>$this->input->post('nombre'),
						   'presupuestado'=>$this->input->post('presupuestado'),
						   'esgeneral'=>0,
						   //Auditoria
						   'creadopor'=>$this->session->userdata('user_id'),
						   'fechacreado'=>date("Y-m-d H:i:s"),
						   'modificadoPor'=>$this->session->userdata('user_id'),
						   'fechamodificado'=>date("Y-m-d H:i:s")
						   ),$err);
              		if($inserto)
					{
						redirect('catalogos/plantillaproyecto/listado');
					}
					else
                    {
	                    	$this->view_data['mensaje']="Error: No se pudo insertar el registro: ".$err;
	                    	$this->view_data['tipoAlerta']="alert-danger";
	                    	$this->load->view('catalogos/plantillaproyecto/nuevo',$this->view_data);
                    }
				}
				break;
			default:
				die("Invalid Method");
				break;
		}
    }

	public function edit($idplantillaproyecto=-1,$pagina=1)
    {
    	$method = $this->input->server('REQUEST_METHOD');
    	$this->view_data['page_title']=  'Modificación de Plantilla';
    	$this->view_data['activo']= 'plantillaproyecto';
		$this->load_partials();
		switch ($method) 
		{
			case 'GET':
				$this->load->model('mplantillaproyecto');
				$datosplantillaproyecto = $this->mplantillaproyecto->getPlantillaProyectoId($idplantillaproyecto);

        		$this->view_data['datosplantillaproyecto']=$datosplantillaproyecto;
        		$this->view_data['pagina']=$pagina;
        		//print_r($this->view_data['datosplantillaproyecto']);
        		//exit;
				$this->load->view('catalogos/plantillaproyecto/edit',$this->view_data);
				break;
			case 'POST':
				$this->form_validation->set_rules('principal','principal','required|numeric');
				$this->form_validation->set_rules('secundaria','secundaria','required|numeric');
				$this->form_validation->set_rules('descriptiva','descriptiva','required|numeric');
				$this->form_validation->set_rules('nombre','nombre','required');
				$this->form_validation->set_rules('presupuestado','descriptiva','numeric');
				if($this->form_validation->run()==FALSE)
				{
					$datosplantilla = new stdClass();
					$datosplantilla->idplantillaproyecto=$this->input->post('idplantillaproyecto');
					$datosplantilla->principal=$this->input->post('principal');
					$datosplantilla->secundaria=$this->input->post('secundaria');
					$datosplantilla->descriptiva=$this->input->post('descriptiva');
					$datosplantilla->nombre=$this->input->post('nombre');
					$this->view_data['datosplantilla']=$datosplantilla;
					$this->load->view('catalogos/plantilla/edit',$this->view_data);
				}
				else
				{
					$this->load->model('mplantillaproyecto');
					$err="";
					$siactualizo=$this->mplantillaproyecto->modificar($this->input->post('idplantillaproyecto'),
						       $this->input->post('idproyecto'), array('principal'=>$this->input->post('principal'),
						       'secundaria'=>$this->input->post('secundaria'),
						       'descriptiva'=>$this->input->post('descriptiva'),
							   'nombre'=>$this->input->post('nombre'),
							   'presupuestado'=>$this->input->post('presupuestado'),
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
                    	redirect('catalogos/plantillaproyecto/listado/'.$this->input->post('idproyecto').'/'.$this->input->post('pagina'));
                    }
                    else
                    {
                    	$this->view_data['mensaje']="Error: No se pudo actualizar el registro ".$err;
                    	$this->view_data['tipoAlerta']="alert-danger";
                    	$this->load->view('catalogos/plantillaproyecto/edit',$this->view_data);
                    }
				}
				break;
			default:
				die("Invalid Method");
				break;
		}
    }


	public function borrar($idplantillaproyecto=-1)
 	{
 		$this->load->model('mplantillaproyecto');
		$sielimino=$this->mplantillaproyecto->borrar(array('idplantillaproyecto'=>$idplantillaproyecto),$err);
        
		if ($sielimino)
        {
        	redirect('catalogos/plantillaproyecto/listado');
        }
        else
        {
        	$this->view_data['page_title']=  'Plantillas';
    		$this->view_data['activo']= 'plantillaproyecto';
			$this->load_partials();
        	$this->view_data['mensaje']="Error: No se pudo eliminar el registro: ".$err;
            $this->view_data['tipoAlerta']="alert-danger";
            $this->load->view('catalogos/plantillaproyecto/listado',$this->view_data);
        }
	}
	
	//public function index($page=1)
	public function getPlantillaProyecto()
	{
		console.log("llego controller");
		$this->load->model('mplantillaproyecto');
		$plantilla = $this->mplantillaproyecto->getPlatillaProyecto();	
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($plantilla));
	}

	public function getPlantillaPorProyecto($idproyecto=-1)
	{
		$this->load->model('mplantillaproyecto');
		$plantilla = $this->mplantillaproyecto->getPlantillaPorProyecto($idproyecto);	
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($plantilla));
	}

	public function generaPlantilla($idproyecto=-1)
	{
		$this->load->model('mplantillaproyecto');
		$sigenero = $this->mplantillaproyecto->generaPlantilla($idproyecto,$err);
		//$sigenero=false;
		if ($sigenero)
        {
        	//redirect('catalogos/plantillaproyecto/listado/'+$idproyecto);
        	$this->view_data['page_title']=  'Plantillas';
    		$this->view_data['activo']= 'plantillaproyecto';
			$this->load_partials();
			$this->view_data['idproyecto']=$idproyecto;
			$this->view_data['hproyecto']=$idproyecto;
			$this->view_data['mensaje']="Plantilla generada!!!";
            $this->view_data['tipoAlerta']="alert-success";
			$this->load->view('catalogos/plantillaproyecto/listado',$this->view_data);
        }
        else
        {
        	$this->view_data['page_title']=  'Plantillas';
    		$this->view_data['activo']= 'plantillaproyecto';
			$this->load_partials();
			$this->view_data['idproyecto']=$idproyecto;
			$this->view_data['hproyecto']=$idproyecto;
        	$this->view_data['mensaje']="Error: No se pudo generar la plantilla: ".$err;
            $this->view_data['tipoAlerta']="alert-danger";
            $this->load->view('catalogos/plantillaproyecto/listado',$this->view_data);
        }
	}

}