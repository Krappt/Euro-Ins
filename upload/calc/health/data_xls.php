<?php

	$xlsColumns = array('Продавец', 'Серия, № полиса', 'Страна', 'Программа', 'Страхователь', 'Дата рождения', 'Застрахованные лица', 'Дата рождения', 'Застраховано чел.', 'Срок с', 'Срок по', 'Кол-во дней', 'Особые условия', 'Премия (у.е.)', 'Оформлен', 'Валюта', 'Курс', 'Страховая Сумма (у.е.)', 'Сумма (руб)', 'Премия (руб)', 'Адрес Страхователя', 'Электронная почта', 'Телефон Страхователя', 'Спорт');

	function getNames() {
		global $Policy;
		
		$Names = '';
		for ($No = 0; $No <= ($Policy['totalHumans'] - 1); $No++) {
			$Names = $Names . (($Names <> '')?PHP_EOL:"") . $Policy['last_name_'.$No] . ' ' . $Policy['first_name_'.$No];
		}
		
		return $Names;
	}

	function getBirthDays() {
		global $Policy;
		
		$BirthDays = '';
		for ($No = 0; $No <= ($Policy['totalHumans'] - 1); $No++) {
			$BirthDays = $BirthDays . (($BirthDays <> '')?PHP_EOL:"") . $Policy['birthday_'.$No];
		}
		
		return $BirthDays;
	}

	function getRiskNames() {
		global $Policy;
		
		$RiskNames = '';
		for ($No = 0; $No <= ($Policy['totalHumans'] - 1); $No++) {
			if ($Policy['risk_'.$No] <> 'Без дополнительных рисков') {
				$RiskNames = $RiskNames . (($RiskNames <> '')?PHP_EOL:"") . $Policy['last_name_'.$No] . ' ' . $Policy['first_name_'.$No];
			}
		}
		
		return $RiskNames;
	}

	function getData() {
		global $Policy, $PolicyNo;

		$arrData = array(
			$Policy['PID'],
			$PolicyNo,
			$Policy['country_0'],
			"1",
			$Policy['insured_name'],
			$Policy['birthday_0'],
			getNames(),
			getBirthDays(),
			$Policy['totalHumans'],
			$Policy['date_in'],
			$Policy['date_out'],
			$Policy['totalDays'],
			$Policy['program'],
			sprintf("%08.2f", ($Policy['cost'] / $Policy['rate'])), // Премия (у.е.)
			date('d.m.Y', strtotime($Policy['Date'])),
			substr($Policy['summa_0'], -3, 3), // Валюта
			sprintf("%08.4f", $Policy['rate']), // Курс
			substr(str_replace(' ', '', $Policy['summa_0']), 0, -3), // СтраховаяСумма(у.е.)
			sprintf("%08.2f", ($Policy['rate'] * $Sum)), // Сумма (руб)
			$Policy['cost'], // Премия (руб)
			$Policy['address'],
			$Policy['e-mail'],
			$Policy['phone'],
			getRiskNames()
		);
		
		return $arrData;
	}
?>
