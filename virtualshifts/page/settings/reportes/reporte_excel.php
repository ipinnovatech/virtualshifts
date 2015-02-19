<?php

ini_set('memory_limit', '-1');
ini_set('max_execution_time', 300);
/**
 * PHPExcel
 *
 * Copyright (C) 2006 - 2010 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2010 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    1.7.5, 2010-12-10
 */

/** Error reporting */
error_reporting(E_ALL);

//date_default_timezone_set('Europe/London');

/** PHPExcel */
include_once("../../../gestionseguridad/security.php");
require_once("../../../clases/PHPExcel.php");
include_once("../../../clases/gui.class.php");
include_once("../../../clases/historial_turnos.class.php");
include_once("../../../clases/clientes.class.php");
if($_SESSION['id_user_type'] != 10){
    header("Location: ../../../gestionseguridad/exit.php");
}

$objCliente = new Clientes();
$objHistorial = new HistorialTurnos();
$nombreCliente = $objCliente->get_client($_SESSION['cliente']);
$objGui = new GUI($_SESSION['id_user_type']);

$fecha_inicial = isset($_GET['fecha_inicial'])?$_GET['fecha_inicial']:date("Y-m-d");
$fecha_final = isset($_GET['fecha_final'])?$_GET['fecha_final']:date("Y-m-d");

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set properties
$objPHPExcel->getProperties()->setCreator("IPInnovatech")
							 ->setLastModifiedBy("IPInnovatech")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");
// Add some data
$objPHPExcel->setActiveSheetIndex(0)
            ->mergeCells('A1:B4')
            ->mergeCells('C2:C3')
            ->mergeCells('D2:D3')
            ->mergeCells('E2:E3')
            ->mergeCells('C4:E4')
            ->mergeCells('A5:F5')
            ->mergeCells('A5:F5')
            ->mergeCells('F1:F4')
           
            ->setCellValue('C1', 'CLIENTE')
            ->setCellValue('D1', 'FECHA REPORTE')
            ->setCellValue('E1', 'CANTIDAD DE REGISTROS OBTENIDOS')
            ->setCellValue('C2', $nombreCliente['0']['C_RAZON_SOCIAL'] )
            ->setCellValue('D2', date("Y-m-d H:i:s"))
            ->setCellValue('B6', 'Reporte Turnos entre el '.$fecha_inicial.' y el '.$fecha_final);

// Set thin white border outline around column
$styleThinWhiteBorderOutline = array(
	'borders' => array(
		'outline' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
			'color' => array('argb' => 'FFFFFFFF'),
		),
	),
);

$objPHPExcel->getActiveSheet()->getStyle('A5:F5')->applyFromArray($styleThinWhiteBorderOutline);
$objPHPExcel->getActiveSheet()->getStyle('C4:E4')->applyFromArray($styleThinWhiteBorderOutline);

// Set thin black border outline around column
$styleThinBlackBorderOutline = array(
	'borders' => array(
		'outline' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
			'color' => array('argb' => 'FF000000'),
		),
	),
);

$reporte = $objHistorial->get_reporte_turno($fecha_inicial, $fecha_final, $_SESSION['cliente']);

$objPHPExcel->setActiveSheetIndex(0);

//$objPHPExcel->getActiveSheet()->getStyle('B8')->applyFromArray($styleThinBlackBorderOutline);
//$objPHPExcel->getActiveSheet()->getStyle('W8')->applyFromArray($styleThinBlackBorderOutline);

$objPHPExcel->getActiveSheet()->getStyle('B7:Y7')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('B7:Y7')->getFont()->setColor( new PHPExcel_Style_Color( PHPExcel_Style_Color::COLOR_WHITE ) );

//$objPHPExcel->getActiveSheet()->getStyle('B8')->getFont()->setBold(true);
//$objPHPExcel->getActiveSheet()->getStyle('B8')->getFont()->setBold(true);

