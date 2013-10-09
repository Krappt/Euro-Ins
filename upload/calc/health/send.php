<?php

	require_once(dirname(__FILE__) . '/../../wp-load.php');

	require(dirname(__FILE__) . '/../config.php');
	require(dirname(__FILE__) . '/../data.php');

	$PolicyID = $_GET["ID"];
	$PolicyType = 'health';
	$PolicyMask = "ВЗР%06dИ";

	LoadPolicy();

	if (($Policy['vpc_BatchNo'] != '') and ($GeneratePDF)) {
		require(dirname(__FILE__) . '/../save_pdf.php');
		WritePDF();
	} else {
		echo 'Полис не оплачен!';
	}

?>
