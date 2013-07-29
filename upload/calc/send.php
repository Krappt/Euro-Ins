<?php

	include('../wp-load.php');

	include('policy_config.php');
	include('policy_db.php');

	$PolicyID = $_GET["ID"];
	LoadPolicy();


	if (($Policy['vpc_BatchNo'] != '') and ($GeneratePDF)) {
		include('policy_pdf.php');
	} else {
		echo 'Полис не оплачен!';
	}

?>
