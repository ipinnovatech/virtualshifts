<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE);
ini_set('display_errors', true);
header('Content-Type: text/html; charset=iso-8859-1'); 
session_start();

require_once('../clases/nusoap/lib/nusoap.php');
include_once("../clases/consumidores.class.php");
include_once("../clases/usuarios.class.php");
include_once("../clases/turnos.class.php");
include_once("../clases/sedes.class.php");
include_once("../clases/areas.class.php");
include_once("../clases/encuestas.class.php");
include_once("../clases/historial_turnos.class.php");
include_once("../clases/clientes.class.php");
include_once("../clases/web_service_client.class.php");

$miURL = 'http://184.168.29.222/virtualshifts/webservice';

$objConsumidores = new Consumidores;
$objUsuarios = new Users;
$objTurnos = new Turnos;
$objSedes = new Sedes;
$objAreas = new Areas;
$objEncuestas = new Encuestas;
$objHistorialTurnos = new HistorialTurnos;
$objClientes = new Clientes;

$server = new soap_server();

$server->configureWSDL('ws_turnos', $miURL);
$server->wsdl->schemaTargetNamespace=$miURL;

$ruta_log = '/var/www/html/virtualshifts/logs/webservice/'.date("Y-m-d").'_ws.log';

$server->register('set_prueba',
    array('user' => 'xsd:string'),
    array('response' => 'xsd:string'),
    $miURL);

