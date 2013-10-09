<?php

	$xlsColumns = array('Продавец', 'Серия, № полиса');

	function getData() {
		global $Policy, $PolicyNo;

		$arrData = array(
			$Policy['PID'],
			$PolicyNo
		);
		
		return $arrData;
	}
?>
