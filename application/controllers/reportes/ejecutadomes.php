<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ejecutadomes extends MY_Controller
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
		{			$this->view_data['usuario']= $this->session->userdata('user_id');

		}

	}

	public function repEjecutadoMes()
	{
		
		$this->view_data['page_title']=  'Reporte Ejecutado por mes';
		$this->view_data['activo']=  'ejecutadomes';
		$this->load_partials();
		$this->load->view('reportes/ejecutadomes',$this->view_data);

	}

// 01-04-2015, erick
  public function getEjecutadoMesRango($idproyecto)
  {   
        $this->load->model('mreporte');
		$proyeccion = $this->mreporte->getEjecutadoMesRango($idproyecto);	
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($proyeccion));
  }

  public function getPresupuestoXProyectoMes($idproyecto)
  {   
        $this->load->model('mreporte');
		$proyeccion = $this->mreporte->getPresupuestoXProyectoMes($idproyecto);	
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($proyeccion));
  }  
   
}