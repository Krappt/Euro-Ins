<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
	<title>Untitled</title>
</head>

<body>

<?php

	include('../wp-load.php');
	include('policy_db.php');

	global $wpdb;

	$tab = "\t"; $eol = PHP_EOL;
	
	$SQL = 'SELECT * FROM `policies`';
	if (isset($_GET['PartnerID'])) { $SQL = $SQL . ' WHERE PID = ' . $_GET['PartnerID']; }
	$Table = $wpdb->get_results($SQL, ARRAY_A);

	echo '<table border="1">'.$eol;
		echo $tab.'<tr>';
		if (!isset($_GET['PartnerID'])) { echo '<td>Продавец</td>'; }
		echo '<td>Номер полиса</td><td>Страны поездки</td><td>Застрахованные</td><td>Даты рождения</td><td>Начало действия</td><td>Окончание</td><td>Кол-во дней</td><td>Программа</td><td>Премия</td><td>Дата оплаты</td><td>Премия в рублях</td>';
		echo '</tr>'.$eol;
	
	foreach ($Table as $Row) {
		echo $tab.'<tr>';
		if (!isset($_GET['PartnerID'])) { echo '<td>'.$Row['PID'].'</td>'; }
		// Номер полиса
		echo '<td>'.sprintf("ВЗР%06dИ", $Row['ID']).'</td>';
		// Страны поездки
			$Countries = '';
			for ($No = 0; $No <= ($Row['totalHumans'] - 1); $No++) {
				$Countries = $Countries . (($Countries <> '')?'<br/>':'') . $Row['country_'.$No];
			}
		echo '<td>'.$Countries.'</td>';
		// Застрахованные
			$Names = '';
			for ($No = 0; $No <= ($Row['totalHumans'] - 1); $No++) {
				$Names = $Names . (($Names <> '')?'<br/>':'') . $Row['last_name_'.$No] . ' ' . $Row['first_name_'.$No];
			}
		echo '<td>'.$Names.'</td>';
		// Даты рождения
		$BirthDays = '';
		for ($No = 0; $No <= ($Row['totalHumans'] - 1); $No++) {
			$BirthDays = $BirthDays . (($BirthDays <> '')?'<br/>':'') . $Row['birthday_'.$No];
		}
		echo '<td>'.$BirthDays.'</td>';
		// Начало действия
		echo '<td>'.$Row['date_in'].'</td>';
		// Окончание
		echo '<td>'.$Row['date_out'].'</td>';
		// Кол-во дней
		echo '<td>'.$Row['totalDays'].'</td>';
		// Программа
		echo '<td>'.$Row['program'].'</td>';
		// Премия
		if ($Row['vpc_Amount'] != '') { echo '<td>'.money_format('%.2n', $Row['vpc_Amount']/100/$Row['rate']).' руб.</td>'; } else { echo '<td>&nbsp;</td>'; }
		// Дата оплаты
		if ($Row['vpc_BatchNo'] != '') { echo '<td>'.date('d.m.Y', strtotime($Row['vpc_BatchNo'])).'</td>'; } else { echo '<td>&nbsp;</td>'; }
		// Премия в рублях ( 20ый столбец)
		if ($Row['vpc_Amount'] != '') { echo '<td>'.money_format('%.2n', $Row['vpc_Amount']/100).' руб.</td>'; } else { echo '<td>&nbsp;</td>'; }
		echo '</tr>'.$eol;
	}
	echo '</table>'.$eol;
?>

</body>
</html>
