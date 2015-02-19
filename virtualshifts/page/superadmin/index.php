<?php
ini_set("display_errors",1);
include_once("../../gestionseguridad/security.php");
include_once("../../clases/gui.class.php");
if($_SESSION['id_user_type'] != 9){
    header("Location: ../../gestionseguridad/exit.php");
}

$objGui = new GUI($_SESSION['id_user_type']);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8" />
    <meta name="product" content="Virtual SHIFTS" />
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

    <title>Virtual MOBILE</title>
</head>
<body class="metro" style="height: auto;">
    <?php
        echo $objGui->get_header();
    ?>
    <div class="page">
        <div class="page-region">
            <div class="page-region-content">
                <h1>
                    Virtual<small class="on-right">SHIFTS</small>
                </h1>
                
                <div class="tiles clearfix">
                    <div class="tile" style="cursor: pointer;" onclick="window.location = '../settings/usuarios/index.php'">
                        <div class="tile-content icon bg-darkBlue">
                            <b class="icon-user-2"></b>
                        </div>
                        <div class="brand">
                            <div class="name">Usuarios</div>
                        </div>
                    </div>
                    
                    <div class="tile" style="cursor: pointer;" onclick="window.location = '../settings/clientes/index.php'">
                        <div class="tile-content icon bg-red">
                            <b class="icon-briefcase-2"></b>
                        </div>
                        <div class="brand">
                            <div class="name">Clientes</div>
                        </div>
                    </div>     

                    <!--<div class="tile double live" data-role="live-tile" data-effect="slideLeft" data-easing="easeInBounce" style="cursor: default;">
                        <div class="tile-content">
                            <img src="../../images/vm1.png" alt="">
                        </div>
                        <div class="tile-content">
                            <img src="../../images/vm2.png" alt="">
                        </div>
                        <div class="tile-content">
                            <img src="../../images/vm3.png" alt="">
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