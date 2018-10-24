<?php 


$servername = "localhost";
$username = "root";
$password = "biGGMoney1";
$dbname = 'entropolis1';

// Create connection
$conn = mysql_connect($servername, $username, $password);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysql_connect_error());
}

$dbsel = mysql_select_db($dbname,$conn);
if(!$dbsel)
{
   die("Connection failed: " . mysql_connect_error());
}


include('class.phpmailer.php');
    
     $siteUrl = "http://dev.entropolis1.prospus.com/";
     $today_date = '2016-08-24'; //date('Y-m-d');

       $seven_day_added = date('Y-m-d', strtotime("+7 days", strtotime($today_date )));
  
       $two_day_added = date('Y-m-d', strtotime("+2 days", strtotime('2016-02-27')));

      //query to get the date 
       echo $sql = "SELECT u.id,u.first_name,u.last_name,u.email_address,u.zoho_customer_id,u.trail_end_date FROM users u LEFT JOIN context_role_users crs ON u.id = crs.user_id LEFT JOIN context_roles cr ON crs.context_role_id = cr.id LEFT JOIN roles r ON cr.role_id = r.id  WHERE u.checkout_status!=1 AND (date(u.trail_end_date)='$seven_day_added' OR date(u.trail_end_date)='$two_day_added' )AND u.life_time_status!='1'  AND u.registration_status ='1' AND (email_address LIKE '%arti.sharma@prospus.com%' OR email_address LIKE '%mohammad.imran@prospus.com%' OR email_address LIKE '%artisharma17aug@gmail.com%')";
      $result = mysql_query($sql) ; 


   while($output = mysql_fetch_array($result))
      {
        
        $trial_date = date('d/m/Y',strtotime($output['trail_end_date']));
        //send confirmation email to users
        $sendTo = $output['email_address'];
        $subject = $output['first_name']." ".$output['last_name']." Your Free Trial Citizenship is Coming to an End ";
        $from   = "support@entropolis.com";
        
        $msg  = "<html><body>
                    <table width='800' cellpadding='50' cellspacing='0' style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px; background:#eee;'>
                    <tr>
                        <td>
                            <table cellpadding='0' cellspacing='0'>
                                <tr>
                                    <td><img src='".$siteUrl."app/webroot/img/email-header.png'></td>
                                </tr>
                                <tr>
                                    <td><table style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px; background:#fff' cellpadding='0' cellspacing='20'>
                                <tr>
                                    <td><table style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px;' cellpadding='7' cellspacing='0'>
                                <tr>
                                    <td >Hello ".$output['first_name'].",</td>
                                </tr>
                                <tr>
                                    <td>A note to let you know that your Entropolis free trial Citizenship will end on <b>".$trial_date."</b>. You will receive a separate email to confirm the start of your monthly Citizens subscription on that date.<br/>
                                   </td>
                                </tr>                                           
                                <tr>
                                    <td >We hope that your time in Entropolis has been valuable and that you continue to be part of our growing online community of entrepreneurs and experts who are connecting, collaborating and co-constructing the great businesses of the future.<br/> </td>
                                </tr>
                                <tr><td>If you wish to discontinue your Citizenship please go to your Account Settings to delete your account.  <br/></td></tr>
                                
                                  <tr><td>Thank you for being a great asset to our online city for entrepreneurs. See you again soon in Entropolis.<br/></td></tr>
                                <tr>
                                    <td style=''><b>The Team@Entropolis|HQ</b><br>
                                    <b><a href='#' style='color:#000; text-decoration:none;'>www.TheEntropolis.com</a> |  #PlacetobeforEntrepreneurs</b></td>
                                </tr>
                                <tr>
                                    <td><table  cellpadding='0' cellspacing='0' style='color:#b2b2b2; font-size:11px; font-family: Arial, Helvetica, sans-serif; line-height:13px'>
                                <tr>
                                        <td> IMPORTANT INFORMATION *</td>
                                </tr>
                                <tr>
                                        <td >This document should be read only by those persons to whom it is addressed and its content is not intended for use by any other persons. If you have received this message in error, please notify us immediately at <a href ='mailto:hello@TheEntropolis.com' style='color:blue'>hello@TheEntropolis.com</a>. Please also destroy and delete the message from your computer. Any unauthorised form of reproduction of this message is strictly prohibited. </td><br/>
                                </tr>
                                <tr>
                                        <td>Entropolis Pty Ltd is not liable for the proper and complete transmission of the information contained in this communication, nor for any delay in its receipt.</td>
                                </tr>
                        </table></td>
                                                                                                </tr>
                                                                                        </table></td>
                                                                        </tr>
                                                                </table></td>
                                                </tr>
                                                <tr>
                                                        <td valign='top' style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:11px; background-color:#E2E2E2;'><table width='100%' border='0' cellspacing='0' cellpadding='20'>
                                                                        <tr>
                                                                                <td style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:11px; background-color:#E2E2E2;'>
                                                                            
                                                                                <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                        <tr>
                                <td width='10'>&nbsp;</td>
                                <td nowrap='nowrap'  style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:11px; background-color:#E2E2E2;'> LEVEL 4,16 SPRING STREET, SYDNEY, NSW 2000 | T:1300 85 6171 | E: <a style='color:blue' > citizens@TheEntropolis.com</a> | <a style='color:blue'> www.TheEntropolis.com </a></td>
                        
                        </tr>
                  </table>

                                                                            
                                                                        </td>
                                                                        </tr>
                                                                </table></td>
                                                </tr>
                                        </table>
                                </td>
                        </tr>
                  </table>
                  </body></html>";    

                 
       //   $mail = new PHPMailer();

echo $msg;



  $from = "ss@prospus.com";
$headers = '';
            $headers = 'MIME-Version: 1.0'.PHP_EOL;
            $headers .= 'Content-type: text/html; charset=iso-8859-1'.PHP_EOL;
            $headers .= 'From: '.@$from.'<'.@$from.'>'.PHP_EOL;
          
            mail('arti.sharma@prospus.com',$subject,$msg,$headers);
die;
        $mail_array = array('arti.sharma@prospus.com'); 
         foreach ($mail_array as $email_address ) {
                 $mail->AddAddress($email_address);
                  }

        
       //  $email_address = 'mragsdale@prospus.com'; 
       
         
       // $mail->AddAddress($email_address);
        $mail->Subject =  $subject;
        $mail->MsgHTML($msg);
      
        $mail->From ="sss";
        $mail->FromName ="Reporting";
       
            
    
        $mail->isHTML('true');
  
     
        if(!$mail->Send()) {
       echo "There was an error sending the message";
       exit;
        } 
        else 
        {
            echo 'true';
        }  
       
    

      }

?>