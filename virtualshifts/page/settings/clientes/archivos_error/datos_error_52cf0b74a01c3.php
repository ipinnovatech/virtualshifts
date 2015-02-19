<?php
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=reporte_errores_detallado.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<html>
<body><table border="1"><tr>
                        <td style="background-color:#333399; color: white; font-weight: bold;">Razon social</td>
                        <td style="background-color:#333399; color: white; font-weight: bold;">NIT</td>
                        <td style="background-color:#333399; color: white; font-weight: bold;">Direccion</td>
                        <td style="background-color:#333399; color: white; font-weight: bold;">Telefono</td>
                        <td style="background-color:#333399; color: white; font-weight: bold;">Representante</td>
                        <td style="background-color:#333399; color: white; font-weight: bold;">Cedula</td>
                        <td style="background-color:#333399; color: white; font-weight: bold;">email</td>
                        <td style="background-color:#333399; color: white; font-weight: bold;">Celular</td>
                        <td style="background-color:#333399; color: white; font-weight: bold;">Descripcion errores</td>
                      </tr><tr>
                            <td align='center'>ipinnovatech</td>
                            <td align='center'>3333333</td>
                            <td align='center'>cra x calle x</td>
                            <td align='center'>123456876</td>
                            <td align='center'>mauricio</td>
                            <td align='center'>45678</td>
                            <td align='center'>fcf@sdf.cj</td>
                            <td align='center'>4567</td>
                            <td align='center'>campo <b>Razon Social</b> tiene asociado otro cliente</td>
                        </tr><tr>
                            <td align='center'>mcc</td>
                            <td align='center'>-654</td>
                            <td align='center'>dfgh</td>
                            <td align='center'></td>
                            <td align='center'>fghj</td>
                            <td align='center'>fgh</td>
                            <td align='center'>bb</td>
                            <td align='center'>tyu</td>
                            <td align='center'>campo <b>Telefono</b> esta vacio,campo <b>Cedula</b> tiene caracteres no validos,campo <b>Correo</b> tiene formato no valido,campo <b>Celular</b> tiene formato no valido</td>
                        </tr><tr>
                            <td align='center'>conectar</td>
                            <td align='center'>56789</td>
                            <td align='center'>cvbn</td>
                            <td align='center'>5678</td>
                            <td align='center'>vbn</td>
                            <td align='center'></td>
                            <td align='center'>jnjn@dfg.d</td>
                            <td align='center'>56789</td>
                            <td align='center'>campo <b>Correo</b> tiene formato no valido</td>
                        </tr></table></body></html>