<?php
ini_set("display_errors",1);

include_once("../../../clases/ventanillas_areas.class.php");

$objVentanillasAreas = new VentanillasAreas;

$ventanilla = $_POST['ventanilla'];


$objVentanillasAreas->get_areas_por_ventanilla_full($ventanilla);

$html = '';

if($objVentanillasAreas->has_value){
    foreach($objVentanillasAreas->array_areas as $row){
        
        $html .= '<tr>';
        $html .= '<td>'.$row['AR_ID'].'</td>';
        $html .= '<td>'.$row['AR_NOMBRE'].'</td>';
        $html .= '<td><select id="prioridades" name="prioridades['.$row['AR_ID'].']">';
        $html .= '<option value="0" '.(($row['VEA_PRIORIDAD']== 0)?'selected="selected"':'').' >Baja</option>';
        $html .= '<option value="1" '.(($row['VEA_PRIORIDAD']== 1)?'selected="selected"':'').' >Media</option>';
        $html .= '<option value="2" '.(($row['VEA_PRIORIDAD']== 2)?'selected="selected"':'').' >Alta</option>';
        $html .= '</select></td>';
        $html .= '</tr>';
        
    }
}
echo $html;
?>