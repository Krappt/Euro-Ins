<?php

	include('../wp-load.php');
	if ($_POST['totalHumans'] == '') { die('Hacking attempt!'); }

	require('policy_config.php');
	require('policy_db.php');

	if ($GeneratePDF) {
		ini_set('memory_limit', '64M');
	}

	if ($Debug) {
		ShowPOST();
	}

	// ����� � ���� � ��������� � ������
	SavePolicy();
	LoadPolicy();

	if ($Debug) {
		ShowPolicy();
	}

	if ($GoToVPC) {
		// �������� ��������� �������
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
