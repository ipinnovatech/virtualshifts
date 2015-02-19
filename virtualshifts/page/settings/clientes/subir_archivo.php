<?php
ini_set("display_errors",true);
include("../../../clases/PHPExcel/Reader/Excel2007.php");
include("../../../clases/clientes.class.php");
include("../../../clases/perfiles.class.php");

//print_r($_FILES);
//exit;
$nombre_archivo= $_FILES['fileupload']['name'];
$tipo_archivo= $_FILES['fileupload']['type'];
$tamano_archivo = $_FILES['fileupload']['size'];
$rutaArchivo = "lista_archivos/".$nombre_archivo;

$objClientes = new Clientes;
$objPerfiles = new Perfiles;

$fecha=date("Y-m-d H:i:s");
$cuenta=0;
$clientes_viejos='';

 if (move_uploaded_file($_FILES['fileupload']['tmp_name'],'lista_archivos/'.$nombre_archivo)){ 
    
        $objReader = (strpos($rutaArchivo,".xlsx"))?PHPExcel_IOFactory::createReader('Excel2007'):PHPExcel_IOFactory::createReader('Excel5');
        $objReader->setReadDataOnly(true);
        
        $objPHPExcel = $objReader->load("lista_archivos/".$nombre_archivo);
        $objWorksheet = $objPHPExcel->getActiveSheet();
        
        $objClientes->get_clientes();
        if($objClientes->has_value){
            foreach($objClientes->array_campos as $row){
                $clientes_viejos[]=$row['C_RAZON_SOCIAL'];
            }
        }
        
        foreach ($objWorksheet->getRowIterator() as $row) {
        
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false); // This loops all cells,

            foreach ($cellIterator as $cell){
                $contactos_temp[] = $cell->getValue();
            }
            
            if(isset($contactos_temp) && $cuenta>0)
                $clientes[]=$contactos_temp;          
            
            unset($contactos_temp);
            $cuenta++;           
        }
        
        if(sizeof($clientes)>0){
            foreach($clientes as $row){
                
//////////////////////////7///////////////////////////////Validacion Campos////////////////////////////
                $has_error=false;
                $error="";
                
                if($row[0]==""){
                    $has_error= true;
                    $error[]="campo <b>Razon Social</b> esta vacio";
                }elseif(!preg_match("/^[a-zA-Z0-9\s]+$/", trim($row[0]))){
                    $has_error = true;
                        $error[] = "campo <b>Razon Social</b> tiene caracteres no validos";
                }
                if(in_array($row[0],$clientes_viejos)){
                    $has_error = true;
                    $error[] = "campo <b>Razon Social</b> tiene asociado otro cliente";
                }
                
                if($row[1]==""){
                    $has_error= true;
                    $error[]="campo <b>NIT</b> esta vacio";
                }elseif(!is_numeric($row[1])){
                    $has_error = true;
                        $error[] = "campo <b>NIT</b> tiene formato no valido";
                }
                //if(in_array($row[1],$clientes_viejos)){
//                    $has_error = true;
//                    $error[] = "campo <b>NIT</b> tiene asociado otro cliente";
//                }
                
                
                if($row[2]==""){
                    $has_error= true;
                    $error[]="campo <b>Direccion</b> esta vacio";
                }
                
                if($row[3]==""){
                    $has_error= true;
                    $error[]="campo <b>Telefono</b> esta vacio";
                }elseif(!is_numeric($row[3]) && (strlen($row[3]) < 7)){
                    $has_error = true;
                        $error[] = "campo <b>Telefono</b> tiene formato no valido";
                }
                
                if($row[4]!="" && !preg_match("/^[A-Za-z]+(\s[A-Za-z]+)*$/", trim($row[4]))){
                    $has_error = true;
                        $error[] = "campo <b>Nombre Representante</b> tiene caracteres no validos";
                }
                
                if( $row[5]!="" && !is_numeric($row[5])){
                    $has_error = true;
                        $error[] = "campo <b>Cedula</b> tiene caracteres no validos";
                }
                
                if($row[6]!="" && !preg_match("/[\w-\.]@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/", trim($row[6]))){
                    $has_error = true;
                        $error[] = "campo <b>Correo</b> tiene formato no valido";
                }
                
                if( $row[7]!="" && !is_numeric($row[7])){
                    $has_error = true;
                        $error[] = "campo <b>Celular</b> tiene formato no valido";
                }
/////////////////////////////////////////////////////////////////////////////////////////////                
                 if($has_error){
                    
                    $errores_tmp[0]=$row[0];
                    $errores_tmp[1]=$row[1];
                    $errores_tmp[2]=$row[2];
                    $errores_tmp[3]=$row[3];
                    $errores_tmp[4]=$row[4];
                    $errores_tmp[5]=$row[5];
                    $errores_tmp[6]=$row[6];
                    $errores_tmp[7]=$row[7];
                    $errores_tmp[8]=join(",", $error);
                    
                    $errores[]=$errores_tmp;
                 }else{             
                
                    if($objClientes->crear_cliente($row[0],$row[1],$row[2],$row[3],$row[4],$row[5],$row[6],$row[7],$fecha)){
                       $objPerfiles->crear_perfil('defecto '.$row[0], 'defecto '.$row[0], $objClientes->insert_id, 1);
                      
                    }
                }                
               
            }
        }
            
        if(isset($errores)){
            
            $html="";
            $html .= '<body>';
            $html .= '<table border="1">';
            $html .= '<tr align="center"><td colspan="4" style="font-size: 26px; background-color:#333399; color: white; font-weight: bold;">Virtual Mobile IPV</td></tr>';
            $html .= '<tr></tr>';
            $html .= '<tr><td>Tipo informe:</td><td colspan="3">Clientes que no han sido creados debido a errores</td></tr>
                        <tr><td>Cantidad de elementos obtenidos:</td><td colspan="3">'.sizeof($errores).'</td></tr>
                        <tr></tr>
                     <tr>
                        <td style="background-color:#333399; color: white; font-weight: bold;">Razon social</td>
                        <td style="background-color:#333399; color: white; font-weight: bold;">NIT</td>
                        <td style="background-color:#333399; color: white; font-weight: bold;">Direccion</td>
                        <td style="background-color:#333399; color: white; font-weight: bold;">Telefono</td>
                        <td style="background-color:#333399; color: white; font-weight: bold;">Representante</td>
                        <td style="background-color:#333399; color: white; font-weight: bold;">Cedula</td>
                        <td style="background-color:#333399; color: white; font-weight: bold;">email</td>
                        <td style="background-color:#333399; color: white; font-weight: bold;">Celular</td>
                        <td style="background-color:#333399; color: white; font-weight: bold;">Descripcion errores</td>
                      </tr>';
                        
            foreach($errores as $row){
                $html.="<tr>
                            <td align='center'>$row[0]</td>
                            <td align='center'>$row[1]</td>
                            <td align='center'>$row[2]</td>
                            <td align='center'>$row[3]</td>
                            <td align='center'>$row[4]</td>
                            <td align='center'>$row[5]</td>
                            <td align='center'>$row[6]</td>
                            <td align='center'>$row[7]</td>
                            <td align='center'>$row[8]</td>
                        </tr>";
            }
            
            $html .= '</table></body></html>';
            
            $nombreArchivoError = uniqid("datos_error_");
            
          $ar=fopen("archivos_error/".$nombreArchivoError.".php","w") or die("Problemas en la creacion del archivo");
          fputs($ar,'<?php');
          fputs($ar,"\n");
          fputs($ar,'header("Content-type: application/vnd.ms-excel");');
          fputs($ar,"\n");
          fputs($ar,'header("Content-Disposition: attachment; filename=reporte_errores_detallado.xls");');
          fputs($ar,"\n");
          fputs($ar,'header("Pragma: no-cache");');
          fputs($ar,"\n");
          fputs($ar,'header("Expires: 0");');
          fputs($ar,"\n");
          fputs($ar,"?>");
          fputs($ar,"\n");
          fputs($ar,'<html>');
          fputs($ar,"\n");
          fputs($ar,$html);
          fclose($ar);
            
          header("Location: importar_cliente.php?state=error2&cuenta=".sizeof($errores)."&archivo_error=".$nombreArchivoError);
          exit;  
        }
        
        header("Location:importar_cliente.php?state=success");
    
 }else{
    header("Location:importar_cliente.php?state=error");
 }

?>