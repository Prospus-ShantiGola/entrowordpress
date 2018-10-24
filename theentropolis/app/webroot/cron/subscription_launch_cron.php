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

   
    $siteUrl = "http://dev.entropolis1.prospus.com/";

    /**
     * PROVIDE INFORMATION TO THE USER ABOUT SUBSCRIPTION LAUNCH 1st oct 2015
     */
    $today_date = '2015-10-01'; //date('Y-m-d');
    if($today_date =='2015-10-01')
    {

    	//query to get the date 
    echo $sql = "SELECT u.id,u.first_name,u.last_name,u.email_address,u.zoho_customer_id,u.trail_end_date,u.registration_type,u.zoho_hosted_page_url  FROM users u LEFT JOIN context_role_users crs ON u.id = crs.user_id LEFT JOIN context_roles cr ON crs.context_role_id = cr.id LEFT JOIN roles r ON cr.role_id = r.id  WHERE  role='Seeker' AND u.checkout_status!=1 AND (date(u.subscription_start_date)='$today_date') AND u.life_time_status!='1'  AND u.registration_status ='1' AND (email_address LIKE '%arti.sharma@prospus.com%' OR email_address LIKE '%mohammad.imran@prospus.com%' OR email_address LIKE '%artisharma17aug@gmail.com%')";
    $result = mysql_query($sql) ; 
echo 'dd';
    while($output = mysql_fetch_array($result))
    {
        
        $trial_date = date('d/m/Y',strtotime($output['trail_end_date']));
        //send confirmation email to users
        $sendTo = $output['email_address'];
        $registration_type = $output['registration_type'];
        if($registration_type == 'campaign'){
          $time_period = '6';
        }else
        {
          $time_period = '12';
        }

        $subject = "NEW CITIZENSHIP INFORMATION";
      
        
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
                                    <td >Hello ".ucfirst($output['first_name']).",</td>
                                </tr>
                                <tr>
                                    <td>A note to let you know that subscriptions have begun in Entropolis. From October 1, 2015 we will be asking new Citizens to pay a monthly fee of AU$25 so we can properly engage and add value to our growing population, curate our wisdom and proactively keep the online city pollution free and high performance.<br/>
                                   </td>
                                </tr>                                           
                                <tr>
                                    <td >We love having you part of our fantastic population of entrepreneurs and experts and want to give you the opportunity to trial our new functionality and shape the city with us for free. As a Pioneer Citizen and in appreciation of your invaluable early support, we would like to offer you ".$time_period." months citizenship on us.<br/> </td>
                                </tr>
                                <tr><td>Your free trial will end on <b>".$trial_date."</b>. For now you don't need to do anything but continue to login and stay active. We will let you know one week out that your Citizenship is up for renewal and invite you to update your subscription then.<br/></td></tr>
                                
                                  <tr><td>Thank you for being an active and valuable part of our online city. We look forward to seeing you again in Entropolis soon.<br/></td></tr>
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


            $headers = '';
            $headers = 'MIME-Version: 1.0'.PHP_EOL;
            $headers .= 'Content-type: text/html; charset=iso-8859-1'.PHP_EOL;
            $headers .= 'From:Entropolis <support@entropolis.com>'.PHP_EOL;
          
            mail($sendTo,$subject,$msg,$headers);

      
      }

        
    }





?>


