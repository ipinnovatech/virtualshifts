<?php

include_once("connect_db.class.php");



class Users{

    var $con;

    var $has_value;
    
    var $password;
    
    var $nombres;
    
    var $apellidos;
    
    var $nick;
    
    var $id;
    
    var $tipo_usuario;
    
    var $id_tipo_usuario;
    
    var $consulta;

    var $array_usuarios;

    var $insert_id;
    
    var $id_movil;
    
    var $cliente;
    
    var $activo;
    
    var $crea_turno;
    
    var $gestiona_turno;
    
    var $administra_sede;
    
    var $ventanillas;
    
    var $sede;
    
    var $foto;

    function Users(){

        $this->con = new connect_db;

        $this->has_value = false;
        
        $this->password;
        
        $this->nombres;
        
        $this->apellidos;
        
        $this->nick;
        
        $this->id;
        
        $this->tipo_usuario;
        
        $this->id_tipo_usuario;
        
        $this->consulta;

        $this->array_usuarios = Array();
        
        $this->activo;
        
        $this->crea_turno;
        
        $this->gestiona_turno;
        
        $this->administra_sede;

        $this->insert_id;
        
        $this->id_movil;
        
        $this->cliente;

        $this->ventanillas;
        
        $this->sede;
        
        $this->foto;
    }

    //funcion utilizada en gestionseguridad/control.php

    function obtener_ventanillas($sede){
        if($this->con->Conectarse()==true){
            $query = "SELECT * FROM VENTANILLAS WHERE VENT_S_ID = '$sede'";
            //echo $query;
            $consulta = $this->con->conect->query($query);
                      
            $this->ventanillas = mysqli_fetch_array($consulta); 
            
            return $this->ventanillas;        
        }
    }
    function validar_user( $username ){

        if($this->con->Conectarse()==true){

            $username = mysqli_real_escape_string($this->con->conect,$username);
            
            $query = "SELECT * FROM USUARIOS INNER JOIN TIPO_USUARIOS ON TU_ID = U_TU_ID WHERE U_NICK = '$username';";
            
            $consulta = $this->con->conect->query($query);

            if($consulta->num_rows==0){
                return false;
            }else{
                
                $usuario = mysqli_fetch_array($consulta);
                
                $this->has_value = true;
                
                $this->password = $usuario['U_PASSWORD'];
                
                $this->nombres = $usuario['U_NOMBRE'];
                
                $this->apellidos = $usuario['U_APELLIDOS'];
                
                $this->tipo_usuario = $usuario['TU_NOMBRE'];
                
                $this->id_tipo_usuario = $usuario['TU_ID'];
                
                $this->nick = $usuario['U_NICK'];
                
                $this->id = $usuario['U_ID'];
                
                $this->cliente = $usuario['U_CLI_ID'];
                
                $this->crea_turno = $usuario['U_CREA_TURNO'];
                
                $this->gestiona_turno = $usuario['U_GESTIONA_TURNO'];
                
                $this->administra_sede = $usuario['U_ADMINISTRA_SEDE'];
                
                $this->foto = $usuario['U_URL_FOTO'];

                return true;
            }
        }
    }
    
    function crear_usuario($nombre, $apellido, $nick, $pass, $tipo, $cedula, $mail, $celular, $activo, $crea_turno, $gestiona_turno, $administra_sede, $cliente, $ventanilla){
        if($this->con->Conectarse()==true){
            $query = "INSERT INTO USUARIOS (U_NOMBRE, U_APELLIDOS, U_NICK, U_PASSWORD, U_TU_ID, U_CEDULA, U_CORREO, U_CELULAR, U_ACTIVO, U_CREA_TURNO, U_GESTIONA_TURNO, U_ADMINISTRA_SEDE, U_CLI_ID, U_VENT_ID) VALUES ('$nombre', '$apellido', '$nick', '".md5($pass)."', $tipo, '$cedula', '$mail', '$celular', $activo, $crea_turno, $gestiona_turno, $administra_sede, $cliente, $ventanilla);";
            //echo $query;
            $consulta = $this->con->conect->query($query);
            
            $this->insert_id = $this->con->conect->insert_id;
            
            return $consulta;
        }
    }
    
    function modificar_usuario($id, $nombre, $apellido, $nick, $cedula, $mail, $celular, $ventanilla){
        if($this->con->Conectarse()==true){
            $query = "UPDATE USUARIOS SET U_NOMBRE='$nombre', U_APELLIDOS='$apellido', U_NICK='$nick', U_CEDULA='$cedula', U_CORREO='$mail', U_CELULAR='$celular', U_VENT_ID=$ventanilla WHERE U_ID = $id;"; 
            //echo $query;
            $consulta = $this->con->conect->query($query);
                            
            return $consulta;
        }
    }
    
    function actulizar_foto($id, $url_foto){
        if($this->con->Conectarse()==true){
            $query = "UPDATE USUARIOS SET U_URL_FOTO = '$url_foto' WHERE U_ID = $id;"; 
            //echo $query;
            $consulta = $this->con->conect->query($query);
                            
            return $consulta;
        }
    }
    
    function validar_usuario($nombre){
        if($this->con->Conectarse()==true){
            $query = "SELECT * FROM USUARIOS WHERE U_NICK = '$nombre'";
            //echo $query;
            $consulta = $this->con->conect->query($query);
            if($consulta->numRows > 0){
                return true;
            }else{
                return false;
            }
        }
    }
    
