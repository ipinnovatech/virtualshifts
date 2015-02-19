<?php
ini_set("display_errors",true);

require_once("../clases/usuarios.class.php");
include_once("../clases/sedes.class.php");
include_once("../clases/videos_sedes.class.php");
include_once("../clases/imagenes_sedes.class.php");
include_once("../clases/turnos.class.php");
include_once("../clases/historial_turnos.class.php");
include_once("../clases/ventanillas.class.php");
include_once("../clases/consumidores.class.php");
include_once("../clases/areas.class.php");

$objUsuario = new Users;
$objSedes = new Sedes;
$objVideosSedes = new VideosSedes;
$objImagenesSedes = new ImagenesSedes;
$objTurnos = new Turnos;
$objHistorialTurnos = new HistorialTurnos;
$objVentanillas = new Ventanillas;
$objAreas = new Areas;
$objConsumidores = new Consumidores;

$ruta_log = '../logs/ws_visor/'.date("Y-m-d").'_ws_visor.log';

$metodo = $_POST['metodo'];

if($metodo == 'login'){
    login($_POST);
}

if($metodo == 'get_turnos'){
    get_turnos($_POST);
}

function login($datos) {
    global $ruta_log, $objUsuario, $objSedes, $objVideosSedes, $objImagenesSedes;

    $fp=fopen($ruta_log,'a');
    fwrite($fp,"\n".date("H:i:s")."datos de entrada login son: ".var_export($datos, true)."\n");
    fclose($fp);

    $errores = array();

    if($datos['username'] == ''){
        $errores[] = "El username es obligatorio";
    }

    if($datos['password'] == ''){
        $errores[] = "El password es obligatorio";
    }

    $gcm_id = $datos['gcm_id'];

    if(count($errores) == 0){
        $fp=fopen($ruta_log,'a');
        fwrite($fp,date("H:i:s")."no hubo errores en el envio de datos\n");
        fclose($fp);
        if ( $objUsuario->validar_user( $datos['username'] ) == true ) {
            $fp=fopen($ruta_log,'a');
            fwrite($fp,date("H:i:s")."el usuario existe\n");
            fclose($fp);
            if( $objUsuario->password == md5($datos['password']) ){
                $fp=fopen($ruta_log,'a');
                fwrite($fp,date("H:i:s")."el password coincide\n");
                fclose($fp);
                $array_salida['status'] = "success";
                $array_salida['error_description'] = "";
                $array_salida['datos']['nombres'] = $objUsuario->nombres." ".$objUsuario->apellidos;
                $array_salida['datos']['id'] = $objUsuario->id;
                $objUsuario->get_ventanilla_y_sede_por_asesor($objUsuario->id);
                $array_salida['datos']['id_sede'] = $objUsuario->sede;
                $array_salida['datos']['nombre_sede'] = $objUsuario->sede;

                $id_sede = $objUsuario->sede;

                $objSedes->actualizar_gcm_id_por_sede($id_sede, $gcm_id);

                $objSedes->get_sede_por_id_para_visor($objUsuario->sede);

                $muestra_video = $objSedes->array_sedes['S_MUESTRA_VIDEO'];

                $array_salida['datos']['muestra_video'] = $muestra_video;

                if($muestra_video == 1){
                    $fp=fopen($ruta_log,'a');
                    fwrite($fp,date("H:i:s")."la sede $id_sede muestra video\n");
                    fclose($fp);
                    $objVideosSedes->get_videos_por_sede_para_visor($id_sede, 0);
                    if($objVideosSedes->has_value){
                        $fp=fopen($ruta_log,'a');
                        fwrite($fp,date("H:i:s")."tiene videos\n");
                        fclose($fp);
                        $array_salida['datos']['videos'] = $objVideosSedes->array_campos;
                    }else{
                        $fp=fopen($ruta_log,'a');
                        fwrite($fp,date("H:i:s")."No tiene videos\n");
                        fclose($fp);
                        $array_salida['datos']['videos'] = array();
                    }
                    $objImagenesSedes->get_imagenes_por_sede_para_visor($id_sede, 0);
                    if($objImagenesSedes->has_value){
                        $fp=fopen($ruta_log,'a');
                        fwrite($fp,date("H:i:s")."tiene imagenes\n");
                        fclose($fp);
                        $array_salida['datos']['imagenes'] = $objImagenesSedes->array_campos;
                    }else{
                        $fp=fopen($ruta_log,'a');
                        fwrite($fp,date("H:i:s")."No tiene imagenes\n");
                        fclose($fp);
                        $array_salida['datos']['imagenes'] = array();
                    }
                }else{
                    $fp=fopen($ruta_log,'a');
                    fwrite($fp,date("H:i:s")."la sede $id_sede no muestra video\n");
                    fclose($fp);
                    $objImagenesSedes->get_imagenes_por_sede_para_visor($id_sede, 0);
                    $array_salida['datos']['videos'] = array();
                    if($objImagenesSedes->has_value){
                        $fp=fopen($ruta_log,'a');
                        fwrite($fp,date("H:i:s")."tiene imagenes\n");
                        fclose($fp);
                        $array_salida['datos']['imagenes'] = $objImagenesSedes->array_campos;
                    }else{
                        $fp=fopen($ruta_log,'a');
                        fwrite($fp,date("H:i:s")."No tiene imagenes\n");
                        fclose($fp);
                        $array_salida['datos']['imagenes'] = array();
                    }
                }
            }else{
                $fp=fopen($ruta_log,'a');
                fwrite($fp,date("H:i:s")."el password no coincide\n");
                fclose($fp);
                $array_salida['status'] = "error";
                $array_salida['error_description'] = "password errado";
                $array_salida['datos'] = array();
            }
        }
    }else{
        $fp=fopen($ruta_log,'a');
        fwrite($fp,date("H:i:s")."Hubo errores en el envio de datos\n");
        fclose($fp);
        $array_salida['status'] = "error";
        $array_salida['error_description'] = join(",", $errores);
        $array_salida['datos'] = array();
    }

    $fp=fopen($ruta_log,'a');
    fwrite($fp,date("H:i:s")." datos de salida login son: ".var_export($array_salida, true)."\n");
    fclose($fp);

    print_r(json_encode($array_salida));
    exit;
}

