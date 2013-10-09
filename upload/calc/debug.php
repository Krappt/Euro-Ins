<?php

	function ShowPOST() {
		if (count($_POST) > 0) {
			echo "_POST array:<br/>";
			foreach($_POST as $key=>$value) {
				echo "$key - $value<br />";
			}
		}
	}

	function ShowGET() {
		if (count($_GET) > 0) {
			echo "_GET array:<br/>";
			foreach($_GET as $key=>$value) {
				echo "$key - $value<br />";
			}
		}
	}

	function ShowPolicy() {
		global $Policy, $PolicyNo;

		echo "Policy array [No = " . $PolicyNo . "] :<br/>";
		echo "<pre>";
		print_r($Policy);
		echo "</pre>";
	}

	function ShowVPC() {
		global $vpc_Data;

		echo "vpc_Data array:<br/>";
		echo "<pre>";
		print_r($vpc_Data);
		echo "</pre>";
	}
?>
