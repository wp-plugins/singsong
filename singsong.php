<?php
/*
Plugin Name: SingSong
Plugin URI: http://www.royakhosravi.com/?p=337
Description:  SingSong Wordpress plugin allows you to add a background sound or music to each section of your Blog (Home, Single, Page, Archive).
Author: Roya Khosravi
Version: 1.2
Author URI: http://www.royakhosravi.com/

Updates:
-none

To-Doo:
-none
*/

$singsong_localversion="1.2";
$wp_singsong_plugin_url = trailingslashit( get_bloginfo('wpurl') ).PLUGINDIR.'/'. dirname( plugin_basename(__FILE__) );

function detect_me() {
$user = $_SERVER['HTTP_USER_AGENT'];

if(eregi("linux",$user)){$system = "Linux";}
        elseif(eregi("win32",$user)){$system = "Windows";}
        elseif(eregi("Win 9x 4.90",$user)){$system = "Windows Me";}
elseif(eregi("windows 2000",$user) || eregi("(windows nt)( ){0,1}
(5.0)",$user) ){$system = "Windows 2000";}
elseif(eregi("(windows nt)( ){0,1}(5.1)",$user) ){$system = "Windows 
XP";}
        elseif( (eregi("(win)([0-9]{2})",$user,$regs)) || (eregi
("(windows) ([0-9]{2})",$user,$regs)) ){$system = "Windows $regs[2]";}
        elseif(eregi("(winnt)([0-9]{1,2}.[0-9]{1,2}){0,1}",$user,$regs) ) {$system = "Windows NT $regs[2]";}
        elseif(eregi("(windows nt)( ){0,1}([0-9]{1,2}.[0-9]{1,2}){0,1}",$user,$regs) ){$system = "Windows NT $regs[3]";}
        elseif(eregi("mac",$user)){$system = "Macintosh";}
        elseif(eregi("(sunos) ([0-9]{1,2}.[0-9]{1,2}){0,1}",$user,$regs)){$system = "SunOS $regs[2]";}
        elseif(eregi("(beos) r([0-9]{1,2}.[0-9]{1,2}){0,1}",$user,$regs)){$system = "BeOS $regs[2]";}
        elseif(eregi("freebsd",$user)){$system = "FreeBSD";}
        elseif(eregi("openbsd",$user)){$system = "OpenBSD";}
        elseif(eregi("irix",$user)){$system = "IRIX";}
        elseif(eregi("os/2",$user)){$system = "OS/2";}
        elseif(eregi("plan9",$user)){$system = "Plan9";}
        elseif(eregi("unix",$user) || eregi("hp-ux",$user) || eregi("X11",$user) ){$system = "Unix";}
        elseif(eregi("osf",$user)){$system = "OSF";}
        else{$system = "Unknown";}
return $system;
}
 // Admin Panel   
function singsong_add_pages()
{
	add_options_page('SingSong options', 'SingSong', 8, __FILE__, 'singsong_options_page');            
}
// Options Page
function singsong_options_page()
{ 
	global $singsong_localversion;
	$status = singsong_getinfo();	
	$theVersion = $status[1];
	$theMessage = $status[3];	
	
			if( (version_compare(strval($theVersion), strval($singsong_localversion), '>') == 1) )
			{
				$msg = 'Latest version available '.' <strong>'.$theVersion.'</strong><br />'.$theMessage;	
				  _e('<div id="message" class="updated fade"><p>' . $msg . '</p></div>');			
			
			}
			
			

			if (isset($_POST['submitted'])) 
	{	

			$sspage_nb= $_POST['sspage_nb'];
			$sssingle_nb= $_POST['sssingle_nb'];

			$sssingle = array();
			$found = 0;
			for ($i = 0; $i <= $sssingle_nb; $i++) {
			if ($i == 0) {
				$ssname = 'sssingle';
				$ssid =  'sssingle_id';
			} else {
				$ssname = 'sssingle'.$i;
				$ssid =  'sssingle_id'.$i;
			}
			$ssname_value= trim($_POST[$ssname]);
			$ssid_value= $_POST[$ssid];
			if (($ssname_value !='') && ($ssname_value !='NULL') ) {
				$sssingle = $sssingle + array($ssname => $ssname_value, $ssid => $ssid_value);
				$found++;
				}
			
			}
			$sssingle = $sssingle + array('nb' => (int)$found);
			update_option('singsong_sssingle', $sssingle);

			$sspage = array();
			$found = 0;
			for ($i = 0; $i <= $sspage_nb; $i++) {
			if ($i == 0) {
				$ssname = 'sspage';
				$ssid =  'sspage_id';
			} else {
				$ssname = 'sspage'.$i;
				$ssid =  'sspage_id'.$i;
			}
			$ssname_value= trim($_POST[$ssname]);
			$ssid_value= $_POST[$ssid];
			if (($ssname_value !='') && ($ssname_value !='NULL') ) {
				$sspage = $sspage + array($ssname => $ssname_value, $ssid => $ssid_value);
				$found++;
				}
			
			}
			$sspage = $sspage + array('nb' => (int)$found);
			update_option('singsong_sspage', $sspage);


			$sshome= trim($_POST['sshome']);
			update_option('singsong_sshome', $sshome);

			$ssarchive = trim($_POST['ssarchive']);	
			update_option('singsong_ssarchive', $ssarchive);


			$volume = trim($_POST['volume']);	
			update_option('singsong_volume', $volume);

			$bloop = !isset($_POST['bloop'])? '0': '1';	
			update_option('singsong_bloop', $bloop);

			$nb = trim($_POST['nb']);
			$skin = trim($_POST['skin']);
			$skin_dir = trim($_POST['skin_dir']);
			$extra1 = trim($_POST['extra1']);
			$extra2 = trim($_POST['extra2']);
			$extra3 = trim($_POST['extra3']);
			$pwidth = trim($_POST['pwidth']);
			$pheight = trim($_POST['pheight']);	
			$wwidth = trim($_POST['wwidth']);
			$wheight = trim($_POST['wheight']);
			$bgc = trim($_POST['bgc']);			
			$bgi = trim($_POST['bgi']);
			$title = trim($_POST['title']);
			$loop = !isset($_POST['loop'])? '0': '1';	
			$auto = !isset($_POST['auto'])? '0': '1';	
			$but = trim($_POST['but']);	

			$player = array (
			'nb'=> $nb,
			'skin'=> $skin,
			'skin_dir'=> $skin_dir,
			'extra1' => $extra1,
			'extra2' => $extra2,
			'extra3' => $extra3,
			'pwidth' => $pwidth,
			'pheight' => $pheight,			
			'wwidth' => $wwidth,
			'wheight' => $wheight,
			'bgc' => $bgc,
			'bgi' => $bgi,
			'title' => $title,
			'loop' => $loop,
			'auto' => $auto,	
			'but' => $but
			);
			update_option('singsong_player', $player);

			$msg_status = 'SingSong options saved.';
							
		   _e('<div id="message" class="updated fade"><p>' . $msg_status . '</p></div>');
		
	} 
		$sshome = get_option('singsong_sshome');
		$ssarchive = get_option('singsong_ssarchive');

		$sssingle = get_option('singsong_sssingle');
		if (!is_array($sssingle) ) {
		$tab = array(
		'nb'=> 0,
		'sssingle'=> $sssingle,
		'sssingle_id'=> '');
		update_option('singsong_sssingle', $tab);
		$sssingle = get_option('singsong_sssingle');
		}		

		$sspage = get_option('singsong_sspage');
		if (!is_array($sspage) ) {
		$tab = array(
		'nb'=> 0,
		'sspage'=> $sspage,
		'sspage_id'=> '');
		update_option('singsong_sspage', $tab);
		$sspage = get_option('singsong_sspage');
		}	

		if (get_option('singsong_bloop') === false) add_option('singsong_bloop', '0');
		$bloop = (get_option('singsong_bloop')=='1') ? 'checked':'';


		if (get_option('singsong_volume') === false) add_option('singsong_volume', '100');
		$volume = get_option('singsong_volume');

		$player = get_option('singsong_player');
		if (( $player === false) || (!is_array($player) ) ) {
		$tab = array(
		'nb'=> 1,
		'skin'=> '0',
		'skin_dir'=> '',
		'extra1'=> '',
		'extra2'=> '',
		'extra3'=> '',
		'pwidth'=> '300',
		'pheight'=> '69',
		'wwidth'=> '400',
		'wheight'=> '200',
		'bgc'=> '#000000',
		'bgi'=> '',
		'title'=> 'Play Now',
		'loop'=> '0',
		'auto'=> '0',
		'but'=> '');
		update_option('singsong_player', $tab);
		$player = get_option('singsong_player');
		}


	global $wp_version;	
	global $wp_singsong_plugin_url;
	$actionurl=$_SERVER['REQUEST_URI'];
    // Configuration Page
    echo <<<END
<div class="wrap" style="max-width:950px !important;">
	<h2>SingSong $singsong_localversion</h2>
				
	<div id="poststuff" style="margin-top:10px;">
	
	<div id="sideblock" style="float:right;width:220px;margin-left:10px;"> 
		 <h3>Related</h3>

<div id="dbx-content" style="text-decoration:none;">
<ul>
<li><a style="text-decoration:none;" href="http://www.royakhosravi.com/?p=337">SingSong</a></li>
</ul><br />
</div>
 	</div>
	
	 <div id="mainblock" style="width:710px">
	 
		<div class="dbx-content">
		 	<form name="rkform" action="$action_url" method="post">
					<input type="hidden" name="submitted" value="1" /> 
<strong>Background Sound</strong><hr />
Please enter the full URL of an audio file (or playlist) for each section/post/page: 
<div>
<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">
END;
	$sssingle_nb = $sssingle['nb'];
	for ($i = 0; $i <= $sssingle_nb; $i++) {
	if ($i == 0) {
	$ssname = 'sssingle';
	$ssid =  'sssingle_id';
	} else {
	$ssname = 'sssingle'.$i;
	$ssid =  'sssingle_id'.$i;
	}
	$ssvalue = $sssingle[$ssname];
	$ssidval = $sssingle[$ssid];
	echo <<<END
  <tr>
    <td width="10%"><label for="$ssname">Single </label></td>
    <td width="20%"><input id="$ssname"  name="$ssname" value="$ssvalue" size="20"/></td>
    <td width="70%" align="left">
	<select name="$ssid"> 
  	<option value="">All Posts</option> 
END;
	$postslist = get_posts('order=ASC&orderby=date');
	foreach ($postslist as $post) :
	if ($post->ID == $ssidval) {$sel ='SELECTED ';} else {$sel ='';}
  	echo '<option '.$sel.'value="'.$post->ID . '">' . $post->post_title . '</option>';   
	endforeach;	
	echo <<<END
	</select>

  </td>
  </tr>
END;
}

	$sspage_nb = $sspage['nb'];
	for ($i = 0; $i <= $sspage_nb; $i++) {
	if ($i == 0) {
	$ssname = 'sspage';
	$ssid =  'sspage_id';
	} else {
	$ssname = 'sspage'.$i;
	$ssid =  'sspage_id'.$i;
	}
	$ssvalue = $sspage[$ssname];
	$ssidval = $sspage[$ssid];
	echo <<<END

  <tr>
    <td width="10%"><label for="$ssname">Page </label></td>
    <td width="20%"><input id="$ssname"  name="$ssname" value="$ssvalue" size="20"/></td>
    <td width="70%" align="left">
END;
	$params = array(
		'depth' => 0, 'child_of' => 0,
		'selected' => $ssidval, 'echo' => 1,
		'name' => $ssid, 'show_option_none' => 'All Pages'
	);
	wp_dropdown_pages($params);
	echo <<<END
  </td>
  </tr>
END;
}
	echo <<<END
  <tr>
    <td width="10%"><label for="sshome">Home </label></td>
    <td width="20%"><input id="sshome"  name="sshome" value="$sshome" size="20"/></td>
    <td width="70%" align="left">&nbsp;</td>
  </tr>

  <tr>
    <td width="10%"><label for="ssarchive">Archives </label></td>
    <td width="20%"><input id="ssarchive"  name="ssarchive" value="$ssarchive" size="20"/></td>
    <td width="70%" align="left">&nbsp;</td>
  </tr>


  <tr>
    <td width="10%"><label for="volume">Volume </label></td>
    <td width="20%"><input id="volume"  name="volume" value="$volume" size="20"/></td>
    <td width="70%" align="left">&nbsp;Volume between 0 (full volume) and -10000 (off)</td>
  </tr>

  <tr>
    <td width="10%"><label for="bloop">Loop ?</label></td>
    <td width="20%"><input id="bloop" type="checkbox" name="bloop" $bloop /></td>
    <td width="70%" align="left">&nbsp;</td>
  </tr>

</table>
</div>
<br />
<strong>Player</strong> <a target="_blank" href="$wp_singsong_plugin_url/help.txt">[Help]</a><hr />
<table border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">
END;
extract($player);
$loop = ($loop=='1') ? 'checked':'';
$auto = ($auto=='1') ? 'checked':'';
	echo <<<END
  <tr>
    <td width="20%"><label for="width">Player Dim. </label></td>
    <td width="80%" align="left"><input id="pwidth"  name="pwidth" value="$pwidth" size="7"/>&nbsp;&nbsp;&nbsp;X&nbsp;&nbsp;&nbsp;<input id="pheight"  name="pheight" value="$pheight" size="7"/>  Width X Height in pixel</td>
  </tr>

  <tr>
    <td width="20%"><label for="width">Popup Dim. </label></td>
    <td width="80%" align="left"><input id="wwidth"  name="wwidth" value="$wwidth" size="7"/>&nbsp;&nbsp;&nbsp;X&nbsp;&nbsp;&nbsp;<input id="wheight"  name="wheight" value="$wheight" size="7"/>  Width X Height in pixel</td>
  </tr>

  <tr>
    <td width="20%"><label for="bgc">Background </label></td>
    <td width="80%" align="left"><input id="bgc"  name="bgc" value="$bgc" size="7"/>&nbsp;&nbsp;OR&nbsp;&nbsp;<input id="bgi"  name="bgi" value="$bgi" size="20"/>  Color OR Image URL</td>
  </tr>

  <tr>
    <td width="20%"><label for="bgi">Link </label></td>
    <td width="80%" align="left"><input id="title"  name="title" value="$title" size="7"/>&nbsp;&nbsp;OR&nbsp;&nbsp;<input id="but"  name="but" value="$but" size="20"/>  Text OR Image URL</td>
  </tr>
  <tr>
    <td width="20%"><label for="loop">Loop ?</label></td>
    <td width="80%" align="left"><input id="loop" type="checkbox" name="loop" $loop /></td>
  </tr>

  <tr>
    <td width="20%"><label for="auto">Autoplay ?</label></td>
    <td width="80%" align="left"><input id="auto" type="checkbox" name="auto" $auto /></td>
  </tr>
</table>

<br>
<input type=hidden name="sspage_nb" value="$sspage_nb">
<input type=hidden name="sssingle_nb" value="$sssingle_nb">

<div class="submit"><input type="submit" name="Submit" value="Update options" /></div>
			</form>
		</div>
					
		<br/><br/><h3>&nbsp;</h3>	
	 </div>

	</div>
<h5>SingSong plugin by <a href="http://www.royakhosravi.com/">Roya Khosravi</a></h5>
</div>
END;
}
// Add Options Page
add_action('admin_menu', 'singsong_add_pages');

function singsong_check_content($the_content) {
	if(strpos($the_content, "[singsong-insert:")!==FALSE) {

		preg_match_all('/\[singsong-insert:([)a-zA-Z0-9\/:\.\|\-_\s%#]+)/', $the_content, $matches, PREG_SET_ORDER); 
		foreach($matches as $match) { 
		$the_content = preg_replace("/\[singsong-insert:([)a-zA-Z0-9\/:\.\|\-_\s%#]+)\]/", singsong_insert_tag($match[1]), $the_content,1);
		}
		
	} 
	if (strpos($the_content, "[singsong-popup:")!==FALSE) {

		preg_match_all('/\[singsong-popup:([)a-zA-Z0-9\/:\.\|\-_\s%#]+)/', $the_content, $matches, PREG_SET_ORDER); 
		foreach($matches as $match) { 
		$the_content = preg_replace("/\[singsong-popup:([)a-zA-Z0-9\/:\.\|\-_\s%#]+)\]/", singsong_popup_tag($match[1]), $the_content,1);
		}
		
	}



    return $the_content;
}


function singsong_check() {
	global $post;
	$sshome = get_option('singsong_sshome');
	$sssingle = get_option('singsong_sssingle');
	$sspage = get_option('singsong_sspage');
	$ssarchive = get_option('singsong_ssarchive');
	$bloop = get_option('singsong_bloop');
	if ($bloop === false) {
		$bloop = '0';
		update_option('singsong_bloop', $bloop);
	}
	$volume = get_option('singsong_volume');
	if ($volume === false) {
		$volume = '100';
		update_option('singsong_volume', $volume);
	}

	if ((!empty($sshome)) && (is_home())) insert_singsong_code($sshome,$bloop,$volume);
	if ((!empty($ssarchive)) && (is_archive())) insert_singsong_code($ssarchive,$bloop,$volume);
	if ((is_array($sssingle)) && (is_single())) {
		$sssingle_nb = $sssingle['nb'];
		for ($i = 0; $i <= $sssingle_nb; $i++) {
		if ($i == 0) {
		$ssname = 'sssingle';
		$ssid =  'sssingle_id';
		} else {
		$ssname = 'sssingle'.$i;
		$ssid =  'sssingle_id'.$i;
		}
		$ssvalue = $sssingle[$ssname];
		$ssidval = $sssingle[$ssid];
		if (($ssvalue != '')&&($ssidval=='')) break; /// all posts
		if ($post->ID == $ssidval) break; /// specific post 
		}
		if ($ssvalue != '') insert_singsong_code($ssvalue,$bloop,$volume);
	}
	if ((is_array($sspage)) && (is_page()))  {
		$sspage_nb = $sspage['nb'];
		for ($i = 0; $i <= $sspage_nb; $i++) {
		if ($i == 0) {
		$ssname = 'sspage';
		$ssid =  'sspage_id';
		} else {
		$ssname = 'sspage'.$i;
		$ssid =  'sspage_id'.$i;
		}
		$ssvalue = $sspage[$ssname];
		$ssidval = $sspage[$ssid];
		if (($ssvalue != '')&&($ssidval=='')) break; /// all pages
		if ($post->ID == $ssidval) break; /// specific page 
		}
		if ($ssvalue != '') insert_singsong_code($ssvalue,$bloop,$volume);
	}
}

function singsong_insert_tag($files) {
	$files = trim($files);
	$player = get_option('singsong_player');
	extract($player);
	$singsong_tag = insert_singsong_php_code($files, $loop, 50, $auto, $pwidth, $pheight);
	return $singsong_tag;
}

function insert_singsong_php_code($filepath, $bloop=0, $volume=100, $autostart=1, $width=0 ,$height=0,$bgcolor='#000000') {

	if ($autostart == 1 ) { 
		$autoplay="true"; 
	} else {
		$autoplay="false";
	}
	if ($bloop == 1 ) { 
		$loop = "true";
		$PlayCount = "1000";
	} else {
		$loop = "false";
		$PlayCount = "1";
	}

	$system = detect_me();
	if (strpos(strtolower($system),strtolower("windows"))!== false) {
		$visitorOS="Windows";
	} else {
		$visitorOS="Other";
	}
	$mimeType = "audio/mpeg"; 
	$objTypeTag = "application/x-mplayer2"; 
	$mimeType = get_mime_type($filepath);
	if ($visitorOS != "Windows") { 
	$objTypeTag = $mimeType; 
	}
	$singsong_tag = "";
$singsong_tag .= "<object width='" .$width. "' height='" .$height. "'>" . "\n";
$singsong_tag .= "<param name='src' value='" .$filepath. "'>" . "\n";
$singsong_tag .= "<param name='type' value='" .$objTypeTag. "'>" . "\n";
$singsong_tag .= "<param name='autostart' value='" .$autostart. "'>" . "\n";
$singsong_tag .= "<param name='showcontrols' value='1'>" . "\n";  
$singsong_tag .= "<param name='showstatusbar' value='1'>" . "\n";
$singsong_tag .= "<param name='loop' value='" .$loop. "'>" . "\n";
$singsong_tag .= "<param name='volume' value='" .$volume. "'>" . "\n";
$singsong_tag .= "<embed src ='" .$filepath. "' type='" .$objTypeTag. "' autoplay='" .$autoplay. "' autostart='" .$autostart. "' width='" .$width. "' height='" .$height. "' controller='1' showstatusbar='1' PlayCount ='" .$PlayCount. "' volume='" .$volume. "' loop='" .$loop. "' bgcolor='" .$bgcolor. "' kioskmode='true'>" . "\n";
$singsong_tag .= "</embed></object>" . "\n";

return $singsong_tag;

}
function get_mime_type($filepath) {
	$mimeType='';
	$ext = substr($filepath, strrpos($filepath, '.') + 1);
	switch($ext)
{

  case "m3u": 
    $mimeType = "audio/mpegurl";
    ///$mimeType = "audio/x-mpegurl";
    break;  
  case "asx": 
    $mimeType = "video/x-ms-asf";
    break;    
  case "asf": 
    $mimeType = "video/x-ms-asf";
    break;    
  case "wax": 
    $mimeType = "audio/x-ms-wax";
    break;    
  case "wvx": 
    $mimeType = "video/x-ms-wvx";
    break;    
  case "pls": 
    $mimeType = "audio/x-scpls";
    break;     
  case "smil": 
    $mimeType = "application/smil";
    break;    
  case "smi": 
    $mimeType = "application/smil";
    break;    
  case "wav":
    $mimeType = "audio/x-wav";
    break;    
  case "aif":
    $mimeType = "audio/x-aiff"; 
    break;       
  case "wma":
    $mimeType = "audio/x-ms-wma";
    break;    
  case "mid":
    $mimeType = "audio/mid";
    break;    
  case "mp3":
    $mimeType = "audio/mpeg";
    break;  
  case "aac":
    $mimeType = "audio/aac";
    break;  
  case "m4u":
    $mimeType = "video/x-mpegurl";
    break;    
  case "mp4":
    $mimeType = "video/x-mpeg";
    break;        
  case "wmv":
    $mimeType = "video/x-ms-wmv";
    break;     
  case "ogg":
    $mimeType = "application/ogg";
    break;     
  case "ra":
    $mimeType = "audio/x-pn-realaudio-plugin";
    break;    
  case "ram":
    $mimeType = "audio/x-pn-realaudio-plugin";
    break;    
  case "rm":
    $mimeType = "audio/x-pn-realaudio-plugin";
    break;    
  default:
    $mimeType = "application/x-mplayer2";
}
return $mimeType;
}

function singsong_popup_tag($files) {
	global $wp_singsong_plugin_url;
	$files = trim($files);
	$player = get_option('singsong_player');
	extract($player);
	$link = $wp_singsong_plugin_url.'/player.php?mode=popup&url='.$files;
	$singsong_tag = '';
	$singsong_tag .= '<a href="#" OnClick="window.open(\''.$link.'\',null, \'height='.$wheight.',width='.$wwidth.',status=yes,toolbar=no,menubar=no,location=no\')">';
	if ($but != '') {
	$singsong_tag .= '<img border="0" src="'.$but.'">';
	} else {
	$singsong_tag .= $title;
	}
	$singsong_tag .= '</a>';	
	return $singsong_tag;
}


function insert_singsong_code($filepath, $bloop=0, $volume=100, $autostart=1, $width=0 ,$height=0,$bgcolor='#000000',$echo=1) {

	if ($autostart == 1 ) { 
		$autoplay="true"; 
	} else {
		$autoplay="false";
	}
	if ($bloop == 1 ) { 
		$loop = "true";
		$PlayCount = "1000";
	} else {
		$loop = "false";
		$PlayCount = "1";
	}

/// vous voyez? vous voyez? je sais faire du javascript! (tape dans les mains et secoue la tête)
?>
<SCRIPT TYPE="text/javascript">
<!-- 
function get_mimeType(filepath) {
  var theExtension = filepath.substr(filepath.lastIndexOf('.')+1, 3); 
  switch(theExtension.toLowerCase())
{

  case "m3u": 
    mimeType = "audio/mpegurl";
    ///mimeType = "audio/x-mpegurl";
    break;  
  case "asx": 
    mimeType = "video/x-ms-asf";
    break;    
  case "asf": 
    mimeType = "video/x-ms-asf";
    break;    
  case "wax": 
    mimeType = "audio/x-ms-wax";
    break;    
  case "wvx": 
    mimeType = "video/x-ms-wvx";
    break;    
  case "pls": 
    mimeType = "audio/x-scpls";
    break;     
  case "smil": 
    mimeType = "application/smil";
    break;    
  case "smi": 
    mimeType = "application/smil";
    break;    
  case "wav":
    mimeType = "audio/x-wav";
    break;    
  case "aif":
    mimeType = "audio/x-aiff"; 
    break;       
  case "wma":
    mimeType = "audio/x-ms-wma";
    break;    
  case "mid":
    mimeType = "audio/mid";
    break;    
  case "mp3":
    mimeType = "audio/mpeg";
    break;  
  case "aac":
    mimeType = "audio/aac";
    break;  
  case "m4u":
    mimeType = "video/x-mpegurl";
    break;    
  case "mp4":
    mimeType = "video/x-mpeg";
    break;        
  case "wmv":
    mimeType = "video/x-ms-wmv";
    break;     
  case "ogg":
    mimeType = "application/ogg";
    break;     
  case "ra":
    mimeType = "audio/x-pn-realaudio-plugin";
    break;    
  case "ram":
    mimeType = "audio/x-pn-realaudio-plugin";
    break;    
  case "rm":
    mimeType = "audio/x-pn-realaudio-plugin";
    break;    
  default:
    mimeType = "application/x-mplayer2";
}
return mimeType;
}

	var visitorOS;
// Get Operating System 
	var isWin = navigator.userAgent.toLowerCase().indexOf("windows") != -1
	if (isWin) {
		visitorOS="Windows";
	} else {
		visitorOS="Other";
	}
	var filepath = "<?php echo $filepath; ?>";
	var width = "<?php echo $width; ?>";
	var height = "<?php echo $height; ?>";
	var bgcolor="<?php echo $bgcolor; ?>";
	var autostart ="<?php echo $autostart; ?>";
	var autoplay="<?php echo $autoplay; ?>";
	var loop = "<?php echo $loop; ?>";
	var PlayCount = "<?php echo $PlayCount; ?>";
	var volume = "<?php echo $volume; ?>";

	var mimeType = "audio/mpeg"; 
	var objTypeTag = "application/x-mplayer2"; 
	mimeType = get_mimeType(filepath);
	if (visitorOS != "Windows") { 
	objTypeTag = mimeType; 
	};
	var htmlPlayer = "";
htmlPlayer = htmlPlayer + "<object width='" + width + "' height='" + height + "'>";
htmlPlayer = htmlPlayer + "<param name='src' value='" + filepath + "'>";
htmlPlayer = htmlPlayer + "<param name='type' value='" + objTypeTag + "'>";
htmlPlayer = htmlPlayer + "<param name='autostart' value='" + autostart + "'>";
htmlPlayer = htmlPlayer + "<param name='showcontrols' value='1'>";  
htmlPlayer = htmlPlayer + "<param name='showstatusbar' value='1'>";
htmlPlayer = htmlPlayer + "<param name='loop' value='" + loop + "'>";
htmlPlayer = htmlPlayer + "<param name='volume' value='" + volume + "'>";
htmlPlayer = htmlPlayer + "<embed src ='" + filepath + "' type='" + objTypeTag + "' autoplay='" + autoplay + "' autostart='" + autostart + "' width='" + width + "' height='" + height + "' controller='1' showstatusbar='1' PlayCount ='" + PlayCount + "' volume='" + volume + "' loop='" + loop + "' bgcolor='" + bgcolor + "' kioskmode='true'>";
htmlPlayer = htmlPlayer + "</embed></object>";
document.writeln (htmlPlayer);
// -->
</SCRIPT>
<?php
}	

function singsong_install(){
    if(!get_option('singsong_sssingle')) add_option('singsong_sssingle', '');  
    if(!get_option('singsong_sshome')) add_option('singsong_sshome', '');
    if(!get_option('singsong_sspage')) add_option('singsong_sspage', '');
    if(!get_option('singsong_ssarchive')) add_option('singsong_ssarchive', '');
    if(!get_option('singsong_bloop')) add_option('singsong_bloop', '0');
    if(!get_option('singsong_volume')) add_option('singsong_volume', '100');
    if(!get_option('singsong_player')) add_option('singsong_player', '');
}

function singsong_uninstall(){
    delete_option('singsong_sssingle');  
    delete_option('singsong_sshome');
    delete_option('singsong_sspage');
    delete_option('singsong_ssarchive');
    delete_option('singsong_bloop');
    delete_option('singsong_volume');
    delete_option('singsong_player');
}

if (isset($_GET['activate']) && $_GET['activate'] == 'true') {
    singsong_install();
}

if ((isset($_GET['deactivate']) && $_GET['deactivate'] == 'true')||(isset($_POST['deactivate']) && $_POST['deactivate'] == 'true')) {
    singsong_uninstall();
}

add_filter('wp_head', 'singsong_check');
add_filter('the_content', 'singsong_check_content', 10);
add_action( 'plugins_loaded', 'singsong_install' );
add_action( 'after_plugin_row', 'singsong_check_plugin_version' );
function singsong_getinfo()
{
		$checkfile = "http://www.royakhosravi.com/pub/SingSong_wordpress_plugin_version.txt";
		
		$status=array();
		return $status;
		$vcheck = wp_remote_fopen($checkfile);
				
		if($vcheck)
		{
			$version = $singsong_localversion;
									
			$status = explode('@', $vcheck);
			return $status;				
		}					
}

function singsong_check_plugin_version($plugin)
{
	global $plugindir,$singsong_localversion;
	
 	if( strpos($plugin,'singsong.php')!==false )
 	{
			

			$status=singsong_getinfo();
			
			$theVersion = $status[1];
			$theMessage = $status[3];	
	
			if( (version_compare(strval($theVersion), strval($singsong_localversion), '>') == 1) )
			{
				$msg = 'Latest version available '.' <strong>'.$theVersion.'</strong><br />'.$theMessage;				
				echo '<td colspan="5" class="plugin-update" style="line-height:1.2em;">'.$msg.'</td>';
			} else {
				return;
			}
		
	}
}
/// à une prochaine fois pour de nouvelles aventures ... dit la pippi longstocking
?>
