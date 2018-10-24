<?php

/*

CometChat
Copyright (c) 2016 Inscripts
License: https://www.cometchat.com/legal/license

*/

if (!defined('CCADMIN')) { echo "NO DICE"; exit; }

function index() {
	global $body, $currentversion, $client, $ts, $livesoftware, $marketplace, $plan, $planInfo,$planId,$licensekey,$accessKey,$planName;

	$fetchtime = time()-60*60*24;

	$last24hours = 	'selected';
	$last30days = $alltime = '';
	$rangelist = array('last24hours','last30days','alltime');
	if (!in_array($_REQUEST['report'], $rangelist)) {
		$_REQUEST['report'] = 'last24hours';
	}
	if (!empty($_REQUEST['report']) && $_REQUEST['report'] == 'last30days'){
		$last30days = 	'selected';
		$last24hours = $alltime = '';
		$fetchtime = time()-60*60*24*30;
	}
	if (!empty($_REQUEST['report']) && $_REQUEST['report'] == 'alltime'){
		$alltime = 	'selected';
		$last24hours = $last30days = '';
		$fetchtime = '';
	}
	$available_version = setConfigValue('LATEST_VERSION','');
	if(cc_version_compare($available_version , $currentversion) < 1){
		$available_version = '';
	}

	$stats = '';
	$showplan = '';
	if (!empty($_GET['d'])) {
		header("Location: ".ADMIN_URL."\r\n");
		exit;
	}

	$range = "In The Last 24 Hours";
	if($_REQUEST['report'] == "last24hours"){
		$messagequery = sql_query('admin_getlast24hoursMessageCount',array('sent'=>$fetchtime));
		$guestquery = sql_query('admin_getlast24hoursActiveGuestsCount',array('sent'=>$fetchtime, 'firstguestid'=>$GLOBALS['firstguestID']));
	}elseif ($_REQUEST['report'] == "last30days") {
		$messagequery = sql_query('admin_getlast30daysMessageCount',array('sent'=>$fetchtime));
		$guestquery = sql_query('admin_getlast30daysActiveGuestsCount',array('sent'=>$fetchtime, 'firstguestid'=>$GLOBALS['firstguestID']));
		$range = "In The Last 30 Days";
	}else{
		$messagequery = sql_query('admin_getAllMessageCount',array());
		$guestquery = sql_query('admin_getAllGuestsCount',array('sent'=>$fetchtime));
		$range = "Till Now";
	}
	if (!empty($fetchtime)){
		$query = sql_query('getuserchatings',array('sent'=>$fetchtime));
	}else{
		$query = sql_query('get_all_userchatings',array('sent'=>$fetchtime));
	}
	$chat = sql_fetch_assoc($query);
	$onlineusers = !empty($chat['users'])?$chat['users']:0;

	$getMesseageCount = sql_fetch_assoc($messagequery);
	$totalmessagest = !empty($getMesseageCount['totalmessages'])?$getMesseageCount['totalmessages']:0;

	$getActiveGuestsCount = sql_fetch_assoc($guestquery);
	$activeguests = !empty($getActiveGuestsCount['activeguests'])?$getActiveGuestsCount['activeguests']:0;


	// start: getActiveUsersCount
	$query = sql_query('admin_getActiveUsersCount',array('sent'=>$fetchtime, 'firstguestid'=>$GLOBALS['firstguestID']));
	$getActiveUsersCount = sql_fetch_assoc($query);
	$activeusers = !empty($getActiveUsersCount['activeusers'])?$getActiveUsersCount['activeusers']:0;
	// end: getActiveUsersCount

	$warningMsg = '';
	if ( ADMIN_USER == 'cometchat' && ADMIN_PASS == 'cometchat' && empty($client)) {
		$warningMsg = <<<EOD
		<div class="col-sm-12 col-lg-12">
			<div class="card card-inverse card-danger">
				<div class="pb-0" style="padding:16px;">
					<p>Warning: Default login detected, this is a security risk. Please update your login information in the Settings  -> General tab.</p>
				</div>
			</div>
		</div>
EOD;
	}else if(!preg_match('/^[0-9a-f]{40}$/i', ADMIN_PASS) && empty($client)){
		$warningMsg = <<<EOD
		<div class="col-sm-12 col-lg-12">
			<div class="card card-inverse card-danger">
				<div class="pb-0" style="padding:16px;">
					<p>Warning: Our login mechanism has been enhanced. To make your Admin Panel safer, please update your login information in the Settings -> General tab</p>
				</div>
			</div>
		</div>
EOD;
	}

	if (empty($totalmessages)) {
		$totalmessages = 0;
	}

	$cc_version_class = 'card-success';
	$acc_version_class = 'card-primary';
	if ($available_version != '') {
		$cc_version_class  = 'card-danger';
		$acc_version_class = 'card-success';
	}

	if(!empty($client)) {
		if(checkLicenseVersion()){
    		$active_plan = $planName;
		}elseif(!empty($plan)){
			$active_plan = $planInfo['mapping'][$plan];
		}
		$cc_version_class = 'card-success';
		$showplan = <<<EOD
		<div class="col-sm-6 col-lg-6">
			<div class="card card-inverse card-primary">
				<div class="card-block pb-0">
					<h1 class="mb-0" style="font-size:37px;">$active_plan</h1>
					<p>CometChat Plan</p>
				</div>
			</div>
		</div>
EOD;
	}

$body = <<<EOD
	<div class="row">
		$warningMsg
		<div class="col-sm-6 col-lg-6">
		<div class="row">
			<div class="col-sm-12 col-lg-12">
			<div class="card">
				<div class="card-header">
					Stats
					<div style="width:200px;float:right;">
						<select onchange="window.location='?module=dashboard&ts={$ts}&report='+this.value+''" class="form-control" id="report" name="report">
							<option $last24hours value="last24hours">Last 24 Hours</option>
								<option $last30days value="last30days">Last 30 Days</option>
							<option $alltime value="alltime">All Time</option>
						</select>
					</div>
				</div>
				<div class="col-sm-6 col-lg-6">
					<div class="card card-inverse card-primary">
						<div class="card-block pb-0">
							<h1 class="mb-0">$onlineusers</h1>
							<p>Users Chatting</p>
						</div>
					</div>
				</div>
				<!--/col-->
				<div class="col-sm-6 col-lg-6">
					<div class="card card-inverse card-primary">
						<div class="card-block pb-0">
							<h1 class="mb-0">$totalmessagest</h1>
							<p>Messages Sent $range</p>
						</div>
					</div>
				</div>

				<!--/col-->
				<div class="col-sm-6 col-lg-6">
					<div class="card card-inverse card-primary">
						<div class="card-block pb-0">
							<h1 class="mb-0">$activeusers</h1>
							<p>Active Users $range</p>
						</div>
					</div>
				</div>
				<!--/col-->

				<!--/col-->
				<div class="col-sm-6 col-lg-6">
					<div class="card card-inverse card-primary">
						<div class="card-block pb-0">
							<h1 class="mb-0">$activeguests</h1>
							<p>Active Guest $range</p>
						</div>
					</div>
				</div>
				<!--/col-->
			</div>
			</div>

EOD;
if(empty($client)) {
	if ($available_version == '') {
		$button = '<a href="?module=update&action=forceUpdate&ts='.$ts.'" class="btn" style="color: #fff;background-color: #1266f1;border-color: #0e61eb;">Force Update</a>';
		$updateUI = <<<EOD
		<div class="col-sm-6 col-lg-6 update-tab">
			<div class="card card-inverse card-primary">
				<div class="card-block pb-0">
				<h3 class="mb-0" style="font-size:20px;"> CometChat is Up-to-date</h3>
				<p style="margin-top:1rem;float:right;">{$button}</p>
				</div>
			</div>
		</div>
EOD;
	}else {
		$writablepath = dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'writable'.DIRECTORY_SEPARATOR;
		$button = '<a href="?module=update&action=updateNow&ts='.$ts.'" class="btn" style="color: #fff;background-color: #1266f1;border-color: #0e61eb;"> Update Now</a>';
		if(!file_exists($writablepath.'updates'.DIRECTORY_SEPARATOR.$available_version.DIRECTORY_SEPARATOR.'cometchat.zip')){
			$button = '<a href="?module=update&force=1&ts='.$ts.'" class="btn" style="color: #fff;background-color: #1266f1;border-color: #0e61eb;"><i class="fa fa-download"></i> Download</a>';
		}
		$updateUI = <<<EOD
		<div class="col-sm-6 col-lg-6 update-tab">
			<div class="card card-inverse card-primary">
				<div class="card-block pb-0">
					<h1 class="mb-0">v{$available_version} <span style="position:relative;float:right;">{$button}</span></h1>
					<p>Available Version &nbsp;<br><a style="color:white;" href="https://www.cometchat.com/change-log"  target="_blank">Change Log</a></p>
				</div>
			</div>
		</div>
		<!--/col-->
EOD;
	}
}

$body .= <<<EOD

			<div class="col-sm-12 col-lg-12">
				<div class="card">
					<div class="card-header">
						Updates
					</div>
						<div class="col-sm-6 col-lg-6">
							<div class="card card-inverse {$cc_version_class}">
								<div class="card-block pb-0">
									<h1 class="mb-0">v$currentversion</h1>
									<p>Current Version</p>
								</div>
							</div>
						</div>
						$updateUI
						<div class="col-sm-6 col-lg-6">
							<div class="card card-inverse card-primary">
								<div class="card-block pb-0">
									<h3 class="mb-0" style="font-size:20px;"> Love CometChat ?</h3>
									<p style="margin-top:1rem;"><span>Take a minute to <a style="color:#0d5bdd;" href="https://www.cometchat.com/reviews/write/" target="_blank">write us a testimonial</a></span></p><br>
								</div>
							</div>
						</div>
						<!--/col-->
						{$showplan}
				</div>
			</div>

		</div>
		</div>
		<div class="col-sm-6 col-lg-6">
			<div class="card">
				<div class="card-header">
					News
				</div>
				<div class="card-block">
					<iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2FCometChat%2F&tabs=timeline&width=500&height=300&small_header=true&adapt_container_width=true&hide_cover=true&show_facepile=false&appId=143961562477205" width="100%" height="300" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
				</div>
			</div>
		</div>
	</div>
EOD;

	template();
}

