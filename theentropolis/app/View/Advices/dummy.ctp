    <script type="text/javascript">
        window.onload = function() {
            cnt_article = new countUp('article-counter', 0,<?php $numPublication = $this->User->numPublication();                                   
                                    echo $numPublication; ?>,0, 2.5);
             cnt_wisdom = new countUp('wisdom-counter', 0,<?php echo $total_eluminatidetail = $this->Eluminati->getEluminatiDetailCount();?>, 0, 2.5);
             cnt_population = new countUp('population-counter', 0,<?php $numUser = $this->User->totalNumberOfUser();
                                    if($numUser >= 1000){
                                        $numUser = $numUser/1000;
                                        $numUser = $numUser.'K';
                                    }
                                    echo $numUser; ?>, 0, 2.5);
             cnt_eluminati = new countUp('eluminati-counter', 0,<?php echo $total_eluminatis = $this->Eluminati->getEluminatiCount();?>, 0, 2.5);
             cnt_sage = new countUp('sage-counter', 0, <?php $numSageUser = $this->User->numActiveExperts();
                                    if($numSageUser >= 1000){
                                        $numSageUser = $numSageUser/1000;
                                        $numSageUser = $numSageUser.'K';
                                    }
                                    echo $numSageUser; ?>, 0, 2.5);
             cnt_seeker = new countUp('seeker-counter', 0,<?php $numSeeker = $this->User->numActiveSeekers();
                                    if($numSeeker >= 1000){
                                        $numSeeker = $numSeeker/1000;
                                        $numSeeker = $numSeeker.'K';
                                    }
                                    echo $numSeeker;?>, 0, 2.5);
             cnt_advice = new countUp('advice-counter', 0,<?php $numAdvices = $this->Advice->numAdvices();
                                    if($numAdvices >= 1000){
                                        $numAdvices = $numAdvices/1000;
                                        $numAdvices = $numAdvices.'K';
                                    }
                                    echo $numAdvices;?>, 0, 2.5);
             cnt_hindsight = new countUp('hindsight-counter', 0,<?php $numHindsight = $this->Hindsight->numHindsights();                    
                                    if($numHindsight >= 1000){
                                        $numHindsight = $numHindsight/1000;
                                        $numHindsight = $numHindsight.'K';
                                    }
                                    echo $numHindsight;?>, 0, 2.5);
             cnt_Myadvice = new countUp('Myadvice-counter', 0,<?php if(!empty($advicedata)){ echo $this->Rating->totalDataCount($advicedata[0]['Advice']['context_role_user_id'],'Advice');}else{echo '0';}?>, 0, 2.5);

            cnt_article.start();
            cnt_wisdom.start();
            cnt_population.start();
            cnt_eluminati.start();
            cnt_sage.start();
            cnt_seeker.start();
            cnt_advice.start();
            cnt_hindsight.start();
            cnt_Myadvice.start();
        }
    </script>
 <div class="page-loading" style="color:red"><?php echo $this->Html->image('loading-upload.gif');?></div>

