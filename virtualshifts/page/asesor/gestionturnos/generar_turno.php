<?php
ini_set("display_errors",1);
header('Content-Type: text/html; charset=iso-8859-1'); 
session_start();

include_once("../../../clases/consumidores.class.php");
include_once("../../../clases/usuarios.class.php");
include_once("../../../clases/turnos.class.php");
include_once("../../../clases/sedes.class.php");
include_once("../../../clases/areas.class.php");
include_once("../../../clases/historial_turnos.class.php");

$objConsumidores = new Consumidores;
$objUsuarios = new Users;
$objTurnos = new Turnos;
$objSedes = new Sedes;
$objAreas = new Areas;
$objHistorialTurnos = new HistorialTurnos;

$cedula = $_POST['cedula'];
$nombre = $_POST['nombre'];
$direccion = $_POST['direccion'];
$telefono = $_POST['telefono'];
$mail = $_POST['mail'];
$campo1 = isset($_POST['campo1'])?$_POST['campo1']:'';
$campo2 = isset($_POST['campo2'])?$_POST['campo2']:'';
$campo3 = isset($_POST['campo3'])?$_POST['campo3']:'';
$campo4 = isset($_POST['campo4'])?$_POST['campo4']:'';
$campo5 = isset($_POST['campo5'])?$_POST['campo5']:'';
$cliente = $_SESSION['cliente'];
$area = $_POST['area'];
$observacion = $_POST['observacion'];

$objConsumidores->crear_consumidor($nombre, $cedula, $direccion, $telefono, $mail, $campo1, $campo2, $campo3, $campo4, $campo5, $cliente);
$id_consumidor = $objConsumidores->insert_id;

$objUsuarios->get_sede_por_asesor($_SESSION['u_id']);
$id_sede = $objUsuarios->ventanillas;

$objSedes->get_sede_por_id($id_sede);
$array_sede = $objSedes->array_sedes;

$objAreas->get_area_por_id($area);
$array_area = $objAreas->array_areas;

$objTurnos->crear_turno($id_sede, $array_sede['S_NOMBRE'], $area, $id_consumidor);
$turno = $objTurnos->insert_id;

if($objHistorialTurnos->crear_turno($id_sede,$area,$turno,$_SESSION['u_id'],$id_consumidor,date("H:i:s"),$observacion)){
    $arra_respuesta['status'] = "success";
    $arra_respuesta['turno'] = $turno;
    $arra_respuesta['area'] = $array_area['AR_ALIAS'];
}else{
    $arra_respuesta['status'] = "error";
    $arra_respuesta['turno'] = 0;
    $arra_respuesta['area'] = '';
}

print_r(json_encode($arra_respuesta));
?>
