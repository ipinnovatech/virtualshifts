<?php
ini_set("display_errors",1);

$ruta_log = "/var/www/html/virtualshifts/logs/encuestas/".date("Y-m-d")."-lanza_encuestas.log";

$fp = fopen($ruta_log,"a");
fwrite($fp, "\n".date("H:i:s")." Inicia ejecucion del script\n");
fclose($fp);

include_once('/var/www/html/virtualshifts/clases/usuario_para_encuesta.class.php');
include_once('/var/www/html/virtualshifts/clases/web_service_client.class.php');
include_once('/var/www/html/virtualshifts/clases/consumidores.class.php');
include_once('/var/www/html/virtualshifts/clases/configuracion_encuestas_virtual_pbax.class.php');
include_once('/var/www/html/virtualshifts/clases/sedes.class.php');

$objUsuariosEncuesta = new UsuariosParaEncuesta;
$objConsumidores = new Consumidores;
$objWebServiceClient = new webServiceClient('http://ipvirtualmobile.com/virtualpbax/web_service_server/server.php?wsdl');
$objConfiguracionEncuesta = new ConfiguracionEncuestasVirtualPBAX;
$objSedes = new Sedes;

$fp = fopen($ruta_log,"a");
fwrite($fp, date("H:i:s")." genera las clases\n");
fclose($fp);

$hora1 = date("H:i", strtotime("+1 minutes"));
$hora2 = date("H:i", strtotime("-1 minutes"));

$fp = fopen($ruta_log,"a");
fwrite($fp, date("H:i:s")." consulta usuarios para encuestar entre las horas $hora2 - $hora1 \n");
fclose($fp);

