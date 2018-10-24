<div class="col-md-10 content-wraaper">
    <div class="new-dashboard">
        <div class="row">
            <div class="col-md-9 border-right">
                <div class="new-dashboard-left-panel">
                    <div class="row prfile-detail-wrap">
                        <div class="col-md-3">
                            <div class="relative">
                                <div class="select-img">  
                                        <?php  


                                         $context_ary = $this->Session->read('context-array');

                                          if($avatar != ''){
                                                                                 ?>   
                                                     <img src="<?php echo $this->Html->url('/'). $this->Image->resize($avatar,128, 128, true);?>" alt="" class="img-thumbnail user-avatar-select "/>
                                                   <?php }
                                                   else{?>
                                                      <img src="<?php echo $this->Html->url('/'). $this->Image->resize('img/dummy-pic.png',128, 128, true);?>" alt="" class="img-thumbnail user-avatar-select "/>
                                                  
                                                 <?php   } ?>                        
                                  
                                </div>
                                 
                             </div>
                        </div>
                        <div class="col-md-9">
                            <div class="seeker-dash">
                                <div class="citizen-title">
                                <?php //echo $this->Hindsight->numPublishedHindsight($this->Session->read('user_id'), 'week');
                                      //echo $this->Hindsight->numPublishedHindsight($this->Session->read('user_id'), 'month');?>
                                     <span><?php echo $this->Session->read('user_name');?><?php  echo $this->Html->image('seeker-icon.png')?></span>
                                  <div>  <?php //pr($user_info);
                                       echo @$user_info['UserProfile']['designation'];?></div>
                                   
                                   <span class="locater">   <?php if(@$countryName['Country']['country_title']){?> <i class="fa fa-map-marker"></i>  <?php if(@$user_info['UserProfile']['city']){ echo @$user_info['UserProfile']['city'].", ".@$countryName['Country']['country_title'];} }?></span>

                                </div>
                                <div class="citizen-title">
                                    <!-- <span class="category-type">Pioneer (<?php echo  $role;?>)</span>
                                    <span class="category-type">Starter Score</span> -->
                                    <div class="social-nav">
                                      <ul>
                                     
                                        <?php if(@$user_info['User']['twitter_followers']){?>
                                         <li><a href="<?php echo $user_info['User']['twitter_followers'];?>" target = "_blank">Twitter</a></li>
                                         <?php }   ?>

                                          <?php if(@$user_info['User']['facebook_network']){?>
                                         <li><a href="<?php echo $user_info['User']['facebook_network'];?>" target = "_blank">Facebook</a></li>
                                         <?php }   ?>
                                      <!--   <li><a href="#">Facebook</a></li> -->
                                        <?php if(@$user_info['User']['linkedin_network']){?>
                                         <li><a href="<?php echo $user_info['User']['linkedin_network'];?>" target = "_blank">
                                          LinkedIn</a></li>
                                         <?php }   ?>
                                        <?php if(@$user_info['User']['other_url']){?>
                                        <li><a href="<?php echo $user_info['User']['other_url'];?>" target = "_blank">Website</a></li>
                                         <?php }   ?>
                                       
                                        
                                      </ul>
                                    </div>
                                </div>
                            </div>                           
                        </div>
                    </div>
                    <div class="biography new-dashboard-wrap seeker-dash sage-biography">
                         <h3>Biography</h3> 

               <?php 
                
