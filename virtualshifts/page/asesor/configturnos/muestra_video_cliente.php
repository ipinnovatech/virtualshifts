<?php
ini_set("display_errors",1);

include_once("../../../clases/clientes.class.php");
include_once("../../../clases/perfiles.class.php");

$objClientes = new Clientes;
$objPerfiles = new Perfiles;

$cliente = $_POST['cliente'];

$objClientes->get_client($cliente);
$html = '<option value="0">Seleccionar ...</option>';

if($objClientes->has_value){
    $array_resultado['datos'] = $objClientes->array_campos;
    
    $objPerfiles->get_perfiles_acivos_por_cliente($cliente);
    if($objPerfiles->has_value){
        foreach($objPerfiles->array_campos as $row){
            $html .= '<option value="'.$row['PER_ID'].'">'.$row['PER_NOMBRE'].'</option>';
        }
    }
    
}else{
    $array_resultado = array();
}

$array_resultado['html'] = $html;

print_r(json_encode($array_resultado));
?>