function set_prueba($id_user){    

    return new soapval('response', 'xsd:string', "$id_user");    
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$server->register('get_user',
    array('user' => 'xsd:string', 'pass' => 'xsd:string'),
    array('response' => 'xsd:string'),
    $miURL);

function get_user($user, $pass){
    global $objUsuarios, $ruta_log;
    
    $fp=fopen($ruta_log,'a');
    fwrite($fp,"\n datos de entrada get_movil son user: $user y pass: $pass \n");
    fclose($fp);
    
    if($objUsuarios->validar_user($user)==true){
        if($objUsuarios->password == $pass){
            if($objUsuarios->crea_turno == 1){
                $resultado=$objUsuarios->id;
                $resultado=$resultado.','.$objUsuarios->nombres;
                $resultado=$resultado.' '.$objUsuarios->apellidos;
                $resultado=$resultado.','.$objUsuarios->id_tipo_usuario;
                $resultado=$resultado.','.$objUsuarios->cliente;
                $resultado=$resultado.',2';
            }else{
               $resultado = 'no_crea'; 
            }
            
        }else{
            $resultado = 'error';
        }        
    }else{
        $resultado = 'error';
    }
    
    $fp=fopen($ruta_log,'a');
    fwrite($fp,"\n dato de salida get_movil es $resultado \n");
    fclose($fp);
    
    return new soapval('response', 'xsd:string', "$resultado"); 
}
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$server->register('crear_turno', 
 array('cedula' => 'xsd:string', 
       'nombre' => 'xsd:string',
       'direccion' => 'xsd:string',
       'telefono' => 'xsd:string',
       'mail' => 'xsd:string',
       'campo1' => 'xsd:string',
       'campo2' => 'xsd:string',
       'campo3' => 'xsd:string',
       'campo4' => 'xsd:string',
       'campo5' => 'xsd:string',
       'area' => 'xsd:string',
       'observacion' => 'xsd:string',
       'cliente' => 'xsd:string',
       'id_sede' => 'xsd:string'
       ), 
 array('return' => 'xsd:string'),
 $miURL);
 
function crear_turno($cedula, $nombre, $direccion, $telefono, $mail, $campo1, $campo2, $campo3, $campo4, $campo5, $area, $observacion , $cliente, $id_sede){
    global $objConsumidores, $objSedes, $objAreas, $objTurnos, $objHistorialTurnos, $ruta_log;
    $nombre = str_replace("Ñ","N",$nombre);
    
    if($area == ""){
        $area = '1';
    }
    $fp = fopen("jojo.log","a");
    fwrite($fp, "\n".date("Y-m-d H:i:s")." --> crear_turno $cedula, $nombre, $direccion, $telefono, $mail, $campo1, $campo2, $campo3, $campo4, $campo5, $area, $observacion, $cliente, $id_sede \n");
    fclose($fp);
    
    $fp = fopen($ruta_log,"a");
    fwrite($fp, date("Y-m-d H:i:s")." --> crear el consumidor \n");
    fclose($fp);
    
    $objConsumidores->crear_consumidor($nombre, $cedula, $direccion, $telefono, $mail, $campo1, $campo2, $campo3, $campo4, $campo5, $cliente);
    $id_consumidor = $objConsumidores->insert_id;
    
    $fp = fopen('jojo.log',"a");
    fwrite($fp, date("Y-m-d H:i:s")." --> id: $id_consumidor \n");
    fclose($fp);
    
    $fp = fopen($ruta_log,"a");
    fwrite($fp, date("Y-m-d H:i:s")." --> se creo el consumidor $id_consumidor \n");
    fclose($fp);
    
    $fp = fopen("jojo.log","a");
    fwrite($fp, date("Y-m-d H:i:s")." --> se obtiene informacion de la sede $id_sede \n");
    fclose($fp);
    
    $objSedes->get_sede_por_id($id_sede);
    $array_sede = $objSedes->array_sedes;
    
    $fp = fopen('jojo.log',"a");
    fwrite($fp, date("Y-m-d H:i:s")." --> ".var_export($array_sede,true)." \n");
    fclose($fp);
    
    $fp = fopen($ruta_log,"a");
    fwrite($fp, date("Y-m-d H:i:s")." --> la informacion de la sede es ".var_export($array_sede,true)." \n");
    fclose($fp);
    
    $fp = fopen($ruta_log,"a");
    fwrite($fp, date("Y-m-d H:i:s")." --> se va a extraer informacion del area  \n");
    fclose($fp);
    
    $objAreas->get_area_por_id($area);
    $array_area = $objAreas->array_areas;
    
    $fp = fopen($ruta_log,"a");
    fwrite($fp, date("Y-m-d H:i:s")." --> la informacion del area es ".var_export($array_area,true)." \n");
    fclose($fp);
    
    $fp = fopen($ruta_log,"a");
    fwrite($fp, date("Y-m-d H:i:s")." --> se va a crear el turno \n");
    fclose($fp);
    
    $objTurnos->crear_turno($id_sede, $array_sede['S_NOMBRE'], $area, $id_consumidor);
    $turno = $objTurnos->insert_id;
    
    $fp = fopen($ruta_log,"a");
    fwrite($fp, date("Y-m-d H:i:s")." --> se creo el turno $turno del area ".$array_area['AR_ALIAS']." \n");
    fclose($fp);
    
    if($objHistorialTurnos->crear_turno($id_sede,$area,$turno,"2",$id_consumidor,date("H:i:s"),$observacion)){
        return new soapval('return', 'xsd:string', $array_area['AR_ALIAS'].$turno);
    }else{
        return new soapval('return', 'xsd:string', 'error');
    }
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$server->wsdl->addComplexType(
    'area',
    'complexType',
    'struct',
    'all',
    '',
    array(
    'id_area' => array('name' => 'id_area', 'type' => 'xsd:string'),
    'nombre_area' => array('name' => 'nombre_area', 'type' => 'xsd:string')
    ));

$server->wsdl->addComplexType(
    'arrayAreas',
    'complexType',
    'array',
    '', 
    'SOAP-ENC:Array', 
    array(),
    array(
    array('ref' => 'SOAP-ENC:arrayType', 
    'wsdl:arrayType' => 'tns:area[]')
    ),
    'tns:area'
);

$server->wsdl->addComplexType(
    'arrayArea',
    'complexType',
    'struct',
    'all',
    '',
    array(
    'status' => array('name' => 'status', 'type' => 'xsd:string'),
    'error_descrip' => array('name' => 'error_descrip', 'type' => 'xsd:string'),
    'datos' => array('name' => 'datos', 'type' => 'tns:arrayAreas')
    ));

$server->register('get_areas', 
 array('cliente' => 'xsd:string'), 
 array('return' => 'tns:arrayArea'),
 $miURL);
 
function get_areas($cliente){
    global $objAreas, $ruta_log;
    
    $fp = fopen($ruta_log,"a");
    fwrite($fp, "\n".date("Y-m-d H:i:s")." --> get_areas $cliente \n");
    fclose($fp);
    
    $fp = fopen($ruta_log,"a");
    fwrite($fp, date("Y-m-d H:i:s")." --> buscando areas del cliente \n");
    fclose($fp);
    
    $objAreas->get_areas_activas_por_cliente($cliente);
    if($objAreas->has_value){
        $arra_salida['status'] = 'success';
        $arra_salida['error_descrip'] = '';
        foreach($objAreas->array_areas as $key => $area){
            $areas_salida[$key]['id_area'] = $area['AR_ID'];
            $areas_salida[$key]['nombre_area'] = $area['AR_DESCRIPCION'];
        }
        $arra_salida['datos'] = $areas_salida;
        
        $fp = fopen('vaina.log',"a");
        fwrite($fp, date("Y-m-d H:i:s")." --> encontro estas areas ".var_export($areas_salida,true)." \n");
        fclose($fp);
        
    }else{
        $arra_salida['status'] = 'error';
        $arra_salida['error_descrip'] = 'empty';
        $arra_salida['datos'] = array();
        
        $fp = fopen($ruta_log,"a");
        fwrite($fp, date("Y-m-d H:i:s")." --> no encontro aras \n");
        fclose($fp);
    }
    
    $fp = fopen('vaina.log',"a");
    fwrite($fp, date("Y-m-d H:i:s")." --> salida ".var_export($arra_salida, true)." \n");
    fclose($fp);
    
    return new soapval('return', 'tns:arrayArea', $arra_salida);
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$server->wsdl->addComplexType(
    'datoAreas',
    'complexType',
    'struct',
    'all',
    '',
    array(
    'AR_ID' => array('name' => 'AR_ID', 'type' => 'xsd:string'),
    'AR_NOMBRE' => array('name' => 'AR_NOMBRE', 'type' => 'xsd:string'),
    )); 

$server->wsdl->addComplexType(
    'arrayAreas2',
    'complexType',
    'array',
    '', 
    'SOAP-ENC:Array', 
    array(),
    array(
    array('ref' => 'SOAP-ENC:arrayType', 
    'wsdl:arrayType' => 'tns:datoAreas[]')
    ),
    'tns:datoAreas'
);

$server->register('get_areas2',
    array('cliente' => 'xsd:string'),
    array('response' => 'tns:arrayAreas'),
    $miURL);                                    // Por aca voyyy!!!!

function get_areas2($cliente){
    global $objAreas, $ruta_log;
    
    $fp=fopen($ruta_log,'a');
    fwrite($fp,"\n datos de entrada get_areas2 son perfil: $perfil \n");
    fclose($fp);

    if($objAreas->get_areas_activas_por_cliente($cliente)==true){
        $resultado = $objAreas->array_areas;

    }else{
        $resultado = array();
    }
        
    $fp=fopen($ruta_log,'a');
    fwrite($fp,"\n dato de salida get_areas2 es ".var_export($resultado, true)." \n");
    fclose($fp);
    
    return new soapval('response', 'tns:arrayAreas2', $resultado); 
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$server->register('crear_encuesta_2',
 array('cliente' => 'xsd:string', 'pregunta' => 'xsd:string', 'respuesta' => 'xsd:string', 'regional' => 'xsd:string', 'usuario' => 'xsd:string', 'actividades' => 'xsd:string'),
 array('return' => 'xsd:string'),
 $miURL);
function crear_encuesta_2($cliente, $pregunta, $respuesta, $regional, $usuario, $actividades){
    global $objEncuestas;
    if($objEncuestas->set_encuesta($pregunta, $respuesta, $cliente, $regional, $usuario, $actividades)){
        return new soapval('return', 'xsd:string' , 'OK');
    }else{
        return new soapval('return', 'xsd:string' , 'error');
    }
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$server->register('crear_encuesta',
 array('cliente' => 'xsd:string', 'pregunta' => 'xsd:string', 'respuesta' => 'xsd:string', 'regional' => 'xsd:string', 'usuario' => 'xsd:string', 'actividades' => 'xsd:string'),
 array('return' => 'xsd:string'),
 $miURL);
function crear_encuesta($cliente, $pregunta, $respuesta, $regional, $usuario, $actividades){
    global $objEncuestas;
    
    $fp=fopen('log_encuesta.log','a');
    fwrite($fp,"\n Datos de entrada de crear_encuesta ".$cliente."___".$pregunta."__".$respuesta."__".$regional."__".$usuario."__".$actividades."__"." \n");
    fclose($fp);
    /////////////////////////////////////////////////////////////
    //                       CLIENTE                           //
    /////////////////////////////////////////////////////////////
    $serverURL = 'http://serviciosweb.eficacia.com.co/web_services';
    $serverScript = 'server.php';
    $metodoALlamar = 'get_info_empresa_nombre_user';
    
    // Crear un cliente de NuSOAP para el WebService
    $clientWS = new nusoap_client("$serverURL/$serverScript?wsdl", 'wsdl');
    
    // 1. Llamar a la funcion getRespuesta del servidor
    $result = $clientWS->call(
    "$metodoALlamar", // Funcion a llamar
    //array('cedula' => '1130669295', 'tipo' => '1'), // Parametros pasados a la funcion
    array('cedula' => "$usuario"),
    "uri:$serverURL/$serverScript", // namespace
    "uri:$serverURL/$serverScript/$metodoALlamar" // SOAPAction
    );
    // Verificacion que los parametros estan ok, y si lo estan. mostrar rta.
    if ($clientWS->fault) {
    } else {
        $error = $clientWS->getError();
        if ($error) {
            $nombre = "SIN INFORMACION";
            $empresa = "EFICACIA";
        } else {
            $resultado = explode("_",$result);
            $nombre = $resultado[0];
            $empresa = $resultado[1];
        }
    }
//    $fp=fopen('log_encuesta.log','a');
//    fwrite($fp,"\n dato de salida  es ".$nombre.' - '.$empresa." \n");
//    fclose($fp);
    /////////////////////////////////////////////////////////////
    //                     FIN CLIENTE                         //
    /////////////////////////////////////////////////////////////
//        $fp=fopen('log_encuesta.log','a');
//        fwrite($fp,"\n Datos ingresados:\n $pregunta, $respuesta, $cliente, $regional, $usuario, $actividades, $nombre, $empresa");
//        fclose($fp);
    if($objEncuestas->set_encuesta($pregunta, $respuesta, $cliente, $regional, $usuario, $actividades, $nombre, $empresa)){
//        $fp=fopen('log_encuesta.log','a');
//        fwrite($fp,"\n Se han ingresado los datos a la BD \n");
//        fclose($fp);
        return new soapval('return', 'xsd:string' , 'OK');
    }else{
        $fp=fopen('log_encuesta.log','a');
        fwrite($fp,"\n Ha ocurrido un error al ingresar los datos a la BD \n");
        fclose($fp);
        return new soapval('return', 'xsd:string' , 'error');
    }
}
if ( !isset( $HTTP_RAW_POST_DATA ) )
    $HTTP_RAW_POST_DATA = file_get_contents( 'php://input' );

$server->service($HTTP_RAW_POST_DATA);
?>