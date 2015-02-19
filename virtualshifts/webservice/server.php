<?php
ini_set('display_errors',1);

ini_set("log_errors", 1);
ini_set("error_log", "php-error.log");

require_once('../clases/nusoap/lib/nusoap.php'); //llamado al archivo nusoap

$miURL = 'http://ipvirtualmobile.com/virtualshifts/webservice/';  //url del servidor
$server = new soap_server();
$server->configureWSDL('ws_ipinnovatech', $miURL);
$server->wsdl->schemaTargetNamespace=$miURL;

$server->wsdl->addComplexType(
    'Credito',
    'complexType',
    'struct',
    'all',
    '',
    array(
    'id_cliente' => array('name' => 'id_cliente', 'type' => 'xsd:string'),
    'credito' => array('name' => 'credito', 'type' => 'xsd:string'),
    'tasaConversion' => array('name' => 'tasaConversion', 'type' => 'xsd:string'),
    'idPlanAfiliado' => array('name' => 'idPlanAfiliado', 'type' => 'xsd:string')
    ));

$server->register('consultar_credito',
    array('id_cliente' => 'xsd:string'),
    array('return' => 'tns:arraySalidaCredito'),
    $miURL
);

function consultar_credito($id_cliente){
    include("../clases/credito.class.php");
    include("../clases/planes.class.php");
    
    $objCredito = new Credito;
    $objPlanes = new Planes;
    
    $consulta = $objCredito->obtener_credito_cliente($id_cliente);
    
    if( $consulta->num_rows > 0 ){
        $result['status'] = "success";
        $result['error_descrip'] = "";
        $credito = $consulta->fetch_assoc();
        $credito_temp['credito'] = $credito['credito'];
        
        $objPlanes->mostrar_plan_por_id($credito['idPlanAfiliado']);
        
        if( $objPlanes->has_value ){
            $credito_temp['tasaConversion'] = $objPlanes->plan['tasaConversion'];
        }else{
            $credito_temp['tasaConversion'] = "1";
        }
        
        $credito_temp['idPlanAfiliado'] = $credito['idPlanAfiliado'];
        
        $result['datos'] = $credito_temp;
    }else{
        $result['status'] = "error";
        $result['error_descrip'] = "empty";
        $result['datos'] = array();
    }
    
    return new soapval('response', 'tns:arraySalidaCredito', $result);   
}

if ( !isset( $HTTP_RAW_POST_DATA ) )
    $HTTP_RAW_POST_DATA = file_get_contents( 'php://input' );

$server->service($HTTP_RAW_POST_DATA);
?>