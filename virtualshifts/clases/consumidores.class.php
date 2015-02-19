<?php

include_once("connect_db.class.php");



class Consumidores{

    var $con;

    var $has_value;
    
    var $consulta;
    
    var $array_campos;

    var $insert_id;
    
    var $total;        

    function Consumidores(){

        $this->con = new connect_db;

        $this->has_value = false;        
        
        $this->consulta;

        $this->array_campos = Array();

        $this->insert_id;
        
        $this->total;

    }
    
    function get_caonsumidores($id_cliente){
    
        $this->array_campos = array();          
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){
            $query="SELECT * FROM CONSUMIDORES WHERE CO_CLI_ID = $id_cliente";
            
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
    
    function get_consumidor_por_id($id){
    
        $this->array_campos = array();          
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){
            $query="SELECT * FROM CONSUMIDORES WHERE CO_ID = $id";
            
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
    
    function crear_consumidor($nobmre, $cedula, $direccion, $telefono, $correo, $campo1, $campo2, $campo3, $campo4, $campo5, $cliente){
        
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){            
            $query="INSERT INTO CONSUMIDORES( CO_NOMBRE, CO_CEDULA, CO_DIRECCION, CO_TELEFONO, CO_CORREO, CO_CAMPO1, CO_CAMPO2, CO_CAMPO3, CO_CAMPO4, CO_CAMPO5, CO_CLI_ID) VALUES ('$nobmre', '$cedula', '$direccion', '$telefono', '$correo', '$campo1', '$campo2', '$campo3', '$campo4', '$campo5', $cliente)";
            //echo $query;
            //$this->con->conect->set_charset('utf8');
            $this->consulta = $this->con->conect->query( $query );
            $this->insert_id = $this->con->conect->insert_id;
            return $this->consulta; 
        }
    }
    
    function actualizar_consumidor($id, $nobmre, $cedula, $direccion, $telefono, $correo, $campo1, $campo2, $campo3, $campo4, $campo5){
        
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){            
            $query="UPDATE CONSUMIDORES SET CO_NOMBRE = '$nobmre', CO_CEDULA = '$cedula', CO_DIRECCION = '$direccion', CO_TELEFONO = '$telefono', CO_CORREO =  '$correo', CO_CAMPO1 =  '$campo1', CO_CAMPO2 = '$campo2', CO_CAMPO3 = '$campo3', CO_CAMPO4 = '$campo4', CO_CAMPO5 = '$campo5' WHERE CO_ID = $id";
            //echo $query;            
            $this->consulta = $this->con->conect->query( $query );
            return $this->consulta; 
        }
    }
}

?>