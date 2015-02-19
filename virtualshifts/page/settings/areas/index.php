<?php
ini_set("display_errors",1);

include_once("../../../gestionseguridad/security.php");
include_once("../../../clases/gui.class.php");
include_once("../../../clases/areas.class.php");

if($_SESSION['id_user_type'] != 10){
    header("Location: ../../../gestionseguridad/exit.php");
}

$objGui = new GUI($_SESSION['id_user_type']);
$objAreas = new Areas;

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
    
    <!--<link href="../../../css/dataTables/demo_table_jui.css" rel="stylesheet" />-->

    <!-- Load JavaScript Libraries -->
    <script src="../../../js/jquery/jquery.js"></script>
    <script src="../../../js/jquery/jquery.min.js"></script>
    <script src="../../../js/jquery/jquery.widget.min.js"></script>
    <script src="../../../js/jquery/jquery.mousewheel.js"></script>
    <script src="../../../js/jquery/jquery.easing.1.3.min.js"></script>
    <script src="../../../js/jquery/jquery.dataTables.js"></script>
    <script src="../../../js/prettify/prettify.js"></script>
    <script src="../../../js/holder/holder.js"></script>
    
    <script src="../../../js/load-metro.js"></script>

        
    <script type="text/javascript">
        
        $(document).ready(function() {
			oTable = $('#users_table').dataTable({
				"bJQueryUI": true,
				"sPaginationType": "full_numbers",
                "bLengthChange": false,
                /*"sScrollX": "100%",
        		"sScrollXInner": "100%",*/
        		"bScrollCollapse": true,
                "aaSorting": [[ 4, "desc" ]],
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
        
        function activar_area(id_area, checkbox){
            var activar = $(checkbox).is(':checked');
            
            $("#checkbox_"+id_area).css('display', 'none');
            $("#carga_"+id_area).css('display', 'block');
            
            
            $.ajax({
                type: "POST",
                url: 'activar_area.php',
                data: { id_area:id_area, accion:activar },
                success: function(data) {
                    
                    $("#checkbox_"+id_area).css('display', 'block');
                    $("#carga_"+id_area).css('display', 'none');
                    
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
                        
                        $(checkbox).click();
                    }
                }
            });
        }
        
        function mostrar_visor(id_area, checkbox){
            var mostrar = $(checkbox).is(':checked');
            
            $("#checkbox_mostrar_"+id_area).css('display', 'none');
            $("#carga_mostrar_"+id_area).css('display', 'block');
            
            
            $.ajax({
                type: "POST",
                url: 'mostrar_nombre_area_visor.php',
                data: { id_area:id_area, accion:mostrar },
                success: function(data) {
                    
                    $("#checkbox_mostrar_"+id_area).css('display', 'block');
                    $("#carga_mostrar_"+id_area).css('display', 'none');
                    
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
                        
                        $(checkbox).click();
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
                    <a href="../../admin/index.php"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
                    &Aacute;reas<small class="on-right">Virtual SHIFTS</small>
                </h1>
                
                <nav class="horizontal-menu">
                    <ul>
                        <li><a href="nueva_area.php"><b class="icon-plus fg-ip"></b>&nbsp;Crear &Aacute;rea</a></li>
                    </ul>
                </nav>
                
                <table class="table hovered" id="users_table">
                    <thead>
                    <tr>
                        <th class="text-left">#</th>
                        <th class="text-left">Nombre</th>
                        <th class="text-left">Descripci&oacute;n</th>
                        <th class="text-left">Alias</th>
                        <th class="text-left">Mostrar en visor</th>
                        <th class="text-left">Activo</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php 
                        $objAreas->get_areas($_SESSION['cliente']);
                        
                        
                        if($objAreas->has_value){
                            foreach($objAreas->array_areas as $row){ ?>
                                <tr>
                                    <td><?php echo $row['AR_ID']; ?></td>
                                    <td><?php echo $row['AR_NOMBRE']; ?></td>
                                    <td><?php echo $row['AR_DESCRIPCION']; ?></td>
                                    <td><?php echo $row['AR_ALIAS']; ?></td>
                                    <td>
                                        <div class="input-control checkbox" id="checkbox_mostrar_<?php echo $row['AR_ID']; ?>">
                                            <label>
                                                <input type="checkbox" onchange="mostrar_visor(<?php echo $row['AR_ID']; ?>, this)" <?php echo ($row['AR_MOSTRAR_NOMBRE_PANTALLA'])?'checked="checked"':''; ?>/>
                                                <span class="check"></span>
                                            </label>
                                        </div>
                                        <img id="carga_mostrar_<?php echo $row['AR_ID']; ?>" src="../../../images/loading.gif" style="display: none;" />
                                    </td>
                                    <td>
                                        <div class="input-control checkbox" id="checkbox_<?php echo $row['AR_ID']; ?>">
                                            <label>
                                                <input type="checkbox" onchange="activar_area(<?php echo $row['AR_ID']; ?>, this)" <?php echo ($row['AR_ACTIVO'])?'checked="checked"':''; ?>/>
                                                <span class="check"></span>
                                            </label>
                                        </div>
                                        <img id="carga_<?php echo $row['AR_ID']; ?>" src="../../../images/loading.gif" style="display: none;" />
                                    </td>
                                    <td>
                                        <a href="nueva_area.php?code=<?php echo $row['AR_ID']; ?>"><b class="icon-pencil fg-ip"></b></a>
                                    </td>
                                </tr>
                            <?php
                            }
                        }
                    ?>                    
                    </tbody>
                    <tfoot></tfoot>
                </table>                
            </div>
        </div>
    </div>
    <?php
        echo $objGui->get_footer();
    ?>
    </body>
</html>