<?php
/*
Plugin Name: SingSong
Plugin URI: http://www.royakhosravi.com/?p=337
Description:  SingSong Wordpress plugin allows you to add a background sound or music to each section of your Blog (Home, Single, Page, Archive).
Author: Roya Khosravi
Version: 1.0
Author URI: http://www.royakhosravi.com/

Updates:
-none

To-Doo:
-none
*/

$singsong_localversion="1.0";
$wp_singsong_plugin_url = trailingslashit( get_bloginfo('wpurl') ).PLUGINDIR.'/'. dirname( plugin_basename(__FILE__) );
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



			$sshome= trim($_POST['sshome']);
			update_option('singsong_sshome', $sshome);

			$sssingle= trim($_POST['sssingle']);
			update_option('singsong_sssingle', $sssingle);

			$sspage= trim($_POST['sspage']);	
			update_option('singsong_sspage', $sspage);

			$ssarchive = trim($_POST['ssarchive']);	
			update_option('singsong_ssarchive', $ssarchive);
				
			$msg_status = 'SingSong options saved.';
							
		   _e('<div id="message" class="updated fade"><p>' . $msg_status . '</p></div>');
		
	} 

		$sshome = get_option('singsong_sshome');
		$sssingle = get_option('singsong_sssingle');
		$sspage = get_option('singsong_sspage');
		$ssarchive = get_option('singsong_ssarchive');

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
						<h3>Usage</h3>                         
<p>SingSong Wordpress plugin allows you to add a background sound or music to each section of your Blog (Home, Single, Page, Archive)</p>
<h3>Settings</h3>
Please enter the full URL of an audio file (or playlist) for each section: 
<div><label for="sshome">Home : </label><input id="sshome"  name="sshome" value="$sshome" size="20"/></div>
<div><label for="sssingle">Single : </label><input id="sssingle"  name="sssingle" value="$sssingle" size="20"/></div>
<label for="sspage">Page : </label><input id="sspage"  name="sspage" value="$sspage" size="20"/></div>
<div><label for="ssarchive">Archives : </label><input id="ssarchive"  name="ssarchive" value="$ssarchive" size="20"/></div>
<br>
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
function singsong_check() {
	$sshome = get_option('singsong_sshome');
	$sssingle = get_option('singsong_sssingle');
	$sspage = get_option('singsong_sspage');
	$ssarchive = get_option('singsong_ssarchive');
	if ((!empty($sshome)) && (is_home())) insert_singsong_code($sshome);
	if ((!empty($sssingle)) && (is_single())) insert_singsong_code($sssingle);
	if ((!empty($sspage)) && (is_page()))  insert_singsong_code($sspage); 
	if ((!empty($ssarchive)) && (is_archive())) insert_singsong_code($ssarchive);
}


function insert_singsong_code($filepath) {

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
	var mimeType = "audio/mpeg"; 
	var objTypeTag = "application/x-mplayer2"; 
	mimeType = get_mimeType(filepath);
	if (visitorOS != "Windows") { 
	objTypeTag = mimeType; 
	};
	var htmlPlayer = "";
htmlPlayer = htmlPlayer + "<object width='0' height='0'>";
htmlPlayer = htmlPlayer + "<param name='src' value='" + filepath + "'>";
htmlPlayer = htmlPlayer + "<param name='type' value='" + objTypeTag + "'>";
htmlPlayer = htmlPlayer + "<param name='autostart' value='1'>";
htmlPlayer = htmlPlayer + "<param name='showcontrols' value='1'>";  
htmlPlayer = htmlPlayer + "<param name='showstatusbar' value='1'>";
htmlPlayer = htmlPlayer + "<embed src ='" + filepath + "' type='" + objTypeTag + "' autoplay='true' width='0' height='0' controller='1' showstatusbar='1' bgcolor='#9999ff' kioskmode='true'>";
htmlPlayer = htmlPlayer + "</embed></object></div>";
document.writeln (htmlPlayer);
// -->
</SCRIPT>
<?php
}	

function singsong_install(){
    add_option('singsong_sssingle', '');
    add_option('singsong_sshome', '');
    add_option('singsong_sspage', '');
    add_option('singsong_ssarchive', '');
}

if (isset($_GET['activate']) && $_GET['activate'] == 'true') {
    singsong_install();
}

add_filter('wp_head', 'singsong_check');
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
?>
