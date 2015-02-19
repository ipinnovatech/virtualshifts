<?php

include_once("connect_db.class.php");



class Areas{

    var $con;

    var $has_value;
    
    var $consulta;
    
    var $array_areas;

    var $insert_id;
    
    var $total;        

    function Areas(){

        $this->con = new connect_db;

        $this->has_value = false;        
        
        $this->consulta;

        $this->array_areas = Array();

        $this->insert_id;
        
        $this->total;

    }
    
    function get_areas($id_cliente){
    
        $this->array_areas = array();          
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){
            $query="SELECT * FROM AREAS WHERE AR_C_ID = $id_cliente ORDER BY AR_ACTIVO DESC";
            
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
    
    function get_areas_activas_por_cliente($id_cliente){
    
        $this->array_areas = array();          
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){
            $query="SELECT * FROM AREAS WHERE AR_C_ID = $id_cliente AND AR_ACTIVO = 1 ORDER BY AR_ACTIVO DESC";
            
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
    
    function get_total_areas($id_cliente){
    
        $this->total = 0;          
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){
            $query="SELECT COUNT(*) AS TOTAL FROM AREAS WHERE AR_C_ID = $id_cliente";
            
            //echo $query;            
            $this->consulta = $this->con->conect->query( $query );
            
            if($this->consulta->num_rows > 0){                
                $this->has_value = true;
                $row = $this->consulta->fetch_assoc();
                $this->total = $row['TOTAL'];
            }
            return $this->total;
        }
    }
    
    function get_area_por_id($id){
    
        $this->array_areas = array();          
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){
            $query="SELECT * FROM AREAS WHERE AR_ID = $id";
            
            //echo $query;            
            $this->consulta = $this->con->conect->query( $query );
            
            if($this->consulta->num_rows > 0){                
                $this->has_value = true;
                $row = $this->consulta->fetch_assoc();
                $this->array_areas = $row;
            }
            return $this->array_areas;
        }
    }
    
    function crear_area($nobmre, $descrip, $cliente, $alias){
    
        $this->array_areas = array();          
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){
            $query="SELECT AR_ID FROM AREAS WHERE AR_NOMBRE = '$nobmre'";            
            //echo $query;            
            $this->consulta = $this->con->conect->query( $query );
            $row = $this->consulta->fetch_assoc();
            
            if($row['AR_ID'] > 0){
                $this->consulta = false;
                $this->insert_id = $row['AR_ID'];
            }else{
                $query="INSERT INTO AREAS( AR_NOMBRE ,AR_DESCRIPCION ,AR_C_ID, AR_ALIAS ,AR_ACTIVO) VALUES ('$nobmre', '$descrip', $cliente, '$alias', 1)";
                //echo $query;            
                $this->consulta = $this->con->conect->query( $query );
                $this->insert_id = $this->con->conect->insert_id;
                return $this->consulta; 
            }
        }
    }
    
    function activar_area($id, $activo){            
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){            
            $query="UPDATE AREAS SET AR_ACTIVO = $activo WHERE AR_ID = $id";
            //echo $query;            
            $this->consulta = $this->con->conect->query( $query );
            return $this->consulta; 
        }
    }
    
    function activar_mostrar_nombre_area_en_visor($id, $activo){            
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){            
            $query="UPDATE AREAS SET AR_MOSTRAR_NOMBRE_PANTALLA = $activo WHERE AR_ID = $id";
            //echo $query;            
            $this->consulta = $this->con->conect->query( $query );
            return $this->consulta; 
        }
    }
    
    function actualizar_area($id, $nobmre, $descrip, $alias){             
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){            
            $query="UPDATE AREAS SET AR_NOMBRE = '$nobmre', AR_DESCRIPCION = '$descrip', AR_ALIAS = '$alias' WHERE AR_ID = $id";
            //echo $query;            
            $this->consulta = $this->con->conect->query( $query );
            return $this->consulta; 
        }
    }
}

?>