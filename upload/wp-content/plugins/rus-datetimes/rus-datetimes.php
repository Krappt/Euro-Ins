<?php
/*
Plugin Name: Russian Datetimes with Cases
Plugin URI: http://q-zma.rajaka.net/#
Description: This plugin adds ability to use extra formatting rules for dates and times with taking into grammatical features of russian language. It works with russian locale with charsets UTF-8, windows-1251 and KOI8-R only.
Author: Denis Kuznetsov
Version: 0.1
Author URI: http://q-zma.rajaka.net/
*/ 

/*
	Именительный падеж 	- :ИП:
	Родительный падеж 	- :РП:
	Дательный падеж 	- :ДП:
	Винительный падеж 	- :ВП:
	Творительный падеж 	- :ТП:
	Предложный падеж 	- :ПП:
*/

$russian_cases = array
(
	'ИП','РП','ДП','ВП','ТП','ПП'
);

$russian_monthes = array
(
	'январь' => array
	(
		'ь', 'я', 'ю', 'ь', 'ём', 'е'
	),
	'февраль' => array
	(
		'ь', 'я', 'ю', 'ь', 'ём', 'е'
	),
	'март' => array
	(
		'т', 'та', 'ту', 'т', 'том', 'те'
	),
	'апрель' => array
	(
		'ь', 'я', 'ю', 'ь', 'ем', 'е'
	),
	'май' => array
	(
		'й', 'я', 'ю', 'й', 'ем', 'е'
	),
	'июнь' => array
	(
		'ь', 'я', 'ю', 'ь', 'ем', 'е'
	),
	'июль' => array
	(
		'ь', 'я', 'ю', 'ь', 'ем', 'е'
	),
	'август' => array
	(
		'т', 'та', 'ту', 'т', 'том', 'те'
	),
	'сентябрь' => array
	(
		'ь', 'я', 'ю', 'ь', 'ём', 'е'
	),
	'октябрь' => array
	(
		'ь', 'я', 'ю', 'ь', 'ём', 'е'
	),
	'ноябрь' => array
	(
		'ь', 'я', 'ю', 'ь', 'ём', 'е'
	),
	'декабрь' => array
	(
		'ь', 'я', 'ю', 'ь', 'ём', 'е'
	)
);

$russian_weekdays = array
(
	'понедельник'	=> array
	(
		'к', 'ка', 'ку', 'к', 'ком', 'ке'
	),
	'вторник'	=> array
	(
		'к', 'ка', 'ку', 'к', 'ком', 'ке'
	),
	'среда'	=> array
	(
		'а', 'ы', 'е', 'у', 'ой', 'е'
	),
	'четверг'	=> array
	(
		'г', 'га', 'гу', 'г', 'гом', 'ге'
	),
	'пятница'	=> array
	(
		'а', 'ы', 'е', 'у', 'ей', 'е'
	),
	'суббота'	=> array
	(
		'а', 'ы', 'е', 'у', 'ой', 'е'
	),
	'воскресенье'	=> array
	(
		'е', 'я', 'ю', 'е', 'ем', 'е'
	)
);

$russian_days = array ( );

for ( $ii = 0; $ii < 31; $ii++ )
{
	if ( $ii != 2 and $ii != 22 ) array_push ( $russian_days, array( 'ое', 'го', 'му', 'ое', 'ым', 'ом' ) );
	else array_push ( $russian_days, array ( 'е', 'го', 'му', 'е', 'им', 'ем' ) );
}

function trans_russian_date_time ( $string )
{	
	if( WPLANG == 'ru_RU' )
	{		
		switch ( get_settings ( 'blog_charset' ) )
		{
			case 'UTF-8':		
			case 'utf-8':
			case 'utf8':
			case 'UTF8':				
				if(extension_loaded('mbstring')) return trans_russian_date_time_multibyte ( $string );
				else return trans_russian_date_time_singlebyte ( $string, 'UTF-8' );
				break;
			case 'windows-1251':
			case 'WINDOWS-1251':
			case 'cp1251':			
			case 'CP1251':			
				return trans_russian_date_time_singlebyte ( $string, 'CP1251' );				
			case 'koi8-r':
			case 'KOI8-R':
				return trans_russian_date_time_singlebyte ( $string, 'KOI8-R' );
				break;
			default:
				return $string;
		}
	}
	return $string;
}

