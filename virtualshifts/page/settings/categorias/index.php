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
			oTable = $('#categorias_table').dataTable({
				"bJQueryUI": true,
				"sPaginationType": "full_numbers",
                "bLengthChange": false,
                //"sScrollX": "100%",
//        		"sScrollXInner": "100%",
//        		"bScrollCollapse": true,
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
        
        function activar_categoria(categoria_id, checkbox){
            var activar = $(checkbox).is(':checked');
            
            $("#checkbox_"+categoria_id).css('display', 'none');
            $("#carga_"+categoria_id).css('display', 'block');
            
            
            $.ajax({
                type: "POST",
                url: 'activar_categoria.php',
                data: { id_categoria:categoria_id, accion:activar },
                success: function(data) {
                    
                    $("#checkbox_"+categoria_id).css('display', 'block');
                    $("#carga_"+categoria_id).css('display', 'none');
                    
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
                        return false;
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
                    <a href="../../admin/index.php"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
                    Categor&iacute;as<small class="on-right">Virtual SHIFTS</small>
                </h1>
                
                <nav class="horizontal-menu">
                    <ul>
                        <li><a href="nuevo_categoria.php"><b class="icon-plus fg-darkBlue"></b>&nbsp;Crear Categor&iacute;a</a></li>
                    </ul>
                </nav>
                
                <table class="table hovered" id="categorias_table">
                    <thead>
                    <tr>
                        <th class="text-left">#</th>
                        <th class="text-left">Nombre</th>
                        <th class="text-left">Descripci&oacute;n</th>
                        <th class="text-left">Activo</th>
                        <th class="text-left">Asociar C&oacute;digos de terminaci&oacute;n</th>
                        <th class="text-left"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php 
                        $objCategorias->get_categorias_por_cliente($_SESSION['cliente']);
                        if($objCategorias->has_value){
                            foreach($objCategorias->array_campos as $row){?>
                                <tr>
                                    <td><?php echo $row['CAT_ID']; ?></td>
                                    <td><?php echo $row['CAT_NOMBRE']; ?></td>
                                    <td><?php echo $row['CAT_DESCRIPCION']; ?></td>
                                    <td>
                                        <div class="input-control checkbox" id="checkbox_<?php echo $row['CAT_ID']; ?>">
                                            <label>
                                                <input type="checkbox" onclick="activar_categoria('<?php echo $row['CAT_ID']; ?>', this);" <?php echo ($row['CAT_ACTIVO'])?'checked="checked"':''; ?> />
                                                <span class="check"></span>
                                            </label>
                                        </div>
                                        <img id="carga_<?php echo $row['CAT_ID']; ?>" src="../../../images/ajax-loader2.gif" style="display: none;" />
                                    </td>
                                    <td>
                                        <a href="asociar_codigos_terminacion.php?code=<?php echo $row['CAT_ID']; ?>" title="Asociar codigos de terminacion"><b class="icon-flag-2 fg-ip"></b></a>
                                    </td>
                                    <td>
                                        <a href="nuevo_categoria.php?code=<?php echo $row['CAT_ID']; ?>" title="Editar Categoria"><b class="icon-pencil"></b></a>
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