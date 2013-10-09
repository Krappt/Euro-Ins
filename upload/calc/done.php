<?php

	function GeneratePolicy() {
		global $GeneratePDF, $GenerateXLS;

		if ($GenerateXLS) {
			require(dirname(__FILE__) . '/save_xls.php');
			WriteXLS();
		}

		if ($GeneratePDF) {
			require(dirname(__FILE__) . '/save_pdf.php');
			WritePDF();
		}
	}

?>
