<?php
App::uses('AppController', 'Controller');
App::uses('UsersController', 'Controller');
App::uses('CakeEmail','Network/Email');

class ChallengesController extends AppController{

    public $helpers = array('Html','Form','Judge','Js'=>array('Jquery'));
    public $uses = array('User','Challenge','ContextRole','ContextRoleUser','ChallengeJudge','ChallengeJudgeInvitation','DecisionType','ChallengeJudgeGrandWinner','Hindsight','HindsightDetail','Category','Judge','Advice','Comment'); //define which model you are going to use
    public $components = array('Session', 'RequestHandler','Email');
   
    function beforeFilter() {
        parent::beforeFilter();
        if ($this->Session->read('user_id') == "") {
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }
        $this->layout = 'admin_default';
        $userId = $this->Session->read('user_id');
        $userObj = new UsersController();
        $avatar = $userObj->getUserAvatar($userId);
        $this->set('avatar', $avatar);
    }
    
    /**
     * Funtion to save and edit challenges
     */
    public function saveChallenge($data,$challenge_id=null)
    {
        $current_time = date("H:i:s");
        if($data)
        {

            if($data['select-date']==1)
            {

                $data['Challenge']['challenge_end_date'] =  date("Y-m-d",strtotime(date("Y-m-d", strtotime($data['Challenge']['challenge_date'])) . " +30 days"))." ".$current_time;
                $data['Challenge']['challenge_start_date'] = date("Y-m-d",strtotime($data['Challenge']['challenge_date']))." ".$current_time;
            }
            else
            {
                $data['Challenge']['challenge_start_date'] =  date("Y-m-d",strtotime(date("Y-m-d", strtotime($data['Challenge']['challenge_date'])) . "-30 days"))." ".$current_time;
                $data['Challenge']['challenge_end_date'] = date("Y-m-d",strtotime($data['Challenge']['challenge_date']))." ".$current_time;
            }
            
            //case of saving data first time for any page
            if(empty($challenge_id)){

                $res = $this->Challenge->save($data);
                $result = $res['Challenge']['id']; // get last insertd id


            }
            //case of updating a page data according to page_id
            else{
                

                $this->Challenge->id = $challenge_id;         
                $result = $this->Challenge->save($data);     
            }

        }
        return $result;
    } 

    /**
     * Funtion to add challenges to the database
     */
    public function admin_addChallenge()
    {
        $this->layout='admin_default'; 
        
        if($this->request->data)
        {

            //set the data value before validating the data
            $this->Challenge->set($this->request->data );
        
           //check validtaion here
            if( $this->Challenge->validates())
            {  
                $result = $this->saveChallenge($this->request->data,$challenge_id=null);
                if($result)
                {
                    $this->redirect(array('action'=>'challengeChooseJudge',$result));
                    
                }
            }
            
        }
      
    }


    public function admin_challengeChooseJudge($challenge_id =null)
    {

        $this->layout = 'admin_default';
     //  echo $this->params['controller'];
         $result = $this->Challenge->getChallengeById($challenge_id);
         $this->set('chall_data', $result);
         //pr($result);

        if(!empty( $result) )
        {
           

            //get all the decision type
            $res = $this->Challenge->getDecisionType();
            $this->set('decision_types', $res );

            $judge = $this->Challenge->getAllJudge();
             $this->set('judgedata', $judge );

             $result =  $this->ChallengeJudgeGrandWinner->find('all',array('conditions'=>array('challenge_id'=>$challenge_id)));
               $this->set('result', $result);
             if($result)
             {
                $name = $this->Challenge->getJudgeName($result[0]['ChallengeJudgeGrandWinner']['context_role_user_id']);
                $this->set('namedata', $name );
             }
             else
             {
                 $this->set('namedata', '' );
             }
         }else
         {
           $this->redirect(array('action'=>'addChallenge',$result)); 
         }
       
        //$dd = $this->Challenge->getDataSource()->getLog(false,false);
       // debug($dd);

        
    }  

    public function admin_challengeManagement()
    {
        // $this->layout = 'admin_default';
        // $result = $this->Challenge->getAllChallenges();
        // $this->set('challenge',$result);

          $limitPerpage = 10;
        $this->paginate = array('order'=>'Challenge.id DESC',
            'limit'=>$limitPerpage);
        
        $challenge = $this->paginate('Challenge');       
        $this->set('challenge', $challenge);

        $this->set('perPageLimit', $limitPerpage);
        
        if($this->RequestHandler->isAjax()){          
             $this->layout = 'ajax'; 
             $this->render('/Elements/admin_challenge_manage_element'); 
        }
        else{
            $this->layout = 'admin_default';
        }
      //  exit();

    } 
    public function admin_editChallenge($challenge_id=null)
    {
        $this->layout = 'admin_default';
        $res = $this->Challenge->getChallengeById($challenge_id);
        $this->set('chall_data',$res);
        if(!empty($res))
        {

            if($this->request->data){
                //set the data value before validating the data
                $this->Challenge->set($this->request->data );
            
               //check validtaion here
                if( $this->Challenge->validates()){  
                    $result = $this->saveChallenge($this->request->data,$challenge_id);
                    if($result){
                        $this->redirect(array('action'=>'challengeManagement'));
                        
                    }
                }
            }
        }
    } 