    function mostrar_usuarios($cliente){
        $this->has_value = false;
        $this->array_usuarios = array();
        
        if($this->con->Conectarse()==true){
            $query = "SELECT * FROM USUARIOS INNER JOIN TIPO_USUARIOS ON TU_ID = U_TU_ID WHERE U_CLI_ID = '$cliente' ORDER BY U_ACTIVO DESC;";
            //echo $query;
            $consulta = $this->con->conect->query($query);
            
            if($consulta->num_rows > 0){
                $this->has_value = true;
                
                while($row = $consulta->fetch_assoc()){
                    $this->array_usuarios[] = $row;
                }
            }
        }       
    }
    
    function mostrar_usuarios_para_admin($cliente){
        $this->has_value = false;
        $this->array_usuarios = array();
        
        if($this->con->Conectarse()==true){
            $query = "SELECT * FROM USUARIOS INNER JOIN TIPO_USUARIOS ON TU_ID = U_TU_ID AND U_TU_ID != 9  WHERE U_CLI_ID = '$cliente' ORDER BY U_ACTIVO DESC;";
            //echo $query;
            $consulta = $this->con->conect->query($query);
            
            if($consulta->num_rows > 0){
                $this->has_value = true;
                
                while($row = $consulta->fetch_assoc()){
                    $this->array_usuarios[] = $row;
                }
            }
        }       
    }
    
    function get_user( $id ){

        if($this->con->Conectarse()==true){
            
            $query = "SELECT * FROM USUARIOS INNER JOIN TIPO_USUARIOS ON TU_ID = U_TU_ID WHERE U_ID = $id;";
            
            $consulta = $this->con->conect->query($query);

            if($consulta->num_rows==0){
                return false;
            }else{
                
                $usuario = mysqli_fetch_array($consulta);
                
                $this->has_value = true;
                
                $this->password = $usuario['U_PASSWORD'];
                
                $this->nombres = $usuario['U_NOMBRE'];
                
                $this->apellidos = $usuario['U_APELLIDOS'];
                
                $this->tipo_usuario = $usuario['TU_NOMBRE'];
                
                $this->cliente = $usuario['U_CLI_ID'];
                
                $this->id_tipo_usuario = $usuario['TU_ID'];
                
                $this->nick = $usuario['U_NICK'];
                
                $this->id = $usuario['U_ID'];
                
                $this->cedula  = $usuario['U_CEDULA'];
                
                $this->celular = $usuario['U_CELULAR'];
                
                $this->mail = $usuario['U_CORREO'];
                
                $this->activo = $usuario['U_ACTIVO'];
                
                $this->array_usuarios = $usuario;
                
                $this->ventanillas = $usuario['U_VENT_ID'];

                return true;
            }
        }
    }
    
    function modificar_password($id_usuario, $pass){
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){
            $query = "UPDATE USUARIOS SET U_PASSWORD = '".md5($pass)."' WHERE U_ID = $id_usuario;";
            //echo $query;
            $consulta = $this->con->conect->query($query);
                            
            return $consulta;
            
        }       
    }

    function activar_usuarios($id_usuario, $activo){
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){
            $query = "UPDATE USUARIOS SET U_ACTIVO = $activo WHERE U_ID = $id_usuario;";
            //echo $query;
            $consulta = $this->con->conect->query($query);
                            
            return $consulta;
        }       
    }
    function activar_crea_turno($id_usuario, $crea_turno){
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){
            $query = "UPDATE USUARIOS SET U_CREA_TURNO = $crea_turno WHERE U_ID = $id_usuario;";
            //echo $query;
            $consulta = $this->con->conect->query($query);
                            
            return $consulta;
        }       
    }
    function activar_gestiona_turno($id_usuario, $gestiona_turno){
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){
            $query = "UPDATE USUARIOS SET U_GESTIONA_TURNO = $gestiona_turno WHERE U_ID = $id_usuario;";
            //echo $query;
            $consulta = $this->con->conect->query($query);
                            
            return $consulta;
        }       
    }
    function activar_administra_sede($id_usuario, $administra_sede){
        $this->has_value = false;
        
        if($this->con->Conectarse()==true){
            $query = "UPDATE USUARIOS SET U_ADMINISTRA_SEDE = $administra_sede WHERE U_ID = $id_usuario;";
            //echo $query;
            $consulta = $this->con->conect->query($query);
                            
            return $consulta;
        }       
    }
    
    function get_sede_por_asesor($id){
        $this->has_value = false;
        if($this->con->Conectarse()==true){
            $query = "SELECT VENT_S_ID FROM USUARIOS INNER JOIN VENTANILLAS ON U_VENT_ID = VENT_ID WHERE U_ID = $id;";
            
            $consulta = $this->con->conect->query($query);

            if($consulta->num_rows > 0){
                $this->has_value = true;
                
                $row = $consulta->fetch_assoc();
                $this->ventanillas = $row['VENT_S_ID'];
            }
        }
    }
    
    function get_ventanilla_y_sede_por_asesor($id){
        $this->has_value = false;
        if($this->con->Conectarse()==true){
            $query = "SELECT VENT_S_ID, U_VENT_ID FROM USUARIOS INNER JOIN VENTANILLAS ON U_VENT_ID = VENT_ID WHERE U_ID = $id;";
            
            $consulta = $this->con->conect->query($query);

            if($consulta->num_rows > 0){
                $this->has_value = true;
                
                $row = $consulta->fetch_assoc();
                $this->sede = $row['VENT_S_ID'];
                $this->ventanillas = $row['U_VENT_ID'];
            }
        }
    }
}

?>