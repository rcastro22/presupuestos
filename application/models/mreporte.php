<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class mreporte extends CI_Model {



	
    //trae los datos de las negociaciones que han hecho los asesores de un proyecto determinado
	public function getPresupuestoxproyecto($idproyecto)
	{		

        $txtQuery="select a.principal||'.'||a.secundaria||'.'||a.descriptiva cuenta,a.nombre,
                   case when a.secundaria=0 and a.descriptiva=0 then a.presupuestado else 0 end presupuestadopartida,
                   case when a.secundaria=0 and a.descriptiva=0 then 0 else a.presupuestado end presupuestadosubpartida, 
                   case when a.secundaria=0 and a.descriptiva=0 then ejecutado else 0 end ejecutadopartida,
                   case when a.secundaria=0 and a.descriptiva=0 then 0 else ejecutado end ejecutadosubpartida,                   

                   case when a.secundaria=0 and a.descriptiva=0 then round(a.presupuestado-ejecutado,2) else 0 end diferenciapartida,                                      
                   case when a.secundaria=0 and a.descriptiva=0 then 0 else round(a.presupuestado-ejecutado,2) end diferenciasubpartida
                   --round(a.presupuestado-ejecutado,2) diferencia
                   from plantillaproyecto a left join
                   (  
                     select t2.principal||'.'||t2.secundaria||'.'||t2.descriptiva cuenta,round(sum(t1.monto/t3.tipocambio),2) ejecutado
                     from detallefactura t1,plantillaproyecto t2,factura t3    
                     where t1.idplantillaproyecto=t2.idplantillaproyecto 
                     and   t1.idfactura=t3.idfactura      
                     and (t2.secundaria<>0 or t2.descriptiva<>0)                     
                     and t2.idproyecto=".$idproyecto.
                     " group by t1.idplantillaproyecto,t2.principal,t2.secundaria,t2.descriptiva
                      union
                      select t2.principal||'.0.0' cuenta,sum(round(t1.monto/t3.tipocambio,2)) ejecutado
                             from detallefactura t1,plantillaproyecto t2,factura t3      
                             where t1.idplantillaproyecto=t2.idplantillaproyecto                             
                             and t1.idfactura=t3.idfactura
                             and (t2.secundaria<>0 or t2.descriptiva<>0)
                             and t2.idproyecto=".$idproyecto.
                             " group by t2.principal||'.0.0' 
                   ) b 
              on 
              a.principal||'.'||a.secundaria||'.'||a.descriptiva=b.cuenta
              where a.idproyecto=".$idproyecto.
              " order by a.principal,a.secundaria,a.descriptiva";
        $query= $this->db->query($txtQuery);
        return $query->result();
	}

  public function getPresupuestoXEmpleado($idproyecto,$idempleado)
  {   
    
      
        $txtQuery="select b.idproyecto,b.idempleado,a.idplantillaproyecto,
                    c.principal||'.'||c.secundaria||'.'||c.descriptiva cuenta,c.nombre,
                    round(sum(a.monto/b.tipocambio),2) ejecutado
                    from detallefactura a, factura b,plantillaproyecto c
                    where a.idfactura=b.idfactura
                    and   a.idplantillaproyecto=c.idplantillaproyecto
                    and   b.idproyecto=".$idproyecto.
                    " and   b.idempleado=".$idempleado.
                    " group by b.idproyecto,b.idempleado,a.idplantillaproyecto,
                               c.principal||'.'||c.secundaria||'.'||c.descriptiva,c.nombre
                    order by c.principal,c.secundaria,c.descriptiva";

        $query= $this->db->query($txtQuery);
        return $query->result();
  }

  // 01-04-2015, erick
  public function getEjecutadoMesRango($idproyecto)
  {   
                
        $txtQuery="select Date(min(a.[fechaejecutado]),6||' hour') fechamin,
                   Date(max(a.[fechaejecutado]),6||' hour') fechamax 
                   from detallefactura a,plantillaproyecto b
                   where a.idplantillaproyecto=b.idplantillaproyecto
                   and b.[idproyecto] =".$idproyecto;

        $query= $this->db->query($txtQuery);
        return $query->result();
  }


   //06/04/2015  erick
  //trae los datos de las negociaciones que han hecho los asesores de un proyecto determinado
  public function getPresupuestoXProyectoMes($idproyecto)
  {   

        $txtQuery="select a.principal||'.'||a.secundaria||'.'||a.descriptiva cuenta,a.nombre,
       case when a.secundaria=0 and a.descriptiva=0 then 0 else ejecutado end ejecutadosubpartida,             
       b.fechaejecutado
       from plantillaproyecto a left join
       (  
         select t2.principal||'.'||t2.secundaria||'.'||t2.descriptiva cuenta,
         strftime('%Y',t1.fechaejecutado) as Anio ,                     
         strftime('%m', t1.fechaejecutado) as Mes ,
         round(t1.monto/t3.tipocambio,2) ejecutado ,                    
                     fechaejecutado
           from detallefactura t1,plantillaproyecto t2,factura t3    
                     where t1.idplantillaproyecto=t2.idplantillaproyecto 
                     and   t1.idfactura=t3.idfactura      
                     and (t2.secundaria<>0 or t2.descriptiva<>0)                     
                     and t2.idproyecto=".$idproyecto.                 
                   " ) b 
              on 
              a.principal||'.'||a.secundaria||'.'||a.descriptiva=b.cuenta
              where a.idproyecto=".$idproyecto.  
              " --and fechaejecutado is not null   
              --and a.principal=1 and (a.secundaria=1 or a.secundaria=5 or a.secundaria=7) and a.descriptiva=0 

       order by a.principal,a.secundaria,a.descriptiva";

        $query= $this->db->query($txtQuery);
        return $query->result();
  }

  //detalle ejecutado erick 11/05/2015
  public function getDetalleEjecutado($idplantillaproyecto)
  {   
     //$idplantillaproyecto=64;
        $txtQuery="select c.principal,c.secundaria,c.[descriptiva],b.noserie,b.nofactura,b.fecha fechafactura,b.proveedor,
                  a.monto,a.fechaejecutado,d.[descripcion] tipodocumento
                  from detallefactura a,factura b,plantillaproyecto c,tipodocumento d
                  where a.idfactura=b.idfactura 
                  and   a.idplantillaproyecto=c.idplantillaproyecto
                  and   b.idtipodocumento = d.idtipodocumento
                  and a.idplantillaproyecto=".$idplantillaproyecto;

        $query= $this->db->query($txtQuery);
        return $query->result();
  }



}

