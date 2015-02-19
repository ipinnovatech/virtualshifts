<?php
ini_set("display_errors",1);

$ruta_log = "/var/www/html/virtualshifts/logs/trunca_sedes/".date("Y-m-d")."-trunca_sedes.log";

$fp = fopen($ruta_log,"a");
fwrite($fp, "\n".date("H:i:s")." Inicia ejecucion del script\n");
fclose($fp);

include_once('/var/www/html/virtualshifts/clases/sedes.class.php');

$objSedes = new Sedes;

$fp = fopen($ruta_log,"a");
fwrite($fp, date("H:i:s")." genera las clases\n");
fclose($fp);

$fp = fopen($ruta_log,"a");
fwrite($fp, date("H:i:s")." se va a buscar todas las sedes\n");
fclose($fp);
$objSedes->get_sedes();

if($objSedes->has_value){
    $fp = fopen($ruta_log,"a");
    fwrite($fp, date("H:i:s")." se encontraron las sedes\n");
    fclose($fp);
    foreach($objSedes->array_sedes as $sede){
        $fp = fopen($ruta_log,"a");
        fwrite($fp, date("H:i:s")." se va a truncar la sede {$sede['S_NOMBRE']} de id {$sede['S_ID']}\n");
        fclose($fp);
        if($objSedes->truncar_tabla_sede($sede['S_NOMBRE'],$sede['S_ID'])){
            $fp = fopen($ruta_log,"a");
            fwrite($fp, date("H:i:s")." se trunco la sede\n");
            fclose($fp);
        }
    }
}

$fp = fopen($ruta_log,"a");
fwrite($fp, date("H:i:s")." finalizo el script\n");
fclose($fp);

?>