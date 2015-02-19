<?php 
ini_set("display_errors",1);
ini_set('max_execution_time', 300);
header('Content-Type: text/html; charset=iso-8859-1'); 

session_start();

include_once ("../../../clases/usuarios.class.php");
include_once ("../../../clases/ventanillas_areas.class.php");
include_once ("../../../clases/ventanillas.class.php");
include_once ("../../../clases/sedes.class.php");
include_once ("../../../clases/turnos.class.php");
include_once ("../../../clases/historial_turnos.class.php");
include_once ("../../../clases/areas.class.php");
include_once ("../../../clases/consumidores.class.php");

$objUsuarios = new Users;
$objVentanillasAreas = new VentanillasAreas;
$objVentanillas = new Ventanillas;
$objSedes = new Sedes;
$objTurnos = new Turnos;
$objHistorialTurnos = new HistorialTurnos;
$objAreas = new Areas;
$objConsumidores = new Consumidores;

$objUsuarios->get_ventanilla_y_sede_por_asesor($_SESSION['u_id']);
$ventanilla = $objUsuarios->ventanillas;
$sede = $objUsuarios->sede;

$objSedes->get_sede_por_id($sede);
$array_sede = $objSedes->array_sedes;

$array_tables = array("TURNOS_SEDE_".strtoupper($array_sede['S_NOMBRE'])."_$sede WRITE", "HISTORIAL_TURNOS WRITE");
$objTurnos->lock_tables($array_tables);

$objTurnos->get_turno_por_usuario($sede, $array_sede['S_NOMBRE'],$_SESSION['u_id']);
$array_turno = $objTurnos->array_campos;

