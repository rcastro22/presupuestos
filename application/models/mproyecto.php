<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MProyecto extends CI_Model {


	//trae todos los bancos 	
	public function getProyectos()
	{		
		
		$usrpermisos=$this->session->userdata('user_id');
		
		$query = $this->db->query("select a.[idproyecto],a.[nombre]
									from proyecto a
									where ((idproyecto<>3 and idproyecto<>8) or '$usrpermisos'  in('programacion','conta1','conta2','admin2','admin3','admin4','s.gonzalez','r.diaz'))
									order by a.nombre");
		//$query=$this->db->get();
		return $query->result();


	}
	
	//trae datos del banco recibido pro parametro
	public function getProyecto($idproyecto)
	{		
		$this->db->select('a.idproyecto,a.nombre');
		$this->db->from('proyecto a');
		$this->db->where('a.idproyecto',$idproyecto);
		$query=$this->db->get();
		return $query->row();
	}

	public function getProyectosPorCliente($cliente)
	{		
		$query = $this->db->query("select a.[idproyecto],a.[nombre]
									from proyecto a
									where a.[idproyecto] in (
									select b.[idproyecto] 
									from negociacion b
									where b.[idcliente] = ".$cliente.")");
		//$query=$this->db->get();
		return $query->result();
	}
	
	public function grabar($data,&$err)
	{
     
		$this->db->insert("proyecto",$data);

		$data['error'] = $this->db->_error_message();
		$err=$data['error'];
		if ($err=="")
		{
			return true;
			//return $this->db->insert_id();
		} 
		else
		{
			return false;
		}


		//ahora debo retornar el id que graba
		//return $this->db->insert_id();
	}

    //actualiza registro y  si da error regresa fals y el $mensaje el 
    // error lanzado
    public function modificar($idproyecto,$data,&$err)
	{
		
		$this->db->where('idproyecto', $idproyecto);
		$this->db->update("proyecto",$data);

		$data['error'] = $this->db->_error_message();
		$err=$data['error'];
		if ($err=="")
		{
			return true;
		} 
		else
		{
			return false;
		}
	}

	public function borrar($data,&$err)
	{

        $txtQuery="PRAGMA foreign_keys = ON";
        $query= $this->db->query($txtQuery);
		//graba el arreglo en la base de datos
		//banco es la tabla y $data el arreglo de campos

		$this->db->delete('proyecto',$data);
	
		$data['error'] = $this->db->_error_message();
		$err=$data['error'];
		
		if ($err=="" or $err=="database schema has changed")
		{
			$err="";
			return true;
		} 
		else
		{
			$err=" posiblemente ese registro ya esta siendo usado";
			return false;
		}
		//return true;
		//ahora debo retornar el id que graba
	}




}