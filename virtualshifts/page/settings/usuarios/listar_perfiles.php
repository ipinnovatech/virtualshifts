<?php 
ini_set("dispaly_errors",1);

include_once("../../../clases/perfiles.class.php");

$cliente = $_POST['cliente'];

$objPerfiles = new Perfiles;

$objPerfiles->get_perfiles_acivos_por_cliente($cliente);

$html = '<option value="0">Seleccione ...</option>';

if($objPerfiles->has_value){
    foreach($objPerfiles->array_campos as $row){
        $html .= '<option value="'.$row['PER_ID'].'" >'.$row['PER_NOMBRE'].'</option>';
    }
}

echo $html;

?>