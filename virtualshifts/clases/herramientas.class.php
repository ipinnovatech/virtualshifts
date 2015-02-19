<?php

include_once("connect_db.class.php");



class Herramientas{

    var $con;

    var $has_value;
    
    var $consulta;
    
    var $array_campos;

    var $insert_id;
    
    var $total;
    
    var $resultado;     

    function Herramientas(){

        $this->con = new connect_db;

        $this->has_value = false;        
        
        $this->consulta;

        $this->array_campos = Array();

        $this->insert_id;
        
        $this->total;
        
        $this->resultado;

    }
    
    function obtener_dia_semana_espanol($dia){
        switch($dia){
            case 0:
                $this->resultado = 'DOMINGO';
                break;
            case 1:
                $this->resultado = 'LUNES';
                break;
            case 2:
                $this->resultado = 'MARTES';
                break;
            case 3:
                $this->resultado = 'MIERCOLES';
                break;
            case 4:
                $this->resultado = 'JUEVES';
                break;
            case 5:
                $this->resultado = 'VIERNES';
                break;
            case 6:
                $this->resultado = 'SABADO';
                break;
        }
    }
}

?>