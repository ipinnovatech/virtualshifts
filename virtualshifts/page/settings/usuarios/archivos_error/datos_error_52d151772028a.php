<?php
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=reporte_errores_usuarios.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<html>
<body><table border="1"><tr align="center"><td colspan="4" style="font-size: 26px; background-color:#333399; color: white; font-weight: bold;">Virtual Mobile IPV</td></tr><tr></tr><tr><td>Tipo informe:</td><td colspan="3">Usuarios que no han sido creados debido a errores</td></tr>
                        <tr><td>Cantidad de elementos obtenidos:</td><td colspan="3">8</td></tr>
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
                            <td align='center'>mavago</td>
                            <td align='center'>apell</td>
                            <td align='center'>9876552</td>
                            <td align='center'>m@dfg.cij</td>
                            <td align='center'>23456</td>
                            <td align='center'>2</td>
                            <td align='center'>NO</td>
                            <td align='center'>1</td>
                            <td align='center'><b>Tipo Usuario</b> no existe</td>
                        </tr><tr>
                            <td align='center'>mavago2</td>
                            <td align='center'>apell2</td>
                            <td align='center'>9876553</td>
                            <td align='center'>m@dfg.cij</td>
                            <td align='center'>23456</td>
                            <td align='center'>1</td>
                            <td align='center'></td>
                            <td align='center'></td>
                            <td align='center'><b>Tipo Usuario</b> no permitido,<b>Tipo Usuario</b> no existe</td>
                        </tr><tr>
                            <td align='center'>mavago3</td>
                            <td align='center'>apell3</td>
                            <td align='center'>9876554</td>
                            <td align='center'>m@dfg.cij</td>
                            <td align='center'>23456</td>
                            <td align='center'>2</td>
                            <td align='center'>SI</td>
                            <td align='center'></td>
                            <td align='center'><b>Tipo Usuario</b> no existe</td>
                        </tr><tr>
                            <td align='center'>mavago4</td>
                            <td align='center'>apell4</td>
                            <td align='center'>9876555</td>
                            <td align='center'>m@dfg.cij</td>
                            <td align='center'>23456</td>
                            <td align='center'>2</td>
                            <td align='center'>NO</td>
                            <td align='center'>100</td>
                            <td align='center'><b>Tipo Usuario</b> no existe</td>
                        </tr><tr>
                            <td align='center'>mavago5</td>
                            <td align='center'>apell5</td>
                            <td align='center'>9876556</td>
                            <td align='center'>m@dfg.cij</td>
                            <td align='center'>23456</td>
                            <td align='center'>2</td>
                            <td align='center'>NO</td>
                            <td align='center'></td>
                            <td align='center'><b>Tipo Usuario</b> no existe</td>
                        </tr><tr>
                            <td align='center'>mavago6</td>
                            <td align='center'>apell6</td>
                            <td align='center'>9876557</td>
                            <td align='center'>m@dfg.cij</td>
                            <td align='center'>23456</td>
                            <td align='center'>5</td>
                            <td align='center'>NO</td>
                            <td align='center'></td>
                            <td align='center'><b>Tipo Usuario</b> no existe</td>
                        </tr><tr>
                            <td align='center'>mavago7</td>
                            <td align='center'>apell7</td>
                            <td align='center'>9876558</td>
                            <td align='center'>m@dfg.cij</td>
                            <td align='center'>23456</td>
                            <td align='center'>5</td>
                            <td align='center'>SI</td>
                            <td align='center'></td>
                            <td align='center'><b>Tipo Usuario</b> no existe</td>
                        </tr><tr>
                            <td align='center'>mavago8</td>
                            <td align='center'>apell8</td>
                            <td align='center'>9876559</td>
                            <td align='center'>Mjgj</td>
                            <td align='center'>23456</td>
                            <td align='center'>2</td>
                            <td align='center'>SI</td>
                            <td align='center'></td>
                            <td align='center'>campo <b>Correo</b> tiene formato no valido,<b>Tipo Usuario</b> no existe</td>
                        </tr></table></body></html>