<?php
include_once("connect_db.class.php");

class ConfiguracionEncuestasVirtualPBAX{
    
    var $con;
    
    var $insert_id;
    
    var $has_value;
    
    var $consulta;

    var $array_campos;
    
    var $resultado;
    
    var $cliente;

    function ConfiguracionEncuestasVirtualPBAX(){
        
        $this->con = new connect_db;
        
        $this->insert_id;
        
        $this->has_value = false;
        
        $this->consulta;

        $this->array_campos = Array();
        
        $this->resultado;
        
        $this->cliente;

    }
    
    function get_configuracion_encuesta_por_sede($sede){
       
          $this->array_campos = array();          
          $this->has_value = false;
            
          if($this->con->Conectarse()==true){
           $query="SELECT * FROM CONFIGURACION_ENCUESTAS_VIRTUAL_PBAX WHERE CEVP_S_ID = $sede";
           
           //echo $query;            
           $this->consulta = $this->con->conect->query( $query );
            
           if($this->consulta->num_rows > 0){
                $this->has_value = true;
                
                $campos = $this->consulta->fetch_assoc();
                $this->array_campos = $campos;
            }
            return $this->array_campos;
        }
    }
    
    function actualizar_configuracion_encuesta_por_sede($sede, $lunes, $martes, $miercoles, $jueves, $viernes, $sabado, $domingo, $lista, $nombre, $celular, $fijo, $auxiliar, $correo, $var1, $var2, $var3){
        
        if($this->con->Conectarse()==true){
            $query = "UPDATE CONFIGURACION_ENCUESTAS_VIRTUAL_PBAX SET CEVPS_CANTIDAD_LUNES = $lunes, CEVPS_CANTIDAD_MARTES = $martes, CEVPS_CANTIDAD_MIERCOLES = $miercoles, CEVPS_CANTIDAD_JUEVES = $jueves, CEVPS_CANTIDAD_VIERNES = $viernes, CEVPS_CANTIDAD_SABADO = $sabado, CEVPS_CANTIDAD_DOMINGO = $domingo, CEVP_ID_LISTA = $lista, CEVP_VAR_NOMBRE = '$nombre', CEVP_VAR_CELULAR = '$celular', CEVP_VAR_FIJO = '$fijo', CEVP_VAR_AUX = '$auxiliar', CEVP_VAR_CORREO = '$correo', CEVP_VAR_VAR1 = '$var1', CEVP_VAR_VAR2 = '$var2', CEVP_VAR_VAR3 = '$var3' WHERE CEVP_S_ID = $sede";
            //echo $query;
            $consulta = $this->con->conect->query($query);

            return $consulta;
        }       
    }
    
    function crear_configuracion_encuesta_por_sede($sede, $lunes, $martes, $miercoles, $jueves, $viernes, $sabado, $domingo, $lista, $nombre, $celular, $fijo, $auxiliar, $correo, $var1, $var2, $var3){
        if($this->con->Conectarse()==true){
            
            $query = "INSERT INTO CONFIGURACION_ENCUESTAS_VIRTUAL_PBAX (CEVP_S_ID, CEVPS_CANTIDAD_LUNES, CEVPS_CANTIDAD_MARTES, CEVPS_CANTIDAD_MIERCOLES, CEVPS_CANTIDAD_JUEVES, CEVPS_CANTIDAD_VIERNES, CEVPS_CANTIDAD_SABADO, CEVPS_CANTIDAD_DOMINGO, CEVP_ID_LISTA, CEVP_VAR_NOMBRE, CEVP_VAR_CELULAR, CEVP_VAR_FIJO, CEVP_VAR_AUX, CEVP_VAR_CORREO, CEVP_VAR_VAR1, CEVP_VAR_VAR2, CEVP_VAR_VAR3) VALUES ($sede, $lunes, $martes, $miercoles, $jueves, $viernes, $sabado, $domingo, $lista, '$nombre', '$celular', '$fijo', '$auxiliar', '$correo', '$var1', '$var2', '$var3')";
            //echo $query;
            $consulta = $this->con->conect->query($query);

            $this->insert_id=$this->con->conect->insert_id;

            return $consulta;
        }
    }
}

?>