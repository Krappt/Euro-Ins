<?php

	$Policy = array();
	$PolicyNo = "";
	$PolicyID = 0;
	$PolicyType = "";
	$PolicyMask = "";


	function GetTable(){
		global $PolicyType;

		return 'policy-' . $PolicyType;
	}

	function SavePolicy() {
		global $wpdb, $PolicyID;

		if ($_GET['PartnerID'] != '') { $PartnerID = $_GET['PartnerID']; } else { $PartnerID = 0; }

		$wpdb->insert(GetTable(), array_merge(array('PID' => $PartnerID), $_POST));

		$PolicyID = $wpdb->insert_id;
	}

	function LoadPolicy() {
		global $wpdb, $Policy, $PolicyNo, $PolicyID, $PolicyMask;

		$Policy = $wpdb->get_row('SELECT * FROM `' . GetTable() . '` WHERE ID = ' . $PolicyID, ARRAY_A);

		// Формируем номер полиса
		$PolicyNo = sprintf($PolicyMask, $PolicyID);
	}

	function SaveVPC() {
		global $wpdb, $PolicyID;

		$count = $wpdb->get_var('SELECT COUNT(*) FROM `' . GetTable() . '` WHERE (ID = ' . $PolicyID . ') and (`vpc_SecureHash` IS NULL)');
		if ($count == 1) {
			$wpdb->update(GetTable(), $_GET, array('ID' => $PolicyID));
		}
		
		return $count;
	}

?>
