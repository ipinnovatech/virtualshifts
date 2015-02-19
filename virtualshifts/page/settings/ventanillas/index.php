<?php
ini_set("display_errors",1);

include_once("../../../gestionseguridad/security.php");
include_once("../../../clases/gui.class.php");
include_once("../../../clases/ventanillas.class.php");

if($_SESSION['id_user_type'] != 10){
    header("Location: ../../../gestionseguridad/exit.php");
}

$objGui = new GUI($_SESSION['id_user_type']);
$objVentanillas = new Ventanillas;

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
    
    <script src="../../../js/simpleModal/jquery.simplemodal.js"></script>
        
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
        
        function activar_ventanilla(id_ventanilla, checkbox){
            var activar = $(checkbox).is(':checked');
            
            $("#checkbox_"+id_ventanilla).css('display', 'none');
            $("#carga_"+id_ventanilla).css('display', 'block');
            
            
            $.ajax({
                type: "POST",
                url: 'activar_ventanilla.php',
                data: { id_ventanilla:id_ventanilla, accion:activar },
                success: function(data) {
                    
                    $("#checkbox_"+id_ventanilla).css('display', 'block');
                    $("#carga_"+id_ventanilla).css('display', 'none');
                    
                    if(data == 'success'){ 
                        $.Notify({
                            content: "Cambios realizados con exito.",
                            style: {background: 'green', color: 'white'},
                            timeout: 5000,
                            width: 250,
                            height: 30                            
                        });
                        window.location = 'index.php';                       
                    }else if(data == 'error'){                        
                        $.Notify({
                            content: "Ha ocurrido un error por favor intente mas tarde.",
                            style: {background: 'red', color: 'white'},
                            timeout: 5000,
                            width: 250,
                            height: 30                            
                        });                        
                    }else if(data == 'error2'){
                        $.Notify({
                            content: "El nombre ya existe en la sede.",
                            style: {background: 'red', color: 'white'},
                            timeout: 5000,
                            width: 250,
                            height: 30                            
                        }); 
                    }
                }
            });
        }
        
        function prioridad(ventanilla){
             $("#ventanilla_prioridad").val(0);
             $("#ventanilla_prioridad").val(ventanilla);
             $.ajax({
                type: "POST",
                url: 'get_areas_por_ventanilla.php',
                data: {ventanilla: ventanilla},
                success: function(data){
                    $("#areas_para_prioridad tbody").html('');
                    $("#areas_para_prioridad tbody").html(data);
                }
             });
            
            $('#basic-modal-content').modal({
                opacity: 40,
                overlayClose: true,
                closeClass: 'closeModal'
            });
        }
        
        function cambiar_prioridades(){
            var form_areas_prioridad = $("#form_areas_prioridad").serialize();
            
            $.ajax({
                type: "POST",
                url: 'actualizar_prioridades.php',
                data: form_areas_prioridad,
                success: function(data){
                    if(data == 'success'){ 
                        $.Notify({
                            content: "Cambios realizados con exito.",
                            style: {background: 'green', color: 'white'},
                            timeout: 5000,
                            width: 250,
                            height: 30                            
                        });                                              
                    }else if(data == 'error'){                        
                        $.Notify({
                            content: "Ha ocurrido un error por favor intente mas tarde.",
                            style: {background: 'red', color: 'white'},
                            timeout: 5000,
                            width: 250,
                            height: 30                            
                        });                        
                    }
                    $('.closeModal').click();
                    $("#ventanilla_prioridad").val(0);
                }
             });
        }
    </script>

    <title>Virtual DATE SHIFTS</title>
</head>
<body class="metro" style="height: auto;">
    <div style="width: 500px; margin-left: auto; margin-right: auto;" id="basic-modal-content" class="bg-white">
        <h3>Establecer prioridad</h3>
		<p>Seleccione la prioridad por area</p>
        
        <div class="tile half" style="cursor: default; ">
            <div class="tile-content icon bg-gray">
                <b class="icon-power"></b>
            </div>
        </div>
        <form id="form_areas_prioridad" action="javascript:cambiar_prioridades();" method="POST">
            <input type="hidden" name="ventanilla_prioridad" id="ventanilla_prioridad" value="0" />
            <table class="table" id="areas_para_prioridad">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Area</th>
                        <th>Prioridad</th>
                    </tr>
                </thead>
                <tbody>                
                </tbody>
            </table>
            <br />
            <button style="margin-left: 10px;" class="button primary place-right">Guardar</button>
            <button class="button place-right" onclick="$('.closeModal').click(); return false;">Cancelar</button>                        
        </form>      
        <br />      
	</div>
    <?php
        echo $objGui->get_header();
    ?>
    <div class="page">
        <div class="page-region">
            <div class="page-region-content">                
                <h1>
                    <a href="../../admin/index.php"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
                    Ventanillas<small class="on-right">Virtual SHIFTS</small>
                </h1>
                
                <nav class="horizontal-menu">
                    <ul>
                        <li><a href="nueva_ventanilla.php"><b class="icon-plus fg-ip"></b>&nbsp;Crear ventanilla</a></li>
                    </ul>
                </nav>
                
                <table class="table hovered" id="users_table">
                    <thead>
                    <tr>
                        <th class="text-left">#</th>
                        <th class="text-left">Nombre</th>
                        <th class="text-left">Descripci&oacute;n</th>
                        <th class="text-left">Sede</th>
                        <th class="text-left">Activo</th>
                        <th class="text-left">Asociar areas</th>
                        <th class="text-left">Establecer prioridad</th>                         
                        <th class="text-left">Editar</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php 
                        $objVentanillas->get_ventanillas($_SESSION['cliente']);
                        
                        
                        if($objVentanillas->has_value){
                            foreach($objVentanillas->array_ventanillas as $row){ ?>
                                <tr>
                                    <td><?php echo $row['VENT_ID']; ?></td>
                                    <td><?php echo $row['VENT_NOMBRE']; ?></td>
                                    <td><?php echo $row['VENT_DESCRIPCION']; ?></td>
                                    <td><?php echo $row['S_NOMBRE']; ?></td>
                                    <td>
                                        <div class="input-control checkbox" id="checkbox_<?php echo $row['VENT_ID']; ?>">
                                            <label>
                                                <input type="checkbox" onchange="activar_ventanilla(<?php echo $row['VENT_ID']; ?>, this)" <?php echo ($row['VENT_ACTIVO'])?'checked="checked"':''; ?>/>
                                                <span class="check"></span>
                                            </label>
                                        </div>
                                        <img id="carga_<?php echo $row['VENT_ID']; ?>" src="../../../images/ajax-loader2.gif" style="display: none;" />
                                    </td>
                                    <td>
                                        <a href="asociar_areas.php?code=<?php echo $row['VENT_ID']; ?>" title="Asociar areas"><b class="icon-layers-alt fg-ip"></b></a>
                                    </td>
                                    <td>
                                        <a href="#" onclick="prioridad('<?php echo $row['VENT_ID']; ?>')" title="Establecer prioridad"><b class="icon-power fg-ip"></b></a>
                                    </td>
                                    <td>
                                        <a href="nueva_ventanilla.php?code=<?php echo $row['VENT_ID']; ?>" title="Editar ventanilla"><b class="icon-pencil fg-ip"></b></a>
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