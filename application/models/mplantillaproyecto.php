<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class mplantillaproyecto extends CI_Model {

	public function getPlantillaProyectos()
	{		
		$this->db->select("a.idplantillaproyectos,
						   a.principal,
						   a.secundaria,
						   a.descriptiva,
						   a.principal||'.'||a.secundaria||'.'||a.descriptiva cuenta,
						   a.presupuestado,
						   a.esgeneral");
		$this->db->from("plantillaproyecto a");
		$query=$this->db->get();
		return $query->result();
	}

	public function getPlantillaPorProyecto($idproyecto)
	{		
		
		$query = $this->db->query("select a.idplantillaproyecto,
								   a.principal,
								   a.secundaria,
								   a.descriptiva,
								   a.principal||'.'||a.secundaria||'.'||a.descriptiva cuenta,
								   a.nombre,
								   a.presupuestado,
								   a.esgeneral
									from plantillaproyecto a
									where a.idproyecto = ".$idproyecto);
		//$query=$this->db->get();
		return $query->result();
	}

	public function getPlantillaProyectoId($idplantillaproyecto)
	{		
    

		$this->db->select("a.idplantillaproyecto,
			               a.idproyecto,
			               b.nombre nomproyecto,
						   a.principal,
						   a.secundaria,
						   a.descriptiva,
						   a.principal||'.'||a.secundaria||'.'||a.descriptiva cuenta,
						   a.nombre,
						   a.presupuestado,
						   a.esgeneral");
		$this->db->from("plantillaproyecto a");
		$this->db->join('proyecto b', 'a.idproyecto = b.idproyecto');
		$this->db->where('a.idplantillaproyecto',$idplantillaproyecto);
		$query=$this->db->get();
		return $query->row();



	
	}

	public function grabar($data,&$err)
	{
		//print_r($data);
		//exit;
		$this->db->insert("plantillaproyecto",$data);	
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

    public function modificar($idplantillaproyecto,$idproyecto,$data,&$err)
	{
		//echo ($idproyecto);
		//exit;
		$this->db->where('idplantillaproyecto', $idplantillaproyecto);
		$this->db->update("plantillaproyecto",$data);
		$data['error'] = $this->db->_error_message();
		$err=$data['error'];
		if ($err=="")
		{
			$this->db->select("a.principal");
			$this->db->from("plantillaproyecto a");
			$this->db->where('a.idplantillaproyecto',$idplantillaproyecto);
			$query=$this->db->get();
			$vararr=$query->row();
			
			

			$query = $this->db->query("update plantillaproyecto
										set presupuestado=(select sum(b.presupuestado)
                                                           from plantillaproyecto b
                                                           where b.principal=$vararr->principal
                                                           and  (b.secundaria <>0 or b.descriptiva <>0) 
                                                           and b.idproyecto=$idproyecto                 
                                                          )                    
                                        where principal=$vararr->principal
										and secundaria=0
										and descriptiva=0
										and idproyecto=$idproyecto");
			//return $query->result();

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

		$this->db->delete('plantillaproyecto',$data);	
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

	public function generaPlantilla($idproyecto,&$err)
	{


		/*$txtQuery="PRAGMA foreign_keys = ON";
        $query= $this->db->query($txtQuery);*/

        $cadena="select * from plantillaproyecto where idproyecto=".$idproyecto;

        $query=$this->db->query($cadena);
       

        if ($query->num_rows() == 0)
        {
        	$cadena="insert into plantillaproyecto
			                       (idproyecto,principal,secundaria,descriptiva,nombre,presupuestado,esgeneral)
			                       select ".$idproyecto.",a.principal,
								          a.secundaria,
								          a.descriptiva,
								          a.nombre,
								          0,
								          1
									from plantilla a";

			$query = $this->db->query($cadena);
			$err="";
			return true;
        }
        else
        {
        	$err="Ya tiene datos";
        	return false;
        }
        

	}


}