<?php

include_once("connect_db.class.php");



class Turnos{

    var $con;

    var $has_value;
    
    var $consulta;
    
    var $array_campos;

    var $insert_id;
    
    var $total;
    
    var $result;       

    function Turnos(){

        $this->con = new connect_db;

        $this->has_value = false;        
        
        $this->consulta;

        $this->array_campos = Array();

        $this->insert_id;
        
        $this->total;
        
        $this->result;

    }
    
    function lock_tables($array_tables){
        if($this->con->Conectarse()==true){
            $query="LOCK TABLES ".join(",", $array_tables);            
            //echo $query;            
            return $this->consulta = $this->con->conect->query( $query );            
        }
    }
    
    function unlock_tables(){
        if($this->con->Conectarse()==true){
            $query="UNLOCK TABLES;";            
            //echo $query;            
            return $this->consulta = $this->con->conect->query( $query );            
        }
    }
    
    function get_turnos($id, $nombre){
    
        $this->array_campos = array();          
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){
            $query="SELECT * FROM TURNOS_SEDE_".strtoupper($nombre)."_$id";
            
            //echo $query;            
            $this->consulta = $this->con->conect->query( $query );
            
            if($this->consulta->num_rows > 0){                
                $this->has_value = true;
                while($row = $this->consulta->fetch_assoc()){
                    $this->array_campos[] = $row;
                }                
            }
            return $this->array_campos;
        }
    }    
    
    function get_turno($id, $nombre, $turno, $area){
    
        $this->array_campos = array();          
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){
            $query="SELECT * FROM TURNOS_SEDE_".strtoupper($nombre)."_$id WHERE ID = $turno AND ID_AREA = '$area'";
            
            //echo $query;            
            $this->consulta = $this->con->conect->query( $query );
            
            if($this->consulta->num_rows > 0){                
                $this->has_value = true;
                $row = $this->consulta->fetch_assoc();
                $this->array_campos = $row;
            }
            return $this->array_campos;
        }
    }
    
    function get_turnos_sin_atender_por_area($id, $nombre, $area){
    
        $this->array_campos = array();          
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){
            $query="SELECT * FROM TURNOS_SEDE_".strtoupper($nombre)."_$id WHERE ID_AREA = '$area' AND ID_ASESOR = 0 ORDER BY ID ASC";
            
            //echo $query;            
            $this->consulta = $this->con->conect->query( $query );
            
            if($this->consulta->num_rows > 0){                
                $this->has_value = true;
                while($row = $this->consulta->fetch_assoc()){
                    $this->array_campos[] = $row;
                }
            }
            return $this->array_campos;
        }
    }
    
    function get_turnos_sin_atender_por_areas($id, $nombre, $areas){
    
        $this->array_campos = array();          
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){
            $query="SELECT * FROM TURNOS_SEDE_".strtoupper($nombre)."_$id WHERE ID_AREA IN ($areas) AND ID_ASESOR = 0 ORDER BY FECHASYS ASC, ID ASC";
            
            //echo $query;            
            $this->consulta = $this->con->conect->query( $query );
            
            if($this->consulta->num_rows > 0){                
                $this->has_value = true;
                while($row = $this->consulta->fetch_assoc()){
                    $this->array_campos[] = $row;
                }
            }
            return $this->array_campos;
        }
    }
    
    function get_total_turnos_sin_atender_por_sede_y_areas($id, $nombre, $areas){
    
        $this->array_campos = array();          
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){
            $query="SELECT COUNT(*) AS TOTAL FROM TURNOS_SEDE_".strtoupper($nombre)."_$id WHERE ID_AREA IN ($areas) AND ID_ASESOR = 0 ORDER BY ID ASC";
            
            //echo $query;            
            $this->consulta = $this->con->conect->query( $query );
            
            if($this->consulta->num_rows > 0){                
                $this->has_value = true;
                $row = $this->consulta->fetch_assoc();
                $this->result = $row['TOTAL'];                
            }
            return $this->array_campos;
        }
    }
    
    function get_turnos_sin_atender($id, $nombre){
    
        $this->array_campos = array();          
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){
            $query="SELECT * FROM TURNOS_SEDE_".strtoupper($nombre)."_$id INNER JOIN HISTORIAL_TURNOS ON ID_AREA = HT_AR_ID WHERE ATENDIO = 0 AND HT_S_ID = $id AND DATE(HT_FECHACREACION) = CURDATE() AND HT_INICIO_ATENCION = '00:00:00' AND HT_TURNO = ID ORDER BY ID ASC";
            
            //echo $query;            
            $this->consulta = $this->con->conect->query( $query );
            
            if($this->consulta->num_rows > 0){                
                $this->has_value = true;
                while($row = $this->consulta->fetch_assoc()){
                    $this->array_campos[] = $row;
                }
            }
            return $this->array_campos;
        }
    }
    
    function get_turno_por_usuario($id, $nombre, $asesor){
    
        $this->array_campos = array();          
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){
            $query="SELECT * FROM TURNOS_SEDE_".strtoupper($nombre)."_$id WHERE ID_ASESOR = $asesor AND ATENDIO = 0;";
            
            //echo $query;            
            $this->consulta = $this->con->conect->query( $query );
            
            if($this->consulta->num_rows > 0){                
                $this->has_value = true;
                $row = $this->consulta->fetch_assoc();
                $this->array_campos = $row;
            }
            return $this->array_campos;
        }
    }
    
    function crear_turno($id, $nombre, $area, $consumidor){
        if($this->con->Conectarse()==true){            
            $query="INSERT INTO TURNOS_SEDE_".strtoupper($nombre)."_$id( ID_AREA, ID_CONSUMIDOR) VALUES ('$area', $consumidor)";
            //echo $query;            
            $this->consulta = $this->con->conect->query( $query );
            $this->insert_id = $this->con->conect->insert_id;
            return $this->consulta;             
        }
    }
    
    function inicia_atencion($id, $nombre, $area, $turno, $gestionador){            
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){            
            $query="UPDATE TURNOS_SEDE_".strtoupper($nombre)."_$id SET ID_ASESOR = $gestionador WHERE ID_AREA = '$area' AND ID = $turno";
            //echo $query;            
            $this->consulta = $this->con->conect->query( $query );
            return $this->consulta; 
        }
    }
    
    function cerrar_turno($id, $nombre, $turno, $area){             
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){            
            $query="UPDATE TURNOS_SEDE_".strtoupper($nombre)."_$id SET ATENDIO = 1 WHERE ID = $turno AND ID_AREA = '$area'";
            //echo $query;            
            $this->consulta = $this->con->conect->query( $query );
            return $this->consulta; 
        }
    }
}

?>