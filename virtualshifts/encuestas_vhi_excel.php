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
require_once("clases/PHPExcel.php");
include_once("clases/gui.class.php");
include_once("clases/encuestas.class.php");
include_once("clases/clientes.class.php");

$objCliente = new Clientes();
$objEncuestas = new Encuestas();

$fecha_inicial = isset($_POST['fecha_inicial'])?$_POST['fecha_inicial']:date("Y-m-d");
$fecha_final = isset($_POST['fecha_final'])?$_POST['fecha_final']:date("Y-m-d");

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
            ->mergeCells('F2:F3')
            ->mergeCells('C4:F4')
            ->mergeCells('A5:K5')
            ->mergeCells('A5:K5')
            ->mergeCells('G1:K4')
           
            ->setCellValue('C1', 'FECHA REPORTE')
            ->setCellValue('D1', 'CANTIDAD DE REGISTROS OBTENIDOS')
            ->setCellValue('E1', 'PREGUNTA 1')
            ->setCellValue('F1', 'PREGUNTA 2')
            ->setCellValue('B6', 'Reporte Encuestas entre el '.$fecha_inicial.' y el '.$fecha_final)
            ->setCellValue('C2', date("Y-m-d H:i:s"))
            ->setCellValue('E2', utf8_encode('Indíquenos su grado de satisfacción con el servicio brindado.'))
            ->setCellValue('F2', 'Su solicitud fue resuelta.');

// Set thin white border outline around column
$styleThinWhiteBorderOutline = array(
	'borders' => array(
		'outline' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
			'color' => array('argb' => 'FFFFFFFF'),
		),
	),
);

$objPHPExcel->getActiveSheet()->getStyle('A5:J5')->applyFromArray($styleThinWhiteBorderOutline);
$objPHPExcel->getActiveSheet()->getStyle('C4:F4')->applyFromArray($styleThinWhiteBorderOutline);

// Set thin black border outline around column
$styleThinBlackBorderOutline = array(
	'borders' => array(
		'outline' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
			'color' => array('argb' => 'FF000000'),
		),
	),
);

$reporte = $objEncuestas->get_encuestas($fecha_inicial, $fecha_final, 1);

$objPHPExcel->setActiveSheetIndex(0);

//$objPHPExcel->getActiveSheet()->getStyle('B8')->applyFromArray($styleThinBlackBorderOutline);
//$objPHPExcel->getActiveSheet()->getStyle('W8')->applyFromArray($styleThinBlackBorderOutline);

$objPHPExcel->getActiveSheet()->getStyle('B7:K7')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('B7:K7')->getFont()->setColor( new PHPExcel_Style_Color( PHPExcel_Style_Color::COLOR_WHITE ) );

//$objPHPExcel->getActiveSheet()->getStyle('B8')->getFont()->setBold(true);
//$objPHPExcel->getActiveSheet()->getStyle('B8')->getFont()->setBold(true);

$objPHPExcel->getActiveSheet()->getStyle('B7:K7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    
$n = 8;
$contador = 1;
$resp1;
$resp2;
$cert;
$cert_ant;
$comp;
$cert_ing_ret;
$aportes;
$nombre;

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B7', 'FECHA');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C7', utf8_encode('CÉDULA'));
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D7', 'NOMBRE');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E7', 'EMPRESA');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F7', 'REGIONAL');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G7', 'PREGUNTA 1');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H7', 'PREGUNTA 2');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I7', 'CERTIFICADO ACTUAL');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J7', 'COMPROBANTE DE PAGO');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K7', utf8_encode('CERTIFICADOS AÑO ANTERIOR'));
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L7', 'CERTIFICADO DE INGRESOS Y RETENCIONES');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M7', 'APORTES');
    
