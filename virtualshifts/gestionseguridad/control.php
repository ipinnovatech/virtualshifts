<?php
ini_set('display_errors','1');

include ("../clases/usuarios.class.php" );
include ("../clases/securimage/securimage.php" );

session_start();

$username = $_POST['username'];
$password = $_POST['password'];

$securimage = new Securimage();

if ($securimage->check($_POST['captcha_code']) != false) {
   
    $objUsuario = new Users;

    $result['status'] = "error";
    $result['error_description'] = "empty";
    $result['data'] = array();

    if ( $objUsuario->validar_user( $username ) == true ) {
    
        $_SESSION["autentificado"] = "SI";
        
        $_SESSION['nombres'] = $objUsuario->nombres;
        $_SESSION['apellidos'] = $objUsuario->apellidos;
        $_SESSION['id_user_type'] = $objUsuario->id_tipo_usuario;
        $_SESSION['u_id'] = $objUsuario->id;
        $_SESSION['cliente'] = $objUsuario->cliente;        
        $_SESSION['username'] = $objUsuario->nick;
        
        if( $objUsuario->password != md5($password) ){
            $result['status'] = "error";
            $result['error_description'] = "pass_not_match";
            $result['data'] = array('url' => "index.php");
            $_SESSION["autentificado"] = "NO";
            print_r(json_encode($result));
            exit;
        }
        
        if( !$objUsuario->con->Desconectarse() )
            echo "Ha ocurrido un error al cerrar la conexion a la base de datos.";
        
        if( $objUsuario->id_tipo_usuario == 9 ){ // Superadmin
            $result['status'] = "success";
            $result['error_description'] = "";
            $result['data'] = array('url' => "page/superadmin/index.php", "user_type" => "superadmin");
            
            print_r(json_encode($result));
            exit;
        }else if( $objUsuario->id_tipo_usuario == 10 ){ //Administrador del cliente
            $result['status'] = "success";
            $result['error_description'] = "";
            $result['data'] = array('url' => "page/admin/index.php", "user_type" => "administrador");
            
            print_r(json_encode($result));
            exit;
        }else if( $objUsuario->id_tipo_usuario == 11 ){ //Asesor
            $result['status'] = "success";
            $result['error_description'] = "";
            $result['data'] = array('url' => "page/asesor/index.php", "user_type" => "asesor");
            
            $_SESSION['crea_turno'] = $objUsuario->crea_turno;
            $_SESSION['gestiona_turno'] = $objUsuario->gestiona_turno;
            $_SESSION['administra_sede'] = $objUsuario->administra_sede;
            $_SESSION['foto'] = $objUsuario->foto;
            
            print_r(json_encode($result));
            exit;
        }           
        //$objUsuario->registrar_logueo_usuario( $userName, $objUsuario->usuario['nombreCliente'] );
    } else {
        $result['status'] = "error";
        $result['error_description'] = "user_dose_not_exist";
        $result['data'] = array('url' => "index.php");
        
        print_r(json_encode($result));
        exit;
        //header( "Location: ../index.html?errorusuario=si" );
    }
}else{
    $result['status'] = "error";
    $result['error_description'] = "captcha_error";
    $result['data'] = array('url' => "index.php");
    
    print_r(json_encode($result));
    exit;
}
?>