<?php
//Creating the TinyMCe window with the field for url field.
require_once dirname(__FILE__).'/../zc_config.php';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
	<head>
	<title>Zoho Creator</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/tiny_mce_popup.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/utils/mctabs.js"></script>
	<script language="javascript" type="text/javascript" src="<?php echo get_option('siteurl') ?>/wp-includes/js/tinymce/utils/form_utils.js"></script>
	<script language="javascript" type="text/javascript">
		var ed = parent.tinymce.editors[0];
		ed.windowManager.windows[0].close();
		function exit(){				
				if(window.tinyMCE){
					window.open("https://www.zoho.com/creator/login.html");
					tinyMCEPopup.close();
				}				
			}
	</script>
	</head>
	<body>
			<div style="position:absolute;top:20%;left:5%">Please Sign in to use the plugin.</div>
			<form>
				<div style="position:absolute;top:59%;left:37%">
					<a onclick="exit()"><input type="button" value="Sign in"></a>
				</div>
			</form>
	</body>
</html>
