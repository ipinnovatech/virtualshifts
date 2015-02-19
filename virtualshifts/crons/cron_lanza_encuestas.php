<?php
ini_set("display_errors",1);

exec("ps -ef | grep lanza_encuestas.php",$result);

$servicio_activo = false;

print_r($result);
foreach($result as $process){
    if(preg_match("/php -q \/var\/www\/html\/virtualshifts\/crons\/lanza_encuestas\.php/",$process)){
        $servicio_activo = true;        
    }
}

if(!$servicio_activo){
    echo "levanta el servicio";
    shell_exec('php -q /var/www/html/virtualshifts/crons/lanza_encuestas.php');
}
?>