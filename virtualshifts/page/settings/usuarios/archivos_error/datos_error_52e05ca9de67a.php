<?php
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=reporte_errores_usuarios.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<html>
<body><table border="1"><tr align="center"><td colspan="4" style="font-size: 26px; background-color:#333399; color: white; font-weight: bold;">Virtual Mobile IPV</td></tr><tr></tr><tr><td>Tipo informe:</td><td colspan="3">Usuarios que no han sido creados debido a errores</td></tr>
                        <tr><td>Cantidad de elementos obtenidos:</td><td colspan="3">1</td></tr>
                        <tr></tr>
                     <tr>
                        <td style="background-color:#333399; color: white; font-weight: bold;">Nombres</td>
                        <td style="background-color:#333399; color: white; font-weight: bold;">Apellidos</td>
                        <td style="background-color:#333399; color: white; font-weight: bold;">Cedula</td>
                        <td style="background-color:#333399; color: white; font-weight: bold;">Correo</td>
                        <td style="background-color:#333399; color: white; font-weight: bold;">Celular</td>
                        <td style="background-color:#333399; color: white; font-weight: bold;">Tipo usuario</td>
                        <td style="background-color:#333399; color: white; font-weight: bold;">Compartido</td>
                        <td style="background-color:#333399; color: white; font-weight: bold;">Perfil</td>
                        <td style="background-color:#333399; color: white; font-weight: bold;">Descripcion errores</td>
                      </tr><tr>
                            <td align='center'>YENLIN ANDREA</td>
                            <td align='center'>AMAYA BELEÑO</td>
                            <td align='center'>22645577</td>
                            <td align='center'></td>
                            <td align='center'>3183490508</td>
                            <td align='center'>2</td>
                            <td align='center'>SI</td>
                            <td align='center'></td>
                            <td align='center'>campo <b>Apellidos</b> tiene caracteres no validos</td>
                        </tr></table></body></html>