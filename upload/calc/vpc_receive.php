<?php

	require_once(dirname(__FILE__) . '/../wp-load.php');

	require(dirname(__FILE__) . '/config.php');
	require(dirname(__FILE__) . '/debug.php');
	require(dirname(__FILE__) . '/vpc.php');

	if ($Debug) {
		ShowPOST();
		ShowGET();
	}

	function ProcessVPC($policy_type = 'health', $policy_mask = "ВЗР%06dИ") {
		global $Debug, $PolicyID, $PolicyTable, $PolicyMask;

		// http://stackoverflow.com/questions/9096470/atomically-appending-a-line-to-a-file-and-creating-it-if-it-doesnt-exist
		file_put_contents(dirname(__FILE__) . '/vpc.log', print_r($_GET, true), FILE_APPEND | LOCK_EX);

		$PolicyType = $policy_type;
		$PolicyMask = $policy_mask;

		if (VerifyResponse()) {
			Clear3D();
			
			$PolicyID = $_GET["vpc_MerchTxnRef"];
			if (SaveVPC()) {
				LoadPolicy();

				require(dirname(__FILE__) . '/done.php');
				GeneratePolicy();
			}
		}
	}

?>
