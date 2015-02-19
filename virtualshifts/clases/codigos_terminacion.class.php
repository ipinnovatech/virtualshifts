<?php
include_once("connect_db.class.php");

class Codigos_terminacion{
    
    var $con;
    
    var $insert_id;
    
    var $has_value;
    
    var $consulta;

    var $array_campos;
    
    var $resultado;
    
    var $cliente;

    function Codigos_terminacion(){
        
        $this->con = new connect_db;
        
        $this->insert_id;
        
        $this->has_value = false;
        
        $this->consulta;

        $this->array_campos = Array();
        
        $this->resultado;
        
        $this->cliente;

    }
    
    function get_codigos_terminacion_por_cliente($id_cliente){
//        
          $this->array_campos=array();          
          $this->has_value=false;
            
          if($this->con->Conectarse()==true){
           $query="SELECT * FROM CODIGOS_TERMINACION WHERE CT_CLIENTE = '$id_cliente' ORDER BY CT_ACTIVO DESC";
           
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
    
    function get_codigos_terminacion(){
//        
          $this->array_campos='';          
          $this->has_value=false;
            
          if($this->con->Conectarse()==true){
           $query="SELECT * FROM CODIGOS_TERMINACION ORDER BY CT_ACTIVO DESC";
           
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
    
    function get_codigos_terminacion_activos_por_cliente($cliente){
//        
          $this->array_campos='';
          $this->has_value=false;
            
          if($this->con->Conectarse()==true){
           $query="SELECT * FROM CODIGOS_TERMINACION WHERE CT_CLIENTE = $cliente AND CT_ACTIVO = 1";
           
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
    
    function get_total_codigos_terminacion($id_cliente){
    
        $this->total = 0;          
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){
            $query="SELECT COUNT(*) AS TOTAL FROM CODIGOS_TERMINACION WHERE CT_CLIENTE = $id_cliente";
            
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
    
    function activar_codigo_terminacion($id_codigo_terminacion, $activo){
        
        if($this->con->Conectarse()==true){
            $query = "UPDATE CODIGOS_TERMINACION SET CT_ACTIVO = '$activo' WHERE CT_ID = $id_codigo_terminacion;";
            //echo $query;
            $consulta = $this->con->conect->query($query);

            return $consulta;
        }       
    }
    
    function crear_codigo_terminacion($nombre,$descripcion,$cliente){
        if($this->con->Conectarse()==true){
            
            $query = "INSERT INTO CODIGOS_TERMINACION (CT_NOMBRE,CT_DESCRIPCION,CT_FECHACREACION,CT_CLIENTE, CT_ACTIVO) VALUES ( '$nombre','$descripcion','".date('Y/m/d H:i:s')."','$cliente','1')";
            //echo $query;
            $consulta = $this->con->conect->query($query);

            $this->insert_id=$this->con->conect->insert_id;

            return $consulta;
        }
    }
    
    function get_codigo_terminacion($id_codigo_terminacion){

          $this->array_campos='';          
          $this->has_value=false;
            
          if($this->con->Conectarse()==true){
           $query="SELECT * FROM CODIGOS_TERMINACION WHERE CT_ID=$id_codigo_terminacion";
           
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
     function get_ct_nombre($nombre){

          $this->array_campos='';       
          $this->has_value=false;
            
          if($this->con->Conectarse()==true){
           $query="SELECT * FROM CODIGOS_TERMINACION WHERE CT_NOMBRE='$nombre'";
           
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
    function update_codigo_terminacion($id, $nombre, $descripcion,  $cliente ){
        
        if($this->con->Conectarse()==true){
            $query = "UPDATE CODIGOS_TERMINACION SET CT_NOMBRE='$nombre',CT_DESCRIPCION='$descripcion',CT_CLIENTE='$cliente' WHERE CT_ID='$id'";
            //echo $query;
            $consulta = $this->con->conect->query($query);
                            
            return $consulta;
            
        }
        
    }
    
    function get_codigos_terminacion_activos(){
        
          $this->array_campos='';          
          $this->has_value=false;
            
          if($this->con->Conectarse()==true){
           $query="SELECT * FROM CODIGOS_TERMINACION WHERE CT_ACTIVO = 1 ORDER BY CT_NOMBRE;";
           
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