function trans_russian_date_time_multibyte ( $string )
{
	global $russian_cases, $russian_monthes, $russian_weekdays, $russian_days;
	mb_internal_encoding("UTF-8");
	$monthes = array_keys($russian_monthes);
	$weekdays = array_keys($russian_weekdays);
	foreach ( $monthes as $month )
	{						
		$search = '/(' . mb_strtoupper(mb_substr($month,0,1)) . '|' . mb_substr($month,0,1) . ')(' . mb_substr($month,1,mb_strlen($month)-2) . ')(' . mb_substr($month,mb_strlen($month)-1) . '):(' . implode('|',$russian_cases) . '):/mu';
		preg_match_all($search,$string,$matches);
		if(count($matches[0]) > 0) for($ii = 0; $ii < count($matches[0]); $ii++) $string = str_replace($matches[0][$ii],($matches[1][$ii] . mb_substr($month,1,mb_strlen($month)-2) . $russian_monthes[$month][array_search($matches[4][$ii], $russian_cases)]),$string);
	}
	foreach ( $weekdays as $weekday )
	{
		$search = '/(' . mb_strtoupper(mb_substr($weekday,0,1)) . '|' . mb_substr($weekday,0,1) . ')(' . mb_substr($weekday,1,mb_strlen($weekday)-2) . ')(' . mb_substr($weekday,mb_strlen($weekday)-1) . '):(' . implode('|',$russian_cases) . '):/mu';
		preg_match_all($search,$string,$matches);
		if(count($matches[0]) > 0) for($ii = 0; $ii < count($matches[0]); $ii++) $string = str_replace($matches[0][$ii],($matches[1][$ii] . mb_substr($weekday,1,mb_strlen($weekday)-2) . $russian_weekdays[$weekday][array_search($matches[4][$ii], $russian_cases)]),$string);
	}
	$search = '/(\d{1,2})(st|nd|rd|th):(' . implode('|',$russian_cases) . '):/mu';
	preg_match_all($search,$string,$matches);
	if(count($matches[0]) > 0)
	for($ii = count($matches[0]) - 1; $ii >= 0; $ii--)
	{
		$string = str_replace($matches[0][$ii],($matches[1][$ii] . '-' . $russian_days[(int) $matches[1][$ii] - 1][array_search($matches[3][$ii], $russian_cases)]),$string);					
	}	
	return $string;
}

function trans_russian_date_time_singlebyte ( $string, $charset )
{
	global $russian_cases, $russian_monthes, $russian_weekdays, $russian_days;
	$phpver = explode('.',phpversion());
	$russian_cases_new = array();
	$russian_monthes_new = array();
	$russian_weekdays_new = array();
	$russian_days_new = array();
	$string_new = decode_charset_from_to($charset,'CP1251',$string);	
	foreach($russian_cases as $russian_case) array_push($russian_cases_new,decode_charset_from_to($charset,'CP1251',$russian_case));
	foreach($russian_monthes as $russian_month => $values)
	{
		$temp = array();
		foreach ($values as $value) array_push($temp,decode_charset_from_to($charset,'CP1251',$value));
		$russian_monthes_new[decode_charset_from_to($charset,'CP1251',$russian_month)] = $temp;
	}
	foreach($russian_weekdays as $russian_weekday => $values)
	{
		$temp = array();
		foreach ($values as $value) array_push($temp,decode_charset_from_to($charset,'CP1251',$value));
		$russian_weekdays_new[decode_charset_from_to($charset,'CP1251',$russian_weekday)] = $temp;
	}
	for($ii = 0; $ii < count($russian_days); $ii++)
	{
		$temp = array();
		foreach ($russian_days[$ii] as $value) array_push($temp,decode_charset_from_to($charset,'CP1251',$value));
		$russian_days_new[$ii] = $temp;
	}
	$monthes = array_keys($russian_monthes_new);
	$weekdays = array_keys($russian_weekdays_new);
	foreach ( $monthes as $month )
	{						
		$search = '/(' . strtoupper(substr($month,0,1)) . '|' . substr($month,0,1) . ')(' . substr($month,1,strlen($month)-2) . ')(' . substr($month,strlen($month)-1) . '):(' . implode('|',$russian_cases_new) . '):/m';
		preg_match_all($search,$string_new,$matches);
		if(count($matches[0]) > 0) for($ii = 0; $ii < count($matches[0]); $ii++) $string_new = str_replace($matches[0][$ii],($matches[1][$ii] . substr($month,1,strlen($month)-2) . $russian_monthes_new[$month][array_search($matches[4][$ii], $russian_cases_new)]),$string_new);
	}
	foreach ( $weekdays as $weekday )
	{
		$search = '/(' . strtoupper(substr($weekday,0,1)) . '|' . substr($weekday,0,1) . ')(' . substr($weekday,1,strlen($weekday)-2) . ')(' . substr($weekday,strlen($weekday)-1) . '):(' . implode('|',$russian_cases_new) . '):/m';
		preg_match_all($search,$string_new,$matches);
		if(count($matches[0]) > 0) for($ii = 0; $ii < count($matches[0]); $ii++) $string_new = str_replace($matches[0][$ii],($matches[1][$ii] . substr($weekday,1,strlen($weekday)-2) . $russian_weekdays_new[$weekday][array_search($matches[4][$ii], $russian_cases_new)]),$string_new);
	}
	$search = '/(\d{1,2})(st|nd|rd|th):(' . implode('|',$russian_cases_new) . '):/m';
	preg_match_all($search,$string_new,$matches);
	if(count($matches[0]) > 0)
	for($ii = count($matches[0]) - 1; $ii >= 0; $ii--)
	{
		$string_new = str_replace($matches[0][$ii],($matches[1][$ii] . '-' . $russian_days_new[(int) $matches[1][$ii] - 1][array_search($matches[3][$ii], $russian_cases_new)]),$string_new);					
	}	
	return decode_charset_from_to('CP1251','UTF-8',$string_new);
}

