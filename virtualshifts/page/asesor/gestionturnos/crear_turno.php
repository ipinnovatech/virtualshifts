<?php
ini_set("display_errors",1);
header('Content-Type: text/html; charset=iso-8859-1'); 
include_once("../../../gestionseguridad/security.php");
include_once("../../../clases/gui.class.php");
include_once("../../../clases/areas.class.php");

if($_SESSION['id_user_type'] != 11){
    header("Location: ../../../gestionseguridad/exit.php");
}

$objGui = new GUI($_SESSION['id_user_type']);
$objAreas = new Areas;

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
    <link href="../../../css/iconFont.css" rel="stylesheet" />
    <link href="../../../js/prettify/prettify.css" rel="stylesheet" />
    
    <link href="../../../css/simpleModal/basic.css" rel="stylesheet" />
    <link href="../../../css/simpleModal/basic_ie.css" rel="stylesheet" />
    <link href="../../../css/simpleModal/demo.css" rel="stylesheet" />
    <link href="../../../css/portal.css" rel="stylesheet" />
    
    <?php echo $objGui->icon; ?>
   
    <script src="../../../js/jquery/jquery.js"></script>
    <script src="../../../js/jquery/jquery.min.js"></script>
    <script src="../../../js/jquery/jquery.widget.min.js"></script>
    <script src="../../../js/jquery/jquery.mousewheel.js"></script>
    <script src="../../../js/jquery/jquery.easing.1.3.min.js"></script>
    <script src="../../../js/prettify/prettify.js"></script>
    <script src="../../../js/holder/holder.js"></script>
    
    <script src="../../../js/load-metro.js"></script>
        
    <script src="../../../js/simpleModal/jquery.simplemodal.js"></script>

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
        
        function get_info_usuario(){
            var cedula = $("#cedula").val();
            $('#basic-modal-content').modal({
                opacity: 40,
                closeClass: 'closeModal'
            });
            
            $.ajax({
                type: "POST",
                url: 'get_info_usuario.php',
                dataType: 'json',
                data: {cedula: cedula},
                success: function(data){
                     if(data.datos.nombre != ''){
                        $("#nombre").val(data.datos.nombre);
                     }
                     if(data.datos.direccion != ''){
                        $("#direccion").val(data.datos.direccion);
                     }
                     if(data.datos.telefono != ''){
                        $("#telefono").val(data.datos.telefono);
                     }
                     if(data.datos.correo != ''){
                        $("#mail").val(data.datos.correo);
                     } 
                     if(data.datos.campo1 != ''){
                        $("#campo1").val(data.datos.campo1);
                     }
                     if(data.datos.campo2 != ''){
                        $("#campo2").val(data.datos.campo2);
                     }
                     if(data.datos.campo3 != ''){
                        $("#campo3").val(data.datos.campo3);
                     }
                     if(data.datos.campo4 != ''){
                        $("#campo4").val(data.datos.campo4);
                     }
                     if(data.datos.campo5 != ''){
                        $("#campo5").val(data.datos.campo5);
                     }
                     $(".closeModal").click();
                }
            });
        }
                
        function crear_turno(){
            $('#basic-modal-content').modal({
                opacity: 40,
                closeClass: 'closeModal'
            });
            var formulario = document.getElementById("form_turno");
            
            var form_area = $("#form_turno").serialize();
            
            var area = $("#area").val();
            
            var has_error = false;
                        
            for(var i = 0; i < formulario.elements.length; i++){
                
                var campo = formulario.elements[i];
                
                if( $(campo).is(':checkbox') || $(campo).is(':hidden') || $(campo).is(':button') ){
                    continue;
                }
                
                if($(campo).attr("id") == "telefono" ){
                    var status = verificar_campo(campo,'numeros');
                }else if($(campo).attr("id") == "mail"){
                    var status = verificar_campo(campo,"correo");
                }else if($(campo).attr("id") == "nombre"){
                    var status = verificar_campo(campo,"3");
                }else if($(campo).attr("id") == "observacion"){
                    var status = verificar_campo(campo,"3");
                }else if($(campo).attr("id") == "direccion"){ 
                    var status = verificar_campo(campo,"dir");
                }else{
                    var status = verificar_campo(campo,"2");
                }
                
                if(status == "error"){
                    has_error = true;
                }
            }
            
            if(has_error){
                $(".closeModal").click();
                return;
            }
            
            if(area == 0){
                alert("Por favor seleccione un area");
                $(".closeModal").click();
                return false;
            }
            
            $.ajax({
                type: "POST",
                url: 'generar_turno.php',
                dataType: 'json',
                data: form_area,
                success: function(data) {
                    $(".closeModal").click();
                    if(data.status == 'success'){
                        var html = '';
                        html += '<h3><strong>Turno creado.</strong><h3>';
                        html += '<p>Los datos del turno son los siguientes:<p>';
                        html += '<p>Turno:  '+data.area+data.turno+'<p>';
                        html += '<div style="text-align: center;" >';
                        html += '<button class="primary large" onclick="location.reload(); return false;">Aceptar</button>';
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
                                location.reload();
                            }
                        });
                    }else{
                        var html = '';
                        html += '<h3><strong>Turno no creado.</strong><h3>';
                        html += '<p>No se pudo crear el turno por favor intente de nuevo<p>';
                        html += '<div style="text-align: center;" >';
                        html += '<button class="primary large" onclick="return false;">Aceptar</button>';
                        html += '</div>';
                        
                        $.Dialog({
                            shadow: true,
                            overlay: false,
                            icon: '<img src="http://184.168.29.222/virtualshifts/favicon.png" />',
                            title: 'Virtual Shifts',
                            width: 500,
                            padding: 10,
                            content: html
                        });
                    }
                }
            });
        }
        
    </script>

    <title>Virtual DATE SHIFTS</title>
