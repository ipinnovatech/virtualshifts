<?php

include_once("connect_db.class.php");



class ImagenesSedes{

    var $con;

    var $has_value;
    
    var $consulta;
    
    var $array_campos;

    var $insert_id;
        

    function ImagenesSedes(){

        $this->con = new connect_db;

        $this->has_value = false;        
        
        $this->consulta;

        $this->array_campos = Array();

        $this->insert_id;

    }
    
    function get_imagenes_por_sede($sede){
    
        $this->array_campos = array();          
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){
            $query="SELECT IMAS_IMA_ID FROM IMAGENES_SEDES WHERE IMAS_S_ID = $sede";
            
            //echo $query;            
            $this->consulta = $this->con->conect->query( $query );
            
            if($this->consulta->num_rows > 0){                
                $this->has_value = true;
                while($row = $this->consulta->fetch_assoc()){
                    $this->array_campos[] = $row['IMAS_IMA_ID'];
                }                
            }
            return $this->array_campos;
        }
    }
    
    function get_imagenes_por_sede_para_visor($sede, $id){
    
        $this->array_campos = array();          
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){
            $query="SELECT * FROM IMAGENES_SEDES INNER JOIN IMAGENES ON IMAS_IMA_ID = IMA_ID WHERE IMAS_S_ID = $sede AND IMAS_IMA_ID != $id";
            
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
    
    function delete_imagenes_por_sede($sede){
             
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){
            $query="DELETE FROM IMAGENES_SEDES WHERE IMAS_S_ID = $sede";
            
            //echo $query;            
            $this->consulta = $this->con->conect->query( $query );
            return $this->consulta;
        }
    }
    
    function agregar_imagenes_por_sede($sede, $imagenes){
          
        $this->has_value = false;
        
        foreach($imagenes as $imagen){
            $datos[] = "($sede, $imagen)";
        }
        
        if($this->con->Conectarse()==true){
            $query="INSERT IMAGENES_SEDES (IMAS_S_ID, IMAS_IMA_ID) VALUES ".join(",",$datos);            
            //echo $query;            
            $this->consulta = $this->con->conect->query( $query );
            return $this->consulta;
        }
    }
}

?>