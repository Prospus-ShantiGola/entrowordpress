<?php
//kuldeep@millieandmore.com.au
$to = "arti.sharma@prospus.com";
$subject = "Test mail";
$message = "Hello! This is a simple email message.";
$from = "projects@prospus.com";
$headers = "From:" . $from;
if(mail($to,$subject,$message,$headers))
{
	echo "1";
}
else
{
	echo '0';
}


?>