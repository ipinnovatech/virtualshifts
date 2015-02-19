<?php
ini_set("display_errors",1);

include_once("../../../gestionseguridad/security.php");
include_once("../../../clases/gui.class.php");
include_once("../../../clases/clientes.class.php");

if($_SESSION['id_user_type'] != 9 && $_SESSION['id_user_type'] != 3){
    header("Location: ../../../gestionseguridad/exit.php");
}

$objGui = new GUI($_SESSION['id_user_type']);
$objClientes =new Clientes;

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
    <link href="../../../css/iconFont.css" rel="stylesheet" />
    
    <?php echo $objGui->icon; ?>
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
    
    <script src="../../../js/dataTables/jquery.dataTables.js"></script>
    <script src="../../../js/dataTables/jquery.dataTables.min.js"></script>

        
    <script type="text/javascript">
        
        $(document).ready(function() {
			oTable = $('#clientes_table').dataTable({
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
        
        function activar_cliente(cliente_id, checkbox){
            var activar = $(checkbox).is(':checked');
            
            $("#checkbox_"+cliente_id).css('display', 'none');
            $("#carga_"+cliente_id).css('display', 'block');
            
            
            $.ajax({
                type: "POST",
                url: 'activar_cliente.php',
                data: { id_cliente:cliente_id, accion:activar },
                success: function(data) {
                    
                    $("#checkbox_"+cliente_id).css('display', 'block');
                    $("#carga_"+cliente_id).css('display', 'none');
                    
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
                    <a href="../../superadmin/index.php"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
                    Clientes<small class="on-right">Virtual SHIFTS</small>
                </h1>
                
                <nav class="horizontal-menu">
                    <ul>
                        <li><a href="nuevo_cliente.php"><b class="icon-plus fg-darkBlue"></b>&nbsp;Crear Cliente</a></li>
                    </ul>
                </nav>
                
                <table class="table hovered" id="clientes_table">
                    <thead>
                    <tr>
                        <th class="text-left">#</th>
                        <th class="text-left">Raz&oacute;n Social</th>
                        <th class="text-left">NIT</th>
                        <th class="text-left">Direcci&oacute;n</th>
                        <th class="text-left">Tel&eacute;fono</th>
                        <th class="text-left">Encargado</th>
                        <th class="text-left">E-mail Encargado</th>
                        <th class="text-left">Celular Encargado</th>
                        <th class="text-left">ID VirtualPBAX</th>
                        <th class="text-left">Activar</th>
                        <th class="text-left"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php 
                        $objClientes->get_clientes();
                        if($objClientes->has_value){
                            foreach($objClientes->array_campos as $row){ ?>
                                <tr>
                                    <td><?php echo $row['C_ID']; ?></td>
                                    <td><?php echo $row['C_RAZON_SOCIAL']; ?></td>
                                    <td><?php echo $row['C_NIT']; ?></td>
                                    <td><?php echo $row['C_DIRECCION']; ?></td>
                                    <td><?php echo $row['C_TELEFONO']; ?></td>
                                    <td><?php echo $row['C_NOMBRE_REPRESENTANTE']; ?></td>
                                    <td><?php echo $row['C_CORREO_REPRESENTANTE']; ?></td>
                                    <td><?php echo $row['C_CELULAR_REPRESENTANTE']; ?></td>
                                    <td><?php echo $row['C_ID_VIRTUAL_PBAX']?></td>
                                    <td>
                                        <div class="input-control checkbox" id="checkbox_<?php echo $row['C_ID']; ?>">
                                            <label>
                                                <input type="checkbox" onclick="activar_cliente('<?php echo $row['C_ID']; ?>', this);" <?php echo ($row['C_ACTIVO'])?'checked="checked"':''; ?> />
                                                <span class="check"></span>
                                            </label>
                                        </div>
                                        <img id="carga_<?php echo $row['C_ID']; ?>" src="../../../images/ajax-loader2.gif" style="display: none;" />
                                    </td>
                                    <td>
                                        <a href="nuevo_cliente.php?code=<?php echo $row['C_ID']; ?>" title="Editar cliente"><b class="icon-pencil"></b></a>
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