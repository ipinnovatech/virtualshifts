<?php
ini_set("display_errors",1);

include_once("../../../../gestionseguridad/security.php");
include_once("../../../../clases/gui.class.php");
include_once("../../../../clases/sedes.class.php");
include_once("../../../../clases/configuracion_encuestas_virtual_pbax.class.php");
include_once("../../../../clases/web_service_client.class.php");
include_once("../../../../clases/clientes.class.php");

if($_SESSION['id_user_type'] != 10){
    header("Location: ../../../../gestionseguridad/exit.php");
}

$objGui = new GUI($_SESSION['id_user_type']);
$objSedes = new Sedes;
$objConfiguracionEncuestas = new ConfiguracionEncuestasVirtualPBAX;
$objWebServiceClient = new webServiceClient('http://ipvirtualmobile.com/virtualpbax/web_service_server/server.php?wsdl');
$objClientes = new Clientes;

$id_sede = (isset($_GET['code']))?$_GET['code']:0;

if($id_sede != 0){
    $objSedes->get_sede_por_id($id_sede);
    $objConfiguracionEncuestas->get_configuracion_encuesta_por_sede($id_sede);
}

$objClientes->get_client($_SESSION['cliente']);

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8" />
    <meta name="product" content="Virtual MOBILE IPV" />
    <meta name="description" content="Gestion para el punto de venta" />
    <meta name="author" content="IP Innovatech" />

    <link href="../../../../css/metro-bootstrap.css" rel="stylesheet" />
    <link href="../../../../css/metro-bootstrap-responsive.css" rel="stylesheet" />
    <link href="../../../../css/docs.css" rel="stylesheet" />
    <link href="../../../../css/iconFont.css" rel="stylesheet" />
    <link href="../../../../js/prettify/prettify.css" rel="stylesheet" />
    
    <link href="../../../../css/simpleModal/basic.css" rel="stylesheet" />
    <link href="../../../../css/simpleModal/basic_ie.css" rel="stylesheet" />
    <link href="../../../../css/simpleModal/demo.css" rel="stylesheet" />
    <link href="../../../../css/portal.css" rel="stylesheet" />
    
    <?php echo $objGui->icon; ?>
   
    <script src="../../../../js/jquery/jquery.js"></script>
    <script src="../../../../js/jquery/jquery.min.js"></script>
    <script src="../../../../js/jquery/jquery.widget.min.js"></script>
    <script src="../../../../js/jquery/jquery.mousewheel.js"></script>
    <script src="../../../../js/jquery/jquery.easing.1.3.min.js"></script>
    <script src="../../../../js/prettify/prettify.js"></script>
    <script src="../../../../js/holder/holder.js"></script>
    
    <script src="../../../../js/load-metro.js"></script>
        
    <script src="../../../../js/simpleModal/jquery.simplemodal.js"></script>

    <script src="../../../../js/funciones.js"></script>
        
    <script type="text/javascript">
                
        function cerrar_sesion(){
            window.location = '../../../../gestionseguridad/exit.php';
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
                
        function crear_configuracion_encuestas(){
            var formulario = document.getElementById("form_configuracion_encuestas");
            
            var form_configuracion_encuestas = $("#form_configuracion_encuestas").serialize();
            
            var has_error = false;
                        
            for(var i = 0; i < formulario.elements.length; i++){
                
                var campo = formulario.elements[i];
                
                if( $(campo).is(':checkbox') || $(campo).is(':hidden') || $(campo).is(':button') || $(campo).is('select') ){
                    continue;
                }
                   
                var status = verificar_campo(campo,'numeros');                                      
                
                if(status == "error"){
                    has_error = true;
                }                
            }            
            
            if(has_error){
                return;
            }
            
            $.ajax({
                type: "POST",
                url: 'configura_encuestas.php',
                data: form_configuracion_encuestas,
                success: function(data) {                    
                    if(data == 'success'){                        
                        $.Notify({
                            content: "Datos almacenados correctamente.",
                            style: {background: 'green', color: 'white'},
                            timeout: 5000,
                            width: 250,
                            height: 30                            
                        });
                        location.reload();                                               
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
            });
        }
        
    </script>

    <title>Virtual DATE SHIFTS</title>
</head>
<body class="metro" style="height: auto;">
    <?php
        echo $objGui->get_header();
    ?>
    <div class="page">
        <div class="page-region">
            <div class="page-region-content">                
                <h1>
                    <a href="../index.php"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
                    Encuestas<small class="on-right">Sede <?php echo $objSedes->array_sedes['S_NOMBRE']; ?></small>
                </h1>                
                
                <form action="javascript: crear_configuracion_encuestas();" id="form_configuracion_encuestas">
                    <input type="hidden" name="id_sede" id="id_sede" value="<?php echo $objSedes->array_sedes['S_ID']; ?>" />
                    <input type="hidden" name="crea" id="crea" value="<?php echo ($objConfiguracionEncuestas->has_value)?0:1; ?>" />
                    <div class="span3 offset1" style="float: left; text-align: right; font-size: 12pt;">Lista de Virtual PBAX<span class="fg-red">*</span>:&nbsp;</div>
                    <div class="input-control select size2">                        
                        <select id="lista" name="lista">
                            <?php
                                $objWebServiceClient->get_listas_marcacion($objClientes->array_campos[0]['C_ID_VIRTUAL_PBAX']);                                
                                if($objWebServiceClient->result['status'] != "error"){
                                    //print_r($objWebServiceClient->result);
                                    foreach($objWebServiceClient->result['datos'] as $lista){ ?>
                                        <option value="<?php echo $lista['ln_id']; ?>" <?php echo ($lista['ln_id']==$objConfiguracionEncuestas->array_campos['CEVP_ID_LISTA'])?'selected="selected"':''; ?> ><?php echo $lista['ln_nombre']; ?></option>
                                    <?php
                                    }
                                } 
                            ?>
                        </select>
                    </div>
                    <br />
                    <div class="grid fluid">
                        <div class="row">
                            <div class="span6">
                                <div class="span6" style="text-align: center;"><h4>Cantidad de encuestas&nbsp;</h4></div>
                                <br />
                                <br />                                
                                <div class="span3" style="float: left; text-align: right; font-size: 12pt;">Lunes<span class="fg-red">*</span>:&nbsp;</div>
                                <div class="input-control text size3">                        
                                    <input name="lunes" id="lunes" type="text" onkeydown="validar_inputs(this)" placeholder="0" value="<?php echo ($objConfiguracionEncuestas->has_value)?$objConfiguracionEncuestas->array_campos['CEVPS_CANTIDAD_LUNES']:''; ?>" />
                                    <button class="btn-clear"></button>
                                </div>
                                <br />
                                <div class="span3" style="float: left; text-align: right; font-size: 12pt;">Martes<span class="fg-red">*</span>:&nbsp;</div>
                                <div class="input-control text size3">                        
                                    <input name="martes" id="martes" type="text" onkeydown="validar_inputs(this)" placeholder="0" value="<?php echo ($objConfiguracionEncuestas->has_value)?$objConfiguracionEncuestas->array_campos['CEVPS_CANTIDAD_MARTES']:''; ?>" />
                                    <button class="btn-clear"></button>
                                </div>
                                <br />
                                <div class="span3" style="float: left; text-align: right; font-size: 12pt;">Miercoles<span class="fg-red">*</span>:&nbsp;</div>
                                <div class="input-control text size3">                        
                                    <input name="miercoles" id="miercoles" type="text" onkeydown="validar_inputs(this)" placeholder="0" value="<?php echo ($objConfiguracionEncuestas->has_value)?$objConfiguracionEncuestas->array_campos['CEVPS_CANTIDAD_MIERCOLES']:''; ?>" />
                                    <button class="btn-clear"></button>
                                </div>
                                <br />
                                <div class="span3" style="float: left; text-align: right; font-size: 12pt;">Jueves<span class="fg-red">*</span>:&nbsp;</div>
                                <div class="input-control text size3">                        
                                    <input name="jueves" id="jueves" type="text" onkeydown="validar_inputs(this)" placeholder="0" value="<?php echo ($objConfiguracionEncuestas->has_value)?$objConfiguracionEncuestas->array_campos['CEVPS_CANTIDAD_JUEVES']:''; ?>" />
                                    <button class="btn-clear"></button>
                                </div>
                                <br />
                                <div class="span3" style="float: left; text-align: right; font-size: 12pt;">Viernes<span class="fg-red">*</span>:&nbsp;</div>
                                <div class="input-control text size3">                        
                                    <input name="viernes" id="viernes" type="text" onkeydown="validar_inputs(this)" placeholder="0" value="<?php echo ($objConfiguracionEncuestas->has_value)?$objConfiguracionEncuestas->array_campos['CEVPS_CANTIDAD_VIERNES']:''; ?>" />
                                    <button class="btn-clear"></button>
                                </div>
                                <br />
                                <div class="span3" style="float: left; text-align: right; font-size: 12pt;">Sabado<span class="fg-red">*</span>:&nbsp;</div>
                                <div class="input-control text size3">                        
                                    <input name="sabado" id="sabado" type="text" onkeydown="validar_inputs(this)" placeholder="0" value="<?php echo ($objConfiguracionEncuestas->has_value)?$objConfiguracionEncuestas->array_campos['CEVPS_CANTIDAD_SABADO']:''; ?>" />
                                    <button class="btn-clear"></button>
                                </div>
                                <br />
                                <div class="span3" style="float: left; text-align: right; font-size: 12pt;">Domingo<span class="fg-red">*</span>:&nbsp;</div>
                                <div class="input-control text size3">                        
                                    <input name="domingo" id="domingo" type="text" onkeydown="validar_inputs(this)" placeholder="0" value="<?php echo ($objConfiguracionEncuestas->has_value)?$objConfiguracionEncuestas->array_campos['CEVPS_CANTIDAD_DOMINGO']:''; ?>" />
                                    <button class="btn-clear"></button>
                                </div>
                            </div>
                            <div class="span6">
                                <div class="span6" style="text-align: center;"><h4>Variables Virtual PBAX&nbsp;</h4></div>
                                <br />
                                <br />                                
                                <div class="span3" style="float: left; text-align: right; font-size: 12pt;">Nombre<span class="fg-red">*</span>:&nbsp;</div>
                                <div class="input-control select size3">                        
                                    <select id="nombre" name="nombre">
                                        <option value="">Seleccione ...</option>
                                        <option value="CO_NOMBRE" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_NOMBRE'] == 'CO_NOMBRE')?'selected="selected"':''; ?> >Nombre</option>
                                        <option value="CO_CEDULA" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_NOMBRE'] == 'CO_CEDULA')?'selected="selected"':''; ?>>C&eacute;dula</option>
                                        <option value="CO_DIRECCION" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_NOMBRE'] == 'CO_DIRECCION')?'selected="selected"':''; ?>>Direcci&oacute;n</option>
                                        <option value="CO_TELEFONO" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_NOMBRE'] == 'CO_TELEFONO')?'selected="selected"':''; ?>>Telefono</option>
                                        <option value="CO_CORREO" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_NOMBRE'] == 'CO_CORREO')?'selected="selected"':''; ?>>Correo</option>
                                        <option value="CO_CAMPO1" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_NOMBRE'] == 'CO_CAMPO1')?'selected="selected"':''; ?>>Empresa</option>
                                        <option value="CO_CAMPO2" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_NOMBRE'] == 'CO_CAMPO2')?'selected="selected"':''; ?>>Cliente</option>
                                        <option value="CO_CAMPO3" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_NOMBRE'] == 'CO_CAMPO3')?'selected="selected"':''; ?>>Tipo de empleado</option>
                                        <option value="CO_CAMPO4" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_NOMBRE'] == 'CO_CAMPO4')?'selected="selected"':''; ?>>Documentos entregados</option>
                                        <option value="CO_CAMPO5" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_NOMBRE'] == 'CO_CAMPO5')?'selected="selected"':''; ?>>Documentos recibidos</option>                                        
                                    </select>
                                </div>
                                <br />
                                <div class="span3" style="float: left; text-align: right; font-size: 12pt;">Celular<span class="fg-red">*</span>:&nbsp;</div>
                                <div class="input-control select size3">                        
                                    <select id="celular" name="celular">
                                        <option value="">Seleccione ...</option>
                                        <option value="CO_NOMBRE" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_CELULAR'] == 'CO_NOMBRE')?'selected="selected"':''; ?> >Nombre</option>
                                        <option value="CO_CEDULA" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_CELULAR'] == 'CO_CEDULA')?'selected="selected"':''; ?>>C&eacute;dula</option>
                                        <option value="CO_DIRECCION" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_CELULAR'] == 'CO_DIRECCION')?'selected="selected"':''; ?>>Direcci&oacute;n</option>
                                        <option value="CO_TELEFONO" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_CELULAR'] == 'CO_TELEFONO')?'selected="selected"':''; ?>>Telefono</option>
                                        <option value="CO_CORREO" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_CELULAR'] == 'CO_CORREO')?'selected="selected"':''; ?>>Correo</option>
                                        <option value="CO_CAMPO1" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_CELULAR'] == 'CO_CAMPO1')?'selected="selected"':''; ?>>Empresa</option>
                                        <option value="CO_CAMPO2" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_CELULAR'] == 'CO_CAMPO2')?'selected="selected"':''; ?>>Cliente</option>
                                        <option value="CO_CAMPO3" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_CELULAR'] == 'CO_CAMPO3')?'selected="selected"':''; ?>>Tipo de empleado</option>
                                        <option value="CO_CAMPO4" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_CELULAR'] == 'CO_CAMPO4')?'selected="selected"':''; ?>>Documentos entregados</option>
                                        <option value="CO_CAMPO5" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_CELULAR'] == 'CO_CAMPO5')?'selected="selected"':''; ?>>Documentos recibidos</option>                                        
                                    </select>
                                </div>
                                <br />
                                <div class="span3" style="float: left; text-align: right; font-size: 12pt;">Fijo:&nbsp;</div>
                                <div class="input-control select size3">                        
                                    <select id="fijo" name="fijo">
                                        <option value="">Seleccione ...</option>
                                        <option value="CO_NOMBRE" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_FIJO'] == 'CO_NOMBRE')?'selected="selected"':''; ?> >Nombre</option>
                                        <option value="CO_CEDULA" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_FIJO'] == 'CO_CEDULA')?'selected="selected"':''; ?>>C&eacute;dula</option>
                                        <option value="CO_DIRECCION" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_FIJO'] == 'CO_DIRECCION')?'selected="selected"':''; ?>>Direcci&oacute;n</option>
                                        <option value="CO_TELEFONO" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_FIJO'] == 'CO_TELEFONO')?'selected="selected"':''; ?>>Telefono</option>
                                        <option value="CO_CORREO" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_FIJO'] == 'CO_CORREO')?'selected="selected"':''; ?>>Correo</option>
                                        <option value="CO_CAMPO1" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_FIJO'] == 'CO_CAMPO1')?'selected="selected"':''; ?>>Empresa</option>
                                        <option value="CO_CAMPO2" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_FIJO'] == 'CO_CAMPO2')?'selected="selected"':''; ?>>Cliente</option>
                                        <option value="CO_CAMPO3" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_FIJO'] == 'CO_CAMPO3')?'selected="selected"':''; ?>>Tipo de empleado</option>
                                        <option value="CO_CAMPO4" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_FIJO'] == 'CO_CAMPO4')?'selected="selected"':''; ?>>Documentos entregados</option>
                                        <option value="CO_CAMPO5" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_FIJO'] == 'CO_CAMPO5')?'selected="selected"':''; ?>>Documentos recibidos</option>                                        
                                    </select>
                                </div>
                                <br />
                                <div class="span3" style="float: left; text-align: right; font-size: 12pt;">Auxiliar:&nbsp;</div>
                                <div class="input-control select size3">                        
                                    <select id="auxiliar" name="auxiliar">
                                        <option value="">Seleccione ...</option>
                                        <option value="CO_NOMBRE" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_AUX'] == 'CO_NOMBRE')?'selected="selected"':''; ?> >Nombre</option>
                                        <option value="CO_CEDULA" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_AUX'] == 'CO_CEDULA')?'selected="selected"':''; ?>>C&eacute;dula</option>
                                        <option value="CO_DIRECCION" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_AUX'] == 'CO_DIRECCION')?'selected="selected"':''; ?>>Direcci&oacute;n</option>
                                        <option value="CO_TELEFONO" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_AUX'] == 'CO_TELEFONO')?'selected="selected"':''; ?>>Telefono</option>
                                        <option value="CO_CORREO" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_AUX'] == 'CO_CORREO')?'selected="selected"':''; ?>>Correo</option>
                                        <option value="CO_CAMPO1" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_AUX'] == 'CO_CAMPO1')?'selected="selected"':''; ?>>Empresa</option>
                                        <option value="CO_CAMPO2" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_AUX'] == 'CO_CAMPO2')?'selected="selected"':''; ?>>Cliente</option>
                                        <option value="CO_CAMPO3" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_AUX'] == 'CO_CAMPO3')?'selected="selected"':''; ?>>Tipo de empleado</option>
                                        <option value="CO_CAMPO4" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_AUX'] == 'CO_CAMPO4')?'selected="selected"':''; ?>>Documentos entregados</option>
                                        <option value="CO_CAMPO5" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_AUX'] == 'CO_CAMPO5')?'selected="selected"':''; ?>>Documentos recibidos</option>
                                    </select>
                                </div>
                                <br />
                                <div class="span3" style="float: left; text-align: right; font-size: 12pt;">Correo:&nbsp;</div>
                                <div class="input-control select size3">                        
                                    <select id="correo" name="correo">
                                        <option value="">Seleccione ...</option>
                                        <option value="CO_NOMBRE" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_CORREO'] == 'CO_NOMBRE')?'selected="selected"':''; ?> >Nombre</option>
                                        <option value="CO_CEDULA" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_CORREO'] == 'CO_CEDULA')?'selected="selected"':''; ?>>C&eacute;dula</option>
                                        <option value="CO_DIRECCION" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_CORREO'] == 'CO_DIRECCION')?'selected="selected"':''; ?>>Direcci&oacute;n</option>
                                        <option value="CO_TELEFONO" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_CORREO'] == 'CO_TELEFONO')?'selected="selected"':''; ?>>Telefono</option>
                                        <option value="CO_CORREO" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_CORREO'] == 'CO_CORREO')?'selected="selected"':''; ?>>Correo</option>
                                        <option value="CO_CAMPO1" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_CORREO'] == 'CO_CAMPO1')?'selected="selected"':''; ?>>Empresa</option>
                                        <option value="CO_CAMPO2" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_CORREO'] == 'CO_CAMPO2')?'selected="selected"':''; ?>>Cliente</option>
                                        <option value="CO_CAMPO3" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_CORREO'] == 'CO_CAMPO3')?'selected="selected"':''; ?>>Tipo de empleado</option>
                                        <option value="CO_CAMPO4" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_CORREO'] == 'CO_CAMPO4')?'selected="selected"':''; ?>>Documentos entregados</option>
                                        <option value="CO_CAMPO5" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_CORREO'] == 'CO_CAMPO5')?'selected="selected"':''; ?>>Documentos recibidos</option>
                                    </select>
                                </div>
                                <br />
                                <div class="span3" style="float: left; text-align: right; font-size: 12pt;">Var1:&nbsp;</div>
                                <div class="input-control select size3">                        
                                    <select id="var1" name="var1">
                                        <option value="">Seleccione ...</option>
                                        <option value="CO_NOMBRE" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_VAR1'] == 'CO_NOMBRE')?'selected="selected"':''; ?> >Nombre</option>
                                        <option value="CO_CEDULA" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_VAR1'] == 'CO_CEDULA')?'selected="selected"':''; ?>>C&eacute;dula</option>
                                        <option value="CO_DIRECCION" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_VAR1'] == 'CO_DIRECCION')?'selected="selected"':''; ?>>Direcci&oacute;n</option>
                                        <option value="CO_TELEFONO" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_VAR1'] == 'CO_TELEFONO')?'selected="selected"':''; ?>>Telefono</option>
                                        <option value="CO_CORREO" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_VAR1'] == 'CO_CORREO')?'selected="selected"':''; ?>>Correo</option>
                                        <option value="CO_CAMPO1" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_VAR1'] == 'CO_CAMPO1')?'selected="selected"':''; ?>>Empresa</option>
                                        <option value="CO_CAMPO2" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_VAR1'] == 'CO_CAMPO2')?'selected="selected"':''; ?>>Cliente</option>
                                        <option value="CO_CAMPO3" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_VAR1'] == 'CO_CAMPO3')?'selected="selected"':''; ?>>Tipo de empleado</option>
                                        <option value="CO_CAMPO4" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_VAR1'] == 'CO_CAMPO4')?'selected="selected"':''; ?>>Documentos entregados</option>
                                        <option value="CO_CAMPO5" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_VAR1'] == 'CO_CAMPO5')?'selected="selected"':''; ?>>Documentos recibidos</option>
                                    </select>
                                </div>
                                <br />
                                <div class="span3" style="float: left; text-align: right; font-size: 12pt;">Var2:&nbsp;</div>
                                <div class="input-control select size3">                        
                                    <select id="var2" name="var2">
                                        <option value="">Seleccione ...</option>
                                        <option value="CO_NOMBRE" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_VAR2'] == 'CO_NOMBRE')?'selected="selected"':''; ?> >Nombre</option>
                                        <option value="CO_CEDULA" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_VAR2'] == 'CO_CEDULA')?'selected="selected"':''; ?>>C&eacute;dula</option>
                                        <option value="CO_DIRECCION" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_VAR2'] == 'CO_DIRECCION')?'selected="selected"':''; ?>>Direcci&oacute;n</option>
                                        <option value="CO_TELEFONO" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_VAR2'] == 'CO_TELEFONO')?'selected="selected"':''; ?>>Telefono</option>
                                        <option value="CO_CORREO" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_VAR2'] == 'CO_CORREO')?'selected="selected"':''; ?>>Correo</option>
                                        <option value="CO_CAMPO1" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_VAR2'] == 'CO_CAMPO1')?'selected="selected"':''; ?>>Empresa</option>
                                        <option value="CO_CAMPO2" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_VAR2'] == 'CO_CAMPO2')?'selected="selected"':''; ?>>Cliente</option>
                                        <option value="CO_CAMPO3" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_VAR2'] == 'CO_CAMPO3')?'selected="selected"':''; ?>>Tipo de empleado</option>
                                        <option value="CO_CAMPO4" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_VAR2'] == 'CO_CAMPO4')?'selected="selected"':''; ?>>Documentos entregados</option>
                                        <option value="CO_CAMPO5" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_VAR2'] == 'CO_CAMPO5')?'selected="selected"':''; ?>>Documentos recibidos</option>
                                    </select>
                                </div>
                                <br />
                                <div class="span3" style="float: left; text-align: right; font-size: 12pt;">Var3:&nbsp;</div>
                                <div class="input-control select size3">                        
                                    <select id="var3" name="var3">
                                        <option value="">Seleccione ...</option>
                                        <option value="CO_NOMBRE" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_VAR3'] == 'CO_NOMBRE')?'selected="selected"':''; ?> >Nombre</option>
                                        <option value="CO_CEDULA" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_VAR3'] == 'CO_CEDULA')?'selected="selected"':''; ?>>C&eacute;dula</option>
                                        <option value="CO_DIRECCION" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_VAR3'] == 'CO_DIRECCION')?'selected="selected"':''; ?>>Direcci&oacute;n</option>
                                        <option value="CO_TELEFONO" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_VAR3'] == 'CO_TELEFONO')?'selected="selected"':''; ?>>Telefono</option>
                                        <option value="CO_CORREO" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_VAR3'] == 'CO_CORREO')?'selected="selected"':''; ?>>Correo</option>
                                        <option value="CO_CAMPO1" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_VAR3'] == 'CO_CAMPO1')?'selected="selected"':''; ?>>Empresa</option>
                                        <option value="CO_CAMPO2" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_VAR3'] == 'CO_CAMPO2')?'selected="selected"':''; ?>>Cliente</option>
                                        <option value="CO_CAMPO3" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_VAR3'] == 'CO_CAMPO3')?'selected="selected"':''; ?>>Tipo de empleado</option>
                                        <option value="CO_CAMPO4" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_VAR3'] == 'CO_CAMPO4')?'selected="selected"':''; ?>>Documentos entregados</option>
                                        <option value="CO_CAMPO5" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_VAR3'] == 'CO_CAMPO5')?'selected="selected"':''; ?>>Documentos recibidos</option>
                                        <option value="sede" <?php echo ($objConfiguracionEncuestas->array_campos['CEVP_VAR_VAR3'] == 'sede')?'selected="selected"':''; ?>>Sede</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>                    
                    <br />                    
                    <button class="primary large offset4" type="submit">Guardar</button>                    
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