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
include_once ("../../../clases/herramientas.class.php");
include_once ("../../../clases/configuracion_encuestas_virtual_pbax.class.php");
include_once ("../../../clases/usuario_para_encuesta.class.php");
include_once ("../../../clases/encuestas.class.php");

$objUsuarios = new Users;
$objVentanillasAreas = new VentanillasAreas;
$objVentanillas = new Ventanillas;
$objSedes = new Sedes;
$objTurnos = new Turnos;
$objHistorialTurnos = new HistorialTurnos;
$objAreas = new Areas;
$objConsumidores = new Consumidores;
$objConfiguracionEncuestas = new ConfiguracionEncuestasVirtualPBAX;
$objHerramientas = new Herramientas;
$objUsuarioParaEncuesta = new UsuariosParaEncuesta;
$objEncuestas = new Encuestas;

$area = $_POST['id_area'];
$nombre = $_POST['nombre'];
$cedula = $_POST['cedula'];
$direccion = $_POST['direccion'];
$telefono = $_POST['telefono'];
$mail = $_POST['mail'];
$observaciones = $_POST['observaciones'];
$codigo = $_POST['codigo'];
$campo1 = trim($_POST['campo1']);
$campo2 = trim($_POST['campo2']);
$campo3 = trim($_POST['campo3']);
$campo4 = trim($_POST['campo4']);
$campo5 = trim($_POST['campo5']);
$resumen = trim($_POST['resumen']);

$turno = $_POST['num_turno'];
$id_turno = $_POST['id_turno'];
$id_consumidor = $_POST['id_consumidor'];

$objUsuarios->get_ventanilla_y_sede_por_asesor($_SESSION['u_id']);
$ventanilla = $objUsuarios->ventanillas;
$sede = $objUsuarios->sede;

$objSedes->get_sede_por_id($sede);
$array_sede = $objSedes->array_sedes;

$objConfiguracionEncuestas->get_configuracion_encuesta_por_sede($sede);
$objHerramientas->obtener_dia_semana_espanol(date("w"));
$dia_semana = $objHerramientas->resultado;

$cantidad_encuestas_para_el_dia = $objConfiguracionEncuestas->array_campos['CEVPS_CANTIDAD_'.$dia_semana];

$objUsuarioParaEncuesta->get_total_encuestas_por_sede_y_fecha($sede, date("Y-m-d"));
$total_encuestas_hoy = $objUsuarioParaEncuesta->total;

if(strlen($telefono) == 10){
    if($cantidad_encuestas_para_el_dia > $total_encuestas_hoy){
        $hace_encuesta = rand(0,1);
        //echo $hace_encuesta; exit;
        if($hace_encuesta == 1){
            $objUsuarioParaEncuesta->get_total_encuestas_en_el_mes_por_cedula($cedula);
            
            $objEncuestas->get_total_encuestas_por_mes_por_cedula($cedula);
            
            if($objUsuarioParaEncuesta->total == 0 && $objEncuestas->total == 0){
                $objUsuarioParaEncuesta->crear_usuario_para_encuesta($id_consumidor,date("Y-m-d"), date("H:i:s", strtotime("+5 minutes")), $sede);
            }
        }
    }
}


$objTurnos->cerrar_turno($sede, $array_sede['S_NOMBRE'],$turno, $area);
$objConsumidores->actualizar_consumidor($id_consumidor,$nombre,$cedula,$direccion,$telefono,$mail,$campo1,$campo2,$campo3,$campo4,$campo5);
$objHistorialTurnos->fin_atencion_turno($id_turno,date("H:i:s"),$codigo,$resumen);

$array_respuesta['status'] = "success";

print_r(json_encode($array_respuesta));
?>