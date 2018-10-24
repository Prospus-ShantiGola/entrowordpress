<?php
/**
    * Component for Generating Captcha in CakePHP 2.x
    * PHP versions 5.2.8
    * @author     Dave
    * @link       http://deliciouscakephp.com/
    * @version 0.0.2
    * @license   GPL (www.gnu.org/licenses/gpl.html)
    *   - Initial release
    */
App::uses('Component', 'Controller');

class SiteMailComponent extends Component{

    public $components = array('PHPEmail');

   
    /**
     * Common function for mail footer
     */
    public function commonFooter()
    {
       $html_footer="<tr>
                                                    <td>
                                                    <strong>Entropolis HQ</strong><br>
                                                    <strong>Inspiring, Educating, Empowering and Connecting Future Entrepreneurs.</strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Entropolis Pty Ltd
                                                        <br>
                                                        ABN 74 168 344 018
                                                        <br><br>
                                                        Level 4, 16 Spring Street
                                                        <br>
                                                        Sydney NSW 2000
                                                        <br>
                                                        Australia
                                                        <br><br>
                                                        <strong>E</strong> <a href='mailto:hq@theentropolis.com'>hq@theentropolis.com</a>
                                                        <br>
                                                        <strong>P</strong> 1300 464 388
                                                        <br>
                                                        <a href='http://www.theentropolis.com/kidchall-unicorns' target='_blank'>www.theentropolis.com/kidchall-unicorns</a>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                
                                               
                                                <tr>
                                                    <td style='line-height: 18px; color: #909090'>
                                                        NOTICE - This communication contains information which is confidential and the copyright of Entropolis Pty Ltd or a third party. This email is intended to be read or used by the addressee only. If you are not the intended recipient, any use, distribution, disclosure or copying of this email is strictly prohibited without the authority of Entropolis Pty Ltd Please delete and destroy all copies and email us at hq@theentropolis.com immediately.
                                                        
                                                    </td>
                                                </tr>";
        return $html_footer;

    }

    /**
     * Common function for mail notice text
     */
    public function commonNoticeText()
    {
       $html_notice=" <tr><td style='font-size:11px;color:#b5b5b5;line-height: 18px; font-family: Times New Roman;'>
                            NOTICE - This communication contains information which is confidential and the copyright of Club Kidpreneur Ltd, Entropolis Pty Ltd or a third party. This email is intended to be read or used by the addressee only. If you are not the intended recipient, any use, distribution, disclosure or copying of this email is strictly prohibited without the authority of Club Kidpreneur Ltd. Please delete and destroy all copies and email Club Kidpreneur at kidpreneurs@theentropolis.com immediately
                           </td>
                       </tr>";
        return $html_notice;

    }
    /**
     * Function to send mail to registered user for parent role  
     * Called for function kid_registration in usercontroller.php
     */
    public function sendMailToParentRoleUser($user_info_mail){
        
        $siteUrl = Router::url('/', true);

        $registeredUserMail = $user_info_mail['registeredUserMail'];

         $subject = "Welcome to Kidpreneur City – Subscription Confirmed";           
                $msg = "<body>
                        <table width='800' cellpadding='50' cellspacing='0' style='font-family: Arial; color:#000; font-size:12px; background:#eee;'>
                            <tr>
                                <td  width='100%'>
                                    <table cellpadding='0' cellspacing='0' width='100%'>
                                    <tr>
                                        <img src='" . Router::url('/', true) . "app/webroot/img/parent-subscription-confirmed.png'></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table width='100%' style='font-family: Arial; color:#000; font-size:12px; background:#fff' cellpadding='0' cellspacing='20'>
                                                <tr>
                                                    <td>
                                                        <table width='100%' style='font-family: Arial; color:#000; font-size:12px;' cellpadding='7' cellspacing='0'>
                                                            <tr>
                                                                <td style='font-weight:bold'>Dear <span>" . $user_info_mail['first_name'] . "</span> <span>" . $user_info_mail['last_name'] . "</span> </td>
                                                            </tr>
                                                            <tr>
                                                                <td style='padding: 20px 5px;line-height: 18px;'>Thank you for signing up to Kidpreneur City, we are so excited you are sharing your entrepreneurial adventure with us.</td>
                                                            </tr>
                                                            <tr>
                                                                <td style='color: #000; padding-bottom: 0px; font-weight: bold;line-height: 18px;'>Your Registration and Payment Confirmation</td>
                                                            </tr>
                                                            <tr>
                                                                <td style='color: #000; padding-bottom: 0px;line-height: 18px;'>Your order has been received. You have registered  <span style='font-weight: bold'>" . $user_info_mail['no_of_student_participate'] . "</span> <span style='font-weight: bold'> Kidpreneurs</span>.</td>
                                                            </tr>
                                                            <tr>
                                                                <td style='color: #000; padding-bottom: 10px; font-weight: bold;font-size:12px;'>Important to note:</td>
                                                            </tr>
                                                            <tr>
                                                                <td style='padding: 0;'>
                                                                    <table>
                                                                        <tr>
                                                                            <td style='margin: 0;'>
                                                                                <ul style='padding-left: 35px; margin:0; line-height: 18px;font-size:12px;'>
                                                                                    <li>If you selected PAY BY INVOICE as your payment option you will receive an invoice from Club Kidpreneur within the next 48 hours. The payment terms are seven days from invoice date.</li>
                                                                                    <li>
                                                                                        Once your payment is confirmed we will email you a unique log-in to gain access to your Educator Dashboard and the Kidpreneur Challenge Curriculum Toolkit online at www.theentropolis.com.
                                                                                    </li>
                                                                                    <li>
                                                                                    If you selected PAY ONLINE as your payment option and your PayPal payment was successful, you will should have automatic access to your Educator dashboard. If you have any issues accessing your dashboard or the curriculum toolkit please let us know.
                                                                                    </li>
                                                                                    <li>Backpack materials will be delivered to the address provided by April 18, 2017.</li>
                                                                                    <li>For questions in the meantime, please email <a href='mailto:kidpreneurs@theentropolis.com' style='color:blue' target='_blank'>kidpreneurs@theentropolis.com</a></li>
                                                                                </ul>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style='color: #000; padding-bottom: 10px; font-size:12px;'><strong>Note:</strong>
                                                                    In Program Module 5 - Financials, students are responsible for paying back their start-up costs ($25 each) from the revenue they make at market day. These funds effectively make the program self-funding for schools.
                                                                </td>
                                                            </tr>

                                                                
                                                            
                                                            <tr>
                                                                <td style='color: #000; padding-bottom: 10px; font-weight: bold;font-size:12px;'>What to expect:</td>
                                                            </tr>
                                                            <tr>
                                                                <td style='padding: 0;'>
                                                                    <table>
                                                                        <tr>
                                                                            <td style='margin: 0;'>
                                                                                <ul style='padding-left: 35px; margin:0; line-height: 18px;font-size:12px;'>
                                                                                    <li>The Online Teaching Resource Centre has all the materials you require to teach the Kidpreneur Challenge.</li>
                                                                                    <li>
                                                                                        A Teacher Handbook will guide you through the 10-week program curriculum ReadySetGo, tips for running a market day and a summary of how the program maps to the Australian National Curriculum 8.3.
                                                                                    </li>
                                                                                    <li>Each module includes a lesson plan, video, student work sheet and Busines-in-a-Satchel materials to reinforce each key learning objective.</li>


                                                                                    <li>Supplementary resources include a Literacy Pack for our novel �Curtis the Kidpreneur� and access to wider reading and a digital network of like-minded educators.</li>


                                                                                    <li>The intent of the program is for students to work in small teams of two, three or four to build a micro-business, sell hand-made products at market, and make enough revenue to cover their start-up costs and generate profits to donate to a worthy cause.</li>
                                                                                </ul>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style='color: #000; padding-bottom: 10px; font-weight: bold'>Kidpreneur Challenge Pitch Competition:</td>
                                                            </tr>
                                                            <tr>
                                                                <td style='padding: 0;'>
                                                                    <table>
                                                                        <tr>
                                                                            <td style='margin: 0;'>
                                                                                <ul style='padding-left: 35px; margin:0; line-height: 18px;font-size:12px;'>
                                                                                    <li>The Kidpreneur Challenge competition is an optional extra. It is a national primary-school entrepreneurship competition open to years 4, 5 & 6, which showcases the creativity and talent amongst students.</li>
                                                                                    <li>
                                                                                        After completing the ReadySetGo curriculum, students enter the competition by creating a video pitch about their business experience and product, which is uploaded by Club Kidpreneur to our YouTube channel and judged by real-life entrepreneurs. 10 teams will win prizes and business experiences for the students and the school. See the 2016 winners’ experience <a href='https://www.youtube.com/watch?v=wMuQ9S4qU9g' style='color:blue' target='_blank'>here</a>.
                                                                                    </li>
                                                                                    <li>Kidpreneur Challenge competition runs 1 September- 16 October, 2017 with judging on 24 October.  Please refer to the Terms and Conditions on our website for full details.</li>
                                                                                </ul>
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style='color: #000; padding-bottom: 10px; font-weight: bold;'>Stay in touch:</td>
                                                            </tr>
                                                            <tr>
                                                                <td style='line-height: 18px;padding-top: 0;'>
                                                                    Welcome to the Club Kidpreneur community; we can’t wait to hear the stories of your kidpreneurs’ business adventures.Please keep us posted along the way and don’t forget to tag us in your social media #kidpreneur, #clubkidpreneur or #kidpreneurchallenge. You will hear from us before the end of Term One as well.
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style='line-height: 18px;padding-top: 0;'>
                                                                    If you would like to discuss the program with a member of our team please phone 1300 464 388 or email 
                                                                    <a href='mailto:kidpreneurs@theentropolis.com' style='color:blue' target='_blank'>kidpreneurs@theentropolis.com</a>.
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style='line-height: 18px;padding-top: 20px;'>Warm regards,</td>
                                                            </tr>
                                                            <tr>
                                                                <td style='font-weight:bold;line-height: 18px;padding-top: 0;'>The Club Kidpreneur Team</td>
                                                            </tr>
                                                            <tr>
                                                                <td style='line-height: 18px;padding-top: 0;'>
                                                                    Club Kidpreneur Ltd. <br/>
                                                                    ABN 13 144 623 709<br/>
                                                                    ACNC Registered charity
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style='line-height: 18px;padding-top: 0;'>
                                                                    Level 4, 16 Spring Street<br/>
                                                                    Sydney NSW 2000<br/>
                                                                    Australia
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style='line-height: 18px;padding-top: 0;'>
                                                                    <strong>E</strong>  <a href='javascript:void(0)' style='color:blue'>kidpreneurs@theentropolis.com</a><br/>
                                                                    <strong>P</strong>  1300 464 388<br/>
                                                                    <strong>W</strong>  <a href='" . $siteUrl . "club-kidpreneur" . "' style='color:blue' target='_blank'>" . $siteUrl . "club-kidpreneur" . "</a>
                                                                </td>
                                                            </tr>".$this->commonNoticeText()."</table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>".$this->commonFooter()."</table>
                            </td>
                        </tr>
                        </table>
                </body>";
                
                //mail send to the registered user
                $this->PHPEmail->send($registeredUserMail, $subject, $msg);
    }
    /**
     * Function to send mail to registered user for teacher/educator role  
     * Called for function kid_registration in usercontroller.php
     */
    public function sendMailToTeacherRoleUser($user_info_mail){
        
        // //Check if the user is Admin from Session
        // $isAdmin   = CakeSession::read('isAdmin');              //$this->Session->read("isAdmin");
        
        // //Get user role context id from the session
        // $contextId = CakeSession::read('context_role_user_id'); //$this->Session->read("context_role_user_id");

        // //Initialise User Model
        // $model = ClassRegistry::init('User');                   //$this->User->getRoleByContextId
        
      //  pr($user_info_mail);
        $siteUrl = Router::url('/', true);

        $registeredUserMail = $user_info_mail['registeredUserMail'];

         $subject = "Kidpreneur Challenge – Order Received";           
                $msg = '<body>
<div><table width="800" cellpadding="50" cellspacing="0" style="font-family:Arial,Helvetica,sans-serif;color:#000;font-size:12px;background:#eee">
    <tbody><tr>
    <td width="100%" ">
    <table cellpadding="0" cellspacing="0" width="100%">
        <tbody><tr>
           <td> <img src="'. Router::url('/', true) . 'app/webroot/img/order-confirm.png" width="100%"></td>
        </tr>
        <tr>
            <td>
                <table width="100%" style="font-family:Arial;color:#000;font-size:12px;background:#fff;" cellpadding="0" cellspacing="20">
                    <tbody><tr>
                        <td>
                            <table width="100%" style="font-family:Arial;color:#000;font-size:12px" cellpadding="7" cellspacing="0">
                                <tbody><tr>
                                    <td padding-top:10px; padding-bottom:0px;>Dear <span>' . $user_info_mail["first_name"] . '</span> <span>' . $user_info_mail["last_name"] . '</span> </td>
                                </tr>
                                <tr>
                                    <td style="padding:0px 5px;line-height:18px">Thank you for registering for the Kidpreneur Challenge program. We are excited you will join us on our mission to ignite the entrepreneurial spirit in the next generation and prepare them for success in the future world.</td>
                                </tr>
                                <tr>
                                    <td style="color:#000;padding-bottom:0px;padding-top:20px;font-weight:bold;line-height:18px;font-size:12px">Your Order Confirmation</td>
                                </tr>
                                <tr>

                                    <td style="color:#000;padding-top:0px; padding-bottom:0px;line-height:18px">Thank you, we have received your order for a Kidpreneur Challenge '.$user_info_mail["plan"].' Package. You have selected PAY BY INVOICE as your payment option and your account activation is pending payment. We will send an invoice from Club Kidpreneur Limited within the next 48 hours. The payment terms are seven days from invoice date.</td>
                                </tr>
                                <tr>

                                    <td style="color:#000;padding-bottom:0px;padding-top:20px;font-weight:bold;line-height:18px;font-size:12px">Please check the below details to confirm what your package includes:</td>
                                </tr>
                                <tr>
                                    <td>
                                        <table width="100%" style="font-family:Arial;color:#000;font-size:12px;background:#fff; box-shadow:none;" cellpadding="0" cellspacing="0" border="1">
                                            <tbody>
                                                <tr>
                                                    <td  style="color:#fff; font-weight: bold; background:#524D4C;padding-top: 10px; padding-bottom:10px;padding-left: 10px;">PACKAGE OFFER</td>
                                                    <td  style="color:#fff; font-weight: bold; background:#524D4C;padding-top: 10px; padding-bottom:10px;padding-left: 10px;">Class</td>
                                                    <td  style="color:#fff; font-weight: bold; background:#524D4C;padding-top: 10px; padding-bottom:10px;padding-left: 10px;">Cohort</td>
                                                    <td  style="color:#fff; font-weight: bold; background:#524D4C;padding-top: 10px; padding-bottom:10px;padding-left: 10px;">Unlimited</td>
                                                    <td style="color:#fff; font-weight: bold; background:#524D4C;padding-top: 10px; padding-bottom:10px;padding-left: 10px;"> Unlimited 3yrs</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5" style="color:#000; font-weight: bold; background: #DAD5D4; padding:10px;">Details</td>
                                                </tr>
                                                <tr>
                                                    <td style="color:#000; padding-top: 10px; padding-bottom:10px;padding-left: 10px;">Number of Students</td>
                                                    <td style="color:#000;padding-top: 10px; padding-bottom:10px;padding-left: 10px; font-weight: bold;">Up to 30 </td>
                                                    <td style="color:#000;padding-top: 10px; padding-bottom:10px;padding-left: 10px; font-weight: bold;">Up to 100</td>
                                                    <td style="color:#000;padding-top: 10px; padding-bottom:10px;padding-left: 10px; font-weight: bold;">Unlimited</td>
                                                    <td style="color:#000;padding-top: 10px; padding-bottom:10px;padding-left: 10px; font-weight: bold;">Unlimited</td>
                                                </tr>
                                                 <tr>
                                                    <td style="color:#000;padding-top: 10px; padding-bottom:10px;padding-left: 10px;"">Number of Educators</td>
                                                    <td style="color:#000;padding-top: 10px; padding-bottom:10px;padding-left: 10px; font-weight: bold;"> One </td>
                                                    <td style="color:#000;padding-top: 10px; padding-bottom:10px;padding-left: 10px; font-weight: bold;">Up to 4</td>
                                                    <td style="color:#000;padding-top: 10px; padding-bottom:10px;padding-left: 10px; font-weight: bold;">Unlimited</td>
                                                    <td style="color:#000;padding-top: 10px; padding-bottom:10px;padding-left: 10px; font-weight: bold;">Unlimited</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5" style="color:#000; font-weight: bold; background:#DAD5D4;padding: 10px;">All packages include</td>
                                                </tr>
                                                <tr width="100%">
                                                <td colspan="5">
                                                <table width="100%" style="font-family:Arial;color:#000;font-size:12px;background:#fff; box-shadow:none; table-layout:fixed; border: none;" cellpadding="0" cellspacing="0" >
                                                    <tbody>
                                                   <tr>

                                                    <td colspan="" style="color:#000; font-weight: bold; background:#fff; border:none;padding:5px;">For Educators</td>
                                                    <td colspan="" style="color:#000; font-weight: bold; background:#fff;  border:none;padding:5px;">For Students</td>

                                                </tr>
                                                        <tr>
                                                        <td style=" background:#fff; margin:0;">
                                                            <table width="100%" style="font-family:Arial;color:#000;font-size:12px;background:#fff; box-shadow:none; border: none;" cellpadding="5" cellspacing="0" >
                                                                <tbody>
                                                                <tr>
                                                                    <td style="width:20px; vertical-align:top;"><img src="'. Router::url('/', true) . 'app/webroot/img/dotdot.png" alt=""></td>
                                                                    <td>Online Curriculum Toolkit and downloadable resources including:  Teaching guides, lesson plans,   instruction videos, student worksheets.</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width:20px; vertical-align:top;"><img src="'. Router::url('/', true) . 'app/webroot/img/dotdot.png" alt=""></td>
                                                                    <td>Secure online support network and curated content to assist educators build their knowledge and skills and support effective classroom delivery of the program. 
                                                                    </td>
                                                                </tr>
                                                                 <tr>
                                                                    <td style="width:20px; vertical-align:top;"><img src="'. Router::url('/', true) . 'app/webroot/img/dotdot.png" alt=""></td>
                                                                    <td>BONUS Curtis the Kidpreneur Code Name Hawaii online book and literacy pack. 
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width:20px; vertical-align:top;"><img src="'. Router::url('/', true) . 'app/webroot/img/dotdot.png" alt=""></td>
                                                                    <td>
                                                                        Feedback and assessment tools to track progress, educational impact and pedagogical outcomes. (Launch 2018)
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width:20px; vertical-align:top;"><img src="'. Router::url('/', true) . 'app/webroot/img/dotdot.png" alt=""></td>
                                                                    <td>Exclusive invitations to endorsed professional development masterclasses and online modules. (Launch 2018)
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>

                                                            <table width="100%" style="font-family:Arial;color:#000;font-size:12px;text-align:center;background:#dad5d4; box-shadow:none;  border: none;" cellpadding="5" cellspacing="5" >
                                                                <tbody>
                                                                <tr>                                                           
                                                                    <td>
                                                                    We will be constantly updating all our content on Entropolis and improving our library of entrepreneurship education resources
                
                                                                    </td>
                                                                </tr>
                                                                <tr>                                                           
                                                                    <td>
                                                                    We will also be launching a number of new tools in 2018 and beyond including assessment and outcomes reporting.
                
                                                                    </td>
                                                                </tr>
                                                                <tr>                                                           
                                                                    <td>
                                                                    We welcome the feedback and input of all our Educators and you sharing your experience with our online community as we grow and shape this city for future entrepreneurs.
                
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                          
                                                        </td>
                                                          <td style="vertical-align: top;">
                                                                <table width="100%" style="font-family:Arial;color:#000;font-size:12px;background:#fff; box-shadow:none; border: none;" cellpadding="5" cellspacing="0" >
                                                            <tbody>
                                                            <tr>
                                                                
                                                                <td colspan="2"> Unlimited access to Kidpreneur City online including: </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="width:20px; vertical-align:top;"><img src="'. Router::url('/', true) . 'app/webroot/img/dotdot.png" alt=""></td>
                                                                <td>Secure personal dashboard to profile your business and build your entrepreneurial cred 
                                                                </td>
                                                            </tr>
                                                             <tr>
                                                                <td style="width:20px; vertical-align:top;"><img src="'. Router::url('/', true) . 'app/webroot/img/dotdot.png" alt=""></td>
                                                                <td>Business networking with other Kidpreneurs. 
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="width:20px; vertical-align:top;"><img src="'. Router::url('/', true) . 'app/webroot/img/dotdot.png" alt=""></td>
                                                                <td>
                                                                     Kid-centric curated content to help build business skills and immerse kids in the exciting world of entrepreneurship.
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="width:20px; vertical-align:top;"><img src="'. Router::url('/', true) . 'app/webroot/img/dotdot.png" alt=""></td>
                                                                <td> Kidpreneur Challenge games, worksheets and other tools to learn about entrepreneurship.
                                                                </td>
                                                            </tr>

                                                             <tr>
                                                                <td style="width:20px; vertical-align:top;"><img src="'. Router::url('/', true) . 'app/webroot/img/dotdot.png" alt=""></td>
                                                                <td> KidpreneurInc.com Subscription â€“ Quarterly online magazine to keep you up to date on the world of entrepreneurship and exciting work of Futurepreneurs.
                                                                </td>
                                                            </tr>
                                                             <tr>
                                                                <td style="width:20px; vertical-align:top;"><img src="'. Router::url('/', true) . 'app/webroot/img/dotdot.png" alt=""></td>
                                                                <td>  Curtis the Kidpreneur - Code Name Hawaii online book authored by Creel Price and James Roy.
                                                                </td>
                                                            </tr>
                                                             <tr>
                                                                <td style="width:20px; vertical-align:top;"><img src="'. Router::url('/', true) . 'app/webroot/img/dotdot.png" alt=""></td>
                                                                <td>  Exclusive invitations to online and real-world entrepreneurship events and special offers and discounts to help build an awesome business portfolio.
                                                                </td>
                                                            </tr>
                                                             <tr>
                                                                <td style="width:20px; vertical-align:top;"><img src="'. Router::url('/', true) . 'app/webroot/img/dotdot.png" alt=""></td>
                                                                <td>Free entry into the Kidpreneur Challenge Pitch Competition and Kidpreneur of the Year Awards. (Full details announced Term 2, 2018)
                                                                </td>
                                                            </tr>
                                                            </tbody>
                                                            </table>
                                                              
                                                         </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                </td>
                                                </tr>
                                                     
                                                         
                                                                   
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td style="color:#000;padding-bottom:0px; padding-top:20px;font-weight:bold">Important to note:</td>
                                </tr>
                                <tr>
                                <td>
                                     <table>
                                         <tr>
                                             <td>&#9679;</td>
                                             <td>Once your payment, by cheque, credit card or direct deposit, is received we will activate your online account and email you your login details.</td>
                                         </tr>
                                         <tr>
                                             <td>&#9679;</td>
                                             <td>Your welcome email will also include important details about the Kidpreneur Challenge program including a guide to accessing your Educator and Kidpreneur Dashboards, the Curriculum Toolkit and other teaching resources online at <a href="www.theentropolis.com">www.theentropolis.com.</a></td>
                                         </tr>
                                         <tr>
                                             <td>&#9679;</td>
                                             <td>If you have any questions or would like to discuss the program with a member of our team please phone 1300 464 388 or email <a href="info@kidpreneurchallenge.com">info@kidpreneurchallenge.com</a> . </td>
                                         </tr>
                                        
                                        
                                     </table>
                                 </td>
                                                    
                                </tr>

                                <tr>
                                <td style="color:#000; padding-bottom:0px;">
                                   Have an awesome Kidpreneur adventure!!
                                </td>
                                </tr>
                               <tr>
                                    <td style="color:#000;font-weight:bold;line-height: 2px;padding-left:5px;padding-top:20px; padding-right:5px;padding-bottom:0px;">Kidpreneur Challenge | HQ</td>
                                </tr>
                               
                                
                                 <tr>
                                    <td  style="color:#000;line-height: 2px;padding-top:20px;padding-bottom:0px;">
                                    Club Kidpreneur Ltd
                                    </td>
                                <tr>
                                    <td  style="color:#000;padding-bottom:0px;">
                                   ABN 13 144 623 709
                                    </td>
                                </tr>
                                <tr>
                                    <td style="color:#000;line-height: 2px;padding-bottom:0px;">
                                   ACNC Registered charity
                                </tr><br/>
                                
                                <tr>
                                    <td  style="color:#000;line-height: 2px;padding-bottom:0px;">
                                    E:<a href="mailto:info@clubkidpreneur.com" target="_blank">hq@theentropolis.com</a> |  P 1300 464 388
                                    </td>
                                </tr>
                                <tr>
                                    <td  style="color:#000;padding-bottom:0px;">
                                    Level 4, 16 Spring Street, Sydney NSW 2000 Australia
                                    </td>
                                </tr> 
                                <tr>
                                    <td  style="color:#000;padding-bottom:0px;">
                                   Powered by Entropolis Pty Ltd ABN 74 168 344 018
                                    </td>
                                </tr>
                                <tr>
                                    <td style=" padding-top:10px;padding-bottom:0px;font-size:11px;color:#b5b5b5;line-height:18px;font-family:Times New Roman">
                                         NOTICE - This communication contains information which is confidential and the copyright of Entropolis Pty Ltd or a third party. This email is intended to be read or used by the addressee only. If you are not the intended recipient, any use, distribution, disclosure or copying of this email is strictly prohibited without the authority of Entropolis Pty Ltd Please delete and destroy all copies and email us at hq@theentropolis.com immediately.
                                    </td>
                                </tr>
                                
                            </tbody></table>
                        </td>
                    </tr>
                </tbody></table>
            </td>
        </tr>
    </tbody></table>
</td>
</tr>
</tbody></table>
</div>
</body>';
           //echo $msg;
//                die;
                //mail send to the registered user
                $this->PHPEmail->send($registeredUserMail, $subject, $msg);
    }

