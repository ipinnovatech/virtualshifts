<?php
ini_set("display_errors",1);

include_once("../../../gestionseguridad/security.php");
include_once("../../../clases/gui.class.php");
include_once("../../../clases/tipo_usuario.class.php");
include_once("../../../clases/usuarios.class.php");
include_once("../../../clases/clientes.class.php");
include_once("../../../clases/sedes.class.php");

if($_SESSION['id_user_type'] != 9 && $_SESSION['id_user_type'] != 10){
    header("Location: ../../../gestionseguridad/exit.php");
}

$objGui = new GUI($_SESSION['id_user_type']);
$objTipoUsuarios = new TipoUsuarios;
$objUsuario = new Users;
$objClientes = new Clientes;
$objSedes = new Sedes;

$id_user = (isset($_GET['code']))?$_GET['code']:0;

if($id_user != 0){
    $objUsuario->get_user($id_user);
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
    
    <link href="../../../css/simpleModal/basic.css" rel="stylesheet" />
    <link href="../../../css/simpleModal/basic_ie.css" rel="stylesheet" />
    <link href="../../../css/simpleModal/demo.css" rel="stylesheet" />
    <link href="../../../css/portal.css" rel="stylesheet" />
    <link href="../../../css/iconFont.css" rel="stylesheet"/>
    
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
        
        function lanzar_modal(){
            $('#basic-modal-content').modal({
                opacity: 40,
                overlayClose: true,
                closeClass: 'closeModal'
            });
        }
        
        function cambiar_pass(){
            var pass = $("#pass").val();
            var rep_pass = $("#rep_pass").val();
            
            var id_user = $("#user_id").val();
            
            if(pass != rep_pass){
                console.log(pass+" - "+rep_pass);
                $("#pass").parent().addClass('error-state');
                $("#pass").parent().after('<span class="span2 fg-red" style="margin-left: 5px;">Los campos no coinciden</span>');
                $("#rep_pass").parent().addClass('error-state');
                $("#rep_pass").parent().after('<span class="span2 fg-red" style="margin-left: 5px;">Los campos no coinciden</span>');
                return;
            }
            
            $.ajax({
                type: "POST",
                url: 'cambiar_password_usuario.php',
                data: {pass: pass, id_user: id_user },
                success: function(data) {

                    if(data == 'success'){
                        
                        $.Notify({
                            content: "Cambios realizados con exito.",
                            style: {background: 'green', color: 'white'},
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
                    $(".closeModal").click();
                }
            });
        }
        
        function crear_usuario(){
            var pass = $("#password").val();
            
            var rep_pass = $("#rep_password").val();
            
            var usuario = $("#usuario").val();
            
            var formulario = document.getElementById("form_user");
            
            var form_user = $("#form_user").serialize();
            
            var has_error = false;
            
            var compartido = $("#compartido").val();
            
            $('#contienePermisos2').hide();
            $('#contienePermisos').hide();
                        
            if(pass != rep_pass){
                console.log(pass+" - "+rep_pass);
                $("#password").parent().addClass('error-state');
                $("#password").parent().after('<span class="span2 fg-red" style="margin-left: 5px;" >Los campos no coinciden</span>');
                $("#rep_password").parent().addClass('error-state');
                $("#rep_password").parent().after('<span class="span2 fg-red" style="margin-left: 5px;">Los campos no coinciden</span>');
                return;
            }
            
            for(var i = 0; i < formulario.elements.length; i++){
                
                var campo = formulario.elements[i];
                
                if( $(campo).is(':checkbox') || $(campo).is(':hidden') || $(campo).is(':button') ){
                    continue;
                }
                
                if($(campo).attr("id") == "cedula"  || $(campo).attr("id") == "celular" ){
                    var status = verificar_campo(campo,'numeros');
                }else if($(campo).attr("id") == "mail"){                    
                    var status = verificar_campo(campo,"correo");                                      
                }else if($(campo).attr("id") == "nick"){                    
                    var status = verificar_campo(campo,"1");                                      
                }else{
                    var status = verificar_campo(campo,2);
                }               
                
                
                if(status == "error"){
                    has_error = true;
                }                
            } 
            
            if($("#tipo_usuario").val() == 0){
                $("#tipo_usuario").parent().addClass('error-state');
                $("#tipo_usuario").parent().after('<span class="span2 fg-red" style="margin-left: 5px;">Debe seleccionar un tipo de usuario.</span>');
                has_error = true;
            }
            
            if(has_error){
                return;
            }
            
            $.ajax({
                type: "POST",
                url: '<?php echo ($objUsuario->has_value)?'modificar_usuario.php':'crear_usuario.php' ?>',
                data: form_user,
                dataType: 'json',
                success: function(data) {
                    
                    if(data.status == 'success'){
                        
                        var html = '';
                        html += '<h3><strong>Usuario <?php echo ($objUsuario->has_value)?'modificado':'creado'; ?>.</strong><h3>';
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
                        //window.location = 'index.php';
                                               
                    }else if(data.status == 'existe'){
                        $.Notify({
                            content: "Este nombre de usuario ya existe, por favor eliga otro.",
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
            });
        }
        
        function carga_perfiles(select){
            var tipo_usuario = $(select).val();
            
            if( $(select).val() != "" ){
                if($(select).parent().next().is('span')){
                    $(select).parent().next().remove('span');
                    $(select).parent().removeClass("error-state");
                    $(select).parent().removeClass("warning-state");
                    $(select).parent().removeClass("info-state");
                }
            }
            
            if(tipo_usuario == 2){                
                $("#compartido").removeAttr('disabled');                
            }else{                
                $("#compartido").attr('disabled', 'disabled');                
            }
        }
        
        function muestra_cliente(sel_compartido){
            var compartido = $(sel_compartido).val();
            
            if(compartido == 0){
                $("#is_movil").css('display', 'block');
                $("#cliente").removeAttr('disabled');
                $("#perfil").removeAttr('disabled');
            }else{
                $("#is_movil").css('display', 'none');
                $("#cliente").attr('disabled', 'disabled');
                $("#perfil").attr('disabled', 'disabled');
            }
        }
        function tipo_actual(selector){
            document.getElementById("crea_turno").checked = false;
            document.getElementById("gestiona_turno").checked = false;
            document.getElementById("administra_sede").checked = false;
            console.log($(selector).val());
            if($(selector).val() == 11){
                $('#contienePermisos').show();
                $('#contienePermisos2').show();
            }else{
                $('#contienePermisos').hide();
                $('#contienePermisos2').hide();
            }
        }
        function sede_actual(){
            var sede = $("#sedes").val();
            var ventanilla_actual = $('#ventanilla').val();
             $.ajax({
                type: "POST",
                url: 'select_sede.php',
                data: {sede:sede},
                dataType: 'json',
                success: function(data) {
                    
                    if(data.status == 'success'){
                       var html = '';
                        html += '<option value="0">Seleccione ...</option>'
                       $.each(data.datos , function(i){
                        var is_selected = '';
                        
                        if(ventanilla_actual == data.datos[i].VENT_ID){
                            is_selected = 'selected="selected"';
                        }
                        
                        html += '<option value="'+data.datos[i].VENT_ID+'" '+is_selected+' >'+data.datos[i].VENT_NOMBRE+'</option>';
                       });
                       $('#ventanillas').html(html);
                    }else{                        
                        $('#ventanillas').html('');                        
                    }
                }
            });
        }
        function cliente_actual(){
            var cliente = $("#cliente").val();
            var sede_actual = $("#sede").val();
            
             $.ajax({
                type: "POST",
                url: 'select_cliente.php',
                data: {cliente:cliente},
                dataType: 'json',
                async : false,
                success: function(data) {
                    
                    if(data.status == 'success'){
                       var html = '';
                       html += '<option value="0">Seleccione ...</option>'
                       $.each(data.datos , function(i){
                        var is_selected = '';
                        
                        if(sede_actual == data.datos[i].S_ID){
                            is_selected = 'selected="selected"';
                        }
                        
                        html += '<option value="'+data.datos[i].S_ID+'" '+is_selected+' >'+data.datos[i].S_NOMBRE+'</option>';
                       });
                       $('#sedes').html(html);
                    }else{                        
                        $('#sedes').html('');                       
                    }
                }
            });
            
            <?php
                if($objUsuario->has_value){ ?>
                    setTimeout('sede_actual()',500);
                <?php
                } 
            ?>
        }
        
        
    </script>

    <title>Virtual SHIFTS</title>
</head>
<body class="metro" onload="cliente_actual();">
    <div id="basic-modal-content" class="bg-darkCobalt fg-white">
        <div style="width: 630px; margin: 0 auto;">
            <h3 class="fg-white">Cambiar contrase&ntilde;a</h3>
    		<p class="fg-white">Ingrese la nueva contrase&ntilde;a</p>
            
            <div class="tile half" style="cursor: default; ">
                <div class="tile-content icon bg-gray">
                    <b class="icon-cog"></b>
                </div>
            </div>
            <div class="input-control password size4">
                <input type="password" id="pass" value="" placeholder="Contrase&ntilde;a" onkeyup="validar_inputs(this);" />
                <button class="btn-reveal"></button>
            </div>
            <br />
            <div class="input-control password size4">
                <input type="password" id="rep_pass" value="" placeholder="Confirmar contrase&ntilde;a" onkeyup="validar_inputs(this);" />
                <button class="btn-reveal"></button>
            </div>
            <br />
            <div class="input-control" style="width: 587px;">                
                <button class="closeModal" style="float: right; margin: 10px;">Cancelar</button>
                <button class="primary" style="float: right; margin: 10px;" onclick="cambiar_pass();">Guardar</button>
            </div>
            <br />
            <br />
            <br />            
        </div>
	</div>
    <?php
        echo $objGui->get_header();
    ?>
    <div class="page">
        <div class="page-region">
            <div class="page-region-content">                
                <h1>
                    <a href="index.php"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
                    <?php echo ($objUsuario->has_value)?'Editar':'Crear' ?><small class="on-right">Usuario</small>
                </h1>
                
                <?php if($objUsuario->has_value){ ?>
                    <nav class="horizontal-menu">
                        <ul>
                            <li><a href="#" onclick="lanzar_modal();"><b class="icon-cog fg-darkBlue"></b>&nbsp;Cambiar contrase&ntilde;a</a></li>
                        </ul>
                    </nav>                
                <?php } ?>
                
                <form action="javascript: crear_usuario();" id="form_user">
                    <?php echo ($objUsuario->has_value)?'<input type="hidden" name="user_id" id="user_id" value="'.$objUsuario->id.'" />':''; ?>
                    <br />
                    <div class="span2 offset1" style="float: left; text-align: right; font-size: 12pt;">Nombres:&nbsp;</div>
                    <div class="input-control text size4">                        
                        <input name="nombre" id="nombre" type="text" onkeydown="validar_inputs(this)" placeholder="Nombres" value="<?php echo ($objUsuario->has_value)?$objUsuario->nombres:''; ?>" />
                        <button class="btn-clear"></button>
                    </div>
                    <br />
                    <div class="span2 offset1" style="float: left; text-align: right; font-size: 12pt;">Apellidos:&nbsp;</div>
                    <div class="input-control text size4">
                        <input name="apellido" id="apellido" type="text" onkeydown="validar_inputs(this)" placeholder="Apellidos" value="<?php echo ($objUsuario->has_value)?$objUsuario->apellidos:''; ?>" />
                        <button class="btn-clear"></button>
                    </div>
                    <br />
                    <div class="span2 offset1" style="float: left; text-align: right; font-size: 12pt;">Usuario:&nbsp;</div>
                    <div class="input-control text size4">
                        <input name="nick" id="nick" type="text" onkeydown="validar_inputs(this)" placeholder="Usuario" value="<?php echo ($objUsuario->has_value)?$objUsuario->nick:''; ?>" />
                        <button class="btn-clear"></button>                        
                    </div>
                    <br />
                    <?php if(!$objUsuario->has_value) { ?>
                        <div class="span2 offset1" style="float: left; text-align: right; font-size: 12pt;">Contrase&ntilde;a:&nbsp;</div>
                        <div class="input-control password size4">
                            <input type="password" name="password" id="password" value="" placeholder="Contrase&ntilde;a" onkeyup="validar_inputs(this);" />
                            <button class="btn-reveal"></button>
                        </div>
                        <br />
                        <div class="span2 offset1" style="float: left; text-align: right; font-size: 12pt;">Contrase&ntilde;a:&nbsp;</div>
                        <div class="input-control password size4">
                            <input type="password" id="rep_password" value="" placeholder="Confirmar contrase&ntilde;a" onkeyup="validar_inputs(this);" />
                            <button class="btn-reveal"></button>
                        </div>               
                        <br />
                        <div class="span2 offset1" style="float: left; text-align: right; font-size: 12pt;">Tipo de Usuario:&nbsp;</div>
                        <div class="input-control select size4">
                            <select name="tipo_usuario" id="tipo_usuario" onchange="tipo_actual(this)">
                                <option value="0">Seleccione ...</option>
                                <?php
                                    if($_SESSION['id_user_type'] == 9){
                                        $objTipoUsuarios->mostrar_tipos_usuarios();
                                    }elseif($_SESSION['id_user_type'] == 10){
                                        $objTipoUsuarios->mostrar_tipos_usuarios_para_admin();
                                    }      
                                    if($objTipoUsuarios->has_value){
                                        foreach($objTipoUsuarios->array_tipo_usuarios as $row){ ?>
                                            <option value="<?php echo $row['TU_ID']; ?>" <?php echo ($objUsuario->id_tipo_usuario == $row['TU_ID'])?'selected="selected"':'' ?> ><?php echo $row['TU_NOMBRE']; ?></option>
                                        <?php    
                                        }
                                    }
                                ?>
                            </select>
                        </div> 
                        <br />
                    <?php
                    }
                    if($_SESSION['id_user_type'] == 9){
                        ?>
                        <div class="span2 offset1" style="float: left; text-align: right; font-size: 12pt;">Cliente:&nbsp;</div>
                        <div class="input-control select size4">
                      <!--<select name="cliente" id="cliente" onchange="cargar_clientes(this)" <?php echo ($objUsuario->has_value && $objUsuario->id_tipo_usuario != 9 )?'':'disabled="disabled"'; ?> >-->
                            <select name="cliente" id="cliente" onchange="cliente_actual()">
                                <option value="0">Seleccione ...</option>
                                <?php 
                                    $objClientes->get_clientes_activos();

                                    if($objClientes->has_value){
                                        foreach($objClientes->array_campos as $row){ ?>
                                            <option value="<?php echo $row['C_ID']; ?>" <?php echo ($objUsuario->cliente == $row['C_ID'])?'selected="selected"':'' ?> ><?php echo $row['C_RAZON_SOCIAL']; ?></option>
                                        <?php
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    <?php }else{ ?>
                        <input type="hidden" name="cliente" id="cliente" value="<?php echo $_SESSION['cliente']; ?>" />
                    <?php } ?>
                    <div id="contienePermisos2" style=" display: <?php echo ($objUsuario->id_tipo_usuario == 11)?'':'none'?>;">
                        <br />
                        <div class="span2 offset1" style="float: left; text-align: right; font-size: 12pt;">Sede:&nbsp;</div>
                        <div class="input-control select size4">
                            <select name="sedes" id="sedes" onchange="sede_actual()" >
                                <option value="0">Seleccione ...</option>
                            </select>
                        </div>
                        <br />
                        <div class="span2 offset1" style="float: left; text-align: right; font-size: 12pt;">Ventanilla:&nbsp;</div>
                        <div class="input-control select size4">
                            <select name="ventanillas" id="ventanillas" >
                                <option value="0">Seleccione ...</option>  
                            </select>
                        </div>
                        <br />
                    </div>
                    <div class="span2 offset1" style="float: left; text-align: right; font-size: 12pt;">C&eacute;dula:&nbsp;</div>
                    <div class="input-control text size4">
                        <input name="cedula" id="cedula" type="tel" onkeydown="validar_inputs(this)" data-transform="input-control" placeholder="Cedula" value="<?php echo ($objUsuario->has_value)?$objUsuario->cedula:''; ?>" />
                        <button class="btn-clear"></button>
                    </div>
                    <br />
                    <div class="span2 offset1" style="float: left; text-align: right; font-size: 12pt;">Correo Electr&oacute;nico:&nbsp;</div>
                    <div class="input-control text size4">
                        <input name="mail" id="mail" type="email" onkeydown="validar_inputs(this)" data-transform="input-control" placeholder="Correo electr&oacute;nico" value="<?php echo ($objUsuario->has_value)?$objUsuario->mail:''; ?>" />
                        <button class="btn-clear"></button>
                    </div>
                    <br />
                    <div class="span2 offset1" style="float: left; text-align: right; font-size: 12pt;">Celular:&nbsp;</div>
                    <div class="input-control text size4">
                        <input name="celular" id="celular" type="tel" onkeydown="validar_inputs(this)" data-transform="input-control" placeholder="Celular" value="<?php echo ($objUsuario->has_value)?$objUsuario->celular:''; ?>" />
                        <button class="btn-clear"></button>
                    </div>
                    <br />
                    <?php if(!$objUsuario->has_value){ ?>
                        <div class="row" style="margin-left: 179px;">
                            <div class="input-control checkbox" style="margin-left: 15px;">
                                <label style="font-size: 12pt;" onchange="sede_actual(this)">
                                    Activo
                                    <input name="activo" id="activo" type="checkbox" <?php echo ($objUsuario->activo == 1)?'checked="checked"':''; ?> />
                                    <span class="check"></span>                            
                                </label>
                            </div>
                        </div>
                        <div id="contienePermisos" class="row" style="margin-left: 132px; display: <?php echo ($objUsuario->id_tipo_usuario == 11)?'':'none'?>;">
                            <div class="input-control checkbox" style="margin-left: 15px;">
                                <label style="font-size: 12pt;">
                                    Crear Turnos
                                    <input name="crea_turno" id="crea_turno" type="checkbox" <?php echo ($objUsuario->crea_turno == 1)?'checked="checked"':''; ?> />
                                    <span class="check"></span>                            
                                </label>
                            </div>
                            <div class="input-control checkbox">
                                <label style="font-size: 12pt;">
                                    Gestionar Turnos
                                    <input name="gestiona_turno" id="gestiona_turno" type="checkbox" <?php echo ($objUsuario->gestiona_turno == 1)?'checked="checked"':''; ?> />
                                    <span class="check"></span>
                                </label>
                            </div>
                            <div class="input-control checkbox">
                                <label style="font-size: 12pt;">
                                    Administrar Sedes
                                    <input name="administra_sede" id="administra_sede" type="checkbox" <?php echo ($objUsuario->administra_sede == 1)?'checked="checked"':''; ?> />
                                    <span class="check"></span>                            
                                </label>
                            </div>
                        </div>
                    <?php }?>
                    <button class="primary large offset5" type="submit">Guardar</button>                    
                </form>
                <br />
                <?php 
                    if($objUsuario->has_value){
                        $objUsuario->get_ventanilla_y_sede_por_asesor($id_user);
                        if($objUsuario->has_value){ ?>
                            <input id="sede" name="sede" value="<?php echo $objUsuario->sede ?>" />
                            <input id="ventanilla" name="ventanilla" value="<?php echo $objUsuario->ventanillas ?>" />
                        <?php 
                        }
                    }else{ ?>
                        <input id="sede" name="sede" value="0" />
                        <input id="ventanilla" name="ventanilla" value="0" />
                    <?php
                    }
                ?>
            </div>
        </div>
    </div>
    <?php
        echo $objGui->get_footer();
    ?>
    </body>
</html>