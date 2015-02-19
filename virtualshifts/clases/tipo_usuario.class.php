<?php

include_once("connect_db.class.php");
class TipoUsuarios{

    var $con;

    var $has_value;
    
    var $array_tipo_usuarios;

    var $insert_id;
    

    function TipoUsuarios(){

        $this->con = new connect_db;

        $this->has_value = false;

        $this->array_tipo_usuarios = Array();

        $this->insert_id;
    }
    
    function mostrar_tipos_usuarios(){
        $this->has_value = false;
        $this->array_tipo_usuarios = array();
        
        if($this->con->Conectarse()==true){
            $query = "SELECT * FROM TIPO_USUARIOS;";
            //echo $query;
            $consulta = $this->con->conect->query($query);
            
            if($consulta->num_rows > 0){
                $this->has_value = true;
                
                while($row = $consulta->fetch_assoc()){
                    $this->array_tipo_usuarios[] = $row;
                }
            }
        }       
    }
    
    function mostrar_tipos_usuarios_para_admin(){
        $this->has_value = false;
        $this->array_tipo_usuarios = array();
        
        if($this->con->Conectarse()==true){
            $query = "SELECT * FROM TIPO_USUARIOS WHERE TU_ID != 9;";
            //echo $query;
            $consulta = $this->con->conect->query($query);
            
            if($consulta->num_rows > 0){
                $this->has_value = true;
                
                while($row = $consulta->fetch_assoc()){
                    $this->array_tipo_usuarios[] = $row;
                }
            }
        }       
    }
    
    
}

?>