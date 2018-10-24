<?php

if($_SERVER['HTTP_HOST'] == "localhost" || $_SERVER['HTTP_HOST'] == "192.168.1.15")
{
    define("SITE_PATH", 'https://'.$_SERVER['HTTP_HOST'].'/trepicity/'); // Manual
	define("IMG_PATH",  'https://'.$_SERVER['HTTP_HOST'].'/trepicity/app/webroot/'); // Manual
	define("PAYPAL_URL",  'https://www.sandbox.paypal.com/cgi-bin/webscr?'); // Manual
	define("PAYPAL_ID",  'shanti.gola@prospus.com'); // Manual
	define("PAYPAL_CANCEL_URL",  'https://'.$_SERVER['HTTP_HOST'].'/trepicity/payment/cancel'); // Manual
	define("PAYPAL_RETURN_URL", 'https://'.$_SERVER['HTTP_HOST'].'/trepicity/payment/success');
        define("KCGTZOHO_RETURN_URL", 'https://'.$_SERVER['HTTP_HOST'].'/trepicity/payment/zohoKCGTsuccess');
        define("HQ_EMAIL", 'prospus.rahultomar@gmail.com');
	
}
else if ($_SERVER['HTTP_HOST'] == "dev.trepicity.com"){
	define("SITE_PATH", 'https://'.$_SERVER['HTTP_HOST'].''); // Manual
	define("IMG_PATH",  'https://'.$_SERVER['HTTP_HOST'].'/app/webroot/'); // Manual
	define("PAYPAL_URL",  'https://www.sandbox.paypal.com/cgi-bin/webscr?'); // Manual
	define("PAYPAL_ID",  'shanti.gola@prospus.com'); // Manual
	define("PAYPAL_CANCEL_URL",  'https://'.$_SERVER['HTTP_HOST'].'/payment/cancel'); // Manual
	define("PAYPAL_RETURN_URL", 'https://'.$_SERVER['HTTP_HOST'].'/payment/success');
        define("ZOHO_RETURN_URL", 'https://'.$_SERVER['HTTP_HOST'].'/payment/zohosuccess');
        define("KCGTZOHO_RETURN_URL", 'https://'.$_SERVER['HTTP_HOST'].'/payment/zohoKCGTsuccess');
        define("HQ_EMAIL", 'prospus.rahultomar@gmail.com');
        define("ORGANIZATIONID", '53121860');
	define("HQ_CHALLENGE_EMAIL", 'info.prospus@gmail.com');
}
else if ($_SERVER['HTTP_HOST'] == "sta.trepicity.com"){
	define("SITE_PATH", 'https://'.$_SERVER['HTTP_HOST'].'/'); // Manual
	define("IMG_PATH",  'https://'.$_SERVER['HTTP_HOST'].'/app/webroot/'); // Manual
	define("PAYPAL_URL",  'https://www.sandbox.paypal.com/cgi-bin/webscr?'); // Manual
	define("PAYPAL_ID",  'shanti.gola@prospus.com'); // Manual
	define("PAYPAL_CANCEL_URL",  'https://'.$_SERVER['HTTP_HOST'].'/payment/cancel'); // Manual
	define("PAYPAL_RETURN_URL", 'https://'.$_SERVER['HTTP_HOST'].'/payment/success');
        define("KCGTZOHO_RETURN_URL", 'https://'.$_SERVER['HTTP_HOST'].'/payment/zohoKCGTsuccess');
        define("ZOHO_RETURN_URL", 'https://'.$_SERVER['HTTP_HOST'].'/payment/zohosuccess');
   define("HQ_EMAIL", 'prospus.shantigola@gmail.com'); // remove this on live
	//define("HQ_EMAIL", 'hq.prospus@gmail.com'); enable this on live//
        define("ORGANIZATIONID", '53121860');
        //define("HQ_CHALLENGE_EMAIL", 'info.prospus@gmail.com');//enable this on live
        define("HQ_CHALLENGE_EMAIL", 'prospus.shantigola@gmail.com'); // remove this on live
        define("KID_DB_ID", '13');
}
else if ($_SERVER['HTTP_HOST'] == "sta.theentropolis.com"){
    define("SITE_PATH", 'https://'.$_SERVER['HTTP_HOST'].'/'); // Manual
    define("IMG_PATH",  'https://'.$_SERVER['HTTP_HOST'].'/app/webroot/'); // Manual
    define("PAYPAL_URL",  'https://www.sandbox.paypal.com/cgi-bin/webscr?'); // Manual
    define("PAYPAL_ID",  'shanti.gola@prospus.com'); // Manual
    define("PAYPAL_CANCEL_URL",  'https://'.$_SERVER['HTTP_HOST'].'/payment/cancel'); // Manual
    define("PAYPAL_RETURN_URL", 'https://'.$_SERVER['HTTP_HOST'].'/payment/success');
        define("KCGTZOHO_RETURN_URL", 'https://'.$_SERVER['HTTP_HOST'].'/payment/zohoKCGTsuccess');
        define("ZOHO_RETURN_URL", 'https://'.$_SERVER['HTTP_HOST'].'/payment/zohosuccess');

         define("HQ_EMAIL", 'hq.prospus@gmail.com'); //remove this on live
        define("ORGANIZATIONID", '53121860');
        define("HQ_CHALLENGE_EMAIL", 'info.prospus@gmail.com');//remove this on live
 
        define("KID_DB_ID", '13');
}
else
{
    
 //        define("SITE_PATH", 'https://'.$_SERVER['HTTP_HOST'].'/'); // Manual
	// define("IMG_PATH",  'https://'.$_SERVER['HTTP_HOST'].'/app/webroot/'); // Manual
	// define("PAYPAL_URL",  'https://www.paypal.com/cgi-bin/webscr?'); // Manual
	// define("PAYPAL_ID",  'tania.price@theentropolis.com'); // Manual
	// define("PAYPAL_CANCEL_URL",  'https://'.$_SERVER['HTTP_HOST'].'/payment/cancel'); // Manual
	// define("PAYPAL_RETURN_URL", 'https://'.$_SERVER['HTTP_HOST'].'/payment/success');
 //        define("ZOHO_RETURN_URL", 'https://'.$_SERVER['HTTP_HOST'].'/payment/zohosuccess');
 //        define("KCGTZOHO_RETURN_URL", 'https://'.$_SERVER['HTTP_HOST'].'/payment/zohoKCGTsuccess');
 //        //  define("HQ_EMAIL", 'HQ@trepicity.com');
 //        //define("HQ_EMAIL", 'prospus.shantigola@gmail.com'); // remove this on live
 //        define("HQ_EMAIL", 'stacey@kidpreneurchallenge.com'); //enable this on live//
 //        define("ORGANIZATIONID", '55357589');
 //        //define("HQ_CHALLENGE_EMAIL", 'prospus.shantigola@gmail.com'); // remove this on live
 //        define("HQ_CHALLENGE_EMAIL", 'stacey@kidpreneurchallenge.com');//enable this on live
 //        define("KID_DB_ID", '13');
}

