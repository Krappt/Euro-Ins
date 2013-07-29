<?php
	global $Policy, $PolicyNo;

	$FileType = 'Excel5';
	$FileName = 'policy.xls';
	$Columns = array('Продавец', 'Серия, № полиса', 'Страна', 'Программа', 'Страхователь', 'Дата рождения', 'Застрахованные лица', 'Дата рождения', 'Застраховано чел.', 'Срок с', 'Срок по', 'Кол-во дней', 'Особые условия', 'Премия (у.е.)', 'Оформлен', 'Валюта', 'Курс', 'Страховая Сумма (у.е.)', 'Сумма (руб)', 'Премия (руб)', 'Адрес Страхователя', 'Электронная почта', 'Телефон Страхователя', 'Спорт');

	set_include_path(get_include_path() . PATH_SEPARATOR . '../includes/PHPExcel/');
	include_once '../includes/PHPExcel/IOFactory.php';
	
	$locale = 'ru';
	$validLocale = PHPExcel_Settings::setLocale($locale);
	if (!$validLocale) {
	  echo 'Unable to set locale to '.$locale." - reverting to en_us<br />".PHP_EOL;
	}
	
	if (file_exists($FileName)) {
		/**  Identify the type of $FileName  **/
		// $FileType = PHPExcel_IOFactory::identify($FileName);
		/**  Create a new Reader of the type defined in $FileType  **/
		$objReader = PHPExcel_IOFactory::createReader($FileType);
		/**  Advise the Reader that we only want to load cell data  **/
		// $objReader->setReadDataOnly(true);
		/**  Load $FileName to a PHPExcel Object  **/
		$objPHPExcel = $objReader->load($FileName);
	} else {
		$objPHPExcel = new PHPExcel();
	}
	
	$objPHPExcel->setActiveSheetIndex(0);
	$objWorksheet = $objPHPExcel->getActiveSheet(); // $objPHPExcel->getSheet(0);
	$highestRow = $objWorksheet->getHighestRow(); // e.g. 10
	
	if ($highestRow == 1) {
		global $Columns;
		
		$objWorksheet->setTitle('TDSheet');
		
		$styleArray = array('font' => array('bold' => true));
		
		for ($Col = 0; $Col < count($Columns); $Col++) {
			$CellValue = $Columns[$Col];
			$objWorksheet->setCellValueByColumnAndRow($Col, $highestRow, $CellValue);
			$Cell = PHPExcel_Cell::stringFromColumnIndex($Col) . $highestRow;
			$objWorksheet->getStyle($Cell)->applyFromArray($styleArray);
		}
	}
	
	$newRow = $highestRow + 1;

	// http://www.web-junior.net/chasto-zadavaemye-voprosy-po-phpexcel/
	function SetStyle($Col, $Row) {
		global $objWorksheet;
		
		$Cell = PHPExcel_Cell::stringFromColumnIndex($Col) . $Row;
		$objWorksheet->getStyle($Cell)->getAlignment()->setWrapText(true);
	}

	function SetAutoSize() {
		global $objWorksheet, $Columns, $newRow;
		
		for ($Row = 1; $Row <= $newRow; $Row++) {
			$objWorksheet->getRowDimension($Row)->setRowHeight(-1); // auto-size on row
		}
		for ($Col = 0; $Col < count($Columns); $Col++) {
			$Name = PHPExcel_Cell::stringFromColumnIndex($Col);
			$objWorksheet->getColumnDimension($Name)->setAutoSize(true);
		}
		$objWorksheet->calculateColumnWidths();
	}

	$objWorksheet->setCellValueByColumnAndRow( 0, $newRow, $Policy['PID']);
	$objWorksheet->setCellValueByColumnAndRow( 1, $newRow, $PolicyNo);
	$objWorksheet->setCellValueByColumnAndRow( 2, $newRow, $Policy['country_0']);
	$objWorksheet->setCellValueByColumnAndRow( 3, $newRow, "1"); 
	$objWorksheet->setCellValueByColumnAndRow( 4, $newRow, $Policy['insured_name']);
	$objWorksheet->setCellValueByColumnAndRow( 5, $newRow, $Policy['birthday_0']);
	SetStyle( 6, $newRow);
		$Names = '';
		for ($No = 0; $No <= ($Policy['totalHumans'] - 1); $No++) {
			$Names = $Names . (($Names <> '')?PHP_EOL:"") . $Policy['last_name_'.$No] . ' ' . $Policy['first_name_'.$No];
		}
	$objWorksheet->setCellValueByColumnAndRow( 6, $newRow, $Names);
	SetStyle( 7, $newRow);
		$BirthDays = '';
		for ($No = 0; $No <= ($Policy['totalHumans'] - 1); $No++) {
			$BirthDays = $BirthDays . (($BirthDays <> '')?PHP_EOL:"") . $Policy['birthday_'.$No];
		}
	$objWorksheet->setCellValueByColumnAndRow( 7, $newRow, $BirthDays);
	$objWorksheet->setCellValueByColumnAndRow( 8, $newRow, $Policy['totalHumans']);
	$objWorksheet->setCellValueByColumnAndRow( 9, $newRow, $Policy['date_in']);
	$objWorksheet->setCellValueByColumnAndRow(10, $newRow, $Policy['date_out']);
	$objWorksheet->setCellValueByColumnAndRow(11, $newRow, $Policy['totalDays']);
	$objWorksheet->setCellValueByColumnAndRow(12, $newRow, $Policy['program']);
	$objWorksheet->setCellValueByColumnAndRow(13, $newRow, sprintf("%08.2f", ($Policy['cost'] / $Policy['rate']))); // Премия (у.е.)
	$objWorksheet->setCellValueByColumnAndRow(14, $newRow, date('d.m.Y', strtotime($Policy['Date'])));
	$objWorksheet->setCellValueByColumnAndRow(15, $newRow, substr($Policy['summa_0'], -3, 3)); // Валюта
	$objWorksheet->setCellValueByColumnAndRow(16, $newRow, sprintf("%08.4f", $Policy['rate'])); // Курс
	SetStyle(17, $newRow);
		$Sum = substr(str_replace(' ', '', $Policy['summa_0']), 0, -3);
	$objWorksheet->setCellValueByColumnAndRow(17, $newRow, $Sum); // СтраховаяСумма(у.е.)
	$objWorksheet->setCellValueByColumnAndRow(18, $newRow, sprintf("%08.2f", ($Policy['rate'] * $Sum))); // Сумма (руб)
	$objWorksheet->setCellValueByColumnAndRow(19, $newRow, $Policy['cost']); // Премия (руб)
	$objWorksheet->setCellValueByColumnAndRow(20, $newRow, $Policy['address']);
	$objWorksheet->setCellValueByColumnAndRow(21, $newRow, $Policy['e-mail']);
	$objWorksheet->setCellValueByColumnAndRow(22, $newRow, $Policy['phone']);
	SetStyle(23, $newRow);
		$RiskNames = '';
		for ($No = 0; $No <= ($Policy['totalHumans'] - 1); $No++) {
			if ($Policy['risk_'.$No] <> 'Без дополнительных рисков') {
				$RiskNames = $RiskNames . (($RiskNames <> '')?PHP_EOL:"") . $Policy['last_name_'.$No] . ' ' . $Policy['first_name_'.$No];
			}
		}
	$objWorksheet->setCellValueByColumnAndRow(23, $newRow, $RiskNames);
	
	SetAutoSize();
	
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $FileType);
	$objWriter->save($FileName);

?>