if(@$user_info['UserProfile']['short_bio'] ){
  echo @$user_info['UserProfile']['short_bio'] ;
}
               else{ ?>
                           <p>  Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.
                    </p>
                         <p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham. </p>    
                         <?php }  ?> 
                    </div>

                   <?php
                    echo $this->element('my_hindsight_element');
             
                    ?>

                </div>                
            </div>
            <div class="col-md-3">
                <div class="my-advice new-dashboard-right-panel seeker-dash">                
                     <div class="new-dashboard-side-wrap">
                        <!-- <h3>Badges</h3> -->
                        <div class="row">
                            <div class="col-md-4">
                               <?php  //echo $this->Html->image('Hydrangeas.jpg',array('class'=>'img-round'))?>
                                <!-- <img src="/entropolis/img/Hydrangeas.jpg" alt="" class="img-round"> -->
                            </div>
                            <div class="col-md-4">
                                <?php //echo $this->Html->image('Chrysanthemum.jpg',array('class'=>'img-round'))?>
                            <!--     <img src="/entropolis/img/Chrysanthemum.jpg" alt="" class="img-round"> -->
                            </div>
                            <div class="col-md-4"></div>
                        </div>
                    </div> 
                    <div class="new-dashboard-side-wrap manage-space">
                        <div class="row">
                            <div class="col-md-6">
                              <div class="seeker-orange">
                                <h3>Total Hindsight</h3>
                                 <span class= "total-count"><?php if(!empty($hindsightdata)){ echo $this->Rating->totalDataCount($hindsightdata[0]['DecisionBank']['context_role_user_id'],'Hindsight');}else{echo '0';} ?></span>
                               <!--  <span><?php if(!empty($total_advice_count)){ echo $total_advice_count; }?></span> -->
                              </div>
                                <!-- <h3>Health</h3> -->
                                
                                  <?php  //echo $this->Html->image('heath.png')?>
                               
                            </div>
                            <div class="col-md-6 right">
                              <div class="seeker-grey">
                                <h3>Profile Rating</h3>
                                  <span class='average-rating'><?php if(!empty($hindsightdata)){  echo $this->Rating->getHindsightAverageRating($hindsightdata[0]['ContextRoleUser']['id']); ?>/10<?php }else{ echo '0/10';} ?> </span>
                              
                              </div>
                                <!-- <h3>Pollution</h3> -->
                                
                                  <?php  //echo $this->Html->image('populations.png')?>
                            
                            </div>
                        </div>  
                        <div class="row">
                          <div class="seeker-badges">
                            <div class="col-md-12">
                              <p class="feeds-brdr">Badges Earned</p>
                              <?php  echo $this->Html->image('icon5.png')?> <?php  echo $this->Html->image('seeker-icon.png')?>
                            </div>
                            
                          </div>
                        </div> 

                        <div class="row">
                          <div class="seeker-badges">
                            <div class="col-md-12">
                              <p class="feeds-brdr">Feeds</p>
                              <table class="table table-txtcolor">
                                  <tbody>
                                      <tr class="grey-badges">
                                          <td>My|Hindsight</td>
                                         <td class= "total-count"><?php if(!empty($hindsightdata)){ echo $this->Rating->totalDataCount($hindsightdata[0]['DecisionBank']['context_role_user_id'],'Hindsight');}else{echo '0';} ?></td>
                                      </tr>
                                      <tr>
                                          <td>Invites</td>
                                          <td>
                                        <?php $newInvitation =  count($this->User->newInvitationList($this->Session->read('user_id')));
                                              if($newInvitation > 0){ ?>
                                                  <a href="<?php echo Router::url(array('controller'=>'decisionBanks', 'action'=>'new_invitation'));?>"> <?php echo $newInvitation;?></a>
                                              <?php 
                                              }
                                              else{
                                                  echo $newInvitation;
                                              }
                                              ?>
                                          </td>
                                      </tr>
                                      <tr>
                                          <td>Comments</td>
                                         <td class= "total-comment"><?php if(!empty($hindsightdata)){ echo $this->Rating->totalCommentCount($hindsightdata[0]['DecisionBank']['context_role_user_id'],'Hindsight');}else{echo '0';} ?></td>
                                      </tr>
                                      <tr>
                                          <td>Questions</td>
                                          <td>0</td>
                                      </tr>
                                  </tbody>
                              </table>

