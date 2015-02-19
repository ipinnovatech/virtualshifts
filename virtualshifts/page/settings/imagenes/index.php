<?php
ini_set("display_errors",1);

include_once("../../../gestionseguridad/security.php");
include_once("../../../clases/gui.class.php");
include_once("../../../clases/imagenes.class.php");

if($_SESSION['id_user_type'] != 10){
    header("Location: ../../../gestionseguridad/exit.php");
}

$objGui = new GUI($_SESSION['id_user_type']);
$objImagenes = new Imagenes;

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8" />
    <meta name="product" content="Virtual DATES SHIFTS" />
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
                "aaSorting": [[ 3, "desc" ]],
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
        
        function activar_imagen(id_imagen, checkbox){
            var activar = $(checkbox).is(':checked');
            
            $("#checkbox_"+id_imagen).css('display', 'none');
            $("#carga_"+id_imagen).css('display', 'block');
            
            
            $.ajax({
                type: "POST",
                url: 'activar_imagen.php',
                data: { id_imagen:id_imagen, accion:activar },
                success: function(data) {
                    
                    $("#checkbox_"+id_imagen).css('display', 'block');
                    $("#carga_"+id_imagen).css('display', 'none');
                    
                    if(data == 'success'){ 
                        $.Notify({
                            content: "Cambios realizados con exito.",
                            style: {background: 'green', color: 'white'},
                            timeout: 5000,
                            width: 250,
                            height: 30                            
                        });
                        //window.location = 'index.php';                       
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
        
        function ver_imagen(url){
            var html = '';
            
            html += '<img src="'+url+'" width="320">';
            
            $.Dialog({
                shadow: true,
                overlay: false,
                icon: '<img src="http://184.168.29.222/virtualshifts/favicon.png" />',
                title: 'Imagen',
                width: 350,
                padding: 10,
                content: html
            });
        }
        
        function eliminar_imagen(id, descrip, url){
            if(confirm('Desea eliminar la imagen '+descrip+'?')){
                alert("Se va a eliminar la imagen!");
                $.ajax({
                    type: "POST",
                    url: 'eliminar_imagen.php',
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
                    Im&aacute;genes<small class="on-right">Virtual SHIFTS</small>
                </h1>
                
                <nav class="horizontal-menu">
                    <ul>
                        <li><a href="nueva_imagen.php"><b class="icon-plus fg-ip"></b>&nbsp;Cargar imagen</a></li>
                        <!--<li><a href="../sedes/asociar_videos_sedes.php"><b class="icon-plus fg-ip"></b>&nbsp;Asociar videos a las sedes</a></li>-->
                    </ul>
                </nav>
                
                <table class="table hovered" id="users_table">
                    <thead>
                    <tr>
                        <th class="text-left">#</th>
                        <th class="text-left">Descripci&oacute;n</th>
                        <th class="text-left">Ver imagen</th>
                        <th class="text-left">Activo</th>                        
                        <th class="text-left">Editar</th>
                        <th class="text-left">Eliminar</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php 
                        $objImagenes->get_imagenes($_SESSION['cliente']);
                        
                        
                        if($objImagenes->has_value){
                            foreach($objImagenes->array_campos as $row){ ?>
                                <tr>
                                    <td><?php echo $row['IMA_ID']; ?></td>
                                    <td><?php echo $row['IMA_DESCRIPCION']; ?></td>
                                    <td>
                                        <a href="#" onclick="ver_imagen('<?php echo $row['IMA_URL']; ?>')"><b class="icon-image fg-green"></b></a>
                                    </td>
                                    <td>
                                        <div class="input-control checkbox" id="checkbox_<?php echo $row['IMA_ID']; ?>">
                                            <label>
                                                <input type="checkbox" onchange="activar_imagen(<?php echo $row['IMA_ID']; ?>, this)" <?php echo ($row['IMA_ACTIVO'])?'checked="checked"':''; ?>/>
                                                <span class="check"></span>
                                            </label>
                                        </div>
                                        <img id="carga_<?php echo $row['IMA_ID']; ?>" src="../../../images/ajax-loader2.gif" style="display: none;" />
                                    </td>
                                    <td>
                                        <a href="nueva_imagen.php?code=<?php echo $row['IMA_ID']; ?>" title="Editar video"><b class="icon-pencil fg-ip"></b></a>
                                    </td>
                                    <td>
                                        <a href="#" onclick="eliminar_imagen(<?php echo $row['IMA_ID']; ?>, '<?php echo $row['IMA_DESCRIPCION']; ?>', '<?php echo $row['IMA_URL']; ?>')" title="Eliminar logo"><b class="icon-remove fg-red"></b></a>
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
