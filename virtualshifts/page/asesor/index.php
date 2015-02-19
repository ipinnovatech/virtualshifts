<?php
ini_set("display_errors",1);
include_once("../../gestionseguridad/security.php");
include_once("../../clases/gui.class.php");
include_once("../../clases/usuarios.class.php");

if($_SESSION['id_user_type'] != 11){
    header("Location: ../../gestionseguridad/exit.php");
}

$objGui = new GUI($_SESSION['id_user_type']);
$objUsuarios = new Users;

$objUsuarios->get_ventanilla_y_sede_por_asesor($_SESSION['u_id']);
$sede = $objUsuarios->sede;

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8" />
    <meta name="product" content="Virtual MOBILE IPV" />
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
    <script src="../../js/metro/metro-dropdown.js"></script>
        
    <script type="text/javascript">
        function cerrar_sesion(){
            window.location = '../../gestionseguridad/exit.php';
        }
              
    </script>

    <title>Virtual DATE SHIFTS</title>
</head>
<body class="metro">
    <div class="tile-area tile-area-ip">        
        <ul class="dropdown-menu place-right drop-down" data-role="dropdown" style="margin-right: 63px; margin-top: -17px;" >
            <li class="menu-title" onclick="cerrar_sesion()">Cerrar sesi&oacute;n</li>
        </ul>
        <h1 class="tile-area-titlle fg-white">
            Asesor
        </h1>       
        <div class="user-id dropdown-toggle" href="#">
            <div class="user-id-image">
                <!--<span class="icon-user"></span>-->
                <img src="<?php echo $_SESSION['foto']; ?>" />
            </div>            
            <div class="user-id-name">
                <span class="first-name"><?php echo $_SESSION['nombres']; ?></span>
                <span class="last-name"><?php echo $_SESSION['apellidos']; ?></span>
            </div>                                  
        </div>
        
        <div class="tile-group six">
            <?php if($_SESSION['crea_turno']){ ?>
                <a class="tile double bg-lightBlue" href="gestionturnos/crear_turno.php" data-click="transform">
                    <div class="tile-content icon">
                        <img src="../../images/icon_crear_turno.png" />
                    </div>
                    <div class="brand">
                        <div class="label">Crear turno</div>
                    </div>
                </a>
            <?php } ?>
            <?php if($_SESSION['gestiona_turno']){ ?>
                <a class="tile double bg-darkGreen" href="gestionturnos/gestion_turnos.php" data-click="transform">
                    <div class="tile-content icon">
                        <img src="../../images/icon_gestion_turno.png" />
                    </div>
                    <div class="brand">
                        <div class="label">Gestionar turno</div>
                    </div>
                </a>
            <?php } ?>
            <?php if($_SESSION['administra_sede']){ ?>
                <a class="tile double bg-violet" href="configturnos/config_turnos.php" data-click="transform">
                    <div class="tile-content icon">
                        <span class="icon-cog fg-white"></span>
                    </div>
                    <div class="brand">
                        <div class="label">Modificar visor</div>
                    </div>
                </a>
            <?php } ?>
            <a href="../viewer/index.php?code=<?php echo $sede; ?>" class="tile double bg-orange" data-click="transform">
                <div class="tile-content icon">
                    <span class="icon-tv fg-white"></span>
                </div>
                <div class="brand">
                    <div class="label">Lanzar visor</div>
                </div>
            </a>
        </div>
        <div class="tile-group double">
            
        </div>
        <!--<div class="tile-group double">
            <div class="tile double bg-white">
                <div class="tile-content icon">
                    <img src="../../images/logo_grande.png" />
                </div>
            </div>
        </div>-->
    </div>
    <?php
        echo $objGui->get_footer();
    ?>
</body>
</html>