    /**
     * Funtion to add judge into the system
     */  
    public function admin_addJudgeChallenge(){

        $challenge_id = $this->request->data('challenge_id');
        $decision_type_id = $this->request->data('decision_type_id');
        $email_address = $this->request->data('email_address');
        $first_name = $this->request->data('first_name');

        $user_obj  = new UsersController(); 
        $random_password =  $user_obj->generateVarificationCode();        
        $password = md5($random_password) ;
        // $this->User->set()
       
        
            
        if ($this->request->is('ajax')) {
            if (!empty($this->request->data)) {
                $this->User->set($this->request->data);
                if (!$this->User->validates()){
                    $formErrors = $this->User->invalidFields();
                    $result = array("result" => "error","error_msg"=>$formErrors);
                } else {
                    $formErrors = null;
                     $current_time = date("Y-m-d H:i:s");
                     $data = array('first_name'=>trim($first_name),'email_address'=>trim($email_address),'password'=>trim($password),'varification_code'=>trim($random_password),'registration_date'=>$current_time);
                     $val = $this->User->save($data);
                     $user_id = $val['User']['id'];

                      $result = array("result" => "success");
                     

                    if($user_id)
                    {
                        $role = 'Judge';
                        //get role id 
                        $role_id = $this->User->getRoleId($role);

                        $context = 'Pioneer';
                        //get context
                        $context_id = $this->User->getContextId($context);

                        //get context role id 
                        $context_role_id = $this->User->getContextRoleId($context_id, $role_id);

                        //insert data into table "context_role_users"
                        $res = $this->Challenge->saveContextRoleUser($context_role_id,$user_id);
                        $context_role_user_id = $res['Challenge']['id'];


                        $inviter_context_role_user_id = $this->Session->read('context_role_user_id');
                        $inviter_user_id = $this->Session->read('user_id');

                        $inviter_info = $this->User->find('first',array('fields'=>array('first_name','last_name','email_address'),'conditions'=>array('id'=>$inviter_user_id)));

                        //insert record into table "challenge_judge_invitations"
                        $output = $this->Challenge->saveChallengeJudgeInvitation($context_role_user_id,$inviter_context_role_user_id) ;                   
                        if($output)
                        {

                            $subject = "Invitation as judge";
                            $from   =  $inviter_info['User']['email_address'];

                            $siteUrl = Router::url('/', true);


                            $verificactionLink = "<a href='".$siteUrl."users/email_verification/".$user_id."/".$random_password."'>".$siteUrl."users/email_verification/".$user_id."/".$random_password."</a>";

                            //send mail to the jugde with password as you are invited as a judge
                            $msg  = "Hi ".$first_name.",<br/><br/>You are invited as judge at TrepiCity.com.<br/><br/>You can activate your account by clicking on the link below or copying and pasting it into your browser:<br/><br/>".$verificactionLink."<br/><br/>Use the following Email and Password to log in :
                                    <br/><br/>Email : ".$email_address."<br/> Password -".$random_password."<br/><br/>Thank you!<br/>The TrepiCity Team.";
                          



                            // User email -".$email_address."<br/> Password -".$random_password."<br/>
                            // Please ".$verificactionLink." to activate your account.<br/>
                            // -<br/>
                            // Regards<br/>
                            // Entropolis Team.";

                            $Email = new CakeEmail('gmail');
                            $Email->from(array($from => 'Entropolis'));
                            $Email->to($email_address);
                            $Email->subject($subject);
                            $Email->emailFormat('html');
                            $res = $Email->send($msg);
                            $result = array("result" => "success");
                        }
                      

                    }
                    
                }
            } 
            // else {
            //     $formErrors = null;

            //     $result = array("result" => "success");
            // }
        }



        header("Content-type: application/json"); // not necessary
            echo json_encode($result);
            exit();
    }

