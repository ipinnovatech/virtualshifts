<?php

include_once("connect_db.class.php");



class Sedes{

    var $con;

    var $has_value;

    var $consulta;

    var $array_sedes;

    var $result;

    var $insert_id;


    function Sedes(){

        $this->con = new connect_db;

        $this->has_value = false;

        $this->consulta;

        $this->array_sedes = Array();

        $this->insert_id;

        $this->result;

    }

    function get_sedes(){

        $this->array_sedes = array();
        $this->has_value = false;

        if($this->con->Conectarse()==true){
            $query="SELECT * FROM SEDES ";

            //echo $query;
            $this->consulta = $this->con->conect->query( $query );

            if($this->consulta->num_rows > 0){
                $this->has_value = true;
                while($row = $this->consulta->fetch_assoc()){
                    $this->array_sedes[] = $row;
                }
            }
            return $this->array_sedes;
        }
    }

    function get_sedes_activas_por_cliente($cliente){

        $this->array_sedes = array();
        $this->has_value = false;

        if($this->con->Conectarse()==true){
            $query="SELECT * FROM SEDES LEFT JOIN LOGOS ON S_LOGO = L_ID WHERE S_C_ID = $cliente AND S_ACTIVO = 1;";

            //echo $query;
            $this->consulta = $this->con->conect->query( $query );

            if($this->consulta->num_rows > 0){
                $this->has_value = true;
                while($row = $this->consulta->fetch_assoc()){
                    $this->array_sedes[] = $row;
                }
            }
            return $this->array_sedes;
        }
    }

    function get_sedes_por_cliente($cliente){

        $this->array_sedes = array();
        $this->has_value = false;

        if($this->con->Conectarse()==true){
            $query="SELECT * FROM SEDES LEFT JOIN LOGOS ON S_LOGO = L_ID WHERE S_C_ID = $cliente ORDER BY S_ACTIVO DESC;";

            //echo $query;
            $this->consulta = $this->con->conect->query( $query );

            if($this->consulta->num_rows > 0){
                $this->has_value = true;
                while($row = $this->consulta->fetch_assoc()){
                    $this->array_sedes[] = $row;
                }
            }
            return $this->array_sedes;
        }
    }

    function get_sede_por_id($id){

        $this->array_sedes = array();
        $this->has_value = false;

        if($this->con->Conectarse()==true){
            $query="SELECT * FROM SEDES WHERE S_ID = $id";

            //echo $query;
            $this->consulta = $this->con->conect->query( $query );

            if($this->consulta->num_rows > 0){
                $this->has_value = true;
                $row = $this->consulta->fetch_assoc();
                $this->array_sedes = $row;
            }
            return $this->array_sedes;
        }
    }

    function get_sede_por_id_para_visor($id){

        $this->array_sedes = array();
        $this->has_value = false;

        if($this->con->Conectarse()==true){
            $query="SELECT * FROM SEDES LEFT JOIN LOGOS ON S_LOGO = L_ID WHERE S_ID = $id";

            //echo $query;
            $this->consulta = $this->con->conect->query( $query );

            if($this->consulta->num_rows > 0){
                $this->has_value = true;
                $row = $this->consulta->fetch_assoc();
                $this->array_sedes = $row;
            }
            return $this->array_sedes;
        }
    }

    function get_tabla_turnos_sede($id, $nombre){

        $this->has_value = false;

        if($this->con->Conectarse()==true){
            $query="SELECT COUNT(*) AS TOTAL FROM information_schema.TABLES WHERE TABLE_SCHEMA = 'VIRTUALSHIFTS' AND TABLE_NAME = 'TURNOS_SEDE_".strtoupper($nombre)."_$id';";

            //echo $query;
            $this->consulta = $this->con->conect->query( $query );

            if($this->consulta->num_rows > 0){
                $this->has_value = true;
                $row = $this->consulta->fetch_assoc();
                $this->result = $row['TOTAL'];
            }
            return $this->result;
        }
    }

