<?php 

<?php

if (!defined('PDF_ROOT')) {
	define('PDF_ROOT', dirname(__FILE__) . '/');
	require_once(PDF_ROOT.'tcpdf_include.php');
	require_once(PDF_ROOT.'Mypdf.class.php');
}


//============================================================+
// File name   : example_001.php
// Begin       : 2008-03-04
// Last Update : 2013-05-14
//
// Description : Example 001 for TCPDF class
//               Default Header and Footer
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: Default Header and Footer
 * @author Nicola Asuni
 * @since 2008-03-04
 */

// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');
require_once('Mypdf.class.php');

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
/*
 $pdf->SetAuthor('Nicola Asuni');
 $pdf->SetTitle('TCPDF Example 001');
 $pdf->SetSubject('TCPDF Tutorial');
 $pdf->SetKeywords('TCPDF, PDF, example, test, guide');
*/
// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING, array(0,0,0), array(0,0,0));
$pdf->setFooterData(array(0,0,0), array(0,0,0));

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

//$pdf->setHeaderMargin(100);

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);



// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/static/lang/chi.php')) {
	require_once(dirname(__FILE__).'/static/lang/chi.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('stsongstdlight', '', 12);

$pdf->AddPage();
$pdf->setPrintFooter(false);
$true_width = $pdf->getPageTrueWidth();
$true_height = $pdf->getPageTrueHeight();

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();
//$pdf->setPrintFooter(true);
//$img_file = K_PATH_IMAGES.'background.png';
//$pdf->Image($img_file, 0, 0, 300, 422, '', '', '', false, 300, '', false, false, 0);

$pdf->SetTextColor(133,11,203);
$pdf->SetLineStyle(array('color' => array(133,11,203)));
$pdf->setPrintFooter(false);


// set font
$pdf->SetFont('stsongstdlight', '', 40);
$pdf->Cell(0, 0, '审定评估报告', 0, 0, 'C');
$pdf->Ln(20);
$pdf->SetFont('stsongstdlight', '', 30);
$pdf->Cell(0, 0, '文档', 0, 0, 'C');

//var_dump($pdf);exit;

$pdf->SetFont('stsongstdlight', '', 18);

$w = $pdf->GetPdfWidth();

$pdf->Ln(25);

$move_x = 60;
$y = $pdf->GetY()+10;
$finalNum = 45;
$lineX = $move_x+$finalNum;
$margins = $pdf->getMargins();


$pdf->cell($move_x);
$pdf->Cell(5, 12, '姓', 0, 0, 'L');
$pdf->cell(14);
$pdf->Cell(5, 12, '名：', 0, 0, 'L');
$pdf->Line($lineX, $y, $lineX+105, $y);

$pdf->Ln(14);
$pdf->cell($move_x);
$pdf->Cell(5, 12, '籍', 0, 0, 'L');
$pdf->cell(14);
$pdf->Cell(5, 12, '贯：', 0, 0, 'L');
$y += 12;
$pdf->Line($lineX, $y, $lineX+30, $y);
$pdf->cell(38);
$pdf->Cell(10, 12, '年龄：', 0, 0, 'L');
$lineX += 50;
$pdf->Line($lineX, $y, $lineX+10, $y);
$pdf->cell(18);
$pdf->Cell(5, 12, '岁', 0, 0, 'L');
$pdf->cell(5);
$pdf->Cell(10, 12, '性别：', 0, 0, 'L');
$lineX += 40;
$pdf->Line($lineX, $y, $lineX+15, $y);

$pdf->Ln(14);
$pdf->cell($move_x);
$pdf->Cell(10, 12, '送检编号：', 0, 0, 'L');
$y += 14;
$lineX = $move_x+$finalNum;
$pdf->Line($lineX, $y, $lineX+105, $y);

$pdf->Ln(14);
$pdf->cell($move_x);
$pdf->Cell(10, 12, '样本类型：', 0, 0, 'L');
$y += 14;
$pdf->Line($lineX, $y, $lineX+30, $y);
$pdf->cell(50);
$pdf->Cell(10, 12, '标本状态：', 0, 0, 'L');
$lineX += 60;
$pdf->Line($lineX, $y, $lineX+45, $y);

$pdf->Ln(14);
$pdf->cell($move_x);
$pdf->Cell(10, 12, '报告编号：', 0, 0, 'L');
$y += 14;
$lineX = $move_x+$finalNum;
$pdf->Line($lineX, $y, $lineX+105, $y);

$pdf->Ln(14);
$pdf->cell($move_x);
$pdf->Cell(10, 12, '送检时间：', 0, 0, 'L');
$y += 14;
$lineX = $move_x+$finalNum;
$pdf->Line($lineX, $y, $lineX+105, $y);


$pdf->Ln(14);
$pdf->cell($move_x);
$pdf->Cell(10, 12, '报告时间：', 0, 0, 'L');
$y += 14;
$lineX = $move_x+$finalNum;
$pdf->Line($lineX, $y, $lineX+105, $y);

$pdf->AddPage();
$pdf->SetTextColor(0,0,0);
$pdf->SetLineStyle(array('color' => array(0,0,0)));
$pdf->SetFont('stsongstdlight', '', 12);


$source_data = array(
		array(
				'type' => '肺癌热点基因突变检测',
				'jiyi' => array(
						'APC' =>array(
								'res' =>'突变'
						)
				)
		)
);

// var_dump($pdf);exit;
// create some HTML content
$html = '
<table  cellpadding="4">
	<tr>
		<th bgcolor="#7C05A5" color="#F0BF2F"  align="center" style="border-left:1px solid #000;border-top:1px solid #000;" width="130">检测（肿瘤）类型</th>
		<th bgcolor="#7C05A5" color="#F0BF2F"  align="center" style="border-left:1px solid #000;border-top:1px solid #000;" width="80">基因检测</th>
		<th bgcolor="#7C05A5" color="#F0BF2F"  align="center" style="border-left:1px solid #000;border-top:1px solid #000;" width="80">检测结果</th>
		<th bgcolor="#7C05A5" color="#F0BF2F"  align="center" style="border-left:1px solid #000;border-top:1px solid #000;" width="130">风险率%(参考值)</th>
		<th bgcolor="#7C05A5" color="#F0BF2F"  align="center" style="border-left:1px solid #000;border-top:1px solid #000;" width="80">肿瘤风险</th>
		<th bgcolor="#7C05A5" color="#F0BF2F"  align="center" style="border:1px solid #000;" width="445">危险因素与症状</th>
	</tr>

	<tr>
		<td rowspan="21" align="center" vertical-align="middle" color="#850BCB" style="border-top:1px solid #000;vertical-align:middle;">
		<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
		肺 	癌<br/>热点基因突变<br/>检	 测
		</td>
		<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">APC</td>
		<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">无突变</td>
		<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">2.48</td>
		<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">低风险</td>
		<td rowspan="21" align="left" style="border-left:1px solid #000;border-top:1px solid #000;">
		
			<b>一、 肺癌风险因素</b>
			<ol>
			<li>环境：长期吸烟，大气污染，职业因素（如长期接触铀镭等放射性物质）。</li>
			<li>遗传：肿瘤（肺癌）家族遗传。</li>
			<li>其他：日常不健康状态或方式(组织器官
			炎症) 肺部慢性疾病（如肺结核、矽肺、尘
			肺等），人体内在因素（免疫机能降低代谢
			活动、内分泌功能失调等）。</li>
			</ol>
			<b>二、早期症状</b>
			<ol>
			<li>咳嗽、发热。</li>
			<li>痰中带血或咯血。</li>
			<li>胸痛。</li>
			<li>胸闷、气急。</li>
			<li>声音嘶哑。</li>
			</ol>
		</td>
	</tr>


	<tr>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">ARIDIA</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">无突变</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">6.09</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">低风险</td>
	</tr>

	<tr>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">ATM</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">无突变</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">6.50</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">低风险</td>
	</tr>

	<tr>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">BRAF</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">无突变</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">2.60</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">低风险</td>
	</tr>

	<tr>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">BRAF</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">无突变</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">2.60</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;" color="#DA5815">高风险</td>
	</tr>

	<tr>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">ARIDIA</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">无突变</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">6.09</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">低风险</td>
	</tr>

	<tr>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">ATM</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">无突变</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">6.50</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">低风险</td>
	</tr>

	<tr>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">BRAF</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">无突变</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">2.60</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">低风险</td>
	</tr>

	<tr>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">BRAF</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">无突变</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">2.60</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;" color="#DA5815">高风险</td>
	</tr>

	<tr>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">ARIDIA</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">无突变</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">6.09</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">低风险</td>
	</tr>

	<tr>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">ATM</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">无突变</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">6.50</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">低风险</td>
	</tr>

	<tr>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">BRAF</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">无突变</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">2.60</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">低风险</td>
	</tr>

	<tr>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">BRAF</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">无突变</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">2.60</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">低风险</td>
	</tr>

	<tr>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">ARIDIA</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">无突变</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">6.09</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">低风险</td>
	</tr>

	<tr>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">ATM</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">无突变</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">6.50</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">低风险</td>
	</tr>

	<tr>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">BRAF</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">无突变</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">2.60</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">低风险</td>
	</tr>

	<tr>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">BRAF</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">无突变</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">2.60</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">低风险</td>
	</tr>

	<tr>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">ARIDIA</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">无突变</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">6.09</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">低风险</td>
	</tr>

	<tr>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">ATM</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">无突变</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">6.50</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">低风险</td>
	</tr>

	<tr>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">BRAF</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">无突变</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">2.60</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">低风险</td>
	</tr>

	<tr>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">BRAF</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">无突变</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">2.60</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">低风险</td>
	</tr>

	<tr>
		<td align="center" color="#F0BF2F" style="border-top:1px solid #000;border-bottom:1px solid #000;font-size:25px;">总结</td>
		<td colspan="5" align="center" style="border-left:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;">未检出该项以上基因突变，但不代表不存在导致该肿瘤的其他未暴露因素，请保持健康生活方式，避开一切导致该肿瘤风险环境。</td>
	</tr>
</table>';


// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');









//echo dirname(dirname(__FILE__));exit;

$html = '
<table cellpadding="4">
	<tr>
		<th bgcolor="#7C05A5" color="#ECD80B"  align="center" style="border-left:1px solid #000;border-top:1px solid #000;">检测（肿瘤）类型</th>
		<th bgcolor="#7C05A5" color="#ECD80B"  align="center" style="border-left:1px solid #000;border-top:1px solid #000;">基因检测</th>
		<th bgcolor="#7C05A5" color="#ECD80B"  align="center" style="border-left:1px solid #000;border-top:1px solid #000;">检测结果</th>
		<th bgcolor="#7C05A5" color="#ECD80B"  align="center" style="border-left:1px solid #000;border-top:1px solid #000;">风险率%(参考值)</th>
		<th bgcolor="#7C05A5" color="#ECD80B"  align="center" style="border-left:1px solid #000;border-top:1px solid #000;">肿瘤风险</th>
		<th bgcolor="#7C05A5" color="#ECD80B"  align="center" style="border:1px solid #000;">危险因素与症状</th>
	</tr>

	<tr>
		<td rowspan="21" align="center" vertical-align="middle" color="#850BCB" style="border-left:1px solid #000;border-top:1px solid #000;vertical-align:middle;">
		<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
		肝 癌<br/>热点基因突变<br/>检 测
		</td>
		<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">APC</td>
		<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">无突变</td>
		<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">2.48</td>
		<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">低风险</td>
		<td rowspan="21" align="center" style="border-left:1px solid #000;border-top:1px solid #000;border-right:1px solid #000;">
			<b>一、肝癌风险因素</b>
			<ol>
			<li>病毒感染：乙肝病毒（大小三阳）、丙型肝炎、肝硬化、酒精肝。</li>
			<li>生活习惯：酗酒、进食有毒素食物及长期吸收污染物、免疫力低下、恶性亚健康。</li>
			<li>遗传：家族遗传（含隔代遗传）。</li>
			</ol>
			<b>二、 早期症状</b>
			<ol>
			<li>突发肝区及胆区闷痛或剧痛。</li>
			<li>口干，烦躁，失眠，牙龈及鼻腔出血，伴有上腹部胀满，肝区不适者。</li>
			<li>肝脏肿大和消化功能紊乱并伴有不明原因的体重下降。</li>
			</ol>
		</td>
	</tr>


	<tr>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">ARIDIA</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">无突变</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">6.09</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">低风险</td>
	</tr>

	<tr>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">ATM</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">无突变</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">6.50</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">低风险</td>
	</tr>

	<tr>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">BRAF</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">无突变</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">2.60</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">低风险</td>
	</tr>

	<tr>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">BRAF</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">无突变</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">2.60</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;" color="#DA5815">高风险</td>
	</tr>

	<tr>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">ARIDIA</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">无突变</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">6.09</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">低风险</td>
	</tr>

	<tr>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">ATM</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">无突变</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">6.50</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">低风险</td>
	</tr>

	<tr>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">BRAF</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">无突变</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">2.60</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">低风险</td>
	</tr>

	<tr>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">BRAF</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">无突变</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">2.60</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;" color="#DA5815">高风险</td>
	</tr>

	<tr>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">ARIDIA</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">无突变</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">6.09</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">低风险</td>
	</tr>

	<tr>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">ATM</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">无突变</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">6.50</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">低风险</td>
	</tr>

	<tr>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">BRAF</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">无突变</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">2.60</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">低风险</td>
	</tr>

	<tr>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">BRAF</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">无突变</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">2.60</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">低风险</td>
	</tr>

	<tr>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">ARIDIA</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">无突变</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">6.09</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">低风险</td>
	</tr>

	<tr>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">ATM</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">无突变</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">6.50</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">低风险</td>
	</tr>

	<tr>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">BRAF</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">无突变</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">2.60</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">低风险</td>
	</tr>

	<tr>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">BRAF</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">无突变</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">2.60</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">低风险</td>
	</tr>

	<tr>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">ARIDIA</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">无突变</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">6.09</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">低风险</td>
	</tr>

	<tr>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">ATM</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">无突变</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">6.50</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">低风险</td>
	</tr>

	<tr>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">BRAF</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">无突变</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">2.60</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">低风险</td>
	</tr>

	<tr>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">BRAF</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">无突变</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">2.60</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">低风险</td>
	</tr>



	<tr>
		<td align="center" color="#F0BF2F" style="border-left:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;font-size:25px;">
		<b>总结</b>
		</td>
		<td colspan="5" align="center" style="border-left:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;">
		未检出该项以上基因突变，但不代表不存在导致该肿瘤的其他未暴露因素，请保持健康生活方式，避开一切导致该肿瘤风险环境。
		</td>
	</tr>
</table>';

$pdf->writeHTML($html, true, false, true, false, '');


$html = '
<table cellspacing="2" cellpadding="4">
	<tr>
		<th bgcolor="#7C05A5" color="#ECD80B"  align="center" style="border-left:1px solid #000;border-top:1px solid #000;">检测（肿瘤）类型</th>
		<th bgcolor="#7C05A5" color="#ECD80B"  align="center" style="border-left:1px solid #000;border-top:1px solid #000;">基因检测</th>
		<th bgcolor="#7C05A5" color="#ECD80B"  align="center" style="border-left:1px solid #000;border-top:1px solid #000;">检测结果</th>
		<th bgcolor="#7C05A5" color="#ECD80B"  align="center" style="border-left:1px solid #000;border-top:1px solid #000;">风险率%(参考值)</th>
		<th bgcolor="#7C05A5" color="#ECD80B"  align="center" style="border-left:1px solid #000;border-top:1px solid #000;">肿瘤风险</th>
		<th bgcolor="#7C05A5" color="#ECD80B"  align="center" style="border:1px solid #000;">危险因素与症状</th>
	</tr>

	<tr>
		<td rowspan="21" align="center" vertical-align="middle" color="#850BCB" style="border-left:1px solid #000;border-top:1px solid #000;vertical-align:middle;">
		<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
		胰腺癌<br/>热点基因突变<br/>检 测
		</td>
		<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">APC</td>
		<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">无突变</td>
		<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">2.48</td>
		<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">低风险</td>
		<td rowspan="21" align="center"  style="border-left:1px solid #000;border-top:1px solid #000;border-right:1px solid #000;">
			<b>一、胰腺癌风险因素</b>
			<ol>
				<li>生活方式：吸烟、高肉类和脂肪摄入，过量饮酒、咖啡、茶摄入的不当的饮食结构。</li>
				<li>遗传：家族遗传。</li>
				<li> 炎症与相关疾病：慢性胰腺炎、糖尿病等。</li>
			</ol>
			<b>二、早期症状</b>
			<ol>
				<li>上腹部不明原因疼痛。</li>
				<li>体重下降、食欲下降。</li>
				<li>出现黄疸。</li>
			</ol>
		</td>
	</tr>

	<tr>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">ARIDIA</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">无突变</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">6.09</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">低风险</td>
	</tr>

	<tr>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">ATM</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">无突变</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">6.50</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">低风险</td>
	</tr>

	<tr>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">BRAF</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">无突变</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">2.60</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">低风险</td>
	</tr>

	<tr>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">BRAF</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">无突变</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">2.60</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;" color="#DA5815">高风险</td>
	</tr>

	<tr>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">ARIDIA</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">无突变</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">6.09</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">低风险</td>
	</tr>

	<tr>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">ATM</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">无突变</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">6.50</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">低风险</td>
	</tr>

	<tr>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">BRAF</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">无突变</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">2.60</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">低风险</td>
	</tr>

	<tr>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">BRAF</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">无突变</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">2.60</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;" color="#DA5815">高风险</td>
	</tr>

	<tr>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">ARIDIA</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">无突变</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">6.09</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">低风险</td>
	</tr>

	<tr>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">ATM</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">无突变</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">6.50</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">低风险</td>
	</tr>

	<tr>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">BRAF</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">无突变</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">2.60</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">低风险</td>
	</tr>

	<tr>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">BRAF</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">无突变</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">2.60</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">低风险</td>
	</tr>

	<tr>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">ARIDIA</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">无突变</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">6.09</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">低风险</td>
	</tr>

	<tr>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">ATM</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">无突变</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">6.50</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">低风险</td>
	</tr>

	<tr>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">BRAF</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">无突变</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">2.60</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">低风险</td>
	</tr>

	<tr>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">BRAF</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">无突变</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">2.60</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">低风险</td>
	</tr>

	<tr>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">ARIDIA</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">无突变</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">6.09</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">低风险</td>
	</tr>

	<tr>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">ATM</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">无突变</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">6.50</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">低风险</td>
	</tr>

	<tr>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">BRAF</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">无突变</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">2.60</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">低风险</td>
	</tr>

	<tr>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">BRAF</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">无突变</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">2.60</td>
	<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">低风险</td>
	</tr>



	<tr>
		<td align="center" color="#F0BF2F" style="border-left:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;font-size:25px;">
		<b>总结</b>
		</td>
		<td colspan="5" align="center" style="border-left:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;border-right:1px solid #000;">
		未检出该项以上基因突变，但不代表不存在导致该肿瘤的其他未暴露因素，请保持健康生活方式，避开一切导致该肿瘤风险环境。
		</td>
	</tr>
</table>';

$pdf->writeHTML($html, true, false, true, false, '');


$pdf->AddPage();
$pdf->SetFont('stsongstdlight', '', 12);
$html = '
<table cellpadding="4">
	<tr>
		<th colspan="6" align="center" style="border-left:1px solid #000;border-top:1px solid #000;border-right:1px solid #000;">总结报告</th>
	</tr>

	<tr>
		<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">
			基因突变
		</td>
		<td colspan="2" style="border-left:1px solid #000;border-top:1px solid #000;">
			FGFR3 基因突变
		</td>
		<td colspan="3" align="center" style="border-left:1px solid #000;border-top:1px solid #000;border-right:1px solid #000;">
			原癌基因突变
		</td>
	</tr>

	<tr>
		<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">
			病 史
		</td>
		<td colspan="5" style="border-left:1px solid #000;border-top:1px solid #000;border-right:1px solid #000;">无</td>
	</tr>

	<tr>
		<td colspan="4" align="center" style="border-left:1px solid #000;border-top:1px solid #000;">
			突变基因在肿瘤中的发生率
		</td>
		<td  colspan="2" style="border-left:1px solid #000;border-top:1px solid #000;border-right:1px solid #000;">
			癌症发生概率（p）分析方式
		</td>
	</tr>

	<tr>
		<td colspan="4" align="center" style="border-left:1px solid #000;border-top:1px solid #000;">
			<img src="images/zongjie/man/man_FGFR3.jpg" border="0" height="200" width="360" align="middle" />
			<p>
			上图数字对应肿瘤：1 肺癌；2 肝癌；3 胰腺癌；4 胃癌；5 食道癌；6 肾癌；
			7 甲状腺癌；8 结直肠癌；<b>9 膀胱癌</b>；10 黑色素瘤；11 胆管癌；12 淋巴瘤；
			13 脑胶质瘤；14 急性髓性白血病；15 头颈癌；16 前列腺癌；17 胆囊癌；
			18 骨髓增生异常综合征
			</p>
		</td>
		<td  colspan="2" style="border-left:1px solid #000;border-top:1px solid #000;border-right:1px solid #000;">
			癌症发生概率 (p) = 细胞分裂次数 (a) X 每次分裂产生
			突变数目 (b) X 突变基因致癌基因概率 (e)
			1、（e） 每个人都一样；<br/>
			2、（a）影响因素：年龄，年龄越大细胞分裂次数越多。
			炎症：器官受损越多，导致细胞分裂越多；不良习惯：
			暴晒、抽烟、吃刺激性食物导致细胞分裂次数增多；病
			毒感染：损坏对应组织器官；环境：空气污染、放射性
			物质污染等；<br/>
			3、（b）、携带相关突变基因人群每次细胞分裂产生的
			突变量比正常人高近百倍
		</td>
	</tr>

	<tr>
		<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">
			<b>发生率数据来源</b>
		</td>
		<td colspan="5" style="border-left:1px solid #000;border-top:1px solid #000;border-right:1px solid #000;">
			国际COSMIC 数据库，突变基因及位点信息为国际公认检测信息。
		</td>
	</tr>

	<tr>
		<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">
			<b>建议与解释</b>
		</td>
		<td colspan="5" style="border-left:1px solid #000;border-top:1px solid #000;border-right:1px solid #000;">
			1、 本报告的检测结果只对本次送检的样本负责；<br/>
			2、 本检测针对高危肿瘤人群外周血肿瘤基因突变检测，预测或评估肿瘤风险；<br/>
			3、 本检测可针对家族遗传风险、环境因素风险、炎症关联风险的任何高危肿瘤人群进行检测，但鉴于当前医学检测技
			术水平的限制和高危人群个体间的差异等不同原因，即使在检测人员已经履行工作职责和操作规程的前提下，仍有
			可能出现假阳性与假阴性，在特异性、敏感性无法达到100%时，假阴性与假阳性在检测技术上是客观存在的，也
			是行业标准许可的。<br/>
			4、 本检测结果不能作为最终的诊断结果，如检测结果为高风险，需要进一步或择时进一步按照本报告“肿瘤防治路径
			指南图”接受肿瘤防治，消除肿瘤基因突变或高危因素的清除(如病毒感染、恶性亚健康等)，如检测结果为低风险，
			则说明受检人患本筛查目标疾病（肿瘤）的风险很低，不排除其他异常情况的可能性，以及相关性，特别是不排除
			高风险肿瘤恶化后转移的目标区域，应该及时深度排查该组织或器官是否存在炎症或其他相关疾病。<br/>
			5、 受检者应该提供完整、准确、详细的个人资料。因受检者提供的资料不实或其他误导因素导致检测服务的中断、结
			果不准确检测单位概不负责。<br/>
			6、 检测报告由受检人或单位或授权人凭回单领取，VIP 客户可在指定网站凭VIP 卡号，个人信息与给予的唯一编码信
			息可查询到本人检测报告。<br/><br/>
			<h2>特别提醒：您是 <u>膀胱癌</u> 高风险，请您及时按照防治路径指南减除肿瘤高危风险。</h2><br/><br/>
			<h1>美好人生、美好家庭拒绝肿瘤，追求健康、喜乐、优雅人生！</h1><br/>
		</td>
	</tr>



	<tr>
		<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;"><b>送检单位</b></td>
		<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;" ></td>
		<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;"><b>采样单位</b></td>
		<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;">市二院</td>
		<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;"><b>检测部门</b></td>
		<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;border-right:1px solid #000;">深圳重大疾病公共技术服务平台&双科国际中心</td>
	</tr>

	<tr>
		<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;"><b>检测方法</b></td>
		<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;">PCR&TOF-MS</td>
		<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;"><b>检测人</b></td>
		<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;">黄建林</td>
		<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000;"><b>审核人(盖章)</b></td>
		<td align="center" style="border-left:1px solid #000;border-top:1px solid #000;border-right:1px solid #000;border-bottom:1px solid #000;">欧阳政德</td>
	</tr>

</table>';

$pdf->writeHTML($html, true, false, true, false, '');


$pdf->AddPage();

$style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => '10,20,5,10', 'phase' => 10, 'color' => array(255, 0, 0));
$style2 = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(255, 0, 0));
$style3 = array('width' => 1, 'cap' => 'round', 'join' => 'round', 'dash' => '2,10', 'color' => array(255, 0, 0));
$style4 = array('L' => 0,
		'T' => array('width' => 0.25, 'cap' => 'butt', 'join' => 'miter', 'dash' => '20,10', 'phase' => 10, 'color' => array(100, 100, 255)),
		'R' => array('width' => 0.50, 'cap' => 'round', 'join' => 'miter', 'dash' => 0, 'color' => array(50, 50, 127)),
		'B' => array('width' => 0.75, 'cap' => 'square', 'join' => 'miter', 'dash' => '30,10,5,10'));
