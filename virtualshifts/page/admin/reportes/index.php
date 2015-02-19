<?php
ini_set("display_errors",1);

include_once("../../../gestionseguridad/security.php");
include_once("../../../clases/gui.class.php");
include_once("../../../clases/rutero.class.php");
include_once("../../../clases/usuarios.class.php");
include_once("../../../clases/clientes.class.php");
include_once("../../../clases/puntos_venta.class.php");
include_once("../../../clases/grupos.class.php");
include_once("../../../clases/subgrupos.class.php");

if($_SESSION['id_user_type'] != 1 && $_SESSION['id_user_type'] != 3){
    header("Location: ../../../gestionseguridad/exit.php");
}

$objGui = new GUI($_SESSION['id_user_type']);
$objRutero = new Rutero;
$objUsuario = new Users;
$objClientes = new Clientes;
$objPuntosVenta = new PuntosVenta;
$objGrupos = new Grupos;
$objSubgrupo = new Subgrupos;

$id_cliente = (isset($_GET['code']))?$_GET['code']:0;

if($id_cliente != 0){
    $objClientes->get_client($id_cliente);
}

$estado=(isset($_GET['state']))?$_GET['state']:0;

$num_errores = (isset($_GET['cuenta']))?$_GET['cuenta']:0;
$nombre_archivo = (isset($_GET['archivo_error']))?$_GET['archivo_error']:0;

$fecha = (isset($_POST['fecha']))?$_POST['fecha']:date("Y-m-d");
$id_pv = (isset($_POST['pv']))?$_POST['pv']:0;
$id_cliente = (isset($_POST['cliente']))?$_POST['cliente']:0;
$id_movil = (isset($_POST['usuario']))?$_POST['usuario']:0;
$id_grupo = (isset($_POST['grupo']))?$_POST['grupo']:0;
$id_subgrupo = (isset($_POST['subgrupo']))?$_POST['subgrupo']:0;

$objRutero->get_rutero_para_portal($id_movil,$id_pv,$id_cliente,$fecha,'');

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
    
    <script src="../../../js/metro/metro-global.js"></script>
    <script src="../../../js/metro/metro-core.js"></script>
    <script src="../../../js/metro/metro-locale.js"></script>
    <script src="../../../js/metro/metro-calendar.js"></script>
    <script src="../../../js/metro/metro-datepicker.js"></script>
   
    <script src="../../../js/dataTables/jquery.dataTables.js"></script>
    <script src="../../../js/dataTables/jquery.dataTables.min.js"></script>

    <script src="../../../js/funciones.js"></script>
    
    <script src="../../../js/simpleModal/jquery.simplemodal.js"></script>
        
    <script type="text/javascript">
                
        function cerrar_sesion(){
            window.location = '../../../gestionseguridad/exit.php';
        }
        
        function cargar_grupos(input){
            
            var cliente = $(input).val();
            
            if( $(input).val() != "" ){
                if($(input).parent().next().is('span')){
                    $(input).parent().next().remove('span');
                    $(input).parent().removeClass("error-state");
                    $(input).parent().removeClass("warning-state");
                    $(input).parent().removeClass("info-state");
                }
            }
            
            if(cliente == 0){
                $("#grupo").html('<option value="0">Seleccione ... </option>');
                $("#subgrupo").html('<option value="0">Seleccione ... </option>');
                $("#usuario").html('<option value="0">Seleccione ... </option>');
            }else{
                var parametros = "cliente="+cliente;
                $("#subgrupo").html('<option value="0">Seleccione ... </option>');                
                $("#usuario").html('<option value="0">Seleccione ... </option>');
                $.ajax({                
                    type: "POST",
                    url:"../../settings/rutero/listar_grupos.php",
                    data: parametros,
                    success: function(data) { 
                            $("#grupo").html(data);
                    }
                });
            }
        }
        
        function cargar_subgrupos(input){
            
            var grupo = $(input).val();
            
            if( $(input).val() != "" ){
                if($(input).parent().next().is('span')){
                    $(input).parent().next().remove('span');
                    $(input).parent().removeClass("error-state");
                    $(input).parent().removeClass("warning-state");
                    $(input).parent().removeClass("info-state");
                }
            }
            
            if(grupo == 0){
                $("#subgrupo").html('<option value="0">Seleccione ... </option>');
                $("#usuario").html('<option value="0">Seleccione ... </option>');
            }else{
                var parametros = "grupo="+grupo;                
                $("#usuario").html('<option value="0">Seleccione ... </option>');
                $.ajax({                
                    type: "POST",
                    url:"../../settings/rutero/listar_subgrupos.php",
                    data: parametros,
                    success: function(data) { 
                            $("#subgrupo").html(data);
                    }
                });
            }
        }
        
        function cargar_moviles(input){
            
            var subgrupo = $(input).val();
            
            if( $(input).val() != "" ){
                if($(input).parent().next().is('span')){
                    $(input).parent().next().remove('span');
                    $(input).parent().removeClass("error-state");
                    $(input).parent().removeClass("warning-state");
                    $(input).parent().removeClass("info-state");
                }
            }
            
            if(subgrupo == 0){
                $("#usuario").html('<option value="0">Seleccione ... </option>');
            }else{
                var parametros = "subgrupo="+subgrupo;                
                
                $.ajax({                
                    type: "POST",
                    url:"../../settings/rutero/listar_moviles.php",
                    data: parametros,
                    success: function(data) { 
                            $("#usuario").html(data);
                    }
                });
            }
        }
        
        
        function iniciar(){
            
        <?php
        
        if($estado!='0'){
            if($estado=="error"){
                ?>
                
                $.Notify({
                            content: "Ha ocurrido un error con el formato del archivo.",
                            style: {background: 'red', color: 'white'},
                            timeout: 5000,
                            width: 250,
                            height: 30                            
                        });
                <?php
            }elseif($estado=="error2"){
                ?>
                
                $.Notify({
                            content: "Algunos registros no fueron cargados.",
                            style: {background: 'orange', color: 'white'},
                            timeout: 5000,
                            width: 250,
                            height: 30                            
                        });
                <?php
            }elseif($estado=="error3"){
                ?>
                
                $.Notify({
                            content: "Ha ocurrido un error por favor intente mas tarde.",
                            style: {background: 'red', color: 'white'},
                            timeout: 5000,
                            width: 250,
                            height: 30                            
                        });
                <?php
            }else{
                ?>
                $.Notify({
                            content: "Clientes cargados con exito.",
                            style: {background: 'green', color: 'white'},
                            timeout: 5000,
                            width: 250,
                            height: 30                            
                        });
                <?php
            }
        }
        ?>
        }
    </script>

    <title>Virtual MOBILE</title>
