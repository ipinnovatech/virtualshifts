<?php
class webServiceClient{
    var $cliente;
    var $error = false;
    var $errorDescription;
    var $result;
    
    function webServiceClient($url_webservice){
        include('nusoap/lib/nusoap.php');        
        $this->cliente = new nusoap_client($url_webservice, 'wsdl');
        $this->cliente->soap_defencoding = 'UTF-8';
        $this->cliente->decode_utf8 = false;
        if ($sError = $this->cliente->getError()) {
            $this->error = true;
            $this->errorDescription = "No se pudo realizar la operaci&oacute;n [" . $sError . "]";
        }
    }
    
    function get_info_usuario($metodo, $nombre_variable, $variable){
        $params = array($nombre_variable => $variable);
        $this->result = $this->cliente->call($metodo,$params);
    }
    
    function crear_contacto_para_marcacion($id_lista, $nombre, $celular, $fijo, $auxiliar, $correo, $var1, $var2, $var3){
        $params = array("id_lista" => $id_lista, "nombre" => $nombre, "celular" => $celular, "fijo" => $fijo, "auxiliar" => $auxiliar, "correo" => $correo, "var1" => $var1, "var2" => $var2, "var3" => $var3);
        $this->result = $this->cliente->call('crear_contacto_lista_marcacion',$params);
    }
    
    function marcar_contaco($id_contacto){
        $params = array("id_contacto" => $id_contacto);
        $this->result = $this->cliente->call('marca_contacto',$params);
    }
    
    function iniciar_lista_marcacion($id_lista){
        $params = array("id_lista" => $id_lista);
        $this->result = $this->cliente->call('iniciar_lista_marcacion',$params);
    }
    
    function get_listas_marcacion($id_cliente){
        $params = array("id_cliente" => $id_cliente);
        $this->result = $this->cliente->call('mostrar_listas_por_cliente',$params);
    }
}
?>