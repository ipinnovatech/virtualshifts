<?php

include_once("connect_db.class.php");



class Imagenes{

    var $con;

    var $has_value;
    
    var $consulta;
    
    var $array_campos;
    
    var $result;

    var $insert_id;        

    function Imagenes(){

        $this->con = new connect_db;

        $this->has_value = false;        
        
        $this->consulta;

        $this->array_campos = Array();

        $this->insert_id;
        
        $this->result;

    }
    
    function get_imagenes($id_cliente){
    
        $this->array_campos = array();          
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){
            $query="SELECT * FROM IMAGENES WHERE IMA_CLI_ID = $id_cliente ORDER BY IMA_ACTIVO DESC";
            
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
    
    function get_imagenes_activos($id_cliente){
    
        $this->array_campos = array();          
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){
            $query="SELECT * FROM IMAGENES WHERE IMA_CLI_ID = $id_cliente AND IMA_ACTIVO = 1";
            
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
    
    function get_total_imagenes_activos($id_cliente){
    
        $this->result = 0;          
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){
            $query="SELECT COUNT(*) AS TOTAL FROM IMAGENES WHERE IMA_CLI_ID = $id_cliente AND IMA_ACTIVO = 1";
            
            //echo $query;            
            $this->consulta = $this->con->conect->query( $query );
            
            if($this->consulta->num_rows > 0){                
                $this->has_value = true;
                $row = $this->consulta->fetch_assoc();
                $this->result = $row['TOTAL'];               
            }
            return $this->result;
        }
    }
        
    function get_imagen_por_id($id){
    
        $this->array_campos = array();          
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){
            $query="SELECT * FROM IMAGENES WHERE IMA_ID = $id";
            
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
    
    function crear_imagen($descrip, $cliente, $url, $activo){
           
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){            
            $query="INSERT INTO IMAGENES(IMA_DESCRIPCION, IMA_CLI_ID, IMA_URL, IMA_ACTIVO, IMA_FECHACREACION) VALUES ('$descrip', $cliente, '$url', $activo, '".date("Y-m-d- H:i:s")."');";
            //echo $query;            
            $this->consulta = $this->con->conect->query( $query );
            $this->insert_id = $this->con->conect->insert_id;
            return $this->consulta;             
        }
    }
    
    function activar_imagen($id, $activo){            
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){            
            $query="UPDATE IMAGENES SET IMA_ACTIVO = $activo WHERE IMA_ID = $id";
            //echo $query;            
            $this->consulta = $this->con->conect->query( $query );
            return $this->consulta; 
        }
    }
    
    function actualizar_imagen($id, $descrip){             
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){            
            $query="UPDATE IMAGENES SET IMA_DESCRIPCION = '$descrip' WHERE IMA_ID = $id";
            //echo $query;            
            $this->consulta = $this->con->conect->query( $query );
            return $this->consulta; 
        }
    }
    
    function eliminar_imagen($id){ 
        if($this->con->Conectarse()==true){            
            $query="DELETE FROM IMAGENES WHERE IMA_ID = $id";
            //echo $query;            
            $this->consulta = $this->con->conect->query( $query );
            return $this->consulta; 
        }
    }
}

?>