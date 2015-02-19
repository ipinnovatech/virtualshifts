<?php
ini_set("display_errors",1);

include_once("../../../gestionseguridad/security.php");
include_once("../../../clases/gui.class.php");
include_once("../../../clases/clientes.class.php");

if($_SESSION['id_user_type'] != 1 && $_SESSION['id_user_type'] != 3){
    header("Location: ../../../gestionseguridad/exit.php");
}

$objGui = new GUI($_SESSION['id_user_type']);
$objClientes = new Clientes;

$id_cliente = (isset($_GET['code']))?$_GET['code']:0;

if($id_cliente != 0){
    $objClientes->get_client($id_cliente);
}

$estado=(isset($_GET['state']))?$_GET['state']:0;

$num_errores = (isset($_GET['cuenta']))?$_GET['cuenta']:0;
$nombre_archivo = (isset($_GET['archivo_error']))?$_GET['archivo_error']:0;

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
    
    <!--<script src="../../../js/metro/metro-loader.js"></script>-->
    <script src="../../../js/metro.min.js"></script>
    
    <script src="../../../js/dataTables/jquery.dataTables.js"></script>
    <script src="../../../js/dataTables/jquery.dataTables.min.js"></script>

    <script src="../../../js/funciones.js"></script>
        
    <script type="text/javascript">
                
        function cerrar_sesion(){
            window.location = '../../../gestionseguridad/exit.php';
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
                    <a href="index.php"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
                    Importar<small class="on-right">Clientes</small>
                </h1>
                
                <form action="subir_archivo.php" method="post" id="form_imp_cliente" enctype="multipart/form-data">      
                    <br />
                    <div class="span2 offset1" style="float: left; text-align: right; font-size: 12pt; padding: 5px;">Archivo Excel:&nbsp;</div>
                    <div class="input-control file size4">                        
                        <input name="fileupload" id="fileupload" type="file" placeholder="Archivo" />
                        <button id="upload_file" class="btn-file"></button>
                    </div>
                    <br />
                    <div>
                    <button class="primary large" style="float: left; margin-left: 434px;" type="submit">Importar</button>
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