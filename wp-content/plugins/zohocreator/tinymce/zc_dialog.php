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
		<script type="text/javascript"src="https://creator.zoho.com/api/allformsandviews/variable=a"></script>
		<script language="javascript" type="text/javascript">		
				var apps = new Array();
				var keyValuePair ="";
				var ed = parent.tinymce.editors[0];
			ed.windowManager.windows[0].close();
				function deselectRadio()
				{
					var radList = document.getElementsByName('formOrView');
					if(document.frm.formOrView[0].checked || document.frm.formOrView[1].checked)
					{
						for (var i = 0; i < radList.length; i++) {
						if(radList[i].checked) radList[i].checked = false;
						}
						document.getElementById("viewOpt").style.display = "none";
						document.getElementById("formOpt").style.display = "none";
					}
					else 
					{
						radList[0].checked = true;
						document.getElementById("formOrView").style.display="";
						document.getElementById("viewOpt").style.display = "none";
						document.getElementById("formOpt").style.display = "";
						formsandviews("form");
					}
				}
				
				
				function applications()
				{
					var len = a.result.applications.length;
					sel = document.getElementById("appname");
					for(i = 0; i < len;i++){
						var opt = document.createElement("option");
						opt.text = a.result.applications[i].appname;
						opt.value = a.result.applications[i].linkname;
						var formObject = a.result.applications[i].forms;
						var viewObject = a.result.applications[i].views;
						sel.options.add(opt);
						var formsAndViews = new Array();
						formsAndViews[0]=formObject;
						formsAndViews[1]=viewObject;
						keyValuePair = opt.value;
						apps[keyValuePair] = formsAndViews;						
					}	
					var radList = document.getElementsByName('formOrView');
					for (var i = 0; i < radList.length; i++) {
						if(radList[i].checked) radList[i].checked = false;
					}
					
				}

				function formsandviews(val){
					var applinkname = document.getElementById("appname").value;
					if(applinkname == "-Select-")
					{
						alert("Please select an application name");
						var radList = document.getElementsByName('formOrView');
						for (var i = 0; i < radList.length; i++) {
							if(radList[i].checked) radList[i].checked = false;
						}
					}
					else
					{
						if(val=="form"){
							var formObject =apps[applinkname][0];
							createOptions(formObject, "formName");
							showForm();
						}
						else{
							var viewObject = apps[applinkname][1];
							createOptions(viewObject, "viewName");	
							showView();							
						}	
					}
				}
				function createOptions(Obj, id)
				{
					var sel = document.getElementById(id);
					sel.innerHTML = "";
					var len = Obj.length;	
					for(i = 0 ; i < len ; i++){
						var createOpt = document.createElement("option");
						createOpt.text = Obj[i].displayname;
						createOpt.value =  Obj[i].componentname;
						sel.options.add(createOpt);
					}
				}
				function showForm(){
					
					document.getElementById("formOpt").style.display = "";
					document.getElementById("viewOpt").style.display = "none";
				}
				function showView(){
					document.getElementById("formOpt").style.display = "none";
					document.getElementById("viewOpt").style.display = "";					
				}
				function zc_submit()
				{
					var apps = document.getElementById("appname").value;
					if(apps == "-Select-")
					{
						alert("Please select an application");
					}
					else
					{
						var username = a.result.applicationowner;
						var appname = document.getElementById("appname").value;
						var compid = "formName";
						var name_embed = "form-embed";
						
						if(document.frm.formOrView[0].checked){
							name_embed = "form-embed";
							compid = "formName";
						}
						else{
							name_embed = "view-embed";
							compid = "viewName";
						}
						
						var compName = document.getElementById(compid).value;
						var urlBuild = "http://creator.zoho.com/"+username+"/"+appname+"/"+name_embed+"/"+compName+"/";	
						var w = document.getElementById('width');
						var h = document.getElementById('height');
						var hbg_color = document.getElementById('hbg');
						var fbg_color = document.getElementById('fbg');
						var bg_color = document.getElementById('fobg');
						var tag = '[creator src=';
						tag += urlBuild;
						if(bg_color.value!="")
						{
							tag += ' bg=';
							tag += bg_color.value;
						}
						if(hbg_color.value!="")
						{
							tag += ' hdbg=';
							tag += hbg_color.value;
						}
						if(fbg_color.value!="")
						{
							tag += ' fbg=';
							tag += fbg_color.value;	
						}
						tag += ' width=';
						tag += w.value;
						tag += ' height=';
						tag += h.value;
						tag += '/]';		
						if(window.tinyMCE){
							var tmce_ver=window.tinyMCE.majorVersion;
			
							if (tmce_ver>="4") {
								window.tinyMCE.execCommand('mceInsertContent', false, tag);
							}
							else
							{
								window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, tag);
							}
							tinyMCEPopup.editor.execCommand('mceRepaint');
							tinyMCEPopup.close();
						}
						return;
					}
				}
				function exit(){
					if(window.tinyMCE){
					tinyMCEPopup.close();
					}
				}
			</script>
			<style type="text/css">
				.size {font-size : 12px;}
				.head1{padding-top:5px;padding-bottom:5px;}
				.head2{padding-top:15px;padding-bottom:5px;}
		</style>

     </head>
     <body onload="applications()">
	    <form methor="post" name="frm" id="frm" action="">
			<b>
			<table width="90%" cellspacing="5" cellpadding="3" border="0">
				<tr>
					<td colspan="3">
					<h3 class="head1">Embed your Zoho Creator Form </h3>
					</td>
				</tr>
				<tr>
					<td class="size">Choose Your Application</td>
					<td class="size">:</td>
					<td>
						<select id="appname"onchange="deselectRadio()" style="width: 250px">
							<option>-Select-</option>
						</select>
					</td>
				</tr>	
				<tr id="formOrView" style="display:none">
							
					<td class="size">Select the Form/View</b></td>
					<td>:</td>
					<td>
						<input onchange="formsandviews(value)" type="radio" name="formOrView" value="form" id="form"/>Form
						<input onchange="formsandviews(value)" type="radio" name="formOrView" value="view" id="view"/>View
					</td>
				</tr>
				<tr id="formOpt" style="display:none">
							
					<td class="size">Select the Form</td>
					<td class="size">:</td>
					<td>
							<select id="formName" style="width: 250px">
								<option>-Select-</option>
							</select>
					</td>
							
				</tr>
				<tr id="viewOpt" style="display:none">				
					<td class="size" >Select the View</td>
					<td class="size">:</td>
					<td>
							<select id="viewName" style="width: 250px">
									<option>-Select-</option>
							</select>
						
					</td>			
				</tr>
				<tr>
					<td class="size"> Width </td> 
					<td class="size"> : </td>
					<td>
						<input type="text" value="100%" id="width">
					</td>
				</tr>
				<tr>
					<td class="size">Height </td>
					<td class="size"> :</td>
					<td> 
						<input type="text" value ="600px" id="height">
					</td>
				</tr>
				<tr>
					<td colspan="3"><h3 class="head2">Customize your Form background</h3></td>
				</tr>
				<tr>
					<td class="size">Header BG color (Optional)</td>
					<td class="size">:</td>
					<td> 
						<input type="text" id="hbg">
					</td>
				</tr>
				<tr>
					<td class="size">Footer BG color &nbsp;(Optional)</td>
					<td class="size"> :</td>
					<td>
						<input type="text" id="fbg">
					</td>
				</tr>
				<tr>
					<td class="size">Form BG color &nbsp;&nbsp;&nbsp;(Optional)</td>
					<td class="size"> :</td>
					<td> 
						<input type="text" id="fobg">
					</td>
				</tr>
			</table>
			<div style="position:absolute;top:90%;left:32%">
				<input type="submit" value="Insert URL"  onclick="zc_submit();return false;">
			</div>
			<div style="position:absolute;top:90%;left:46%">
				<input type="submit" value="Cancel" onclick="exit();">
			</div>
			</b>
		</form>
	</body>
</html>