<!-------------------Start My Network section ---------------------------- -->
                              <div class="">
                                  <div class="grey-badges" style="padding: 8px"> My Network</div>
                             
                                  <ul> 
                             <?php $invList =  $this->User->invitationList($this->Session->read('user_id'));
                                   foreach($invList as $key=>$invitation){
                                       if($invitation['Invitation']['invitee_user_id'] == $this->Session->read('user_id')){ 
                                           if($invitation['Invitation']['invitation_status'] == 1){
                                              
                                           ?>
                                      <li class="invitation-wrapper-">
                                          <span class="user-name" style="color:#000000"><?php echo ucfirst($invitation['User']['first_name']).' '. ucfirst($invitation['User']['last_name']);?></span> 
                                      </li>
                                     <?php }                                        
                                       }   
                                       else{ 
                                           if($invitation['Invitation']['invitation_status'] == 1){
                                           ?>
                                               <li class="invitation-wrapper">
                                                   <span class="user-name" style="color:#000000"><?php echo ucfirst($invitation['InviteeUser']['first_name']).' '. ucfirst($invitation['InviteeUser']['last_name']);?> </span>
                                               </li>
                                       <?php
                                           }
                                       }
                                   } 
                                  ?>    
                                      
                                  </ul>
                              </div>
 <!-------------------Start My Network section -------------------------- --> 

                            </div>
                            
                          </div>
                        </div>     
                    </div>
                    <!-- <div class="new-dashboard-side-wrap">
                        <h3>Notification</h3>
                        <div class="new-dashboard-side-panel align-center">
                            <a href="#">
                                <?php  //echo $this->Html->image('chat.png')?>
                                
                            </a>
                            <div class="">
                                <span class="orange">9</span> 
                                <span class="purpel">49</span>
                            </div>                                                                      
                           
                        </div>
                        <div class="new-dashboard-side-panel align-center">
                            <a href="#">
                                 <?php  //echo $this->Html->image('star.png')?>
                              
                            </a>
                            <div class="">
                                <span class="orange">5</span> 
                                <span class="purpel">28</span>
                            </div>
                        </div>
                        <div class="new-dashboard-side-panel align-center">
                            <a href="#">
                                 <?php  //echo $this->Html->image('group.png')?>
                             
                            </a>
                            <div class="">
                                <span class="orange">23</span> 
                                <span class="purpel">110</span>
                            </div>
                                                                      
                           
                        </div>
                    </div>
 -->                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="hindsight" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog hindsight-model">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">My Decision|Bank</h4>
            </div>
            <div class="modal-body">
                <div id="container-scroll">
                    <ul class="nav nav-tabs tabs" role="tablist">
                        <li class="active" id="addhindsight" ><a href="#add-hindsight" role="tab" data-toggle="tab" > Add Hindsight</a></li>
                        <li  id = "askquestion" ><a href="#ask-question" role="tab" data-toggle="tab">Ask|Entropolis</a></li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane active" id="add-hindsight">
                            <h3>Enter a New Hindsight</h3>
                            <!--<form role="form" action="">--> 
                            <div id="allError"></div>
                            <?php echo $this->Form->create('DecisionBank',array('id' => 'Userchallangeinfo')); ?>    
                            <div class="row">
                                <div class="col-md-12 hind-sights-form challenge-color" >
                                    <div class="form-group" >
                                        <?php echo $this->Form->input('hindsight_decision_date', array('type'=>'text','class'=>'form-control calender', 'id'=>"datepicker", 'placeholder'=>"When did you make this decision? Select a date", 'label'=>false,"autocomplete"=>"off"));?> 
                                    </div>
                                    <div class="form-group">
                                        <?php echo $this->Form->input('decision_type_id', array('options'=>$decision_types,'id'=>'decision_type_id', 'class'=>'form-control', 'label'=>false));?>      
                                    </div>
                                    <div class="form-group category" style= "display:none;">
                                        <?php echo $this->Form->input('category_id', array('options'=>array(''=>'Select Category'), 'id'=>'category_id','class'=>'form-control', 'label'=>false));?>  
                                    </div>
                                    <div class="form-group">
                                        <?php echo $this->Form->input('hindsight_title', array('class'=>'form-control', 'placeholder'=>"Decision Title", 'id'=>"hindsight_title", 'label'=>false));?> 
                                    </div>
                                    <div class="form-group">
                                        <?php echo $this->Form->input('short_description', array('class'=>'form-control rem_val','rows'=>3, 'placeholder'=>"Add a short description", 'label'=>false));?> 
                                    </div>
                                    <div class="form-group">
                                        <textarea name="data[DecisionBank][HindsightDetail][][hindsight_details]" class="form-control" rows="3" placeholder="Hindsight"></textarea> 
                                    </div>
                                    <div class="form-group hind-sights" style="display:none" >
                                        <textarea name="data[DecisionBank][HindsightDetail][][hindsight_details]" class="form-control" rows="3" placeholder="Hindsight"></textarea> 
                                        <span><?php echo $this->Html->image('delete.png', array('class'=>'close-hindsight'));?></span>
                                    </div>
                                    <div class="gg">            
                                    </div>
                                    <div class="form-group">
                                        <a  class="right add-more"><i class="fa fa-plus-circle"></i> Add More</a>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="form-group">
                                <?php echo $this->Form->submit('Submit', array('type'=>'button','class'=>'btn btn-black', 'div'=>false, 'data-toggle'=>"modal", 'data-target'=>"#submit-hindsight"));?>
                                <?php echo $this->Form->button('Cancel', array('type'=>'button','class'=>'btn btn-black', 'div'=>false, 'data-toggle'=>"modal", 'data-dismiss'=>"modal" ));?>
                            </div>
                            <?php echo $this->Form->end();?>
                        </div>
                    
                    <div class="tab-pane" id="ask-question">
                      <div class="">
                        <div class="">
                            <div class="challenge-color ">
                                <h3>START A DISCUSSION</h3>                                
                            </div>
                            <div class ='discission-data' style = "margin-bottom:10px;"></div>

                            <div id="challenge-display">
                                <div class="row">
                                    <div class="col-md-12 judge-challenge challenge-color">
                                        <div class="hind-sights-form " >
                                            
                                            <?php //echo $this->Session->Flash('discussion-form');?>
                                            <?php echo $this->Form->create('Discussion', array('url'=>'/decisionBanks/index','id'=>"discussion-form-data"));?>      
                                            <div class="form-group">
                                                <?php echo $this->Form->input('category_id', array('options'=>$decisiontypes,'id'=>'decision_type', 'class'=>'form-control', 'label'=>false));?>
                                                
                                            </div>
                                            <div class="form-group category_data" style = "display:none;">
                                                
                                                <?php echo $this->Form->input('sub_category_id', array('options'=>array(''=>'Decision Sub-Category'), 'id'=>'categoryid','class'=>'form-control', 'label'=>false));?>  
                                            </div>
                                            <div class="form-group" style="float:left; margin-top: 12px; width: 100%">
                                                <?php echo $this->Form->input('question_title', array('id'=>'question_title','class'=>'form-control', 'placeholder'=>'Question Title', 'label'=>false,'maxlength'=>'500'));?>  
                                            </div>
                                            <div class="form-group" style="float:left;  width: 100%">
                                                <?php echo $this->Form->textarea('description', array('id'=>'description', 'placeholder'=>'How can we help?', 'class'=>'form-control', 'rows'=>'6', 'label'=>false ,'maxlength'=>'1000'));?>  
                                            </div>
                                            <div class="form-group  my_challenge" style="float:left; margin-top: 12px; width: 100%">
                                           
                                                <?php echo $this->Form->submit('Send', array('class'=>'btn btn-black add-discussion' ,'div'=>false,) );?>
                                                  <?php echo $this->Form->button('Cancel', array('type'=>'button','class'=>'btn btn-black', 'div'=>false, 'data-toggle'=>"modal", 'data-dismiss'=>"modal" ));?>

                                            </div>
                                            <?php echo $this->Form->end();?>                 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                      </div>
                        <script type="text/javascript">

                            $('body').on('change','#decision_type' , function(){
                                jQuery(".category_data").show();
                            $.ajax({
                                url:'<?php echo Router::url(array('controller'=>'DecisionBanks', 'action'=>'discussion_category'));?>',
                                data:{
                                  id:this.value
                                },
                                type:'get',
                                success:function(data){ 
                                    $('#categoryid').html(data);
                                }
                                
                            });
                            });
                        </script>  
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="submit-hindsight" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header challenge-color">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">Submit Hindsight</h4>
            </div>
            <div class="modal-body">
                Are you sure you want to submit this?
            </div>
            <div class="modal-footer model-footer1 my_challenge">
                <button type="button" class="btn  btn-black" id="submitHindsightFrm" data-dismiss="modal">Yes</button>
                <button type="button" class="btn btn-black" data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="discussion-submit" tabindex="-1"  style="top:20%;" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header challenge-color">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">Success Message</h4>
            </div>
            <div class="modal-body">Thank you!! Your Question has been sent to Entropolis HQ and we will connect you with some great advice and hindsight wisdom shortly.  Why don't you also post your question to the e|scene and engage our citizens to assist in your decision making process.
            </div>
            <div class="modal-footer model-footer1 my_challenge">
                <button type="button" class="btn  btn-black" id="question-data" data-dismiss="modal">Post to E|Scene</button>
                <button type="button" class="btn btn-black" data-dismiss="modal" onclick= "window.location.reload();">No Thanks</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="escene-message" tabindex="-1"  style="top:20%;" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header challenge-color">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">Success Message</h4>
            </div>
            <div class="modal-body">Thank you!! Your Question has been successfully posted to Entropolis E|Scene Wall.
            </div>
            <div class="modal-footer model-footer1 my_challenge">
               
                <button type="button" class="btn btn-black" data-dismiss="modal" onclick = "window.location.reload();">OK</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