    function crear_sede($nobmre, $descrip, $cliente, $cantidad_encuestas, $areas){
        $this->has_value = false;

        if($this->con->Conectarse()==true){
            $query="SELECT S_ID FROM SEDES WHERE S_NOMBRE = '$nobmre'";
            //echo $query;
            $this->consulta = $this->con->conect->query( $query );
            $row = $this->consulta->fetch_assoc();

            if($row['S_ID'] > 0){
                $this->consulta = false;
                $this->insert_id = $row['S_ID'];
            }else{
                $query="INSERT INTO SEDES( S_NOMBRE, S_DESCRIPCION, S_C_ID, S_CANTIDAD_ENCUESTAS, S_ACTIVO) VALUES ('$nobmre', '$descrip', $cliente, '$cantidad_encuestas', 1)";
                //echo $query;
                $this->consulta = $this->con->conect->query( $query );
                $this->insert_id = $this->con->conect->insert_id;

                if(count($areas) > 0){
                    $enum_area = "ID_AREA ENUM(".join(",",$areas).") NOT NULL";
                }else{
                    $enum_area = "ID_AREA INT(10) NOT NULL";
                }

                $query2 = "CREATE TABLE TURNOS_SEDE_".strtoupper($nobmre)."_".$this->insert_id." (
                           $enum_area,
                           ID INT(10) UNSIGNED AUTO_INCREMENT NOT NULL,
                           ID_CONSUMIDOR INT(10) UNSIGNED NOT NULL,
                           ATENDIO TINYINT(1) UNSIGNED NOT NULL,
                           ID_ASESOR INT(10) UNSIGNED NOT NULL,
                           FECHASYS TIMESTAMP NOT NULL,
                           PRIMARY KEY (ID_AREA,ID)
                        ) ENGINE = MyISAM ROW_FORMAT = DEFAULT";
                //echo $query2;
                $this->consulta = $this->con->conect->query( $query2 );
                return $this->consulta;
            }
        }
    }

    function agregar_area_en_sede($id, $nombre, $areas){
        $this->has_value = false;

        if($this->con->Conectarse()==true){
            $query="ALTER TABLE TURNOS_SEDE_".strtoupper($nombre)."_$id
                     CHANGE ID_AREA ID_AREA ENUM(".join(",",$areas).") NOT NULL;";
            //echo $query;
            $this->consulta = $this->con->conect->query( $query );
            return $this->consulta;
        }
    }

    function activar_sede($id, $activo){
        $this->has_value = false;

        if($this->con->Conectarse()==true){
            $query="UPDATE SEDES SET S_ACTIVO = $activo WHERE S_ID = $id";
            //echo $query;
            $this->consulta = $this->con->conect->query( $query );
            return $this->consulta;
        }
    }

    function activar_muestra_video_por_sede($id, $activo){
        $this->has_value = false;

        if($this->con->Conectarse()==true){
            $query="UPDATE SEDES SET S_MUESTRA_VIDEO = $activo WHERE S_ID = $id";
            //echo $query;
            $this->consulta = $this->con->conect->query( $query );
            return $this->consulta;
        }
    }

    function actualizar_gcm_id_por_sede($id, $gcm_id){
        $this->has_value = false;

        if($this->con->Conectarse()==true){
            $query="UPDATE SEDES SET S_REG_ID = '$gcm_id' WHERE S_ID = $id";
            //echo $query;
            $this->consulta = $this->con->conect->query( $query );
            return $this->consulta;
        }
    }

    function actualizar_sede($id, $nobmre, $descrip, $cantidad_encuestas){
        $this->has_value = false;

        if($this->con->Conectarse()==true){
            $query="UPDATE SEDES SET S_NOMBRE = '$nobmre', S_DESCRIPCION = '$descrip', S_CANTIDAD_ENCUESTAS = '$cantidad_encuestas' WHERE S_ID = $id";
            //echo $query;
            $this->consulta = $this->con->conect->query( $query );
            return $this->consulta;
        }
    }

    function actualizar_logo_en_sede($id, $logo){
        $this->has_value = false;

        if($this->con->Conectarse()==true){
            $query="UPDATE SEDES SET S_LOGO = $logo WHERE S_ID = $id";
            //echo $query;
            $this->consulta = $this->con->conect->query( $query );
            return $this->consulta;
        }
    }

    function truncar_tabla_sede($nombre, $id){
        if($this->con->Conectarse()==true){
            $query="TRUNCATE TABLE TURNOS_SEDE_".strtoupper($nombre)."_".$id;
            //echo $query;
            $this->consulta = $this->con->conect->query( $query );
            return $this->consulta;
        }
    }
}

?>