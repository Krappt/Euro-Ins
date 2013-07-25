<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>HTML5 Menu</title>
	<base target="_parent" />

	<script>
	function detectIE6(){
		var browser = window.navigator.userAgent;
		if (navigator.userAgent.indexOf('MSIE') != -1){
			var re = /MSIE\s([\d]+)/;
			var res = browser.match(re);
			if (res[1] > 8){
				return true;
			}
		}
		return false;
	}

	function removeMenu(){
		if ( detectIE6() ){
			var html5=document.getElementById("menus_wrapHTML5");
			document.getElementById("menus_wrap").removeChild(html5);
		}
		else{
			var flash=document.getElementById("menus_wrapFLASH");
			document.getElementById("menus_wrap").removeChild(flash);
		}
	}
	</script>
	<script src="html5/runtime.js"></script>
	<script src="html5/menusapi.js"></script>
<style>
	.menu_elem { width: 137px; height: 114px; float: left; margin-right: 2px; }
	.flash_link { position: absolute; top: 0px; left: 0px; width: 137px; height: 114px; background: url('flash/zero.gif') no-repeat; }
</style>
</head>

<body style="margin: 0px;">

<?php

$tab = "\t"; $eol = PHP_EOL;
$links = array(
    1 => array(
        1 => '/insurance/kasko_osago', '/insurance/houses', '/insurance/strahovka_dlya_vyezda_za_granitsu', '/insurance/medicina', '/insurance/neschastnyi_sluchai'
    ),
    2 => array(
        1 => '/corporate/transport', '/corporate/imushestvo_u', '/corporate/personal', '/corporate/otvetstvennost', '/corporate/cargo'
    ),
);

if (!isset($_GET['ID'])) { $ID = 1; } else { $ID = $_GET['ID']; }

echo '<div id="menus_wrap"><div id="menus_wrapHTML5">'.PHP_EOL;
	for ($i = 1; $i <= 5; $i++) {
		echo '<a href="'.$links[$ID][$i].'"><div class="menu_elem" id="menu'.$ID.'_'.$i.'"></div></a>'.PHP_EOL;
	}
echo '</div>'.PHP_EOL;

echo '<script>'.PHP_EOL;
	for ($i = 1; $i <= 5; $i++) {
		echo 'var stagemenu'.$ID.'_'.$i.' = new swiffy.Stage(document.getElementById("menu'.$ID.'_'.$i.'"), menu'.$ID.'_'.$i.'object); stagemenu'.$ID.'_'.$i.'.start();'.PHP_EOL;
	}
echo '</script>'.PHP_EOL;

echo '<div id="menus_wrapFLASH">'.PHP_EOL;
echo '<script>removeMenu();</script>'.PHP_EOL;
	for ($i = 1; $i <= 5; $i++) {
	    // http://pokrovskii.com/razmeshhaem-chto-libo-poverx-flash-bloka/
	    echo '<div class="menu_elem" style="position: relative;"><a class="flash_link" href="'.$links[$ID][$i].'"></a><object type="application/x-shockwave-flash" data="flash/'.$ID.'-'.$i.'.swf" width="137" height="114"><param name="wmode" value="opaque"><param name="movie" value=data="flash/'.$ID.'-'.$i.'.swf" /><param name="quality" value="high" /></object></div>'.PHP_EOL;
	}
echo '</div></div>'.PHP_EOL;

?>

</body>
</html>