$('body').on('change','#decision_type_id' , function(){
            jQuery(".category").show();
            $.ajax({
                url:'<?php echo $this->webroot ?>challengers/decision_category/',
                data:{
                    id:this.value
                },
                type:'get',
                success:function(data){ 
                    $('#category_id').html(data);
                }
        
            });
        });
  
$('#submitHindsightFrm').click( function(e){ 
          e.preventDefault();
          var datas=$('#Userchallangeinfo').serialize();
          //alert("dsd");
        
          $.ajax({
           url:'<?php echo $this->webroot?>DecisionBanks/add_ajax/',
           data:datas,
           type:'POST',
           success:function(data){ 
          //  alert(data);

               if(data.result=="error")
               {
                   $("#category_id").nextAll().remove();
                   $("#decision_type_id").nextAll().remove();
                   $("#datepicker").nextAll().remove();
                   $("#hindsight_title").nextAll().remove();
                   
                   if(data.error_msg.hindsight_decision_date !== undefined && data.error_msg.hindsight_decision_date[0]!=''){
                       $("#datepicker").after('<div class="error-message">'+data.error_msg.hindsight_decision_date[0]+'</span>');
                   }
                   if(data.error_msg.category_id !== undefined && data.error_msg.category_id[0]!=''){
                       $("#category_id").after('<div class="error-message">'+data.error_msg.category_id[0]+'</span>');
                   }
                   if(data.error_msg.decision_type_id !== undefined && data.error_msg.decision_type_id[0]!=''){
                       $("#decision_type_id").after('<div class="error-message">'+data.error_msg.decision_type_id[0]+'</div>');
                   }
                   if(data.error_msg.hindsight_title !== undefined && data.error_msg.hindsight_title[0]!=''){
                       $("#hindsight_title").after('<div class="error-message">'+data.error_msg.hindsight_title[0]+'</div>');
                   }
               }    
               else
               { 
    
                 
                  
                   $("#category_id").nextAll().remove();
                   $("#decision_type_id").nextAll().remove();
                   $("#datepicker").nextAll().remove();
                   $("#hindsight_title").nextAll().remove();
                   $("#Userchallangeinfo").get(0).reset();
                   $("#hindsight").modal('hide');
                   window.location="<?php echo Router::url(array('controller' => 'decisionBanks', 'action' => 'dashboard')) ?>";
                  // getListData(data.decision_data.name, data.decision_data.id, 'tab', 0);
                   //window.location.reload(true);
                  
                  
               } 
           }
           
       });
           
    });