    /**
     * Function to send mail regarding teacher/educator role registeration to HQ user  
     * Called for function kid_registration in usercontroller.php
     */
    public function HQTeacherRoleMail($profileId,$form_type) {

        //$User = ClassRegistry::init('User');
    

        $UserTeacherProfile = ClassRegistry::init('UserTeacherProfile');
        $State = ClassRegistry::init('State');
        $Country = ClassRegistry::init('Country');
        $Identity = ClassRegistry::init('Identity');
        $Contact = ClassRegistry::init('Contact');
        $Student = ClassRegistry::init('Student');
        $PaypalPlan = ClassRegistry::init('PaypalPlan');

        $profileDetails = $UserTeacherProfile->find('first', array('conditions' => array('UserTeacherProfile.id' => $profileId)));
        $planDetails = $PaypalPlan->find('first', array('conditions' => array('PaypalPlan.id' =>$profileDetails['UserTeacherProfile']['plan'])));
        if(is_numeric($profileDetails['UserTeacherProfile']['state']))
            $stateDetails = $State->find('first', array('conditions' => array('State.id' => $profileDetails['UserTeacherProfile']['state']), 'fields' => array('State.state_code')));
        else
            $stateDetails['State']['state_code']=$profileDetails['UserTeacherProfile']['state'];
        $countryDetails = $Country->find('first', array('conditions' => array('Country.id' => $profileDetails['User']['country_id']), 'fields' => array('Country.country_title')));
        
        $first_name = $profileDetails['User']['first_name'];
        $last_name =  $profileDetails['User']['last_name'];
        $username = $profileDetails['User']['username'];
        $email = $profileDetails['User']['email_address'];
        $subscription= $profileDetails['User']['subscription'];
       
        $schoolName = $profileDetails['UserTeacherProfile']['organization'];
        $state = $stateDetails['State']['state_code'];
        $country = $countryDetails['Country']['country_title'];
    
        $no_of_student = $profileDetails['UserTeacherProfile']['no_of_student_participate'];
        $year_group = $profileDetails['UserTeacherProfile']['year_group'];
        $taking_challenge = $profileDetails['UserTeacherProfile']['taking_challenge'];
        $pitch_competiotion = $profileDetails['UserTeacherProfile']['pitch_competiotion'];
        $message = $profileDetails['UserTeacherProfile']['message'];
        $kidpreneur_programs = $profileDetails['UserTeacherProfile']['kidpreneur_programs'];
        $entrepreneurship_programs = $profileDetails['UserTeacherProfile']['entrepreneurship_programs'];
        $club_kidpreneur = $profileDetails['UserTeacherProfile']['club_kidpreneur'];
        
        $phone_teacher = $profileDetails['UserTeacherProfile']['phone'];
     
        $identityDetails = $Identity->find('first', array('conditions' => array('Identity.id' => $profileDetails['UserTeacherProfile']['identity_id']), 'fields' => array('Identity.title')));
        $billing_address = $profileDetails['UserTeacherProfile']['billing_address'];

        $bestTimeTocontact = $profileDetails['UserTeacherProfile']['best_time_to_contact'];
        
        $best_time_contactDetails = $Contact->find('first', array('conditions' => array('Contact.id' => $bestTimeTocontact), 'fields' => array('Contact.title')));
        
        $class_number = $profileDetails['UserTeacherProfile']['class_number'];
        $educator_number = $profileDetails['UserTeacherProfile']['educator_number'];
        $deliver_program = $profileDetails['UserTeacherProfile']['deliver_program'];
        $kid_dashboard_permission = $profileDetails['UserTeacherProfile']['kid_dashboard_permission'];

        $kid_program = ($kidpreneur_programs == '1') ? 'Yes' : 'No';
        $entr_program = ($entrepreneurship_programs == '1') ? 'Yes' : 'No';
        $kid_dashboard_permission = ($kid_dashboard_permission == '1') ? 'Yes' : 'No';

        $studentDetail = $Student->find('all', array('conditions' => array('Student.registered_by' =>$profileDetails['UserTeacherProfile']['user_id'])));
       
        $studenInfo="";  
        //pr($studentDetail);
   
       // echo count($studentDetail[$i])."fdsfdsf";
       //  echo "<br/>"; 
       // echo count($studentDetail)."****";
$subject = "Kidpreneur Challenge 2018 - ".($form_type=="parent" ? ucfirst($form_type) : "Teacher")." Registration Confirmation";
    if($form_type!="parent"){
        for($i=0;$i<count($studentDetail);$i++){
                $student_gender = ($studentDetail[$i]['Student']['student_gender'] == '1') ? 'Male' : 'Female';
                $is_australian = ($studentDetail[$i]['Student']['is_australian'] == '1') ? 'Yes' : 'No';
                $parental_const = ($studentDetail[$i]['Student']['parental_const'] == '1') ? 'Yes' : 'No';
                
                $studenInfo .="<tr>
                                        <td>Student (".($i+1).") Details: </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <table  style='font-family: Arial; color:#000; font-size:12px;' cellpadding='5' cellspacing='0'>
                                                            <tr>
                                                                <td>Full Name: ".$studentDetail[$i]['Student']['first_name'].' '.$studentDetail[$i]['Student']['last_name']."</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Grade: ".$studentDetail[$i]['Student']['student_grade']."</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Age: ".$studentDetail[$i]['Student']['student_age']."</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Gender: ".$student_gender."</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Are You an Australian Resident?: ".$is_australian."</td>
                                                            </tr>
                                                            <tr>
                                                                <td>I have parental consent for this kidpreneur: ".$parental_const."</td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>";
            }
            $HQMailMsg = '<body>
<div><table width="800" cellpadding="50" cellspacing="0" style="font-family:Arial,Helvetica,sans-serif;color:#000;font-size:12px;background:#eee">
                    <tbody><tr>
                    <td width="100%">
                    <table cellpadding="0" cellspacing="0" width="100%">
                        <tbody><tr>
                            <td><img src="'. Router::url('/', true) . 'app/webroot/img/recieved.png" width="100%"></td>
                        </tr>
                        <tr>
                            <td>
                                <table width="100%" style="font-family:Arial;color:#000;font-size:12px;background:#fff;" cellpadding="0" cellspacing="20">
                                    <tbody><tr>
                                        <td>
                                            <table width="100%" style="font-family:Arial;color:#000;font-size:12px" cellpadding="7" cellspacing="0">
                                                <tbody>
                                                <tr>
                                                    <td style="padding:20px 5px;line-height:18px">Congratulations! You have just received a new School registration for the Kidpreneur Challenge 2018!</td>
                                                </tr>
                                                <tr>
                                                    <td style="color:#000;line-height:18px; padding:0px 0px 0px 5px;margin:0px;font-weight:bold;">DETAILS</td>
                                                </tr>
                                                <tr>
                                                    <td style="color:#000;line-height:18px; padding:0px 0px 0px 5px;margin:0px;">Package: <span>'.$planDetails['PaypalPlan']['plan_desc'].'</span></td>
                                                </tr>
                                                <tr>  
                                                    <td  style="color:#000;line-height:18px; padding:0px 0px 0px 5px;margin:0px;">Payment Status: <span>Pending</span> </td>
                                                </tr>
                                                <tr>
                                                    <td style="color:#000;padding:15px 0px 0px 5px;line-height:18px">Educator Name: <span>'. $first_name .'</span></td>
                                                </tr>
                                                <tr>
                                                    <td style="color:#000;line-height:18px; padding:0px 0px 0px 5px;margin:0px;"> Email Address: <span>'. $email .'</span></td>
                                                </tr>
                                                <tr>
                                                    <td style="color:#000;line-height:18px; padding:0px 0px 0px 5px;margin:0px;">Contact Number: <span>'. $phone_teacher .'</span></td>
                                                </tr>
                                                <tr>
                                                    <td style="color:#000;line-height:18px; padding:0px 0px 0px 5px;margin:0px;">Best Time to contact: <span>'. $best_time_contactDetails['Contact']['title'] .'  </span></td>
                                                </tr>
                                                <tr>
                                                    <td style="color:#000;line-height:18px; padding:0px 0px 0px 5px;margin:0px;">Username: <span>'. $username .'</span></td>
                                                </tr>
                                                <tr>
                                                    <td style="color:#000;padding:15px 0px 0px 5px;line-height:18px">School Name: <span>'. $schoolName .'</span></td>
                                                </tr>
                                                <tr>
                                                    <td style="color:#000;line-height:18px;padding:0px 0px 0px 5px;margin:0px;">Job Role/Title: <span>'. $identityDetails['Identity']['title'] .'</span></td>
                                                </tr>
                                                <tr>
                                                     <td style="color:#000;line-height:18px; padding:0px 0px 0px 5px;margin:0px;">State: <span>'. $state .'</span></td>
                                                </tr>
                                                <tr>
                                                    <td style="color:#000;padding:15px 0px 0px 5px;line-height:18px">Year Group: <span>' . $year_group . '</span></td>
                                                </tr>
                                                <tr>
                                                    <td style="color:#000;line-height:18px; padding:0px 0px 0px 5px;margin:0px;">When will the Challenge be taken: <span> '. $taking_challenge .'</span></td>
                                                </tr>
                                                <tr>
                                                <td style="color:#000;line-height:18px; padding:0px 0px 0px 5px;margin:0px;">Intend to enter the Pitch competition?: <span>'. $pitch_competiotion . '</span></td>
                                                </tr>
                                                <tr>
                                                    <td style="color:#000;padding:20px 0px 20px 5px;line-height:18px">Comments: <span>' . $message . '</span></td>
                                                </tr>
                                                
                                                <tr>
                                                    <td style="color:#000;padding:20px 0px 0px 5px;line-height:18px">First time running the Kidpreneur Challenge program?: <span>'. $kid_program .'</span></td>
                                                </tr>
                                                <tr>
                                                     <td style="color:#000;line-height:18px; padding:0px 0px 0px 5px;margin:0px;">Does the school run other entrepreneurship programs?:
                                                     <span>'. $entr_program .'</span></td>
                                                </tr>
                                                <tr>
                                                <td style="color:#000;line-height:18px; padding:0px 0px 0px 5px;margin:0px;">How did you hear about the Kidpreneur Challenge?: <span>'. $club_kidpreneur .'</span></td>
                                                </tr>
                                                <tr>
                                                <td style="color:#000;padding:20px 0px 0px 5px;font-weight:bold;line-height:18px; margin:0;">Entropolis | HQ</td>
                                                </tr>  
                                            </tbody></table>
                                        </td>
                                    </tr>
                                </tbody></table>
                            </td>
                        </tr>
                    </tbody></table>
                </td>
            </tr>
        </tbody></table>
        </div>
</body>';
                
                 }
    else{
        $subject = "Kidpreneur City – New Subscription";
                     for($i=0;$i<count($studentDetail);$i++){
                      $studenInfo .="<tr>
                                        <td>Student (".($i+1).") Details: </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <table  style='font-family: Arial; color:#000; font-size:12px;' cellpadding='5' cellspacing='0'>
                                                            <tr>
                                                                <td>First Initial: ".$studentDetail[$i]['Student']['first_name']."</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Last Name: ".$studentDetail[$i]['Student']['last_name']."</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Avatar Name: ".$studentDetail[$i]['Student']['avatar_name']."</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Password: ".$studentDetail[$i]['Student']['password']."</td>
                                                            </tr>
                                                            <tr>
                                                                <td>DOB: ".$studentDetail[$i]['Student']['student_dob']."</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Gender: ".$studentDetail[$i]['Student']['student_gender']."</td>
                                                            </tr>
                                                            <tr>
                                                                <td>School Name: ".$studentDetail[$i]['Student']['school_name']."</td>
                                                            </tr>
                                                             <tr>
                                                                <td>School Year Level: ".$studentDetail[$i]['Student']['student_schoollevel']."</td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>";
                 }
                  /*Parent registration email.*/
        $subscriptionText = "";
        
        switch ($subscription) {
            case "1":
                $subscriptionText ="Basic - $24.99 Registration fee ($6.99/month afterwards)";
                break;
            case "2":
                $subscriptionText ="Annual - $77.70 yearly fee";
                break;
            case "3":
                $subscriptionText ="Founding Citizen - $6216 yearly fee";
                break;

            default:
                $subscriptionText ="Basic - $24.99 Registration fee ($6.99/month afterwards)";
                break;
        }
        $HQMailMsg = "<body>
        
        <table width='800' cellpadding='50' cellspacing='0' style='font-family: Arial; color:#000; font-size:12px; background:#eee;'>
            <tr>
                <td  width='100%'>
                    <table cellpadding='0' cellspacing='0' width='100%'>
                        <tr>
                            <td><img src='" . Router::url('/', true) . "app/webroot/img/parent-registration-confirmed.png'></td>
                        </tr>
                        <tr>
                            <td>
                                <table width='100%' style='font-family: Arial; color:#000; font-size:12px; background:#fff' cellpadding='0' cellspacing='20'>
                                    <tr>
                                        <td>
                                            <table width='100%' style='font-family: Arial; color:#000; font-size:12px;' cellpadding='7' cellspacing='0'>
                                                <tr>
                                                    <td style='line-height: 18px;'>
                                                        Congratulations! You have just received a new Kidpreneur City registration!
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style='font-weight:bold;line-height: 18px;'>DETAILS</td>
                                                </tr>
                                                
                                                <tr>
                                                    <td style='line-height: 18px;'>
                                                        Payment Status: <span>Pending</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style='line-height: 18px;padding-top:20px;padding-bottom: 0;'>
                                                        Parent Name: <span>" . $first_name . "  " . $last_name . "</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style='line-height: 18px;padding-bottom: 0;'>
                                                        Contact Number: <span>" . $phone_teacher . " </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                   <td style='line-height: 18px;padding-bottom: 0;'>
                                                        Username: <span>" . $identityDetails['Identity']['title'] . " </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                   <td style='line-height: 18px;padding-bottom: 0;'>
                                                        &nbsp;
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <td style='line-height: 18px;padding-bottom: 0;'>
                                                        School Name: <span>" . $email . "</span>
                                                    </td>
                                                </tr>
                                               
                                                <tr>
                                                    <td style='line-height: 18px;padding-bottom: 0;'>
                                                        Job Role/Title: <span>" . $identityDetails['Identity']['title'] . "</span>
                                                    </td>
                                                </tr> 
                                                 <tr>
                                                    <td style='line-height: 18px;padding-bottom: 0;'>
                                                        State: <span>" . $state . "</span>
                                                    </td>
                                                </tr> 
                                                <tr>
                                                   <td style='line-height: 18px;padding-bottom: 0;'>
                                                        &nbsp;
                                                    </td>
                                                </tr>   
                                                <tr>
                                                   <td style='line-height: 18px;padding-bottom: 0;color:red;'>
                                                       Package: <span>" . $subscriptionText . "</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style='line-height: 18px;padding-bottom: 0;'>
                                                        Number of Students Participating: <span>" . $no_of_student . "</span>
                                                    </td>
                                                </tr>".$studenInfo."
                                                    
                                                <tr>
                                                    <td style='line-height: 18px;padding-bottom: 0;'>
                                                       Comments: <span>" . $subscriptionText . "</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                   <td style='line-height: 18px;padding-bottom: 0;'>
                                                        &nbsp;
                                                    </td>
                                                </tr>
                                                 <tr>
                                                    <td style='line-height: 18px;padding-bottom: 0;'>
                                                       How did you hear about the Kidpreneur Challenge Unicorns?: <span>" . $subscriptionText . "</span>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td style='line-height: 18px;padding-top:20px;'>
                                                        Regards,<br/>
                                                        <span style='font-weight:bold'>Kidpreneur Challenge | HQ</span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>".$this->commonFooter()."</table>
                </td>
            </tr>
        </table>
        </body>";
                 }
                 
          if(strtoupper($form_type) == strtoupper('parent'))
         {
              $sendToAdmin = HQ_EMAIL;
         }
         else
         {
            $sendToAdmin = HQ_CHALLENGE_EMAIL;
         }
        $this->PHPEmail->send($sendToAdmin, $subject, $HQMailMsg);
    }
    

