<?php

	require_once(dirname(__FILE__) . '/../wp-load.php');

	require(dirname(__FILE__) . '/config.php');
	require(dirname(__FILE__) . '/debug.php');
	require(dirname(__FILE__) . '/data.php');

	if ($Debug) {
		ShowPOST();
		ShowGET();
	}

	function ProcessPolicy($policy_type = 'health', $policy_mask = "ВЗР%06dИ", $amount_field = 'cost') {
		global $Debug, $PolicyType, $PolicyMask, $GoToVPC;

		$PolicyType = $policy_type;
		$PolicyMask = $policy_mask;

		// Пишем в базу и загружаем в массив
		SavePolicy();
		LoadPolicy();

		if ($Debug) {
			ShowPolicy();
		}

		if ($GoToVPC) {
			// Вызываем платежную систему
			require(dirname(__FILE__) . '/vpc_send.php');
			SendVPC($amount_field);
		} else {
			require(dirname(__FILE__) . '/done.php');
			GeneratePolicy();
		}
	}

?>
