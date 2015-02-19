<?php
ini_set("display_errors",1);

include_once("../../../gestionseguridad/security.php");
include_once("../../../clases/gui.class.php");
include_once("../../../clases/clientes.class.php");

if($_SESSION['id_user_type'] != 9 && $_SESSION['id_user_type'] != 3){
    header("Location: ../../../gestionseguridad/exit.php");
}

$objGui = new GUI($_SESSION['id_user_type']);
$objClientes = new Clientes;

$id_cliente = (isset($_GET['code']))?$_GET['code']:0;

if($id_cliente != 0){
    $objClientes->get_client($id_cliente);
}

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8" />
    <meta name="product" content="Virtual MOBILE IPV" />
    <meta name="description" content="Gestion para el punto de venta" />
    <meta name="author" content="IP Innovatech" />

    <link href="../../../css/metro-bootstrap.css" rel="stylesheet" />
    <link href="../../../css/metro-bootstrap-responsive.css" rel="stylesheet" />
    <link href="../../../css/docs.css" rel="stylesheet" />
    <link href="../../../js/prettify/prettify.css" rel="stylesheet" />
    
    </a><link href="../../../css/simpleModal/basic.css" rel="stylesheet" />
    <link href="../../../css/simpleModal/basic_ie.css" rel="stylesheet" />
    <link href="../../../css/simpleModal/demo.css" rel="stylesheet" />
    <link href="../../../css/portal.css" rel="stylesheet" />
    <link href="../../../css/iconFont.css" rel="stylesheet" />
    
    <?php echo $objGui->icon; ?>
    <!--<link href="../../../css/dataTables/demo_table_jui.css" rel="stylesheet" />-->

    <!-- Load JavaScript Libraries -->
    <script src="../../../js/jquery/jquery.js"></script>
    <script src="../../../js/jquery/jquery.min.js"></script>
    <script src="../../../js/jquery/jquery.widget.min.js"></script>
    <script src="../../../js/jquery/jquery.mousewheel.js"></script>
    <script src="../../../js/jquery/jquery.easing.1.3.min.js"></script>
    <script src="../../../js/prettify/prettify.js"></script>
    <script src="../../../js/holder/holder.js"></script>
    
    <script src="../../../js/load-metro.js"></script>
    
    <script src="../../../js/dataTables/jquery.dataTables.js"></script>
    <script src="../../../js/dataTables/jquery.dataTables.min.js"></script>

    <script src="../../../js/funciones.js"></script>
        
    <script type="text/javascript">
                
        function cerrar_sesion(){
            window.location = '../../../gestionseguridad/exit.php';
        }
        
        
        function validar_inputs(input){
            if( $(input).val() != "" ){
                if($(input).parent().next().is('span')){
                    $(input).parent().next().remove('span');
                    $(input).parent().removeClass("error-state");
                    $(input).parent().removeClass("warning-state");
                    $(input).parent().removeClass("info-state");
                }
            }
        }
        
        function crear_cliente(){
            
            var formulario = document.getElementById("form_cliente");
            
            var form_cliente = $("#form_cliente").serialize();
            
            var has_error = false;
                        
            for(var i = 0; i < formulario.elements.length; i++){
                
                var campo = formulario.elements[i];
                
                if( $(campo).is(':checkbox') || $(campo).is(':hidden') || $(campo).is(':button') ){
                    continue;
                }
                if($(campo).attr("id") == "cedula"  || $(campo).attr("id") == "celular" || $(campo).attr("id") == "telefono" || $(campo).attr("id") == "virtualpbax"){
                    var status = verificar_campo(campo,'numeros');
                }else if($(campo).attr("id") == "e_mail"){
                    if($(campo).val() != ""){
                        var status = verificar_campo(campo,"correo");
                    }
                }else if($(campo).attr("id") == "webservice" || $(campo).attr("id") == "metodo" || $(campo).attr("id") == "variable" ){
                    var status = "";
                }else{
                    var status = verificar_campo(campo,2);
                }
                if(status == "error"){
                    has_error = true;
                }
            }
            
            if(has_error){
                return;
            }            
            
            $.ajax({
                type: "POST",
                url: '<?php echo ($objClientes->has_value)?'modificar_cliente.php':'crear_cliente.php' ?>',
                data: form_cliente,
                success: function(data) {
                                        
                    if(data == 'success'){ 
                        var html = '';
                        html += '<h3><strong>Cliente creado.</strong><h3>';
                        html += '<p>El cliente fue creado exitosamente<p>';
                        html += '<div style="text-align: center;" >';
                        html += '<button class="primary large" onclick="window.location = \'index.php\'; return false;">Aceptar</button>';
                        html += '</div>';
                        
                        $.Dialog({
                            shadow: true,
                            overlay: false,
                            icon: '<img src="http://184.168.29.222/virtualshifts/favicon.png" />',
                            title: 'Virtual Shifts',
                            width: 500,
                            padding: 10,
                            content: html,
                            onClose: function(_dialog){
                                window.location = 'index.php';
                            }
                        });                       
                    }else{  
                        if(data == 'existe'){
                            $.Notify({                                
                                content: "Cliente ya existe.",
                                style: {background: 'red', color: 'white'},
                                timeout: 5000,
                                width: 250,
                                height: 30                            
                            }); 
                        }else{
                            $.Notify({
                                content: "Ha ocurrido un error por favor intente mas tarde.",
                                style: {background: 'red', color: 'white'},
                                timeout: 5000,
                                width: 250,
                                height: 30                            
                            });
                        }                       
                    }
                }
            });
        }
    </script>

    <title>Virtual SHIFTS</title>
