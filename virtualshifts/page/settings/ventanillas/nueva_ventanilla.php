<?php
ini_set("display_errors",1);

include_once("../../../gestionseguridad/security.php");
include_once("../../../clases/gui.class.php");
include_once("../../../clases/sedes.class.php");
include_once("../../../clases/ventanillas.class.php");

if($_SESSION['id_user_type'] != 10){
    header("Location: ../../../gestionseguridad/exit.php");
}

$objGui = new GUI($_SESSION['id_user_type']);
$objVentanillas = new Ventanillas;
$objSedes = new Sedes;

$id_ventanilla = (isset($_GET['code']))?$_GET['code']:0;

if($id_ventanilla != 0){
    $objVentanillas->get_ventanillas_por_id($id_ventanilla);
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
                
        function crear_ventanilla(){
            var formulario = document.getElementById("form_ventanilla");
            
            var form_ventanilla = $("#form_ventanilla").serialize();
            
            var has_error = false;
                        
            for(var i = 0; i < formulario.elements.length; i++){
                
                var campo = formulario.elements[i];
                
                if( $(campo).is(':checkbox') || $(campo).is(':hidden') || $(campo).is(':button') ){
                    continue;
                }
                
                if($(campo).attr("id") == "nombre" ){
                    var status = verificar_campo(campo,1);
                }else if($(campo).attr("id") == "descrip"){                    
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
                url: '<?php echo ($objVentanillas->has_value)?'modificar_ventanilla.php':'crear_ventanilla.php' ?>',
                data: form_ventanilla,
                success: function(data) {                    
                    if(data == 'success'){                        
                        $.Notify({
                            content: "Datos almacenados correctamente.",
                            style: {background: 'green', color: 'white'},
                            timeout: 5000,
                            width: 250,
                            height: 30                            
                        });
                        window.location = 'index.php';                                               
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
                    <a href="index.php"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
                    <?php echo ($objVentanillas->has_value)?'Editar':'Crear' ?><small class="on-right">Ventanilla</small>
                </h1>                
                
                <form action="javascript: crear_ventanilla();" id="form_ventanilla">
                    <?php echo ($objVentanillas->has_value)?'<input type="hidden" name="id_ventanilla" id="id_ventanilla" value="'.$objVentanillas->array_ventanillas['VENT_ID'].'" />':''; ?>
                    <br />
                    <div class="span2 offset1" style="float: left; text-align: right; font-size: 12pt;">Nombre<span class="fg-red">*</span>:&nbsp;</div>
                    <div class="input-control text size4">                        
                        <input name="nombre" id="nombre" type="text" onkeydown="validar_inputs(this)" placeholder="Nombre" value="<?php echo ($objVentanillas->has_value)?$objVentanillas->array_ventanillas['VENT_NOMBRE']:''; ?>" />
                        <button class="btn-clear"></button>
                    </div>
                    <br />
                    <div class="span2 offset1" style="float: left; text-align: right; font-size: 12pt;">Sede<span class="fg-red">*</span>:&nbsp;</div>
                    <div class="input-control select size4">
                        <select name="sede" id="sede">
                            <?php
                                $objSedes->get_sedes_activas_por_cliente($_SESSION['cliente']);
                                if($objSedes->has_value){
                                    foreach($objSedes->array_sedes as $row){ ?>
                                        <option value="<?php echo $row['S_ID']; ?>" <?php echo ($objVentanillas->has_value && $row['S_ID'] == $objVentanillas->array_ventanillas['VENT_S_ID'])?'selected="selected"':'' ?> ><?php echo $row['S_NOMBRE']; ?></option>
                                    <?php
                                    }
                                }
                            ?>
                        </select>
                    </div>
                    <br />
                    <div class="span2 offset1" style="float: left; text-align: right; font-size: 12pt;">Descripci&oacute;n:&nbsp;</div>
                    <div class="input-control textarea size4">
                        <textarea id="descrip" name="descrip" onkeydown="validar_inputs(this)" placeholder="Descripci&oacute;n"><?php echo ($objVentanillas->has_value)?$objVentanillas->array_ventanillas['VENT_DESCRIPCION']:''; ?></textarea>
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