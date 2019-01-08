<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class porempleado extends MY_Controller
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

	public function repXEmpleado()
	{
		$this->view_data['page_title']=  'Reporte Presupuesto por Empleado';
		$this->view_data['activo']=  'porempleado';
		$this->load_partials();
		$this->load->view('reportes/porempleado',$this->view_data);
	}


   public function getPresupuestoXEmpleado($idproyecto=-1,$idempleado=-1)
	{
		$this->load->model('mreporte');
		$proyeccion = $this->mreporte->getPresupuestoXEmpleado($idproyecto,$idempleado);	
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($proyeccion));
	}
}