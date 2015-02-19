<?php
ini_set('display_errors',1);
// Incluimos la biblioteca de NuSOAP (la misma que hemos incluido en el servidor, ver la ruta que le especificamos)
require_once('../clases/nusoap/lib/nusoap.php');
// Crear un cliente apuntando al script del servidor (Creado con WSDL) - 
// Las proximas 3 lineas son de configuracion, y debemos asignarlas a nuestros parametros
$serverURL = 'http://www.virtualtickets.co:7070';
$serverScript = 'WebService1.asmx';
$metodoALlamar = 'GetTicketTodoCedula';

// Crear un cliente de NuSOAP para el WebService
$cliente = new nusoap_client("$serverURL/$serverScript?wsdl", 'wsdl');
// Se pudo conectar?
$error = $cliente->getError();
if ($error) {
echo '<pre style="color: red">' . $error  . '</pre>';
echo '<p style="color:red;'>htmlspecialchars($cliente->getDebug(), ENT_QUOTES).'</p>';
die();
}

// 1. Llamar a la funcion getRespuesta del servidor
$result = $cliente->call(
"$metodoALlamar", // Funcion a llamar
//array('cedula' => '1130669295', 'tipo' => '1'), // Parametros pasados a la funcion
array('cedula' => '1130630969'
    ),
"uri:$serverURL/$serverScript", // namespace
"uri:$serverURL/$serverScript/$metodoALlamar" // SOAPAction
);
// Verificacion que los parametros estan ok, y si lo estan. mostrar rta.
if ($cliente->fault) {
echo '<b>Error: ';
print_r($result);
echo '</b>';
} else {
$error = $cliente->getError();
if ($error) {
echo '<b style="color: red">Error: ' . $error . '</b>';
} else {
echo 'Respuesta: ';print_r($result);
}
}

echo "<br />";
?>
