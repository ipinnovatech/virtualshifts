<?php

//Inicio la sesi�n 

session_start();

//echo $_SESSION["autentificado"];

include_once '/var/www/html/virtualshifts/clases/data.php';

//COMPRUEBA QUE EL USUARIO ESTA AUTENTIFICADO 

if ($_SESSION["autentificado"]!="SI") {

   	//si no existe, envio a la p�gina de autentificacion 

   	header("Location:$app_url"); 

   	//ademas salgo de este script

   	exit();

}

?>