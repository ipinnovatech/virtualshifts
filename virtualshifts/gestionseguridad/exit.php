<?php

session_start(); 

//include("../clases/usuario.class.php");
include_once '/var/www/html/virtualshifts/clases/data.php';


session_destroy();

header("Location: $app_url"); 



//$objUsuario = new Usuario;

//$objUsuario->registrar_deslogueo_usuario($_SESSION['sessionName'],$_SESSION['nombreCliente']);





?> 
