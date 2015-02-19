<?php
ini_set("display_errors",1);

include_once("../../../gestionseguridad/security.php");
include_once("../../../clases/gui.class.php");
include_once("../../../clases/logos.class.php");
include_once("../../../clases/sedes.class.php");

if($_SESSION['id_user_type'] != 9 && $_SESSION['id_user_type'] != 10){
    header("Location: ../../../gestionseguridad/exit.php");
}

$objGui = new GUI($_SESSION['id_user_type']);
$objLogos = new Logos;

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8" />
    <meta name="product" content="Virtual DATE SHIFTS" />
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

        
    <script type="text/javascript">
        
        $(document).ready(function() {
			oTable = $('#logos_table').dataTable({
				"bJQueryUI": true,
				"sPaginationType": "full_numbers",
                "bLengthChange": false,
                //"sScrollX": "100%",
//        		"sScrollXInner": "100%",
//        		"bScrollCollapse": true,
                "aaSorting": [[ 0, "asc" ]],
                "oLanguage": {
        			"sLengthMenu": "Mostrando _MENU_ registros por pagina",
        			"sZeroRecords": "No se encontraron registros - !lo sentimos!",
        			"sInfo": "Mostrando _START_ a _END_ de _TOTAL_ registros",
        			"sInfoEmpty": "Mostrando 0 a 0 de 0 registros",
                    "sSearch":"Buscar:",
                    "oPaginate": {
                        "sFirst":    "Primero",
                        "sPrevious": "<<",
                        "sNext":     ">>",
                        "sLast":     "\xdaltimo"
                    },
        			"sInfoFiltered": "(Filtrado de un total de _MAX_ registros)"
        		}                    
			});
		} );
        
        function cerrar_sesion(){
            window.location = '../../../gestionseguridad/exit.php';
        }
        
        function ver_foto(url){
            var html = '';
            
            html += '<img src="'+url+'" />';
            
            $.Dialog({
                shadow: true,
                overlay: false,
                icon: '<img src="http://184.168.29.222/virtualshifts/favicon.png" />',
                title: 'Logo',
                width: 350,
                padding: 10,
                content: html
            });
        }
        
        function eliminar_logo(id, nombre, url){
            if(confirm('Desea eliminar el logo '+nombre+'?')){
                alert("Se va a eliminar el logo!");
                $.ajax({
                    type: "POST",
                    url: 'eliminar_logo.php',
                    data: {id:id, url:url},
                    success: function(data) {                        
                        if(data == 'success'){ 
                            $.Notify({
                                content: "Cambios realizados con exito.",
                                style: {background: 'green', color: 'white'},
                                timeout: 5000,
                                width: 250,
                                height: 30                            
                            });
                            location.reload();                       
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
                    <a href="../../admin/index.php"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
                    Logos<small class="on-right">Virtual SHIFTS</small>
                </h1>
                
                <nav class="horizontal-menu">
                    <ul>
                        <li><a href="nuevo_logo.php"><b class="icon-plus fg-darkBlue"></b>&nbsp;Crear Logo</a></li>
                    </ul>
                </nav>
                
                <table class="table hovered" id="logos_table">
                    <thead>
                    <tr>
                        <th class="text-left">#</th>
                        <th class="text-left">Nombre</th>
                        <th class="text-left">Descripci&oacute;n</th>
                        <th class="text-left">Ver imagen</th>
                        <th class="text-left">Editar</th>
                        <th class="text-left">Eliminar</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php 
                        $objLogos->get_logos_por_cliente($_SESSION['cliente']);
                        if($objLogos->has_value){
                            foreach($objLogos->array_campos as $row){ ?>
                                <tr>
                                    <td><?php echo $row['L_ID']; ?></td>
                                    <td><?php echo $row['L_NOMBRE']; ?></td>
                                    <td><?php echo $row['L_DESCRIPCION']; ?></td>
                                    <td>
                                        <a href="#" onclick="ver_foto('<?php echo $row['L_URL']; ?>');"><i class="icon-pictures fg-ip"></i></a>
                                    </td>                                    
                                    <td>
                                        <a href="nuevo_logo.php?code=<?php echo $row['L_ID']; ?>" title="Editar Logo"><b class="icon-pencil"></b></a>
                                    </td>
                                    <td>
                                        <a href="#" onclick="eliminar_logo(<?php echo $row['L_ID']; ?>, '<?php echo $row['L_NOMBRE']; ?>', '<?php echo $row['L_URL']; ?>')" title="Eliminar logo"><b class="icon-remove fg-red"></b></a>
                                    </td>
                                </tr>
                            <?php                                
                            }
                        }
                    ?>                    
                    </tbody>
                    <tfoot></tfoot>
                </table>
                
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