    /**
     * Funtion to send the invitation to the judge
     */
    public function admin_sendInvitationToJudge($challenge_id=null,$decision_type_id=null,$user_id=null)
    {

        $siteUrl = Router::url('/', true);

        $challenge_id = $this->request->data('challenge_id');
        $decision_type_id = $this->request->data('decision_type_id');


         $user_id = $this->request->data('user_id');
    
        //echo "**".$challenge_id."((".$decision_type_id.")))".$user_id;


         $role = 'Judge';
        //get role id 
         $role_id = $this->User->getRoleId($role);

        $context = 'Pioneer';
        //get context
        $context_id = $this->User->getContextId($context);

        //get context role id 
        $context_role_id = $this->User->getContextRoleId($context_id, $role_id);

        //get context role user id
        $id = $this->Challenge->getContextRoleUserId($context_role_id,$user_id);
       
        $context_role_user_id = $id['Challenge']['id'];

         $inviter_context_role_user_id = $this->Session->read('context_role_user_id');

        $inviter_user_id = $this->Session->read('user_id');

        $inviter_info = $this->User->find('first',array('fields'=>array('first_name','last_name','email_address'),'conditions'=>array('id'=>$inviter_user_id)));
        
        $from   =  $inviter_info['User']['email_address'];

        //get challenge detail
        $challenge_detail = $this->Challenge->find('first',array('fields'=>array('challenge_title'),'conditions'=>array('id'=>$challenge_id)));

         if( $decision_type_id )
           { 
            //echo "jjj";
                //get decision type 
                $decision_types = $this->DecisionType->find('first',array('fields'=>array('decision_type'),'conditions'=>array('id'=>$decision_type_id)));

                //check whether the judes already added for this decision type under the challenge
                $record_count =  $this->ChallengeJudge->find('count',array('conditions' =>array('challenge_id'=>$challenge_id,'decision_type_id'=>$decision_type_id)));
                //if result found then delete the pervious record and send the mail of cancellation as a judge to prvious one  and send mail to another one
                if( $record_count )
                {
                    //check the invitation is sending to different judge or another one
                     $user_count =  $this->ChallengeJudge->find('count',array('conditions' =>array('challenge_id'=>$challenge_id,'decision_type_id'=>$decision_type_id,'context_role_user_id'=>$context_role_user_id )));
                    if($user_count)
                    {
                       //echo $result = array("result" => "success");
                        echo "exists";


                    }
                    else
                    {
                        
                        //get the context role user of the previous user
                        $previous_res =  $this->ChallengeJudge->find('first',array('conditions' =>array('challenge_id'=>$challenge_id,'decision_type_id'=>$decision_type_id)));
                                              
                            $current_time = date("Y-m-d H:i:s");

                                $data = array('context_role_user_id'=>$context_role_user_id, 'inviter_context_role_user_id'=> $inviter_context_role_user_id,'invited_on'=>"'$current_time'",'invitation_status'=>'0');
                     
                                //update the challege judge 
                                $upadte_res = $this->ChallengeJudge->updateAll( $data, array('ChallengeJudge.id'=>$previous_res['ChallengeJudge']['id']));
                                if(  $upadte_res )
                                {


                                    $previous_user_id = $this->ContextRoleUser->find('first',array('conditions' =>array('ContextRoleUser.id'=> $previous_res['ChallengeJudge']['context_role_user_id'])));
                                    $invitee_info = $this->User->find('first',array('fields'=>array('first_name','last_name','email_address'),'conditions'=>array('User.id'=> $previous_user_id['ContextRoleUser']['user_id'])));
                                    //send  cancellation mail
                                   
                                    $subject = "Removal as judge from challenge";              
                                    // $msg  = "Hello ".$invitee_info['User']['first_name'].",<br/>You are removed as a judge from our system for decision type " .$decision_types['DecisionType']['decision_type']. " under challenge
                                    //  " .ucfirst($challenge_detail['Challenge']['challenge_title'])."<br/> 
                                    // -<br/>
                                    // Regards<br/>
                                    // Entropolis Team.";

                                    $msg  = "Hi ".$invitee_info['User']['first_name'].",<br/><br/>
                                    You are removed as judge at Entropolis.com for the following challenge and decision type:<br/><br/>Challenge Name : ".ucfirst($challenge_detail['Challenge']['challenge_title'])."<br/>Decision Type : ".$decision_types['DecisionType']['decision_type']."<br/><br/>Thank you!<br/>The TrepiCity Team.";

                                    $Email = new CakeEmail('gmail');
                                    $Email->from(array($from => 'Entropolis'));
                                    $Email->to($invitee_info['User']['email_address']);
                                    $Email->subject($subject);
                                    $Email->emailFormat('html');
                                    $res = $Email->send($msg);

                                    //send invitation mail
                                    $invitee_info = $this->User->find('first',array('fields'=>array('first_name','last_name','email_address'),'conditions'=>array('id'=> $user_id)));
                                   
                                     $subject = "Invitation as judge for challenge";               
                              
                                    //send mail to the jugde with password as you are invited as a judge
                                    $msg  = "Hi ".$invitee_info['User']['first_name'].",<br/><br/>
                                    You are invited as judge at TrepiCity.com for the following challenge and decision type:<br/><br/>Challenge Name : ".ucfirst($challenge_detail['Challenge']['challenge_title'])."<br/>Decision Type : ".$decision_types['DecisionType']['decision_type']."<br/><br/>Thank you!<br/>The TrepiCity Team.";

                                    // You are invited as a judge into our system for decision type " .$decision_types['DecisionType']['decision_type']. " under challenge
                                    //  " .ucfirst($challenge_detail['Challenge']['challenge_title'])."<br/> 
                                    // -<br/>
                                    // Regards<br/>
                                    // Entropolis Team.";


                                    $Email = new CakeEmail('gmail');
                                    $Email->from(array($from => 'Entropolis'));
                                    $Email->to($invitee_info['User']['email_address']);
                                    $Email->subject($subject);
                                    $Email->emailFormat('html');
                                    $result = $Email->send($msg);

                                    echo $invitee_info['User']['first_name'];
                                }
                                
                            }    


                    }


                
                else
                {

                       
                        
                          
                            //insert record into table "challenge_judges"
                            $result = $this->Challenge->saveChallengeJudge($context_role_user_id,$decision_type_id,$challenge_id,$inviter_context_role_user_id );
                            
                            if($result)
                            {

                                 $invitee_info = $this->User->find('first',array('fields'=>array('first_name','last_name','email_address'),'conditions'=>array('id'=> $user_id)));
                        
                                $subject = "Invitation as judge for challenge";               
                              
                                // //send mail to the jugde with password as you are invited as a judge
                                // $msg  = "Hello ".$invitee_info['User']['first_name'].",<br/>You are invited as a judge into our system for decision type " .$decision_types['DecisionType']['decision_type']. " under challenge
                                //  " .ucfirst($challenge_detail['Challenge']['challenge_title'])."<br/> 
                                // -<br/>
                                // Regards<br/>
                                // Entropolis Team.";
                                 $msg  = "Hi ".$invitee_info['User']['first_name'].",<br/><br/>
                                    You are invited as judge at TrepiCity.com for the following challenge and decision type:<br/><br/>Challenge Name : ".ucfirst($challenge_detail['Challenge']['challenge_title'])."<br/>Decision Type : ".$decision_types['DecisionType']['decision_type']."<br/><br/>Thank you!<br/>The TrepiCity Team.";


                                $Email = new CakeEmail('gmail');
                                $Email->from(array($from => 'Entropolis'));
                                $Email->to($invitee_info['User']['email_address']);
                                $Email->subject($subject);
                                $Email->emailFormat('html');
                                $res = $Email->send($msg);

                                echo $invitee_info['User']['first_name'];
                            }
                      
                    }

        }
        //if judge is grand judge
        else
        {
           // echo "AAA";


            //check whether the judes already added for this decision type under the challenge
                $record_count =  $this->ChallengeJudgeGrandWinner->find('count',array('conditions' =>array('challenge_id'=>$challenge_id)));
                //if result found then delete the pervious record and send the mail of cancellation as a judge to prvious one  and send mail to another one
                if( $record_count )
                {
                    //check the invitation is sending to different judge or another one
                     $user_count =  $this->ChallengeJudgeGrandWinner->find('count',array('conditions' =>array('challenge_id'=>$challenge_id,'context_role_user_id'=>$context_role_user_id )));
                    if($user_count)
                    {
                       //echo $result = array("result" => "success");
                       //echo "This user is already invited as a  grand judge on this challenge.";
                        echo "exists";

                    }
                    else
                    {
                        
                        //get the context role user of the previous user
                        $previous_res =  $this->ChallengeJudgeGrandWinner->find('first',array('conditions' =>array('challenge_id'=>$challenge_id)));
                     
                            
                            $current_time = date("Y-m-d H:i:s");

                           
                                $data = array('context_role_user_id'=>$context_role_user_id, 'inviter_context_role_user_id'=> $inviter_context_role_user_id,'invited_on'=>"'$current_time'",'invitation_status'=>'0');
                     
                                //update the challege judge 
                                $update_res = $this->ChallengeJudgeGrandWinner->updateAll( $data, array('ChallengeJudgeGrandWinner.id'=>$previous_res['ChallengeJudgeGrandWinner']['id']));
                                if( $update_res)
                                {

                                    $previous_user_id = $this->ContextRoleUser->find('first',array('conditions' =>array('ContextRoleUser.id'=> $previous_res['ChallengeJudgeGrandWinner']['context_role_user_id'])));


                                    $invitee_info = $this->User->find('first',array('fields'=>array('first_name','last_name','email_address'),'conditions'=>array('User.id'=> $previous_user_id['ContextRoleUser']['user_id'])));


                                       //send  cancellation mail
                                    $subject = "Removal as grand judge from challenge";              
                                    // $msg  = "Hello ".$invitee_info['User']['first_name'].",<br/>You are removed as a grand judge from our system for challenge
                                    //  " .ucfirst($challenge_detail['Challenge']['challenge_title'])."<br/> 
                                    // -<br/>
                                    // Regards<br/>
                                    // Entropolis Team.";

                                    $msg  = "Hi ".$invitee_info['User']['first_name'].",<br/><br/>
                                    You are removed as grand judge at TrepiCity.com for the following challenge:<br/><br/>Challenge Name : ".ucfirst($challenge_detail['Challenge']['challenge_title'])."<br/><br/>Thank you!<br/>The TrepiCity Team.";
                                    
                                    $Email = new CakeEmail('gmail');
                                    $Email->from(array($from => 'Entropolis'));
                                    $Email->to($invitee_info['User']['email_address']);
                                    $Email->subject($subject);
                                    $Email->emailFormat('html');
                                    $res = $Email->send($msg);  



                                            //send invitation mail
                                    $invitee_info = $this->User->find('first',array('fields'=>array('first_name','last_name','email_address'),'conditions'=>array('id'=> $user_id)));
                                   
                                     $subject = "Invitation as grand judge for challenge";               
                              
                                    // //send mail to the jugde with password as you are invited as a judge
                                    // $msg  = "Hello ".$invitee_info['User']['first_name'].",<br/>You are invited as a grand judge into our system for under challenge
                                    //  " .ucfirst($challenge_detail['Challenge']['challenge_title'])."<br/> 
                                    // -<br/>
                                    // Regards<br/>
                                    // Entropolis Team.";

                                      $msg  = "Hi ".$invitee_info['User']['first_name'].",<br/><br/>
                                    You are invited as grand judge at TrepiCity.com for the following challenge:<br/><br/>Challenge Name : ".ucfirst($challenge_detail['Challenge']['challenge_title'])."<br/><br/>Thank you!<br/>The TrepiCity Team.";

                                    $Email = new CakeEmail('gmail');
                                    $Email->from(array($from => 'Entropolis'));
                                    $Email->to($invitee_info['User']['email_address']);
                                    $Email->subject($subject);
                                    $Email->emailFormat('html');
                                    $result = $Email->send($msg);    

                                    echo $invitee_info['User']['first_name'];

                                }
                                
                            
                       

                    }


                }
                else
                {

                       
                        
                          
                            //insert record into table "ChallengeJudgeGrandWinner"
                            $result = $this->ChallengeJudgeGrandWinner->save(array('context_role_user_id'=>$context_role_user_id,'challenge_id'=>$challenge_id,'inviter_context_role_user_id'=>$inviter_context_role_user_id,'invited_on'=>date('Y-m-d H:i:s')));
                            
                            if($result)
                            {
                                $invitee_info = $this->User->find('first',array('fields'=>array('first_name','last_name','email_address'),'conditions'=>array('id'=> $user_id)));
                        
                                $subject = "Invitation as judge for challenge";               
                              
                                // //send mail to the jugde with password as you are invited as a judge
                                // $msg  = "Hello ".$invitee_info['User']['first_name'].",<br/>You are invited as a grand  judge into our system for under challenge
                                //  " .ucfirst($challenge_detail['Challenge']['challenge_title'])."<br/> 
                                // -<br/>
                                // Regards<br/>
                                // Entropolis Team.";

                                  $msg  = "Hi ".$invitee_info['User']['first_name'].",<br/><br/>
                                    You are invited as grand judge at TrepiCity.com for the following challenge:<br/><br/>Challenge Name : ".ucfirst($challenge_detail['Challenge']['challenge_title'])."<br/><br/>Thank you!<br/>The TrepiCity Team.";

                                $Email = new CakeEmail('gmail');
                                $Email->from(array($from => 'Entropolis'));
                                $Email->to($invitee_info['User']['email_address']);
                                $Email->subject($subject);
                                $Email->emailFormat('html');
                                $res = $Email->send($msg);


                                echo $invitee_info['User']['first_name'];
                            }
                      
                    }


        }
        exit();
    }

