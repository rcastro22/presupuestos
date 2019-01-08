<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class mempleado extends CI_Model {

	public function getEmpleados()
	{		
		$this->db->select("a.idempleado,
						   a.nombre,
						   a.apellido,
						   a.direccion,
						   a.telefono");
		$this->db->from("empleado a");
		$query=$this->db->get();
		return $query->result();
	}

	public function getEmpleadoId($idempleado)
	{		
		$this->db->select("a.idempleado,
						   a.nombre,
						   a.apellido,
						   a.direccion,
						   a.telefono");
		$this->db->from("empleado a");
		$this->db->where('a.idempleado',$idempleado);
		$query=$this->db->get();
		return $query->row();
	}

	public function grabar($data,&$err)
	{
		$this->db->insert("empleado",$data);	
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

    public function modificar($idempleado,$data,&$err)
	{
		$this->db->where('idempleado', $idempleado);
		$this->db->update("empleado",$data);
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

		$this->db->delete('empleado',$data);	
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
	}

    
    

    

    

}

