<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class detalleejecutado extends MY_Controller
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

	public function repDetalleEjecutado()
	{
		$this->view_data['page_title']=  'Reporte Detallado';
		$this->view_data['activo']=  'detallejecutado';
		$this->load_partials();
		$this->load->view('reportes/detalleejecutado',$this->view_data);
	}


   public function getDetalleEjecutado($idplantillaproyecto=-1)
	{
		$this->load->model('mreporte');
		$detalle = $this->mreporte->getDetalleEjecutado($idplantillaproyecto);	
		$this->output->set_content_type('application/json');
		$this->output->set_output(json_encode($detalle));
	}
}