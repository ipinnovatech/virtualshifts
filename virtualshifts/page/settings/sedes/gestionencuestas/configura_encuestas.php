<?php
ini_set("display_errors", 1);

include_once("../../../../clases/configuracion_encuestas_virtual_pbax.class.php");

$objConfiguracionEncuestas = new ConfiguracionEncuestasVirtualPBAX;

$sede = $_POST['id_sede'];
$crea = $_POST['crea'];

$lunes = $_POST['lunes'];
$martes = $_POST['martes'];
$miercoles = $_POST['miercoles'];
$jueves = $_POST['jueves'];
$viernes = $_POST['viernes'];
$sabado = $_POST['sabado'];
$domingo = $_POST['domingo'];

$lista = $_POST['lista'];
$nombre = $_POST['nombre'];
$celular = $_POST['celular'];
$fijo = $_POST['fijo'];
$auxiliar = $_POST['auxiliar'];
$correo = $_POST['correo'];
$var1 = $_POST['var1'];
$var2 = $_POST['var2'];
$var3 = $_POST['var3'];

if($crea == 1){
    if($objConfiguracionEncuestas->crear_configuracion_encuesta_por_sede($sede, $lunes, $martes, $miercoles, $jueves, $viernes, $sabado, $domingo, $lista, $nombre, $celular, $fijo, $auxiliar, $correo, $var1, $var2, $var3)){
        echo "success";
        exit;
    }else{
        echo "error";
        exit;
    }
}else{
    if($objConfiguracionEncuestas->actualizar_configuracion_encuesta_por_sede($sede, $lunes, $martes, $miercoles, $jueves, $viernes, $sabado, $domingo, $lista, $nombre, $celular, $fijo, $auxiliar, $correo, $var1, $var2, $var3)){
        echo "success";
        exit;
    }else{
        echo "error";
        exit;
    }
}

?>