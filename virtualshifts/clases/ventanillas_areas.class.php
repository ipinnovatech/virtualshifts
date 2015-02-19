<?php

include_once("connect_db.class.php");



class VentanillasAreas{

    var $con;

    var $has_value;
    
    var $consulta;
    
    var $array_areas;

    var $insert_id;
        

    function VentanillasAreas(){

        $this->con = new connect_db;

        $this->has_value = false;        
        
        $this->consulta;

        $this->array_areas = Array();

        $this->insert_id;

    }
    
    function get_areas_por_ventanilla($ventanilla){
    
        $this->array_areas = array();          
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){
            $query="SELECT VEA_A_ID FROM VENTANILLAS_AREAS WHERE VEA_VENT_ID = $ventanilla";
            
            //echo $query;            
            $this->consulta = $this->con->conect->query( $query );
            
            if($this->consulta->num_rows > 0){                
                $this->has_value = true;
                while($row = $this->consulta->fetch_assoc()){
                    $this->array_areas[] = "'".$row['VEA_A_ID']."'";
                }                
            }
            return $this->array_areas;
        }
    }
    
    function get_areas_por_ventanilla_con_prioridad_alta($ventanilla){
    
        $this->array_areas = array();          
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){
            $query="SELECT VEA_A_ID FROM VENTANILLAS_AREAS WHERE VEA_VENT_ID = $ventanilla AND VEA_PRIORIDAD = 2";
            
            //echo $query;            
            $this->consulta = $this->con->conect->query( $query );
            
            if($this->consulta->num_rows > 0){                
                $this->has_value = true;
                while($row = $this->consulta->fetch_assoc()){
                    $this->array_areas[] = "'".$row['VEA_A_ID']."'";
                }                
            }
            return $this->array_areas;
        }
    }
    
    function get_areas_por_ventanilla_con_prioridad_media($ventanilla){
    
        $this->array_areas = array();          
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){
            $query="SELECT VEA_A_ID FROM VENTANILLAS_AREAS WHERE VEA_VENT_ID = $ventanilla AND VEA_PRIORIDAD = 1";
            
            //echo $query;            
            $this->consulta = $this->con->conect->query( $query );
            
            if($this->consulta->num_rows > 0){                
                $this->has_value = true;
                while($row = $this->consulta->fetch_assoc()){
                    $this->array_areas[] = "'".$row['VEA_A_ID']."'";
                }                
            }
            return $this->array_areas;
        }
    }
    
    function get_areas_por_ventanilla_con_prioridad_baja($ventanilla){
    
        $this->array_areas = array();          
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){
            $query="SELECT VEA_A_ID FROM VENTANILLAS_AREAS WHERE VEA_VENT_ID = $ventanilla AND VEA_PRIORIDAD = 0";
            
            //echo $query;            
            $this->consulta = $this->con->conect->query( $query );
            
            if($this->consulta->num_rows > 0){                
                $this->has_value = true;
                while($row = $this->consulta->fetch_assoc()){
                    $this->array_areas[] = "'".$row['VEA_A_ID']."'";
                }                
            }
            return $this->array_areas;
        }
    }
    
    function delete_areas_por_ventanilla($ventanilla){
    
        $this->array_areas = array();          
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){
            $query="DELETE FROM VENTANILLAS_AREAS WHERE VEA_VENT_ID = $ventanilla";
            
            //echo $query;            
            $this->consulta = $this->con->conect->query( $query );
            return $this->consulta;
        }
    }
    
    function agregar_areas_por_ventanilla($ventanilla, $areas){
    
        $this->array_areas = array();          
        $this->has_value = false;
        $this->insert_id = 0;
        
        foreach($areas as $area){
            $datos[] = "($ventanilla, $area)";
        }
        
        if($this->con->Conectarse()==true){
            $query="INSERT VENTANILLAS_AREAS (VEA_VENT_ID, VEA_A_ID) VALUES ".join(",",$datos);            
            //echo $query;            
            $this->consulta = $this->con->conect->query( $query );
            return $this->consulta;
        }
    }
    
    function get_areas_por_ventanilla_full($ventanilla){
    
        $this->array_areas = array();          
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){
            $query="SELECT * FROM VENTANILLAS_AREAS INNER JOIN AREAS ON VEA_A_ID = AR_ID WHERE VEA_VENT_ID = $ventanilla";
            
            //echo $query;            
            $this->consulta = $this->con->conect->query( $query );
            
            if($this->consulta->num_rows > 0){                
                $this->has_value = true;
                while($row = $this->consulta->fetch_assoc()){
                    $this->array_areas[] = $row;
                }                
            }
            return $this->array_areas;
        }
    }
    
    function actualiza_prioridad_por_ventanilla_y_area($ventanilla, $area, $prioridad){        
        if($this->con->Conectarse()==true){
            $query="UPDATE VENTANILLAS_AREAS SET VEA_PRIORIDAD = $prioridad WHERE VEA_VENT_ID = $ventanilla AND VEA_A_ID = $area";
            
            //echo $query;            
            $this->consulta = $this->con->conect->query( $query );
            return $this->consulta;
        }
    }
}

?>