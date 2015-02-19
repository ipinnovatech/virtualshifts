<?php
ini_set('memory_limit', '-1');
include_once("connect_db.class.php");

class HistorialTurnos{

    var $con;

    var $has_value;
    
    var $consulta;
    
    var $array_campos;

    var $insert_id;
    
    var $total;        

    function HistorialTurnos(){

        $this->con = new connect_db;

        $this->has_value = false;        
        
        $this->consulta;

        $this->array_campos = Array();

        $this->insert_id;
        
        $this->total;

    }
    
    function get_turnos(){
    
        $this->array_campos = array();          
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){
            $query="SELECT * FROM HISTORIAL_TURNOS";
            
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
    
    function get_reporte_turno($fecha_inicio,$fecha_fin, $cliente){
        $this->array_campos = array();          
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){
            $query="SELECT HT_FECHACREACION AS 'FECHA', 
                        CONCAT(AR_ALIAS,HT_TURNO) AS 'TURNO', 
                        HT_HORA_CREACION AS 'HORA_CREACION', 
                        HT_HORA_ASIGNACION AS 'HORA_ASIGNACION',
                        HT_INICIO_ATENCION AS 'HORA_INICIO',
                        IF(HT_INICIO_ATENCION = '00:00:00', 'NO ATIENDE', TIMEDIFF(HT_INICIO_ATENCION, HT_HORA_ASIGNACION)) AS TIEMPO_EN_ESPERA, 
                        HT_FIN_ATENCION AS 'HORA_FIN',
                        IF(HT_FIN_ATENCION = '00:00:00', 'TURNO ABIERTO', TIMEDIFF(HT_FIN_ATENCION, HT_INICIO_ATENCION)) AS TIEMPO_EN_TURNO,
                        CO_NOMBRE AS 'NOMBRE_COLABORADOR' , 
                        CO_CEDULA AS 'CEDULA' , 
                        CO_TELEFONO AS 'CELULAR' , 
                        CO_CORREO AS 'CORREO' , 
                        CO_CAMPO1 AS 'EMPRESA' , 
                        S_NOMBRE AS 'REGIONAL' , 
                        CO_CAMPO2 AS 'CLIENTE' , 
                        AR_NOMBRE AS 'PROCESO' ,
                        CT_NOMBRE AS 'CODIGO_TERMINACION',
                        HT_OBSERVACIONES AS 'OBSERVACIONES',
                        HT_RESUMEN_TURNO AS 'DESCRIPCION', 
                        CO_CAMPO4 AS 'DOCUMENTOS_RECIBIDOS' , 
                        CO_CAMPO5 AS 'DOCUMENTOS_ENTREGADOS',
                        CONCAT(U_NOMBRE, ' ', U_APELLIDOS) AS 'NOMBRE_ASESOR',
                        CAT_NOMBRE AS 'CATEGORIA',
                        CT_NOMBRE AS 'CODIGO_TERMINACION'
                    FROM HISTORIAL_TURNOS 
                        INNER JOIN SEDES ON S_ID = HT_S_ID 
                        INNER JOIN CONSUMIDORES ON CO_ID = HT_CONSUMIDOR 
                        INNER JOIN AREAS ON AR_ID = HT_AR_ID
                        LEFT JOIN CODIGOS_TERMINACION ON CT_ID = HT_CODIGO_TERMINACION
                        LEFT JOIN CATEGORIAS_CODIGOS_TERMINACION ON CATCT_CT_ID = CT_ID
                        LEFT JOIN CATEGORIAS ON CATCT_CAT_ID = CAT_ID
                        INNER JOIN USUARIOS ON HT_GESTIONADOR = U_ID
                    WHERE U_CLI_ID = '$cliente'
                    AND DATE(HT_FECHACREACION) BETWEEN '$fecha_inicio' AND '$fecha_fin'
                    GROUP BY FECHA, TURNO, S_NOMBRE 
                    ORDER BY FECHA, HORA_CREACION";
            
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
    
    function get_turno_por_id($id){
    
        $this->array_campos = array();          
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){
            $query="SELECT * FROM HISTORIAL_TURNOS WHERE HT_ID = $id";
            
            //echo $query;            
            $this->consulta = $this->con->conect->query( $query );
            
            if($this->consulta->num_rows > 0){                
                $this->has_value = true;
                $row = $this->consulta->fetch_assoc();
                $this->array_campos = $row;
            }
            return $this->array_campos;
        }
    }
    
    function get_turno_por_sede_area_turno_fecha($sede, $area, $turno, $fecha_creacion){
    
        $this->array_campos = array();          
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){
            $query="SELECT * FROM HISTORIAL_TURNOS WHERE HT_S_ID = $sede AND HT_AR_ID = $area AND HT_TURNO = $turno AND DATE(HT_FECHACREACION) = '$fecha_creacion'";
            
            //echo $query;            
            $this->consulta = $this->con->conect->query( $query );
            
            if($this->consulta->num_rows > 0){                
                $this->has_value = true;
                $row = $this->consulta->fetch_assoc();
                $this->array_campos = $row;
            }
            return $this->array_campos;
        }
    }
    
    function crear_turno($sede, $area, $turno, $creador, $consumidor, $hora_creacion, $observaciones){
    
        $this->array_areas = array();
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){
            $query="INSERT INTO HISTORIAL_TURNOS(HT_S_ID, HT_AR_ID, HT_TURNO, HT_CREADOR, HT_CONSUMIDOR, HT_HORA_CREACION, HT_FECHACREACION, HT_OBSERVACIONES) VALUES ($sede, $area, $turno, $creador, $consumidor, '$hora_creacion', '".date("Y-m-d H:i:s")."', '$observaciones')";
            //echo $query;
            $this->consulta = $this->con->conect->query( $query );
            $this->insert_id = $this->con->conect->insert_id;
            return $this->consulta;
        }
    }
    
    function asignacion_turno($sede, $area, $turno, $fecha_creacion, $ventanilla, $gestionador, $hora_atencion){
    
        $this->array_areas = array();
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){
            $query="UPDATE HISTORIAL_TURNOS SET HT_VENT_ID = $ventanilla, HT_GESTIONADOR = $gestionador, HT_HORA_ASIGNACION = '$hora_atencion' WHERE HT_S_ID = $sede AND HT_AR_ID = $area AND HT_TURNO = $turno AND DATE(HT_FECHACREACION) = '$fecha_creacion'";
            //echo $query;
            $this->consulta = $this->con->conect->query( $query );
            return $this->consulta;
        }
    }
    
    function inicio_atencion_turno($hora_atencion, $id){
    
        $this->array_areas = array();
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){
            $query="UPDATE HISTORIAL_TURNOS SET HT_INICIO_ATENCION = '$hora_atencion' WHERE HT_ID = $id";
            //echo $query;
            $this->consulta = $this->con->conect->query( $query );
            return $this->consulta;
        }
    }
    
    function fin_atencion_turno($id, $hora_fin, $codigo, $resumen){
    
        $this->array_areas = array();
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){
            $query="UPDATE HISTORIAL_TURNOS SET HT_FIN_ATENCION = '$hora_fin', HT_CODIGO_TERMINACION = $codigo, HT_RESUMEN_TURNO = '$resumen' WHERE HT_ID = $id";
            //echo $query;
            $this->consulta = $this->con->conect->query( $query );
            return $this->consulta;
        }
    }
}

?>