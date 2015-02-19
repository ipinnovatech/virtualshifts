<?php

include_once("connect_db.class.php");

class UsuariosParaEncuesta{

    var $con;

    var $has_value;
    
    var $consulta;
    
    var $array_campos;

    var $insert_id;
    
    var $total;        

    function UsuariosParaEncuesta(){

        $this->con = new connect_db;

        $this->has_value = false;        
        
        $this->consulta;

        $this->array_campos = Array();

        $this->insert_id;
        
        $this->total;

    }
    
    function get_total_encuestas_por_sede_y_fecha($sede, $fecha){
    
        $this->total = 0;          
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){
            $query="SELECT COUNT(*) AS TOTAL FROM USUARIOS_PARA_ENCUESTA WHERE UPA_FECHA = '$fecha' AND UPA_S_ID = $sede";
            
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
    
    function crear_usuario_para_encuesta($consumidor, $fecha, $hora, $sede){        
        if($this->con->Conectarse()==true){
            $query="INSERT INTO USUARIOS_PARA_ENCUESTA(UPA_CON_ID, UPA_FECHACREACION, UPA_FECHA, UPA_HORA, UPA_S_ID) VALUES ($consumidor, '".date("Y-m-d H:i:s")."', '$fecha', '$hora', $sede)";
            //echo $query;
            $this->consulta = $this->con->conect->query( $query );
            $this->insert_id = $this->con->conect->insert_id;
            return $this->consulta;
        }
    }
    
    function usuario_encuestado($id){
    
        $this->array_areas = array();
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){
            $query="UPDATE USUARIOS_PARA_ENCUESTA SET UPA_ENCUESTADO = 1 WHERE UPA_ID = $id";
            echo $query;
            $this->consulta = $this->con->conect->query( $query );
            return $this->consulta;
        }
    }
    
    function get_usuarios_para_encuesta($fecha,$hora1,$hora2){
    
        $this->array_campos = array();          
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){
            $query="SELECT * FROM USUARIOS_PARA_ENCUESTA WHERE UPA_FECHA = '$fecha' AND TIME(UPA_HORA) BETWEEN '$hora1' AND '$hora2' AND UPA_ENCUESTADO = 0";
            
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
    
    function get_usuarios_para_encuesta_viejos($fecha,$hora){
    
        $this->array_campos = array();          
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){
            $query="SELECT * FROM USUARIOS_PARA_ENCUESTA WHERE UPA_FECHA = '$fecha' AND TIME(UPA_HORA) < '$hora' AND UPA_ENCUESTADO = 0";
            
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
    
    function get_total_encuestas_en_el_mes_por_cedula($cedula){
    
        $this->total = 0;          
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){
            $query = "SELECT COUNT(*) AS TOTAL FROM USUARIOS_PARA_ENCUESTA INNER JOIN CONSUMIDORES ON UPA_CON_ID = CO_ID WHERE CO_CEDULA = $cedula AND DATE_FORMAT(UPA_FECHA, '%Y-%M') = DATE_FORMAT(CURDATE(), '%Y-%M');";
            
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