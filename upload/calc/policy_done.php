<?php

	include('../wp-load.php');

	include('policy_config.php');
	include('policy_db.php');

	if ($Debug) {
		ShowGET();
	}

	// http://stackoverflow.com/questions/9096470/atomically-appending-a-line-to-a-file-and-creating-it-if-it-doesnt-exist
	file_put_contents(dirname(__FILE__) . '/vpc.log', print_r($_GET, true), FILE_APPEND | LOCK_EX);

	if (VerifyResponse()) {
		Clear3D();
		
		$PolicyID = $_GET["vpc_MerchTxnRef"];
		if (SaveVPC()) {
			LoadPolicy();

			if ($GenerateXLS) {
				include('policy_xls.php');
			}

			if ($GeneratePDF) {
				include('policy_pdf.php');
			}
		}
	}


	function VerifyResponse() {
		// This is secret for encoding the MD5 hash. This secret will vary from merchant to merchant
		$SECURE_SECRET = "FC4813131480ACBAE05D27AC1B6D3817";

		// set a flag to indicate if hash has been validated
		$errorExists = false;
		$errorTxt = "";

		if ($_GET["vpc_TxnResponseCode"] != "7" && $_GET["vpc_TxnResponseCode"] != "No Value Returned") {
		    $md5HashData = $SECURE_SECRET;

		    // sort all the incoming vpc response fields and leave out any with no value
		    foreach($_GET as $key => $value) {
		        if ($key != "vpc_SecureHash" and strlen($value) > 0) {
		            $md5HashData .= $value;
		        }
		    }
		    
		    // Validate the Secure Hash (remember MD5 hashes are not case sensitive)
		    if (strtoupper($_GET["vpc_SecureHash"]) != strtoupper(md5($md5HashData))) {
			    $errorTxt = "INVALID HASH";
		        $errorExists = true;
		    } else {
	    		$errorExists = ($_GET["vpc_TxnResponseCode"] != "0");
		    }
		} else {
	        $errorExists = true;
		}

	    if ($errorExists && ($errorTxt == "")) {
	    	$errorTxt = "Error " . getResponseDescription($_GET["vpc_TxnResponseCode"]);
	    }
	    
	    if ($errorTxt != "") {
	    	echo $errorTxt;
	    }
	    
	    return !$errorExists;
	}

	function getResponseDescription($responseCode) {
	    switch ($responseCode) {
	        case "0" : $result = "Transaction Successful"; break;
	        case "?" : $result = "Transaction status is unknown"; break;
	        case "1" : $result = "Unknown Error"; break;
	        case "2" : $result = "Bank Declined Transaction"; break;
	        case "3" : $result = "No Reply from Bank"; break;
	        case "4" : $result = "Expired Card"; break;
	        case "5" : $result = "Insufficient funds"; break;
	        case "6" : $result = "Error Communicating with Bank"; break;
	        case "7" : $result = "Payment Server System Error"; break;
	        case "8" : $result = "Transaction Type Not Supported"; break;
	        case "9" : $result = "Bank declined transaction (Do not contact Bank)"; break;
	        case "A" : $result = "Transaction Aborted"; break;
	        case "C" : $result = "Transaction Cancelled"; break;
	        case "D" : $result = "Deferred transaction has been received and is awaiting processing"; break;
	        case "F" : $result = "3D Secure Authentication failed"; break;
	        case "I" : $result = "Card Security Code verification failed"; break;
	        case "L" : $result = "Shopping Transaction Locked (Please try the transaction again later)"; break;
	        case "N" : $result = "Cardholder is not enrolled in Authentication scheme"; break;
	        case "P" : $result = "Transaction has been received by the Payment Adaptor and is being processed"; break;
	        case "R" : $result = "Transaction was not processed - Reached limit of retry attempts allowed"; break;
	        case "S" : $result = "Duplicate SessionID (OrderInfo)"; break;
	        case "T" : $result = "Address Verification Failed"; break;
	        case "U" : $result = "Card Security Code Failed"; break;
	        case "V" : $result = "Address Verification and Card Security Code Failed"; break;
	        default  : $result = "Unable to be determined"; 
	    }
	    return $result;
	}

	function Clear3D() {
		// 3-D Secure Data
		unset($_GET["vpc_VerType"]);
		unset($_GET["vpc_VerStatus"]);
		unset($_GET["vpc_VerToken"]);
		unset($_GET["vpc_VerSecurityLevel"]);
		unset($_GET["vpc_3DSenrolled"]);
		unset($_GET["vpc_3DSXID"]);
		unset($_GET["vpc_3DSECI"]);
		unset($_GET["vpc_3DSstatus"]);
	}

?>
