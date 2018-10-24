<?php
	$CONF = Array() ;
$CONF['DOCUMENT_ROOT'] = addslashes( '/var/www/html/theentropolis/app/webroot/phplive' ) ;
$CONF['BASE_URL'] = '//theentropolis.com/app/webroot/phplive' ;
$CONF['SQLTYPE'] = 'SQLi.php' ;
$CONF['SQLHOST'] = 'localhost' ;
$CONF['SQLLOGIN'] = 'root' ;
$CONF['SQLPASS'] = 't#3en+r0' ;
$CONF['DATABASE'] = 'trepicity' ;
$CONF['THEME'] = 'default' ;
$CONF['TIMEZONE'] = 'Australia/Melbourne' ;
$CONF['icon_online'] = '' ;
$CONF['icon_offline'] = '' ;
$CONF['lang'] = 'english' ;
$CONF['logo'] = '' ;
$CONF['CONF_ROOT'] = '/var/www/html/theentropolis/app/webroot/phplive/web' ;
$CONF['UPLOAD_HTTP'] = '//theentropolis.com/app/webroot/phplive/web' ;
$CONF['UPLOAD_DIR'] = '/var/www/html/theentropolis/app/webroot/phplive/web' ;
$CONF['ATTACH_DIR'] = '/var/www/html/theentropolis/app/webroot/phplive/web/file_attach' ;
$CONF['geo'] = '1' ;
$CONF['SALT'] = 'd3dexrsbn9' ;
$CONF['API_KEY'] = 'kmbeth7sdu' ;
	if ( phpversion() >= '5.1.0' ){ date_default_timezone_set( $CONF['TIMEZONE'] ) ; }
	include_once( "$CONF[DOCUMENT_ROOT]/API/Util_Vars.php" ) ;
?>