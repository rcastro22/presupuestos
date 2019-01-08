<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class mdetfactura extends CI_Model {

	public function getDetFacturas($idfactura)
	{		
		$query = $this->db->query("select a.idfactura,
						   a.iddetalle,
						   a.idplantillaproyecto,
						   b.principal,
						   b.secundaria,
						   b.descriptiva,
						   a.descripcion,
						   a.monto,
						   a.fechaejecutado
						from detallefactura a
						join plantillaproyecto b on a.[idplantillaproyecto] = b.[idplantillaproyecto]
						where a.[idfactura] = $idfactura");
		return $query->result();
	}

	public function getDetFacturaId($idlinea)
	{		
		$query = $this->db->query("select a.idfactura,
						   a.iddetalle,
						   a.idplantillaproyecto,
						   b.principal,
						   b.secundaria,
						   b.descriptiva,
						   a.descripcion,
						   a.monto,
						   a.fechaejecutado
						from detallefactura a
						join plantillaproyecto b on a.[idplantillaproyecto] = b.[idplantillaproyecto]
						where a.[iddetalle] = $idlinea");
		return $query->row();

		/*$this->db->select("a.idfactura,
						   a.noserie,
						   a.nofactura,
						   a.idproyecto,
						   a.nit,
						   a.fecha,
						   a.tipocambio,
						   a.idempleado");
		$this->db->from("factura a");
		$this->db->where('a.idfactura',$idfactura);
		$query=$this->db->get();
		return $query->row();*/
	}

	public function getTotalFactura($idfactura)
	{		
		$query = $this->db->query("select sum(monto) monto
							from detallefactura a
							where a.[idfactura] = $idfactura;");
		return $query->row();
	}

	public function grabar($data,&$err)
	{
		$this->db->insert("detallefactura",$data);	
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
		$this->db->where('iddetalle', $idfactura);
		$this->db->update("detallefactura",$data);
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

		$this->db->delete('detallefactura',$data);	
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

