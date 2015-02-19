<?php
include_once("connect_db.class.php");

class Auxiliaries{
    
    var $con;
    
    var $insert_id;
    
    var $has_value;
    
    var $consulta;

    var $array_campos;
    
    var $resultado;
    
    var $cliente;

    function Auxiliaries(){
        
        $this->con = new connect_db;
        
        $this->insert_id;
        
        $this->has_value = false;
        
        $this->consulta;

        $this->array_campos = Array();
        
        $this->resultado;
        
        $this->cliente;

    }
    
    function get_auxiliaries($cliente){
//        
          $this->array_campos='';          
          $this->has_value=false;
            
          if($this->con->Conectarse()==true){
           $query="SELECT * FROM AUXILIARIES WHERE A_CLIENTE_ID = '$cliente' ORDER BY A_ACTIVO DESC";
           
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
    
    function activar_auxiliary($id_auxiliary, $activo){
        
        if($this->con->Conectarse()==true){
            $query = "UPDATE AUXILIARIES SET A_ACTIVO = '$activo' WHERE A_ID = $id_auxiliary;";
            //echo $query;
            $consulta = $this->con->conect->query($query);

            return $consulta;
        }       
    }
    
    function crear_auxiliary($nombre,$descripcion,$duracion,$cliente){
        if($this->con->Conectarse()==true){
            
            $query = "INSERT INTO AUXILIARIES (A_NOMBRE,A_DESCRIPCION,A_DURACION,A_FECHACREACION,A_CLIENTE_ID, A_ACTIVO) VALUES ( '$nombre','$descripcion','$duracion','".date('Y/m/d H:i:s')."','$cliente','1')";
            //echo $query;
            $consulta = $this->con->conect->query($query);

            $this->insert_id=$this->con->conect->insert_id;

            return $consulta;
        }
    }
    
    function get_auxiliary($id_auxiliary){

          $this->array_campos=array();          
          $this->has_value=false;
            
          if($this->con->Conectarse()==true){
           $query="SELECT * FROM AUXILIARIES WHERE A_ID=$id_auxiliary";
           
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
     function get_aux_nombre($nombre){

          $this->array_campos='';       
          $this->has_value=false;
            
          if($this->con->Conectarse()==true){
           $query="SELECT * FROM AUXILIARIES WHERE A_NOMBRE='$nombre'";
           
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
    function update_auxiliary($id, $nombre, $descripcion, $duracion, $cliente ){
        
        if($this->con->Conectarse()==true){
            $query = "UPDATE AUXILIARIES SET A_NOMBRE='$nombre',A_DESCRIPCION='$descripcion',A_DURACION='$duracion',A_CLIENTE_ID='$cliente' WHERE A_ID='$id'";
            //echo $query;
            $consulta = $this->con->conect->query($query);
                            
            return $consulta;
            
        }
        
    }
    
    function get_auxiliaries_activos(){
        
          $this->array_campos='';          
          $this->has_value=false;
            
          if($this->con->Conectarse()==true){
           $query="SELECT * FROM AUXILIARIES WHERE A_ACTIVO = 1 ORDER BY A_NOMBRE;";
           
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
    
    function get_auxiliaries_activos_por_cliente($cliente){
        
          $this->array_campos='';          
          $this->has_value=false;
            
          if($this->con->Conectarse()==true){
           $query="SELECT * FROM AUXILIARIES WHERE A_ACTIVO = 1 AND A_CLIENTE_ID = $cliente ORDER BY A_NOMBRE;";
           
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