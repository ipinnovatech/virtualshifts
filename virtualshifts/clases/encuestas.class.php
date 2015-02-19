<?php

include_once("connect_db.class.php");

class Encuestas{

    var $con;

    var $has_value;
    
    var $consulta;
    
    var $array_encuestas;

    var $insert_id;
    
    var $total;

    function Encuestas(){

        $this->con = new connect_db;

        $this->has_value = false;        
        
        $this->consulta = new mysqli;

        $this->array_encuestas = Array();

        $this->insert_id;
        
        $this->total;
        
    }
    
    function get_encuestas($fecha_inicial, $fecha_final, $id_cliente){
        
        if($this->con->Conectarse()==true){
            
            $query="SELECT * FROM ENCUESTA_VHI WHERE EVHI_CLI_ID = $id_cliente AND EVHI_ID >= 1108 AND EVHI_FECHA_CREACION BETWEEN '$fecha_inicial' AND '$fecha_final'";
            
            //echo $query;
            $this->consulta = $this->con->conect->query( $query );
            
            if($this->consulta->num_rows > 0){
                $this->has_value = true;
                while($row = $this->consulta->fetch_assoc()){
                    $this->array_encuestas[] = $row;
                }
            }
            return $this->array_encuestas;
        }
    }
    
    function get_encuesta_por_id($id){
        
        if($this->con->Conectarse()==true){
            $query="SELECT * FROM ENCUESTAS_VHI WHERE EVHI_ID = $id";
            
            //echo $query;
            $this->consulta = $this->con->conect->query( $query );
            
            if($this->consulta->num_rows > 0){
                $this->has_value = true;
                $row = $this->consulta->fetch_assoc();
                $this->array_encuestas = $row;
            }
            return $this->array_encuestas;
        }
    }
    
    function set_encuesta($pregunta, $respuesta, $cliente, $regional, $usuario, $actividades, $nombre, $empresa){
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){
            $query="INSERT INTO ENCUESTA_VHI (EVHI_PREG_ID , EVHI_RESP , EVHI_CLI_ID, EVHI_CEDULA_USUARIO, EVHI_REGIONAL, EVHI_ACTIVIDADES, EVHI_NOMBRE_USUARIO, EVHI_EMPRESA) VALUES ('$pregunta' , '$respuesta' , '$cliente', '$usuario','$regional','$actividades', '$nombre', '$empresa')";
            
            $this->consulta = $this->con->conect->query( $query );
            return $this->consulta;
        }
    }
    
    function get_total_encuestas_por_mes_por_cedula($cedula){
        $this->total = 0;          
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){
            $query = "SELECT COUNT(*) AS TOTAL FROM ENCUESTA_VHI WHERE EVHI_CEDULA_USUARIO = '1130621297' AND DATE_FORMAT(EVHI_FECHA_CREACION, '%Y-%M') = DATE_FORMAT(CURDATE(), '%Y-%M');";
            
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
}

?>