</head>
<body class="metro">
    <?php
        echo $objGui->get_header();
    ?>
    <div class="page">
        <div class="page-region">
            <div class="page-region-content">                
                <h1>
                    <a href="index.php?"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
                    <?php echo ($objClientes->has_value)?'Editar':'Crear' ?><small class="on-right">Cliente</small>
                </h1>
                
                <form action="javascript: crear_cliente();" id="form_cliente">
                <?php echo ($objClientes->has_value)?'<input type="hidden" name="cliente_id" id="cliente_id" value="'.$id_cliente.'" />':''; ?>                
                    <br />
                    <div class="span3 offset1" style="float: left; text-align: right; font-size: 12pt;">Raz&oacute;n social:&nbsp;</div>
                    <div class="input-control text size4">                        
                        <input name="razon" id="razon" type="text" onkeydown="validar_inputs(this)" placeholder="Razon social" value="<?php echo ($objClientes->has_value)?$objClientes->array_campos[0]['C_RAZON_SOCIAL']:''; ?>"/>
                        <button class="btn-clear"></button>
                    </div>
                    <br />
                    <div class="span3 offset1" style="float: left; text-align: right; font-size: 12pt;">NIT:&nbsp;</div>
                    <div class="input-control text size4">
                        <input name="nit" id="nit" type="text" onkeydown="validar_inputs(this)" placeholder="NIT" value="<?php echo ($objClientes->has_value)?$objClientes->array_campos[0]['C_NIT']:''; ?>"/>
                        <button class="btn-clear"></button>
                    </div>
                    <br />
                    <div class="span3 offset1" style="float: left; text-align: right; font-size: 12pt;">Direcci&oacute;n:&nbsp;</div>
                    <div class="input-control text size4">
                        <input name="direccion" id="direccion" type="text" onkeydown="validar_inputs(this)" placeholder="Direccion" value="<?php echo ($objClientes->has_value)?$objClientes->array_campos[0]['C_DIRECCION']:''; ?>"/>
                        <button class="btn-clear"></button>                        
                    </div>
                    <br />
                    <div class="span3 offset1" style="float: left; text-align: right; font-size: 12pt;">Tel&eacute;fono:&nbsp;</div>
                    <div class="input-control text size4">
                        <input name="telefono" id="telefono" type="tel" data-transform="input-control" onkeydown="validar_inputs(this)" placeholder="telefono" value="<?php echo ($objClientes->has_value)?$objClientes->array_campos[0]['C_TELEFONO']:''; ?>" />
                        <button class="btn-clear"></button>
                    </div>
                    <br />
                    <div class="span3 offset1" style="float: left; text-align: right; font-size: 12pt;">Representante:&nbsp;</div>
                    <div class="input-control text size4">
                        <input name="representante" id="representante" type="text" data-transform="input-control" onkeydown="validar_inputs(this)" placeholder="Representante" value="<?php echo ($objClientes->has_value)?$objClientes->array_campos[0]['C_NOMBRE_REPRESENTANTE']:''; ?>"/>
                        <button class="btn-clear"></button>
                    </div>
                    <br />
                    <div class="span3 offset1" style="float: left; text-align: right; font-size: 12pt;">E-mail Representante:&nbsp;</div>
                    <div class="input-control text size4">
                        <input name="e_mail" id="e_mail" type="text" data-transform="input-control" onkeydown="validar_inputs(this)" placeholder="E-mail Representante" value="<?php echo ($objClientes->has_value)?$objClientes->array_campos[0]['C_CORREO_REPRESENTANTE']:''; ?>" />
                        <button class="btn-clear"></button>
                    </div>
                    <br />
                    <div class="span3 offset1" style="float: left; text-align: right; font-size: 12pt;">Celular Representante:&nbsp;</div>
                    <div class="input-control text size4">
                        <input name="celular" id="celular" type="tel" data-transform="input-control" onkeydown="validar_inputs(this)" placeholder="Celular Representante" value="<?php echo ($objClientes->has_value)?$objClientes->array_campos[0]['C_CELULAR_REPRESENTANTE']:''; ?>"/>
                        <button class="btn-clear"></button>
                    </div>
                    <br />
                    <div class="span3 offset1" style="float: left; text-align: right; font-size: 12pt;">ID VirtualPBAX:&nbsp;</div>
                    <div class="input-control text size4">
                        <input name="virtualpbax" id="virtualpbax" type="tel" data-transform="input-control" onkeydown="validar_inputs(this)" placeholder="ID VirtualPBAX" value="<?php echo ($objClientes->has_value)?$objClientes->array_campos[0]['C_ID_VIRTUAL_PBAX']:''; ?>"/>
                        <button class="btn-clear"></button>
                    </div>
                    <br />
                    <div class="span3 offset1" style="float: left; text-align: right; font-size: 12pt;">URL WebService:&nbsp;</div>
                    <div class="input-control text size4">
                        <input name="webservice" id="webservice" type="text" data-transform="input-control"  placeholder="URL WebService" value="<?php echo ($objClientes->has_value)?$objClientes->array_campos[0]['C_URL_WEBSERVICE']:''; ?>"/>
                        <button class="btn-clear"></button>
                    </div>
                    <br />
                    <div class="span3 offset1" style="float: left; text-align: right; font-size: 12pt;">M&eacute;todo WebService:&nbsp;</div>
                    <div class="input-control text size4">
                        <input name="metodo" id="metodo" type="text" data-transform="input-control" placeholder="Metodo WebService" value="<?php echo ($objClientes->has_value)?$objClientes->array_campos[0]['C_METODO']:''; ?>"/>
                        <button class="btn-clear"></button>
                    </div>
                    <br />
                    <div class="span3 offset1" style="float: left; text-align: right; font-size: 12pt;">Variable WebService:&nbsp;</div>
                    <div class="input-control text size4">
                        <input name="variable" id="variable" type="text" data-transform="input-control" placeholder="Variable WebService" value="<?php echo ($objClientes->has_value)?$objClientes->array_campos[0]['C_VARIABLE']:''; ?>"/>
                        <button class="btn-clear"></button>
                    </div>
                    <br />
                    <button class="primary large offset5" type="submit">Guardar</button>
                </form>
                <br />
                <div class="grid">
                    <div class="row">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
        echo $objGui->get_footer();
    ?>
    </body>
</html>