</head>
<body class="metro" onload="iniciar()">    
    <?php
        echo $objGui->get_header();
    ?>
    <div class="page">
        <div class="page-region">
            <div class="page-region-content">                
                <h1>
                    <a href="../index.php"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
                    Reportes<small class="on-right"></small>
                </h1>
                
                <form action="subir_archivo.php" method="post" id="form_rutero" enctype="multipart/form-data">    
                    
                </form>
                    <?php
                        if($nombre_archivo!='0'){
                    ?>
                            <a class="button info large" style="float: right; margin-right: 170px;" href="archivos_error/<?php echo $nombre_archivo ?>.php"><?php echo $num_errores?> Registros no cargados</a>
                    <?php
                        }
                    ?>
                </div>
                <br />
                <legend>Filtros</legend>
                <form method="post" action="construir_reporte.php" target="_blank">
                    <div class="span2" style="float: left; font-size: 12pt;  margin-top: 5px;">Fecha inicial:&nbsp;</div>
                    <div class="input-control text size2" data-role="datepicker"
                        data-format='yyyy-mm-dd'
                        data-effect='slide'
                        data-locale='en'>
                        <input type="text" name="fecha_inicio" id="fecha_inicio" value="<?php echo $fecha; ?>" />
                        <button class="btn-date" onclick="return false;"></button>
                    </div>                    
                    <br />
                    <div class="span2" style="float: left; font-size: 12pt;  margin-top: 5px;">Fecha final:&nbsp;</div>
                    <div class="input-control text size2" data-role="datepicker"
                        data-format='yyyy-mm-dd'
                        data-effect='slide'
                        data-locale='en'>
                        <input type="text" name="fecha_fin" id="fecha_fin" value="<?php echo $fecha; ?>" />
                        <button class="btn-date" onclick="return false;"></button>
                    </div>                    
                    <br />
                    <div class="span2" style="text-align: left; float: left; font-size: 12pt;  margin-top: 5px;">Modulo:&nbsp;</div>
                    <div class="input-control select size2">
                        <select id="modulo" name="modulo" >
                            <option value="RU_AGOTADOS">Agotados</option>
                            <option value="RU_PRECIOS">Precios</option>
                            <option value="RU_INVENTARIO">Inventarios PV</option>
                            <option value="RU_SUGERIDOS">Sugeridos</option>                       
                            <option value="RU_ACTIVIDADES">Actividades PV</option>
                            <option value="RU_PARTICIPACION">Participaci&oacute;n</option>
                            <option value="RU_VENTAS">Ventas</option>
                            <option value="RU_ENCUESTAS">Encuestas</option>
                            <option value="RU_BITACORA">Bit&aacute;cora</option>
                        </select>
                    </div>
                    <br />
                    <div class="span2" style="float: left; font-size: 12pt;  margin-top: 5px;">Cliente:&nbsp;</div>
                    <div class="input-control select size2 place-left">
                        <select id="cliente" name="cliente" onchange="cargar_grupos(this);">
                            <option value="0">Seleccione ...</option>
                            <?php
                                $objClientes->get_clientes_activos();
                                if($objClientes->has_value){
                                    foreach($objClientes->array_campos as $row){ ?>
                                        <option value="<?php echo $row['C_ID']; ?>" <?php echo ($id_cliente == $row['C_ID'])?'selected="selected"':'' ?> ><?php echo $row['C_RAZON_SOCIAL']; ?></option>
                                    <?php    
                                    }
                                } 
                            ?>                        
                        </select>
                    </div>
                    <div style="text-align: right; float: left; font-size: 12pt;  margin-top: 5px; margin-left: 10px;">Grupo:&nbsp;</div>
                    <div class="input-control select size2 place-left">
                        <select id="grupo" name="grupo" onclick="cargar_subgrupos(this);">
                            <option value="0">Seleccione ...</option>
                            <?php
                                if($id_cliente != 0){
                                    $objGrupos->get_grupos_activos_por_cliente($id_cliente);
                                    if($objGrupos->has_value){
                                        foreach($objGrupos->array_gupos as $row){ ?>                                            
                                            <option value="<?php echo $row['G_ID']; ?>" <?php echo ($id_grupo == $row['G_ID'])?'selected="selected"':''; ?> ><?php echo $row['G_NOMBRE']; ?></option>
                                        <?php
                                        }
                                    }
                                }                                
                            ?>                        
                        </select>
                    </div>
                    <div style="text-align: right; float: left; font-size: 12pt;  margin-top: 5px; margin-left: 10px;">Subgrupo:&nbsp;</div>
                    <div class="input-control select size2 place-left">
                        <select id="subgrupo" name="subgrupo" onclick="cargar_moviles(this);">
                            <option value="0">Seleccione ...</option>
                            <?php
                                if($id_grupo != 0){
                                    $objSubgrupo->mostrar_subgrupos_activos_por_grupo($id_grupo);
                                    if($objSubgrupo->has_value){
                                        foreach($objSubgrupo->array_subgrupos as $row){ ?>
                                            <option value="<?php echo $row['SG_ID']; ?>" <?php echo ($id_subgrupo == $row['SG_ID'])?'selected="selected"':'' ?> ><?php echo $row['SG_NOMBRE']; ?></option>
                                        <?php    
                                        }
                                    }
                                } 
                            ?>                        
                        </select>
                    </div>
                    <div style="text-align: right; float: left; font-size: 12pt;  margin-top: 5px; margin-left: 10px;">Movil:&nbsp;</div>
                    <div class="input-control select size2">
                        <select id="usuario" name="usuario" >
                            <option value="0">Seleccione ...</option>
                            <?php
                                if($id_subgrupo != 0){
                                    $objUsuario->get_usurios_movil_por_subgrupo($id_subgrupo);
                                    if($objUsuario->has_value){
                                        foreach($objUsuario->array_usuarios as $row){ ?>
                                            <option value="<?php echo $row['U_ID'] ?>" <?php echo ($id_movil == $row['U_ID'])?'selected="selected"':'' ?> ><?php echo $row['U_NOMBRE']." ".$row['U_APELLIDOS']; ?></option>
                                        <?php    
                                        }
                                    }
                                } 
                            ?>                        
                        </select>
                    </div>
                    <br />                    
                    <button class="button primary large place-right" type="submit">Buscar rutas</button>
                    <br />
                </form>
                <br />
                <!--<a class="place-right button large primary" onclick="parent.document.ReloadForm.submit(); return false;" ><b class="icon-cycle"></b>Actualizar</a>-->
                <br />
                <br />
            </div>
        </div>
    </div>
    <?php
        echo $objGui->get_footer();
    ?>
    </body>
</html>
