<?php
 
App::uses('Component', 'Controller');
App::import('Vendor', 'phpmailer', array('file' => 'phpmailer'.DS.'PHPMailerAutoload.php'));
 
class PHPEmailComponent extends Component {
 
  public function send($to, $subject, $message,$file_path='') {
    $mail = new PHPMailer;

$mail->SMTPDebug = 2;                               // Enable verbose debug output
$mail->CharSet = 'UTF-8';
//$mail->isSMTP();   
$mail->SMTPDebug = 0;// Set mailer to use SMTP
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'hq@theentropolis.com';                 // SMTP username
$mail->Password = 'hQTEP@2017';                           // SMTP password
$mail->Port = 465;                                    // TCP port to connect to
$mail->SMTPAutoTLS = false;


if(is_array($to)){
foreach ($to as $toEmailId) {
    $mail->addAddress($toEmailId);     // Add a recipient
}
}else{
$mail->addAddress($to);     // Add a recipient
}
$mail->addReplyTo('hq@theentropolis.com', 'Entropolis HQ');
$mail->setFrom('hq@theentropolis.com', 'Entropolis HQ');
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = $subject;
$mail->Body    = $message;
$mail->AltBody = $message;
$mail->SMTPSecure = 'tls';
$mail->Host = 'smtp.theentropolis.com';

$mail->addAttachment($file_path);

    if(!$mail->send()) {
      return array('error' => true, 'message' => 'Mailer Error: ' . $mail->ErrorInfo);
    } else {
      return array('error' => false, 'message' =>  "Message sent!");
    }
    
    
   
  }
}
 
?>