<?php
ini_set("display_errors",1);

include_once("../../../gestionseguridad/security.php");
include_once("../../../clases/gui.class.php");
include_once("../../../clases/historial_turnos.class.php");

if($_SESSION['id_user_type'] != 10){
    header("Location: ../../../gestionseguridad/exit.php");
}

$fecha_inicial = isset($_POST['fecha_inicial'])?$_POST['fecha_inicial']:date("Y-m-d");
$fecha_final = isset($_POST['fecha_final'])?$_POST['fecha_final']:date("Y-m-d");

$objHistorial = new HistorialTurnos();
$objGui = new GUI($_SESSION['id_user_type']);

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
			oTable = $('#tabla_reporte').dataTable({
				"bJQueryUI": true,
				"sPaginationType": "full_numbers",
                "bLengthChange": false,
                /*"sScrollX": "100%",
        		"sScrollXInner": "100%",*/
        		"bScrollCollapse": true,
                "bFilter": false,
                "aaSorting": [[ 0, "asc" ]],
                "oLanguage": {
        			"sLengthMenu": "Mostrando _MENU_ registros por pagina",
        			"sZeroRecords": "No se encontraron registros - !lo sentimos!",
        			"sInfo": "Mostrando _START_ a _END_ de _TOTAL_ registros",
        			"sInfoEmpty": "Mostrando 0 a 0 de 0 registros",
                    //"sSearch":"Buscar:",
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
                    Reporte<small class="on-right">Virtual SHIFTS</small>
                </h1>
                <form id="form_reportes" method="POST" action="index.php">
                    <br />
                    <div class="span2 offset1" style="float: left; font-size: 12pt;  margin-top: 5px;">Fecha inicial:&nbsp;</div>
                    <div class="input-control text size2" data-role="datepicker"
                        data-format='yyyy-mm-dd'
                        data-effect='slide'
                        data-locale='en'>
                        <input type="text" name="fecha_inicial" id="fecha_inicial" value="<?php echo $fecha_inicial; ?>" />
                        <button class="btn-date" onclick="return false;"></button>
                    </div>                    
                    <br />
                     <div class="span2 offset1" style="float: left; font-size: 12pt;  margin-top: 5px;">Fecha Final:&nbsp;</div>
                    <div class="input-control text size2" data-role="datepicker"
                        data-format='yyyy-mm-dd'
                        data-effect='slide'
                        data-locale='en'>
                        <input type="text" name="fecha_final" id="fecha_final" value="<?php echo $fecha_final; ?>" />
                        <button class="btn-date" onclick="return false;"></button>
                    </div>                    
                    <br />
                    <button type="submit" class="button large primary offset4">Generar reporte</button>
                </form>
                <legend>Resultados</legend>
                <a class="button large bg-green fg-white" style="float: right;" href="reporte_excel.php?<?php echo http_build_query($_POST); ?>"><b class="icon-file-excel fg-white"></b>&nbsp;Exportar a excel</a>
                <br />
                <div class="span12" id="contiene_tabla" style="overflow: auto;">
                    <table class="table" id="tabla_reporte" >
                        <thead>
                            <tr class='header'>
                                <th>FECHA</th>
                                <th>TURNO</th>
                                <th>REGIONAL</th>
                                <th>HORA DE CREACI&Oacute;N</th>
                                <th>HORA DE LA ASIGNACI&Oacute;N</th>
                                <th>HORA DE INICIO DE LA ATENCI&Oacute;N</th>
                                <th>TIEMPO DE ESPERA</th>
                                <th>HORA DE CIERRE DE LA ATENCI&Oacute;N</th>
                                <th>TIEMPO EN TURNO</th>
                                <th>NOMBRE DEL COLABORADOR</th>
                                <th>N&Uacute;MERO DE C&Eacute;DULA</th>
                                <th>N&Uacute;MERO DE CELULAR</th>
                                <th>CORREO ELECTR&Oacute;NICO</th>
                                <th>EMPRESA</th>                                
                                <th>CLIENTE</th>
                                <th>PROCESO</th>
                                <th>OBSERVACIONES DEL TURNO</th>
                                <th>DESCRIPCI&Oacute;N ACT. REALIZADA</th>
                                <th>DOCUMENTOS RECIBIDOS</th>
                                <th>DOCUMENTOS ENTREGADOS</th>
                                <th>ASESOR QUE ATENDIO EL TURNO</th>
                                <th>CATEGOR&Iacute;A</th>
                                <th>C&Oacute;DIGO DE TERMINACI&Oacute;N</th>
                                <th>RESULTADO DE LA ENCUESTA</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $reporte = $objHistorial->get_reporte_turno($fecha_inicial,$fecha_final, $_SESSION['cliente']);  
                            foreach($reporte as $key => $value){?>
                                <tr>
                                    <td><?php echo $value['FECHA'];?></td>
                                    <td><?php echo $value['TURNO'];?></td>
                                    <td><?php echo $value['REGIONAL'];?></td>
                                    <td><?php echo $value['HORA_CREACION'];?></td>
                                    <td><?php echo $value['HORA_ASIGNACION'];?></td>
                                    <td><?php echo $value['HORA_INICIO'];?></td>
                                    <td><?php echo $value['TIEMPO_EN_ESPERA'];?></td>
                                    <td><?php echo $value['HORA_FIN'];?></td>
                                    <td><?php echo $value['TIEMPO_EN_TURNO'];?></td>
                                    <td><?php echo $value['NOMBRE_COLABORADOR'];?></td>
                                    <td><?php echo $value['CEDULA'];?></td>
                                    <td><?php echo $value['CELULAR'];?></td>
                                    <td><?php echo $value['CORREO'];?></td>
                                    <td><?php echo $value['EMPRESA'];?></td>                                    
                                    <td><?php echo $value['CLIENTE'];?></td>
                                    <td><?php echo $value['PROCESO'];?></td>
                                    <td><?php echo $value['OBSERVACIONES'];?></td>
                                    <td><?php echo $value['DESCRIPCION'];?></td>
                                    <td><?php echo $value['DOCUMENTOS_RECIBIDOS'];?></td>
                                    <td><?php echo $value['DOCUMENTOS_ENTREGADOS'];?></td>
                                    <td><?php echo $value['NOMBRE_ASESOR'];?></td>
                                    <td><?php echo $value['CATEGORIA'];?></td>
                                    <td><?php echo $value['CODIGO_TERMINACION'];?></td>
                                    <td></td>
                                </tr> 
                                <?php
                            }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <br />
        <a class="button large bg-green fg-white" style="float: right;" href="reporte_excel.php?<?php echo http_build_query($_POST); ?>"><b class="icon-file-excel fg-white"></b>&nbsp;Exportar a excel</a>
        <br />
        <br />
    </div>    
    <?php
        echo $objGui->get_footer();
    ?>
    </body>
</html>