function get_turnos($datos){
    global $ruta_log, $objUsuario, $objTurnos, $objHistorialTurnos, $objVentanillas, $objAreas, $objConsumidores, $objSedes;

    $fp=fopen($ruta_log,'a');
    fwrite($fp,"\n".date("H:i:s")."datos de entrada get_turnos son: ".var_export($datos, true)."\n");
    fclose($fp);

    if($datos['id_sede'] == ''){
        $fp=fopen($ruta_log,'a');
        fwrite($fp,date("H:i:s")."No se envio el id de la sede\n");
        fclose($fp);

        $array_salida['status'] = "error";
        $array_salida['error_description'] = "el id_sede es obligatorio";
        $array_salida['datos'] = array();

        $fp=fopen($ruta_log,'a');
        fwrite($fp,date("H:i:s")." datos de salida login son: ".var_export($array_salida, true)."\n");
        fclose($fp);

        print_r(json_encode($array_salida));
        exit;
    }

    $sede = $datos['id_sede'];
    $i = 0;

    $objSedes->get_sede_por_id($sede);

    $nombre_sede = $objSedes->array_sedes['S_NOMBRE'];

    $objTurnos->get_turnos_sin_atender($sede,$nombre_sede);
    if($objTurnos->has_value){
        $fp=fopen($ruta_log,'a');
        fwrite($fp,date("H:i:s")."hay turnos sin atender\n");
        fclose($fp);

        $array_salida['status'] = 'success';
        $array_salida['error_description'] = '';
        foreach($objTurnos->array_campos as $turno){
            $objHistorialTurnos->get_turno_por_sede_area_turno_fecha($sede,$turno['ID_AREA'],$turno['ID'],date("Y-m-d"));
            if($objHistorialTurnos->has_value){
                $fp=fopen($ruta_log,'a');
                fwrite($fp,date("H:i:s")."se encontro el historial del tuirno y se le van a cargar los datos de ventanilla, area, asesor y consumidor\n");
                fclose($fp);
                if($objHistorialTurnos->array_campos['HT_VENT_ID'] != 0){
                    $objVentanillas->get_ventanillas_por_id($objHistorialTurnos->array_campos['HT_VENT_ID']);
                    $array_salida['datos'][$i]['datos_ventanilla'] = $objVentanillas->array_ventanillas;

                    $objAreas->get_area_por_id($turno['ID_AREA']);
                    $array_salida['datos'][$i]['datos_area'] = $objAreas->array_areas;

                    $objUsuarios->get_user($turno['ID_ASESOR']);
                    $array_salida['datos'][$i]['datos_asesor'] = $objUsuarios->array_usuarios;

                    $objConsumidores->get_consumidor_por_id($turno['ID_CONSUMIDOR']);
                    $array_salida['datos'][$i]['datos_consumidor'] = $objConsumidores->array_campos;

                    $array_salida['datos'][$i]['datos_turno'] = $turno;

                    $i++;

                    if($i >= 3){
                        break;
                    }
                }
            }
        }
    }else{
        $fp=fopen($ruta_log,'a');
        fwrite($fp,date("H:i:s")."no se encontraron turnos sin atender\n");
        fclose($fp);

        $array_salida['datos'] = array();
        $array_salida['status'] = 'error';
        $array_salida['error_description'] = 'No hay turnos por atender';
    }

    $fp=fopen($ruta_log,'a');
    fwrite($fp,date("H:i:s")." datos de salida login son: ".var_export($array_salida, true)."\n");
    fclose($fp);

    print_r(json_encode($array_salida));
    exit;
}

?>