    /**
     * Funtion to view judges
     */
    public function admin_viewJudge($challenge_id=null)
    {

        $this->layout='admin_default';
        $chal_data = $this->Challenge->getChallengeById($challenge_id);
        if(!empty($chal_data)){
        $this->set('chal_info',$chal_data);

        //get all the decision type
        $res = $this->Challenge->getDecisionType();
        $this->set('decision_types', $res );

         $judge = $this->Challenge->getAllJudge();
         $this->set('judgedata', $judge);

         $result =  $this->ChallengeJudgeGrandWinner->find('all',array('conditions'=>array('challenge_id'=>$challenge_id)));
        $this->set('result', $result);
        // pr($result);
        // die;
         if($result)
         {
            $name = $this->Challenge->getJudgeName($result[0]['ChallengeJudgeGrandWinner']['context_role_user_id']);
            $this->set('namedata', $name );
         }
         else
         {
             $this->set('namedata', '' );
         }
        }
    }

    public function admin_judgeProfile($user_id =null,$challenge_id=null)
    {
        $this->layout ='admin_default';
        $this->set('challenge_id',$challenge_id);
        $userres = $this->Challenge->getUserDetailByUserId($user_id);
        $this->set('userres',$userres);

       
    }
    public function admin_updateUserName()
    {
         if ($this->request->is('ajax')) {
            if (!empty($this->request->data)) {
                $this->User->set($this->request->data);
                if (!$this->User->validates()) {
                    $formErrors = $this->User->invalidFields();
                    $result = array("result" => "error","error_msg"=>$formErrors);
                } else {
                    $formErrors = null;

                     $this->User->id = $this->request->data('user_id');
                     $data=array('first_name' =>trim($this->request->data('first_name')) , 'last_name'=>trim($this->request->data('last_name')));     
                     $this->User->save( $data, $this->User->id );
                     $result = array("result" => "success");
                }
            } else {
                $formErrors = null;
                $result = array("result" => "success");
            }
        }
           

            header("Content-type: application/json"); // not necessary
            echo json_encode($result);
            exit;
    } 

    public function admin_updateGender()
    {
       

         if ($this->request->is('ajax')) {


            if (!empty($this->request->data)) {
               

                if ($this->request->data('gender')=='') {
                    $error = 'Gender is required';
                    $result = array("result" => "error","error_msg"=>$error);

                } else {
                    $formErrors = null;

                     $this->User->id = $this->request->data('user_id');
                     $data=array('gender' =>trim($this->request->data('gender')));     
                     $this->User->save( $data, $this->User->id );
                     $result = array("result" => "success");
                }
            } else {
                $formErrors = null;
                $result = array("result" => "success");
            }
        }

            header("Content-type: application/json"); // not necessary
            echo json_encode($result);
            exit;
    } 

    public function admin_updateEmailAddress()
    {
         if ($this->request->is('ajax')) {
            if (!empty($this->request->data)) {
                $this->User->set($this->request->data);
                if (!$this->User->validates()) {
                    $formErrors = $this->User->invalidFields();
                    $result = array("result" => "error","error_msg"=>$formErrors);
                } else {
                    $formErrors = null;

                     $this->User->id = $this->request->data('user_id');
                     $data=array('email_address' =>trim($this->request->data('email_address')));     
                     $this->User->save( $data, $this->User->id );
                     $result = array("result" => "success");
                }
            } else {
                $formErrors = null;
                $result = array("result" => "success");
            }
        }
           

            header("Content-type: application/json"); // not necessary
            echo json_encode($result);
            exit;
    } 

    public function admin_cancelChallenge()
    {
        $this->request->data('challenge_id');
        $this->Challenge->delete( $this->request->data('challenge_id'));
        exit();
    }

    public function admin_getAllJudgeInfo()
    {
        $html = '';
         $judge = $this->Challenge->getAllJudge();
    
         foreach($judge  as $judge_data){ 
         $html.="<tr><td class='radio-btn'>
                <input id=".$judge_data['u']['id']." type='radio' name='select-judge'>
                                            <label class='custom-radio' for=".$judge_data['u']['id']."></label>
                                        </td>
                                        <td>".$judge_data['u']['first_name']."</td>
                                        <td>".$judge_data['u']['email_address']."</td>
                                    </tr>";
                                }
                                echo $html;
                                exit();

    }