/**
 * Source lead array mapped from zoho.
 */
$sourceLead = array(
    'Inquiry Form' => 'Inquiry Form', /* Inquire form or about us form */
    'KCGT' => 'Ninja Pitch', /*  Ninjas Pitch (KCGT form) */
    'Ninjas Subscription' => 'Ninja Program', /*  Ninjas Subscription (Parents / Kidpreneurs form) */
    'Unicorns program' => 'Schools Program', /*  Unicorns program (KC registration form) */
    'KCPC' => 'Schools Pitch Competition', /*  Unicorns Pitch Competition (KCPC form)  */
    'Get In Touch' => 'Get In Touch', /*  Get In Touch  */
    'Nominate a School' => 'Nominate a School', /* Nominate a School  */
    'Register your Kidpreneur' => 'Register your Kidpreneur' /* Register your Kidpreneur  */
);

/**
 * Config for roles static mentioned in the code files for the condition on the context roles.
 * 
 */
define("PARENT_CONTEXT_ID", '10');
// define("HQ_USER_ID", '10');
define("MAX_BUSINESS_PROFILE", 3);


define("STUDENT_AMT", '50'); // Manual
define("INDIVIDUAL_STUDENT_AMT", '25');
define("GSTAMT", '10%');
define("SHIPPING_AMOUNT", '50');
//Calender settings
define("MIN_AGE", "-12Y");
?>
