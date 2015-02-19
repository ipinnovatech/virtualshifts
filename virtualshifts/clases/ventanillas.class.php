<?php

include_once("connect_db.class.php");



class Ventanillas{

    var $con;

    var $has_value;
    
    var $consulta;
    
    var $array_ventanillas;

    var $insert_id;
        

    function Ventanillas(){

        $this->con = new connect_db;

        $this->has_value = false;        
        
        $this->consulta;

        $this->array_ventanillas = Array();

        $this->insert_id;

    }
    
    function get_ventanillas($cliente){
    
        $this->array_ventanillas = array();          
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){
            $query="SELECT * FROM VENTANILLAS INNER JOIN SEDES ON VENT_S_ID = S_ID WHERE VENT_CLI_ID = $cliente ORDER BY VENT_ACTIVO DESC";
            
            //echo $query;            
            $this->consulta = $this->con->conect->query( $query );
            
            if($this->consulta->num_rows > 0){                
                $this->has_value = true;
                while($row = $this->consulta->fetch_assoc()){
                    $this->array_ventanillas[] = $row;
                }                
            }
            return $this->array_ventanillas;
        }
    }
    
    function get_ventanillas_por_sede($sede){
    
        $this->array_ventanillas = array();          
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){
            $query="SELECT * FROM VENTANILLAS WHERE VENT_S_ID = $sede";
            
            //echo $query;            
            $this->consulta = $this->con->conect->query( $query );
            
            if($this->consulta->num_rows > 0){                
                $this->has_value = true;
                while($row = $this->consulta->fetch_assoc()){
                    $this->array_ventanillas[] = $row;
                }                
            }
            return $this->array_ventanillas;
        }
    }
    
    function get_ventanillas_activas_por_sede($sede){
    
        $this->array_ventanillas = array();          
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){
            $query="SELECT * FROM VENTANILLAS WHERE VENT_S_ID = $sede AND VENT_ACTIVO = 1";
            
            //echo $query;            
            $this->consulta = $this->con->conect->query( $query );
            
            if($this->consulta->num_rows > 0){                
                $this->has_value = true;
                while($row = $this->consulta->fetch_assoc()){
                    $this->array_ventanillas[] = $row;
                }                
            }
            return $this->array_ventanillas;
        }
    }
    
    function get_ventanillas_por_id($id){
    
        $this->array_ventanillas = array();          
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){
            $query="SELECT * FROM VENTANILLAS WHERE VENT_ID = $id";
            
            //echo $query;            
            $this->consulta = $this->con->conect->query( $query );
            
            if($this->consulta->num_rows > 0){                
                $this->has_value = true;
                $row = $this->consulta->fetch_assoc();
                $this->array_ventanillas = $row;
            }
            return $this->array_ventanillas;
        }
    }
    
    function crear_ventanilla($nobmre, $descrip, $cliente, $sede){
    
        $this->array_areas = array();          
        $this->has_value = false;
        $this->insert_id = 0;
        
        if($this->con->Conectarse()==true){
            $query="SELECT VENT_ID FROM VENTANILLAS WHERE VENT_NOMBRE = '$nobmre' AND VENT_S_ID = $sede";            
            //echo $query;            
            $this->consulta = $this->con->conect->query( $query );
            $row = $this->consulta->fetch_assoc();
            
            if($row['VENT_ID'] > 0){
                $this->consulta = false;
                $this->insert_id = $row['VENT_ID'];
                return false; 
            }else{
                $query="INSERT INTO VENTANILLAS( VENT_NOMBRE, VENT_DESCRIPCION, VENT_S_ID, VENT_CLI_ID, VENT_ACTIVO) VALUES ('$nobmre', '$descrip', $sede, $cliente, 1)";
                //echo $query;            
                $this->consulta = $this->con->conect->query( $query );
                $this->insert_id = $this->con->conect->insert_id;
                return $this->consulta; 
            }
        }
    }
    
    function activar_ventanilla($id, $activo){            
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){            
            $query="UPDATE VENTANILLAS SET VENT_ACTIVO = $activo WHERE VENT_ID = $id";
            //echo $query;            
            $this->consulta = $this->con->conect->query( $query );
            return $this->consulta; 
        }
    }
    
    function actualizar_ventanilla($id, $nobmre, $descrip){             
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){            
            $query="UPDATE VENTANILLAS SET VENT_NOMBRE = '$nobmre', VENT_DESCRIPCION = '$descrip' WHERE VENT_ID = $id";
            //echo $query;            
            $this->consulta = $this->con->conect->query( $query );
            return $this->consulta; 
        }
    }
}

?>