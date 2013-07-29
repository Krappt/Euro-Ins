<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
	<title>Untitled</title>
</head>

<body>

<?php

	define('IN_SUBDREAMER', true);
	include('../includes/core.php');
	include('policy_db.php');

	global $DB;

	$tab = "\t"; $eol = PHP_EOL;
	
	$SQL = 'SELECT * FROM `policies`';
	if (isset($_GET['PartnerID'])) { $SQL = $SQL . ' WHERE PID = ' . $_GET['PartnerID']; }
	$Table = $DB->query($SQL);

	echo '<table border="1">'.$eol;
		echo $tab.'<tr>';
		if (!isset($_GET['PartnerID'])) { echo '<td>��������</td>'; }
		echo '<td>���� �������</td><td>����� ������</td><td>������ �������</td><td>���������� �����</td>';
		echo '</tr>'.$eol;
	
	while($Row = $DB->fetch_array($Table)) {
		echo $tab.'<tr>';
		if (!isset($_GET['PartnerID'])) { echo '<td>'.$Row['PID'].'</td>'; }
		if ($Row['vpc_BatchNo'] != '') { echo '<td>'.date('d.m.Y', strtotime($Row['vpc_BatchNo'])).'</td>'; } else { echo '<td>&nbsp;</td>'; }
		echo '<td>'.sprintf("���%06d�", $Row['ID']).'</td><td>'.$Row['country_0'].'</td>';
		if ($Row['vpc_Amount'] != '') { echo '<td>'.money_format('%.2n', $Row['vpc_Amount']/100).' ���.</td>'; } else { echo '<td>&nbsp;</td>'; }
		echo '</tr>'.$eol;
	}
	echo '</table>'.$eol;
?>

</body>
</html>
