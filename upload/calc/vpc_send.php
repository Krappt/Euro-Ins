<?php

	require(dirname(__FILE__) . '/vpc.php');

	function SendVPC($AmountField) {
		global $Policy, $vpc_Data, $PolicyType;
		
	    $vpc_Data["vpc_Amount"] = $Policy[$AmountField] * 100; // Purchase Amount
	    $vpc_Data["vpc_ReturnURL"] = "http://" . $_SERVER["SERVER_NAME"] . "/calc/" . $PolicyType . "/reply.php"; // Receipt ReturnURL

		// FINISH TRANSACTION - Redirect the customers using the Digital Order
		header("Location: " . CreateRequest());
	}

?>