    public function admin_getFilteredData()
    {
        $first_name = $this->request->data('first_name');
        $email =  $this->request->data('email_add');
        $html = '';

         $virtualFields = array(
       'name' => 'CONCAT(User.first_name, " ", User.last_name)'
       );
        // $name 



        // $this->User->find('all',array('conditions'=>array('OR' => array(
        //     array('first_name' => 0),
        //     array('last_name' => $status),)))

       if($first_name!='' && $email !='')
       {
          
       // $res = $this->User->query("SELECT concat(first_name, ' ', last_name) as user_name, id,email_address FROM `users` LEFT JOIN context_role_users cru ON users.id = cru.user_id LEFT JOIN context_roles cr ON cru.context_role_id = cr.id LEFT JOIN roles r ON cr.role_id = r.id having user_name like '%".trim($first_name)."%' AND r.role='Judge' AND email_address =".trim($email)."");
        $res = $this->User->query("SELECT first_name,last_name, users.id,email_address FROM `users` LEFT JOIN context_role_users cru ON users.id = cru.user_id LEFT JOIN context_roles cr ON cru.context_role_id = cr.id LEFT JOIN roles r ON cr.role_id = r.id where (first_name like '%".trim($first_name)."%' OR last_name like '%".trim($first_name)."%') AND r.role ='Judge' AND email_address ='".trim($email)."'");    
       }
       else if($first_name!='' && $email =='' )
       {
         
            // $res = $this->User->query("SELECT concat(first_name, ' ', last_name) as user_name, id, email_address FROM `users`  having user_name like '%".trim($first_name)."%' ");
          $res = $this->User->query("SELECT first_name,last_name, users.id,email_address FROM `users` LEFT JOIN context_role_users cru ON users.id = cru.user_id LEFT JOIN context_roles cr ON cru.context_role_id = cr.id LEFT JOIN roles r ON cr.role_id = r.id where (first_name like '%".trim($first_name)."%' OR last_name like '%".trim($first_name)."%') AND r.role ='Judge'");    
       }
       else if($first_name=='' && $email !='')
       {
            // $res = $this->User->find('all',array('conditions'=>array('email_address'=>trim($email))));
             $res = $this->User->query("SELECT first_name,last_name, users.id,email_address FROM `users` LEFT JOIN context_role_users cru ON users.id = cru.user_id LEFT JOIN context_roles cr ON cru.context_role_id = cr.id LEFT JOIN roles r ON cr.role_id = r.id where  r.role ='Judge' AND email_address ='".trim($email)."'");    
       }
        if(!empty($res))
        {
           

            foreach ($res as  $value) {
             
            
                $html.="<tr><td class='radio-btn'>
                <input id=".$value['users']['id']." type='radio' name='select-judge'>
                                            <label class='custom-radio' for=".$value['users']['id']."></label>
                                        </td>
                                        <td>".$value['users']['first_name'].' '.$value['users']['last_name']."</td>
                                        <td>".$value['users']['email_address']."</td>
                                   </tr>";
                               }
        }
        else
        {
            $html.= 'No records found.';
        }
        

        echo $html;



           exit();
    }

    public function admin_challengeCompleted($challenge_id)
    {


        $this->layout='admin_default';
        $chal_data = $this->Challenge->getChallengeById($challenge_id);

        if(!empty($chal_data)){
        $this->set('chal_info',$chal_data);

        //get all the decision type
        $res = $this->Challenge->getDecisionType();
        $this->set('decision_types', $res );

         $judge = $this->Challenge->getAllJudge();
         $this->set('judgedata', $judge);

           $result =  $this->ChallengeJudgeGrandWinner->find('all',array('conditions'=>array('challenge_id'=>$challenge_id)));
         if($result)
         {
            $name = $this->Challenge->getJudgeName($result[0]['ChallengeJudgeGrandWinner']['context_role_user_id']);
            $this->set('namedata', $name );
         }
         else
         {
             $this->set('namedata', '' );
         }
     }

    }

    public function admin_viewEntry($challenge_id = null)
    {
        $this->layout='admin_default';

        $res = $this->Challenge->getChallengeById($challenge_id);
       // pr($res);
         $this->set('challenge_data',$res);
        if(!empty($res))
        {
            
        $context_role_user_id = $this->Session->read('context_role_user_id');
       

        //$decision_types =  $this->Judge->getDecisionTypeById($challenge_id);
        $decision_types = $this->Challenge->getDecisionType();
        $this->set('decision_types',$decision_types);
        if( !empty($decision_types) ){
            $count_grand_judge = $this->ChallengeJudgeGrandWinner->find('count',array('conditions'=>array('challenge_id'=>$challenge_id,'context_role_user_id'=>$context_role_user_id)));
            if( !empty($decision_types))
            {
             $decision_type_id = $decision_types[0]['Challenge']['id'];
             $status = 0;
            }
            else
             {
                if($count_grand_judge)
                {
                  $status =2;
                }

             }
         $this->set('count_grand_judge',$count_grand_judge);
       

       
      }
     }
    }

