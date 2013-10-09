<?php

	function WriteXLS() {
		global $Policy, $PolicyNo, $PolicyType;

		$FileType = 'Excel5';
		$FileName = dirname(__FILE__) . '/' . $PolicyType . '/policy.xls';
		
		set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__FILE__) . '/../includes/PHPExcel/');
		require(dirname(__FILE__) . '/' . $PolicyType . '/data_xls.php');
		require_once(dirname(__FILE__) . '/../includes/PHPExcel/IOFactory.php');
		
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
			$objWorksheet->setTitle('TDSheet');
			
			$styleArray = array('font' => array('bold' => true));
			
			for ($Col = 0; $Col < count($xlsColumns); $Col++) {
				$CellValue = $xlsColumns[$Col];
				$objWorksheet->setCellValueByColumnAndRow($Col, $highestRow, $CellValue);
				$Cell = PHPExcel_Cell::stringFromColumnIndex($Col) . $highestRow;
				$objWorksheet->getStyle($Cell)->applyFromArray($styleArray);
			}
		}
		
		$newRow = $highestRow + 1;

		// Set row heights
		for ($Row = 1; $Row <= $newRow; $Row++) {
			$objWorksheet->getRowDimension($Row)->setRowHeight(-1); // auto-size on row
		}

		$xlsData = getData();
		for ($Col = 0; $Col < count($xlsData); $Col++) {
			// Set style
			// http://www.web-junior.net/chasto-zadavaemye-voprosy-po-phpexcel/
			$Cell = PHPExcel_Cell::stringFromColumnIndex($Col) . $newRow;
			$objWorksheet->getStyle($Cell)->getAlignment()->setWrapText(true);

			// Write data
			$objWorksheet->setCellValueByColumnAndRow($Col, $newRow, $xlsData[$Col]);

			// Set column widths
			$Name = PHPExcel_Cell::stringFromColumnIndex($Col);
			$objWorksheet->getColumnDimension($Name)->setAutoSize(true);
		}

		$objWorksheet->calculateColumnWidths();

		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, $FileType);
		$objWriter->save($FileName);
	}
?>
