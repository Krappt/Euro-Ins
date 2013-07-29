<?php
	$Policy = array();
	$PolicyNo = "";
	$PolicyID = 0;


	function ShowPOST() {
		foreach($_POST as $key=>$value) {
			echo "$key - ".iconv("windows-1251", "UTF-8", $value)."<br />";
		}
	}

	function ShowPolicy() {
		global $Policy, $PolicyNo;

		echo $PolicyNo."<br/>";
		echo "<pre>";
		print_r($Policy);
		echo "</pre>";
	}

	function SavePolicy() {
		global $DB, $PolicyID;

		if ($_GET['PartnerID'] != '') { $PartnerID = $_GET['PartnerID']; } else { $PartnerID = 0; }

		$DB->query('INSERT INTO `policies` (`PID`,`'.implode('`,`',array_keys($_POST)).'`) VALUES ("'.$PartnerID.'","'.implode('","',array_values($_POST)).'");');

		$PolicyID = $DB->insert_id();
	}

	function LoadPolicy() {
		global $DB, $Policy, $PolicyNo, $PolicyID;

		$Policy = $DB->fetch_array($DB->query('SELECT * FROM `policies` WHERE ID = %d;', $PolicyID));
		// Меняем кодировку переданных параметров
		foreach($Policy as $key=>$value) {
			$Policy[$key] = iconv("windows-1251", "UTF-8", $value);
		}

		// Формируем номер полиса
		$PolicyNo = iconv("windows-1251", "UTF-8", sprintf("ВЗР%06dИ", $PolicyID));
	}

	function ShowGET() {
		foreach($_GET as $key=>$value) {
			echo "$key - ".iconv("windows-1251", "UTF-8", $value)."<br />";
		}
	}

	function SaveVPC() {
		global $DB, $PolicyID;

		$count = $DB->query_first('SELECT COUNT(*) FROM `policies` WHERE (ID = ' . $PolicyID . ') and (`vpc_SecureHash` IS NULL)');
		if ($count[0] == 1) {
			foreach ($_GET as $key => $value) {
				$updates[] = "$key = '$value'";
			}
			$implodeArray = implode(', ', $updates);

			$DB->query('UPDATE `policies` SET ' . $implodeArray . ' WHERE ID = ' . $PolicyID);
		}
		
		return $count[0];
	}

?>