function loadexternal() {
	if (file_exists(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.$_GET['type'].'s'.DIRECTORY_SEPARATOR.$_GET['name'].DIRECTORY_SEPARATOR.'settings.php')) {
		include_once(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.$_GET['type'].'s'.DIRECTORY_SEPARATOR.$_GET['name'].DIRECTORY_SEPARATOR.'settings.php');
	} else {
echo <<<EOD
<form>
<div id="content">
		<h2>No configuration required</h2>
		<h3>Sorry there are no settings to modify</h3>
		<input type="button" value="Close Window" class="button" onclick="javascript:window.close();">
</div>
</form>
EOD;
	}
}

function loadthemetype() {
	if (file_exists(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.$_GET['type'].'s'.DIRECTORY_SEPARATOR.$_GET['name'].DIRECTORY_SEPARATOR.'settings.php')) {
		include_once(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.$_GET['type'].'s'.DIRECTORY_SEPARATOR.$_GET['name'].DIRECTORY_SEPARATOR.'settings.php');
	} else {
echo <<<EOD
<form>
<div id="content">
		<h2>No configuration required</h2>
		<h3>Sorry there are no settings to modify</h3>
		<input type="button" value="Close Window" class="button" onclick="javascript:window.close();">
</div>
</form>
EOD;
	}
}

function themeembedcodesettings() {
	if (file_exists(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.$_GET['type'].'s'.DIRECTORY_SEPARATOR.$_GET['name'].DIRECTORY_SEPARATOR.'settings.php')) {
		$generateembedcodesettings = 1;
		include_once(dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.$_GET['type'].'s'.DIRECTORY_SEPARATOR.$_GET['name'].DIRECTORY_SEPARATOR.'settings.php');
	} else {
echo <<<EOD
<form>
<div id="content">
		<h2>No configuration required</h2>
		<h3>Sorry there are no settings to modify</h3>
		<input type="button" value="Close Window" class="button" onclick="javascript:window.close();">
</div>
</form>
EOD;
	}
}
