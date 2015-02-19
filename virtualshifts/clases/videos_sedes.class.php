<?php

include_once("connect_db.class.php");



class VideosSedes{

    var $con;

    var $has_value;
    
    var $consulta;
    
    var $array_campos;

    var $insert_id;
        

    function VideosSedes(){

        $this->con = new connect_db;

        $this->has_value = false;        
        
        $this->consulta;

        $this->array_campos = Array();

        $this->insert_id;

    }
    
    function get_videos_por_sede($sede){
    
        $this->array_campos = array();          
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){
            $query="SELECT VIS_VID_ID FROM VIDEOS_SEDES WHERE VIS_S_ID = $sede";
            
            //echo $query;            
            $this->consulta = $this->con->conect->query( $query );
            
            if($this->consulta->num_rows > 0){                
                $this->has_value = true;
                while($row = $this->consulta->fetch_assoc()){
                    $this->array_campos[] = $row['VIS_VID_ID'];
                }                
            }
            return $this->array_campos;
        }
    }
    
    function get_videos_por_sede_para_visor($sede, $id){
    
        $this->array_campos = array();          
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){
            $query="SELECT * FROM VIDEOS_SEDES INNER JOIN VIDEOS ON VIS_VID_ID = VID_ID WHERE VIS_S_ID = $sede AND VIS_VID_ID != $id";
            
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
    
    function delete_videos_por_sede($sede){
             
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){
            $query="DELETE FROM VIDEOS_SEDES WHERE VIS_S_ID = $sede";
            
            //echo $query;            
            $this->consulta = $this->con->conect->query( $query );
            return $this->consulta;
        }
    }
    
    function agregar_videos_por_sede($sede, $videos){
          
        $this->has_value = false;
        
        foreach($videos as $video){
            $datos[] = "($sede, $video)";
        }
        
        if($this->con->Conectarse()==true){
            $query="INSERT VIDEOS_SEDES (VIS_S_ID, VIS_VID_ID) VALUES ".join(",",$datos);            
            //echo $query;            
            $this->consulta = $this->con->conect->query( $query );
            return $this->consulta;
        }
    }
}

?>