$(document).ready(function () {
  $('body').on('click','.check-hindsight',function(){
       var showThis = 0;
       $('.check-hindsight').each(function(){
           $this = $(this);
           if($this.is(':checked', true)){

          

               showThis = 1;
               return false;
           }
           else{
               showThis = 0;
           }


       });

            var total_length = $('.check-hindsight').length;
            var total_checked_length = $('.check-hindsight:checked').length;

            if (total_length == total_checked_length) {
                $(".check_all").prop( "checked", true );
            } 
       
       if(showThis == 1){
           $('.delete-hindsight').prop('disabled', false).css({opacity:'1'});
       }
       else{
           $('.delete-hindsight').prop('disabled', true).css({opacity:'0.2'});
           $(".check_all").prop( "checked", false );
       }
       
   });


 $('body').on('click','.delete-hindsight',function(){
     
    bootbox.dialog({
            title: "Confirm Deletion",
            message: "Are you sure you want to delete ?",            
            buttons: {
                success: {
                    label: "Yes",
                    className: "btn-black",
                    callback: function() {
   
             $('.loading').show();  
             var data_val = '';
             $('.check-hindsight').each(function(){ 
                 $this = $(this);
                 if($this.is(':checked', true)){
                if( data_val ==''){
                  data_val = $this.val();
                }else{
                   data_val = data_val+"~"+ $this.val();
                }
                 }
                 
              });

              jQuery.ajax({
                 url:'<?php echo $this->webroot?>decisionBanks/deleteHindsight/',
                 data:{
                  
                 'data_val':data_val,
                 
                 },
                 type:'POST',
                 success:function(data){
                  $('.loading').hide();  
                  $('.check-hindsight').each(function(){ 
                    $this = $(this);
                    if($this.is(':checked', true)){
                     $this.closest('tr').remove();
                    
                      var temp = data.split('~');
                     jQuery(".total-count").text(temp[0]);
                     jQuery(".average-rating").text(temp[1]+"/10");
                      jQuery(".total-comment").text(temp[2]);
                    }
                  });               
                 
                      $('.check_all').prop( "checked", false );
                     $('.delete-hindsight').prop('disabled', true).css({opacity:'0.2'});
                 }
               });
     
     
           }
                },
                danger: {
                    label: "No",
                    className: "btn-black"                   
                }
               
            }
        });

 });

   $('body').on('click','.check_all',function(){
      $this = $(this);

              if($this.is(':checked', true)){
                $('.check-hindsight').prop( "checked", true );
                 $('.delete-hindsight').prop('disabled', false).css({opacity:'1'});
           
           }else{
              $('.check-hindsight').prop( "checked", false );
                $('.delete-hindsight').prop('disabled', true).css({opacity:'0.2'});
           }

           // $('.check-hindsight').trigger('click');
      

   });



    $('.add-discussion').click( function(e){ 
          e.preventDefault();
          var datas=$('#discussion-form-data').serialize();
          
          $.ajax({
           url:'<?php echo $this->webroot?>decisionBanks/discussion/',
           data:datas,
           type:'POST',
           success:function(data){ 
         
               if(data.result=="error")
               {
                   $("#decision_type").nextAll().remove();
                   $("#categoryid").nextAll().remove();
                   $("#question_title").nextAll().remove();
                   $("#description").nextAll().remove();
                   
                   if(data.error_msg.category_id !== undefined && data.error_msg.category_id[0]!=''){
                       $("#decision_type").after('<div class="error-message">'+data.error_msg.category_id[0]+'</span>');
                   }
                   if(data.error_msg.sub_category_id !== undefined && data.error_msg.sub_category_id[0]!=''){
                       $("#categoryid").after('<div class="error-message">'+data.error_msg.sub_category_id[0]+'</span>');
                   }
                   if(data.error_msg.question_title !== undefined && data.error_msg.question_title[0]!=''){
                       $("#question_title").after('<div class="error-message">'+data.error_msg.question_title[0]+'</div>');
                   }
                   if(data.error_msg.description !== undefined && data.error_msg.description[0]!=''){
                       $("#description").after('<div class="error-message">'+data.error_msg.description[0]+'</div>');
                   }
               }    
               else
               { 
                   
                   jQuery("#discussion-submit").modal('show');
                   jQuery("#question-data").data("id",data.msg);
                   // jQuery(".discission-data").html('<div id="discussion-formMessage" class="alert-success session-alert">Added successfully.</div>')

                //window.location = "decisionBanks/index";
                  
               } 
           }
           
       });
           
    });



    jQuery("body").on('click','#question-data',function(){
    var obj = $(this);
    discussion_id = obj.data("id");
  
     jQuery.ajax({
           url:'<?php echo $this->webroot?>Escenes/postQuestionOnEsceneWall/',
           data:{
             'discussion_id':discussion_id 
           },
           type:'POST',
           success:function(data){
              jQuery("#hindsight").modal('hide');
            window.location = "<?php echo $this->webroot?>escenes";
           }
       });
});



     jQuery('body').on('click',".load-more-hindsight",function(e){
        e.preventDefault();
      $this = $(this);
      var data_count =  $this.data("count");
      var start_limit = $this.data("startlimit");
      //var type = $this.data("type");
     var totalshow = $this.data("totalshow");
    
      if(data_count>=totalshow)
      {
         var end_limit = totalshow;
         
      }
      else if(data_count<totalshow )
      {
        var end_limit = data_count;
      }
    
     var remaining_count = data_count - end_limit;
     var start_limit = start_limit+totalshow;
     $('.page-loading').show(); 
      jQuery.ajax({
        type:"post",
           url:'<?php echo $this->webroot?>decisionBanks/loadMoreHindsight/',
        // url:'<?php echo Router::url(array('controller'=>'escenes', 'action'=>'loadMoreOfficialPost'));?>',
        data:
        {
          'start_limit':start_limit,
          'end_limit':end_limit
        
        },
        success:function(data)
        {
           // alert(data);
            $('.page-loading').hide();
     
          
          $this.data("startlimit",start_limit);
          $this.data("count",remaining_count);
    
           $(".my_challenge >tbody").append(data);
          if(remaining_count=='0')
          {
            $this.hide();
          }
    
        },
    
      });
    
    });


});

</script>