    public function admin_getChallengeByStatusAdmin()
    {
        $html = '';
      $siteUrl = Router::url('/', true);

      $challenge_id = $this->request->data('challenge_id');
      $decision_type_id = $this->request->data('decision_type_id');
      $judgement_status = $this->request->data('judgement_status');
       $challenge_type = $this->request->data('challenge_type');

       $context_role_user_id = $this->Session->read('context_role_user_id');
       if($judgement_status=='rejected')
       {
        $judgementstatus ='1';
       }
       else if( $judgement_status=='pending')
       {
         $judgementstatus ='0';
       }
        else if( $judgement_status=='shortlisted')
       {

          if(trim($decision_type_id)==trim('Grand Winner'))
          {
            $judgementstatus ='3'; // get all the nominee
          }
          else{
              $judgementstatus ='2';
          }
            
       }
       else if( $judgement_status=='nominated')
       {

             if(trim($decision_type_id)==trim('Grand Winner'))
          {
            $judgementstatus ='1'; // get the grand winner among all the decision type 
          }
          else{
              $judgementstatus ='3';
          }
            
       }

       if(trim($challenge_type) ==trim('Advice'))
       {
      

            $pending_res = $this->Challenge->getAllAdviceByStatus($challenge_id, $decision_type_id,$judgementstatus);   
            if(!empty($pending_res)){      

          //  $this->set('pending_res',$pending_res);
        
            $html.='<div class="tab-pane active" id="'.$judgement_status.'">
                            <div>'; 
                
            foreach($pending_res as $output){ 
                //pr($pending_res);
                //die;
                
                 $categorytype = $this->Category->find('first',array('conditions'=>array('id'=>$output['Challenge']['category_id'])));

                   $advice_id = $output['Challenge']['id'];
               $comment_count = $this->Comment->find('count',array('conditions'=>array('advice_id'=>$output['Challenge']['id'],'rating <>'=>'')));
               if($comment_count)
               {
                 $get_comment_sum = $this->Comment->query("SELECT sum(rating) as total FROM comments WHERE advice_id = $advice_id AND rating!='' ");
             
              $average_rating = round(($get_comment_sum[0][0]['total']/$comment_count),1);
             }else{
                 $average_rating = 0;
                }

             $html.='<div class="judge-challenge-div  clearfix ">
                                    <div class="col-md-9 judge-tab-sidebar">
                                        <h2>'.$output['Challenge']['advice_title']." ".$output['Challenge']['id'].'</h2>';
          
                     
 $html.='<h6>'.$categorytype["Category"]["category_name"].'</h6>                
                    <p align="justify">'.$this->text_cut($output['Challenge']['executive_summary'], $length = 200, $dots = true).'</p>';
             $html.='<span><strong>Rating:</strong>'.$average_rating.'</span>
                    <a href="'.$siteUrl.'admin/Challenges/adviceDetail/'.$output['Challenge']['id'].'"  class="right">View Details</a>
                    </div>
                     <div class="col-md-3 judge-tab-rightbar">';
                    
                      
                     $user_context_role_id = $output['Challenge']['context_role_user_id'];
                     $user_id_user = $this->ContextRoleUser->find('first',array('conditions'=>array('ContextRoleUser.id'=>$user_context_role_id)));
                     //pr($user_id_user);
                     //die;
                    $uid =  $user_id_user['ContextRoleUser']['user_id'];
                    $user_obj = new UsersController();
                    $user_image = $user_obj->getUserAvatar($uid);
                  
                     if($user_image)
                     {
                       //  $image = $this->Html->url('/'). $this->Image->resize($user_image, 50, 50, false);
                        $html.='<img src="'.$siteUrl.$user_image.'" alt=""/>';
                     }
                     else
                     {
                         $html.='<img src="'.$siteUrl.'upload/avatar-male-1.png">';
                     }
                     
                   
                      $html.='<span>'.$user_id_user["User"]["first_name"]." ".$user_id_user["User"]["last_name"].'</span>';

                                     $html.='</div>
                                </div>';
                       }
                            $html.='</div></div>';

                    }
                    else
                    {
                        $html.='No records found.';
                    }
       }
       else
       {

            $pending_res = $this->Judge->getAllChallengeByStatus($challenge_id, $decision_type_id,$judgementstatus);
            
            if(!empty($pending_res)){
        
            $html.='<div class="tab-pane active" id="'.$judgement_status.'">
                            <div>'; 
                
            foreach($pending_res as $output){ 
         

                $categorytype = $this->Category->find('first',array('conditions'=>array('id'=>$output['Judge']['category_id'])));
       
                $hindsight_id = $output['Judge']['id'];
               $comment_count = $this->Comment->find('count',array('conditions'=>array('hindsight_id'=>$output['Judge']['id'],'rating <>'=>'')));
               if($comment_count)
               {
                 $get_comment_sum = $this->Comment->query("SELECT sum(rating) as total FROM comments WHERE hindsight_id = $hindsight_id AND rating!='' ");
             
                $average_rating = round(($get_comment_sum[0][0]['total']/$comment_count),1);
                 }else{
                     $average_rating = 0;
                    }
                        $decison_type = $this->DecisionType->find('first',array('conditions'=>array('id'=>$output['Judge']['decision_type_id'])));
          
             $html.='<div class="judge-challenge-div  clearfix ">
                                    <div class="col-md-9 judge-tab-sidebar">
                                        <h2>'.$output['Judge']['hindsight_title']." ".$output['Judge']['id'].'</h2>';
              if(trim($decision_type_id)==trim('Grand Winner'))
                 {
                                   
                    $html.='<h6>'.$decison_type["DecisionType"]["decision_type"].'|'.$categorytype["Category"]["category_name"].'</h6>';       
                }
                else
                {
                   $html.='<h6>'.$categorytype["Category"]["category_name"].'</h6>'; 
                }
                      
                              
                    $html.='<p align="justify">'.$this->text_cut($output['Judge']['short_description'], $length = 200, $dots = true).'</p>';

             $html.='<span><strong>Rating:</strong>'.$average_rating.'</span>
                    <a href="'.$siteUrl.'admin/Challenges/hindsightDetail/'.$output['Judge']['id'].'"  class="right">View Details</a>
                    </div>
                     <div class="col-md-3 judge-tab-rightbar">';
                    
                      
                     $user_context_role_id = $output['Judge']['context_role_user_id'];
                     $user_id_user = $this->ContextRoleUser->find('first',array('conditions'=>array('ContextRoleUser.id'=>$user_context_role_id)));
                     //pr($user_id_user);
                     //die;
                    $uid =  $user_id_user['ContextRoleUser']['user_id'];
                    $user_obj = new UsersController();
                    $user_image = $user_obj->getUserAvatar($uid);
                  
                     if($user_image)
                     {
                       //  $image = $this->Html->url('/'). $this->Image->resize($user_image, 50, 50, false);
                        $html.='<img src="'.$siteUrl.$user_image.'" alt=""/>';
                     }
                     else
                     {
                         $html.='<img src="'.$siteUrl.'upload/avatar-male-1.png">';
                     }
                     
                   
                      $html.='<span>'.$user_id_user["User"]["first_name"]." ".$user_id_user["User"]["last_name"].'</span>';

                                     $html.='</div>
                                </div>';
                       }
                            $html.='</div></div>';

                    }
                    else
                    {
                        $html.='No records found.';
                    }

       }
       
        echo $html;

        
        exit();
    }

