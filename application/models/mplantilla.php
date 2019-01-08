<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class mplantilla extends CI_Model {

	public function getPlantillas()
	{		
		$this->db->select("a.principal,
						   a.secundaria,
						   a.descriptiva,
						   a.principal||'.'||a.secundaria||'.'||a.descriptiva cuenta,
						   a.nombre");
		$this->db->from("plantilla a");
		$this->db->order_by('a.principal asc,a.secundaria asc,a.descriptiva asc');
		$query=$this->db->get();
		return $query->result();
	}

	public function getPlantillaId($principal,$secundaria,$descriptiva)
	{		
		$this->db->select("a.principal,
						   a.secundaria,
						   a.descriptiva,
						   a.nombre");
		$this->db->from("plantilla a");
		$this->db->where('a.principal',$principal);
		$this->db->where('a.secundaria',$secundaria);
		$this->db->where('a.descriptiva',$descriptiva);
		$query=$this->db->get();
		return $query->row();
	}

	public function grabar($data,&$err)
	{
		$this->db->insert("plantilla",$data);	
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

    public function modificar($principal,$secundaria,$descriptiva,$data,&$err)
	{
		$this->db->where('principal', $principal);
		$this->db->where('secundaria',$secundaria);
		$this->db->where('descriptiva',$descriptiva);
		$this->db->update("plantilla",$data);
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

        $txtQuery="delete from plantilla "
                   ." where principal=".$data["principal"]
                   ." and   secundaria=".$data["secundaria"]
                   ." and   descriptiva=".$data["descriptiva"];
        $query= $this->db->query($txtQuery);        
        
        /*$this->db->delete('planitlla',$data);
		echo "hola 2";
		exit;	*/
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

