<?php
include_once("connect_db.class.php");

class Logos{
    
    var $con;
    
    var $insert_id;
    
    var $has_value;
    
    var $consulta;

    var $array_campos;
    
    var $resultado;
    
    var $sede;

    function Logos(){
        
        $this->con = new connect_db;
        
        $this->insert_id;
        
        $this->has_value = false;
        
        $this->consulta;

        $this->array_campos = Array();
        
        $this->resultado;
        
        $this->sede;

    }
    
    function get_logos(){
//        
          $this->array_campos='';          
          $this->has_value=false;
            
          if($this->con->Conectarse()==true){
           $query="SELECT * FROM LOGOS";
           
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
    
    function get_logos_por_cliente($cliente){
//        
          $this->array_campos='';          
          $this->has_value=false;
            
          if($this->con->Conectarse()==true){
           $query="SELECT * FROM LOGOS WHERE L_CLI_ID = $cliente";
           
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
    
    function crear_logo($nombre, $descripcion, $cliente, $url){
        if($this->con->Conectarse()==true){
            
            $query = "INSERT INTO LOGOS (L_NOMBRE, L_DESCRIPCION, L_CLI_ID, L_URL, L_FECHACREACION) VALUES ('$nombre', '$descripcion', $cliente, '$url', '".date("Y-m-d H:i:S")."')";
            //echo $query;
            $consulta = $this->con->conect->query($query);

            $this->insert_id=$this->con->conect->insert_id;

            return $consulta;
        }
    }
    
    function get_logo($id_logo){

          $this->array_campos = array();          
          $this->has_value = false;
            
          if($this->con->Conectarse()==true){
           $query="SELECT * FROM LOGOS WHERE L_ID=$id_logo";
           
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
     function get_log_nombre($nombre){

          $this->array_campos='';       
          $this->has_value=false;
            
          if($this->con->Conectarse()==true){
           $query="SELECT * FROM LOGOS WHERE L_NOMBRE='$nombre'";
           
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
    
    function update_logo($id, $descrip){
        
        if($this->con->Conectarse()==true){
            $query = "UPDATE LOGOS SET L_DESCRIPCION = '$descrip' WHERE L_ID = $id";
            //echo $query;
            $consulta = $this->con->conect->query($query);
                            
            return $consulta;
            
        }
        
    }
    
    function get_logos_por_id($id_logo){
        
          $this->array_campos='';          
          $this->has_value=false;
            
          if($this->con->Conectarse()==true){
           $query="SELECT * FROM LOGOS WHERE L_ID = '$id_logo' ORDER BY L_NOMBRE;";
           
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
    
    function eliminar_logo($id){
        
        if($this->con->Conectarse()==true){
            $query = "DELETE FROM LOGOS WHERE L_ID = $id";
            //echo $query;
            $consulta = $this->con->conect->query($query);
                            
            return $consulta;
            
        }
        
    }
}

?>