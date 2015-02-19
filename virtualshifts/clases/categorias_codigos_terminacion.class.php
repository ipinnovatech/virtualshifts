<?php

include_once("connect_db.class.php");



class CategoriasCodigos_terminacion{

    var $con;

    var $has_value;
    
    var $consulta;
    
    var $array_campos;

    var $insert_id;
        

    function CategoriasCodigos_terminacion(){

        $this->con = new connect_db;

        $this->has_value = false;        
        
        $this->consulta;

        $this->array_campos = Array();

        $this->insert_id;

    }
    
    function get_codigos_terminacion_por_categoria($categoria){
    
        $this->array_campos = array();          
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){
            $query="SELECT CATCT_CT_ID FROM CATEGORIAS_CODIGOS_TERMINACION WHERE CATCT_CAT_ID = $categoria";
            
            //echo $query;            
            $this->consulta = $this->con->conect->query( $query );
            
            if($this->consulta->num_rows > 0){                
                $this->has_value = true;
                while($row = $this->consulta->fetch_assoc()){
                    $this->array_campos[] = $row['CATCT_CT_ID'];
                }                
            }
            return $this->array_campos;
        }
    }
    
    function delete_codigos_terminacion_por_categoria($categoria){
    
        $this->array_campos = array();          
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){
            $query="DELETE FROM CATEGORIAS_CODIGOS_TERMINACION WHERE CATCT_CAT_ID = $categoria";
            
            //echo $query;            
            $this->consulta = $this->con->conect->query( $query );
            return $this->consulta;
        }
    }
    
    function agregar_codigos_terminacion_por_categoria($categoria, $codigos_terminacion){
    
        $this->array_campos = array();          
        $this->has_value = false;
        $this->insert_id = 0;
        
        foreach($codigos_terminacion as $area){
            $datos[] = "($categoria, $area)";
        }
        
        if($this->con->Conectarse()==true){
            $query="INSERT CATEGORIAS_CODIGOS_TERMINACION (CATCT_CAT_ID, CATCT_CT_ID) VALUES ".join(",",$datos);            
            //echo $query;            
            $this->consulta = $this->con->conect->query( $query );
            return $this->consulta;
        }
    }
    
    function get_codigos_terminacion_por_categoria_para_portal($categoria){
    
        $this->array_campos = array();          
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){
            $query="SELECT * FROM CATEGORIAS_CODIGOS_TERMINACION INNER JOIN CODIGOS_TERMINACION ON CATCT_CT_ID = CT_ID WHERE CATCT_CAT_ID = $categoria AND CT_ACTIVO = 1";
            
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
}

?>