    /**
     * Function to send mail to registered user for role teacher/educator after successfull payment through paypal.  
     * Called for function success in paymentcontroller.php
     */
    public function paypalPaymentSuccessTeacherRole($info_array) {

       
        $siteUrl = Router::url('/', true);

        $UserTeacherProfile = ClassRegistry::init('UserTeacherProfile');

        $Payment = ClassRegistry::init('Payment');
        $profileId = $info_array['profileId'];
        $transId = $info_array['transId'];
        $amt = $info_array['amt'];
        $currency_code = $info_array['currency_code'];
        $payment_status = $info_array['payment_status'];

  
       $profileDetails = $UserTeacherProfile->find('first', array('conditions' => array('UserTeacherProfile.id' => $profileId)));
    
        $password = base64_decode($profileDetails['UserTeacherProfile']['teacher_password']);
        if(!empty($profileId))
        {
            $paymentArray          = array('user_id' =>$profileId,'txn_id'=>$transId,'payment_gross'=>$amt,'currency_code'=>$currency_code,'payment_status'=>$payment_status,'payment_type'=>'Online');
            $savePayment        = $Payment->save($paymentArray);
           
            $UserTeacherProfile->updateAll(array('UserTeacherProfile.payment_status' => '"Success"'),array('UserTeacherProfile.id' => $profileId));
         
            $sendToRegisteredUser = $profileDetails['User']['email_address'];
            $subject = "Welcome to the Kidpreneur Challenge 2018";
               
                $msg = "<body><table width='800' cellpadding='50' cellspacing='0' style='font-family: Arial; color:#000; font-size:12px; background:#eee;'>
                <tr>
                <td  width='100%'>
                <table cellpadding='0' cellspacing='0' width='100%'>
                    <tr>
                        <td><img src='" . Router::url('/', true) . "app/webroot/img/register-kidpreneur-challenge.png'></td>
                    </tr>
                    <tr>
                        <td>
                            <table width='100%' style='font-family: Arial; color:#000; font-size:12px; background:#fff' cellpadding='0' cellspacing='20'>
                                <tr>
                                    <td>
                                        <table width='100%' style='font-family: Arial; color:#000; font-size:12px;' cellpadding='7' cellspacing='0'>
                                            <tr>
                                                <td>Dear <span>".$profileDetails['User']['first_name']."</span> <span>".$profileDetails['User']['last_name']."</span> </td>
                                            </tr>
                                            <tr>
                                                <td style='padding: 20px 5px;line-height: 18px;'>Thank you for registering for the Club Kidpreneur program. We are delighted you will join us on the mission to ignite the entrepreneurial spirit in Australian kids.</td>
                                            </tr>
                                            <tr>
                                                <td style='color: #000; padding-bottom: 0px; font-weight: bold;line-height: 18px;font-size:12px'>Registration Confirmation:</td>
                                            </tr>
                                            <tr>
                                                <td style='color: #000; padding-top: 5px;line-height: 18px;'>Your Kidpreneur Challenge 2018 Registration is confirmed. You have registered <span style='font-weight: bold'>".$profileDetails['UserTeacherProfile']['no_of_student_participate']."</span> <span style='font-weight: bold'>Kidpreneurs</span>. Please keep a copy of the online payment receipt for your records. If you did not receive a payment receipt, please advise via return email.</td>
                                            </tr>
                                            <tr>
                                                <td style='color: #000; padding-bottom: 0px; font-weight: bold'>Your Dashboard is Now Active</td>
                                            </tr>
                                             <tr>
                                                <td style='color: #000; padding-bottom: 0px;'>Login: <span>".$profileDetails['User']['email_address']."</span></td>
                                            </tr>
                                             <tr>
                                                <td style='color: #000; padding-bottom: 5px;'>Password: <span>".$password."</span></td>
                                            </tr>
                                            
                                            <tr>
                                                <td style='color: #000; padding-bottom: 10px; font-weight: bold'>Important to note:</td>
                                            </tr>
                                            <tr>
                                                <td style='padding: 0;'>
                                                    <table>
                                                        <tr>
                                                            <td style='margin: 0;'>
                                                                <ul style='padding-left: 35px; margin:0; line-height: 18px;font-size:12px'>
                                                                    <li>Club Kidpreneur is now hosted on our joint venture partner website theentropolis.com.</li>
                                                                    <li>
                                                                        Please go to '<a href='" . $siteUrl . "' style='color:blue' target='_blank'>" . $siteUrl . "</a>' click on the login button on the top right of your screen and use the login provided to access your Teacher Dashboard.
                                                                    </li>
                                                                    <li>Once you have logged into your dashboard you will be able to access the Kidpreneur Challenge Curriculum Toolkit (online teaching resource centre) via the menu link on the left hand side of your screen. Note: The curriculum and resources will be available from April 1, 2017</li>
                                                                    <li>Business in a Backpacks will be delivered to the address you provided by April 18, 2017.</li>
                                                                    <li>Please see attached pdf for detailed information on how to access your dashboard / curriculum toolkit and troubleshooting tips to ensure you get the most out of Club Kidpreneur @ theentropolis.com</li>
                                                                    <li>For questions in the meantime, please email kidpreneurs@theentropolis.com</li>
                                                                </ul>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style='color: #000; padding-bottom: 10px; font-weight: bold'>What to expect:</td>
                                            </tr>
                                            <tr>
                                                <td style='padding: 0;'>
                                                    <table>
                                                        <tr>
                                                            <td style='margin: 0;'>
                                                                <ul style='padding-left: 35px; margin:0; line-height: 18px;font-size:12px'>
                                                                   <li>The  Kidpreneur Challenge Curriculum Toolkit has all the materials you require to teach the Kidpreneur Challenge.</li>
                                                                    <li>
                                                                        A comprehensive Teacher Handbook will guide you through the 10-week program curriculum ReadySetGo, tips for running a market day and a summary of how the program maps to the ANC 8.2.
                                                                    </li>
                                                                    <li>Each module includes a lesson plan, video, student work sheet and backpack materials to reinforce each key learning objective.</li>


                                                                    <li>Supplementary resources include a Literacy Pack for our novel �Curtis the Kidpreneur� and access to a knowledge bank of 25,000+ entrepreneurship education materials and a digital network of like-minded educators.</li>

                                                                   

                                                                    <li>The intent of the program is for students to work in small teams of two, three or four
                                                                    to build a micro-business, sell hand-made products at market, and make enough revenue to cover
                                                                    their start-up costs and generate profits to donate to a worthy cause.</li>
                                                                </ul>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style='color: #000; padding-bottom: 10px; font-weight: bold'>Kidpreneur Challenge Pitch Competition:</td>
                                            </tr>
                                            <tr>
                                                <td style='padding: 0;'>
                                                    <table>
                                                        <tr>
                                                            <td style='margin: 0;'>
                                                                <ul style='padding-left: 35px; margin:0; line-height: 18px;font-size:12px'>
                                                                    <li>The Kidpreneur Challenge competition is an optional extra. It is a national primary-school entrepreneurship competition open to years 4, 5 & 6, which showcases the creativity and talent amongst students.</li>
                                                                    <li>
                                                                        After completing the ReadySetGo curriculum, students enter the competition by creating a video pitch about their business experience and product, which is uploaded by Club Kidpreneur to our YouTube channel and judged by real-life entrepreneurs. 10 teams will win prizes and business experiences for the students and the school. See the 2016 winners’ experience <a href='https://www.youtube.com/watch?v=wMuQ9S4qU9g' style='color:blue' target='_blank'>here</a>.
                                                                    </li>
                                                                    <li>Kidpreneur Challenge competition runs 1 September- 16 October, 2017 with judging on 24 October.  Please refer to the Terms and Conditions on our website for full details.</li>
                                                                </ul>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style='color: #000; padding-bottom: 10px; font-weight: bold;'>Stay in touch:</td>
                                            </tr>
                                            <tr>
                                                <td style='line-height: 18px;padding-top: 0;'>
                                                    Welcome to the Club Kidpreneur community; we can’t wait to hear the stories of your kidpreneurs’ business adventures.Please keep us posted along the way and don’t forget to tag us in your social media #kidpreneur, #clubkidpreneur or #kidpreneurchallenge. You will hear from us before the end of Term One as well.
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style='line-height: 18px;padding-top: 0;'>
                                                    If you would like to discuss the program with a member of our team please phone 1300 464 388 or email <a href='mailto:kidpreneurs@theentropolis.com' target='_blank' style='color:blue'>kidpreneurs@theentropolis.com</a>.
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style='line-height: 18px;padding-top: 20px;'>Warm regards,</td>
                                            </tr>
                                            <tr>
                                                <td style='font-weight:bold;line-height: 18px;font-size:13px;padding-bottom:0'>The Club Kidpreneur Team | <a href='http://www.theentropolis.com/kidpreneur_challenge/' target='_blank' style='color:blue'>www.theentropolis.com/kidpreneur_challenge/</a></td>
                                            </tr>
                                            <tr>
                                                <td style='line-height: 18px;font-size:13px;padding-top:0;padding-bottom:0'>
                                                    If you have any questions about this email please contact us at  <a href='mailto:kidpreneurs@theentropolis.com' style='color:blue' target='_blank'>kidpreneurs@theentropolis.com</a>
                                                </td>
                                            </tr>".$this->commonNoticeText()."</table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    ".$this->commonFooter()."</table>
            </td>
        </tr>
    </table>
    </body>";

   

    $attached_file_path = WWW_ROOT . DS . 'pdf'.DS.'TRPCTY_Login_AccessCurrToolkit.pdf';
    $this->PHPEmail->send($sendToRegisteredUser, $subject, $msg,  $attached_file_path );


        } 
    }   
    
