<?php
ini_set("display_errors", 1);
session_start();

include_once("../../../clases/areas.class.php");
include_once("../../../clases/sedes.class.php");

$objAreas = new Areas;
$objSedes = new Sedes;

$nombre = $_POST['nombre'];
$descrip = $_POST['descrip'];
$alias = $_POST['alias'];

if($objAreas->crear_area($nombre, $descrip, $_SESSION['cliente'], $alias)){
    
    $objSedes->get_sedes($_SESSION['cliente']);
    if($objSedes->has_value){
        foreach($objSedes->array_sedes as $row){
            $objSedes->get_tabla_turnos_sede($row['S_ID'],$row['S_NOMBRE']);
            if($objSedes->result == 1){
                $areas = array();
                $objAreas->get_areas($_SESSION['cliente']);
                if($objAreas->has_value){
                    foreach($objAreas->array_areas as $fila){
                        $areas[] = "'{$fila['AR_ID']}'";
                    }
                }
                $objSedes->agregar_area_en_sede($row['S_ID'],$row['S_NOMBRE'],$areas);
            }
        }
    }
    
    
    echo "success";
    exit;
}else{
    echo "error";
    exit;
}
?>