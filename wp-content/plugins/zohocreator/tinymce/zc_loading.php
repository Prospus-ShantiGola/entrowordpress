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
		
		var a="";
		if(window.tinyMCE){var url = tinyMCEPopup.getWindowArg("plugin_url");}
		function load()
		{
			document.getElementById('image').src = url+'/loader.gif';
		}
		</script>
	</head>	
	<body>
		<div style="position:absolute;top:30%;left:35%;font-size : 12px;">Loading ...</div>
		<div style="position:absolute;top:55%;left:35%"><img id ="image" src="loader.gif"></div>
		
		<script type="text/javascript" src="https://creator.zoho.com/api/allformsandviews/variable=a"></script>
		<script language="javascript" type="text/javascript">
		
				if(a == "")
				{
						if(window.tinyMCE){
							tinymce.activeEditor.windowManager.open({
							file : url+'/zc_popup.php',
							title : 'Zoho Creator',
							width : 200, 
							height : 80,
							resizable : "yes",
							inline : "yes", 
							close_previous : "yes"
							});
						}										
				}
				else
				{
					if(window.tinyMCE){
						tinymce.activeEditor.windowManager.open({
						file : url+'/zc_dialog.php',
						title : 'Zoho Creator',
						width : 600, 
						height : 365,
						inline :1
						});
					}
				}
		</script>
	</body>
	</html>