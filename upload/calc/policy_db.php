<?php
	$Policy = array();
	$PolicyNo = "";
	$PolicyID = 0;


	function ShowPOST() {
		foreach($_POST as $key=>$value) {
			echo "$key - $value<br />";
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
		global $wpdb, $PolicyID;

		if ($_GET['PartnerID'] != '') { $PartnerID = $_GET['PartnerID']; } else { $PartnerID = 0; }

		$wpdb->insert('policies', array_merge(array('PID' => $PartnerID), $_POST));

		$PolicyID = $wpdb->insert_id;
	}

	function LoadPolicy() {
		global $wpdb, $Policy, $PolicyNo, $PolicyID;

		$Policy = $wpdb->get_row('SELECT * FROM `policies` WHERE ID = ' . $PolicyID, ARRAY_A);

		// Формируем номер полиса
		$PolicyNo = sprintf("ВЗР%06dИ", $PolicyID);
	}

	function ShowGET() {
		foreach($_GET as $key=>$value) {
			echo "$key - $value<br />";
		}
	}

	function SaveVPC() {
		global $wpdb, $PolicyID;

		$count = $wpdb->get_var('SELECT COUNT(*) FROM `policies` WHERE (ID = ' . $PolicyID . ') and (`vpc_SecureHash` IS NULL)');
		if ($count == 1) {
			foreach ($_GET as $key => $value) {
				$updates[] = "$key = '$value'";
			}
			$implodeArray = implode(', ', $updates);

			$wpdb->update('policies', $updates, array('ID' => $PolicyID));
		}
		
		return $count;
	}

?>
