<?php
ini_set("display_errors",1);

include_once("../../../gestionseguridad/security.php");
include_once("../../../clases/gui.class.php");
include_once("../../../clases/usuarios.class.php");

if($_SESSION['id_user_type'] != 9 && $_SESSION['id_user_type'] != 10){
    header("Location: ../../../gestionseguridad/exit.php");
}

$objGui = new GUI($_SESSION['id_user_type']);
$objUsuario = new Users;

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
    
    <script src="../../../js/simpleModal/jquery.simplemodal.js"></script>
    
    <script src="../../../js/load-metro.js"></script>
            
    <script type="text/javascript">
        
        $(document).ready(function() {
			oTable = $('#users_table').dataTable({
				"bJQueryUI": true,
				"sPaginationType": "full_numbers",
                "bLengthChange": false,
                //"sScrollX": "100%",
//        		"sScrollXInner": "100%",
//        		"bScrollCollapse": true,
                "aaSorting": [[ 7, "desc" ], [0, 'asc']],
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
        
        function activar_usuario(user_id, checkbox){
            var activar = $(checkbox).is(':checked');
            
            $("#checkbox_"+user_id+"_1").css('display', 'none');
            $("#carga_"+user_id+"_1").css('display', 'block');
            
            
            $.ajax({
                type: "POST",
                url: 'activar_usuario.php',
                data: { id_user:user_id, accion:activar },
                success: function(data) {
                    
                    $("#checkbox_"+user_id+"_1").css('display', 'block');
                    $("#carga_"+user_id+"_1").css('display', 'none');
                    
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
        function activar_crea_turno(user_id, checkbox){
            var activar = $(checkbox).is(':checked');
            
            $("#checkbox_"+user_id+"_2").css('display', 'none');
            $("#carga_"+user_id+"_2").css('display', 'block');
            
            
            $.ajax({
                type: "POST",
                url: 'activar_crea_turno.php',
                data: { id_user:user_id, accion:activar },
                success: function(data) {
                    
                    $("#checkbox_"+user_id+"_2").css('display', 'block');
                    $("#carga_"+user_id+"_2").css('display', 'none');
                    
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
        function activar_gestiona_turno(user_id, checkbox){
            var activar = $(checkbox).is(':checked');
            
            $("#checkbox_"+user_id+"_3").css('display', 'none');
            $("#carga_"+user_id+"_3").css('display', 'block');
            
            
            $.ajax({
                type: "POST",
                url: 'activar_gestiona_turno.php',
                data: { id_user:user_id, accion:activar },
                success: function(data) {
                    
                    $("#checkbox_"+user_id+"_3").css('display', 'block');
                    $("#carga_"+user_id+"_3").css('display', 'none');
                    
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
        function activar_administra_sede(user_id, checkbox){
            var activar = $(checkbox).is(':checked');
            
            $("#checkbox_"+user_id+"_4").css('display', 'none');
            $("#carga_"+user_id+"_4").css('display', 'block');
            
            
            $.ajax({
                type: "POST",
                url: 'activar_administra_sede.php',
                data: { id_user:user_id, accion:activar },
                success: function(data) {
                    
                    $("#checkbox_"+user_id+"_4").css('display', 'block');
                    $("#carga_"+user_id+"_4").css('display', 'none');
                    
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
        
        function ver_foto(url){
            if(url != ''){
                var html = '';
                
                html += '<img src="'+url+'" />';
                
                $.Dialog({
                    shadow: true,
                    overlay: false,
                    icon: '<img src="http://ipvirtualmobile.com/virtualshifts/favicon.png" />',
                    title: 'Foto asesor',
                    width: 350,
                    padding: 10,
                    content: html
                });
            }
        }
        
        function mostrar_actualizar_foto(usaurio){
            $("#id_usuario").val(usaurio);
            $('#basic-modal-content').modal({
                opacity: 40,
                overlayClose: true,
                closeClass: 'closeModal'
            });
        }
        
        function actualizar_foto(){
            var form_foto = new FormData($('#form_actualiza_foto')[0]);
            $.ajax({
                type: "POST",
                url: 'actualizar_foto.php',
                data: form_foto,
                cache: false,
                processData: false,
                contentType: false,
                success: function(data) {                    
                    $(".closeModal").click();
                    if(data == 'success'){                        
                        $.Notify({
                            content: "Datos almacenados correctamente.",
                            style: {background: 'green', color: 'white'},
                            timeout: 5000,
                            width: 250,
                            height: 30                            
                        });
                        $("#id_usuario").val(0);
                        $("#archivo_foto").val('');
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
        
    </script>

    <title>Virtual MOBILE</title>
</head>
<body class="metro">
    <div style="width: 500px; margin-left: auto; margin-right: auto;" id="basic-modal-content" class="bg-white">
        <h3>Actualiza foto asesor</h3>
		<p>Seleccione el archivo a cargar</p>
        
        <div class="tile half" style="cursor: default; ">
            <div class="tile-content icon bg-gray">
                <b class="icon-user-3"></b>
            </div>
        </div>
        <form id="form_actualiza_foto" action="javascript:actualizar_foto();" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_usuario" id="id_usuario" value="0" />
            <br />
            <div class="input-control file size3">
                <input id="archivo_foto" name="achivo_foto" type="file" accept="image/*" />
                <button class="btn-file"></button>
            </div>
            <br />
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
                    <a href="<?php echo ($_SESSION['id_user_type'] == 9)?'../../superadmin/index.php':'../../admin/index.php'; ?>"><i class="icon-arrow-left-3 fg-darker smaller"></i></a>
                    Usuarios<small class="on-right">Virtual SHIFTS</small>
                </h1>
                
                <nav class="horizontal-menu">
                    <ul>
                        <li><a href="nuevo_usuario.php?id_user_type=<?php echo ($_SESSION['id_user_type'])?>"><b class="icon-plus fg-darkBlue"></b>&nbsp;Crear Usuario</a></li>
                        </ul>
                </nav>
                
                <table class="table hovered" id="users_table">
                    <thead>
                    <tr>
                        <th class="text-left">#</th>
                        <th class="text-left">Nombres</th>
                        <th class="text-left">Apellidos</th>
                        <th class="text-left">Username</th>
                        <th class="text-left">Cedula</th>
                        <th class="text-left">Celular</th>
                        <th class="text-left">Tipo Usuario</th>
                        <th class="text-left">Activar</th>
                        <th class="text-left">Crear Turnos</th>
                        <th class="text-left">Gestionar Turnos</th>                        
                        <th class="text-left">Administrar Sedes</th>
                        <th class="text-left">Ver foto</th>
                        <th class="text-left">Actualizar foto</th>
                        <th class="text-left"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php 
                        if($_SESSION['id_user_type'] == 9){
                            $objUsuario->mostrar_usuarios($_SESSION['cliente']);
                        }
                        
                        if($_SESSION['id_user_type'] == 10){
                            $objUsuario->mostrar_usuarios_para_admin($_SESSION['cliente']);
                        }
                        
                        
                        if($objUsuario->has_value){
                            foreach($objUsuario->array_usuarios as $row){ ?>
                                <tr>
                                    <td><?php echo $row['U_ID']; ?></td>
                                    <td><?php echo $row['U_NOMBRE']; ?></td>
                                    <td><?php echo $row['U_APELLIDOS']; ?></td>
                                    <td><?php echo $row['U_NICK']; ?></td>
                                    <td><?php echo $row['U_CEDULA']; ?></td>
                                    <td><?php echo $row['U_CELULAR']; ?></td>
                                    <td><?php echo $row['TU_NOMBRE']; ?></td>
                                    <td>
                                        <div class="input-control checkbox" id="checkbox_<?php echo $row['U_ID']; ?>_1">
                                            <label>
                                                <input type="checkbox" onclick="activar_usuario('<?php echo $row['U_ID']; ?>', this);" <?php echo ($row['U_ACTIVO'])?'checked="checked"':''; ?> />
                                                <span class="check"></span>
                                            </label>
                                        </div>
                                        <img id="carga_<?php echo $row['U_ID']; ?>_1" src="../../../images/ajax-loader2.gif" style="display: none;" />
                                    </td>
                                    <td>
                                        <div class="input-control checkbox" id="checkbox_<?php echo $row['U_ID']; ?>_2">
                                            <label>
                                                <input type="checkbox" onclick="activar_crea_turno('<?php echo $row['U_ID']; ?>', this);" <?php echo ($row['U_CREA_TURNO'])?'checked="checked"':''; echo ($row['U_TU_ID'] == 11)?'enabled':'disabled'; ?> />
                                                <span class="check"></span>
                                            </label>
                                        </div>
                                        <img id="carga_<?php echo $row['U_ID']; ?>_2" src="../../../images/ajax-loader2.gif" style="display: none;" />
                                    </td>
                                    <td>
                                        <div class="input-control checkbox" id="checkbox_<?php echo $row['U_ID']; ?>_3">
                                            <label>
                                                <input type="checkbox" onclick="activar_gestiona_turno('<?php echo $row['U_ID']; ?>', this);" <?php echo ($row['U_GESTIONA_TURNO'])?'checked="checked"':''; echo ($row['U_TU_ID'] == 11)?'enabled':'disabled'; ?> />
                                                <span class="check"></span>
                                            </label>
                                        </div>
                                        <img id="carga_<?php echo $row['U_ID']; ?>_3" src="../../../images/ajax-loader2.gif" style="display: none;" />
                                    </td>
                                    <td>
                                        <div class="input-control checkbox" id="checkbox_<?php echo $row['U_ID']; ?>_4">
                                            <label>
                                                <input type="checkbox" onclick="activar_administra_sede('<?php echo $row['U_ID']; ?>', this);" <?php echo ($row['U_ADMINISTRA_SEDE'])?'checked="checked"':''; echo ($row['U_TU_ID'] == 11)?'enabled':'disabled'; ?> />
                                                <span class="check"></span>
                                            </label>
                                        </div>
                                        <img id="carga_<?php echo $row['U_ID']; ?>_4" src="../../../images/ajax-loader2.gif" style="display: none;" />
                                    </td>
                                    <td><a href="#" onclick="ver_foto('<?php echo $row['U_URL_FOTO']; ?>')"><i class="icon-user-3" title="Ver foto"></i></a></td>
                                    <td><a href="#" onclick="mostrar_actualizar_foto('<?php echo $row['U_ID']; ?>')"><i class="icon-cog"></i></a></td>
                                    <td>
                                        <a href="nuevo_usuario.php?code=<?php echo $row['U_ID']; ?>" title="Editar usuario"><b class="icon-pencil"></b></a>
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