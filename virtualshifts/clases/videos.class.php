<?php

include_once("connect_db.class.php");



class Videos{

    var $con;

    var $has_value;
    
    var $consulta;
    
    var $array_videos;
    
    var $result;

    var $insert_id;        

    function Videos(){

        $this->con = new connect_db;

        $this->has_value = false;        
        
        $this->consulta;

        $this->array_videos = Array();

        $this->insert_id;
        
        $this->result;

    }
    
    function get_videos($id_cliente){
    
        $this->array_videos = array();          
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){
            $query="SELECT * FROM VIDEOS WHERE VID_CLI_ID = $id_cliente ORDER BY VID_ACTIVO DESC";
            
            //echo $query;            
            $this->consulta = $this->con->conect->query( $query );
            
            if($this->consulta->num_rows > 0){                
                $this->has_value = true;
                while($row = $this->consulta->fetch_assoc()){
                    $this->array_videos[] = $row;
                }                
            }
            return $this->array_videos;
        }
    }
    
    function get_videos_activos($id_cliente){
    
        $this->array_videos = array();          
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){
            $query="SELECT * FROM VIDEOS WHERE VID_CLI_ID = $id_cliente AND VID_ACTIVO = 1";
            
            //echo $query;            
            $this->consulta = $this->con->conect->query( $query );
            
            if($this->consulta->num_rows > 0){                
                $this->has_value = true;
                while($row = $this->consulta->fetch_assoc()){
                    $this->array_videos[] = $row;
                }                
            }
            return $this->array_videos;
        }
    }
    
    function get_total_videos_activos($id_cliente){
    
        $this->result = 0;          
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){
            $query="SELECT COUNT(*) AS TOTAL FROM VIDEOS WHERE VID_CLI_ID = $id_cliente AND VID_ACTIVO = 1";
            
            //echo $query;            
            $this->consulta = $this->con->conect->query( $query );
            
            if($this->consulta->num_rows > 0){                
                $this->has_value = true;
                $row = $this->consulta->fetch_assoc();
                $this->result = $row['TOTAL'];               
            }
            return $this->result;
        }
    }
        
    function get_video_por_id($id){
    
        $this->array_videos = array();          
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){
            $query="SELECT * FROM VIDEOS WHERE VID_ID = $id";
            
            //echo $query;            
            $this->consulta = $this->con->conect->query( $query );
            
            if($this->consulta->num_rows > 0){                
                $this->has_value = true;
                $row = $this->consulta->fetch_assoc();
                $this->array_videos = $row;
            }
            return $this->array_videos;
        }
    }
    
    function crear_video($descrip, $cliente, $url, $activo){
    
        $this->array_areas = array();          
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){            
            $query="INSERT INTO VIDEOS(VID_DESCRIPCION, VID_CLI_ID, VID_URL, VID_ACTIVO, VID_FECHACREACION) VALUES ('$descrip', $cliente, '$url', $activo, '".date("Y-m-d- H:i:s")."');";
            //echo $query;            
            $this->consulta = $this->con->conect->query( $query );
            $this->insert_id = $this->con->conect->insert_id;
            return $this->consulta;             
        }
    }
    
    function activar_video($id, $activo){            
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){            
            $query="UPDATE VIDEOS SET VID_ACTIVO = $activo WHERE VID_ID = $id";
            //echo $query;            
            $this->consulta = $this->con->conect->query( $query );
            return $this->consulta; 
        }
    }
    
    function actualizar_video($id, $descrip){             
        if($this->con->Conectarse()==true){            
            $query="UPDATE VIDEOS SET VID_DESCRIPCION = '$descrip' WHERE VID_ID = $id";
            //echo $query;            
            $this->consulta = $this->con->conect->query( $query );
            return $this->consulta; 
        }
    }
    
    function eliminar_video($id){             
        if($this->con->Conectarse()==true){            
            $query="DELETE FROM VIDEOS WHERE VID_ID = $id";
            //echo $query;            
            $this->consulta = $this->con->conect->query( $query );
            return $this->consulta; 
        }
    }
}

?>