function decode_charset_from_to($from, $to, $string)
{
	$phpver = explode('.',phpversion());	
	if(((int) $phpver[0] > 4 or extension_loaded('iconv')) and $from != $to)
	{
		return iconv($from, $to, $string);
	}
	elseif($from == 'UTF-8' and $to == 'CP1251')
	{
		return utf8_to_win ( $string );
	}
	elseif($from == 'CP1251' and $to == 'UTF-8')
	{
		return win_to_utf8 ( $string );
	}
	elseif($from == 'KOI8-R' and $to == 'CP1251')
	{
		return convert_cyr_string($string, 'k', 'w');
	}
	else
	{
		return $string;
	}
}

function win_to_utf8 ( $s )
{
	$t = '';
	for ( $i = 0, $m = strlen ( $s ); $i < $m; $i++ )
	{
		$c = ord ( $s[$i] );
		if ( $c <= 127 ) { $t .= chr ( $c ); continue; }
		if ( $c >= 192 && $c <= 207) { $t .= chr( 208 ) . chr ( $c-48 ); continue; }
		if ( $c >= 208 && $c <= 239) { $t .= chr( 208 ) . chr ( $c-48 ); continue; }
		if ( $c >= 240 && $c <= 255) { $t .= chr( 209 ) . chr ( $c-112 ); continue; }
		if ( $c == 184 ) { $t .= chr ( 209 ) . chr ( 145 ); continue; };
		if ( $c == 168 ) { $t .= chr ( 208 ) . chr ( 129 ); continue; };
	}
   return $t; 
}

function utf8_to_win ( $s )
{
	$t = '';
	$byte2 = false;
	for ( $c = 0; $c < strlen ( $s ) ; $c++ )
	{
   		$i = ord ( $s[$c] );
   		if ( $i <= 127 ) $t .= $s[$c];
   		if ( $byte2 )
		{
			$new_c2 = ( $c1 & 3 ) * 64 + ( $i & 63 );
			$new_c1 = ( $c1 >> 2 ) & 5;
			$new_i = $new_c1 * 256 + $new_c2;
			if ( $new_i == 1025 ) $t_i = 168; else if ( $new_i == 1105 ) $t_i = 184; else $t_i = $new_i - 848;
       		$t .= chr ( $t_i );
       		$byte2 = false;
       }
       if ( ( $i >> 5 ) == 6 ) { $c1 = $i; $byte2 = true; }
	}
	return $t; 
}

add_filter('get_the_date', 'trans_russian_date_time', 10, 1);
add_filter('get_the_time', 'trans_russian_date_time', 10, 1);
add_filter('get_comment_date', 'trans_russian_date_time', 10, 1);
add_filter('get_comment_time', 'trans_russian_date_time', 10, 1);
add_filter('get_the_modified_time', 'trans_russian_date_time', 10, 1);