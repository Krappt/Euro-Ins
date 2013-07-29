<?php

	define('IN_SUBDREAMER', true);
	include('../includes/core.php');
	if ($_POST['totalHumans'] == '') { die('Hacking attempt!'); }

	include('policy_config.php');

	if ($GeneratePDF) {
		ini_set('memory_limit', '64M');
	}

	if ($Debug) {
		ShowPOST();
	}

	// Пишем в базу и загружаем в массив
	include('policy_db.php');
	SavePolicy();
	LoadPolicy();

	if ($Debug) {
		ShowPolicy();
	}

	if ($GoToVPC) {
		// Вызываем платежную систему
		include('policy_vpc.php');
	} else {
		if ($GenerateXLS) {
			include('policy_xls.php');
		}

		if ($GeneratePDF) {
			include('policy_pdf.php');
		}
	}
?>