    public function admin_getAllChallengeByDecisionTypeAdmin(){
          $siteUrl = Router::url('/', true);
            $html = '';
       
        $challenge_id = $this->request->data('challenge_id');
        $decision_type_id = $this->request->data('decision_type_id');
        $judgement_status = $this->request->data('judgement_status');
        $challenge_type = $this->request->data('challenge_type');

        $context_role_user_id = $this->Session->read('context_role_user_id');
        
        $pending_count = $this->Hindsight->find('count',array('conditions'=>array('challenge_id'=>$challenge_id,'Hindsight.decision_type_id'=>$decision_type_id,'judgement_status'=>0)));
        $rejected_count = $this->Hindsight->find('count',array('conditions'=>array('challenge_id'=>$challenge_id,'Hindsight.decision_type_id'=>$decision_type_id,'judgement_status'=>'1')));
             
        $short_count = $this->Hindsight->find('count',array('conditions'=>array('challenge_id'=>$challenge_id,'Hindsight.decision_type_id'=>$decision_type_id,'judgement_status'=>'2')));

      
        //if grand winner tab
        if( trim($challenge_type) ==trim('Grand Winner'))
        {

             if( $judgement_status=='shortlisted')
            {
                $judgementstatus ='3';
            }

            $short_count = $this->Hindsight->find('count',array('conditions'=>array('challenge_id'=>$challenge_id,'judgement_status'=>'3','grand_winner_status'=>0)));
            
            $pending_res = $this->Judge->getAllChallengeByStatus($challenge_id, $decision_type_id ,$judgementstatus);

            $html.='<ul class="nav nav-tabs tabs  setting-tab"><li class="active">';
            $html.='<a href="#short-listed"  onclick = "getChallengeByStatusAdmin(\'shortlisted\','.$challenge_id.')" data-toggle="tab">Short-listed ('. $short_count.')</a></li>';
            $html.='<li><a href="#winner" onclick = "getChallengeByStatusAdmin(\'nominated\','.$challenge_id.')"data-toggle="tab">Nominated</a></li>';
             $html.='</ul><div class="tab-content"><div class="tab-pane active" id="'.$judgement_status.'">
                          <div>';

            if(!empty($pending_res )){
            $this->set('pending_res',$pending_res);
        
             foreach($pending_res as $output){ 
              
                $categorytype = $this->Category->find('first',array('conditions'=>array('id'=>$output['Judge']['category_id'])));

               $hindsight_id = $output['Judge']['id'];
               $comment_count = $this->Comment->find('count',array('conditions'=>array('hindsight_id'=>$output['Judge']['id'],'rating <>'=>'')));
               if($comment_count)
               {
                 $get_comment_sum = $this->Comment->query("SELECT sum(rating) as total FROM comments WHERE hindsight_id = $hindsight_id AND rating!='' ");
             
              $average_rating = round(($get_comment_sum[0][0]['total']/$comment_count),1);
             }else{
                 $average_rating = 0;
                }
                $decison_type = $this->DecisionType->find('first',array('conditions'=>array('id'=>$output['Judge']['decision_type_id'])));
               
           $html.='<div class="judge-challenge-div  clearfix ">
                                  <div class="col-md-9 judge-tab-sidebar">
                                      <h2>'.$output['Judge']['hindsight_title']." ".$output['Judge']['id'].'</h2>';
        
                   $html.='<h6>'.$decison_type["DecisionType"]["decision_type"].'|'.$categorytype["Category"]["category_name"].'</h6>                  
                  <p align="justify">'.$this->text_cut($output['Judge']['short_description'], $length = 200, $dots = true).'</p>';
             $html.='<span><strong>Rating:</strong>'.$average_rating.'</span>
                <a href="'.$siteUrl.'admin/Challenges/hindsightDetail/'.$output['Judge']['id'].'" class="right">View Details</a>
                  </div>
                   <div class="col-md-3 judge-tab-rightbar">';
                   
                   $user_context_role_id = $output['Judge']['context_role_user_id'];
                $user_id_user = $this->ContextRoleUser->find('first',array('conditions'=>array('ContextRoleUser.id'=>$user_context_role_id)));

                $uid =  $user_id_user['ContextRoleUser']['user_id'];
                $user_obj = new UsersController();
                $user_image = $user_obj->getUserAvatar($uid);
              
                 if($user_image)
                 {
                   //  $image = $this->Html->url('/'). $this->Image->resize($user_image, 50, 50, false);
                    $html.='<img src="'.$siteUrl.$user_image.'" alt=""/>';
                 }
                 else
                 {
                     $html.='<img src="'.$siteUrl.'upload/avatar-male-1.png">';
                 }
                  
                  $html.='<span>'.$user_id_user["User"]["first_name"]." ".$user_id_user["User"]["last_name"].'</span>';
                         
                                  $html.='</div>
                              </div>';
                     }
                          $html.='</div></div></div>';
                  }
                  else
                  {
                    $html.='No records found.';
                  }
        }
        else if(trim($challenge_type)==trim('Hindsight'))
        {
            
            if( $judgement_status=='pending')
            {
                $judgementstatus ='0';
            }


              $pending_res = $this->Judge->getAllChallengeByStatus($challenge_id, $decision_type_id,$judgementstatus);

              $html.='<ul class="nav nav-tabs tabs  setting-tab"><li class="active">
               <a href="#pending" onclick = "getChallengeByStatusAdmin(\'pending\','.$challenge_id.')" data-toggle="tab">Pending ('.$pending_count.')</a></li>';
           
            $html.='<li><a href="#rejected" onclick = "getChallengeByStatusAdmin(\'rejected\','.$challenge_id.')" data-toggle="tab">Rejected ('.$rejected_count.')</a></li>' ;             
                      
            $html.='<li><a href="#short-listed"  onclick = "getChallengeByStatusAdmin(\'shortlisted\','.$challenge_id.')" data-toggle="tab">Short-listed ('. $short_count.')</a></li>';
            $html.='<li><a href="#winner" onclick = "getChallengeByStatusAdmin(\'nominated\','.$challenge_id.')"data-toggle="tab">Nominated</a></li>';
            $html.='</ul><div class="tab-content"><div class="tab-pane active" id="'.$judgement_status.'">
                          <div>'; 
            $this->set('pending_res',$pending_res);
              if(!empty($pending_res )){
             
                

            

               
              
          foreach($pending_res as $output){ 
        $categorytype = $this->Category->find('first',array('conditions'=>array('id'=>$output['Judge']['category_id'])));


                 $hindsight_id = $output['Judge']['id'];
               $comment_count = $this->Comment->find('count',array('conditions'=>array('hindsight_id'=>$output['Judge']['id'],'rating <>'=>'')));
               if($comment_count)
               {
                 $get_comment_sum = $this->Comment->query("SELECT sum(rating) as total FROM comments WHERE hindsight_id = $hindsight_id AND rating!=''");
             
              $average_rating = round(($get_comment_sum[0][0]['total']/$comment_count),1);
             }else{
                 $average_rating = 0;
                }

           $html.='<div class="judge-challenge-div  clearfix ">
                                  <div class="col-md-9 judge-tab-sidebar">
                                      <h2>'.$output['Judge']['hindsight_title']." ".$output['Judge']['id'].'</h2>';
        
                 $html.='<h6>'.$categorytype["Category"]["category_name"].'</h6>                  
                  <p align="justify">'.$this->text_cut($output['Judge']['short_description'], $length = 200, $dots = true).'</p>';
             $html.='<span><strong>Rating:</strong>'.$average_rating.'</span>
                <a href="'.$siteUrl.'admin/Challenges/hindsightDetail/'.$output['Judge']['id'].'" class="right">View Details</a>
                  </div>
                   <div class="col-md-3 judge-tab-rightbar">';
                   
                   $user_context_role_id = $output['Judge']['context_role_user_id'];
                $user_id_user = $this->ContextRoleUser->find('first',array('conditions'=>array('ContextRoleUser.id'=>$user_context_role_id)));

                $uid =  $user_id_user['ContextRoleUser']['user_id'];
                $user_obj = new UsersController();
                $user_image = $user_obj->getUserAvatar($uid);
              
                 if($user_image)
                 {
                   //  $image = $this->Html->url('/'). $this->Image->resize($user_image, 50, 50, false);
                    $html.='<img src="'.$siteUrl.$user_image.'" alt=""/>';
                 }
                 else
                 {
                     $html.='<img src="'.$siteUrl.'upload/avatar-male-1.png">';
                 }
                 $html.='<span>'.$user_id_user["User"]["first_name"]." ".$user_id_user["User"]["last_name"].'</span>';
                    

                                  $html.='</div>
                              </div>';
                     }
                          $html.='</div></div></div>'; 
                      }
                      else{
                        $html.='No records found.';
                      }   
          }
          //case of advice 
          else
          {


            $pending_count = $this->Advice->find('count',array('conditions'=>array('challenge_id'=>$challenge_id,'Advice.decision_type_id'=>$decision_type_id,'status_id'=>0)));
            $rejected_count = $this->Advice->find('count',array('conditions'=>array('challenge_id'=>$challenge_id,'Advice.decision_type_id'=>$decision_type_id,'status_id'=>'1')));
             
            $short_count = $this->Advice->find('count',array('conditions'=>array('challenge_id'=>$challenge_id,'Advice.decision_type_id'=>$decision_type_id,'status_id'=>'2')));

                if( $judgement_status=='pending')
                {
                    $judgementstatus ='0';
                }

                $pending_res = $this->Challenge->getAllAdviceByStatus($challenge_id, $decision_type_id,$judgementstatus);
                   $html.='<ul class="nav nav-tabs tabs  setting-tab"><li class="active">
                   <a href="#pending" onclick = "getChallengeByStatusAdmin(\'pending\','.$challenge_id.')" data-toggle="tab">Pending ('.$pending_count.')</a></li>';
               
               $html.='<li><a href="#rejected" onclick = "getChallengeByStatusAdmin(\'rejected\','.$challenge_id.')" data-toggle="tab">Rejected ('.$rejected_count.')</a></li>' ;             
                          
               $html.='<li><a href="#short-listed"  onclick = "getChallengeByStatusAdmin(\'shortlisted\','.$challenge_id.')" data-toggle="tab">Short-listed ('. $short_count.')</a></li>';
               $html.='<li><a href="#winner" onclick = "getChallengeByStatusAdmin(\'nominated\','.$challenge_id.')"data-toggle="tab">Nominated</a></li>';
              $html.='</ul><div class="tab-content"><div class="tab-pane active" id="'.$judgement_status.'">
                              <div>'; 
                if(!empty($pending_res))
                {
                $this->set('pending_res',$pending_res);

            

            
              
          foreach($pending_res as $output){ 
             $categorytype = $this->Category->find('first',array('conditions'=>array('id'=>$output['Challenge']['category_id'])));

               $advice_id = $output['Challenge']['id'];
               $comment_count = $this->Comment->find('count',array('conditions'=>array('advice_id'=>$output['Challenge']['id'],'rating <>'=>'')));
               if($comment_count)
               {
                 $get_comment_sum = $this->Comment->query("SELECT sum(rating) as total FROM comments WHERE advice_id = $advice_id AND rating!=''");
             
              $average_rating = round(($get_comment_sum[0][0]['total']/$comment_count),1);
             }else{
                 $average_rating = 0;
                }   
           $html.='<div class="judge-challenge-div  clearfix ">
                                  <div class="col-md-9 judge-tab-sidebar">
                                      <h2>'.$output['Challenge']['advice_title']." ".$output['Challenge']['id'].'</h2>';
        
                    $html.='<h6>'.$categorytype["Category"]["category_name"].'</h6>              
                  <p align="justify">'.$this->text_cut($output['Challenge']['executive_summary'], $length = 200, $dots = true).'</p>';

          $html.='<span><strong>Rating:</strong>'.$average_rating.'</span>
                <a href="'.$siteUrl.'admin/Challenges/adviceDetail/'.$output['Challenge']['id'].'" class="right">View Details</a>
                  </div>
                   <div class="col-md-3 judge-tab-rightbar">';
                   
                   $user_context_role_id = $output['Challenge']['context_role_user_id'];
                $user_id_user = $this->ContextRoleUser->find('first',array('conditions'=>array('ContextRoleUser.id'=>$user_context_role_id)));

                $uid =  $user_id_user['ContextRoleUser']['user_id'];
                $user_obj = new UsersController();
                $user_image = $user_obj->getUserAvatar($uid);
              
                 if($user_image)
                 {
                   //  $image = $this->Html->url('/'). $this->Image->resize($user_image, 50, 50, false);
                    $html.='<img src="'.$siteUrl.$user_image.'" alt=""/>';
                 }
                 else
                 {
                     $html.='<img src="'.$siteUrl.'upload/avatar-male-1.png">';
                 }
                 $html.='<span>'.$user_id_user["User"]["first_name"]." ".$user_id_user["User"]["last_name"].'</span>';
                    

                                  $html.='</div>
                              </div>';
                     }
                          $html.='</div></div></div>';   
                      }
                      else{
                        $html.='No records found.';
                      }  

          }
           
        echo $html;
        exit();

    }

