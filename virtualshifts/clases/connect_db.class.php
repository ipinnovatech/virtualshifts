<?php

class connect_db
{

    var $conect;

    var $host;
    var $user;
    var $password;
    var $name_db;
    
    function connect_db(){
        include( "data.php" );
        
        $this->host = $host;
        $this->user = $bd_user;
        $this->password = $bd_password;
        $this->name_db = $bd_name;
    }
    
//    function connect_db_cliente(){
//        include ( "data.php" );
//        $this->name_db = $bd_cliente_name;
//    }

    function Conectarse(){
        if ( !( $conexion = new mysqli( $this->host, $this->user, $this->password, $this->name_db ) ) ) {
            echo "Error al conectar a la base de datos";
            exit();

        }
        $this->conect = $conexion;
        return true;
        //$conexion->close();
    }
    function Desconectarse(){
        if ( !$this->conect->close() ) {
            return false;
        }else{
            return true;
        }
    }

}

?>