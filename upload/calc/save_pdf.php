<?php

	function WritePDF() {
		global $Policy, $PolicyNo, $PolicyType, $SendMail;

		// Загружаем макет с обработкой переменных PHP
		ob_start();
		include(dirname(__FILE__) . '/' . $PolicyType . '/policy.html');
		$html = ob_get_contents();
		ob_end_clean();
		
		// Подключаем библиотеку выгрузки в PDF
		require(dirname(__FILE__) . '/../includes/mPDF/mpdf.php');
		
		// Формируем полис
		$mpdf=new mPDF('cp1251', 'A4'); 
		$mpdf->WriteHTML($html);

		if ($SendMail) {
			// http://mpdf1.com/manual/index.php?tid=373
			
			$content = $mpdf->Output('', 'S');
			
			require(dirname(__FILE__) . '/../includes/PHPMailer/class.phpmailer.php');
			require(dirname(__FILE__) . '/' . $PolicyType . '/data_pdf.php');
			
			$from_name = 'Euro-Ins';
			$from_mail = 'info@euro-ins.ru';
			$subject = 'Policy';
			$filename = 'policy.pdf';

			$mail = new PHPMailer();
			$mail->IsSMTP();
			$mail->SMTPDebug = 1; // enables SMTP debug information (1 = errors and messages, 2 = messages only)
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = 'ssl'; // 'tls'
			$mail->Host = 'smtp.gmail.com';
			$mail->Port = 465; // 587
			$mail->Username = 'web.euroins@gmail.com';
			$mail->Password = 'z34567890123';
			$mail->SetFrom($from_mail, $from_name);
				$mail->AddReplyTo($from_mail,$from_name);
			$mail->AddAddress($to_mail, $to_name);
			$mail->Subject = $subject;
				ob_start();
				include(dirname(__FILE__) . '/message.html');
				$html = ob_get_contents();
				ob_end_clean();
			$mail->MsgHTML($html);
			$mail->AddStringAttachment($content, $filename);

			$is_sent = $mail->Send();
			
			if ($is_sent) {
				include(dirname(__FILE__) . '/' . $PolicyType . '/sent.html');
			}
		} else { $is_sent = false; }

		if (!$is_sent && ($mail->SMTPDebug == 0)) {
			$mpdf->Output();
		}
	}
?>
