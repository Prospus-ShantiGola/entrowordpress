
<?php

class JudgeHelper extends AppHelper{
    var $helpers = array('Html');
    
    // public function classCombo($classId =0){
       
    //     App::import("Model", "Classguide");
    //     $guide = new Classguide();
    //     $classLst = $guide->getClassList();
    //     $result = array();
    //     foreach($classLst as $key=>$class){
    //         $result[] = $class['Classguide'];
    //     }
    //     $classHtml = '';
    //     foreach($result as $key=>$datas){
    //         $classHtml .= '<option value="'.$datas['preferred_class_id'].'" ';
	   //  $classHtml .=  $classId==$datas['preferred_class_id'] ? "selected='selected'" : '';
	   //  $classHtml .=  '> Class '.$datas['class_name'].'</option>';	
    //     }
    //     return $classHtml;
    // }

     public function getJudgeStatus($challenge_id,$decision_type_id, $decision_type)
    {
       // echo "hel".$decision_type_id."hgh";
        App::import("Model", "Challenge");
        $challenge_obj = new Challenge();
       
        $result = $challenge_obj->getJudgeStatusOnChallenge($challenge_id,$decision_type_id);
       
        if($result)
        {

             $context_role_user_id = $result['Challenge']['context_role_user_id'];
          
            $user_res = $challenge_obj->getJudgeName($context_role_user_id);
            foreach($user_res as $user_val){

            }

           if($result['Challenge']['challenge_status']=='2')
           {?>


            <div class="form-group border-none">
                <label class="col-sm-5 control-label"><?php echo $decision_type; ?></label>
                <div class="col-sm-7">
                    <div class="control-value">
                        <span class="selected-judge-name">
                            <?php  echo $this->Html->link($user_val['u']['first_name']." ".$user_val['u']['last_name'],array('controller'=>'Challenges','action'=>'judgeProfile',$user_val['u']['id'],$challenge_id));?>
                                                   
                        </span>
                        
                    </div>
                </div>
            </div>

           <?php }else
           {
          
  ?> 

            <div class="form-group border-none">
                <label class="col-sm-5 control-label"><?php echo $decision_type; ?></label>
                <div class="col-sm-5">
                    <div class="control-value">
                        <span class="selected-judge-name">
                            <?php  echo $this->Html->link($user_val['u']['first_name']." ".$user_val['u']['last_name'],array('controller'=>'Challenges','action'=>'judgeProfile',$user_val['u']['id'],$challenge_id));?>
                              <?php if($result['Challenge']['invitation_status']!='1'){?>
                            <span class="delete judge-selection"  data-id= "decision_type-<?php echo $decision_type_id; ?>" data-toggle="modal" data-target="#select-judge"><i class="fa fa-pencil"></i></span>
                            <?php }?>
                        </span>
                        <?php if($result['Challenge']['invitation_status']=='1'){?>
                        <span class="judge-approval">
                            <?php  echo $this->Html->image('tick-green.png',array('alt'=>"approved", 'title'=>"Approved"));?>

                            </span>
                            <?php }?>
                    </div>
                </div>
            </div>


        <?php } }
        else
        {?>
            <div class="form-group">
                <label class="col-sm-5 control-label"><?php echo $decision_type; ?></label>
                <div class="col-sm-5">
                    <a href="#select-judge" data-id= "decision_type-<?php echo $decision_type_id; ?>"class="btn btn-orange-small judge-selection" data-toggle="modal">Select Judge</a>
                </div>
            </div>
        <?php }
        
    }

     public function chooseJudge($challenge_id,$decision_type_id, $decision_type)
    {
       // echo "hel".$decision_type_id."hgh";
        App::import("Model", "Challenge");
        $challenge_obj = new Challenge();
       
        $result = $challenge_obj->getJudgeStatusOnChallenge($challenge_id,$decision_type_id);
       
        if($result)
        {

             $context_role_user_id = $result['Challenge']['context_role_user_id'];
          
            $user_res = $challenge_obj->getJudgeName($context_role_user_id);
            foreach($user_res as $user_val){

            }

           if($result['Challenge']['challenge_status']=='2')
           {?>


            <div class="form-group border-none">
                <label class="col-sm-5 control-label"><?php echo $decision_type; ?></label>
                <div class="col-sm-7">
                    <div class="control-value">
                        <span class="selected-judge-name">
                        
                              <span><?php echo $user_val['u']['first_name']." ".$user_val['u']['last_name'];?></span>                      
                        </span>
                        
                    </div>
                </div>
            </div>

           <?php }else
           {
          
  ?> 

            <div class="form-group border-none">
                <label class="col-sm-5 control-label"><?php echo $decision_type; ?></label>
                <div class="col-sm-5">
                    <div class="control-value">
                        <span class="selected-judge-name">
                         
                             <span><?php echo $user_val['u']['first_name']." ".$user_val['u']['last_name'];?></span>
                              <?php if($result['Challenge']['invitation_status']!='1'){?>
                            <span class="delete judge-selection"  data-id= "decision_type-<?php echo $decision_type_id; ?>" data-toggle="modal" data-target="#select-judge"><i class="fa fa-pencil"></i></span>
                            <?php }?>
                        </span>
                        <?php if($result['Challenge']['invitation_status']=='1'){?>
                        <span class="judge-approval">
                            <?php  echo $this->Html->image('tick-green.png',array('alt'=>"approved", 'title'=>"Approved"));?>

                            </span>
                            <?php }?>
                    </div>
                </div>
            </div>


        <?php } }
        else
        {?>
            <div class="form-group">
                <label class="col-sm-5 control-label"><?php echo $decision_type; ?></label>
                <div class="col-sm-5">
                    <a href="#select-judge" data-id= "decision_type-<?php echo $decision_type_id; ?>"class="btn btn-orange-small judge-selection" data-toggle="modal">Select Judge</a>
                </div>
            </div>
        <?php }
        
    }


    
}
?>