$objPHPExcel->getActiveSheet()->getStyle('B7:Y7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    
$n = 8;
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B7', 'FECHA');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C7', 'TURNO');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D7', 'REGIONAL');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E7', 'HORA DE CREACIÓN');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F7', 'HORA DE LA ASIGNACIÓN');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G7', 'HORA DE INICIO DE LA ATENCIÓN');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H7', 'TIEMPO DE ESPERA');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I7', 'HORA DE CIERRE DE LA ATENCIÓN');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J7', 'TIEMPO EN TURNO');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K7', 'NOMBRE DEL COLABORADOR');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L7', 'NÚMERO DE CÉDULA');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M7', 'NÚMERO DE CELULAR');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N7', 'CORREO ELECTRÓNICO');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O7', 'EMPRESA');    
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P7', 'CLIENTE');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q7', 'PROCESO');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R7', 'OBSERVACIONES DEL TURNO');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S7', 'DESCRIPCIÓN ACT. REALIZADA');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T7', 'DOCUMENTOS RECIBIDOS');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('U7', 'DOCUMENTOS ENTREGADOS');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V7', 'ASESOR QUE ATENDIO EL TURNO');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('W7', 'CATEGORIA');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('X7', 'CODIGO DE TERMINACION');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Y7', 'RESULTADO DE LA ENCUESTA');
foreach($reporte as $key => $dato){
    
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$n, $dato['FECHA']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$n, $dato['TURNO']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$n, $dato['REGIONAL']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$n, $dato['HORA_CREACION']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$n, $dato['HORA_ASIGNACION']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$n, $dato['HORA_INICIO']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$n, $dato['TIEMPO_EN_ESPERA']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$n, $dato['HORA_FIN']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$n, $dato['TIEMPO_EN_TURNO']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$n, $dato['NOMBRE_COLABORADOR']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$n, $dato['CEDULA']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$n, $dato['CELULAR']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$n, $dato['CORREO']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$n, $dato['EMPRESA']);    
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$n, $dato['CLIENTE']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$n, $dato['PROCESO']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$n, $dato['OBSERVACIONES']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.$n, $dato['DESCRIPCION']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T'.$n, $dato['DOCUMENTOS_RECIBIDOS']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('U'.$n, $dato['DOCUMENTOS_ENTREGADOS']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V'.$n, $dato['NOMBRE_ASESOR']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('W'.$n, $dato['CATEGORIA']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('X'.$n, $dato['CODIGO_TERMINACION']);
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Y'.$n, "");
    
    
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('V')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('W')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('X')->setAutoSize(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension('Y')->setAutoSize(true);
    //$objPHPExcel->getActiveSheet()->getColumnDimension('W')->setAutoSize(true);
    
    $objPHPExcel->getActiveSheet()->getStyle('B'.$n.':Y'.$n)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
  $n++;   
}

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E2', ($n-8));

$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B6:Y6');

$objPHPExcel->getActiveSheet()->getStyle('C1:E1')->applyFromArray($styleThinBlackBorderOutline);
$objPHPExcel->getActiveSheet()->getStyle('C2:E3')->applyFromArray($styleThinBlackBorderOutline);
$objPHPExcel->getActiveSheet()->getStyle('B8:Y'.($n-1))->applyFromArray($styleThinBlackBorderOutline);
$objPHPExcel->getActiveSheet()->getStyle('B6:Y6')->applyFromArray($styleThinBlackBorderOutline);
$objPHPExcel->getActiveSheet()->getStyle('A1:F5')->applyFromArray($styleThinBlackBorderOutline);
$objPHPExcel->getActiveSheet()->getStyle('B7:Y7')->applyFromArray($styleThinBlackBorderOutline);
//$objPHPExcel->getActiveSheet()->getStyle('B8')->applyFromArray($styleThinBlackBorderOutline);

// Set fills
$objPHPExcel->getActiveSheet()->getStyle('C1:E1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('C1:E1')->getFill()->getStartColor()->setARGB('FF333399');
$objPHPExcel->getActiveSheet()->getStyle('B6:W6')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('B6:Y6')->getFill()->getStartColor()->setARGB('FF333399');
$objPHPExcel->getActiveSheet()->getStyle('B7:Y7')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('B7:Y7')->getFill()->getStartColor()->setARGB('FF333399');

// Set fonts
$objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setColor( new PHPExcel_Style_Color( PHPExcel_Style_Color::COLOR_WHITE ) );
$objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()->setColor( new PHPExcel_Style_Color( PHPExcel_Style_Color::COLOR_WHITE ) );
$objPHPExcel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('E1')->getFont()->setColor( new PHPExcel_Style_Color( PHPExcel_Style_Color::COLOR_WHITE ) );
$objPHPExcel->getActiveSheet()->getStyle('B6')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('B6')->getFont()->setColor( new PHPExcel_Style_Color( PHPExcel_Style_Color::COLOR_WHITE ) );
//$objPHPExcel->getActiveSheet()->getStyle('B8')->getFont()->setBold(true);

// Set column widths
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);

// Set alignments
$objPHPExcel->getActiveSheet()->getStyle('C1:F2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('C1:F2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('B6')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
//$objPHPExcel->getActiveSheet()->getStyle('B8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('Reporte');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

$logo_ipinnovatech = '/var/www/html/virtualshifts/images/logos/logo_grande.png';
if(file_exists($logo_ipinnovatech)){
    //echo date('H:i:s') . " Add a drawing to the wpngorksheet\n";
    $objDrawing = new PHPExcel_Worksheet_Drawing();
    $objDrawing->setName('Logo');
    $objDrawing->setDescription('Logo');
    $objDrawing->setPath($logo_ipinnovatech);
    $objDrawing->setHeight(70);
    $objDrawing->setWidth(70);
    $objDrawing->setCoordinates('A1');
    $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
}

// Redirect output to a clientÃ¢â‚¬â„¢s web browser (Excel2007)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Reporte_general_virtual_shifts.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;

?>