foreach($reporte as $key => $dato){
    if($dato['EVHI_PREG_ID'] == 2){
        $resp1 = $dato['EVHI_RESP'];
    }else{
        if($dato['EVHI_RESP'] == 1){
            $resp2 = 'NO';
        }else if($dato['EVHI_RESP'] == 2){
            $resp2 = 'SI';
        }else{
            $resp2 = '';
        }
        
        $cert = substr_count($dato['EVHI_ACTIVIDADES'] , 'Certificado Actual');
        $cert_ant = substr_count($dato['EVHI_ACTIVIDADES'] , 'Certificados años anteriores');
        $comp = substr_count($dato['EVHI_ACTIVIDADES'] , 'Comprobante de pago');
        $cert_ing_ret = substr_count($dato['EVHI_ACTIVIDADES'] , 'Certificados de ingresos y retenciones');
        $aportes = substr_count($dato['EVHI_ACTIVIDADES'] , 'Aportes');
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$n, $dato['EVHI_FECHA_CREACION']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$n, $dato['EVHI_CEDULA_USUARIO']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$n, utf8_encode($dato['EVHI_NOMBRE_USUARIO']));
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$n, $dato['EVHI_EMPRESA']);
        //$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$n, $nombre);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$n, $dato['EVHI_REGIONAL']);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$n, $resp1);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$n, $resp2);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$n, $cert);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$n, $comp);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$n, $cert_ant);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$n, $cert_ing_ret);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$n, $aportes);
        $n++;
    }
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
    
    $objPHPExcel->getActiveSheet()->getStyle('B'.$n.':M'.$n)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);   
}

$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D2', ($n-8));

$objPHPExcel->setActiveSheetIndex(0)->mergeCells('B6:K6');

$objPHPExcel->getActiveSheet()->getStyle('C1:F1')->applyFromArray($styleThinBlackBorderOutline);
$objPHPExcel->getActiveSheet()->getStyle('C2:F3')->applyFromArray($styleThinBlackBorderOutline);
$objPHPExcel->getActiveSheet()->getStyle('B8:M'.($n-1))->applyFromArray($styleThinBlackBorderOutline);
$objPHPExcel->getActiveSheet()->getStyle('B6:M6')->applyFromArray($styleThinBlackBorderOutline);
$objPHPExcel->getActiveSheet()->getStyle('A1:M5')->applyFromArray($styleThinBlackBorderOutline);
$objPHPExcel->getActiveSheet()->getStyle('B7:M7')->applyFromArray($styleThinBlackBorderOutline);
//$objPHPExcel->getActiveSheet()->getStyle('B8')->applyFromArray($styleThinBlackBorderOutline);

// Set fills
$objPHPExcel->getActiveSheet()->getStyle('C1:F1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('C1:F1')->getFill()->getStartColor()->setARGB('FF333399');
$objPHPExcel->getActiveSheet()->getStyle('B6:M6')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('B6:M6')->getFill()->getStartColor()->setARGB('FF333399');
$objPHPExcel->getActiveSheet()->getStyle('B7:M7')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('B7:M7')->getFill()->getStartColor()->setARGB('FF333399');

// Set fonts
$objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setColor( new PHPExcel_Style_Color( PHPExcel_Style_Color::COLOR_WHITE ) );
$objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('D1')->getFont()->setColor( new PHPExcel_Style_Color( PHPExcel_Style_Color::COLOR_WHITE ) );
$objPHPExcel->getActiveSheet()->getStyle('E1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('E1')->getFont()->setColor( new PHPExcel_Style_Color( PHPExcel_Style_Color::COLOR_WHITE ) );
$objPHPExcel->getActiveSheet()->getStyle('F1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('F1')->getFont()->setColor( new PHPExcel_Style_Color( PHPExcel_Style_Color::COLOR_WHITE ) );
$objPHPExcel->getActiveSheet()->getStyle('B6')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('B6')->getFont()->setColor( new PHPExcel_Style_Color( PHPExcel_Style_Color::COLOR_WHITE ) );
//$objPHPExcel->getActiveSheet()->getStyle('B8')->getFont()->setBold(true);

// Set column widths
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
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

// Set alignments
$objPHPExcel->getActiveSheet()->getStyle('C1:M2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('C1:M2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
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