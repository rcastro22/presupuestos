<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class mfactura extends CI_Model {

	public function getFacturas()
	{		
		$query = $this->db->query("select a.idfactura,
						   a.noserie,
						   a.nofactura,
						   a.idproyecto,
						   a.nit,
						   a.proveedor,
						   a.fecha,
						   a.tipocambio,
						   a.idempleado,
               				(select sum(monto) monto from detallefactura b where b.[idfactura] = a.[idfactura]) monto   
					from factura a
					order by a.idfactura desc;");
		return $query->result();
	}

	public function getFacturaId($idfactura)
	{		
		$this->db->select("a.idfactura,
						   a.idtipodocumento,
						   a.noserie,
						   a.nofactura,
						   a.idproyecto,
						   a.nit,
						   a.proveedor,
						   a.fecha,
						   a.tipocambio,
						   a.idempleado");
		$this->db->from("factura a");
		$this->db->where('a.idfactura',$idfactura);		
		$query=$this->db->get();
		return $query->row();
	}

	public function getFacturasPorProyecto($idproyecto,$idplantilla)
	{		
		if($idplantilla == 0)
		{
			$query = $this->db->query("select a.idfactura,
							   a.noserie,
							   a.nofactura,
							   a.idproyecto,
							   a.nit,
							   a.proveedor,
							   a.fecha,
							   a.tipocambio,
							   a.idempleado,
	               				(select sum(monto) monto from detallefactura b where b.[idfactura] = a.[idfactura]) monto   
						from factura a
						where $idproyecto = 0 or a.idproyecto = $idproyecto
						order by a.idfactura desc;");
		}
		else
		{
			$query = $this->db->query("select a.idfactura,
							   a.noserie,
							   a.nofactura,
							   a.idproyecto,
							   a.nit,
							   a.proveedor,
							   a.fecha,
							   a.tipocambio,
							   a.idempleado,
	               				(select sum(monto) monto from detallefactura b where b.[idfactura] = a.[idfactura]) monto   
						from factura a, detallefactura b
						where a.[idfactura] = b.[idfactura]
	          			and b.[idplantillaproyecto] = $idplantilla
	          			and ($idproyecto = 0 or a.idproyecto == $idproyecto)
						order by a.idfactura desc;");	
		}
		return $query->result();
	}

	public function grabar($data,&$err)
	{
		$this->db->insert("factura",$data);	
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

    public function modificar($idfactura,$data,&$err)
	{
		$this->db->where('idfactura', $idfactura);
		$this->db->update("factura",$data);
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

		$this->db->delete('factura',$data);	
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