     /**
     * Function to send mail to registered user for role teacher/educator after successfull payment through paypal.  
     * Called for function "sendUnsuccessMail" in paymentcontroller.php
     */
    public function paypalPaymentUnSuccessFullTeacherRole($profileId) {

       
        $siteUrl = Router::url('/', true);

        $UserTeacherProfile = ClassRegistry::init('UserTeacherProfile');

         $profileDetails = $UserTeacherProfile->find('first', array('conditions' => array('UserTeacherProfile.id' => $profileId)));
       
        $password = base64_decode($profileDetails['UserTeacherProfile']['teacher_password']);
       
        $sendToRegisteredUser = $profileDetails['User']['email_address'];
        $subject = "Kidpreneur Challenge 2018 - Payment Error";
                   
        $msg = "<body>
        <table width='800' cellpadding='50' cellspacing='0' style='font-family: Arial; color:#000; font-size:12px; background:#eee;'>
            <tr>
                <td  width='100%'>
                    <table cellpadding='0' cellspacing='0' width='100%'>
                        <tr>
                            <td><img src='" . Router::url('/', true) . "app/webroot/img/payment-unsuccessful.png'></td>
                        </tr>
                        <tr>
                            <td>
                                <table width='100%' style='font-family: Arial; color:#000; font-size:12px; background:#fff' cellpadding='0' cellspacing='20'>
                                    <tr>
                                        <td>
                                            <table width='100%' style='font-family: Arial; color:#000; font-size:12px;' cellpadding='7' cellspacing='0'>
                                                <tr>
                                                    <td style='font-weight:bold'>Dear <span>".$profileDetails['User']['first_name']."</span> <span>".$profileDetails['User']['last_name']."</span> </td>
                                                </tr>
                                                <tr>
                                                    <td style='line-height: 18px;'>
                                                        Uh Oh! We seem to have a problem …
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style='line-height: 18px;'>
                                                        Thank you for registering for the Kidpreneur Challenge 2018. We are delighted you will join us on the mission to ignite the entrepreneurial spirit in Australian kids.
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style='line-height: 18px;'>
                                                        You have registered ".$profileDetails['UserTeacherProfile']['no_of_student_participate']." Kidpreneurs but unfortunately there seems to be an error with your payment so we aren't able to confirm your order or give you access to your Teacher Dashboard and Kidpreneur Challenge Curriculum Toolkit just yet.
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style='line-height: 18px;'>
                                                        What now?
                                                    </td>
                                                </tr>
                                                <tr> 
                                                    <td style='line-height: 18px;'>
                                                        Your Dashboard is set up but not active. Follow the steps below to complete your payment and activate your account:
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style='padding: 0;'>
                                                        <table>
                                                            <tr>
                                                                <td style='margin: 0;'>
                                                                    <ul style='padding-left: 35px; margin:0; line-height: 18px;font-size:12px;list-style-type: decimal;'>
                                                                        <li>
                                                                            Go to <a href='" . $siteUrl . "' style='color:blue' target='_blank'>" . $siteUrl . "</a> click on the login button on the top right of your screen and use the login provided to access your Teacher Dashboard <span style='font-weight:bold'>Login:</span>  <span style='font-weight:bold'> ".$profileDetails['User']['email_address']." </span> | <span style='font-weight:bold'>Password:</span> <span style='font-weight:bold'>".$password."</span>
                                                                        </li>
                                                                        <li>
                                                                            Once you have logged into your dashboard you will be able to see your dashboard with a pop-up hovering over the top asking you to re-start the payment process.
                                                                        </li>
                                                                        <li>
                                                                            Complete the payment process
                                                                        </li>
                                                                        <li>
                                                                            Once the payment process is completed and your payment received you will be sent a confirmation email with all the information you need to get started with the Kidpreneur Challenge.
                                                                        </li>
                                                                    </ul>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style='line-height: 18px;'>
                                                        In the meantime, if you have any questions or you would like to discuss the program with a member of our team please phone 1300 464 388 or email <a href='mailto:kidpreneurs@theentropolis.com' style='color:blue' target='_blank'>kidpreneurs@theentropolis.com</a>.
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style='line-height: 18px;'>
                                                        See you soon!
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style='line-height: 18px;'>
                                                        Warm regards,
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style='font-weight:bold;line-height: 18px;font-size:13px;padding-bottom:0'>
                                                        The Club Kidpreneur Team | <a href='" . $siteUrl ."kidpreneur_challenge". "' style='color:blue' target='_blank'>" . $siteUrl ."kidpreneur_challenge". "</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style='line-height: 18px;font-size:13px;padding-top:0;padding-bottom:0'>
                                                        If you have any questions about this email please contact us at <a href='mailto:kidpreneurs@theentropolis.com' target='_blank' style='color:blue'>kidpreneurs@theentropolis.com</a>
                                                    </td>
                                                </tr>".$this->commonNoticeText()."
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>".$this->commonFooter()."</table>
                </td>
            </tr>
        </table></body>";  
         
        $this->PHPEmail->send($sendToRegisteredUser, $subject, $msg);
    }
    
    /**
     * Function to send mail to registered user for role teacher/educator after successfull payment through paypal.  
     * Called for function success in paymentcontroller.php
     */
    public function zohoPaymentSuccessTeacherRole($info_array) {

       
        $siteUrl = Router::url('/', true);

        $User = ClassRegistry::init('User');
        $UserTeacherProfile = ClassRegistry::init('UserTeacherProfile');

        $Payment = ClassRegistry::init('Payment');
        $profileId = $info_array['profileId'];
        $transId = $info_array['transId'];
        $amt = $info_array['amt'];
        $currency_code = $info_array['currency_code'];
        $payment_status = $info_array['payment_status'];

  
       $profileDetails = $User->find('first', array('conditions' => array('User.zoho_customer_id' => $profileId)));
       //debug($profileDetails);
    
        $password = base64_decode($profileDetails['UserTeacherProfile']['teacher_password']);
        
        if(!empty($profileId))
        {
            $paymentArray          = array('user_id' =>$profileId,'txn_id'=>$transId,'payment_gross'=>$amt,'currency_code'=>$currency_code,'payment_status'=>$payment_status,'payment_type'=>'Online');
            $savePayment        = $Payment->save($paymentArray);
           
            $UserTeacherProfile->updateAll(array('UserTeacherProfile.payment_status' => '"Success"'),array('UserTeacherProfile.id' => $profileDetails['UserTeacherProfile']['id']));
            $subscription=$profileDetails['User']['subscription'];
            switch ($subscription) {
                    case "1":
                        $planCode="Basic - $24.99 Registration fee ($6.99/month afterwards)";
                            break;
                    case "2":
                        $planCode="Annual - $77.70 yearly fee";
                            break;
                    case "3":
                        $planCode="Founding Citizen - $6216 yearly fee";
                            break;

                    default:
                        $planCode="Basic - $24.99 Registration fee ($6.99/month afterwards)";
                        break;
                }
         
            $sendToRegisteredUser = $profileDetails['User']['email_address'];
            $subject = "Welcome to Kidpreneur City – Subscription Confirmed";
               
                $msg = "<body>
        <table cellpadding='50' cellspacing='0' style='font-family: Arial; color:#000; font-size:12px; background:#eee;'>
            <tr>
                <td  >
                    <table cellpadding='0' cellspacing='0' >
                        <tr>
                            <td style='background-color:#d0cece;'><img src='" . Router::url('/', true) . "app/webroot/img/banner-subscription-confirmed.jpg' style='max-width: 100%; height: auto; width: auto;'></td>
                        </tr>
                        <tr>
                            <td>
                                <table  style='font-family: Arial; color:#000; font-size:12px; background:#fff' cellpadding='0' cellspacing='20'>
                                    <tr>
                                        <td>
                                            <table  style='font-family: Arial; color:#000; font-size:12px;' cellpadding='5' cellspacing='0'>
                                                <tr>
                                                    <td style='font-weight:bold'>Hi ".$profileDetails['User']['first_name']."</span> <span>".$profileDetails['User']['last_name']." </td>
                                                </tr>
                                                <tr>
                                                    <td style='line-height: 18px;'>
                                                      Thank you for signing up to Kidpreneur City, we are so excited you are sharing your entrepreneurial adventure with us.
                                                    </td>
                                                </tr>
                                                <tr>
                                                     <td>&nbsp;</td>
                                                    
                                                </tr>
                                                <tr>
                                                    <td>
                                                      <strong> Your Registration and Payment Confirmation</strong>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Your payment has been received and your Kidpreneur City subscription is set up. You have purchased a <span style='font-weight:bold'>".$planCode."</span> package. Please check the details on the pdf attached to this email to confirm what your package includes. Please keep a copy of the online payment receipt for your records. If you did not receive a payment receipt, please advise via return email.</td>
                                                </tr>
                                                <tr>
                                                     <td>&nbsp;</td>
                                                    
                                                </tr>
                                                <tr>
                                                    <td><strong>Your Parent Dashboard is Now Active</strong></td>
                                                    
                                                </tr>
                                                <tr>
                                                    <td>Support your future entrepreneurs as they embark on their awesome entrepreneur adventure, connect with other like-minded parents and educators and share wisdom and ideas on how to ignite the entrepreneurial spirit in the next generation.</td>
                                                    
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <table>
                                                            <tr>
                                                                <td>Login:</td>
                                                                <td>".$profileDetails['User']['email_address']." </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Password:</td>
                                                                <td>".$password."</td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                    
                                                </tr>
                                                
                                                <tr>
                                                    <td><strong>Child Privacy and Security at Entropolis:</strong></td>
                                                    
                                                </tr>
                                               <tr>
                                                     <td>
                                                         <table>
                                                             <tr>
                                                                 <td>&#9679;</td>
                                                                 <td>The Kidpreneur dashboards are secure and monitored 24 / 7 to ensure that all activity inside Entropolis complies with our online <a href='#' target='_blank'>Privacy and Security policy</a>.</td>
                                                             </tr>
                                                             <tr>
                                                                 <td>&#9679;</td>
                                                                 <td>All Kidpreneur accounts / dashboards are registered by a verified responsible adult (Educator / Parent) and they will receive all communications regarding Entropolis including on behalf of Kidpreneurs and related to Kidpreneur City.</td>
                                                             </tr>
                                                             <tr>
                                                                 <td>&#9679;</td>
                                                                 <td>Kidpreneurs use an avatar name and picture to identify themselves and are only allowed to post information about their Kidpreneur business online. There is no option for Kidpreneurs to provide, view or edit personal information.</td>
                                                             </tr>
                                                             <tr>
                                                                 <td>&#9679;</td>
                                                                 <td>Kidpreneurs are only given permission to discuss matters related to their entrepreneurial journey with other registered Kidpreneurs and the individual Educator / Parent who registered them.</td>
                                                             </tr>
                                                             <tr>
                                                                 <td>&#9679;</td>
                                                                 <td>They have no access to the Educator / Parent content libraries or information sharing and communication channels. You will be able to monitor your Kidpreneurs online activity via the Activity Feed on your dashboard however, you will not be able to interact with and Kidpreneurs directly other than the ones you have personally registered.</td>
                                                             </tr>
                                                             
                                                            
                                                         </table>
                                                     </td>
                                                    
                                                </tr>
                                                <tr>
                                                      <td>&nbsp;</td>
                                                </tr>
                                                 <tr>
                                                      <td><strong>Important to note</strong></td>
                                                </tr>

                                                  <tr>
                                                     <td>
                                                         <table>
                                                             <tr>
                                                                 <td>&#9679;</td>
                                                                 <td>Go to www.theentropolis.com click on the login button on the top right of your screen and use the login provided to access your Parent Dashboard.</td>
                                                             </tr>
                                                             <tr>
                                                                 <td>&#9679;</td>
                                                                 <td>Once you have logged into your dashboard you will be able to access curated content, tools and apps to help immerse you in the exciting world of entrepreneurship, and engage and support your kidpreneurs on their entrepreneurship adventure.</td>
                                                             </tr>
                                                             <tr>
                                                                 <td>&#9679;</td>
                                                                 <td>Please see attached pdf for detailed information on how to access your dashboard / Futurepreneurs toolkit and troubleshooting tips to ensure you get the most out of theentropolis.com.</td>
                                                             </tr>
                                                             <tr>
                                                                 <td>&#9679;</td>
                                                                 <td>For questions in the meantime, please email us at <a href='mailto:city@theentropolis.com'>city@theentropolis.com</a>.</td>
                                                             </tr>
                                                            
                                                             
                                                            
                                                         </table>
                                                     </td>
                                                    
                                                </tr>
                                                 <tr>
                                                      <td>For further information on the Entropolis Terms of Use and Privacy policy please go to <a href='http://www.theentropolis.com/terms-of-use' target='_blank'></a> or <a href='http://www.theentropolis.com/privacy-policy' target='_blank'></a> . Or you can contact us at <a href='mailto:city@theentropolis.com'>city@theentropolis.com</a></td>
                                                </tr> 
                                                <tr>
                                                      <td>&nbsp;</td>
                                                </tr>

                                                 <tr>
                                                      <td><strong>Stay in touch</strong></td>
                                                </tr>

                                                 <tr>
                                                      <td>Welcome to the Entropolis global community; we can’t wait to hear the stories of your kidpreneurs’ business adventures. Please keep us posted along the way and don’t forget to tag us in your social media #kidpreneur, #kidpreneurchallenge or #entropolis. You will hear from us regularly with helpful tips, tools and tricks to make your experience as great as possible.</td>
                                                </tr>
                                                <tr>
                                                    <td>If you would like to provide feedback or discuss anything with a member of our team please phone 1300 464 388 or email <a href='mailto:city@theentropolis.com'>city@theentropolis.com</a>.</td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                ".$this->commonFooter()."
                                                
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td valign='top' style='font-family: Arial; color:#000; font-size:11px; background-color:#E2E2E2;'>
                                <table  border='0' cellspacing='0' cellpadding='20'>
                                    <tr>
                                        <td style='font-family: Arial; color:#000; font-size:11px; background-color:#E2E2E2;'>
                                            <table  border='0' cellspacing='0' cellpadding='0'>
                                                <tr>
                                                    <td width='10'>&nbsp;</td>
                                                    <td  style='font-family: Arial; color:#000; font-size:11px; background-color:#E2E2E2;'>       LEVEL 4,16 SPRING STREET, SYDNEY, NSW 2000 | E: <a style='color:blue;text-decoration: none' href='mailto:citizens@theentropolis.com'>citizens@theentropolis.com</a> | <a href='http://theentropolis.com/?reqp=1&reqr=' style='color:blue; text-decoration: none' target='_blank'> www.theentropolis.com/ </a></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>";

    $attached_file_path = WWW_ROOT . DS . 'pdf'.DS.'TRPCTY_Login_AccessCurrToolkit.pdf';
    $this->PHPEmail->send($sendToRegisteredUser, $subject, $msg,  $attached_file_path );


        } 
    }   
    /**
     * Function to send mail regarding teacher/educator role registeration to HQ user  
     * Called for function kid_registration in usercontroller.php
     */
    public function HQParentRoleMail($profileId) {

        //$User = ClassRegistry::init('User');
    

        $UserTeacherProfile = ClassRegistry::init('UserTeacherProfile');
        $State = ClassRegistry::init('State');
        $Country = ClassRegistry::init('Country');
        $Identity = ClassRegistry::init('Identity');
        $Contact = ClassRegistry::init('Contact');
        $Student = ClassRegistry::init('Student');

        $profileDetails = $UserTeacherProfile->find('first', array('conditions' => array('UserTeacherProfile.id' => $profileId)));
        if(is_numeric($profileDetails['UserTeacherProfile']['state']))
            $stateDetails = $State->find('first', array('conditions' => array('State.id' => $profileDetails['UserTeacherProfile']['state']), 'fields' => array('State.state_code')));
        else
            $stateDetails['State']['state_code']=$profileDetails['UserTeacherProfile']['state'];
        $countryDetails = $Country->find('first', array('conditions' => array('Country.id' => $profileDetails['User']['country_id']), 'fields' => array('Country.country_title')));
        $first_name = $profileDetails['User']['first_name'];
        $last_name =  $profileDetails['User']['last_name'];
        $username = $profileDetails['User']['username'];
        $email = $profileDetails['User']['email_address'];
        $subscription= $profileDetails['User']['subscription'];
       
        $schoolName = $profileDetails['UserTeacherProfile']['organization'];
        $state = $stateDetails['State']['state_code'];
        $country = $countryDetails['Country']['country_title'];
    
        $no_of_student = $profileDetails['UserTeacherProfile']['no_of_student_participate'];
        $year_group = $profileDetails['UserTeacherProfile']['year_group'];
        $taking_challenge = $profileDetails['UserTeacherProfile']['taking_challenge'];
        $pitch_competiotion = $profileDetails['UserTeacherProfile']['pitch_competiotion'];
        $message = $profileDetails['UserTeacherProfile']['message'];
        $kidpreneur_programs = $profileDetails['UserTeacherProfile']['kidpreneur_programs'];
        $entrepreneurship_programs = $profileDetails['UserTeacherProfile']['entrepreneurship_programs'];
        $club_kidpreneur = $profileDetails['UserTeacherProfile']['club_kidpreneur'];
        
        $phone_teacher = $profileDetails['UserTeacherProfile']['phone'];
     
        $identityDetails = $Identity->find('first', array('conditions' => array('Identity.id' => $profileDetails['UserTeacherProfile']['identity_id']), 'fields' => array('Identity.title')));
        $billing_address = $profileDetails['UserTeacherProfile']['billing_address'];

        $bestTimeTocontact = $profileDetails['UserTeacherProfile']['best_time_to_contact'];
        
        $best_time_contactDetails = $Contact->find('first', array('conditions' => array('Contact.id' => $bestTimeTocontact), 'fields' => array('Contact.title')));
        
        $class_number = $profileDetails['UserTeacherProfile']['class_number'];
        $educator_number = $profileDetails['UserTeacherProfile']['educator_number'];
        $deliver_program = $profileDetails['UserTeacherProfile']['deliver_program'];
        $kid_dashboard_permission = $profileDetails['UserTeacherProfile']['kid_dashboard_permission'];

        $kid_program = ($kidpreneur_programs == '1') ? 'Yes' : 'No';
        $entr_program = ($entrepreneurship_programs == '1') ? 'Yes' : 'No';

        $studentDetail = $Student->find('all', array('conditions' => array('Student.registered_by' =>$profileDetails['UserTeacherProfile']['user_id'])));
       
        $studenInfo="";  
//        debug($studentDetail);
//   die;
       // echo count($studentDetail[$i])."fdsfdsf";
       //  echo "<br/>"; 
       // echo count($studentDetail)."****";
    
        $subject = "Kidpreneur City – New Subscription";
                     for($i=0;$i<count($studentDetail);$i++){
                      $studenInfo .="<tr>
                                        <td>Student (".($i+1).") Details: </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <table  style='font-family: Arial; color:#000; font-size:12px;' cellpadding='5' cellspacing='0'>
                                                            <tr>
                                                                <td>First Initial: ".$studentDetail[$i]['Student']['first_name']."</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Last Name: ".$studentDetail[$i]['Student']['last_name']."</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Avatar Name: ".$studentDetail[$i]['Student']['avatar_name']."</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Password: ".$studentDetail[$i]['Student']['password']."</td>
                                                            </tr>
                                                            <tr>
                                                                <td>DOB: ".$studentDetail[$i]['Student']['student_dob']."</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Gender: ".$studentDetail[$i]['Student']['student_gender']."</td>
                                                            </tr>
                                                            <tr>
                                                                <td>School Name: ".$studentDetail[$i]['Student']['school_name']."</td>
                                                            </tr>
                                                             <tr>
                                                                <td>School Year Level: ".$studentDetail[$i]['Student']['student_schoollevel']."</td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>";
                 }
                  /*Parent registration email.*/
        $subscriptionText = "";
        
        switch ($subscription) {
            case "1":
                $subscriptionText ="Basic - $24.99 Registration fee ($6.99/month afterwards)";
                break;
            case "2":
                $subscriptionText ="Annual - $77.70 yearly fee";
                break;
            case "3":
                $subscriptionText ="Founding Citizen - $6216 yearly fee";
                break;

            default:
                $subscriptionText ="Basic - $24.99 Registration fee ($6.99/month afterwards)";
                break;
        }
        $HQMailMsg = "<body>
        
        <table width='800' cellpadding='50' cellspacing='0' style='font-family: Arial; color:#000; font-size:12px; background:#eee;'>
            <tr>
                <td  width='100%'>
                    <table cellpadding='0' cellspacing='0' width='100%'>
                        <tr>
                            <td style='background-color:#d0cece;'><img src='" . Router::url('/', true) . "app/webroot/img/entr-new-subscriber.jpg'></td>
                        </tr>
                        <tr>
                            <td>
                                <table width='100%' style='font-family: Arial; color:#000; font-size:12px; background:#fff' cellpadding='0' cellspacing='20'>
                                    <tr>
                                        <td>
                                            <table width='100%' style='font-family: Arial; color:#000; font-size:12px;' cellpadding='7' cellspacing='0'>
                                                <tr>
                                                    <td style='line-height: 18px;'>
                                                        Congratulations! You have just received a new Kidpreneur City registration!
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style='font-weight:bold;line-height: 18px;'>DETAILS</td>
                                                </tr>
                                                
                                                <tr>
                                                    <td style='line-height: 18px;'>
                                                        Payment Status: <span>Confirmed</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style='line-height: 18px;padding-top:20px;padding-bottom: 0;'>
                                                        Parent Name: <span>" . $first_name . "  " . $last_name . "</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style='line-height: 18px;padding-bottom: 0;'>
                                                        Contact Number: <span>" . $phone_teacher . " </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                   <td style='line-height: 18px;padding-bottom: 0;'>
                                                        Username: <span>" . $identityDetails['Identity']['title'] . " </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                   <td style='line-height: 18px;padding-bottom: 0;'>
                                                        &nbsp;
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <td style='line-height: 18px;padding-bottom: 0;'>
                                                        Email: <span>" . $email . "</span>
                                                    </td>
                                                </tr>
                                               
                                                <tr>
                                                    <td style='line-height: 18px;padding-bottom: 0;'>
                                                        Job Role/Title: <span>" . $identityDetails['Identity']['title'] . "</span>
                                                    </td>
                                                </tr> 
                                                <tr>
                                                    <td style='line-height: 18px;padding-bottom: 0;'>
                                                        Country: <span>" . $country . "</span>
                                                    </td>
                                                </tr>
                                                 <tr>
                                                    <td style='line-height: 18px;padding-bottom: 0;'>
                                                        State: <span>" . $state . "</span>
                                                    </td>
                                                </tr> 
                                                <tr>
                                                   <td style='line-height: 18px;padding-bottom: 0;'>
                                                        &nbsp;
                                                    </td>
                                                </tr>   
                                                <tr>
                                                   <td style='line-height: 18px;padding-bottom: 0;color:red;'>
                                                       Package: <span>" . $subscriptionText . "</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style='line-height: 18px;padding-bottom: 0;'>
                                                        Number of Students Participating: <span>" . $no_of_student . "</span>
                                                    </td>
                                                </tr>".$studenInfo."
                                                    
                                                <tr>
                                                    <td style='line-height: 18px;padding-bottom: 0;'>
                                                       Comments: <span>" . $message . "</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                   <td style='line-height: 18px;padding-bottom: 0;'>
                                                        &nbsp;
                                                    </td>
                                                </tr>
                                                 <tr>
                                                    <td style='line-height: 18px;padding-bottom: 0;'>
                                                       How did you hear about the Kidpreneur Challenge Unicorns?: <span>" . $club_kidpreneur . "</span>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td style='line-height: 18px;padding-top:20px;'>
                                                        Regards,<br/>
                                                        ".$this->commonFooter()."
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr></table>
                </td>
            </tr>
        </table>
        </body>";
//        echo $HQMailMsg;
//                die;
        $sendToAdmin = HQ_EMAIL;
        $this->PHPEmail->send($sendToAdmin, $subject, $HQMailMsg);
    }

