<?php
//ini_set('display_errors',1);
//header('Content-Type: text/html; charset=iso-8859-1'); 
// Incluimos la biblioteca de NuSOAP (la misma que hemos incluido en el servidor, ver la ruta que le especificamos)
require_once('clases/nusoap/lib/nusoap.php');
// Crear un cliente apuntando al script del servidor (Creado con WSDL) - 
// Las proximas 3 lineas son de configuracion, y debemos asignarlas a nuestros parametros
$serverURL = 'http://serviciosweb.eficacia.com.co/web_services/server.php';
$metodoALlamar = 'get_info_user';

// Crear un cliente de NuSOAP para el WebService
$cliente = new nusoap_client("$serverURL?wsdl", 'wsdl');
// Se pudo conectar?
$error = $cliente->getError();
if ($error) {
 echo '<pre style="color: red">' . $error  . '</pre>';
 echo '<p style="color:red;'>htmlspecialchars($cliente->getDebug(), ENT_QUOTES).'</p>';
 die();
}

//$cliente->soap_defencoding = 'UTF-8';
//$cliente->decode_utf8 = false;

// 1. Llamar a la funcion getRespuesta del servidor
$result = $cliente->call(
 "$metodoALlamar", // Funcion a llamar
 array('cedula' => '1130630969'),
// array('usuario' => 'RGARCES', 
//       'clave' => '$14638$', 
//       'punto' => 'CALI', 
//       'identificacion' => '00000079', 
//       'secuencia' => '', 
//       'tipo_pedido' => 'CLIE', 
//       'tipo_lista' => 'GENE', 
//       'punto_destino' => '', 
//       'bodega_destino' => '', 
//       'condicion_pago' => '', 
//       'vendedor' => 'NUTRESA', 
//       'fecha_vencimiento' => '',
//       'fecha_envio' => '2014-05-22', 
//       'hora_envio' => '10', 
//       'documento_referencia' => '', 
//       'fecha_documento_referencia' => '', 
//       'valor_tasa_cambio' => '', 
//       'porcentaje_descuento_global' => '0', 
//       'observaciones' => 'prueba webservice 21 mayo', 
//       'identificacion_facturar_a' => '', 
//       'secuencia_facturar_a' => '', 
//       'identificacion_entregar_en' => '', 
//       'secuencia_entregar_en' => '', 
//       'clasificador1' => '',
//       'clasificador2' => '', 
//       'proveedor' => 'NUTRESA', 
//       'dato_adicional' => '', 
//       'detallesubicaciones' => array('pais' => '057', 
//                                      'departamento' => '76', 
//                                      'ciudad' => '001', 
//                                      'nombre_pais' => 'COLOMBIA', 
//                                      'nombre_departamento' => 'VALLE', 
//                                      'nombre_ciudad' => 'CALI',
//                                      'zona' => 'NUTRESA',
//                                      'direccion' => 'DIRECCIÓN: CARRERA 12 23-01 EL OBRERO'), 
//       'detalles' => array('articulo' => '123456', 
//                           'cantidad' => '2', 
//                           'porcentaje_descuento' => '0', 
//                           'serie' => '', 
//                           'lote' => '',
//                           'documento1' => 'CADENAS', 
//                           'documento2' => '', 
//                           'estado_articulo' => '', 
//                           'identificacion_detalla' => '', 
//                           'secuencia_detalla' => '', 
//                           'fecha_detalla' => '', 
//                           'hora_detalla' => '' 
//                           ),
//       'detallespersonas' => array('tipo_identificacion' => 'NIT',
//                                   'nombre' => 'Pablo',
//                                   'apellido' => 'Lievano',
//                                   'sexo' => 'M',
//                                   'tipo_persona' => 'N',
//                                   'tipo_cliente' => 'SIN')
//       ), // Parametros pasados a la funcion
 //array('cedula' => '63438238', 'anho' => '2010', 'id_tablet' => '1'),
 "uri:$serverURL", // namespace
 "uri:$serverURL/$metodoALlamar" // SOAPAction
);

print_r($result);
// Verificacion que los parametros estan ok, y si lo estan. mostrar rta.
if ($cliente->fault) {
 echo '<b>Error: ';
 print_r($result);
 echo '</b>';
} else {
 $error = $cliente->getError();
 if ($error) {
 echo '<b style="color: red">Error: ' . $error . '</b>';
 }
}

?>