$objUsuariosEncuesta->get_usuarios_para_encuesta(date("Y-m-d"),$hora2.":00",$hora1.":59");
if($objUsuariosEncuesta->has_value){
    $fp = fopen($ruta_log,"a");
    fwrite($fp, date("H:i:s")." encontro usuarios para encuestar \n");
    fclose($fp);
    
    foreach($objUsuariosEncuesta->array_campos as $contacto){
        $fp = fopen($ruta_log,"a");
        fwrite($fp, date("H:i:s")." busca los datos del consumidor {$contacto['UPA_CON_ID']} \n");
        fclose($fp);
    
        $objConsumidores->get_consumidor_por_id($contacto['UPA_CON_ID']);
        if($objConsumidores->has_value){
            $fp = fopen($ruta_log,"a");
            fwrite($fp, date("H:i:s")." encontro los datos del consumidor \n");
            fclose($fp);
            
            $objConfiguracionEncuesta->get_configuracion_encuesta_por_sede($contacto['UPA_S_ID']);
            
            $nombre = ($objConfiguracionEncuesta->array_campos['CEVP_VAR_NOMBRE'] != '')?$objConsumidores->array_campos[$objConfiguracionEncuesta->array_campos['CEVP_VAR_NOMBRE']]:'';
            $celular = ($objConfiguracionEncuesta->array_campos['CEVP_VAR_CELULAR'] != '')?$objConsumidores->array_campos[$objConfiguracionEncuesta->array_campos['CEVP_VAR_CELULAR']]:'';
            $fijo = ($objConfiguracionEncuesta->array_campos['CEVP_VAR_FIJO'] != '')?$objConsumidores->array_campos[$objConfiguracionEncuesta->array_campos['CEVP_VAR_FIJO']]:'';
            $aux = ($objConfiguracionEncuesta->array_campos['CEVP_VAR_AUX'] != '')?$objConsumidores->array_campos[$objConfiguracionEncuesta->array_campos['CEVP_VAR_AUX']]:'';
            $correo = ($objConfiguracionEncuesta->array_campos['CEVP_VAR_CORREO'] != '')?$objConsumidores->array_campos[$objConfiguracionEncuesta->array_campos['CEVP_VAR_CORREO']]:'';
            $var1 = ($objConfiguracionEncuesta->array_campos['CEVP_VAR_VAR1'] != '')?$objConsumidores->array_campos[$objConfiguracionEncuesta->array_campos['CEVP_VAR_VAR1']]:'';
            $var2 = ($objConfiguracionEncuesta->array_campos['CEVP_VAR_VAR2'] != '')?$objConsumidores->array_campos[$objConfiguracionEncuesta->array_campos['CEVP_VAR_VAR2']]:'';
            
            if($objConfiguracionEncuesta->array_campos['CEVP_VAR_VAR3'] != 'sede'){
                $var3 = ($objConfiguracionEncuesta->array_campos['CEVP_VAR_VAR3'] != '')?$objConsumidores->array_campos[$objConfiguracionEncuesta->array_campos['CEVP_VAR_VAR3']]:'';
            }else{
                $objSedes->get_sede_por_id($contacto['UPA_S_ID']);
                $var3 = $objSedes->array_sedes['S_NOMBRE'];
            }
            
            $fp = fopen($ruta_log,"a");
            fwrite($fp, date("H:i:s")." NOMBRE SEDE $var3 \n");
            fclose($fp);
            
            $objWebServiceClient->crear_contacto_para_marcacion($objConfiguracionEncuesta->array_campos['CEVP_ID_LISTA'],$nombre,$celular,$fijo,$aux,$correo,$var1,$var2,$var3);
            $fp = fopen($ruta_log,"a");
            fwrite($fp, date("H:i:s")." crea el contacto {$objWebServiceClient->result} en virtual pbax \n");
            fclose($fp);
            
            $objWebServiceClient->marcar_contaco($objWebServiceClient->result);
            $objWebServiceClient->iniciar_lista_marcacion($objConfiguracionEncuesta->array_campos['CEVP_ID_LISTA']);
            if($objWebServiceClient->result == 'success'){
                $fp = fopen($ruta_log,"a");
                fwrite($fp, date("H:i:s")." coloco a marcar el contacto y se pone como encuestado el usuario {$contacto['UPA_ID']} \n");
                fclose($fp);
                $objUsuariosEncuesta->usuario_encuestado($contacto['UPA_ID']);
            }
        }
    }
}else{
    $fp = fopen($ruta_log,"a");
    fwrite($fp, date("H:i:s")." no encontro usuarios para encuestar y va a buscar en horas anteriores a ".date("H:i:s")." \n");
    fclose($fp);
    $objUsuariosEncuesta->get_usuarios_para_encuesta_viejos(date("Y-m-d"),date("H:i:s"));
    if($objUsuariosEncuesta->has_value){
        $fp = fopen($ruta_log,"a");
        fwrite($fp, date("H:i:s")." encontro usuarios para encuestar \n");
        fclose($fp);
        
        foreach($objUsuariosEncuesta->array_campos as $contacto){
            $fp = fopen($ruta_log,"a");
            fwrite($fp, date("H:i:s")." busca los datos del consumidor {$contacto['UPA_CON_ID']} \n");
            fclose($fp);
            
            $objConsumidores->get_consumidor_por_id($contacto['UPA_CON_ID']);
            if($objConsumidores->has_value){            
                $fp = fopen($ruta_log,"a");
                fwrite($fp, date("H:i:s")." encontro los datos del consumidor \n");
                fclose($fp);
                
                $objConfiguracionEncuesta->get_configuracion_encuesta_por_sede($contacto['UPA_S_ID']);
            
                $nombre = ($objConfiguracionEncuesta->array_campos['CEVP_VAR_NOMBRE'] != '')?$objConsumidores->array_campos[$objConfiguracionEncuesta->array_campos['CEVP_VAR_NOMBRE']]:'';
                $celular = ($objConfiguracionEncuesta->array_campos['CEVP_VAR_CELULAR'] != '')?$objConsumidores->array_campos[$objConfiguracionEncuesta->array_campos['CEVP_VAR_CELULAR']]:'';
                $fijo = ($objConfiguracionEncuesta->array_campos['CEVP_VAR_FIJO'] != '')?$objConsumidores->array_campos[$objConfiguracionEncuesta->array_campos['CEVP_VAR_FIJO']]:'';
                $aux = ($objConfiguracionEncuesta->array_campos['CEVP_VAR_AUX'] != '')?$objConsumidores->array_campos[$objConfiguracionEncuesta->array_campos['CEVP_VAR_AUX']]:'';
                $correo = ($objConfiguracionEncuesta->array_campos['CEVP_VAR_CORREO'] != '')?$objConsumidores->array_campos[$objConfiguracionEncuesta->array_campos['CEVP_VAR_CORREO']]:'';
                $var1 = ($objConfiguracionEncuesta->array_campos['CEVP_VAR_VAR1'] != '')?$objConsumidores->array_campos[$objConfiguracionEncuesta->array_campos['CEVP_VAR_VAR1']]:'';
                $var2 = ($objConfiguracionEncuesta->array_campos['CEVP_VAR_VAR2'] != '')?$objConsumidores->array_campos[$objConfiguracionEncuesta->array_campos['CEVP_VAR_VAR2']]:'';
                $var3 = ($objConfiguracionEncuesta->array_campos['CEVP_VAR_VAR3'] != '')?$objConsumidores->array_campos[$objConfiguracionEncuesta->array_campos['CEVP_VAR_VAR3']]:'';
                
                $objWebServiceClient->crear_contacto_para_marcacion($objConfiguracionEncuesta->array_campos['CEVP_ID_LISTA'],$nombre,$celular,$fijo,$aux,$correo,$var1,$var2,$var3);
                
                $fp = fopen($ruta_log,"a");
                fwrite($fp, date("H:i:s")." crea el contacto {$objWebServiceClient->result} en virtual pbax \n");
                fclose($fp);
                
                $objWebServiceClient->marcar_contaco($objWebServiceClient->result);
                $objWebServiceClient->iniciar_lista_marcacion($objConfiguracionEncuesta->array_campos['CEVP_ID_LISTA']);
                if($objWebServiceClient->result == 'success'){
                    $fp = fopen($ruta_log,"a");
                    fwrite($fp, date("H:i:s")." coloco a marcar el contacto y se pone como encuestado el usuario {$contacto['UPA_ID']} \n");
                    fclose($fp);
                    $objUsuariosEncuesta->usuario_encuestado($contacto['UPA_ID']);
                }
            }
        }
    }else{
        $fp = fopen($ruta_log,"a");
        fwrite($fp, date("H:i:s")." no encontro usuarios para encuestar\n");
        fclose($fp);
    }
}

$fp = fopen($ruta_log,"a");
fwrite($fp, date("H:i:s")." termino la ejecucion del script \n");
fclose($fp);

?>