    public function admin_hindsightDetail($hindsight_id=null)
    {
       
        $this->layout = 'admin_default';
        $res = $this->Judge->getHindsightDetail($hindsight_id);
        if(!empty($res)){

        $this->set('hindsightsdetail',$this->Judge->getHindsightDetail($hindsight_id));
       
        $output = $this->Judge->getHindsightById($hindsight_id);
         
       
        $context_role_user_id = $output['Judge']['context_role_user_id'] ;
        $this->set('hindsights', $output);
        $name = $this->Judge->getUserName($context_role_user_id);
        $this->set('name', $name);

        $user_obj = new UsersController();
        $user_image = $user_obj->getUserAvatar($name[0]['u']['id']);
        $this->set('user_image', $user_image);

         $categorytype = $this->Category->find('first',array('conditions'=>array('id'=>$output['Judge']['category_id'])));
            $this->set('categorytype', $categorytype["Category"]["category_name"]);
              $decision_types = $this->DecisionType->find('first',array('conditions'=>array('id'=>$output['Judge']['decision_type_id'])));
            $this->set('decision_types', $decision_types["DecisionType"]["decision_type"]);

        }

      }

    public function admin_adviceDetail($advice_id=null)
    {
       
        $this->layout = 'admin_default';

        $advicedetail = $this->Advice->find('first',array('conditions'=>array('Advice.id'=>$advice_id)));
        if(!empty($advicedetail))
        {
         $this->set('advicedetail',$advicedetail);
       
         $context_role_user_id = $advicedetail['Advice']['context_role_user_id'] ;
       
         $name = $this->Judge->getUserName($context_role_user_id);
         $this->set('name', $name);

        $user_obj = new UsersController();
        $user_image = $user_obj->getUserAvatar($name[0]['u']['id']);
        $this->set('user_image', $user_image);

        }

      }

      public function text_cut($text, $length = 200, $dots = true) {
    $text = trim(preg_replace('#[\s\n\r\t]{2,}#', ' ', $text));
    $text_temp = $text;
    while (substr($text, $length, 1) != " ") { $length++; if ($length > strlen($text)) { break; } }
    $text = substr($text, 0, $length);
    return $text . ( ( $dots == true && $text != '' && strlen($text_temp) > $length ) ? '...' : ''); 
}


}
