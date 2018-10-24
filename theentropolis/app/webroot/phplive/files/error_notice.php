<!DOCTYPE html>
<html lang="en-US">
<head>
<title> Live Chat Temporarily Unavailable </title>
<meta http-equiv="content-type" content="text/html; CHARSET=utf-8"> 
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="background: #F6F3F3; margin: 0; padding: 0; overflow: auto; font-family: Arial; font-size: 12px; color: #524F4F;">
<div style="padding: 10px;">
	<div style="font-size: 18px; font-weight: bold; color: #FD7D7F;">Live Chat Temporarily Unavailable</div>
	<div style="margin-top: 10px; background: #FD7D7F; border: 1px solid #E16F71; padding: 5px; color: #FFFFFF; -moz-border-radius: 10px; border-radius: 10px;">
		<table cellspacing=0 cellpadding=2 border=0>
		<tr>
			<td><div style="background: #FFFFFF; color: #524F4F; padding: 5px; -moz-border-radius: 5px; border-radius: 5px;">File</div></td>
			<td>%file%</td>
		</tr>
		<tr>
			<td><div style="background: #FFFFFF; color: #524F4F; padding: 5px; -moz-border-radius: 5px; border-radius: 5px;">Line #</div></td>
			<td>%line%</td>
		</tr>
		<tr>
			<td><div style="background: #FFFFFF; color: #524F4F; padding: 5px; -moz-border-radius: 5px; border-radius: 5px;">Error</div></td>
			<td>%error%</td>
		</tr>
		</table>
	</div>
	<div style="margin-top: 15px;">
		<div id="solution_default" style="">
			Live chat has detected an error.  Please notify the website admin%admin%.
			<div style="margin-top: 15px;"><span style="">If you are the website admin <a href="%solution%" target="_blank" style="color: #727272">click here to check for solutions</a>.</span></div>
		</div>
		<div id="solution_mapp" style="display: none;">
			The live chat software has detected an error.  Please notify the website admin%admin%.  Once fixed, <a href="JavaScript:void(0)" onClick="do_refresh()">refresh this page</a>.
		</div>
	</div>

<script data-cfasync="false" type="text/javascript">
<!--
	var error_loaded = 1 ;
	var href = location.href ;

	function show_mapp_error() { document.getElementById("solution_default").style.display = "none" ; document.getElementById("solution_mapp").style.display = "block" ; }
	function do_refresh()
	{
		document.getElementById("solution_mapp").innerHTML = '<img src="%base_url%/pics/loading_ci.gif" width="16" height="16" border="0" alt="">' ;
		setTimeout( function(){ location.href = href ; }, 1000 ) ;
	}
//-->
</script>

</div>
</body>
</html>