if(count($array_turno) == 0){
    
    $objVentanillasAreas->get_areas_por_ventanilla_con_prioridad_alta($ventanilla);
    $array_areas = $objVentanillasAreas->array_areas;
    
    if(count($array_areas) > 0){
        //while(count($array_areas) > 0){
            //$rand = rand(0, count($array_areas) -1);
//            $area = $array_areas[$rand];
            
            $objTurnos->get_turnos_sin_atender_por_areas($sede, $array_sede['S_NOMBRE'], join(',',$array_areas));
            if($objTurnos->has_value){
                $turno = $objTurnos->array_campos[0];
                $area = $turno['ID_AREA'];
                $objHistorialTurnos->asignacion_turno($sede,$area,$turno['ID'],date("Y-m-d"),$ventanilla,$_SESSION['u_id'],date("H:i_s"));
                $objTurnos->inicia_atencion($sede, $array_sede['S_NOMBRE'], $area, $turno['ID'], $_SESSION['u_id']);
                
                $objHistorialTurnos->get_turno_por_sede_area_turno_fecha($sede,$area,$turno['ID'],date("Y-m-d"));
                
                $objConsumidores->get_consumidor_por_id($turno['ID_CONSUMIDOR']);
                
                $objAreas->get_area_por_id($area);
                
                $array_respuesta['status'] = 'success';
                $array_respuesta['datos_turno'] = $objHistorialTurnos->array_campos;
                $array_respuesta['datos_consumidor'] = $objConsumidores->array_campos;
                $array_respuesta['datos_area'] = $objAreas->array_areas;
                $array_respuesta['tiempo_turno'] = 0;
                
                //break;
            }//else{
//                unset($array_areas[$rand]);
//                $array_areas = array_values($array_areas);
//            }
        //}
    }
    
    $objVentanillasAreas->get_areas_por_ventanilla_con_prioridad_media($ventanilla);
    $array_areas = $objVentanillasAreas->array_areas;
    
    if(count($array_areas) > 0){
        //while(count($array_areas) > 0){
            //$rand = rand(0, count($array_areas) -1);
//            $area = $array_areas[$rand];
            
            $objTurnos->get_turnos_sin_atender_por_areas($sede, $array_sede['S_NOMBRE'], join(',',$array_areas));
            if($objTurnos->has_value){
                $turno = $objTurnos->array_campos[0];
                $area = $turno['ID_AREA'];
                $objHistorialTurnos->asignacion_turno($sede,$area,$turno['ID'],date("Y-m-d"),$ventanilla,$_SESSION['u_id'],date("H:i_s"));
                $objTurnos->inicia_atencion($sede, $array_sede['S_NOMBRE'], $area, $turno['ID'], $_SESSION['u_id']);
                
                $objHistorialTurnos->get_turno_por_sede_area_turno_fecha($sede,$area,$turno['ID'],date("Y-m-d"));
                
                $objConsumidores->get_consumidor_por_id($turno['ID_CONSUMIDOR']);
                
                $objAreas->get_area_por_id($area);
                
                $array_respuesta['status'] = 'success';
                $array_respuesta['datos_turno'] = $objHistorialTurnos->array_campos;
                $array_respuesta['datos_consumidor'] = $objConsumidores->array_campos;
                $array_respuesta['datos_area'] = $objAreas->array_areas;
                $array_respuesta['tiempo_turno'] = 0;
                
                //break;
            }//else{            
//                unset($array_areas[$rand]);
//                $array_areas = array_values($array_areas);
//            }
        //}
    }
    
    $objVentanillasAreas->get_areas_por_ventanilla_con_prioridad_baja($ventanilla);
    $array_areas = $objVentanillasAreas->array_areas;
    //print_r($array_areas);
    if(count($array_areas) > 0){
        //while(count($array_areas) > 0){
            //$rand = rand(0, count($array_areas) -1);
//            $area = $array_areas[$rand];
            
            $objTurnos->get_turnos_sin_atender_por_areas($sede, $array_sede['S_NOMBRE'], join(',',$array_areas));
            if($objTurnos->has_value){
                $turno = $objTurnos->array_campos[0];
                $area = $turno['ID_AREA'];
                $objHistorialTurnos->asignacion_turno($sede,$area,$turno['ID'],date("Y-m-d"),$ventanilla,$_SESSION['u_id'],date("H:i_s"));
                $objTurnos->inicia_atencion($sede, $array_sede['S_NOMBRE'], $area, $turno['ID'], $_SESSION['u_id']);
                
                $objHistorialTurnos->get_turno_por_sede_area_turno_fecha($sede,$area,$turno['ID'],date("Y-m-d"));
                
                $objConsumidores->get_consumidor_por_id($turno['ID_CONSUMIDOR']);
                
                $objAreas->get_area_por_id($area);
                
                $array_respuesta['status'] = 'success';
                $array_respuesta['datos_turno'] = $objHistorialTurnos->array_campos;
                $array_respuesta['datos_consumidor'] = $objConsumidores->array_campos;
                $array_respuesta['datos_area'] = $objAreas->array_areas;
                $array_respuesta['tiempo_turno'] = 0;
                
                //break;
            }//else{            
//                unset($array_areas[$rand]);
//                $array_areas = array_values($array_areas);
//            }
        //}
    }    
    
    if(count($array_areas) == 0){        
        $array_respuesta['status'] = 'sin_turnos';
    }
    
}else{
    $objHistorialTurnos->get_turno_por_sede_area_turno_fecha($sede,$array_turno['ID_AREA'],$array_turno['ID'],date("Y-m-d"));
            
    $objConsumidores->get_consumidor_por_id($array_turno['ID_CONSUMIDOR']);
    
    $objAreas->get_area_por_id($array_turno['ID_AREA']);
    
    $array_respuesta['status'] = 'success';
    $array_respuesta['datos_turno'] = $objHistorialTurnos->array_campos;
    $array_respuesta['datos_consumidor'] = $objConsumidores->array_campos;
    $array_respuesta['datos_area'] = $objAreas->array_areas;
    
    if($objHistorialTurnos->array_campos['HT_INICIO_ATENCION'] == "00:00:00"){
        $array_respuesta['tiempo_turno'] = 0;
    }else{
        $array_respuesta['tiempo_turno'] = strtotime(date("H:i:s")) - strtotime($objHistorialTurnos->array_campos['HT_INICIO_ATENCION']);
    }
}

$objVentanillasAreas->get_areas_por_ventanilla($ventanilla);
if($objVentanillasAreas->has_value){
    $objTurnos->get_total_turnos_sin_atender_por_sede_y_areas($sede, $array_sede['S_NOMBRE'], join(",", $objVentanillasAreas->array_areas));
    $array_respuesta['turnos_sin_atender'] = $objTurnos->result;
}else{
    $array_respuesta['turnos_sin_atender'] = 0;
}

sleep(1);

$objTurnos->get_turno_por_usuario($sede, $array_sede['S_NOMBRE'],$_SESSION['u_id']);
$array_turno = $objTurnos->array_campos;

if(count($array_turno) == 0){
    $array_respuesta['status'] = 'error';
    $array_respuesta['datos_turno'] = array();
    $array_respuesta['datos_consumidor'] = array();
    $array_respuesta['datos_area'] = array();
    $array_respuesta['tiempo_turno'] = 0; 
}

$objTurnos->unlock_tables();

print_r(json_encode($array_respuesta));
?>