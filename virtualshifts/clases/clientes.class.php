<?php
include_once("connect_db.class.php");

class Clientes{
    
    var $con;
    
    var $insert_id;
    
    var $has_value;
    
    var $consulta;

    var $array_campos;
    
    var $resultado;

    function Clientes(){
        
        $this->con = new connect_db;
        
        $this->insert_id;
        
        $this->has_value = false;
        
        $this->consulta;

        $this->array_campos = Array();
        
        $this->resultado;

    }
    
    function get_clientes(){
//        
          $this->array_campos='';          
          $this->has_value=false;
            
          if($this->con->Conectarse()==true){
           $query="SELECT * FROM CLIENTES";
           
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
    
    function activar_clientes($id_cliente, $activo){
        
        if($this->con->Conectarse()==true){
            $query = "UPDATE CLIENTES SET C_ACTIVO = $activo WHERE C_ID = $id_cliente;";
            //echo $query;
            $consulta = $this->con->conect->query($query);
                            
            return $consulta;
            
        }       
    }
    
    function crear_cliente($razon,$nit,$telefono,$direccion,$representante,$celular,$e_mail,$activo,$webservice,$metodo,$variable,$virtualpbax){
        
        if($this->con->Conectarse()==true){
            $query = "INSERT INTO CLIENTES (C_RAZON_SOCIAL,C_NIT,C_TELEFONO,C_DIRECCION,C_NOMBRE_REPRESENTANTE,C_CELULAR_REPRESENTANTE,C_FECHACREACION,C_CORREO_REPRESENTANTE,C_ACTIVO,C_URL_WEBSERVICE,C_METODO,C_VARIABLE,C_ID_VIRTUAL_PBAX) VALUES ('$razon','$nit','$telefono','$direccion','$representante','$celular','".date('Y/m/d H:i:s')."','$e_mail','$activo','$webservice', '$metodo','$variable','$virtualpbax')";
            //echo $query;
            $consulta = $this->con->conect->query($query);
            
            $this->insert_id=$this->con->conect->insert_id;
                         
            return $consulta;
            
        }
        
    }
    
    function get_client($id_client){

        $this->array_campos='';          
        $this->has_value=false;
            
        if($this->con->Conectarse()==true){
            $query="SELECT * FROM CLIENTES WHERE C_ID=$id_client";
           
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
    
    function get_clientes_ruta($cli_id){
        
          $this->array_campos='';          
          $this->has_value=false;
            
          if($this->con->Conectarse()==true){
           $query="SELECT * FROM CLIENTES WHERE C_ID IN ($cli_id)";
           
           //echo $query;            
           $this->consulta = $this->con->conect->query($query);
            
           if($this->consulta->num_rows > 0){                
                $this->has_value = true;
                
                while($campos = $this->consulta->fetch_assoc()){                    
                    $this->array_campos[] = $campos;
                }
            }
            return $this->array_campos;
        }
    }
    
    function get_client_razon($razon){

          $this->array_campos='';          
          $this->has_value=false;
            
          if($this->con->Conectarse()==true){
           $query="SELECT * FROM CLIENTES WHERE C_RAZON_SOCIAL='$razon'";
           
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
    
    function update_cliente($id_cliente,$razon,$nit,$direccion,$telefono,$representante,$e_mail,$celular,$webservice,$metodo,$variable,$virtualpbax){
        
        if($this->con->Conectarse()==true){
            $query = "UPDATE CLIENTES SET C_RAZON_SOCIAL='$razon',C_NIT='$nit',C_DIRECCION='$direccion',C_TELEFONO='$telefono',C_NOMBRE_REPRESENTANTE='$representante',C_CORREO_REPRESENTANTE='$e_mail',C_CELULAR_REPRESENTANTE='$celular', C_URL_WEBSERVICE='$webservice', C_METODO='$metodo',C_VARIABLE='$variable' ,C_ID_VIRTUAL_PBAX='$virtualpbax' WHERE C_ID=$id_cliente";
            //echo $query;
            $consulta = $this->con->conect->query($query);

            return $consulta;
        }
    }
    
    function get_clientes_activos(){
//        
          $this->array_campos='';          
          $this->has_value=false;
            
          if($this->con->Conectarse()==true){
           $query="SELECT * FROM CLIENTES WHERE C_ACTIVO = 1 ORDER BY C_RAZON_SOCIAL;";
           
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
    
    function get_clientes_activos_para_usuario(){
//        
          $this->array_campos='';          
          $this->has_value=false;
            
          if($this->con->Conectarse()==true){
           $query="SELECT C_ID, CLIENTES.C_RAZON_SOCIAL FROM CLIENTES INNER JOIN PERFILES ON PER_CLI_ID = C_ID INNER JOIN USUARIOS ON U_PER_ID = PER_ID WHERE C_ACTIVO = 1 GROUP BY C_ID ORDER BY CLIENTES.C_RAZON_SOCIAL ASC;";
           
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
    
    function get_mail_encargado_cliente($id_cliente){        
        $this->has_value=false;
        
        if($this->con->Conectarse()==true){
            $query="SELECT C_CORREO_REPRESENTANTE FROM CLIENTES WHERE C_ID=$id_cliente";
            
            //echo $query;            
            $this->consulta = $this->con->conect->query( $query );
            
            if($this->consulta->num_rows > 0){                
                $this->has_value = true;                
                
                $row = $this->consulta->fetch_assoc();
                $this->resultado = $row['C_CORREO_REPRESENTANTE'];
            }
            return $this->resultado;
        }
    }    
}

?>