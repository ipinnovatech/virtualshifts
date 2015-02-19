<?php
ini_set("display_errors",1);
session_start();

include_once("../../../../clases/categorias_codigos_terminacion.class.php");

$objCategoriasCodigos = new CategoriasCodigos_terminacion;

$categoria = $_POST['categoria'];

$objCategoriasCodigos->get_codigos_terminacion_por_categoria_para_portal($categoria);

$html = '<option value="0">Seleccione ...</option>';

if($objCategoriasCodigos->has_value){
    foreach($objCategoriasCodigos->array_campos as $codigo){
        $html .= '<option value="'.$codigo['CT_ID'].'">'.$codigo['CT_NOMBRE'].'</option>';
    }
}

echo $html;
?>