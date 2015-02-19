<?php
include_once("connect_db.class.php");

class Categorias{
    
    var $con;
    
    var $insert_id;
    
    var $has_value;
    
    var $consulta;

    var $array_campos;
    
    var $resultado;
    
    var $cliente;

    function Categorias(){
        
        $this->con = new connect_db;
        
        $this->insert_id;
        
        $this->has_value = false;
        
        $this->consulta;

        $this->array_campos = Array();
        
        $this->resultado;
        
        $this->cliente;

    }
    
    function get_categorias(){
//        
          $this->array_campos='';          
          $this->has_value=false;
            
          if($this->con->Conectarse()==true){
           $query="SELECT * FROM CATEGORIAS ORDER BY CAT_ACTIVO DESC";
           
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
    
    function get_categorias_por_cliente($cliente){
//        
          $this->array_campos='';          
          $this->has_value=false;
            
          if($this->con->Conectarse()==true){
           $query="SELECT * FROM CATEGORIAS WHERE CAT_CLIENTE = $cliente";
           
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
    
    function get_categorias_activas_por_cliente($cliente){
//        
          $this->array_campos='';          
          $this->has_value=false;
            
          if($this->con->Conectarse()==true){
           $query="SELECT * FROM CATEGORIAS WHERE CAT_CLIENTE = $cliente AND CAT_ACTIVO = 1";
           
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
    
    function activar_categoria($id_categoria, $activo){
        
        if($this->con->Conectarse()==true){
            $query = "UPDATE CATEGORIAS SET CAT_ACTIVO = $activo WHERE CAT_ID = $id_categoria;";
            //echo $query;
            $consulta = $this->con->conect->query($query);

            return $consulta;
        }       
    }
    
    function crear_categoria($nombre,$descripcion,$cliente){
        if($this->con->Conectarse()==true){
            
            $query = "INSERT INTO CATEGORIAS (CAT_NOMBRE,CAT_DESCRIPCION,CAT_FECHACREACION,CAT_CLIENTE, CAT_ACTIVO) VALUES ( '$nombre','$descripcion','".date('Y/m/d H:i:s')."','$cliente','1')";
            //echo $query;
            $consulta = $this->con->conect->query($query);

            $this->insert_id=$this->con->conect->insert_id;

            return $consulta;
        }
    }
    
    function get_categoria($id_categoria){

          $this->array_campos='';          
          $this->has_value=false;
            
          if($this->con->Conectarse()==true){
           $query="SELECT * FROM CATEGORIAS WHERE CAT_ID=$id_categoria";
           
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
     function get_cat_nombre($nombre){

          $this->array_campos='';       
          $this->has_value=false;
            
          if($this->con->Conectarse()==true){
           $query="SELECT * FROM CATEGORIAS WHERE CAT_NOMBRE='$nombre'";
           
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
    function update_categoria($id, $nombre, $descripcion,  $cliente ){
        
        if($this->con->Conectarse()==true){
            $query = "UPDATE CATEGORIAS SET CAT_NOMBRE='$nombre',CAT_DESCRIPCION='$descripcion',CAT_CLIENTE='$cliente' WHERE CAT_ID='$id'";
            //echo $query;
            $consulta = $this->con->conect->query($query);
                            
            return $consulta;
            
        }
        
    }
    
    function get_categorias_activos(){
        
          $this->array_campos='';          
          $this->has_value=false;
            
          if($this->con->Conectarse()==true){
           $query="SELECT * FROM CATEGORIAS WHERE CAT_ACTIVO = 1 ORDER BY CAT_NOMBRE;";
           
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
    function get_categorias_por_id($id_categoria){
        
          $this->array_campos='';          
          $this->has_value=false;
            
          if($this->con->Conectarse()==true){
           $query="SELECT * FROM CATEGORIAS WHERE CAT_ID = '$id_categoria' ORDER BY CAT_NOMBRE;";
           
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