     /**
     * Function to send mail to registered user for role teacher/educator after successfull payment through paypal.  
     * Called for function "forgot_password" in usercontroller.php
     */
    public function forgotPasswordMail($info_array) {

        $siteUrl = Router::url('/', true);

        $userId = $info_array['userId'];
        $varificationCode = $info_array['varificationCode'];
        $first_name = $info_array['first_name'];
        $last_name = $info_array['last_name'];
        $email = $info_array['email'];

     
        $subject = "Reset Password | TheEntropolis.com";        
        $verificactionLink = "<a href='" . $siteUrl . "users/reset_password/" . $userId . "/" . $varificationCode . "'> Click here to reset your password</a>";
        $msg = "<body>
            <table width='800' cellpadding='50' cellspacing='0' style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px; background:#eee;'>
                <tr>
                    <td width='100%'>
                        <table cellpadding='0' cellspacing='0' width='100%'>
                            <tr>
                                <td><img src='" . $siteUrl . "app/webroot/img/ENTR-About.jpg'></td>
                            </tr>
                            <tr>
                                <td><table style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px; background:#fff' cellpadding='0' cellspacing='20'>
                            <tr>
                                <td><table style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px;' cellpadding='7' cellspacing='0'>
                            <tr>
                                <td >Hi " . $first_name . ' ' . $last_name . ",</td>
                            </tr>
                            <tr>
                                <td>Have you forgotten your Entropolis password? That's ok …<br/>
                                you can reset your password by clicking on the link below or copying and pasting it into your browser.
                                </td>
                            </tr>                                           
                            <tr>
                                <td > <a style='color:blue' href='". $siteUrl . "users/reset_password/" . $userId . "/" . $varificationCode ."'> " . $siteUrl . "users/reset_password/" . $userId . "/" . $varificationCode . " </a></td>
                            </tr>                                           
                            <tr>
                                <td >Stay active, explore and have fun in your City! If we can do anything to help, please contact us at <a href ='mailto:citizens@theentropolis.com' style='color:blue'>citizens@theentropolis.com</a> </td>
                            </tr>

                            <tr>
                                <td >See you soon in Entropolis! </td>
                            </tr>

                            <tr>
                                <td style=''>
                                    <b>Entropolis HQ</b><br>
                                    <b>Inspiring, Educating, Empowering and Connecting Future Entrepreneurs.</b><br>
                                    Entropolis Pty Ltd<br>
                                    ABN 74 168 344 018<br>
                                    Level 4, 16 Spring Street<br>
                                    Sydney NSW 2000<br>
                                    Australia<br><br>
                                   <strong>E</strong> <a href='mailto:hq@theentropolis.com'>hq@theentropolis.com</a><br>
                                    <b>P</b> 1300 464 388 <br>
                                    <a href='http://www.theentropolis.com/challenge' target='_blank'>www.theentropolis.com/challenge</a>
                                </td>
                            </tr>
                             
                                               
                                                <tr>
                                                    <td style='line-height: 18px; color: #909090'>
                                                        NOTICE - This communication contains information which is confidential and the copyright of Entropolis Pty Ltd or a third party. This email is intended to be read or used by the addressee only. If you are not the intended recipient, any use, distribution, disclosure or copying of this email is strictly prohibited without the authority of Entropolis Pty Ltd Please delete and destroy all copies and email us at <a href='mailto:hq@theentropolis.com'>hq@theentropolis.com</a> immediately.
                                                        
                                                    </td>
                                                </tr>
                    </table></td>
                    </tr>
                    </table></td>
                    </tr>
                </table></td>
                </tr></table>
                            </td>
                    </tr>
            </table>
            </body>";
      // echo $msg;
        $this->PHPEmail->send($email, $subject, $msg);
    } 

    
     /**
     * Function to send mail to HQ user to intimate about new suggestion posted by other users.  
     * Called for function "saveSuggestion" in Suggestioncontroller.php
     */

     public function sendSuggestionMailHQ($suggestion)
     {
        $loggedin_user = CakeSession::read('user_id');    
        $User = ClassRegistry::init('User');
        $sender = $User->find('first', array('conditions'=>array('User.id'=>$loggedin_user),'fields'=>array('email_address','first_name','last_name')));
                
        $subject = "New Message – Suggestion Box | TheEntropolis.com";
        $from   = $sender['User']['email_address'];
          
        
        $sender_name = $sender['User']['first_name'].' '.$sender['User']['last_name'];
        $siteUrl = Router::url('/', true);
          
        
         
        $msg  = "<body>
        <table width='800' cellpadding='50' cellspacing='0' style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px; background:#eee;'>
            <tr>
                <td  width='100%'>
                    <table cellpadding='0' cellspacing='0' width='100%'>
                        <tr>
                           <td><img src='".$siteUrl."app/webroot/img/suggestion_box.jpg'></td>
                        </tr>
                        <tr>
                            <td>
                                <table width='100%' style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px; background:#fff' cellpadding='0' cellspacing='20'>
                                    <tr>
                                        <td>
                                            <table width='100%' style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px;' cellpadding='7' cellspacing='0'>
                                               <tr>
                                                <td >Hello Entropolis HQ,</td>
                                            </tr>
                                            <tr>
                                               <td>You have received a new message via Suggestion Box forum.
                                                </td>
                                            </tr>
                                            <tr>
                                                <td ><b>From:</b> ".$sender_name." </td>
                                            </tr>
                                            <tr>
                                                <td ><b>Suggestion:</b> ".$suggestion."</td>
                                            </tr>
                                             <tr>
                                <td style=''>
                                    <b>Entropolis HQ</b><br>
                                    <b>Futureproofing the Next Generation through Entrepreneurship Education and Immersive experience</b><br><br>
                                    Entropolis Pty Ltd<br>
                                    ABN 74 168 344 018<br><br>
                                    Level 4, 16 Spring Street<br>
                                    Sydney NSW 2000<br>
                                    Australia<br><br>
                                   <strong>E</strong> <a href='mailto:hq@theentropolis.com'>hq@theentropolis.com</a><br>
                                    <b>P</b> 1300 464 388 <br><br>
                                    <a href='http://www.theentropolis.com' target='_blank'>www.theentropolis.com</a>
                                </td>
                            </tr>
                             
                                               
                                                <tr>
                                                    <td style='line-height: 18px; color: #909090'>
                                                        NOTICE - This communication contains information which is confidential and the copyright of Entropolis Pty Ltd or a third party. This email is intended to be read or used by the addressee only. If you are not the intended recipient, any use, distribution, disclosure or copying of this email is strictly prohibited without the authority of Entropolis Pty Ltd Please delete and destroy all copies and email us at <a href='mailto:hq@theentropolis.com'>hq@theentropolis.com</a> immediately.
                                                        
                                                    </td>
                                                </tr>

                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>";  

       // $sendToHQ = 'prospus.artisharma@gmail.com';    
        $sendToHQ = HQ_EMAIL;     
        $this->PHPEmail->send($sendToHQ, $subject, $msg);
   }

    /**
     * Function to send mail to the user in network of logged in user and  HQ user in case of Role Kidpreneur.  
     * Called for function "add_question" in AskQuestioncontroller.php
     */

    public function sendMailToNetworkUser($user_array_data)
    {
       
        $user_id_network = $user_array_data['user_id_network'];
        $role_type = $user_array_data['role_type'];
        $sendTo = $user_array_data['sendTo'];
        $usrname = $user_array_data['user_name'];
        $ask_type = $user_array_data['ask_type'];
        $parent_name  = $user_array_data['parent_name'];

        $loggedin_user = CakeSession::read('user_id');    
        $User = ClassRegistry::init('User');

        if($role_type =='allRole') {
                $network_user = $User->find('first', array('conditions'=>array('User.id'=>$user_id_network),'fields'=>array('email_address','first_name','last_name')));
                $sendTo = $network_user['User']['email_address'];
                $userName = "Hello ".$network_user['User']['first_name'].' '. $network_user['User']['last_name'];
                

        }else
        {
           
            $sendTo = $sendTo;
            $userName = 'Hello '.$usrname;
           
        }

        
        $module_name = "ASK AN ADULT";

        $sender = $User->find('first', array('conditions'=>array('User.id'=>$loggedin_user),'fields'=>array('email_address','first_name','last_name')));
               
        $subject = "NEW REQUEST FOR ADVICE";
        $from   = $sender['User']['email_address'];
      

        $sender_name = $sender['User']['first_name'].' '.$sender['User']['last_name'];
        $siteUrl = Router::url('/', true);         
        
         
        $msg  = "<body>
                           <table width='800' cellpadding='50' cellspacing='0' style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px; background:#eee;'>
                   <tr>
                       <td  width='100%'>
                           <table cellpadding='0' cellspacing='0' width='100%' >
                                            <tr>
                                                <td><img src='".$siteUrl."app/webroot/img/ENTR-About.jpg' width ='100%'></td>
                                            </tr>
                                            <tr>
                                                <td><table style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px; background:#fff' cellpadding='0' cellspacing='20' width='100%'>
                                            <tr>
                                                <td><table style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px;' cellpadding='7' cellspacing='0'>
                                            <tr>
                                                <td >".$userName.",</td>
                                            </tr>";

                                            if($ask_type =='Indirect')
                                            {
                                                $msg.="<tr>
                                                <td>Great news! ".$sender_name." has asked ".$parent_name." a direct question and requested your advice via the ".$module_name." app.</td>
                                            </tr>";
                                            }
                                            else
                                            {
                                            $msg.="<tr>
                                                <td>Great news! ".$sender_name." has asked you a direct question and requested your advice via the ".$module_name." app.</td>
                                            </tr>";
                                            }
                                        
                                              $msg.="<tr>
                                                <td>Please login to your dashboard and click on the New item in your activity feed to add your wisdom. 
                                              </td>  
                                            </tr>
                                            <tr>
                                                <td >Thanks for being an awesome Citizen and see you soon in Entropolis.</td>
                                            </tr>";

                                            if($role_type =='HQ')
                                            {
                                               $msg  .="<tr>
                                                                               <td >
                                            Regards,
                                            <br><br>
                                            <strong>Entropolis | HQ</strong></td>
                                                                           </tr>";
                                            }
                                            else
                                            {
                                                $msg  .="<tr>
                                <td style=''>
                                    <b>Entropolis HQ</b><br>
                                    <b>Futureproofing the Next Generation through Entrepreneurship Education and Immersive experience</b><br><br>
                                    Entropolis Pty Ltd<br>
                                    ABN 74 168 344 018<br><br>
                                    Level 4, 16 Spring Street<br>
                                    Sydney NSW 2000<br>
                                    Australia<br><br>
                                   <strong>E</strong> <a href='mailto:hq@theentropolis.com'>hq@theentropolis.com</a><br>
                                    <b>P</b> 1300 464 388 <br><br>
                                    <a href='http://www.theentropolis.com' target='_blank'>www.theentropolis.com</a>
                                </td>
                            </tr>
                             
                                               
                                                <tr>
                                                    <td style='line-height: 18px; color: #909090'>
                                                        NOTICE - This communication contains information which is confidential and the copyright of Entropolis Pty Ltd or a third party. This email is intended to be read or used by the addressee only. If you are not the intended recipient, any use, distribution, disclosure or copying of this email is strictly prohibited without the authority of Entropolis Pty Ltd Please delete and destroy all copies and email us at <a href='mailto:hq@theentropolis.com'>hq@theentropolis.com</a> immediately.
                                                        
                                                    </td>
                                                </tr>";
                                            }
                                            $msg  .="</table>

                                            </td>
                                            
                                            </tr>
                                            </table></td>
                                          </tr></table>
                                            </td>
                                    </tr>
                            </table>
                            </body>";   

        $this->PHPEmail->send($sendTo, $subject, $msg);
    
        
    }

