<?php
ini_set("display_errors",1);
include_once("../../gestionseguridad/security.php");
include_once("../../clases/gui.class.php");
if($_SESSION['id_user_type'] != 10){
    header("Location: ../../gestionseguridad/exit.php");
}

$objGui = new GUI($_SESSION['id_user_type']);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8" />
    <meta name="product" content="Virtual DATE SHIFTS" />
    <meta name="description" content="Gestion para el punto de venta" />
    <meta name="author" content="IP Innovatech" />

    <link href="../../css/metro-bootstrap.css" rel="stylesheet" />
    <link href="../../css/metro-bootstrap-responsive.css" rel="stylesheet" />
    <link href="../../css/docs.css" rel="stylesheet" />
    <link href="../../css/iconFont.css" rel="stylesheet" />
    <link href="../../js/prettify/prettify.css" rel="stylesheet" />
    
    <link href="../../css/simpleModal/basic.css" rel="stylesheet" />
    <link href="../../css/simpleModal/basic_ie.css" rel="stylesheet" />
    <link href="../../css/simpleModal/demo.css" rel="stylesheet" />
    <link href="../../css/portal.css" rel="stylesheet" />
    
    <?php echo $objGui->icon; ?>

    <!-- Load JavaScript Libraries -->
    <script src="../../js/jquery/jquery.js"></script>
    <script src="../../js/jquery/jquery.min.js"></script>
    <script src="../../js/jquery/jquery.widget.min.js"></script>
    <script src="../../js/jquery/jquery.mousewheel.js"></script>
    <script src="../../js/jquery/jquery.easing.1.3.min.js"></script>
    <script src="../../js/prettify/prettify.js"></script>
    <script src="../../js/holder/holder.js"></script>

    <!-- Metro UI CSS JavaScript plugins -->
    <script src="../../js/load-metro.js"></script>
        
    <script type="text/javascript">
        function cerrar_sesion(){
            window.location = '../../gestionseguridad/exit.php';
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
                    Administrador<small class="on-right">Virtual SHIFTS</small>
                </h1>
                
                <div class="tiles clearfix">
                    <div class="tile" style="cursor: pointer;" onclick="window.location = '../settings/usuarios/index.php'">
                        <div class="tile-content icon bg-lime">
                            <b class="icon-user"></b>
                        </div>
                        <div class="brand">
                            <div class="name">Usuarios</div>
                        </div>
                    </div>
                    
                    <div class="tile" style="cursor: pointer;" onclick="window.location = '../settings/codigos_terminacion/index.php'">
                        <div class="tile-content icon bg-darkOrange">
                            <b class="icon-flag-2"></b>
                        </div>
                        <div class="brand">
                            <div class="name">C&oacute;digos de terminaci&oacute;n</div>
                        </div>
                    </div>
                    
                    <div class="tile" style="cursor: pointer;" onclick="window.location = '../settings/areas/index.php'">
                        <div class="tile-content icon bg-cyan">
                            <b class="icon-layers-alt"></b>
                        </div>
                        <div class="brand">
                            <div class="name">&Aacute;reas</div>
                        </div>
                    </div>
                    
                    <div class="tile" style="cursor: pointer;" onclick="window.location = '../settings/categorias/index.php'">
                        <div class="tile-content icon bg-darkGreen">
                            <b class="icon-grid-view"></b>
                        </div>
                        <div class="brand">
                            <div class="name">Categor&iacute;as</div>
                        </div>
                    </div>
                    
                    <div class="tile" style="cursor: pointer;" onclick="window.location = '../settings/sedes/index.php'">
                        <div class="tile-content icon bg-pink">
                            <b class="icon-location"></b>
                        </div>
                        <div class="brand">
                            <div class="name">Sedes</div>
                        </div>
                    </div>
                    
                    <div class="tile" style="cursor: pointer;" onclick="window.location = '../settings/ventanillas/index.php'">
                        <div class="tile-content icon bg-amber">
                            <b class="icon-accessibility"></b>
                        </div>
                        <div class="brand">
                            <div class="name">Ventanillas</div>
                        </div>
                    </div>
                    
                    <div class="tile" style="cursor: pointer;" onclick="window.location = '../settings/auxiliaries/index.php'">
                        <div class="tile-content icon bg-green">
                            <b class="icon-busy"></b>
                        </div>
                        <div class="brand">
                            <div class="name">Auxiliaries</div>
                        </div>
                    </div>
                    
                    <div class="tile" style="cursor: pointer;" onclick="window.location = '../settings/videos/index.php'">
                        <div class="tile-content icon bg-magenta">
                            <b class="icon-film"></b>
                        </div>
                        <div class="brand">
                            <div class="name">Videos</div>
                        </div>
                    </div>
                    
                    <div class="tile" style="cursor: pointer;" onclick="window.location = '../settings/logos/index.php'">
                        <div class="tile-content icon bg-lightBlue">
                            <b class="icon-pictures"></b>
                        </div>
                        <div class="brand">
                            <div class="name">Logos</div>
                        </div>
                    </div>
                    
                    <div class="tile" style="cursor: pointer;" onclick="window.location = '../settings/imagenes/index.php'">
                        <div class="tile-content icon bg-lightOrange">
                            <b class="icon-image"></b>
                        </div>
                        <div class="brand">
                            <div class="name">Im&aacute;genes</div>
                        </div>
                    </div>
                    
                    <div class="tile" style="cursor: pointer;" onclick="window.location = '../settings/reportes/index.php'">
                        <div class="tile-content icon bg-steel">
                            <b class="icon-stats-2"></b>
                        </div>
                        <div class="brand">
                            <div class="name">Reportes</div>
                        </div>
                    </div>
                    
                    <!--<div class="tile" style="cursor: pointer;" onclick="window.location = '../settings/encuestas/index.php'">
                        <div class="tile-content icon bg-teal">
                            <b class="icon-clipboard-2"></b>
                        </div>
                        <div class="brand">
                            <div class="name">Encuestas</div>
                        </div>
                    </div>-->
                                           
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