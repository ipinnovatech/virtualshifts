<?php
ini_set("display_errors",1);

include_once("../../../gestionseguridad/security.php");
include_once("../../../clases/gui.class.php");
include_once("../../../clases/sedes.class.php");

if($_SESSION['id_user_type'] != 10){
    header("Location: ../../../gestionseguridad/exit.php");
}

$objGui = new GUI($_SESSION['id_user_type']);
$objSedes = new Sedes;

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
                "aaSorting": [[ 11, "desc" ]],
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
        
        function activar_area(id_sede, checkbox){
            var activar = $(checkbox).is(':checked');
            
            $("#checkbox_"+id_sede).css('display', 'none');
            $("#carga_"+id_sede).css('display', 'block');
            
            
            $.ajax({
                type: "POST",
                url: 'activar_sede.php',
                data: { id_sede:id_sede, accion:activar },
                success: function(data) {
                    
                    $("#checkbox_"+id_sede).css('display', 'block');
                    $("#carga_"+id_sede).css('display', 'none');
                    
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
        
        function activa_muestra_video(sede, switche){
            var activar = $(switche).is(':checked');
            
            $("#switch_video_"+sede).css('display', 'none');
            $("#carga_video_"+sede).css('display', 'block');
            
            $.ajax({
                type: "POST",
                url: 'activa_muestra_video.php',
                data: { id_sede:sede, accion:activar },
                success: function(data) {
                    
                    $("#switch_video_"+sede).css('display', 'block');
                    $("#carga_video_"+sede).css('display', 'none');
                    
                    if(data == 'success'){ 
                        $.Notify({
                            content: "Cambios realizados con exito.",
                            style: {background: 'green', color: 'white'},
                            timeout: 5000,
                            width: 250,
                            height: 30                            
                        });
                        if(activar == true){
                            $("#imagen_"+sede).css('display','none');
                            $("#video_"+sede).css('display','block');
                        }else{
                            $("#imagen_"+sede).css('display','block');
                            $("#video_"+sede).css('display','none');
                        }                       
                    }else{                        
                        $.Notify({
                            content: "Ha ocurrido un error por favor intente mas tarde.",
                            style: {background: 'red', color: 'white'},
                            timeout: 5000,
                            width: 250,
                            height: 30                            
                        });
                        
                        $(switche).click();
                    }
                }
            });
        }
        
        function ver_foto(url){
            if(url != ''){
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
                    Sedes<small class="on-right">Virtual SHIFTS</small>
                </h1>
                
                <nav class="horizontal-menu">
                    <ul>
                        <li><a href="nueva_sede.php"><b class="icon-plus fg-ip"></b>&nbsp;Crear sedes</a></li>
                    </ul>
                </nav>
                
                <table class="table hovered" id="users_table">
                    <thead>
                    <tr>
                        <th class="text-left">#</th>
                        <th class="text-left">Nombre</th>
                        <th class="text-left">Descripci&oacute;n</th>                        
                        <th class="text-left">Imagenes/Videos</th>
                        <th></th>
                        <th></th>
                        <th></th>                        
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php 
                        $objSedes->get_sedes_por_cliente($_SESSION['cliente']);
                        
                        
                        if($objSedes->has_value){
                            foreach($objSedes->array_sedes as $row){ ?>
                                <tr>
                                    <td><?php echo $row['S_ID']; ?></td>
                                    <td><?php echo $row['S_NOMBRE']; ?></td>
                                    <td><?php echo $row['S_DESCRIPCION']; ?></td>                                    
                                    <td>
                                        <div id="switch_video_<?php echo $row['S_ID']; ?>">                                        
                                            <b class="icon-image fg-ip"></b>
                                            <div class="input-control switch">
                                                <label>
                                                    <input type="checkbox" <?php echo ($row['S_MUESTRA_VIDEO'] == 1)?'checked="checked"':''; ?> onclick="activa_muestra_video(<?php echo $row['S_ID']; ?>, this);" />
                                                    <span class="check"></span>
                                                </label>
                                            </div>                                        
                                            <b class="icon-film fg-ip"></b>
                                        </div>
                                        <img id="carga_video_<?php echo $row['S_ID']; ?>" src="../../../images/loading.gif" style="display: none; width: 18px;" />
                                    </td>
                                    <td>
                                        <a title="Ver logo" href="#" onclick="ver_foto('<?php echo isset($row['L_URL'])?$row['L_URL']:''; ?>')"><b class="icon-pictures fg-ip"></b></a>
                                    </td>
                                    <td>
                                        <a title="Cambiar logo" href="asociar_logos_sedes.php?code=<?php echo $row['S_ID']; ?>"><b class="icon-cog fg-ip"></b></a>
                                    </td>
                                    <td>
                                        <a <?php echo ($row['S_MUESTRA_VIDEO'] == 1)?'style="display: none"':''; ?> id="imagen_<?php echo $row['S_ID']; ?>" title="Asociar imagenes" href="asociar_imagenes_sedes.php?code=<?php echo $row['S_ID']; ?>"><b class="icon-image fg-ip"></b></a>
                                    </td>
                                    <td>
                                        <a <?php echo ($row['S_MUESTRA_VIDEO'] == 0)?'style="display: none"':''; ?> id="video_<?php echo $row['S_ID']; ?>" title="Asociar videos" href="asociar_videos_sedes.php?code=<?php echo $row['S_ID']; ?>"><b class="icon-film fg-ip"></b></a>
                                    </td>
                                    <td>
                                        <a title="Lanzar visor" href="../../viewer/index.php?code=<?php echo $row['S_ID']; ?>"><b class="icon-tv fg-ip"></b></a>
                                    </td>
                                    <td>
                                        <a title="Configurar encuestas" href="gestionencuestas/index.php?code=<?php echo $row['S_ID']; ?>" ><i class="icon-clipboard-2 fg-ip"></i></a>
                                    </td>
                                    <td>
                                        <div title="Activar sede" class="input-control checkbox" id="checkbox_<?php echo $row['S_ID']; ?>">
                                            <label>
                                                <input type="checkbox" onchange="activar_area(<?php echo $row['S_ID']; ?>, this)" <?php echo ($row['S_ACTIVO'])?'checked="checked"':''; ?>/>
                                                <span class="check"></span>
                                            </label>
                                        </div>
                                        <img id="carga_<?php echo $row['S_ID']; ?>" src="../../../images/loading.gif" style="display: none; width: 18px;" />
                                    </td>
                                    <td>
                                        <a title="Editar sede" href="nueva_sede.php?code=<?php echo $row['S_ID']; ?>"><b class="icon-pencil fg-ip"></b></a>
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