    /**
    * Function to send message through mail to the user.  
    * Called for function "SendMessage" in pagescontroller.php
    */
    public function SendMessageToUser( $message_array )
    {       
        $loggedin_user = CakeSession::read('user_id');  
         $context_ary= CakeSession::read('context-array'); 
          $context_role_user_id = CakeSession::read('context_role_user_id'); 

            $invitee_user_id = $message_array['invitee_user_id'];
            $inviter_user_id = $message_array['inviter_user_id'];
            $message = $message_array['message'];
            $message_sent = $message_array['message_sent'];
            $group_name = $message_array['group_name'];


        $User = ClassRegistry::init('User');

                $User->recursive = -1;
                $invitee = $User->find('first', array('conditions' => array('User.id' => $invitee_user_id), 'fields' => array('email_address', 'first_name', 'last_name')));
                $inviter = $User->find('first', array('conditions' => array('User.id' => $inviter_user_id), 'fields' => array('email_address', 'first_name', 'last_name')));


                // to send mail the user credential to this new user 
                $sendTo = $invitee['User']['email_address'];
             
                $subject = "New Message | TheEntropolis.com";
                $from = $inviter['User']['email_address'];
                $sender_name = $inviter['User']['first_name'] . ' ' . $inviter['User']['last_name'];
                $userName = $invitee['User']['first_name'];
                $last_name = $invitee['User']['last_name'];
                $siteUrl = Router::url('/', true);

                if (in_array('6', $context_ary)) {
                    $link = $siteUrl . "pages/sageProfile/" . $context_role_user_id;
                    $profile_link = "<a href='" . $link . "'>Citizen|Profile</a>";
                } else {
                    $link = $siteUrl . "pages/seekerProfile/" . $context_role_user_id;
                    $profile_link = "<a href='" . $link . "'>Citizen|Profile</a>";
                }

                $msg = "<body>
                            <table width='800' cellpadding='50' cellspacing='0' style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px; background:#eee;'>
                                <tr>
                                    <td>
                                        <table cellpadding='0' cellspacing='0'>
                                            <tr>
                                                <td><img src='" . $siteUrl . "app/webroot/img/ENTR-About.jpg'></td>
                                            </tr>
                                            <tr>
                                                <td><table style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px; background:#fff' cellpadding='0' cellspacing='20'>
                                            <tr>
                                                <td><table style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px;' cellpadding='7' cellspacing='0'>
                                            <tr>
                                                <td >Hi " . $userName . ",</td>
                                            </tr>
                                            <tr>
                                                <td>Great news, you have received a new message from:</td>
                                            </tr>";
                                            if($message_sent =='group')
                                            {
                                                    $msg .= "<tr>
                                                <td ><b>Group Name | </b>" . $group_name . "</td>
                                            </tr> ";   
                                            }
                                                 $msg .= "<tr>
                                                <td ><b>Citizen | </b>" . $sender_name . "</td>
                                            </tr>
                                            <tr>
                                                <td ><b> Messsage | </b> " . nl2br($message) . "</td>
                                            </tr>
                                            
                                            <tr>
                                                <td >If we can do anything to help, please contact us at <a href ='mailto:hq@theentropolis.com' style='color:blue;'>hq@theentropolis.com </a> </td>
                                            </tr>
                                            
                                            <tr>
                                                <td style=''><b>The Team@EntropolisHQ</b><br>
                                                <b><a href='#' style='color:#000; text-decoration:none;'>www.theentropolis.com</a> |  #PlacetobeforEntrepreneurs</b></td>
                                            </tr>
                                            <tr>
                                                <td><table  cellpadding='0' cellspacing='0' style='color:#b2b2b2; font-size:11px; font-family: Arial, Helvetica, sans-serif; line-height:13px'>
                                            <tr>
                                                    <td> IMPORTANT INFORMATION *</td>
                                            </tr>
                                            <tr>
                                                    <td >This document should be read only by those persons to whom it is addressed and its content is not intended for use by any other persons. If you have received this message in error, please notify us immediately at  <a href ='mailto:hq@theentropolis.com' style='color:blue;'>hq@theentropolis.com</a>. Please also destroy and delete the message from your computer. Any unauthorised form of reproduction of this message is strictly prohibited. </td><br/>
                                            </tr>
                                            <tr>
                                                    <td>Entropolis Pty Ltd is not liable for the proper and complete transmission of the information contained in this communication, nor for any delay in its receipt.</td>
                                            </tr>
                                    </table></td>
                                                                                                            </tr>
                                                                                                    </table></td>
                                                                                    </tr>
                                                                            </table></td>
                                                          </tr></table>
                                            </td>
                                    </tr>
                            </table>
                            </body>";

                 // $sendTo = 'prospus.artisharma@gmail.com';
                 $this->PHPEmail->send($sendTo, $subject, $msg);

    }
    public function goldenPitchAdminMail($pitchDetails){
        
        $studenInfo="";
        $stdKey=0;
        foreach($pitchDetails['KgpcStudent'] as $kcpcStudent){
                   
                $student_gender = ($kcpcStudent['student_gender'] == '1') ? 'Male' : 'Female';
                $is_australian = ($kcpcStudent['is_australian'] == '1') ? 'Yes' : 'No';
                $parental_const = ($kcpcStudent['parental_const'] == '1') ? 'Yes' : 'No';
                
                $studenInfo .="<tr>
                                                    <td>Student (".($stdKey+1).") Details</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <table  style='font-family: Arial; color:#000; font-size:12px;' cellpadding='5' cellspacing='0'>
                                                            <tr>
                                                                <td>Full Name: ".$kcpcStudent['student_fullname']."</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Grade: ".$kcpcStudent['student_grade']."</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Age: ".$kcpcStudent['student_age']."</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Gender: ".$student_gender."</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Are You an Australian Resident?: ".$is_australian."</td>
                                                            </tr>
                                                            <tr>
                                                                <td>I have parental consent for this kidpreneur: ".$parental_const."</td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>";
                $stdKey++;
                }
        
        //echo $this->PitchGoldenEntryForm->getLastQuery();
                $pitchDetails=$pitchDetails['PitchGoldenEntryForm'];
                $intend_for_bussiness = ($pitchDetails['intend_for_bussiness'] == '1') ? 'Yes' : 'No';
                $entrepreneurship_education = ($pitchDetails['entrepreneurship_education'] == '1') ? 'Yes' : 'No';
                $donate_money = ($pitchDetails['donate_money'] == '1') ? 'Yes' : 'No';
                $subscribe = ($pitchDetails['subscribe'] == '1') ? 'Yes' : 'No';
                $teacher_html="";
                $donation_html="";
                //if($pitchDetails['entrepreneurship_education'] == '1'){
                    if(true){
                $teacher_html="<tr>
                                                                <td>What is your School Name? (If different to the above): ".$pitchDetails['teacher_school']."</td>
                                                            </tr>";
                }
                //if($pitchDetails['donate_money'] == '1'){
                    
                if(true){    
                $donation_html=" <tr>
                                                                <td>How much money did you donate to them?: ".$pitchDetails['donation']."</td>
                                                            </tr>";
                }
        $subject = "Kidpreneur Challenge Ninjas Pitch Competition - Entry Received";
        $from = "support@theentropolis.com";
        $MailMsg = "  <body>
        <table cellpadding='50' cellspacing='0' style='font-family: Arial; color:#000; font-size:12px; background:#eee;'>
            <tr>
                <td  >
                    <table cellpadding='0' cellspacing='0' >
                        <tr>
                            <td style='background-color:#BEC7CC;'><img src='" . Router::url('/', true) . "app/webroot/img/ninja-golden-received.jpg' style='max-width: 100%; height: auto; width: auto;''></td>
                        </tr>
                        <tr>
                            <td style='background-color:white;'>
                                <table  style='font-family: Arial; color:#000; font-size:12px; background:#fff' cellpadding='0' cellspacing='20'>
                                    <tr>
                                        <td>
                                                <table  style='font-family: Arial; color:#000; font-size:12px;' cellpadding='5' cellspacing='0'>
                                                <tr>
                                                    <td style='font-weight:bold'>Dear Kidpreneur HQ, </td>
                                                </tr>
                                                <tr>
                                                    <td style='line-height: 18px;'>
                                                        A new entry for the Kidpreneur Challenge Ninjas Pitch Competition has been received via <a href='http://www.entropolis.com' target='_blank'>www.entropolis.com</a>.
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        The entry details for your records are as follows:
                                                    </td>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                               <tr>
                                                                <td>Year: ".date('Y')."</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Submitter's First Name: ".$pitchDetails['first_name']."</td>
                                                            </tr>
                                                             <tr>
                                                                <td>Submitter's Last Name: ".$pitchDetails['last_name']."</td>
                                                            </tr>
                                                             <tr>
                                                                <td>Submitter's Email Address: ".$pitchDetails['email_address']."</td>
                                                            </tr>
                                                             <tr>
                                                                <td>Submitter's Contact Number: ".$pitchDetails['phone']."</td>
                                                            </tr>
                                                            <tr>
                                                                <td>State: ".$pitchDetails['state']."</td>
                                                            </tr>

                                                             <tr>
                                                                <td>Select ID: ".$pitchDetails['role_id']."</td>
                                                            </tr>
                                                             
                                                            
                                                                                                                      

                                                             <tr>
                                                                <td>How many Kidpreneurs own this business?: ".$pitchDetails['kidpreneur_no']."</td>
                                                            </tr>".$studenInfo."
                                                             <tr>
                                                                <td>What type of Pitch are you submitting: ".$pitchDetails['pitch']."</td>
                                                            </tr>

                                                             
                                                             <tr>
                                                                <td>What is Your Business Name?: ".$pitchDetails['bussiness_name']."</td>
                                                            </tr>
                                                            
                                                            
                                                             <tr>
                                                                <td>Did you donate any money to a charity or social cause?: ".$donate_money."</td>
                                                            </tr>
                                                             <tr>
                                                                <td>Where did you learn how to be a Kidpreneur?: ".$pitchDetails['how_to_kidreprenuer']."</td>
                                                            </tr>
                                                            
                                                             <tr>
                                                                <td>Do you intend to continue running this Kidpreneur Business: ".$intend_for_bussiness."</td>
                                                            </tr>
                                                            <tr>
                                                                <td>How likely are you to start another business?: ".$pitchDetails['start_another_business']."</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Would you like to join our mailing list and hear more about our programs and tools to help you support your kidpreneurs?: ".$subscribe."</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Would you like us to share information on entrepreneurship education with your school?: ".$entrepreneurship_education."</td>
                                                            </tr>
                                                           
                                                            ".$teacher_html."
                                                             <tr>
                                                                <td>Principal's Full Name (if different from Submitter): ".$pitchDetails['teacher_full_name']."</td>
                                                            </tr>
                                                            <tr>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                ".$this->commonFooter()."
                                                
                                                
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        
                    </table>
                </td>
            </tr>
        </table>
    </body>";
        
        //pr($pitchDetails);
        $sendToAdmin=HQ_EMAIL;
        $this->PHPEmail->send($sendToAdmin, $subject, $MailMsg);
    
        
    }
    
    public function sendHQInquiryMail($inquiryData){
                    $sendTo = HQ_EMAIL;
                    $subject = "Hello | TheEntropolis.com";
                    $from = "support@theentropolis.com";
        if(isset($inquiryData['school_name'])){
            $school_name='<tr><td>School Name:</td><td>' . $inquiryData['school_name'] . '</td></tr>';
        }
        if(isset($inquiryData['subject'])){
            $inquirysubject='<tr><td>Subject:</td><td>' . $inquiryData['subject'] . '</td></tr>';
        }
        if(isset($inquiryData['message'])){
            $message='<tr><td>Message:</td><td>' . $inquiryData['message'] . '</td></tr>';
        }
        $msg = '<!DOCTYPE html>
                            <html>
                                <head>
                                    <title></title>
                                </head>
                                <body>
                                    <table width="800" cellpadding="50" cellspacing="0" style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px; background:#eee;">
                                        <tr>
                                            <td  width="100%">
                                                <table cellpadding="0" cellspacing="0" width="100%">
                                                    <tr>
                                                        <td style="background-color:#404040;"><img src="'. Router::url('/', true) . 'app/webroot/img/ENTR-About.jpg"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <table width="100%" style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px; background:#fff" cellpadding="0" cellspacing="20">
                                                                <tr>
                                                                    <td>
                                                                        <table style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px;" cellpadding="7" cellspacing="0">
                                                                            <tr>
                                                                                <td colspan="2" style="font-weight:bold">Hello <span>Entropolis | HQ,</span> </td>
                                                                            </tr>
                                                                            <tr>
                                                                            <td colspan="2" >
                                                                            You have received a new message via the Get in Touch form on the Website:
                                                                            </td>
                                                                            </tr>
                                                                            <tr><td>Name:</td><td>' .$inquiryData['name'] . ' ' . $inquiryData['last_name'] . '</td></tr>
                                                                            <tr><td>Email:</td><td>' . $inquiryData['email_address'] . '</td></tr>
                                                                            '.$school_name.'
                                                                            '.$inquirysubject.'
                                                                            '.$message.'
                                                                            
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>';
        $this->PHPEmail->send($sendTo, $subject, $msg);
    }
    public function sendInquiryMail($inquiryData){
                    $sendTo = $inquiryData['email_address'];
                    $subject = "New Message - Hello | TheEntropolis.com ";
                    $from = "support@theentropolis.com";
                    
                    if(isset($inquiryData['message'])){
                        $message='Below is a copy of your message for your records<br><br>'.$inquiryData['message'].'<br><br>';
                    }
        
        $msg = '<!DOCTYPE html>
                            <html>
                                <head>
                                    <title></title>
                                    <style type="text/css">


                                    </style>
                                </head>
                                <body>
                                    <table width="800" cellpadding="50" cellspacing="0" style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px; background:#eee;">
                                        <tr>
                                            <td  width="100%">
                                                <table cellpadding="0" cellspacing="0" width="100%">
                                                    <tr>
                            <td style="background-color:#404040;"><img src="'. Router::url('/', true) . 'app/webroot/img/ENTR-About.jpg"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <table width="100%" style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px; background:#fff" cellpadding="0" cellspacing="20">
                                                                <tr>
                                                                    <td>
                                                                        <table width="100%" style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px;" cellpadding="7" cellspacing="0">
                                                                            <tr>
                                                                                 <td style="font-weight:bold">Dear <span>' . $inquiryData['name'] . ',</span> </td>
                                                                            </tr>
                                                                            <tr>
                                                                                    <td>Thank you for contacting the team at Entropolis | HQ. We will get back to you within the next 48 hours. If you need urgent attention or assistance please contact us on (Australia) 1300 856 171.
<br> <br>
                                                                                    '.$message.'
                                                                                    See you soon in Entropolis!<br><br>
                                                                                    <strong>The Team at Entropolis | HQ<br>www.TheEntropolis.com | #PlacetobeforEntrepreneurs</strong>
                                                                                    </td>
                                                                            </tr>
                                                                            <tr>
                                                                            <td style="font-family: Arial, Helvetica, sans-serif; color:#000; font-size:11px; background-color:#E2E2E2;">
                                                                            IMPORTANT INFORMATION *
This document should be read only by those persons to whom it is addressed and its content is not intended for use by any other persons. If you have received this message in error, please notify us immediately at hello@theentropolis.com. Please also destroy and delete the message from your computer. Any unauthorised form of reproduction of this message is strictly prohibited.
Entropolis Pty Ltd is not liable for the proper and complete transmission of the information contained in this communication, nor for any delay in its receipt.
                                                                            </td>
                                                                            </tr>
                                                                        </table>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </body>
                            </html>';
                    $this->PHPEmail->send($sendTo, $subject, $msg);
    }
    public function sendSuccessMailKGCT($pitchDetails){
        $siteUrl = Router::url('/', true);
        $studenInfo = "";
            $stdKey = 0;
            $pitchDetailsAdmin=$pitchDetails;
            foreach ($pitchDetails['KgpcStudent'] as $kgpcStudent) {

                $student_gender = ($kgpcStudent['student_gender'] == '1') ? 'Male' : 'Female';
                $is_australian = ($kgpcStudent['is_australian'] == '1') ? 'Yes' : 'No';
                $parental_const = ($kgpcStudent['parental_const'] == '1') ? 'Yes' : 'No';

                $studenInfo .="<tr>
                                                    <td>Student (" . ($stdKey + 1) . ") Details</td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <table  style='font-family: Arial; color:#000; font-size:12px;' cellpadding='5' cellspacing='0'>
                                                            <tr>
                                                                <td>Full Name: " . $kgpcStudent['student_fullname'] . "</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Grade: " . $kgpcStudent['student_grade'] . "</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Age: " . $kgpcStudent['student_age'] . "</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Gender: " . $student_gender . "</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Are You an Australian Resident?: " . $is_australian . "</td>
                                                            </tr>
                                                            <tr>
                                                                <td>I have parental consent for this kidpreneur: " . $parental_const . "</td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>";
                $stdKey++;
            }
            //$sendToAdmin = 'tarun.kumar@prospus.com';

            $pitchDetails = $pitchDetails['PitchGoldenEntryForm'];

            $intend_for_bussiness = ($pitchDetails['intend_for_bussiness'] == '1') ? 'Yes' : 'No';
            $entrepreneurship_education = ($pitchDetails['entrepreneurship_education'] == '1') ? 'Yes' : 'No';
            $donate_money = ($pitchDetails['donate_money'] == '1') ? 'Yes' : 'No';
            $subscribe = ($pitchDetails['subscribe'] == '1') ? 'Yes' : 'No';
            $teacher_html = "";
            $donation_html = "";
            //if($pitchDetails['entrepreneurship_education'] == '1'){
            if (true) {
                $teacher_html = "<tr>
                                                                <td>What is your School Name? (If different to the above): " . $pitchDetails['teacher_school'] . "</td>
                                                            </tr>";
            }
            //if($pitchDetails['donate_money'] == '1'){
            if (true) {
                $donation_html = " <tr>
                                                                <td>How much money did you donate to them?: " . $pitchDetails['donation'] . "</td>
                                                            </tr>";
            }
            $couponCode=$this->getCouponCode($pitchDetails);
            $sendToAdmin = $pitchDetails['email_address'];
            $subject = "Kidpreneur Challenge Ninjas Pitch Competition - Entry Received";
            $msg = "<body>
        <table cellpadding='50' cellspacing='0' style='font-family: Arial; color:#000; font-size:12px; background:#eee;'>
            <tr>
                <td  >
                    <table cellpadding='0' cellspacing='0' >
                        <tr>
                            <td style='background-color:#BEC7CC;'><img src='" . Router::url('/', true) . "app/webroot/img/ninja-golden-confirmation.jpg' style='max-width: 100%; height: auto; width: auto;'></td>
                        </tr>
                    <tr>
                        <td style='background-color:white;'>
                            <table  style='font-family: Arial; color:#000; font-size:12px; background:#fff' cellpadding='0' cellspacing='20'>
                                <tr>
                                    <td>
                                        <table  style='font-family: Arial; color:#000; font-size:12px;' cellpadding='5' cellspacing='0'>
                                            <tr>
                                                <td style='font-weight:bold'>Dear Entrant, </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Thank you for entering the Kidpreneur Challenge Ninjas Pitch Competition. Your entry has been successfully delivered to Kidpreneur HQ. Details we have collected from the competition entry form are as follows:
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;</td>
                                            </tr>
                                            
                                           <tr>
                                                                <td>Year: " . date('Y') . "</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Submitter's First Name: " . $pitchDetails['first_name'] . "</td>
                                                            </tr>
                                                             <tr>
                                                                <td>Submitter's Last Name: " . $pitchDetails['last_name'] . "</td>
                                                            </tr>
                                                             <tr>
                                                                <td>Submitter's Email Address: " . $pitchDetails['email_address'] . "</td>
                                                            </tr>
                                                             <tr>
                                                                <td>Submitter's Contact Number: " . $pitchDetails['phone'] . "</td>
                                                            </tr>
                                                            <tr>
                                                                <td>State: " . $pitchDetails['state'] . "</td>
                                                            </tr>

                                                             <tr>
                                                                <td>Select ID: " . $pitchDetails['role_id'] . "</td>
                                                            </tr>
                                                             
                                                           


                                                             <tr>
                                                                <td>How many Kidpreneurs own this business?: " . $pitchDetails['kidpreneur_no'] . "</td> 
                                                            </tr>
                                                            " . $studenInfo . " <tr>
                                                                <td>What type of Pitch are you submitting: " . $pitchDetails['pitch'] . "</td>
                                                            </tr>
                                                             
                                                             <tr>
                                                                <td>What is Your Business Name?: " . $pitchDetails['bussiness_name'] . "</td>
                                                            </tr>
                                                          
                                                             <tr>
                                                                <td>Did you donate any money to a charity or social cause?: " . $donate_money . "</td>
                                                            </tr>
                                                             <tr>
                                                                <td>Where did you learn how to be a Kidpreneur?: " . $pitchDetails['how_to_kidreprenuer'] . "</td>
                                                            </tr>
                                                           
                                                             <tr>
                                                                <td>Do you intend to continue running this Kidpreneur Business: " . $intend_for_bussiness . "</td>
                                                            </tr>
                                                            <tr>
                                                                <td>How likely are you to start another business?: " . $pitchDetails['start_another_business'] . "</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Would you like to join our mailing list and hear more about our programs and tools to help you support your kidpreneurs?: " . $subscribe . "</td>
                                                            </tr>
                                                             <tr>
                                                                <td>Would you like us to share information on entrepreneurship education with your school?: " . $entrepreneurship_education . "</td>
                                                            </tr>
                                                           
                                                            " . $teacher_html . "
                                                             <tr>
                                                                <td>Principal's Full Name (if different from Submitter): " . $pitchDetails['teacher_full_name'] . "</td>
                                                            </tr>
                                                            <tr>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td >
                                                    Congratulations Kidpreneurs on kickstarting your entrepreneurial adventure, we look forward to viewing your pitch video and are excited to learn more about your business.
                                                </td>
                                            </tr>
                                            <tr>
                                                <td >
                                                    Now you can also sign up to a Ninja Program Subscription via the Kidpreneur City Subscriptions form using the special Ninja Coupon code <b>".$couponCode."</b>.
                                                </td>
                                            </tr>
                                            <tr>
                                                <td >
                                                    Educators and Parents, if you have any questions or concerns regarding this submission or wish to update / freeze it for any reason, please email <a href='mailto:ninjas@theentropolis.com'> ninjas@theentropolis.com </a>  and one of our team members from Kidpreneur HQ will be in touch shortly.
                                                </td>
                                            </tr>
                                            <tr>
                                                <td >
                                                    If no objection is received within 24 hours, we will assume that this submission has been approved for the competition and has permission to be uploaded onto Kidpreneur TV | Kidpreneur Challenge 2018 YouTube playlist.
                                                    
                                                </td>
                                            </tr>
                                            <tr>
                                                <td >
                                                    Best of luck!!
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                    <td>
                                                    <strong>Entropolis HQ</strong><br>
                                                    <strong>Inspiring, Educating, Empowering and Connecting Future Entrepreneurs.</strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        Entropolis Pty Ltd
                                                        <br>
                                                        ABN 74 168 344 018
                                                        <br><br>
                                                        Level 4, 16 Spring Street
                                                        <br>
                                                        Sydney NSW 2000
                                                        <br>
                                                        Australia
                                                        <br><br>
                                                        <strong>E</strong> <a href='mailto:hq@theentropolis.com'>hq@theentropolis.com</a>
                                                        <br>
                                                        <strong>P</strong> 1300 464 388
                                                        <br>
                                                        <a href='http://www.theentropolis.com/kidchall-unicorns' target='_blank'>www.theentropolis.com/kidchall-unicorns</a>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                
                                               
                                                <tr>
                                                    <td style='line-height: 18px; color: #909090'>
                                                        NOTICE - This communication contains information which is confidential and the copyright of Entropolis Pty Ltd or a third party. This email is intended to be read or used by the addressee only. If you are not the intended recipient, any use, distribution, disclosure or copying of this email is strictly prohibited without the authority of Entropolis Pty Ltd Please delete and destroy all copies and email us at hq@theentropolis.com immediately.
                                                        
                                                    </td>
                                                </tr>
                                            
                                            
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td valign='top' style='font-family: Arial; color:#000; font-size:11px; background-color:#E2E2E2;'>
                            <table  border='0' cellspacing='0' cellpadding='20'>
                                <tr>
                                    <td style='font-family: Arial; color:#000; font-size:11px; background-color:#E2E2E2;'>
                                        <table  border='0' cellspacing='0' cellpadding='0'>
                                            <tr>
                                                <td width='10'>&nbsp;</td>
                                                <td  style='font-family: Arial; color:#000; font-size:11px; background-color:#E2E2E2;'>       LEVEL 4,16 SPRING STREET, SYDNEY, NSW 2000 | E: <a style='color:blue;text-decoration: none' href='mailto:citizens@theentropolis.com'>citizens@theentropolis.com</a> | <a href='http://entropolis.com/?reqp=1&reqr=' style='color:blue; text-decoration: none' target='_blank'> www.entropolis.com</a></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>";
            $this->PHPEmail->send($sendToAdmin, $subject, $msg);
             /* Send Mail To Kidpreneur USER */
            $this->goldenPitchAdminMail($pitchDetailsAdmin);
        
    }
    private function couponCode(){
        $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $coupon = "";
        for ($i = 0; $i < 6; $i++) {
            $coupon .= $chars[mt_rand(0, strlen($chars)-1)];
        }
        return $coupon;
    }
    private function getCouponCode($userDetails){ 
        $Coupon = ClassRegistry::init('Coupon');
        $couponOwner['user_email']=$userDetails['email_address'];
        $couponOwner['coupon_code']=$this->couponCode();
        
        $Coupon->create();
        $Coupon->save($couponOwner);
        return $couponOwner['coupon_code'];
    }
    
