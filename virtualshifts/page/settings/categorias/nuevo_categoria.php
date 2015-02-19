<?php
ini_set("display_errors",1);

include_once("../../../gestionseguridad/security.php");
include_once("../../../clases/gui.class.php");
include_once("../../../clases/categorias.class.php");
include_once("../../../clases/clientes.class.php");

if($_SESSION['id_user_type'] != 9 && $_SESSION['id_user_type'] != 10){
    header("Location: ../../../gestionseguridad/exit.php");
}

$objGui = new GUI($_SESSION['id_user_type']);
$objCategorias = new Categorias;
$objClientes = new Clientes;
$id_categoria = (isset($_GET['code']))?$_GET['code']:0;

if($id_categoria != 0){
    $objCategorias->get_categoria($id_categoria);
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
    
    <!--<link href="../../../css/dataTables/demo_table_jui.css" rel="stylesheet" />-->
    <?php echo $objGui->icon; ?>
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
        
        function crear_categoria(){
            
            var formulario = document.getElementById("form_categoria");
            
            var form_categoria = $("#form_categoria").serialize();
            
            var has_error = false;
                        
            for(var i = 0; i < formulario.elements.length; i++){
                
                var campo = formulario.elements[i];
                
                if( $(campo).is(':checkbox') || $(campo).is(':hidden') || $(campo).is(':button') ){
                    continue;
                }
                if($(campo).attr("id") == "cedula"  || $(campo).attr("id") == "celular" || $(campo).attr("id") == "telefono"){
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
                url: '<?php echo ($objCategorias->has_value)?'modificar_categoria.php':'crear_categoria.php' ?>',
                data: form_categoria,
                success: function(data) {
                                        
                    if(data == 'success'){
                        var html = '';
                        html += '<h3><strong>Categoria creada.</strong><h3>';
                        html += '<p>La categoria fue creada exitosamente<p>';
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
                                content: "La categoria ya existe.",
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
                    <?php echo ($objCategorias->has_value)?'Editar':'Crear' ?><small class="on-right">Categor&iacute;a</small>
                </h1>
                
                <form action="javascript: crear_categoria();" id="form_categoria">
                <?php echo ($objCategorias->has_value)?'<input type="hidden" name="categoria_id" id="categoria_id" value="'.$id_categoria.'" />':''; ?>                
                    <input type="hidden" name="cliente" id="cliente" value="<?php echo $_SESSION['cliente']; ?>" />
                    <br />
                    <div class="span3 offset1" style="float: left; text-align: right; font-size: 12pt;">Nombre:&nbsp;</div>
                    <div class="input-control text size4">                        
                        <input name="nombre" id="nombre" type="text" onkeydown="validar_inputs(this)" placeholder="Nombre" value="<?php echo ($objCategorias->has_value)?$objCategorias->array_campos[0]['CAT_NOMBRE']:''; ?>"/>
                        <button class="btn-clear"></button>
                    </div>
                    <br />
                    <div class="span3 offset1" style="float: left; text-align: right; font-size: 12pt;">Descripci&oacute;n:&nbsp;</div>
                    <div class="input-control textarea size4">
                        <textarea name="descripcion" id="descripcion" onkeydown="validar_inputs(this)" placeholder="Descripci&oacute;n" ><?php echo ($objCategorias->has_value)?$objCategorias->array_campos[0]['CAT_DESCRIPCION']:''; ?></textarea>
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