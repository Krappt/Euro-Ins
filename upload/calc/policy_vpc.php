<?php

	global $Policy, $PolicyID, $PolicyNo, $Debug;

	$Data = array();
    $Data["vpc_Version"] = "1"; // VPC Version
    $Data["vpc_Command"] = "pay"; // Command Type
    $Data["vpc_Locale"] = "RU_ru"; // Payment Server Display Language Locale
    $Data["vpc_AccessCode"] = "08414424"; // Merchant AccessCode
    $Data["vpc_Merchant"] = "9293686770"; // MerchantID
    $Data["vpc_MerchTxnRef"] = $PolicyID; // Merchant Transaction Reference
    $Data["vpc_OrderInfo"] = $PolicyID; // Transaction OrderInfo
    $Data["vpc_Amount"] = $Policy["cost"] * 100; // Purchase Amount
    $Data["vpc_ReturnURL"] = "http://www.euro-ins.ru/calc/policy_done.php"; // Receipt ReturnURL

	if ($Debug) {
		echo "<pre>";
		print_r($Data);
		echo "</pre>";
	}

	// This is secret for encoding the MD5 hash. This secret will vary from merchant to merchant
	$SECURE_SECRET = "FC4813131480ACBAE05D27AC1B6D3817";

	// Virtual Payment Client URL and the start of the vpcURL querystring parameters
	$vpcURL = "https://migs.mastercard.com.au/vpcpay" . "?";

	// Create the request to the Virtual Payment Client which is a URL encoded GET request
	$md5HashData = $SECURE_SECRET;
	ksort ($Data);

	// set a parameter to show the first pair in the URL
	$appendAmp = 0;
	foreach($Data as $key => $value) {
	    // create the md5 input and URL leaving out any fields that have no value
    	if (strlen($value) > 0) {
	        // this ensures the first paramter of the URL is preceded by the '?' char
    	    if ($appendAmp == 0) {
        	    $vpcURL .= urlencode($key) . '=' . urlencode($value);
            	$appendAmp = 1;
	        } else {
    	        $vpcURL .= '&' . urlencode($key) . "=" . urlencode($value);
        	}
        	$md5HashData .= $value;
    	}
	}

	// Create the secure hash and append it to the Virtual Payment Client Data
	if (strlen($SECURE_SECRET) > 0) {
	    $vpcURL .= "&vpc_SecureHash=" . strtoupper(md5($md5HashData));
	}

	// FINISH TRANSACTION - Redirect the customers using the Digital Order
	header("Location: ".$vpcURL);

?>