$style5 = array('width' => 0.25, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(0, 64, 128));
$style6 = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => '10,10', 'color' => array(0, 128, 0));
$style7 = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(255, 128, 0));


$pdf->SetTextColor(150,125,187);
$pdf->SetFont('stsongstdlight', '', 20);
$pdf->Cell(0, 0, '防治路径指南图', 0, 0, 'L');
$pdf->Ln(20);

$pdf->SetFont('stsongstdlight', '', 12);
$pdf->SetTextColor(0,0,0);

$img_file = K_PATH_IMAGES.'fangzhilujing.jpg';
//$pdf->Image($img_file, 15, 50, 270, 180, '', '', '', false, 300, '', false, false, 0);
$pdf->Image($img_file, 15, '', 220, 120, '', '', '', false, 300, '', false, false, 0, false, false, false);



$pdf->AddPage();

$pdf->SetFont('stsongstdlight', '', 20);
$pdf->Cell('', '', '给您的一封信', 0, 0, 'C');
$pdf->Ln();
$pdf->SetFont('stsongstdlight', 'b', 14);
$pdf->Cell(15,10, '尊敬的  ', 0, 0, 'L');
$pdf->Cell(15,10, '____先生', 0, 0, 'L');
$pdf->Ln();
$pdf->SetFont('stsongstdlight', '', 12);
$html = '<p ><span>&nbsp;&nbsp;</span>祝贺您！您已成为我国防治肿瘤事业的一名新卫士，“传递健康，就是一种爱”，健康是一切情感天长地久，财富可持续增长的基
石，让身边的人远离癌症，远离疾病是我们应尽的一种职责。<br/>
<span style="font-weight: bold;">一、健康是生命中最宝贵不可再生的财富，但：</span>
<br/><span>&nbsp;&nbsp;</span> a) 2014 年《中国肿瘤登记年报》指出中国每分钟有大于6.4 人被诊断为肿瘤，意味着平均每个人有22%的发生率；
<br/><span>&nbsp;&nbsp;</span> b) 如今，深圳、北京每天分别有43 人、110 人被诊断为恶性肿瘤，每年还以大于15%的速度增长；
<br/><span>&nbsp;&nbsp;</span> c) HBV 阳性率高达10%，妇女HPV 阳性率高达15.82%，亚健康人群占总人口的75%，这些我们并没有有效控制；
<br/><span>&nbsp;&nbsp;</span> d) 雾霾、地沟油、放射污染、农残、黄曲霉素等等，无时不刻不再侵害我们的每一个细胞，诱发癌基因突变。
<br/><span style="font-weight: bold;">二、每个人都存在肿瘤风险</span><br/>
<span>&nbsp;&nbsp;</span>正常人每天产生的肿瘤细胞会被巨噬细胞吞噬，才得以安然无恙，所以肿瘤不是一种病，而是一种身体机制，它只在人体防御系统失
效时，才会发生“叛变”。一旦因遗传、辐射、炎症、污染等诱导肿瘤基因突变，癌症就悄然来临，这就是日常生活中的恶性肿瘤。
<br/><span style="font-weight: bold;">三、预测肿瘤风险，检测肿瘤基因突变</span><br/>
<span>&nbsp;&nbsp;</span>癌细胞在破裂和死亡时会释放出循环肿瘤DNA（Ct-DNA）片段，一旦发生突变，增殖加速，巨噬细胞吞噬不了，基因组片段越来越多
引发癌细胞“叛变”。抽取受检人外周血（5ml），通过PCR& MALDI-TOF MS 技术系统实施肿瘤相关基因突变检测，评估肿瘤风险。
<br/><span style="font-weight: bold;">四、检测肿瘤基因突变在肿瘤防治中的意义</span><br/>
<span>&nbsp;&nbsp;</span> <span>意义：1、肿瘤的早期筛查；2、肿瘤治疗方案确定；3、肿瘤疗效观察；4、肿瘤预后评估；5、肿瘤转移风险分析；6、肿瘤复发监测。
该技术系统将颠覆癌症治疗，实现肿瘤早防早治，消除威胁。</span>
</p>

<p style="text-align:right;">
深圳市重大疾病体外诊断公共技术服务平台<br/>
双科国际（深圳）肿瘤防治中心<span>&nbsp;&nbsp;</span>
<p>
';
$pdf->writeHTML($html, true, false, true, false, '');


// $html = '<h4>防治路径指南图</h4>';
// $html .= '<image src="images/logo_example.png" width="100" height="100" border="0" />';
// $pdf->writeHTML($html, true, false, true, false, '');
// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$filename = dirname(dirname(__FILE__)).'/example_001.pdf';
$pdf->Output('example_001.pdf', 'I');




//============================================================+
// END OF FILE
//============================================================+


?>