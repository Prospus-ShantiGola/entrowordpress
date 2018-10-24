<?php
	/*
	-------------------------------
	--- DO NOT MODIFY THIS FILE ---
	-------------------------------

	Rather, make a copy of the file and modify that file for your use because this file will get updated
	with each new versions.  This script is meant for direct access to chat by providing the
	needed variables and redirecting to the chat starting process.

	*/
	include_once( "./web/config.php" ) ;
	/***********************************
	/* the API_KEY can be found at the Setup Admin -> Extras -> Dev APIs
	/*
	/*    * for security, if invalid or blank API_KEY, the script will not process
	/*
	***********************************/
	$API_KEY = "" ;




	/*********************************************/
	/* REQUIRED variables begin ******************/

	/* If you prefer, the values can also be fetched from $_GET or $_POST but you'll need to implement that */

	/***********************************
	/* deptID ($deptid) values are located at Setup Admin -> Operators -> Assign Operator to Department
	/*    [ IMPORTANT ] if the $deptid is set to ZERO or is an invalid deptID, the
	/*                  the system will attempt to locate the deptID from the below $opid (if provided and valid)
	/*
	/*    [ IMPORTANT ] if both the $deptid AND the below $opid is invalid, the system will
	/*                  automatically redirect the visitor to the standard chat request window that
	/*                  lists all the available departments
	***********************************/
	$deptid = 0 ;

	/************************************
	/* opID ($opid) values are located at Setup Admin -> Operators -> Assign Operator to Department
	/*    [ IMPORTANT ] if invalid $opid or operator is offline or the operator is not available, system will
	/*                  automatically route the chat to the next available department online operator(s)
	/*
	/*    [ IMPORTANT ] if the operator is not assigned to the above $deptid, the system will
	/*                  automatically select the operator's first assigned department (online) result for
	/*                  the $deptid, overriding the above set $deptid
	/*
	/*    * set to ZERO or an invalid ID to inactivate and to process normal chat routing to
	/*    * all above $deptid operators
	************************************/
	$opid = 0 ;

	/************************************
	/* $_GET/$_POST to capture the values or provide the values directly
	************************************/
	$vname = ( isset( $_GET["vname"] ) && $_GET["vname"] ) ? $_GET["vname"] : "Visitor Name" ;
	$vemail = ( isset( $_GET["vemail"] ) && $_GET["vemail"] ) ? $_GET["vemail"] : "visitor@interwebs-location.com" ;

	/********************************************
	/* additional custom validation, redirects, etc can be done such as
	/* validating your custom values passed, formatting the question, updating your
	/* database, etc.
	/*
	/* example:
	/*
	/* if ( !Your_Function_Client_Validate( $vemail ) )
	/* { HEADER( "location: http://www.your_domain_llc_co_ent.com/oops_did_not_validate.html ) ; exit ; }
	/* else { $your_var = Your_Function_Fetch_Client_Info( $vemail ) ; }
	/*
	/* $vquestion = "Client ID: $your_var[clientID]\r\nQuestion: $vquestion" ;
	********************************************/

	$vquestion = ( isset( $_GET["vquestion"] ) && $_GET["vquestion"] ) ? $_GET["vquestion"] : "This is the question." ;

	/* REQUIRED variables end *******************/
	/********************************************/




	/************************************
	/* (optional) custom variables are automatically formatted to display on the operator console and is stored to the system
	/*    * each custom variable must have a name and the value
	/*
	/*    [ NOTE ] $custom_vars is a one line string with the following delimiter to signify each custom variable
	/*
	/*    * the -_- is a marker that indicates the custom variable name and its value (example: name-_-value)
	/*    * the -cus- is a separator for each custom variable (example: name1-_-value1-cus-name2-_-value2)
	/*
	/* Manual format structure:
	/* $custom_vars = "custom_var_name1"."-_-"."custom_var_value1"."-cus-"."custom_var_name2"."-_-"."custom_var_value2"."-cus-" ;
	/*
	/* To pass the ticketid to prefill a custom field, the URL should pass the value (not the name).  The
	/* formatting of the custom string can prefill the value to the custom field name (example below)
	/*
	************************************/

	//$ticketid = ( isset( $_GET["ticketid"] ) && $_GET["ticketid"] ) ? $_GET["ticketid"] : "12345" ;
	//$login = ( isset( $_GET["login"] ) && $_GET["login"] ) ? $_GET["login"] : "the_login" ;
	//$custom_vars = "Ticket ID-_-$ticketid-cus-Login-_-$login" ;






































	/*********************************
	/*
	/* DO NOT MODIFY BELOW THIS LINE
	/*
	*********************************/
	$on = 0 ; if ( isset( $API_KEY ) && isset( $CONF['API_KEY'] ) && ( $CONF['API_KEY'] == $API_KEY ) ) { $on = 1 ; }
	if ( !$deptid && !$opid ) { $on = 0 ; }

	$onpage = "livechatimagelink" ; // this string indicates a direct link (do not modify)
	$title= "Live Chat Direct Link" ; // this string indicates a direct link (do not modify)
	$onpage = urlencode( $onpage ) ;
	$title = urlencode( $title ) ;
	$vname = urlencode( $vname ) ;
	$vemail = urlencode( $vemail ) ;
	$vquestion = urlencode( $vquestion ) ;
	$custom = isset( $custom_vars ) ? rawurlencode( $custom_vars ) : "" ;
	$query = "&popout=1&deptid=$deptid&opid=$opid&onpage=$onpage&title=$title&vname=$vname&vemail=$vemail&custom=$custom&vquestion=$vquestion" ;
?>
<?php include_once( "./inc_doctype.php" ) ?>
<head>
<title> o_O </title>
<meta name="description" content="Fetch Chat Direct">
<meta http-equiv="content-type" content="text/html; CHARSET=utf-8"> 
<?php include_once( "./inc_meta_dev.php" ) ; ?>

<?php if ( $on ) : $now = time() ; ?>
<script data-cfasync="false" type="text/javascript" src="./js/jquery_md5.js?<?php echo $VERSION ?>"></script>
<script data-cfasync="false" type="text/javascript">
<!--
	var phplive_browser = navigator.appVersion ; var phplive_mime_types = "" ;
	var phplive_display_width = screen.availWidth ; var phplive_display_height = screen.availHeight ; var phplive_display_color = screen.colorDepth ; var phplive_timezone = new Date().getTimezoneOffset() ;
	if ( navigator.mimeTypes.length > 0 ) { for (var x=0; x < navigator.mimeTypes.length; x++) { phplive_mime_types += navigator.mimeTypes[x].description ; } }
	var phplive_browser_token = phplive_md5( phplive_display_width+phplive_display_height+phplive_display_color+phplive_timezone+phplive_browser+phplive_mime_types ) ;

	var win_width = screen.width ;
	var win_height = screen.height ;
	var win_dim = win_width + " x " + win_height ;
	location.href = "./phplive_.php?token="+phplive_browser_token+"&win_dim="+win_dim+"<?php echo $query ?>&<?php echo $now ?>" ;
//-->
</script>
<?php endif ; ?>

</head>
<body style="padding: 25px; font-family: arial; font-size: 12px;">
	<div style="background: #FD7D7F; border: 1px solid #E16F71; padding: 5px; color: #FFFFFF; -moz-border-radius: 5px; border-radius: 5px;">Invalid API Key or the $deptid AND $opid is not set.</div>
	<div style="margin-top: 15px;">Double check the file <code>fetch_direct.php</code> for the configuration procedures.</div>
</body>
</html>