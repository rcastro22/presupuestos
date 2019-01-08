<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


//aqui quite que extendiera de CI_Controller y ahora
//le pongo de mi controlador MY_Controller
class menuadmin extends MY_Controller
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

    //el offset lo agregue cuando hice la paginacion
    //luego quite el $page=1 cuando hice el ordenamiento
	//public function index($page=1)
	public function index()
	{
		$this->view_data['page_title']=  'Menu de administración';
		$this->view_data['activo']=  'inicio';
		$this->load_partials();
		$this->load->view('admin/menuadmin',$this->view_data);
	}
    
    

}