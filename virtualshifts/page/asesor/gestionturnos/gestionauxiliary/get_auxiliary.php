<?php
ini_set("display_errors",1);
session_start();

include_once("../../../../clases/auxiliaries.class.php");
include_once("../../../../clases/estado_asesores_historico.class.php");

$objAuxiliaries = new Auxiliaries;
$objEstadoAsesoresHistorico = new EstadoAsesoresHistorico;

$aux = $_POST['aux'];

$tiempo_aux_acumulado = 0;

$objAuxiliaries->get_auxiliary($aux);
if($objAuxiliaries->has_value){
    $array_respuesta['status'] = 'success';
    $array_respuesta['datos'] = $objAuxiliaries->array_campos;
    
    $objEstadoAsesoresHistorico->get_estado_asesor_por_fecha_asesor_aux(date("Y-m-d"),"auxiliary",$aux,$_SESSION['u_id']);
    if($objEstadoAsesoresHistorico->has_value){
        foreach($objEstadoAsesoresHistorico->array_campos as $row){            
            $tiempo_aux_acumulado = $tiempo_aux_acumulado + $row['DIFERENCIA_TIEMPO'];
        }
    }    
    $objEstadoAsesoresHistorico->crea_estado_asesor(date("Y-m-d"),date("H:i:s"),"00:00:00","auxiliary",$aux,$_SESSION['u_id']);
    
    $array_respuesta['tiempo_acumulado'] = $tiempo_aux_acumulado;
    
}else{
    $array_respuesta['status'] = 'error';
    $array_respuesta['datos'] = array();
    $array_respuesta['tiempo_acumulado'] = 0;
}

print_r(json_encode($array_respuesta));
?>