    private function sendUnsuccessMailKCGT($user_email){
         $siteUrl = Router::url('/', true);
       
        $sendToRegisteredUser = $user_email;
        $subject = "NINJA PITCH COMPETITION – Entry Error";
                   
        $msg = "<body>
        <table width='800' cellpadding='50' cellspacing='0' style='font-family: Arial; color:#000; font-size:12px; background:#eee;'>
            <tr>
                <td  width='100%'>
                    <table cellpadding='0' cellspacing='0' width='100%'>
                        <tr>
                            <td><img src='" . Router::url('/', true) . "app/webroot/img/payment-unsuccessful.png'></td>
                        </tr>
                        <tr>
                            <td>
                                <table width='100%' style='font-family: Arial; color:#000; font-size:12px; background:#fff' cellpadding='0' cellspacing='20'>
                                    <tr>
                                        <td>
                                            <table width='100%' style='font-family: Arial; color:#000; font-size:12px;' cellpadding='7' cellspacing='0'>
                                                <tr>
                                                    <td style='font-weight:bold'>Dear <span>Hi There,</span> </td>
                                                </tr>
                                                <tr>
                                                    <td style='line-height: 18px;'>
                                                        Uh Oh! We seem to have a problem …
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style='line-height: 18px;'>
                                                        Thank you for registering for the Kidpreneur Challenge 2018. We are delighted you will join us on the mission to ignite the entrepreneurial spirit in Australian kids.
                                                    </td>
                                                </tr>
                                               
                                                <tr>
                                                    <td style='line-height: 18px;'>
                                                        What now?
                                                    </td>
                                                </tr>
                                                <tr> 
                                                    <td style='line-height: 18px;'>
                                                        Your Dashboard is set up but not active. Follow the steps below to complete your payment and activate your account:
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style='padding: 0;'>
                                                        
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style='line-height: 18px;'>
                                                        In the meantime, if you have any questions or you would like to discuss the program with a member of our team please phone 1300 464 388 or email <a href='mailto:kidpreneurs@theentropolis.com' style='color:blue' target='_blank'>kidpreneurs@theentropolis.com</a>.
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style='line-height: 18px;'>
                                                        See you soon!
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style='line-height: 18px;'>
                                                        Warm regards,
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style='font-weight:bold;line-height: 18px;font-size:13px;padding-bottom:0'>
                                                        The Club Kidpreneur Team | <a href='" . $siteUrl ."kidpreneur_challenge". "' style='color:blue' target='_blank'>" . $siteUrl ."kidpreneur_challenge". "</a>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style='line-height: 18px;font-size:13px;padding-top:0;padding-bottom:0'>
                                                        If you have any questions about this email please contact us at <a href='mailto:kidpreneurs@theentropolis.com' target='_blank' style='color:blue'>kidpreneurs@theentropolis.com</a>
                                                    </td>
                                                </tr>".$this->commonNoticeText()."
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>".$this->commonFooter()."</table>
                </td>
            </tr>
        </table></body>";  
        $this->PHPEmail->send($sendToRegisteredUser, $subject, $msg);
    }

    function sendRemovedStudentInfo($student_info_array)
    {
        $student_id = $student_info_array['student_id'] ;
        $student_first_name=  $student_info_array['student_first_name'];
        $student_last_name =  $student_info_array['student_last_name'];
        $student_avatar_name = $student_info_array['student_avatar_name'];
        
        $student_school_name = $student_info_array['organization'];
        $student_promotional= $student_info_array['kbn_number'];
        $birth_date = $student_info_array['birth_date'];
        $student_gender = $student_info_array['gender'];
        $year_group= $student_info_array['year_group'];
        $teacher_id= $student_info_array['teacher_id'];
        $teacher_first_name= $student_info_array['teacher_first_name'];
        $teacher_last_name = $student_info_array['teacher_last_name'];
        $student_teacher_email =  $student_info_array['student_teacher_email'];
        $addedUser = $student_info_array['addedUser'];


        $user_type = $student_info_array['user_type'];
        $phone = $student_info_array['phone'];
      


        if(strtoupper($addedUser) == strtoupper('Student'))
        {
            $subject        = "Kidpreneur Challenge - Student Account Closed";
            $subject_hq     = "Kidpreneur Challenge - Student Account Closed";
            $unique_words   = 'Challenge';
            $internal_mail  = 'challenge@theentropolis.com';
            $image_name     = 'KC_Student_De_Reg_Confirmation.png';
            $address_mail =  'www.theentropolis.com/challenge';
        }
        else 
        {
            $subject = "Ninja Program - Kidpreneur Account Closed";
            $subject_hq = "Ninja Program - Kidpreneur Account Closed";
            $unique_words= 'Ninjas';
            $internal_mail = 'ninjas@theentropolis.com';
            $image_name = 'KC_Kid_De_Reg_Confirmation.png';
             $address_mail =  'http://theentropolis.com/ninjas';
        }
       // $subject = "Kidpreneur Challenge " . date("Y") . " - Student De-Registration Confirmation";

            $msg = "<body>
                   <table width='800' cellpadding='50' cellspacing='0' style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px; background:#eee;'>
                       <tr>
                           <td  width='100%'>
                               <table cellpadding='0' cellspacing='0' width='100%' >
                                   <tr>
                                       <td><img src='" . Router::url('/', true) . "app/webroot/img/".$image_name."'></td>
                                   </tr>
                                   <tr>
                                       <td><table width='100%' style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px; background:#fff' cellpadding='0' cellspacing='20'>
                                   <tr>
                                       <td><table width='100%' style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px;' cellpadding='7' cellspacing='0'>
                                   <tr>
                                       <td > Dear " . ucwords($teacher_first_name . " " . $teacher_last_name) . ", </td>
                                   </tr>
                                   <tr>
                                       <td>
                                            You have successfully de-registered " . ucwords($student_first_name . " " . $student_last_name) . " from the Kidpreneur ".$unique_words." Program.
    <br><br>
We hope that everything is OK and your other ".strtolower($addedUser)."s are enjoying their entrepreneurial adventure. <br> <br>
If you have any questions or we can be of assistance, please contact us via email at <span style='color: blue; text-decoration: underline'>".$internal_mail."</span> or call us on 1300 464 388.

</td>
                                   </tr>
                                   <tr>
                                       <td >
Best of luck in the  Kidpreneur ".$unique_words." Program.
<br><br>

<strong style='font-size: 13px'>Kidpreneur Education Team</strong><br>
<strong style='font-size: 13px'>Inspiring, Educating, Empowering and Connecting Future Entrepreneurs</strong>
</td>
                                   </tr>
                                   <tr>
                                                    <td>
                                                        Entropolis Pty Ltd
                                                        <br>
                                                        ABN 74 168 344 018
                                                        <br><br>
                                                        Level 4, 16 Spring Street
                                                        <br>
                                                        Sydney NSW 2000
                                                        <br>
                                                        Australia
                                                        <br><br>
                                                        <strong>E</strong> <a href='mailto:hq@theentropolis.com'>hq@theentropolis.com</a>
                                                        <br>
                                                        <strong>P</strong> 1300 464 388
                                                        <br>
                                                        <a href='".$address_mail."' target='_blank'>".$address_mail."</a>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                </tr>



                                 
                                   <tr>
                                                    <td style='font-size:12px;color:#b5b5b5;line-height: 18px; font-family: Times New Roman;'>
                                                        <br>
                                                        NOTICE - This communication contains information which is confidential and the copyright of Entropolis Pty Ltd or a third party. This email is intended to be read or used by the addressee only. If you are not the intended recipient, any use, distribution, disclosure or copying of this email is strictly prohibited without the authority of Entropolis Pty Ltd Please delete and destroy all copies and email us at <a href='mailto:hq@theentropolis.com'>hq@theentropolis.com</a> immediately.
                                                    </td>
                                                </tr>
                                   </table></td>
                                                                           </tr>
                                                                   </table></td>
                                                   </tr>
                                                 
                                           </table>
                                   </td>
                           </tr>
                   </table>
                   </body>";

            $this->PHPEmail->send($student_teacher_email, $subject, $msg);

           
         
             
         $msg_detail = "";
       
            $msg_detail.= $addedUser." Name: " . $student_first_name . " " . $student_last_name . "<br>";
            $msg_detail.= $addedUser." Avatar Name: " . $student_avatar_name. "<br>";          
            $msg_detail.= "KBN: " . $student_promotional . "<br>"; 
            $msg_detail.= "School Name: " . $student_school_name . "<br>";            
            $msg_detail.= "Year Level: " . $year_group . "<br>";     
       
            $msg_detail.= $user_type." Name: " . $teacher_first_name . " " . $teacher_last_name . "<br>";
        
     
            $msg_detail.= $user_type." Email Address: " . $student_teacher_email . "<br>";
            $msg_detail.= "Contact Phone: " .$phone . "<br>";

            $msg = "<body>
               <table width='800' cellpadding='50' cellspacing='0' style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px; background:#eee;'>
                   <tr>
                       <td  width='100%'>
                           <table cellpadding='0' cellspacing='0' width='100%' >
                               <tr>
                                     <td><img src='" . Router::url('/', true) . "app/webroot/img/".$image_name."'></td>
                               </tr>
                               <tr>
                                   <td><table width='100%' style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px; background:#fff' cellpadding='0' cellspacing='20'>
                               <tr>
                                   <td><table width='100%' style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px;' cellpadding='7' cellspacing='0'>
                               <tr>
                                   <td>
                                   Sad news! You have just received a new ".strtolower($addedUser)." de-registration for the Kidpreneur ".$unique_words." Program!<br><br>
     
                                        <strong>DETAILS</strong><br><br>" . $msg_detail . "

                                    </td>
                               </tr>
                               <tr>
                                   <td >
Regards,
<br><br>
<strong>Entropolis | HQ</strong></td>
                               </tr>

                               </table></td>
                                                                       </tr>
                                                               </table></td>
                                               </tr>
                                            
                                       </table>
                               </td>
                       </tr>
               </table>
               </body>";

// echo $msg ;die;

                $this->PHPEmail->send(HQ_EMAIL, $subject_hq, $msg);

      
    }

