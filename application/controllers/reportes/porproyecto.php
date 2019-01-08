<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class porproyecto extends MY_Controller
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

	public function repXProyecto()
	{
		$this->view_data['page_title']=  'Reporte Presupuesto';
		$this->view_data['activo']=  'porproyecto';
		$this->load_partials();
		$this->load->view('reportes/porproyecto',$this->view_data);
	}


   public function getPresupuestoxproyecto($idproyecto=-1)
	{
		$this->load->model('mreporte');
		$proyeccion = $this->mreporte->getPresupuestoxproyecto($idproyecto);	
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($proyeccion));
	}
}