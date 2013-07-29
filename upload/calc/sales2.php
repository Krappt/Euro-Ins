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
		echo '<td>����� ������</td><td>������ �������</td><td>��������������</td><td>���� ��������</td><td>������ ��������</td><td>���������</td><td>���-�� ����</td><td>���������</td><td>������</td><td>���� ������</td><td>������ � ������</td>';
		echo '</tr>'.$eol;
	
	while($Row = $DB->fetch_array($Table)) {
		echo $tab.'<tr>';
		if (!isset($_GET['PartnerID'])) { echo '<td>'.$Row['PID'].'</td>'; }
		// ����� ������
		echo '<td>'.sprintf("���%06d�", $Row['ID']).'</td>';
		// ������ �������
			$Countries = '';
			for ($No = 0; $No <= ($Row['totalHumans'] - 1); $No++) {
				$Countries = $Countries . (($Countries <> '')?'<br/>':'') . $Row['country_'.$No];
			}
		echo '<td>'.$Countries.'</td>';
		// ��������������
			$Names = '';
			for ($No = 0; $No <= ($Row['totalHumans'] - 1); $No++) {
				$Names = $Names . (($Names <> '')?'<br/>':'') . $Row['last_name_'.$No] . ' ' . $Row['first_name_'.$No];
			}
		echo '<td>'.$Names.'</td>';
		// ���� ��������
		$BirthDays = '';
		for ($No = 0; $No <= ($Row['totalHumans'] - 1); $No++) {
			$BirthDays = $BirthDays . (($BirthDays <> '')?'<br/>':'') . $Row['birthday_'.$No];
		}
		echo '<td>'.$BirthDays.'</td>';
		// ������ ��������
		echo '<td>'.$Row['date_in'].'</td>';
		// ���������
		echo '<td>'.$Row['date_out'].'</td>';
		// ���-�� ����
		echo '<td>'.$Row['totalDays'].'</td>';
		// ���������
		echo '<td>'.$Row['program'].'</td>';
		// ������
		if ($Row['vpc_Amount'] != '') { echo '<td>'.money_format('%.2n', $Row['vpc_Amount']/100/$Row['rate']).' ���.</td>'; } else { echo '<td>&nbsp;</td>'; }
		// ���� ������
		if ($Row['vpc_BatchNo'] != '') { echo '<td>'.date('d.m.Y', strtotime($Row['vpc_BatchNo'])).'</td>'; } else { echo '<td>&nbsp;</td>'; }
		// ������ � ������ ( 20�� �������)
		if ($Row['vpc_Amount'] != '') { echo '<td>'.money_format('%.2n', $Row['vpc_Amount']/100).' ���.</td>'; } else { echo '<td>&nbsp;</td>'; }
		echo '</tr>'.$eol;
	}
	echo '</table>'.$eol;
?>

</body>
</html>
