<?php
ini_set("display_errors",true);
ini_set('memory_limit', '-1');
ini_set('max_execution_time', 300);
include("../../../clases/PHPExcel/Reader/Excel2007.php");
include("../../../clases/usuarios.class.php");
include("../../../clases/tipo_usuario.class.php");
//print_r($_FILES);
//exit;
$nombre_archivo= $_FILES['fileupload']['name'];
$tipo_archivo= $_FILES['fileupload']['type'];
$tamano_archivo = $_FILES['fileupload']['size'];
$rutaArchivo = "lista_archivos/".$nombre_archivo;

$objUsuario = new Users;
$objTipoUsuario = new TipoUsuarios;

$fecha=date("Y-m-d H:i:s");
$cuenta=0;

 if (move_uploaded_file($_FILES['fileupload']['tmp_name'],'lista_archivos/'.$nombre_archivo)){ 
    
        $objReader = (strpos($rutaArchivo,".xlsx"))?PHPExcel_IOFactory::createReader('Excel2007'):PHPExcel_IOFactory::createReader('Excel5');
        $objReader->setReadDataOnly(true);
        
        $objPHPExcel = $objReader->load("lista_archivos/".$nombre_archivo);
        $objWorksheet = $objPHPExcel->getActiveSheet();
                
        $objTipoUsuario->mostrar_tipos_usuarios();
        if($objTipoUsuario->has_value){
            foreach($objTipoUsuario->array_tipo_usuarios as $row){
                $tipoUsuarios[]=$row['TU_ID'];
            }
        }
        
        foreach ($objWorksheet->getRowIterator() as $row) {
        
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false); // This loops all cells,

            foreach ($cellIterator as $cell){
                $contactos_temp[] = $cell->getValue();
            }
            
            if(isset($contactos_temp) && $cuenta>0)
                $usuarios[]=$contactos_temp;          
            
            unset($contactos_temp);
            $cuenta++;           
        }
        
        if(sizeof($usuarios)>0){
            foreach($usuarios as $row){
                
//////////////////////////7///////////////////////////////Validacion Campos////////////////////////////
                $has_error=false;
                $error="";
                
                if($row[0]==""){
                    $has_error= true;
                    $error[]="campo <b>Nombre</b> esta vacio";
                }elseif(!preg_match("/^[a-zA-Z0-9\s]+$/", trim($row[0]))){
                    $has_error = true;
                        $error[] = "campo <b>Nombre</b> tiene caracteres no validos";
                }
                
                if($row[1]==""){
                    $has_error= true;
                    $error[]="campo <b>Apellidos</b> esta vacio";
                }elseif(!preg_match("/^[a-zA-Z0-9\s]+$/", trim($row[1]))){
                    $has_error = true;
                        $error[] = "campo <b>Apellidos</b> tiene caracteres no validos";
                }               
                
                if($row[2]==""){
                    $has_error= true;
                    $error[]="campo <b>Cedula</b> esta vacio";
                }elseif(!is_numeric($row[4])){
                    $has_error = true;
                        $error[] = "campo <b>Cedula</b> tiene formato no valido";
                }

               // if($row[3]==""){
//                    $has_error= true;
//                    $error[]="campo <b>Correo</b> esta vacio";
//                }else
                if($row[3]!="" && !preg_match("/[\w-\.]@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/", trim($row[3]))){
                    $has_error = true;
                        $error[] = "campo <b>Correo</b> tiene formato no valido";
                }
                
                if($row[4]==""){
                    $has_error= true;
                    $error[]="campo <b>Celular</b> esta vacio";
                }elseif(!is_numeric($row[4])){
                    $has_error = true;
                        $error[] = "campo <b>Celular</b> tiene formato no valido";
                }
                
                
                if($row[5]==""){
                    $has_error= true;
                    $error[]="campo <b>Tipo de usuario</b> esta vacio";
                }elseif(!is_numeric($row[5])){
                    $has_error = true;
                        $error[] = "campo <b>Tipo de usuario</b> tiene formato no valido";
                }
                
                if($row[5]=="1" || $row[5]=="3"){
                    $has_error = true;
                        $error[] = "<b>Tipo Usuario</b> no permitido";
                }
                if(!in_array($row[5],$tipoUsuarios)){
                    $has_error = true;
                    $error[] = "<b>Tipo Usuario</b> no existe";
                }
/////////////////////////////////////////////////////////////////////////////////////////////                
                 if($has_error){
                    
                    $errores_tmp[0]=$row[0];
                    $errores_tmp[1]=$row[1];
                    $errores_tmp[2]=$row[2];
                    $errores_tmp[3]=$row[3];
                    $errores_tmp[4]=$row[4];
                    $errores_tmp[5]=$row[5];
                    $errores_tmp[3]=$row[3];
                    $errores_tmp[4]=$row[4];
                    $errores_tmp[5]=$row[5];
                    $errores_tmp[6]=$row[6];
                    $errores_tmp[7]=$row[7];
//                    $errores_tmp[8]=join(",", $error);        //perfil, no aplica
                    
                    $errores[]=$errores_tmp;
                 }else{             
                
//                    if($row[5]=='2'){
//                        
//                        if(($row[6]=="SI" || $row[6]=="NO")){
//                            
//                            if($row[6]=="SI"){
//                                $compartido=1;
//                                $perfil=0;
//                            }else{
//                                if($row[7]!="" && is_numeric($row[7])){
//                                    $objPerfiles->get_perfil($row[7]);
//                                    if($objPerfiles->has_value){
//                                        $compartido=0;
//                                        $perfil=$row[7];
//                                    }else{
//                                        $has_error=true;
//                                        $error="campo <b>Perfil</b> tiene una opcion invalida";
//                                    }
//                                }else{
//                                    $has_error=true;
//                                    $error="campo <b>Perfil</b> tiene un formato no valido";
//                                }
//                            }
//                        }else{
//                            $has_error=true;
//                            $error="campo <b>Compartido</b> tiene una opcion invalida";
//                        }
//                    }else{
//                        $compartido=0;
//                        $perfil=0;
//                    }
                    
                    if(!$has_error){
                        
                        $array_apellidos = explode(' ',$row[1]);
                        $password = substr($row[2], 0,4);
                        $username = strtolower(substr($row[0],0,1).$array_apellidos[0]);
                        
                        if($objUsuario->crear_usuario($row[0], $row[1], $username, $password, $row[5], $row[2], $row[3], $row[4], 1, $compartido, $perfil)){
//                            if($row[5] == 2 || $row[5] == 5){
//                                $objMoviles->crear_movil($row[2], $objUsuario->insert_id);
//                            }
                        }else{
                            $has_error=true;
                            $error="campo <b>Cedula</b> tiene asociado otro usuario";//Validacion por base de datos                            
                        }
                    }
                    
                    if($has_error){
                            $errores_tmp[0]=$row[0];
                            $errores_tmp[1]=$row[1];
                            $errores_tmp[2]=$row[2];
                            $errores_tmp[3]=$row[3];
                            $errores_tmp[4]=$row[4];
                            $errores_tmp[5]=$row[5];
                            $errores_tmp[3]=$row[3];
                            $errores_tmp[4]=$row[4];
                            $errores_tmp[5]=$row[5];
                            $errores_tmp[6]=$row[6];
                            $errores_tmp[7]=$row[7];
                            $errores_tmp[8]=$error;
                            $errores[]=$errores_tmp;
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
            $html .= '<tr><td>Tipo informe:</td><td colspan="3">Usuarios que no han sido creados debido a errores</td></tr>
                        <tr><td>Cantidad de elementos obtenidos:</td><td colspan="3">'.sizeof($errores).'</td></tr>
                        <tr></tr>
                     <tr>
                        <td style="background-color:#333399; color: white; font-weight: bold;">Nombres</td>
                        <td style="background-color:#333399; color: white; font-weight: bold;">Apellidos</td>
                        <td style="background-color:#333399; color: white; font-weight: bold;">Cedula</td>
                        <td style="background-color:#333399; color: white; font-weight: bold;">Correo</td>
                        <td style="background-color:#333399; color: white; font-weight: bold;">Celular</td>
                        <td style="background-color:#333399; color: white; font-weight: bold;">Tipo usuario</td>
                        <td style="background-color:#333399; color: white; font-weight: bold;">Compartido</td>
                        <td style="background-color:#333399; color: white; font-weight: bold;">Perfil</td>
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
          fputs($ar,'header("Content-Disposition: attachment; filename=reporte_errores_usuarios.xls");');
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
            
          header("Location: importar_usuarios.php?state=error2&cuenta=".sizeof($errores)."&archivo_error=".$nombreArchivoError);
          exit;  
        }
        
        header("Location:importar_usuarios.php?state=success");
    
 }else{
    header("Location:importar_usuarios.php?state=error");
 }

?>