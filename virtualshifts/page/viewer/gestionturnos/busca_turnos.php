<?php
ini_set("display_errors",1);

include_once("../../../clases/turnos.class.php");
include_once("../../../clases/historial_turnos.class.php");
include_once("../../../clases/ventanillas.class.php");
include_once("../../../clases/consumidores.class.php");
include_once("../../../clases/areas.class.php");
include_once("../../../clases/usuarios.class.php");

$sede = $_POST['sede'];
$nombre_sede = $_POST['nombre_sede'];

$objTurnos = new Turnos;
$objHistorialTurnos = new HistorialTurnos;
$objVentanillas = new Ventanillas;
$objAreas = new Areas;
$objConsumidores = new Consumidores;
$objUsuarios = new Users;

$i = 0;
$array_respuesta = array();

$objTurnos->get_turnos_sin_atender($sede,$nombre_sede);
if($objTurnos->has_value){
    foreach($objTurnos->array_campos as $turno){
        $objHistorialTurnos->get_turno_por_sede_area_turno_fecha($sede,$turno['ID_AREA'],$turno['ID'],date("Y-m-d"));
        if($objHistorialTurnos->has_value){
            ;
            if($objHistorialTurnos->array_campos['HT_VENT_ID'] != 0){
                $objVentanillas->get_ventanillas_por_id($objHistorialTurnos->array_campos['HT_VENT_ID']);
                $array_respuesta[$i]['datos_ventanilla'] = $objVentanillas->array_ventanillas;
                
                $objAreas->get_area_por_id($turno['ID_AREA']);
                $array_respuesta[$i]['datos_area'] = $objAreas->array_areas;
                
                $objUsuarios->get_user($turno['ID_ASESOR']);
                $array_respuesta[$i]['datos_asesor'] = $objUsuarios->array_usuarios;
                
                $objConsumidores->get_consumidor_por_id($turno['ID_CONSUMIDOR']);
                $array_respuesta[$i]['datos_consumidor'] = $objConsumidores->array_campos;
                
                $array_respuesta[$i]['datos_turno'] = $turno;
                
                $i++;
                
                if($i >= 3){
                    break;
                }                
            }
        }
    }
}

print_r(json_encode($array_respuesta));

?>