<div class="col-md-10 content-wraaper black-dot">
    <div class="row">
        <div class="col-md-8">
            <div class="sage-dash-wrap">
                <div class="sage-wrap">
                    <div class="row">
                        <div class="col-md-8 sage-dash-top">
                            <div class="sage-dash-img">

                                <?php
                             
                                   $info = $this->User->getUserData($this->Session->read('user_id'));
                                if($avatar != ''){?>   
                                 <img src="<?php echo $this->Html->url('/'). $this->Image->resize($avatar,128, 128, true);?>" />
                               <?php }
                               else{?>
                                  <img src="<?php echo $this->Html->url('/'). $this->Image->resize('img/dummy-pic.png',128, 128, true);?>" />
                               
                             <?php   } //ECHO pr($user_info);?> 

                            </div>
                            <div class="sage-dash-title">
                                <h1><?php echo $info['first_name']." ".$info['last_name'];?><a class="btn Black-Btn" href="<?php echo Router::url(array('controller' => 'users', 'action' => 'settings')) ?>">Edit</a></h1>
                              <?php if( @$user_info['UserProfile']['designation']) {?>  <h5><?php echo @$user_info['UserProfile']['designation'];?></h5><?php } ?>

                                <?php if(@$countryName['Country']['country_title']){?><span class="locater">    <i><?php echo $this->Html->image('pin.png', array('alt'=>''));?></i><?php if(@$user_info['UserProfile']['city']){ echo @$user_info['UserProfile']['city'].", ".@$countryName['Country']['country_title'];}else{
                                  echo @$countryName['Country']['country_title'];
                                } ?></span><?php  }?>

                                <span>Citizen since:<b><?php 

                             
                                

                                echo date("Y",strtotime($info['registration_date'])) ?></b></span>
                            </div>
                        </div>
                        <div class="col-md-4 profile-view">
                            <ul class="profile-rating right">
                                <li><span>Total profile view </span> <b><?php  if(@$user_info['UserProfile']['user_profile_view_status']){ echo @$user_info['UserProfile']['user_profile_view_status'];}else echo '0';?></b></li>
                                <li>
                                         <span class='average-rating'>Total wisdom rating</span><b><?php if(!empty($advicedata)){  echo $this->Rating->getRatingAllAdvice($advicedata[0]['ContextRoleUser']['id']); ?>/10<?php }else{ echo '0/10';} ?></b> 
                                    
                                </li>
                                <li><span>Badges earned</span>
                                    <span class="img-icon">
                                    <?php echo $this->Html->image('icon5.png', array('alt'=>''));?>
                                    <?php echo $this->Html->image('sage-gray.png', array('alt'=>''));?>
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="sage-wrap">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="box-panel">
                                <h2>
                                    <?php echo $this->Html->image('entrop-icon1.png', array('alt'=>''));?>
                                    Population
                                </h2>
                                <div class="box-panel-detail">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <h1><span id="population-counter"></span></h1>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="advice-rating"><?php echo $this->Html->image('eluminate-icon.png', array('alt'=>''));?><span id="eluminati-counter"></span></div>
                                            <div class="advice-rating"><?php echo $this->Html->image('sage-gray.png', array('alt'=>''));?><span id="sage-counter"></span></div>
                                            <div class="advice-rating"><?php echo $this->Html->image('seeker-icon.png', array('alt'=>''));?><span id="seeker-counter"></span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="box-panel">
                                <h2>
                                    <?php echo $this->Html->image('EC2.png', array('alt'=>''));?>
                                    Articles 
                                </h2>
                                <div class="box-panel-detail">

                                    <h1><span id="article-counter"></span></h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="box-panel">
                                <h2 style="padding-bottom:8px;">
                                    <?php echo $this->Html->image('eluminate-icon.png', array('alt'=>''));?>
                                    Wisdom
                                </h2>
                                <div class="box-panel-detail">
                                    <h1><span id="wisdom-counter"></span>
                                    </h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sage-wrap">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="box-panel">
                                <h2>
                                    <?php echo $this->Html->image('advices.png', array('alt'=>''));?>
                                    Advice|Market<button class="btn Black-Btn right add-hindsights" data-toggle="modal" data-target="#new-advice">Add</button>
                                </h2>
                                <div class="box-panel-detail">
                                    <div class="row">
                                        <div class="col-md-6 manage-wrap">
                                            <h3>Total|Advice</h3>
                                            <h1><span id="advice-counter"></span></h1>
                                        </div>
                                        <div class="col-md-6 manage-wrap">
                                            <h3>My|Advice </h3>
                                            <h1><span id="Myadvice-counter"></span></h1>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="box-panel">
                                <h2>
                                    <?php echo $this->Html->image('hindsights.png', array('alt'=>''));?>
                                    Decision|Bank
                                </h2>
                                <div class="box-panel-detail">
                                    <div class="row">
                                        <div class="col-md-12 manage-wrap">
                                            <h3>Total|Hindsight</h3>
                                            <h1><span id="hindsight-counter"></span></h1>
                                        </div>                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sage-wrap">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="box-panel">
                                <h2>
                                    <?php echo $this->Html->image('ask.png', array('alt'=>''));?>
                                    Ask|Entropolis
                                </h2>
                                <div class="box-panel-detail">
                                   
                                        <?php echo $this->Form->create('AskQuestion', array('id'=>"discussion-form-data"));?>      
                                        <div class="form-group">
                                            <label class="custom-select">
                                                <div class="input select required">
                                                 <!--    <select required="required" class="form-control" id="country" name="data[User][country_id]">
                                                        <option value="">Category</option>
                                                    </select>
 -->
                                                    <?php echo $this->Form->input('category_id', array('options'=>$decisiontypes,'id'=>'decision_type', 'class'=>'form-control', 'label'=>false));?>
                                                </div>
                                            </label>
                                            <label class="custom-select">
                                                <div class="input select required">
                                                 
                                                    <?php echo $this->Form->input('sub_category_id', array('options'=>array(''=>'Sub-Category'), 'id'=>'categoryid','class'=>'form-control', 'label'=>false));?>  

                                                </div>
                                            </label>
                                        </div>
                                        <div class="form-group">

                                               <?php echo $this->Form->input('question_title', array('id'=>'question_title','class'=>'form-control', 'placeholder'=>'Title', 'label'=>false,'maxlength'=>'500'));?>  

                                         
                                        </div>
                                        <div class="form-group">
                      <!--                       <textarea name="" class="form-control" cols="30" rows="3">Your question</textarea> -->
                                             <?php echo $this->Form->textarea('description', array('id'=>'description', 'placeholder'=>'Your question', 'class'=>'form-control', 'rows'=>'6', 'label'=>false ,'maxlength'=>'1000'));?>
                                        </div>
                                        <?php echo $this->Form->submit('Ask', array('class'=>'btn Black-Btn add-discussion' ,'div'=>false) );?>
                                        <!-- <button class="btn Black-Btn">Ask</button> -->
                                     <?php echo $this->Form->end();?>          
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="box-panel">
                                <h2>
                                    <?php echo $this->Html->image('invite.png', array('alt'=>''));?>
                                    E|Box
                                </h2>
                                <div class="box-panel-detail e-box">
                                    <p>We want to hear from you. Share your thoughts on how we can built a better city.</p>
                                     <?php echo $this->Form->create('AskQuestion', array('id'=>"send-feedback"));?> 
                                        <div class="form-group">
                                            <!-- <textarea name= "data['AskQuestion']['feedback']" required class="form-control" cols="30" rows="5"></textarea>
 -->
                                                <?php echo $this->Form->textarea('feedback', array('id'=>'feedback','required','class'=>'form-control', 'rows'=>'6', 'label'=>false ,'maxlength'=>'1000'));?>
                                        </div>
                                       
                                          <?php echo $this->Form->button('Share', array('class'=>'btn Black-Btn add-feedback' ,'div'=>false,'type'=>'submit') );?>
                                           <?php echo $this->Form->end();?>     
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 left-panels">
            <div role="tabpanel">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs tab-panels" role="tablist">
                    <li role="presentation" class="active"><a href="#activity" aria-controls="activity" data-type = 'activity' class = 'tab-data'role="tab" data-toggle="tab"><?php echo $this->Html->image('activity.png', array('alt'=>''));?>Activity<span class="activity-count"><?php echo $this->Notification->countUnreadObject($this->Session->read('user_id'),'Advice');?></span></a></li>
                    <li role="presentation"><a href="#people" class = 'tab-data' aria-controls="people"  data-type = 'people' role="tab" data-toggle="tab"><?php echo $this->Html->image('people.png', array('alt'=>''));?> People</a>
                    </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">

                                
                                 <div role="tabpanel" class="tab-pane active" id="activity">   

                                 
                                    <?php echo $this->element('activity_notification_element');?>
                         


                                </div><!-- activity-->

                    <div role="tabpanel" class="tab-pane" id="people">
                      <div  class="scrollTo-demo"  id="demo">
                            <div class="items" id="info">
                                <div class="demo-y set-wrap-height">
                                        <?php echo $this->element('people_invitation_element');?>                 
                                   
                                </div>
                            </div>
                        </div>                      
                    </div><!-- people-->

                </div><!-- tab-content-->
            </div>
        </div>
    </div>
</div>


 <?php echo $this->element('advice_all_modal_element');?>                      

    

       

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
    $("#cke_executive_summary").nextAll().remove();
}
        $('#submitAdvice').click( function(e){
            e.preventDefault();

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
                            $("#cke_executive_summary").after('<div class="error-message">'+data.error_msg.executive_summary[0]+'</div>');
                        }

                     $('.modal-body').scrollTop(0); 
                
                    }
                    else{
                       
clearAll();
                        
                        $("#UserchallangeinfoProfileForm").get(0).reset();
                         $("#new-advice").modal('hide');
                         jQuery("#thanks-wisdom-add").modal('show');
                           //getListData(decision_data, decision_type_id, 'tab', 0);
                       
                    }
                }
        
            });
        
        });


 $('body').on('click','#confirmadvice',function(){

 
   window.location="<?php echo Router::url(array('controller' => 'advices', 'action' => 'dashboard')) ?>";

});
        </script>



<?php echo $this->element('dashboard_js_element');?>

