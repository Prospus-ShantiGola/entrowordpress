<?php
App::uses('AppController', 'Controller');
App::uses('UsersController', 'Controller');

class JudgesController extends AppController{

  public $helpers = array('Html','Form','Judge','Js'=>array('Jquery'));

   public $uses = array('ChallengeJudge','Challenge','Judge','DecisionType','Hindsight','HindsightDetail','Category','User','ContextRoleUser','ChallengeJudgeGrandWinner','Comment');
   public $components = array('Session', 'RequestHandler');
    public $paginate = array();

    function beforeFilter() {
      parent::beforeFilter();
        if ($this->Session->read('user_id') == "") {
            $this->redirect(array('controller' => 'users', 'action' => 'login'));
        }
        $this->layout = 'judge_default';
        $userId = $this->Session->read('user_id');
        $userObj = new UsersController();
        $avatar = $userObj->getUserAvatar($userId);
        $this->set('avatar', $avatar);
    }
    
    public function index(){
        
       $userId = $this->Session->read('user_id');      
        $userObj = new UsersController();
        $avatar =  $userObj->getUserAvatar($userId);
        $this->set('avatar', $avatar);
        $this->layout = 'judge_default'; 
        
    }

    /**
     * Function to maintain the judge dashboard
     */
    public function dashboard()
    {
        $this->layout = 'judge_default';        
    }
    
    public function judgeChallengeManagement()
    {
        $this->layout = 'judge_default';

        $context_role_user_id = $this->Session->read('context_role_user_id');

        //get all the challenges on which a user is invited as a judge
        $result = $this->Judge->getAllChallengeById($context_role_user_id);
        //if(!empty( $result))
       // {
              $this->set('challenge',$result);
       
        //get all the challenges on which a user is invited as a grand judge
        $value = $this->Judge->getAllGrandChallengeById($context_role_user_id);
       
           $this->set('grandjudge',$value);
        //}
              
    }

