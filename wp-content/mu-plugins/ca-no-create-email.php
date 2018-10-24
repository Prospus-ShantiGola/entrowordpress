<?php
/**
 * @package CA_No_Notification
 * @version 1.0
 */

/*
Plugin Name: CA No Notification
Description: Suppress welcome blog email notification
Version: 1.0
*/

function ca_do_nothing($arg) {
	return false;
}
add_filter('wpmu_welcome_notification', 'ca_do_nothing');

// Override method so it doesn't send email
function wp_new_blog_notification() {
	return false;
}
