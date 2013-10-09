<?php

// Настройки калькулятора
	$GeneratePDF = true;
	$GenerateXLS = true;
	$SendMail = true;
	$GoToVPC = true;
	$Debug = false;

// Настройки платежной системы
	// This is secret for encoding the MD5 hash. This secret will vary from merchant to merchant
	$SECURE_SECRET = "FC4813131480ACBAE05D27AC1B6D3817";
	// Заголовок передаваемых параметров
	$vpc_Data = array(
		'vpc_Version'    =>          '1', // VPC Version
		'vpc_Command'    =>        'pay', // Command Type
		'vpc_Locale'     =>      'RU_ru', // Payment Server Display Language Locale
		'vpc_AccessCode' =>   '08414424', // Merchant AccessCode
		'vpc_Merchant'   => '9293686770', // MerchantID
	);

// На случай проблев в конфиге хостинга
	if ($GeneratePDF) {
		ini_set('memory_limit', '64M');
	}

?>
