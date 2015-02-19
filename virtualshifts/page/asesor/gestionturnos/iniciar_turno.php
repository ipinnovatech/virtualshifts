<?php 
ini_set("display_errors",1);
ini_set('max_execution_time', 300);

include_once ("../../../clases/historial_turnos.class.php");

$objHistorialTurnos = new HistorialTurnos;

$id_turno = $_POST['id_turno'];

$objHistorialTurnos->inicio_atencion_turno(date("H:i:s"),$id_turno);

$array_respuesta['status'] = "success";

print_r(json_encode($array_respuesta));
?>