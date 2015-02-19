<?php
ini_set("display_errors",1);
header('Content-Type: text/html; charset=iso-8859-1');

include_once("../../../gestionseguridad/security.php");
include_once("../../../clases/gui.class.php");
include_once("../../../clases/areas.class.php");
include_once("../../../clases/auxiliaries.class.php");
include_once("../../../clases/categorias.class.php");

if($_SESSION['id_user_type'] != 11){
    header("Location: ../../../gestionseguridad/exit.php");
}

$objGui = new GUI($_SESSION['id_user_type']);
$objAreas = new Areas;
$objAuxiliaries = new Auxiliaries;
$objCategorias = new Categorias;

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
    <link href="../../../css/flipClockMaster/flipclock.css" rel="stylesheet" />
    
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
    <script src="../../../js/flipClockMaster/libs/base.js"></script>
	<script src="../../../js/flipClockMaster/flipclock.js"></script>
    <script src="../../../js/flipClockMaster/faces/twelvehourclock.js"></script>

    <script src="../../../js/funciones.js"></script>
    
    <style>
        ul li,
        ol li {
          line-height: 37px !important;
        }
        
        .tiempo_cita span{
            display: none;
        }
    </style>
        
    <script type="text/javascript">
        var clock = '';
        var clock2 = '';
        var clock3 = '';
        var has_turn = 0;
        var has_aux = 0;
        console.log("se define has_turn "+has_turn);
        $(document).ready(function(){
            clock = $('#reloj').FlipClock({
                clockFace: 'TwelveHourClock',
                language: 'es',
                showSeconds: false
            });
            clock2 = $('#tiempo_cita').FlipClock({
                clockFace: 'Hourlycounter',
                autoStart: false,
                language: 'es'
            });
            clock3 = $('#reloj_auxilary').FlipClock({
                clockFace: 'Hourlycounter',
                countdown: true,
                autoStart: false,
                language: 'es'
            });
        })
                
        function cerrar_sesion(){
            console.log("se evalua has_turn para dejarlo salir "+has_turn);
            if(has_turn == 1){
                alert("Para salir, debes cerrar los turnos pendientes.");
            }else{
                window.location = '../../../gestionseguridad/exit.php';
            }
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
        
        function get_turno(){            
            console.log("se evalua has_turn para ver si traigo otro turno "+has_turn);
            if(has_turn == 0 && has_aux == 0){ 
                //console.log("hola");
                $.ajax({
                    type: "POST",
                    url: 'get_turno.php',
                    contentType:"application/json; charset=utf-8",
                    dataType: 'json',
                    data: {cedula: ''},
                    success: function(data){
                        if(data.status == 'success'){
                            if(data.tiempo_turno != 0){
                                clock2.setTime(data.tiempo_turno);
                                clock2.start();
                                
                                $("#boton_inicia_turno").removeClass('primary');
                                $("#boton_inicia_turno").addClass('disabled');
                                $("#boton_inicia_turno").attr('disabled', 'disabled');
                                
                                $("#boton_cerrar_turno").removeClass('disabled');
                                $("#boton_cerrar_turno").addClass('primary');
                                $("#boton_cerrar_turno").removeAttr('disabled');
                            }else{                                
                                $("#boton_inicia_turno").removeClass('disabled');
                                $("#boton_inicia_turno").addClass('primary');
                                $("#boton_inicia_turno").removeAttr('disabled');
                                
                                $("#boton_cerrar_turno").removeClass('primary');
                                $("#boton_cerrar_turno").addClass('disabled');
                                $("#boton_cerrar_turno").attr('disabled', 'disabled');
                                
                                $.each($("#form_turno input"), function(i){
                                    if($(this).attr('type') != 'hidden'){
                                        $(this).attr('disabled','disabled');
                                    }                                     
                                });
                                
                                $.each($("#form_turno textarea"), function(i){
                                    $(this).attr('disabled','disabled'); 
                                });
                                
                                $.each($("#form_turno select"), function(i){
                                    $(this).attr('disabled','disabled'); 
                                });
                            }
                            
                            $("#turno").html(data.datos_area.AR_ALIAS+data.datos_turno.HT_TURNO);
                            $("#nombre").val(data.datos_consumidor.CO_NOMBRE);
                            $("#cedula").val(data.datos_consumidor.CO_CEDULA);
                            $("#direccion").val(data.datos_consumidor.CO_DIRECCION);
                            $("#telefono").val(data.datos_consumidor.CO_TELEFONO);
                            $("#mail").val(data.datos_consumidor.CO_CORREO);
                            $("#campo1").val(data.datos_consumidor.CO_CAMPO1);
                            $("#campo2").val(data.datos_consumidor.CO_CAMPO2);
                            $("#campo3").val(data.datos_consumidor.CO_CAMPO3);
                            $("#campo4").val(data.datos_consumidor.CO_CAMPO4);
                            $("#campo5").val(data.datos_consumidor.CO_CAMPO5);
                            $("#observaciones").html(data.datos_turno.HT_OBSERVACIONES);
                            $("#id_area").val(data.datos_area.AR_ID);
                            $("#id_turno").val(data.datos_turno.HT_ID);                            
                            $("#num_turno").val(data.datos_turno.HT_TURNO);                            
                            $("#id_consumidor").val(data.datos_consumidor.CO_ID);
                            
                            console.log("se setea has_turn para que no se pidan mas turnos "+has_turn);
                            has_turn = 1;
                        }
                        
                        $("#total_turnos").html(data.turnos_sin_atender);
                    }
                });  
            }
        }
                
        function cerrar_turno(){
            console.log("se evalua has_turn para cerrar un turno "+has_turn);
            if(has_turn == 1){
                if(has_aux == 0){
                    $('#basic-modal-content').removeClass('bg-white');
                    $('#basic-modal-content').addClass('bg-transparent');
                    $("#pa_cargar").css('display','block');
                    $("#pa_aux").css('display','none');
                    
                    $('#basic-modal-content').modal({
                        opacity: 40,
                        closeClass: 'closeModal'
                    });
                }
                
                var formulario = document.getElementById("form_turno");
                
                var form_turno = $("#form_turno").serialize();
                
                var codigo = $("#codigo").val();
                
                var has_error = false;
                            
                for(var i = 0; i < formulario.elements.length; i++){
                    
                    var campo = formulario.elements[i];
                    
                    if( $(campo).is(':checkbox') || $(campo).is(':hidden') || $(campo).is(':button') || $(campo).attr("id") == 'codigo' ){
                        continue;
                    }
                    
                    if($(campo).attr("id") == "telefono" ){
                        var status = verificar_campo(campo,'numeros');
                    }else if($(campo).attr("id") == "mail"){
                        var status = verificar_campo(campo,"correo");
                    }else if($(campo).attr("id") == "nombre"){
                        var status = verificar_campo(campo,"3");
                    }else if($(campo).attr("id") == "observaciones"){
                        var status = verificar_campo(campo,"3");
                    }else if($(campo).attr("id") == "resumen"){
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
                    if(has_aux == 1){
                        sale_aux();
                    }
                    return;
                }
                
                if(codigo == 0){
                    alert("Por favor seleccione un un codigo de terminacion");
                    $(".closeModal").click();
                    if(has_aux == 1){
                        sale_aux();
                    }
                    return false;
                }
                
                $.ajax({
                    type: "POST",
                    url: 'cerrar_turno.php',
                    dataType: 'json',
                    data: form_turno,
                    success: function(data) {                        
                        if(data.status == 'success'){
                            var html = '';
                            html += '<h3><strong>Turno cerrado.</strong><h3>';
                            html += '<p>El turno se ha cerrado correctamente<p>';
                            html += '<div style="text-align: center;" >';
                            html += '<button class="primary large" onclick="location.reload(); return false;">Aceptar</button>';
                            html += '</div>';
                            
                            $("#id_area").val('');
                            $("#id_turno").val('');
                            $("#num_turno").val('');
                            $("#id_consumidor").val(''); 
                            
                            if(has_aux == 0){
                                $(".closeModal").click();
                                $.Dialog({
                                    shadow: true,
                                    overlay: false,
                                    icon: '<img src="http:184.168.29.222/virtualshifts/favicon.png" />',
                                    title: 'Virtual Shifts',
                                    width: 500,
                                    padding: 10,
                                    content: html,
                                    onClose: function(_dialog){
                                        location.reload();
                                    }
                                });
                            }else{
                                $("#boton_cerrar_turno_actual").css('display','none');
                            }
                            console.log("se setea has_turn para que se pidan mas turnos "+has_turn);
                            has_turn = 0;
                        }else{
                            var html = '';
                            html += '<h3><strong>Turno no cerrado.</strong><h3>';
                            html += '<p>No se pudo cerrar el turno por favor intente de nuevo<p>';
                            html += '<div style="text-align: center;" >';
                            html += '<button class="primary large" onclick="return false;">Aceptar</button>';
                            html += '</div>';
                            
                            $.Dialog({
                                shadow: true,
                                overlay: false,
                                icon: '<img src="http:184.168.29.222/virtualshifts/favicon.png" />',
                                title: 'Virtual Shifts',
                                width: 500,
                                padding: 10,
                                content: html
                            });
                        }
                    }
                });
            }
        }
        
        function iniciar_turno(){
            $('#basic-modal-content').removeClass('bg-white');
            $('#basic-modal-content').addClass('bg-transparent');
            $("#pa_cargar").css('display','block');
            $("#pa_aux").css('display','none');
            
            $('#basic-modal-content').modal({
                opacity: 40,
                closeClass: 'closeModal'
            });
            
            var form_turno = $("#form_turno").serialize();
            
            $.ajax({
                type: "POST",
                url: 'iniciar_turno.php',
                dataType: 'json',
                data: form_turno,
                success: function(data){
                    $(".closeModal").click();
                    if(data.status){
                        clock2.setTime(0);
                        clock2.start();
                        
                        $("#boton_inicia_turno").removeClass('primary');
                        $("#boton_inicia_turno").addClass('disabled');
                        $("#boton_inicia_turno").attr('disabled','disabled');
                        
                        $("#boton_cerrar_turno").removeClass('disabled');
                        $("#boton_cerrar_turno").addClass('primary');
                        $("#boton_cerrar_turno").removeAttr('disabled');
                        
                        $.each($("#form_turno input"), function(i){
                            $(this).removeAttr('disabled'); 
                        });
                        
                        $.each($("#form_turno textarea"), function(i){
                            $(this).removeAttr('disabled'); 
                        });
                        
                        $.each($("#form_turno select"), function(i){
                            $(this).removeAttr('disabled'); 
                        });
                    }
                }
            });
        }
        
        function etra_aux(){
            //if(has_turn == 0){ 
                $("#pa_cargar").css('display','none');
                $("#pa_aux").css('display','block');
                $('#basic-modal-content').removeClass('bg-transparent');
                $('#basic-modal-content').addClass('bg-white');
                $('#basic-modal-content').modal({
                    opacity: 60,
                    closeClass: 'closeModal'
                });
            //}else{
//                alert("Te falta un turno por cerrar, para poder entrar a auxiliary.");  
//            }            
        }
        
        function inicia_aux(sel_aux){
            var aux = $(sel_aux).val();
            
             $.ajax({
                type: "POST",
                url: 'gestionauxiliary/get_auxiliary.php',
                dataType: 'json',
                data: {aux: aux},
                success: function(data) {
                    if(data.status == 'success'){
                        var duracion = parseInt(data.datos.A_DURACION);
                        var acumulado = parseInt(data.tiempo_acumulado);
                        var tiempo_arranque = duracion - acumulado;
                        //clock3.reset();
                        clock3.setTime(tiempo_arranque);
                        clock3.start();
                        $(sel_aux).attr('disabled', 'disabled');
                        has_aux = 1;
                        console.log("se evalua has_turn para dejar cerrar el turno"+has_turn);
                        if(has_turn == 1){
                            $("#boton_cerrar_turno_actual").css('display','block');
                        }
                    }else{
                        
                    }
                }
             });
        }
        
        function sale_aux(){
            if(has_aux == 1){
                var aux = $("#auxiliary").val();
                $.ajax({
                    type: "POST",
                    url: 'gestionauxiliary/termina_auxiliary.php',
                    data: {aux: aux},
                    success: function(data) {
                        if(data == 'success'){
                            $("#auxiliary").removeAttr('disabled');
                            clock3.stop();
                            clock3.setTime(0);
                            $(".closeModal").click();
                            $("#boton_cerrar_turno_actual").css('display','none');
                            has_aux = 0;
                            location.reload();
                        }else{
                            
                        }
                    }
                 });
            }else{
                $(".closeModal").click();
            }
        }
        
        function cambia_categoria(selector){
            var categoria = $(selector).val();
            
            $.ajax({
                type: "POST",
                url: 'gestioncodigos/carga_codigos.php',
                data: {categoria: categoria},
                success: function(data) {                    
                        $("#codigo").html('');
                        $("#codigo").html(data);                        
                }
             });
        }
        
        function atras(){
            console.log("se evalua has_turn para que dejar ir atras "+has_turn);
            if(has_turn == 1){
                console.log("paso1");
                alert("Para devolverte, debes cerrar los turnos pendientes.");
            }else{
                console.log("paso2");
                window.location = '../index.php';
            }
        }
        
        setInterval('get_turno()',3000);
    </script>

    <title>Virtual DATE SHIFTS</title>
</head>
<body class="metro" style="height: auto;">
    <div style="width: 300px; height: 225px; margin-left: auto; margin-right: auto;" id="basic-modal-content" class="bg-white">
        <img id="pa_cargar" style="display: none; margin-left: auto; margin-right: auto;" src="../../../images/loading_blanco.gif" />
        <div id="pa_aux">
            <div class="span2" style="font-size: 12pt;">Auxiliary:</div>
            <div class="input-control select size3">
                <select id="auxiliary" name="auxiliary" onchange="inicia_aux(this);">
                    <option value="0">Seleccione ... </option>
                    <?php $objAuxiliaries->get_auxiliaries_activos_por_cliente($_SESSION['cliente']);
                          if($objAuxiliaries->has_value){
                            foreach($objAuxiliaries->array_campos as $row){ ?>
                                <option value="<?php echo $row['A_ID']; ?>"><?php echo $row['A_NOMBRE']; ?></option>
                            <?php
                            }                            
                          } ?>
                </select>
            </div>
            <div id="reloj_auxilary"></div>
            <button onclick="sale_aux();" class="button primary">salir auxiliary</button><br /><br />
            <button style="display: none;" id="boton_cerrar_turno_actual" onclick="cerrar_turno();" class="button primary">Cerrar turno actual</button>
        </div>        
	</div>
    <?php
        echo $objGui->get_header();
    ?>
    <div class="page">
        <div class="page-region">
            <div class="page-region-content">                
                <h1>
                    <a href="#" onclick="atras();"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
                    Gestion <small class="on-right">Turnos</small>
                </h1>
                <div class="tile-group span12">
                    <div class="tile bg-emerald">
                        <div class="tile-content">
                            <div class="padding10" style="padding-top: 42px; padding-left: 17px;">
                                <h2 id="turno" class="fg-white no-margin"></h2>
                            </div>                        
                        </div>
                        <div class="tile-status">
                            <span class="name">Turno</span>
                        </div>
                    </div>
                    <div class="tile triple bg-steel">
                        <div class="tile-content icon">
                            <div class="padding10" style="padding-top: 25px;  padding-left: 40px;">
                                <div id="tiempo_cita"></div>
                            </div>                   
                        </div>
                        <div class="tile-status">
                            <span class="name">Tiempo del turno</span>
                        </div>
                    </div>
                    <div class="tile bg-crimson">
                        <div class="tile-content">
                            <div class="padding10" style="padding-top: 42px; padding-left: 17px;">
                                <h2 id="total_turnos" class="fg-white no-margin"></h2>
                            </div>                        
                        </div>
                        <div class="tile-status">
                            <span class="name">Turnos en espera</span>
                        </div>
                    </div>
                    <a class="tile bg-amber" onclick="etra_aux();">
                        <div class="tile-content icon">
                            <i class="icon-busy"></i>                  
                        </div>
                        <div class="tile-status">
                            <span class="name">Auxiliary</span>
                        </div>
                    </a>
                </div>
                <br />
                <br />                
                <form action="javascript: cerrar_turno();" id="form_turno">
                    <div class="span12">
                        <button id="boton_inicia_turno" class="disabled large" disabled="disabled" onclick="iniciar_turno(); return false;" >Iniciar turno</button>
                        <button id="boton_cerrar_turno" class="primary large" type="submit">Cerrar turno</button>
                    </div>                    
                    <input type="hidden" name="id_area" id="id_area" value="" />
                    <input type="hidden" name="id_turno" id="id_turno" value="" />
                    <input type="hidden" name="num_turno" id="num_turno" value="" />
                    <input type="hidden" name="id_consumidor" id="id_consumidor" value="" />
                    <br />                    
                    <div class="grid fluid" style="height: 380px; overflow-y: auto; overflow-x: hidden;">
                        <div class="row">
                            <div class="span5">
                                <div class="span5" style="font-size: 12pt;">Categoria c&oacute;digo:</div>
                                <div class="input-control select size5">
                                    <select id="categoria" name="categoria" onchange="cambia_categoria(this)">
                                        <option value="0">Seleccione ... </option>
                                        <?php
                                            $objCategorias->get_categorias_activas_por_cliente($_SESSION['cliente']);
                                            if($objCategorias->has_value){
                                                foreach($objCategorias->array_campos as $row){ ?>
                                                    <option value="<?php echo $row['CAT_ID']; ?>"><?php echo $row['CAT_NOMBRE']; ?></option>
                                                <?php
                                                }
                                            } 
                                        ?>
                                    </select>
                                </div>
                                <div class="span5" style="font-size: 12pt;">Nombre:&nbsp;</div>
                                <div class="input-control text size5">                        
                                    <input name="nombre" id="nombre" type="text" onkeydown="validar_inputs(this)" placeholder="Nombre" value="" />
                                    <button class="btn-clear"></button>
                                </div>
                                <div class="span5" style="font-size: 12pt;">C&eacute;dula:&nbsp;</div>
                                <div class="input-control text size5">                        
                                    <input name="cedula" id="cedula" type="text" onkeydown="validar_inputs(this)" placeholder="C&eacute;dula" value="" />
                                    <button class="btn-clear"></button>
                                </div>
                                <div class="span5" style="font-size: 12pt;">Direcci&oacute;n:&nbsp;</div>
                                <div class="input-control text size5">                        
                                    <input name="direccion" id="direccion" type="text" onkeydown="validar_inputs(this)" placeholder="Direcci&oacute;n" value="" />
                                    <button class="btn-clear"></button>
                                </div>
                                <div class="span5" style="font-size: 12pt;">Tel&eacute;fono:&nbsp;</div>
                                <div class="input-control text size5">                        
                                    <input name="telefono" id="telefono" type="text" onkeydown="validar_inputs(this)" placeholder="Tel&eacute;fono" value="" />
                                    <button class="btn-clear"></button>
                                </div>
                                <div class="span5" style="font-size: 12pt;">E-mail:&nbsp;</div>
                                <div class="input-control text size5">                        
                                    <input name="mail" id="mail" type="text" onkeydown="validar_inputs(this)" placeholder="E-mail" value="" />
                                    <button class="btn-clear"></button>
                                </div>
                                <div class="span5" style="font-size: 12pt;">Observaciones:&nbsp;</div>
                                <div class="input-control textarea size5">
                                    <textarea id="observaciones" onkeydown="validar_inputs(this)" name="observaciones" placeholder="Observaciones"></textarea>
                                </div>
                            </div>
                            <div class="span6">
                                <div class="span6" style="font-size: 12pt;">C&oacute;digo terminaci&oacute;n:&nbsp;</div>
                                <div class="input-control select size6">
                                    <select id="codigo" name="codigo">
                                        <option value="0">Seleccione ... </option>
                                    </select>
                                </div>
                                <div class="span6" style="font-size: 12pt;">Empresa:&nbsp;</div>
                                <div class="input-control text size6">                        
                                    <input name="campo1" id="campo1" type="text" onkeydown="validar_inputs(this)" placeholder="Empresa" value="" />
                                    <button class="btn-clear"></button>
                                </div>
                                <div class="span6" style="font-size: 12pt;">Cliente:&nbsp;</div>
                                <div class="input-control text size6">                        
                                    <input name="campo2" id="campo2" type="text" onkeydown="validar_inputs(this)" placeholder="Cliente" value="" />
                                    <button class="btn-clear"></button>
                                </div>
                                <div class="span6" style="font-size: 12pt;">Ciudad labor:&nbsp;</div>
                                <div class="input-control text size6">                        
                                    <input name="campo3" id="campo3" type="text" onkeydown="validar_inputs(this)" placeholder="Ciudad labor" value="" />
                                    <button class="btn-clear"></button>
                                </div>
                                <div class="span6" style="font-size: 12pt;">Documentos recibidos:&nbsp;</div>
                                <div class="input-control text size6">                        
                                    <input name="campo4" id="campo4" type="text" onkeydown="validar_inputs(this)" placeholder="Documentos recibidos" value="" />
                                    <button class="btn-clear"></button>
                                </div>
                                <div class="span6" style="font-size: 12pt;">Documentos entregados:&nbsp;</div>
                                <div class="input-control text size6">                        
                                    <input name="campo5" id="campo5" type="text" onkeydown="validar_inputs(this)" placeholder="Documentos entregados" value="" />
                                    <button class="btn-clear"></button>
                                </div>
                                <div class="span6" style="font-size: 12pt;">Resumen del turno:&nbsp;</div>
                                <div class="input-control textarea size6">
                                    <textarea id="resumen" onkeydown="validar_inputs(this)" name="resumen" placeholder="Resumen"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>                                        
                </form> 
                <div class="span6" style="float: right;">
                    <div style="float: right; width: 302px;" id="reloj"></div>
                </div>                
            </div>
        </div>
    </div>
    <?php
        echo $objGui->get_footer();
    ?>
    
    </body>
</html>