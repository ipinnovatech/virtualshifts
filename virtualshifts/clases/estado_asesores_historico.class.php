<?php
include_once("connect_db.class.php");

class EstadoAsesoresHistorico{
    
    var $con;
    
    var $insert_id;
    
    var $has_value;
    
    var $consulta;

    var $array_campos;
    
    var $resultado;
    
    var $cliente;

    function EstadoAsesoresHistorico(){
        
        $this->con = new connect_db;
        
        $this->insert_id;
        
        $this->has_value = false;
        
        $this->consulta;

        $this->array_campos = Array();
        
        $this->resultado;
        
        $this->cliente;

    }
    
    function crea_estado_asesor($fecha, $hora_inicio, $hora_fin, $etado, $aux_id, $usuario){
//                
          $this->has_value=false;
            
          if($this->con->Conectarse()==true){
           $query="INSERT INTO ESTADO_ASESORES_HISTORICO(EAH_FECHA, EAH_FECHA_CREACION, EAH_HORA_INICIO, EAH_HORA_FIN, EAH_ESTADO, EAH_AUX_ID, EAH_U_ID) VALUES ('$fecha', '".date("Y-m-d H:i:s")."', '$hora_inicio', '$hora_fin', '$etado', $aux_id, $usuario)";
           
           //echo $query;            
           $this->consulta = $this->con->conect->query( $query );
           $this->insert_id=$this->con->conect->insert_id;
           
           return $this->consulta;
        }
    }
    
    function terminar_tiempo_auxiliary($fecha, $estado, $aux, $usuario, $hora_fin){
        
        if($this->con->Conectarse()==true){
            $query = "UPDATE ESTADO_ASESORES_HISTORICO SET EAH_HORA_FIN = '$hora_fin' WHERE DATE(EAH_FECHA) = '$fecha' AND EAH_ESTADO = '$estado' AND EAH_AUX_ID = $aux AND EAH_U_ID = $usuario AND EAH_HORA_FIN = '00:00:00';";
            //echo $query;
            $consulta = $this->con->conect->query($query);

            return $consulta;
        }       
    }
    
    function get_estado_asesor_por_fecha_asesor_aux($fecha, $estado, $aux, $usuario){

          $this->array_campos=array();          
          $this->has_value=false;
            
          if($this->con->Conectarse()==true){
           $query="SELECT *, TIME_TO_SEC(TIMEDIFF(EAH_HORA_FIN, EAH_HORA_INICIO)) AS DIFERENCIA_TIEMPO FROM ESTADO_ASESORES_HISTORICO WHERE DATE(EAH_FECHA) = '$fecha' AND EAH_ESTADO = '$estado' AND EAH_AUX_ID = $aux AND EAH_U_ID = $usuario";
           
           //echo $query;            
           $this->consulta = $this->con->conect->query( $query );
            
           if($this->consulta->num_rows > 0){                
                $this->has_value = true;
                
                while($campos = $this->consulta->fetch_assoc()){
                    $this->array_campos[] = $campos;
                }
            }
            return $this->array_campos;
        }
        
    }
}

?>