    function sendAddedStudentInfo($student_info_array)
    {
        $student_id = $student_info_array['student_id'] ;
        $student_first_name=  $student_info_array['student_first_name'];
        $student_last_name =  $student_info_array['student_last_name'];
        $student_avatar_name = $student_info_array['student_avatar_name'];
        
        $student_school_name = $student_info_array['student_school_name'];
        $student_promotional= $student_info_array['student_promotional'];
        $birth_date = $student_info_array['birth_date'];
        $student_gender = $student_info_array['gender'];
        $year_group= $student_info_array['year_group'];
        $teacher_id= $student_info_array['teacher_id'];
        $teacher_first_name= $student_info_array['teacher_first_name'];
        $teacher_last_name = $student_info_array['teacher_last_name'];
        $student_teacher_email =  $student_info_array['student_teacher_email'];
        $addedUser = $student_info_array['addedUser'];
        $user_type = $student_info_array['user_type'];
        $phone = $student_info_array['phone'];
        $student_password =  $student_info_array['student_password'] ;


        if(strtoupper($addedUser) == strtoupper('Student'))
        {
            $subject = "Kidpreneur Challenge - Student Registration Confirmation";
            $subject_hq = "Kidpreneur Challenge - Student Registration Confirmation";
            $unique_words= 'Challenge';
            $internal_mail = 'challenge@theentropolis.com';
            $address_mail =  'www.theentropolis.com/challenge';
            $image_name = 'KC_Student_Registration_Confirmation.png';
        }
        else
        {

            $subject = "Ninja Program - Kidpreneur Registration Confirmation";
            $subject_hq = "Ninja Program - Kidpreneur Registration Confirmation";
            $unique_words= 'Ninjas';
            $internal_mail = 'ninjas@theentropolis.com';
            $image_name = 'KC_Kid_Registration_Confirmation.png';
            $address_mail =  'http://theentropolis.com/ninjas';

               
        }
        
        $msg = "<body>
               <table width='800' cellpadding='50' cellspacing='0' style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px; background:#eee;'>
                   <tr>
                       <td  width='100%'>
                           <table cellpadding='0' cellspacing='0' width='100%' >
                               <tr>
                                   <td><img src='" . Router::url('/', true) . "app/webroot/img/".$image_name."'></td>
                               </tr>
                               <tr>
                                   <td><table width='100%' style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px; background:#fff' cellpadding='0' cellspacing='20'>
                               <tr>
                                   <td><table width='100%' style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px;' cellpadding='7' cellspacing='0'>
                               <tr>
                                   <td > <strong>Dear " . ucwords($teacher_first_name . " " . $teacher_last_name) . ", </strong></td>
                               </tr>
                               <tr>
                               <td>You  have successfully registered " . ucwords($student_first_name . " " . $student_last_name) . " for the Kidpreneur ".$unique_words." program. A reminder to please ensure you have your ".$addedUser."'s parent / guardian�s permission to register them for this program.
</td>
                               <tr>
                                   <td><strong> ".$addedUser."'s secure dashboard login: <strong><br><br>
                                   Username: ".$student_avatar_name."<br>
                                   Password: ".$student_password ."<br>



                                   </td>
                               </tr>
                                <tr>
                                                    <td><strong>Child Privacy and Security at Entropolis:</strong></td>
                                                    
                                                </tr>

                                <tr>
                                                     <td>
                                                         <table>
                                                             <tr>
                                                                 <td>&#9679;</td>
                                                                 <td>The Kidpreneur dashboards are secure and monitored 24 / 7 to ensure that all activity inside Entropolis complies with our online <a href='www.theentropolis.com/pdf/ENTROPOLIS Privacy Policy 2018 051217.pdf' target='_blank'>Privacy and Security policy</a>.</td>
                                                             </tr>
                                                             <tr>
                                                                 <td>&#9679;</td>
                                                                 <td>All Kidpreneur accounts / dashboards are registered by a verified responsible adult (Educator / Parent) and they will receive all communications regarding Entropolis including on behalf of Kidpreneurs and related to Kidpreneur City.</td>
                                                             </tr>
                                                             <tr>
                                                                 <td>&#9679;</td>
                                                                 <td>Kidpreneurs use an avatar name and picture to identify themselves and are only allowed to post information about their Kidpreneur business online. There is no option for Kidpreneurs to provide, view or edit personal information.</td>
                                                             </tr>
                                                             <tr>
                                                                 <td>&#9679;</td>
                                                                 <td>Kidpreneurs are only given permission to discuss matters related to their entrepreneurial journey with other registered Kidpreneurs and the individual Educator / Parent who registered them.</td>
                                                             </tr>
                                                             <tr>
                                                                 <td>&#9679;</td>
                                                                 <td>They have no access to the Educator / Parent content libraries or information sharing and communication channels. You will be able to monitor your Kidpreneurs online activity via the Activity Feed on your dashboard however, you will not be able to interact with and Kidpreneurs directly other than the ones you have personally registered.</td>
                                                             </tr>
                                                             
                                                            
                                                         </table>
                                                     </td>
                                                    
                                                </tr>
                                                <tr>
                                                      <td>&nbsp;</td>
                                                </tr>



                               <tr>
                                   <td >For further information on the Club Kidpreneur and Kidpreneur Challenge Terms of Use and Privacy policy please go to <a href='www.theentropolis.com/pdf/ENTROPOLIS Terms of Use 2018 051217.pdf' target='_blank'>www.theentropolis.com/terms-of-use</a> or <a href='www.theentropolis.com/pdf/ENTROPOLIS Privacy Policy 2018 051217.pdf' target='_blank'>www.theentropolis.com/privacy-policy</a>. Or you can contact us at  <a href='mailto:".$internal_mail."''>".$internal_mail."</a> .
<br><br>
Best of luck in the Kidpreneur ".$unique_words." Program.
<br><br>
<strong style='font-size: 13px'>Kidpreneur Education Team</strong><br>
<strong style='font-size: 13px'>Inspiring, Educating, Empowering and Connecting Future Entrepreneurs</strong>
</td>
                                   </tr>
                                   <tr>
                                                    <td>
                                                        Entropolis Pty Ltd
                                                        <br>
                                                        ABN 74 168 344 018
                                                        <br><br>
                                                        Level 4, 16 Spring Street
                                                        <br>
                                                        Sydney NSW 2000
                                                        <br>
                                                        Australia
                                                        <br><br>
                                                        <strong>E</strong> <a href='mailto:hq@theentropolis.com'>hq@theentropolis.com</a>
                                                        <br>
                                                        <strong>P</strong> 1300 464 388
                                                        <br>
                                                        <a href='".$address_mail."' target='_blank'>". $address_mail."</a>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                </tr>



                                   <tr>
                                                    <td style='font-size:12px;color:#b5b5b5;line-height: 18px; font-family: Times New Roman;'>
                                                        <br>
                                                        NOTICE - This communication contains information which is confidential and the copyright of Entropolis Pty Ltd or a third party. This email is intended to be read or used by the addressee only. If you are not the intended recipient, any use, distribution, disclosure or copying of this email is strictly prohibited without the authority of Entropolis Pty Ltd Please delete and destroy all copies and email us at <a href='mailto:hq@theentropolis.com'>hq@theentropolis.com</a> immediately.
                                                    </td>
                                                </tr>
                                   </table></td>
                                                                           </tr>
                                                                   </table></td>
                                                   </tr>
                                                 
                                           </table>
                                   </td>
                           </tr>
                   </table>
                   </body>";


        // send mail to teacher when he add an student
        $this->PHPEmail->send($student_teacher_email, $subject, $msg);

       
            $msg_detail = "";
       
            $msg_detail.= $addedUser." Name: " . $student_first_name . " " . $student_last_name . "<br>";
            $msg_detail.= $addedUser." Avatar Name: " . $student_avatar_name. "<br>";          
            $msg_detail.= "KBN: " . $student_promotional . "<br>"; 
            $msg_detail.= "School Name: " . $student_school_name . "<br>";            
            $msg_detail.= "Year Level: " . $year_group . "<br>";     
       
            $msg_detail.= $user_type." Name: " . $teacher_first_name . " " . $teacher_last_name . "<br>";
        
     
            $msg_detail.= $user_type." Email Address: " . $student_teacher_email . "<br>";
            $msg_detail.= "Contact Phone: " .$phone . "<br>";
        
             $msg = "<body>
               <table width='800' cellpadding='50' cellspacing='0' style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px; background:#eee;'>
                   <tr>
                       <td  width='100%'>
                           <table cellpadding='0' cellspacing='0' width='100%' >
                               <tr>
                                  <td><img src='" . Router::url('/', true) . "app/webroot/img/".$image_name."'></td>
                               </tr>
                               <tr>
                                   <td><table width='100%' style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px; background:#fff' cellpadding='0' cellspacing='20'>
                               <tr>
                                   <td><table width='100%' style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px;' cellpadding='7' cellspacing='0'>
                               <tr>
                                   <td>
                                   Congratulations! You have just received a new ".strtolower($addedUser)." registration for the Kidpreneur ".$unique_words." Program!
<br><br>
     
                                        <strong>DETAILS</strong><br><br>" . $msg_detail . "

                                    </td>
                               </tr>
                               <tr>
                                   <td >
Regards,
<br><br>
<strong>Entropolis | HQ</strong></td>
                               </tr>

                               </table></td>
                                                                       </tr>
                                                               </table></td>
                                               </tr>
                                            
                                       </table>
                               </td>
                       </tr>
               </table>
               </body>";



                $this->PHPEmail->send(HQ_EMAIL, $subject_hq, $msg);
    }


    public function updatePasswordMail($student_info_array)
    {
        
        //$student_id = $student_info_array['student_id'] ;
        $student_first_name=  $student_info_array['student_first_name'];
        $student_last_name =  $student_info_array['student_last_name'];
        //$student_avatar_name = $student_info_array['student_avatar_name'];
        
        //$student_school_name = $student_info_array['student_school_name'];
        //$student_promotional= $student_info_array['student_promotional'];
        //$birth_date = $student_info_array['birth_date'];
        //$student_gender = $student_info_array['gender'];
        //$year_group= $student_info_array['year_group'];
        //$teacher_id= $student_info_array['teacher_id'];
        $teacher_first_name= $student_info_array['teacher_first_name'];
        $teacher_last_name = $student_info_array['teacher_last_name'];
        $student_teacher_email =  $student_info_array['student_teacher_email'];
        $addedUser = $student_info_array['addedUser'];
        //$user_type = $student_info_array['user_type'];
        //$phone = $student_info_array['phone'];
        $student_password =  $student_info_array['student_password'] ;
        $updationTime = date('Y-m-d H:i:s');

        $sendTo =       $student_teacher_email;
        $subject = "Password Update | Theentropolis.com";

         if(strtoupper($addedUser) == strtoupper('Student'))
        {
            
            $internal_mail = 'challenge@theentropolis.com';
            $address_mail =  'www.theentropolis.com/challenge';
            $image_name = 'KC_Student_Registration_Confirmation.png';
        }
        else
        {

            
            $internal_mail = 'ninjas@theentropolis.com';
            $image_name = 'KC_Kid_Registration_Confirmation.png';
            $address_mail =  'http://theentropolis.com/ninjas';

               
        }
        

        $siteUrl = Router::url('/', true);
        $msg = "<body>
                <table width='800' cellpadding='50' cellspacing='0' style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px; background:#eee;'>
                <tr>
                     <td width='100%'>
                       <table cellpadding='0' cellspacing='0' width='100%'>
                        <tr>
                            <td><img src='" . $siteUrl . "app/webroot/img/update_password_kid.jpg'></td>
                        </tr>
                            <tr>
                                <td><table style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px; background:#fff' cellpadding='0' cellspacing='20'>
                            <tr>
                                <td><table style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px;' cellpadding='7' cellspacing='0'>
                            <tr>
                                <td >Hi " . ucwords($teacher_first_name . ' ' . $teacher_last_name) . ",</td>
                            </tr>
                            <tr>
                                <td>The password for ".ucwords($student_first_name. ' ' . $student_last_name) ." has been updated on ".$updationTime.". Below is the updated password for your ".$addedUser.".<br/>
                               </td>
                            </tr>  

                             <tr>
                                <td >Password: ".$student_password." </td>
                            </tr>                                         
                            <tr>
                                <td >See you soon in Entropolis! </td>
                            </tr>
                            <tr>
                <td style=''>
                    <b>Entropolis HQ</b><br>
                    <b>Inspiring, Educating, Empowering and Connecting Future Entrepreneurs.</b><br>
                    Entropolis Pty Ltd<br>
                    ABN 74 168 344 018<br>
                    Level 4, 16 Spring Street<br>
                    Sydney NSW 2000<br>
                    Australia<br><br>
                   <strong>E</strong> <a href='mailto:hq@theentropolis.com'>hq@theentropolis.com</a><br>
                    <b>P</b> 1300 464 388 <br>
                    <a href='".$address_mail."' target='_blank'>".$address_mail."</a>
                </td>
            </tr>
             
                               
                                <tr>
                                    <td style='line-height: 18px; color: #909090'>
                                        NOTICE - This communication contains information which is confidential and the copyright of Entropolis Pty Ltd or a third party. This email is intended to be read or used by the addressee only. If you are not the intended recipient, any use, distribution, disclosure or copying of this email is strictly prohibited without the authority of Entropolis Pty Ltd Please delete and destroy all copies and email us at <a href='mailto:hq@theentropolis.com'>hq@theentropolis.com</a> immediately.
                                        
                                    </td>
                                </tr>
        </table></td>
        </tr>
        </table></td>
        </tr>
        </table></td>
        </tr></table>
            </td>
        </tr>
        </table>
        </body>";
        $this->PHPEmail->send($sendTo, $subject, $msg);
   }
   
   /**
    * 
    * @param type $userDetails
    * @param type $broadCastMsg
    * 
    */
   function sendBroadcastMessage($userDetails,$broadCastMsg){
      
        $subject = "You have received a new Broadcast Message from Entropolis";
        $siteUrl = Router::url('/', true);
        $userDetails['users']['email'];
                        $userDetails['users']['username'];
                         $msg = "<body>
        <table   width='800' cellpadding='50' cellspacing='0' style='font-family: Arial; color:#000; font-size:12px; background:#eee;'>
            <tr>
                <td  >
                    <table cellpadding='0' cellspacing='0' >
                        <tr>
                            <td style='background-color:#d9d9d9;'><img src='" . $siteUrl . "app/webroot/img/ENTR-About.jpg'></td>
                        </tr>
                        <tr>
                            <td>
                                <table  style='font-family: Arial; color:#000; font-size:12px; background:#fff;width:100%' cellpadding='0' cellspacing='20'>
                                    <tr>
                                        <td >
                                            <table  style='font-family: Arial; color:#000; font-size:12px;' cellpadding='5' cellspacing='0'>
                                                <tr>
                                                    <td style='font-weight:bold'>Hi ".$userDetails['users']['username'].", </td>
                                                </tr>
                                                <tr>
                                                    <td style='line-height: 18px;'>
                                                      A new Broadcast Message has gone out across Entropolis!
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style='line-height: 18px;'>
                                                     ".$broadCastMsg."
                                                    </td>
                                                </tr>
                                                 
                                                <tr>
                                                    <td>
                                                       You can login to read it here:


                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                      <a href='".$_SERVER['HTTP_HOST']."' style='color:blue; text-decoration: none' target='_blank'> ".$_SERVER['HTTP_HOST']." </a>


                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                
                                               
                                                <tr>
                                                    <td>
                                                   The Entropolis HQ Team
                                                        
                                                    </td>
                                                </tr>
                                              
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td valign='top' style='font-family: Arial; color:#000; font-size:11px; background-color:#E2E2E2;'>
                                <table  border='0' cellspacing='0' cellpadding='20'>
                                    <tr>
                                        <td style='font-family: Arial; color:#000; font-size:11px; background-color:#E2E2E2;'>
                                            <table  border='0' cellspacing='0' cellpadding='0'>
                                                <tr>
                                                    <td width='10'>&nbsp;</td>
                                                    <td  style='font-family: Arial; color:#000; font-size:11px; background-color:#E2E2E2;'>Level 2, 11 York Street, Sydney NSW 2000 /  1300 464 388 / <a style='color:blue;text-decoration: none' href='mailto:hq@theentropolis.com'>hq@theentropolis.com</a> | <a href='http://www.theentropolis.com' style='color:blue; text-decoration: none' target='_blank'>www.theentropolis.com </a></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>";
                        
//                         echo $msg;
//                          pr(array($userDetails['users']['email'], $subject, $msg));
//                         die;
                        
                    $this->PHPEmail->send($userDetails['users']['email'], $subject, $msg);
   }


   function sendNetworkUserInvitation($userDetails){
      
        $subject = "Private Network Request | Entropolis.com";
        $siteUrl = Router::url('/', true);
      
                        $msg = "<body>
                            <table width='800' cellpadding='50' cellspacing='0' style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px; background:#eee;'>
                                <tr>
                                    <td>
                                        <table cellpadding='0' cellspacing='0'>
                                            <tr>
                                                <td><img src='" . $siteUrl . "app/webroot/img/new_img.png'></td>
                                            </tr>
                                            <tr>
                                                <td><table style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px; background:#fff' cellpadding='0' cellspacing='20'>
                                            <tr>
                                                <td><table style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:12px;' cellpadding='7' cellspacing='0'>
                                            <tr>
                                                <td >Hi " . $userDetails['userName'] . ",</td>
                                            </tr>
                                            <tr>
                                                <td>Great news, you have received a private ".$userDetails['invitation']." network request from:</td>
                                            </tr>";
                        if ($userDetails['group_name']) {
                                               $msg .= "<tr>
                                                <td ><b> Group Name | </b> " .$userDetails['group_name'] . "</td>
                                            </tr>";
                                        }
                                            $msg .= "<tr>
                                                <td ><b>Citizen | </b>" . $userDetails['sender_name'] . "</td>
                                            </tr>";
                            if ($userDetails['personal_message']) {
                                $msg .= "<tr>
                                                <td ><b> Messsage | </b> " . nl2br($userDetails['personal_message']) . "</td>
                                            </tr>";
                            }

                            $msg .= "
                                            <tr>
                                                <td >To accept this network request: </td>      </tr>
                                             <tr> 
                                               <td >
                                                <ol>
                                                <li>Go to <a href ='http://theentropolis.com/' style='color:blue;' target='_blank'>www.theentropolis.com</a>  </li>
                                                <li>Log on to your dashboard using your registered email and password </li>
                                                <li>Click on the New Request link in the Activity Feed on your dashboard</li>
                                                <li>Click Accept. If you do not want to connect with this person or add them to your private business network please disregard their request or click Decline.</li>
                                                <li>If we can do anything to help, please contact us at <a href ='mailto:hq@theentropolis.com' style='color:blue;'>hq@theentropolis.com</a> </li>


                                                </ol></td>
                                                </tr>                                       
                                            
                                            <tr>
                                                <td style=''><b>The Team at Entropolis | HQ</b><br>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><table  cellpadding='0' cellspacing='0' style='color:#b2b2b2; font-size:11px; font-family: Arial, Helvetica, sans-serif; line-height:13px'>
                                            <tr>
                                                    <td> IMPORTANT INFORMATION *</td>
                                            </tr>
                                            <tr>
                                                    <td >You have received this private network invitation from another member of <a href ='http://theentropolis.com/' style='color:blue;' target='_blank'>www.theentropolis.com</a> via our platform. This document is confidential and should be viewed only by the person(s) to whom it is addressed. It’s content is not intended for use by any other person(s). If you have received this message in error, please notify us immediately at <a href ='mailto:hq@theentropolis.com' style='color:blue;'>hq@theentropolis.com</a>. Please also immediately delete the message from your computer. Any unauthorised use or reproduction of this message is strictly prohibited. Entropolis Pty Ltd is not liable for the proper and complete transmission of the information contained in this communication, nor any delay in its receipt.</td><br/>
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
                                            <td nowrap='nowrap'  style='font-family: Arial, Helvetica, sans-serif; color:#000; font-size:11px; background-color:#E2E2E2;'> LEVEL 2 <a href = 'https://www.google.com/maps/place/LEVEL+2%2F11+York+St,+Sydney+NSW+2000,+Australia/@-33.8652521,151.2029634,17z/data=!3m1!4b1!4m5!3m4!1s0x6b12ae40d8e1bc1d:0xc28a59d961d2c0e6!8m2!3d-33.8652521!4d151.2051521' style='color:blue; text-decoration: none' target='_blank'>,11 York Street, Sydney, NSW 2000 </a> |  E: <a style='color:blue;text-decoration: none' href='mailto:hq@theentropolis.com'>hq@theentropolis.com</a> | <a href='http://theentropolis.com' style='color:blue; text-decoration: none' target='_blank'> www.theentropolis.com </a></td>
                                    
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
                            </body>";
                        
                  //  $userDetails['sendTo'] = 'prospus.artisharma@gmail.com';
           
                   $result =  $this->PHPEmail->send($userDetails['sendTo'], $subject, $msg);


                // echo   $msg; 
                 
                  // echo "<pre>";print_r($result );
                  // die;
   }
}