    public function viewChallenge($challenge_id=null)
    {
        $this->layout = 'judge_default';

        $res = $this->Challenge->getChallengeById($challenge_id);

         $context_role_user_id = $this->Session->read('context_role_user_id');

        $this->set('challenge_data',$res);
        if(!empty($res))
        {
          $decision_types =  $this->Judge->getDecisionTypeById($challenge_id,$context_role_user_id);
         if( !empty($decision_types) ){
          $this->set('decision_types',$decision_types);
          }  

            $count_grand_judge = $this->ChallengeJudgeGrandWinner->find('count',array('conditions'=>array('challenge_id'=>$challenge_id,'context_role_user_id'=>$context_role_user_id,'invitation_status'=>'1')));        
           if( !empty($decision_types))
           {
               $decision_type_id = $decision_types[0]['decision_types']['id'];
               $status =0;
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

    

    public function getChallengeByStatus()
    {
      $siteUrl = Router::url('/', true);

      $challenge_id = $this->request->data('challenge_id');
      $decision_type_id = $this->request->data('decision_type_id');
      $judgement_status = $this->request->data('judgement_status');

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

        $pending_res = $this->Judge->getAllChallengeByStatus($challenge_id, $decision_type_id,$judgementstatus);
      //  $this->set('pending_res',$pending_res);
          
        $html = '';
        $html.='<div class="tab-pane active" id="'.$judgement_status.'">
                        <div>'; 
         if(!empty( $pending_res))  { 
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
                <a href="'.$siteUrl.'Judges/hindsight_detail/'.$output['Judge']['id'].'"  class="right">View Details</a>
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

                   if( $judgement_status=='pending')
                        {
                            $html.='<div class="col-md-12">
                                <a href="javascript:void(0);" data-id ="hindsight-'.$output['Judge']['id'].'" class ="update-status shortlisted ">Short-List</a>
                                <a href="javascript:void(0);" data-id ="hindsight-'.$output['Judge']['id'].'" class ="update-rejected-status rejected ">Reject</a>
                               
                            </div>';
                        }
                        else if($judgement_status=='rejected')
                        {
                          $html.='<div class="col-md-12">
                                <a href="javascript:void(0);" id = "rejected-pane" data-id ="hindsight-'.$output['Judge']['id'].'" class ="update-status shortlisted ">Short-List</a>
                                <a href="javascript:void(0);" data-id ="hindsight-'.$output['Judge']['id'].'" class ="update-reconsider-status pending ">Reconsider</a>
                               
                            </div>';
                        }
                        else if($judgement_status == 'shortlisted')
                        {
                             $html.='<div class="col-md-12">';

                                if(trim($decision_type_id)==trim('Grand Winner'))
                                {
                                  $judgementstatus ='1'; // get the grand winner among all the decision type 
                                }
                                else{
                                    $judgementstatus ='3';
                                }
                                                    //check either this challenge have a nominee or not
                              //  $judgementstatus = '3';
                               $pending_res = $this->Judge->getAllChallengeByStatus($challenge_id, $decision_type_id,$judgementstatus);
                               //pr($pending_res);
                             //  die;
                               if(empty($pending_res))
                               {
                                if( trim($decision_type_id)==trim('Grand Winner') )
                                {
                                     $html.='<a href="javascript:void(0);"  data-id ="hindsight-'.$output['Judge']['id'].'" class ="winner nominated grand">Select Grand Winner</a>';   
                                }
                                else
                                {
                                    $html.='<a href="javascript:void(0);"  data-id ="hindsight-'.$output['Judge']['id'].'" class ="winner nominated ">Select Winner</a>';   
                                }
                               
                               }
                                
                                $html.='<a href="javascript:void(0);" id = "shortlist-tab" data-id ="hindsight-'.$output['Judge']['id'].'" class ="update-rejected-status rejected ">Reject</a>
                               
                            </div>';
                    
                        }
                        



                                 $html.='</div>
                            </div>';
                   }
                        $html.='</div></div>';
       
       }
        else
                  {
                    $html.='No records found.';
                  }
        echo $html;

        
        exit();
    }

    public function getAllChallengeByDecisionType(){
          $siteUrl = Router::url('/', true);
            $html = '';
       
        $challenge_id = $this->request->data('challenge_id');
        $decision_type_id = $this->request->data('decision_type_id');
        $judgement_status = $this->request->data('judgement_status');

        $context_role_user_id = $this->Session->read('context_role_user_id');
        
        $pending_count = $this->Hindsight->find('count',array('conditions'=>array('challenge_id'=>$challenge_id,'Hindsight.decision_type_id'=>$decision_type_id,'judgement_status'=>0)));
        $rejected_count = $this->Hindsight->find('count',array('conditions'=>array('challenge_id'=>$challenge_id,'Hindsight.decision_type_id'=>$decision_type_id,'judgement_status'=>'1')));
             
        $short_count = $this->Hindsight->find('count',array('conditions'=>array('challenge_id'=>$challenge_id,'Hindsight.decision_type_id'=>$decision_type_id,'judgement_status'=>'2')));

       

        if( $decision_type_id =='Grand Winner')
        {

            if( $judgement_status=='shortlisted')
            {
                $judgementstatus ='3'; // get all the nominee of all type of the challenge
            }


            $short_count = $this->Hindsight->find('count',array('conditions'=>array('challenge_id'=>$challenge_id,'judgement_status'=>'3','grand_winner_status'=>0)));
            $pending_res = $this->Judge->getAllChallengeByStatus($challenge_id, $decision_type_id , $judgementstatus);
        

           // $this->set('pending_res',$pending_res);
        
            

            $html.='<ul class="nav nav-tabs tabs  setting-tab"><li class="active">';
            $html.='<a href="#short-listed"  onclick = "getChallengeByStatus(\'shortlisted\','.$challenge_id.')" data-toggle="tab">Short-listed ('. $short_count.')</a></li>';
            $html.='<li><a href="#winner" onclick = "getChallengeByStatus(\'nominated\','.$challenge_id.')"data-toggle="tab">Nominated</a></li>';
             $html.='</ul><div class="tab-content"><div class="tab-pane active" id="'.$judgement_status.'">
                          <div>';

                if(!empty($pending_res )){
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
                <a href="'.$siteUrl.'Judges/hindsight_detail/'.$output['Judge']['id'].'" class="right">View Details</a>
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
                  //  echo $this->Html->image('avatar.jpg');
                  $html.='<span>'.$user_id_user["User"]["first_name"]." ".$user_id_user["User"]["last_name"].'</span>';
                         
                          if($judgement_status == 'shortlisted')
                          {
                               $html.='<div class="col-md-12">
                                  <a href="javascript:void(0);"  data-id ="hindsight-'.$output['Judge']['id'].'" class ="winner nominated grand ">Select Grand Winner</a>
                                  <a href="javascript:void(0);" id = "shortlist-tab" data-id ="hindsight-'.$output['Judge']['id'].'" class ="update-rejected-status rejected ">Reject</a>
                                 
                              </div>';
                      
                          }
                          

                                  $html.='</div>
                              </div>';
                     }
                          $html.='</div></div></div>';
                        }else
                        {
                           $html.='No records found.';
                        }
        }
        else
        {
            
            if( $judgement_status=='pending')
            {
                $judgementstatus ='0';
            }

             
            

              $pending_res = $this->Judge->getAllChallengeByStatus($challenge_id, $decision_type_id,$judgementstatus);
             
             
             // $this->set('pending_res',$pending_res);

            

               $html.='<ul class="nav nav-tabs tabs  setting-tab"><li class="active">
               <a href="#pending" onclick = "getChallengeByStatus(\'pending\','.$challenge_id.')" data-toggle="tab">Pending ('.$pending_count.')</a></li>';
           
           $html.='<li><a href="#rejected" onclick = "getChallengeByStatus(\'rejected\','.$challenge_id.')" data-toggle="tab">Rejected ('.$rejected_count.')</a></li>' ;             
                      
           $html.='<li><a href="#short-listed"  onclick = "getChallengeByStatus(\'shortlisted\','.$challenge_id.')" data-toggle="tab">Short-listed ('. $short_count.')</a></li>';
           $html.='<li><a href="#winner" onclick = "getChallengeByStatus(\'nominated\','.$challenge_id.')"data-toggle="tab">Nominated</a></li>';
          $html.='</ul><div class="tab-content"><div class="tab-pane active" id="'.$judgement_status.'">
                          <div>'; 
               if(!empty($pending_res )){ 
          foreach($pending_res as $output){ 

             $categorytype = $this->Category->find('first',array('conditions'=>array('id'=>$output['Judge']['category_id'])));


             $hindsight_id = $output['Judge']['id'];
                $comment_count = $this->Comment->find('count',array('conditions'=>array('hindsight_id'=>$output['Judge']['id'],'rating <>'=>'')));
               if($comment_count)
               {
                  $get_comment_sum = $this->Comment->query("SELECT sum(rating) as total FROM comments WHERE hindsight_id = $hindsight_id AND rating!='' ");
                   $get_comment_sum[0][0]['total'];
                  $average_rating = round(($get_comment_sum[0][0]['total']/$comment_count),1);
                 
                }
                else{
                     $average_rating = 0;
                    }
           $html.='<div class="judge-challenge-div  clearfix ">
                                  <div class="col-md-9 judge-tab-sidebar">
                                      <h2>'.$output['Judge']['hindsight_title']." ".$output['Judge']['id'].'</h2>';
        
                   $html.='<h6>'.$categorytype["Category"]["category_name"].'</h6>                    
                 <p align="justify">'.$this->text_cut($output['Judge']['short_description'], $length = 200, $dots = true).'</p>';
           $html.='<span><strong>Rating:</strong>'.$average_rating.'</span>
                <a href="'.$siteUrl.'Judges/hindsight_detail/'.$output['Judge']['id'].'" class="right">View Details</a>
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
                  //  echo $this->Html->image('avatar.jpg');
                  $html.='<span>'.$user_id_user["User"]["first_name"]." ".$user_id_user["User"]["last_name"].'</span>';
                          if( $judgement_status=='pending')
                          {
                              $html.='<div class="col-md-12">
                                  <a href="javascript:void(0);" data-id ="hindsight-'.$output['Judge']['id'].'" class ="update-status shortlisted ">Short-List</a>
                                  <a href="javascript:void(0);" data-id ="hindsight-'.$output['Judge']['id'].'" class ="update-rejected-status rejected ">Reject</a>
                                 
                              </div>';
                          }
                          else if($judgement_status=='rejected')
                          {
                            $html.='<div class="col-md-12">
                                  <a href="javascript:void(0);" id = "rejected-pane" data-id ="hindsight-'.$output['Judge']['id'].'" class ="update-status shortlisted ">Short-List</a>
                                  <a href="javascript:void(0);" data-id ="hindsight-'.$output['Judge']['id'].'" class ="update-reconsider-status pending ">Reconsider</a>
                                 
                              </div>';
                          }
                          else if($judgement_status == 'shortlisted')
                          {
                               $html.='<div class="col-md-12">
                                  <a href="javascript:void(0);"  data-id ="hindsight-'.$output['Judge']['id'].'" class ="winner nominated ">Select Winner</a>
                                  <a href="javascript:void(0);" id = "shortlist-tab" data-id ="hindsight-'.$output['Judge']['id'].'" class ="update-rejected-status rejected ">Reject</a>
                                 
                              </div>';
                      
                          }
                          

                                  $html.='</div>
                              </div>';
                     }
                          $html.='</div></div></div>';}   
                          else{
                            $html.='No records found.';
                          } 
          }
           
        echo $html;
        exit();

    }
    public function hindsight_detail($hindsight_id=null)
    {
        $this->layout = 'judge_default';
        $res = $this->Judge->getHindsightDetail($hindsight_id);
        if(!empty($res))
        {

         $this->set('hindsightsdetail',$this->Judge->getHindsightDetail($hindsight_id));
    
          $output = $this->Judge->getHindsightById($hindsight_id);
      //   pr($output);

       
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
    public function updateHindsightStatus()
    {
      $hindsight_id = $this->request->data('hindsight_id');
      $judgement_status = $this->request->data('judgementstatus');
      $decision_type_id= $this->request->data('decision_type_id');
      $challenge_id = $this->request->data('challenge_id');


      if( $judgement_status =='pending')
      {
        $judgementstatus = '0';
      }
      else if($judgement_status =='rejected')
      {
        $judgementstatus = '1';
      }
       else if($judgement_status =='shortlisted')
      {
       

        if( $decision_type_id =='Grand Winner')
        {
                $judgementstatus ='3'; 
           
        }
        else
        {
           $judgementstatus = '2';
        }
      }
      else if($judgement_status =='nominated')
      {
         if( $decision_type_id =='Grand Winner')
        {
                $judgementstatus ='1'; 
           
        }
        else
        {
           $judgementstatus = '3';
        }
      }
      $update_time = date('Y-m-d H:i:s');
     
        if( $decision_type_id =='Grand Winner')
        {
           if($judgement_status =='rejected')
           {
               $status = array('judgement_status'=>$judgementstatus,'hindsight_update_date'=>"'$update_time'");
               $res = $this->Hindsight->updateAll($status,array('Hindsight.id'=>$hindsight_id));
           }
           else
           {
              $status = array('grand_winner_status'=>$judgementstatus,'hindsight_update_date'=>"'$update_time'");
              $res = $this->Hindsight->updateAll($status,array('Hindsight.id'=>$hindsight_id));
              if($res)
              {
                  $data = array('challenge_status'=>'2');
                  $result = $this->Challenge->updateAll($data,array('Challenge.id'=>$challenge_id));
              }
           }
              
        }
        else
        {
           $status = array('judgement_status'=>$judgementstatus,'hindsight_update_date'=>"'$update_time'");
            $res = $this->Hindsight->updateAll($status,array('Hindsight.id'=>$hindsight_id));
        }
       if($res)
      {
        echo "success";
      }
      
      exit();
    }

    //record the status of acceptance and reject challenge by judge 
    public function updateChallengeStatusByJudge()
    {
        //$this->request->data('action');
    
         if(strtoupper($this->request->data('action'))==strtoupper('Accept'))
        {
              $data = array('invitation_status'=>1);
            if($this->request->data('type')=='challenge_judges')
            {
              //update data into challenge_judges table
              
               $res = $this->ChallengeJudge->updateAll($data,array('ChallengeJudge.id'=>$this->request->data('challenge_id')));

               $getid = $this->ChallengeJudge->find('first',array('conditions'=>array('ChallengeJudge.id'=>$this->request->data('challenge_id'))));
               $id = $getid['ChallengeJudge']['challenge_id'];

   
           }
           else
            {
              $res = $this->ChallengeJudgeGrandWinner->updateAll($data,array('ChallengeJudgeGrandWinner.id'=>$this->request->data('challenge_id')));
             
                         // pr($res);
               $getid = $this->ChallengeJudgeGrandWinner->find('first',array('conditions'=>array('ChallengeJudgeGrandWinner.id'=>$this->request->data('challenge_id'))));
               $id = $getid['ChallengeJudgeGrandWinner']['challenge_id'];
          }
         }
        else
         {
              $data = array('invitation_status'=>2);
            if($this->request->data('type')=='challenge_judges')
            {
               //update data into challenge_judges table
              
            $res = $this->ChallengeJudge->updateAll($data,array('ChallengeJudge.id'=>$this->request->data('challenge_id')));
            $id ='1';
        
            }
             else
             {
               $res = $this->ChallengeJudgeGrandWinner->updateAll($data,array('ChallengeJudgeGrandWinner.id'=>$this->request->data('challenge_id')));
                $id ='1';
            }
        }
      
         if($res)
         {
           echo $id;
         } 
        exit();
    }

     public function text_cut($text, $length = 200, $dots = true) {
    $text = trim(preg_replace('#[\s\n\r\t]{2,}#', ' ', $text));
    $text_temp = $text;
    while (substr($text, $length, 1) != " ") { $length++; if ($length > strlen($text)) { break; } }
    $text = substr($text, 0, $length);
    return $text . ( ( $dots == true && $text != '' && strlen($text_temp) > $length ) ? '...' : ''); 
}

}
