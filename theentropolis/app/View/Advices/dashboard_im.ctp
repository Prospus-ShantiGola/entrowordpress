<!-- <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-53c383bb6244e3e5"></script> -->
 <div class="page-loading" style="color:red"><?php echo $this->Html->image('loading-upload.gif');?></div>
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
                                                    <!-- <img src="/entropolis/upload/avatar-male-1.png" class="img-thumbnail user-avatar-select "> -->
                                                 <?php   } ?>                        
                                  <!--  <img src="/entropolis/upload/avatar-male-1.png" class="img-thumbnail user-avatar-select "> -->
                                   <!--  <span class="upload-img">
                                        <span class="choose-file">Choose File</span>
                                        <input type="file" class="new-dashboard-upload-img">
                                    </span> -->
                                </div>
                                 
                             </div>
                        </div>
                        <div class="col-md-9">
                            <div class="seeker-dash">
                                <div class="citizen-title">
                                <?php //echo $this->Hindsight->numPublishedHindsight($this->Session->read('user_id'), 'week');
                                      //echo $this->Hindsight->numPublishedHindsight($this->Session->read('user_id'), 'month');?>

                                    <span><?php echo $this->Session->read('user_name');?> <?php  echo $this->Html->image('sage-icon1.svg')?></span>
                                  
                                      <div>  <?php //pr($user_info);
                                       echo @$user_info['UserProfile']['designation'];?></div>
                                    
                                    <span class="locater">   <?php if(@$countryName['Country']['country_title']){?> <i class="fa fa-map-marker"></i>  <?php if(@$user_info['UserProfile']['city']){ echo @$user_info['UserProfile']['city'].", ".@$countryName['Country']['country_title'];}else{
                                  echo @$countryName['Country']['country_title'];
                                } }?></span>
                                    
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
               

               if( @$user_info['UserProfile']['short_bio'] ) 
                {echo @$user_info['UserProfile']['short_bio'];

               }else{ ?>
                       <p>  Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.
                    </p>
                         <p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham. </p>    
                         <?php }  ?> 
                    </div>

                   <?php
                    echo $this->element('my_advice_element');
             
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
                                <h3>Total Advice</h3>
                                <span class ="total-count"><?php if(!empty($advicedata)){ echo $this->Rating->totalDataCount($advicedata[0]['Advice']['context_role_user_id'],'Advice');}else{echo '0';} ?></span>
                              </div>
                                <!-- <h3>Health</h3> -->
                                
                                  <?php  //echo $this->Html->image('heath.png')?>
                               
                            </div>
                            <div class="col-md-6 right">
                              <div class="seeker-grey">
                                <h3>Profile Rating</h3>
                                <span class='average-rating'><?php if(!empty($advicedata)){  echo $this->Rating->getRatingAllAdvice($advicedata[0]['ContextRoleUser']['id']); ?>/10<?php }else{ echo '0/10';} ?> </span>
                              </div>
                                <!-- <h3>Pollution</h3> -->
                                
                                  <?php  //echo $this->Html->image('populations.png')?>
                            
                            </div>
                        </div>  
                        <div class="row">
                          <div class="seeker-badges">
                            <div class="col-md-12">
                              <p class="feeds-brdr">Badges Earned</p>
                              <?php  echo $this->Html->image('icon5.png')?> <?php  echo $this->Html->image('sage-icon1.svg')?>
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
                                          <td>My|Advice</td>
                                         <td class = "total-count"><?php if(!empty($advicedata)){ echo $this->Rating->totalDataCount($advicedata[0]['Advice']['context_role_user_id'],'Advice');}else{echo '0';} ?></td>
                                      </tr>
                                      <tr>
                                          <td>Invites</td>
                                          <td>
                                              <?php $newInvitation =  count($this->User->newInvitationList($this->Session->read('user_id')));
                                              if($newInvitation > 0){ ?>
                                                  <a href="<?php echo Router::url(array('controller'=>'advices', 'action'=>'new_invitation'));?>"> <?php echo $newInvitation;?></a>
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
                                          <td class= "total-comment"><?php if(!empty($advicedata)){ echo $this->Rating->totalCommentCount($advicedata[0]['Advice']['context_role_user_id'],'Advice');}else{echo '0';} ?></td>
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


                  <!-- advice modal-->
                     <div class="modal fade" id="new-advice" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog hindsight-model">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="clearAll()"><i class="icons close-icon"></i></button>
                    <h4 class="modal-title" id="myModalLabel">Add Advice</h4>
                </div>

                <div class="modal-body">
                    <h3>Publish New Advice</h3>
                    <div id="error"></div>
<?php echo $this->Form->create('Advice', array('class' => 'margin-0x', 'id' => 'UserchallangeinfoProfileForm')); ?>
                    <input type="hidden" name="data[Advice][context_role_user_id]" value="<?php echo $this->Session->read('context_role_user_id'); ?>">
                    <div class="row">
                        <div class="col-md-6 hind-sights-form"> 
                            <!--                        <div class="form-group">
<?php //echo $this->Form->input('challenge_id', array('options'=>$challenges,'class'=>'form-control', 'id'=>'challenge_id', 'label'=>false)); ?>      
                                                 </div>-->
                            <div class="form-group">
<?php echo $this->Form->input('decision_type_id', array('options' => $decision_types, 'id' => 'decision_type_id', 'class' => 'form-control', 'label' => false, 'empty' => 'Type of Advice')); ?> 
                            </div>
                            <div class="form-group category" style= "display:none;">
<?php echo $this->Form->input('category_id', array('options' => array('' => 'Select Category'), 'id' => 'category_id', 'class' => 'form-control', 'label' => false, 'empty' => 'Select Category')); ?>  
                            </div>
                            <div class="form-group" >
<?php echo $this->Form->input('advice_title', array('class' => 'form-control', 'placeholder' => 'Enter Title (Optional)', 'label' => false, 'id' => 'advice_title')); ?>

                            </div>

                        </div>
                        <div class="col-md-6 hind-sights-form" style="margin-top:-25px;">
                            <div class="form-group">
                                <label>Have you published this advice before?</label>
<?php echo $this->Form->input('source_url', array('class' => 'form-control', 'placeholder' => 'Add a source URL link', 'label' => false, 'id' => 'source_url')); ?>
                            </div>
                            <div class="form-group">
                                <input type='text' name="data[Advice][advice_decision_date]" class="form-control calender" disable="disable" id="datepicker" autocomplete="off", placeholder="When did you make this decision? Select a date." />

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 padding-top hind-sights-form ">
                            <div class="form-group">

<?php echo $this->Form->textarea('executive_summary', array('class' => 'form-control', 'placeholder' => 'Executive Summary', 'data-placeholder' => 'Executive Summary', 'label' => false, 'id' => 'executive_summary')); ?>
                            </div>
                            <div class="form-group">

<?php echo $this->Form->textarea('challenge_addressing', array('class' => 'form-control', 'placeholder' => 'What Entrepreneurship Challenge are You Addressing?', 'data-placeholder' => 'What Entrepreneurship Challenge are You Addressing?', 'label' => false, 'id' => 'challenge_addressing')); ?>

                            </div>
                            <div class="form-group">

<?php echo $this->Form->textarea('key_advice_points', array('class' => 'form-control', 'placeholder' => 'Key Advice Points (we recommend bullet points or short paragraphs for easy reading)', 'data-placeholder' => 'Key Advice Points (we recommend bullet points or short paragraphs for easy reading)', 'label' => false, 'id' => 'key_advice_points')); ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <!--                        <button type="button" class="btn btn-black" data-toggle="modal" data-target="#submit-hindsight" data-dismiss="modal">Submit Advice</button>-->
                    <?php echo $this->Form->Button('Submit Advice', array('div' => false,'type'=>'button', 'class' => 'btn btn-black','onclick'=>"javascript:jQuery('#submit-hindsight').modal('show');")); ?>
                    <?php echo $this->Form->button('Cancel', array('div' => false, 'class' => 'btn btn-black', 'data-toggle' => 'modal', 'data-dismiss'=>"modal")); ?>
                    </div>
<?php echo $this->Form->end(); ?>   

                </div>
            </div>

        </div>
    </div>
    <div class="modal fade" id="submit-hindsight" tabindex="-1" role="dialog" data-backdrop="static"  aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
                    <h4 class="modal-title" id="myModalLabel">Submit Advice</h4>
                </div>
                <div class="modal-body">
                    Are you sure you want to submit this?
                </div>
                <div class="modal-footer model-footer1 ">
                    <button type="button" class="btn btn-black" data-dismiss="modal" id="submitAdvice">Yes</button>
                    <button type="button" class="btn btn-black" data-dismiss="modal">No</button>
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
  
function clearAll(){


            $("#advice_title").nextAll().remove();
            $("#category_id").nextAll().remove();
            $("#decision_type_id").nextAll().remove();
            $("#datepicker").nextAll().remove();
            $("#executive_summary").nextAll().remove();
        }
        $('#submitAdvice').click( function(e){
 e.preventDefault();
 //alert("ente");
             var decision_data =  $("#decision_type_id option:selected").text();
           var  decision_type_id = $("#decision_type_id").val();
           
            var datas=$('#UserchallangeinfoProfileForm').serialize();
            $.ajax({
                url:"<?php echo Router::url(array('controller' => 'Advices', 'action' => 'add_advice')) ?>",
                data:datas,
                type:'POST',
                success:function(data){
                  //alert(data);
                    if(data.result=="error"){
                        clearAll();
                        //                    if(data.error_msg.challenge_id !== undefined && data.error_msg.challenge_id[0]!=''){
                        //                        $("#challenge_id").after('<div class="error-message">'+data.error_msg.challenge_id[0]+'</div>');
                        //                    }
                        if(data.error_msg.advice_title !== undefined && data.error_msg.advice_title[0]!=''){
                            $("#advice_title").after('<div class="error-message">'+data.error_msg.advice_title[0]+'</div>');
                        }
                        if(data.error_msg.category_id !== undefined && data.error_msg.category_id[0]!=''){
                            $("#category_id").after('<div class="error-message">'+data.error_msg.category_id[0]+'</span>');
                        }
                        if(data.error_msg.decision_type_id !== undefined && data.error_msg.decision_type_id[0]!=''){
                            $("#decision_type_id").after('<div class="error-message">'+data.error_msg.decision_type_id[0]+'</div>');
                        }
                        if(data.error_msg.advice_decision_date !== undefined && data.error_msg.advice_decision_date[0]!=''){
                            $("#datepicker").after('<div class="error-message">'+data.error_msg.advice_decision_date[0]+'</div>');
                        }
                        if(data.error_msg.executive_summary !== undefined && data.error_msg.executive_summary[0]!=''){
                            $("#executive_summary").after('<div class="error-message">'+data.error_msg.executive_summary[0]+'</div>');
                        }
                
                    }
                    else{
                       // alert("fd");
                     
                    ///    alert( $('ul.tabs li'));
                  //$('#'+decision_data+'-tab').closest('li').addClass('active'); 
                  // alert(  $('#'+decision_data+'-tab').closest('li'));
clearAll();

                        $("#UserchallangeinfoProfileForm").get(0).reset();
                        $("#new-advice").modal('hide');
                           //getListData(decision_data, decision_type_id, 'tab', 0);
                       window.location="<?php echo Router::url(array('controller' => 'advices', 'action' => 'dashboard')) ?>";
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
                 url:'<?php echo $this->webroot?>advices/deleteAdvice/',
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

                      $('.check_all').prop( "checked", false );

                        $('.delete-hindsight').prop('disabled', true).css({opacity:'0.2'});
                     
                    }
                  });               
                 
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
   
   
   /*----- Start to manage status of invitation ---------------------*/
   $('body').on('click', '.invitee-status', function(){
       var $this = $(this),
       invitationId = $this.data('id'),
       wrapper = $this.closest('.invitation-wrapper'),
       userName = wrapper.find('.user-name').text();
       if(invitationId > 0){
           bootbox.dialog({
            message: userName+" invited you. ",            
            buttons: {
                success: {
                    label: "Accept",
                    className: "btn-black",
                    callback: function() {
                        var datas = {'invId':invitationId, 'status':'accept'};
                        $.ajax({
                            type:'POST',
                            url:'<?php echo Router::url(array('controller' => 'advices', 'action' => 'invitationStatus')) ?>',
                            data:datas,
                            success:function(resp){
                                if(resp == 1){
                                    $this.remove();
                                }
                                else{
                                    bootbox.alert('Sorry! status did not change.');
                                }
                            }
                        });
                   }
                },
                danger: {
                    label: "Reject",
                    className: "btn-black",
                    callback:function(){
                        var datas = {'invId':invitationId, 'status':'reject'};
                        $.ajax({
                            type:'POST',
                            url:'<?php echo Router::url(array('controller' => 'advices', 'action' => 'invitationStatus')) ?>',
                            data:datas,
                            success:function(resp){
                                if(resp == 1){
                                    wrapper.remove();
                                }
                                else{
                                    bootbox.alert('Sorry! status did not change.');
                                }
                            }
                        });
                    }
                }
               
            }
        });     
           
       }
   });
   /*----- End to manage status of invitation ---------------------*/
   
});

</script>