</head>
<body class="metro" style="height: auto;">
    <div style="width: 300px; height: 300px; margin-left: auto; margin-right: auto;" id="basic-modal-content" class="bg-transparent fg-white">
        <img style="display: block; margin-left: auto; margin-right: auto;" src="../../../images/loading_blanco.gif" />
	</div>
    <?php
        echo $objGui->get_header();
    ?>
    <div class="page">
        <div class="page-region">
            <div class="page-region-content">                
                <h1>
                    <a href="../index.php"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
                    Crear<small class="on-right">Turno</small>
                </h1>                
                
                <form action="javascript: crear_turno();" id="form_turno">
                    <?php echo ($objAreas->has_value)?'<input type="hidden" name="id_area" id="id_area" value="'.$objAreas->array_areas['AR_ID'].'" />':''; ?>
                    <br />
                    <div class="span2 offset1" style="float: left; text-align: right; font-size: 12pt;">C&eacute;dula<span class="fg-red">*</span>:&nbsp;</div>
                    <div class="input-control text size4">                        
                        <input name="cedula" id="cedula" type="text" onkeydown="validar_inputs(this)" placeholder="C&eacute;dula" value="" />
                        <button class="btn-clear"></button>
                    </div>
                    <button class="button primary" onclick="get_info_usuario(); return false;">Buscar</button>
                    <br />
                    <div class="span2 offset1" style="float: left; text-align: right; font-size: 12pt;">Area:&nbsp;</div>
                    <div class="input-control select size4">
                        <select id="area" name="area">
                            <option value="0">Seleccione ...</option>
                            <?php
                                $objAreas->get_areas_activas_por_cliente($_SESSION['cliente']);
                                if($objAreas->has_value){
                                    foreach($objAreas->array_areas as $row){ ?>
                                        <option value="<?php echo $row['AR_ID']; ?>"><?php echo $row['AR_NOMBRE']; ?></option>
                                    <?php
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <br />
                    <div class="span2 offset1" style="float: left; text-align: right; font-size: 12pt;">Nombre completo:&nbsp;</div>
                    <div class="input-control text size4">                        
                        <input name="nombre" id="nombre" type="text" onkeydown="validar_inputs(this)" placeholder="Nombre" value="" />
                        <button class="btn-clear"></button>
                    </div>
                    <br />
                    <div class="span2 offset1" style="float: left; text-align: right; font-size: 12pt;">Direcci&oacute;n:&nbsp;</div>
                    <div class="input-control text size4">                        
                        <input name="direccion" id="direccion" type="text" onkeydown="validar_inputs(this)" placeholder="Direcci&oacute;n" value="" />
                        <button class="btn-clear"></button>
                    </div>
                    <br />
                    <div class="span2 offset1" style="float: left; text-align: right; font-size: 12pt;">Tel&eacute;fono:&nbsp;</div>
                    <div class="input-control text size4">                        
                        <input name="telefono" id="telefono" type="text" onkeydown="validar_inputs(this)" placeholder="Tel&eacute;fono" value="" />
                        <button class="btn-clear"></button>
                    </div>
                    <br />
                    <div class="span2 offset1" style="float: left; text-align: right; font-size: 12pt;">E-mail:&nbsp;</div>
                    <div class="input-control text size4">                        
                        <input name="mail" id="mail" type="text" onkeydown="validar_inputs(this)" placeholder="E-mail" value="" />
                        <button class="btn-clear"></button>
                    </div>
                    <br />
                    <div class="span2 offset1" style="float: left; text-align: right; font-size: 12pt;">Empresa:&nbsp;</div>
                    <div class="input-control text size4">                        
                        <input name="campo1" id="campo1" type="text" onkeydown="validar_inputs(this)" placeholder="Empresa" value="" />
                        <button class="btn-clear"></button>
                    </div>
                    <br />
                    <div class="span2 offset1" style="float: left; text-align: right; font-size: 12pt;">Cliente:&nbsp;</div>
                    <div class="input-control text size4">                        
                        <input name="campo2" id="campo2" type="text" onkeydown="validar_inputs(this)" placeholder="Cliente" value="" />
                        <button class="btn-clear"></button>
                    </div>
                    <br />
                    <div class="span2 offset1" style="float: left; text-align: right; font-size: 12pt;">Ciudad labor:&nbsp;</div>
                    <div class="input-control text size4">                        
                        <input name="campo3" id="campo3" type="text" onkeydown="validar_inputs(this)" placeholder="Ciudad labor" value="" />
                        <button class="btn-clear"></button>
                    </div>
                    <br />
                    <div class="span2 offset1" style="float: left; text-align: right; font-size: 12pt;">Observaci&oacute;n:&nbsp;</div>
                    <div class="input-control textarea size4">
                        <textarea id="observacion" name="observacion" onkeydown="validar_inputs(this)" placeholder="Observaci&oacute;n"></textarea>
                    </div>
                    <br />
                    <button class="primary large offset5" type="submit">Crear turno</button>                    
                </form>                
                <br />
            </div>
        </div>
    </div>
    <?php
        echo $objGui->get_footer();
    ?>
    </body>
</html>