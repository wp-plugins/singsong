<?php
	require_once('../../../wp-config.php');	
	$url = $_GET['url'];
	$player = get_option('singsong_player');
	extract($player);
if ($skin==0) {
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Player</title>
</head>
<?php 
if ($bgi != '') {
	echo '<body background="'.$bgi.'">';
} else if ($bgc != '') {
	echo '<body bgcolor="'.$bgc.'">';
} else {
	echo '<body>';
}
?>
<p align="center">&nbsp;</p>
<p align="center">
<?php echo insert_singsong_php_code($url, $loop, 50, $auto, $pwidth, $pheight); ?>
</p>
</body>
</html>
<?php
}
?>