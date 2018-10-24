<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-53c383bb6244e3e5"></script>
<?php if($type=='Hindsight'){
 // pr($hindsight);
 //die; ?>


  <div class="modal-dialog">
    <div class="modal-content purpel-bg">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><i class="icons close-icon"></i></button>
      </div>
       <div class="modal-body">
        <div class="elumanati-wrap">
          <div class="row">
            <div class="col-md-4">
              <div class="">
               <?php 
              if($adviceInfoData['ContextRoleUser']['User']['user_image'])
              {

                $user_image = $adviceInfoData['ContextRoleUser']['User']['user_image'];?>
                <img   src="<?php echo $this->Html->url('/'). $this->Image->resize($user_image, 227, 256, false);?>" alt=""/>
           <?php   }else {
              echo $this->Html->image('dummy-pic.png');
            ?>
             <!--  <img   src="<?php echo $this->Html->url('/').$this->Image->resize(  'img/avatar-male-1.png' , 227, 256, false);?>" alt=""/>     -->
         <?php  }
              ?>

            </div>
            
          </div>
            <div class="col-md-8">
              <div class="eluminate-icon">
            <i>
            <?php echo $this->Html->image('seeker-hindsight-icon.png'); ?>
            </i>
            <h3>SEEKER HINDSIGHT</h3>
          </div>
          <div class="row ">
            <div class="col-md-12">
              <div class="elumanati-wrap-left">
               
                <span><h4><?php echo $this->Eluminati->text_cut($adviceInfoData['Hindsight']['hindsight_title'], $length = 20, $dots = true);?></h4></span>
                <span><?php echo $adviceInfoData['DecisionType']['decision_type'];?>|<?php echo $adviceInfoData['Category']['category_name'];?></span>
                <span>Published: <?php echo date('D j F Y',strtotime($adviceInfoData['Hindsight']['hindsight_posted_date']));?></span>
                <span class="date">Last Updated: <?php echo date('D j F Y',strtotime($adviceInfoData['Hindsight']['hindsight_update_date']));?></span>
              </div>
            </div>            
          </div>          
            </div>
          </div>
          <div class="row margin-top">
            <div class="col-md-4">
              <h2><a href= "pages/seekerProfile/<?php echo $adviceInfoData['ContextRoleUser']['id'];?>" target= "_Blank"><?php echo $adviceInfoData['ContextRoleUser']['User']['first_name']." ".$adviceInfoData['ContextRoleUser']['User']['last_name'];?></a></h2>
            </div>
            <div class="col-md-8">
              <div class="url">
            <input type="text" class="form-control" placeholder="Original Source URL">
          </div>
            </div>
          </div>
          <div class="row eluminti-box-wrap">
            <div class="col-md-4">
              <div class="relative">
                <textarea class="form-control" rows="3"></textarea>  
               <!--  <i class="fa fa-plus add"></i>       -->        
              </div>
              <div class="relative">
                <textarea class="form-control" rows="3"></textarea>  
             <!--    <i class="fa fa-plus add"></i>  -->             
              </div>
              <div class="relative">
                <textarea class="form-control" rows="3"></textarea>  
              <!--   <i class="fa fa-plus add"></i>  -->             
              </div>
            </div>
            <div class="col-md-8">
              <div class="relative">
                <!-- <textarea class="form-control" rows="3" placeholder="Executive Summary"></textarea>  
                <i class="fa fa-plus add"></i>  -->   


                <?php
                if(strlen($adviceInfoData['Hindsight']['short_description']) > 300)
                {?>
              <p class="eluminti-box person-content short-data"><?php 
                  // echo substr($post['Escene']['post_description'], $remaining-1 );  
                  $actual_lenth = strlen(trim($adviceInfoData['Hindsight']['short_description'])); 
                  echo nl2br($this->Eluminati->text_cut($adviceInfoData['Hindsight']['short_description'], $length = 300, $dots = true)); 
                  $later_length =  strlen(trim($this->Eluminati->text_cut($adviceInfoData['Hindsight']['short_description'], $length = 300, $dots = true)));?></p>
                <p class="eluminti-box person-content full-data hide"  data-to="1"> <?php echo  nl2br($adviceInfoData['Hindsight']['short_description']);  ?></p>  
                  <?php if( $actual_lenth != $later_length ){?>
                                 <a href="#1" class="right btn-readmore"><i class="fa fa-plus add"></i> </a>
                             <?php } ?><?php
                }
                else{?>
                  <p class="eluminti-box person-content short-data"><?php 
                  echo nl2br($this->Eluminati->text_cut($adviceInfoData['Hindsight']['short_description'], $length = 300, $dots = true));?>
                </p>
               <?php }?>          
              </div>
             
            </div>
          </div>

        </div>
      
      </div>
      <div class="modal-footer align-center">
       <a data-toggle="modal" onclick="javascript:jQuery('#add-comment').modal('show');"> <?php echo $this->Html->image('black-icon1.png');?></a>
         <a data-toggle="modal" onclick="javascript:jQuery('#add-rating').modal('show');"> <?php echo $this->Html->image('black-icon2.png');?></a>
       <a data-toggle="modal" onclick="javascript:jQuery('#share-advice').modal('show');"> <?php echo $this->Html->image('black-icon3.png');?></a>
          <a data-toggle="modal" onclick="javascript:jQuery('#invite-user').modal('show');"> <?php echo $this->Html->image('black-icon4.png');?></a>
          <a data-toggle="modal" onclick="javascript:jQuery('#send-message').modal('show');"> <?php echo $this->Html->image('black-icon5.png');?></a>
        <a href="#"> <i class="icons attachment-icon"></i></a>        
      </div>
    </div>
  </div>

<?php }
else if($type=='Advice'){

 //pr($advice);
//  echo $advice[0]['ContextRoleUser']['id'];
// die;?>

<div class="modal-dialog">
    <div class="modal-content yellow-bg">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><i class="icons close-icon"></i></button>
      </div>
       <div class="modal-body">
        <div class="elumanati-wrap">
          <div class="row">
            <div class="col-md-4">
              <div class="">
              <?php 
               $obj_id = $adviceInfoData['Advice']['id'];
               $obj_type = 'Advice';
              
              if($adviceInfoData['ContextRoleUser']['User']['user_image'])
              {

                $user_image = $adviceInfoData['ContextRoleUser']['User']['user_image'];?>
                <img   src="<?php echo $this->Html->url('/'). $this->Image->resize($user_image, 227, 256, false);?>" alt=""/>
           <?php   }else {
            echo $this->Html->image('dummy-pic.png');
            ?>
              <!-- <img   src="<?php echo $this->Html->url('/').$this->Image->resize('img/avatar-male-1.png' , 227, 256, false);?>" alt=""/>     -->
         <?php  }
              ?>
            </div>
            
          </div>
            <div class="col-md-8">
              <div class="eluminate-icon">
            <i><?php echo $this->Html->image('sage-icons.png');?></i>
            <h3>Sage Advice</h3>
          </div>
          <div class="row ">
            <div class="col-md-12">
              <div class="elumanati-wrap-left">
               
                <span><h4><?php echo $this->Eluminati->text_cut($adviceInfoData['Advice']['advice_title'], $length = 20, $dots = true);?></h4></span>
               <span><?php echo $adviceInfoData['DecisionType']['decision_type'];?>|<?php echo $adviceInfoData['Category']['category_name'];?></span>
                <span>Published: <?php echo date('D j F Y',strtotime($adviceInfoData['Advice']['advice_posted_date']));?></span>
                <span class="date">Last Updated: <?php echo date('D j F Y',strtotime($adviceInfoData['Advice']['advice_update_date']));?> </span>
              </div>
            </div>            
          </div>          
            </div>
          </div>
          <div class="row margin-top">
            <div class="col-md-4">
              <h2> <a href= "pages/sageProfile/<?php echo $adviceInfoData['ContextRoleUser']['id'];?>" target= "_Blank"><?php echo $adviceInfoData['ContextRoleUser']['User']['first_name']." ".$adviceInfoData['ContextRoleUser']['User']['last_name'];?></a></h2>
            </div>
            <div class="col-md-8">
              <div class="url">
            <input type="text" class="form-control" value= "<?php echo $adviceInfoData['Advice']['source_url'];?>" placeholder="Original Source URL">
          </div>
            </div>
          </div>
          <div class="row eluminti-box-wrap">
            <div class="col-md-4">
              <div class="relative">
                <textarea class="form-control" rows="3"></textarea>  
             <!--    <i class="fa fa-plus add"></i>     -->          
              </div>
              <div class="relative">
                <textarea class="form-control" rows="3"></textarea>  
              <!--   <i class="fa fa-plus add"></i> -->              
              </div>
              <div class="relative">
                <textarea class="form-control" rows="3"></textarea>  
                <!-- <i class="fa fa-plus add"></i>      -->         
              </div>
            </div>
            <div class="col-md-8">
              <div class="relative">
               <!--  <textarea class="form-control" rows="3" placeholder="Executive Summary"><?php echo $advice[0]['Advice']['executive_summary'];?></textarea>  
                <i class="fa fa-plus add"></i> <i class="fa fa-minus"></i>
 -->         


    <?php
    if(strlen($adviceInfoData['Advice']['executive_summary']) > 300)
    {?>
  <p class="eluminti-box person-content short-data"><?php 
      // echo substr($post['Escene']['post_description'], $remaining-1 );  
      $actual_lenth = strlen(trim($adviceInfoData['Advice']['executive_summary'])); 
      echo nl2br($this->Eluminati->text_cut($adviceInfoData['Advice']['executive_summary'], $length = 300, $dots = true)); 
      $later_length =  strlen(trim($this->Eluminati->text_cut($adviceInfoData['Advice']['executive_summary'], $length = 300, $dots = true)));?></p>
    <p class="eluminti-box person-content full-data hide"  data-to="1"> <?php echo  nl2br($adviceInfoData['Advice']['executive_summary']);  ?></p>  
      <?php if( $actual_lenth != $later_length ){?>
                     <a href="#1" class="right btn-readmore"><i class="fa fa-plus add"></i> </a>
                 <?php } ?><?php
    }
    else{?>
      <p class="eluminti-box person-content short-data"><?php 
      echo nl2br($this->Eluminati->text_cut($adviceInfoData['Advice']['executive_summary'], $length = 300, $dots = true));?>
    </p>
   <?php }?>
        
              </div>
              <div class="relative">
               <!--  <textarea class="form-control" rows="3" placeholder="The Entrepreneurship Challenge"><?php echo $advice[0]['Advice']['challenge_addressing'];?></textarea>
                <i class="fa fa-plus add"></i>       -->  

                    <?php
                  if(strlen($adviceInfoData['Advice']['challenge_addressing']) > 300)
                  {?>
                <p class="eluminti-box person-content short-data"><?php 
                    // echo substr($post['Escene']['post_description'], $remaining-1 );  
                    $actual_lenth = strlen(trim($adviceInfoData['Advice']['challenge_addressing'])); 
                    echo nl2br($this->Eluminati->text_cut($adviceInfoData['Advice']['challenge_addressing'], $length = 300, $dots = true)); 
                    $later_length =  strlen(trim($this->Eluminati->text_cut($adviceInfoData['Advice']['challenge_addressing'], $length = 300, $dots = true)));?></p>
                  <p class="eluminti-box person-content full-data hide"  data-to="1"> <?php echo  nl2br($adviceInfoData['Advice']['challenge_addressing']);  ?></p>  
                    <?php if( $actual_lenth != $later_length ){?>
                                   <a href="#1" class="right btn-readmore"><i class="fa fa-plus add"></i> </a>
                               <?php } ?><?php                  }
                  else{?>
                    <p class="eluminti-box person-content short-data"><?php 
                    echo nl2br($this->Eluminati->text_cut($adviceInfoData['Advice']['challenge_addressing'], $length = 300, $dots = true));?>
                  </p>
                 <?php }?>
              </div>

              <div class="relative">
               <!--  <textarea class="form-control" rows="3" placeholder="Key Advice Points"><?php echo $advice[0]['Advice']['key_advice_points'];?></textarea>
                <i class="fa fa-plus add"></i>    -->   

                   <?php
                  if(strlen($adviceInfoData['Advice']['key_advice_points']) > 300)
                  {?>
                <p class="eluminti-box person-content short-data"><?php 
                    // echo substr($post['Escene']['post_description'], $remaining-1 );  
                    $actual_lenth = strlen(trim($adviceInfoData['Advice']['key_advice_points'])); 
                    echo nl2br($this->Eluminati->text_cut($adviceInfoData['Advice']['key_advice_points'], $length = 300, $dots = true)); 
                    $later_length =  strlen(trim($this->Eluminati->text_cut($adviceInfoData['Advice']['key_advice_points'], $length = 300, $dots = true)));?></p>
                  <p class="eluminti-box person-content full-data hide"  data-to="1"> <?php echo  nl2br($adviceInfoData['Advice']['key_advice_points']);  ?></p>  
                    <?php if( $actual_lenth != $later_length ){?>
                                   <a href="#1" class="right btn-readmore"><i class="fa fa-plus add"></i> </a>
                               <?php } ?><?php } else{?>
                    <p class="eluminti-box person-content short-data"><?php 
                    echo nl2br($this->Eluminati->text_cut($adviceInfoData['Advice']['key_advice_points'], $length = 300, $dots = true));?>
                  </p>
                 <?php  }?>

              </div>
            </div>
          </div>
        </div>
      <div class="atch-wrapper clearfix">                                                                                                                             
          <div class="image-bind">
           
          </div>    
      </div>
      </div>
      <div class="modal-footer align-center">
        <a data-toggle="modal" onclick="javascript:jQuery('#add-comment').modal('show');"> <?php echo $this->Html->image('black-icon1.png');?></a>
        <a data-toggle="modal" onclick="javascript:jQuery('#add-rating').modal('show');"> <?php echo $this->Html->image('black-icon2.png');?></a>
        <a data-toggle="modal" onclick="javascript:jQuery('#share-advice').modal('show');"> <?php echo $this->Html->image('black-icon3.png');?></a>
        <a data-toggle="modal" onclick="javascript:jQuery('#invite-user').modal('show');"><?php echo $this->Html->image('black-icon4.png');?></a>
        <a data-toggle="modal" onclick="javascript:jQuery('#send-message').modal('show');"> <?php echo $this->Html->image('black-icon5.png');?></a>
     <!--     <a href="#" class="escene-action-right"><input type = "hidden" class= "obj_id" name = "obj_id" value = "<?php echo  $advice[0]['Advice']['id'];?>"><input type = "hidden" name = "obj_type" value= "Advice"><input class="atch-new" type="file" name="files[]" data-url="<?php echo Router::url(array('controller'=>'pages', 'action'=>'upload_data/'.$obj_id.'/'.$obj_type));?>"  multiple> <i class="fa fa-camera escene-action-fa"></i></a> -->
        <a href="#" class="escene-action-right"><input class="atch-new post-nav-input" type="file" name="files[]" data-url="<?php echo Router::url(array('controller'=>'escenes', 'action'=>'upload'));?>"  multiple><i class="icons attachment-icon"></i></a>  
      </div>
    </div>
  </div>
  <?php }
else{ 
    
    ?>
 <div class="modal-dialog">
    <div class="modal-content blue-bg">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><i class="icons close-icon"></i></button>
      </div>
       <div class="modal-body">
        <div class="elumanati-wrap">
          <div class="row">
            <div class="col-md-4">
              <div class="eluminti-signup-icon">
            <?php 
              if($eluminati['Eluminati']['image_url'])
              {

                $user_image = $eluminati['Eluminati']['image_url'];?>
                <img   src="<?php echo $this->Html->url('/'). $this->Image->resize($user_image, 227, 256, false);?>" alt=""/>
           <?php   }else {
echo $this->Html->image('dummy-pic.png');
            ?>
              <!-- <img   src="<?php echo $this->Html->url('/').$this->Image->resize('img/avatar-male-1.png' , 227, 256, false);?>" alt=""/>   -->  
         <?php  }
        
              ?>
            </div>
          </div>
            <div class="col-md-8" >
              <div class="eluminate-icon">
            <i><?php echo $this->Html->image('eluminate.png');?></i>
            <h3>E|Luminati Wisdom</h3>
          </div>
          <div class="row ">
            <div class="col-md-7">
              <div class="elumanati-wrap-left">
               
                <span><h4><?php echo $adviceInfoData['EluminatiDetail']['source_name'];?></h4></span>
                <span><?php echo $adviceInfoData['DecisionType']['decision_type'];?>|<?php echo $adviceInfoData['Category']['category_name'];?></span>
                <span>Published: <?php echo date('D j F Y',strtotime($adviceInfoData['EluminatiDetail']['date_published']));?></span>
                <span class="date">Last Updated: <?php echo date('D j F Y',strtotime($adviceInfoData['EluminatiDetail']['added_on']));?></span>
              </div>
            </div>
            <div class="col-md-5">
              <div class="elumanati-wrap-right">
                <span class = 'view_status'>Views [ <?php echo $adviceInfoData['EluminatiDetail']['view_status'] ?> ]</span>
                <span>Comments [ 0 ]</span>
                <span><a href="">View all comments</a></span>
              </div>
            </div>
          </div>
          
            </div>
          </div>
          <div class="row margin-top">
            <div class="col-md-4">
              <h2><?php echo $eluminati['Eluminati']['first_name']." ".$eluminati['Eluminati']['last_name'];?></h2>
            </div>
            <div class="col-md-8">
              <div class="url">
            <input type="text" class="form-control" placeholder="Original Source URL" value = "<?php echo $adviceInfoData['EluminatiDetail']['source_rss_feed'];?>">
          </div>
            </div>
          </div>
          <div class="row eluminti-box-wrap">
            <div class="col-md-4">
              <div class="relative">
                <textarea class="form-control" rows="3"></textarea>  
                <!-- <i class="fa fa-plus add"></i>    -->           
              </div>
              <div class="relative">
                <textarea class="form-control" rows="3"></textarea>  
       <!--          <i class="fa fa-plus add"></i>  -->             
              </div>
              <div class="relative">
                <textarea class="form-control" rows="3"></textarea>  
             <!--    <i class="fa fa-plus add"></i>        -->       
              </div>
            </div>
            <div class="col-md-8">
           
              <div class="relative" >

               <!--  <textarea class="form-control" rows="3" placeholder="Executive Summary"><?php echo $eluminati['Eluminati']['executive_summary'];?></textarea>   -->
 
                 <?php
                if(strlen($eluminati['Eluminati']['executive_summary']) > 300)
                {?>
              <p class="eluminti-box eluminti-box1 person-content short-data"><?php 
                  // echo substr($post['Escene']['post_description'], $remaining-1 );  
                  $actual_lenth = strlen(trim($eluminati['Eluminati']['executive_summary'])); 
                  echo nl2br($this->Eluminati->text_cut($eluminati['Eluminati']['executive_summary'], $length = 300, $dots = true)); 
                  $later_length =  strlen(trim($this->Eluminati->text_cut($eluminati['Eluminati']['executive_summary'], $length = 300, $dots = true)));?></p>
                <p class="eluminti-box eluminti-box1 person-content full-data hide"  data-to="1"> <?php echo  nl2br($eluminati['Eluminati']['executive_summary']);  ?></p>  
                  <?php if( $actual_lenth != $later_length ){?>
                                 <a href="#1" class="right btn-readmore"><i class="fa fa-plus add"></i> </a>
                                  
                             <?php } ?><?php
                }
                else{?>
                  <p class="eluminti-box eluminti-box1 person-content short-data" placeholder="Executive Summary"><?php 
                  echo nl2br($this->Eluminati->text_cut($eluminati['Eluminati']['executive_summary'], $length = 300, $dots = true));?>
                </p>
               <?php }?>
        

              </div>

              <div class="relative">
             <!--    <textarea class="form-control" rows="3" placeholder="The Entrepreneurship Challenge"><?php echo $eluminati_deatil['EluminatiDetail']['challenge_addressing'];?></textarea> -->
                    <?php
                  if(strlen($adviceInfoData['EluminatiDetail']['challenge_addressing']) > 300)
                  {?>
                <p class="eluminti-box person-content short-data"><?php 
                    // echo substr($post['Escene']['post_description'], $remaining-1 );  
                    $actual_lenth = strlen(trim($adviceInfoData['EluminatiDetail']['challenge_addressing'])); 
                    echo nl2br($this->Eluminati->text_cut($adviceInfoData['EluminatiDetail']['challenge_addressing'], $length = 300, $dots = true)); 
                    $later_length =  strlen(trim($this->Eluminati->text_cut($adviceInfoData['EluminatiDetail']['challenge_addressing'], $length = 300, $dots = true)));?></p>
                  <p class="eluminti-box person-content full-data hide"  data-to="1"> <?php echo  nl2br($adviceInfoData['EluminatiDetail']['challenge_addressing']);  ?></p>  
                    <?php if( $actual_lenth != $later_length ){?>
                                   <a href="#1" class="right btn-readmore"><i class="fa fa-plus add"></i> </a>
                               <?php } ?><?php                  }
                  else{?>
                    <p class="eluminti-box person-content short-data"><?php 
                    echo nl2br($this->Eluminati->text_cut($adviceInfoData['EluminatiDetail']['challenge_addressing'], $length = 300, $dots = true));?>
                  </p>
                 <?php }?>

                                
              </div>
              <div class="relative">
                <!-- <textarea class="form-control" rows="3" placeholder="Key Advice Points"><?php echo $eluminati_deatil['EluminatiDetail']['key_advice_points'];?></textarea> -->

                 <?php
                  if(strlen($adviceInfoData['EluminatiDetail']['key_advice_points']) > 300)
                  {?>
                <p class="eluminti-box person-content short-data"><?php 
                    // echo substr($post['Escene']['post_description'], $remaining-1 );  
                    $actual_lenth = strlen(trim($adviceInfoData['EluminatiDetail']['key_advice_points'])); 
                    echo nl2br($this->Eluminati->text_cut($adviceInfoData['EluminatiDetail']['key_advice_points'], $length = 300, $dots = true)); 
                    $later_length =  strlen(trim($this->Eluminati->text_cut($adviceInfoData['EluminatiDetail']['key_advice_points'], $length = 300, $dots = true)));?></p>
                  <p class="eluminti-box person-content full-data hide"  data-to="1"> <?php echo  nl2br($adviceInfoData['EluminatiDetail']['key_advice_points']);  ?></p>  
                    <?php if( $actual_lenth != $later_length ){?>
                                   <a href="#1" class="right btn-readmore"><i class="fa fa-plus add"></i> </a>
                               <?php } ?><?php } else{?>
                    <p class="eluminti-box person-content short-data"><?php 
                    echo nl2br($this->Eluminati->text_cut($adviceInfoData['EluminatiDetail']['key_advice_points'], $length = 300, $dots = true));?>
                  </p>
                 <?php  }?>
                            
              </div> 
            </div>
          </div>

        </div>
      
      </div>
      <div class="modal-footer align-center">
      <a data-toggle="modal" onclick="javascript:jQuery('#add-comment').modal('show');"><?php echo $this->Html->image('black-icon1.png');?></a>
      <a data-toggle="modal" onclick="javascript:jQuery('#add-rating').modal('show');"><?php echo $this->Html->image('black-icon2.png');?></a>
       <a> <?php echo $this->Html->image('black-icon3.png');?></a>
       <a> <?php echo $this->Html->image('black-icon4.png');?></a>
       <a>  <?php echo $this->Html->image('black-icon5.png');?></a>
    
        <a href="#" class="escene-action-right"><input class="atch-new post-nav-input" type="file" name="files[]" data-url="<?php echo Router::url(array('controller'=>'escenes', 'action'=>'upload'));?>"  multiple><i class="icons attachment-icon"></i></a>      
      </div>
    </div>
  </div>

  <?php } ?>
  
<!--<div class="footer-modal-apend"></div>-->
<!----------------- Start Add Comment ----------------->
<div class="modal fade" id="add-comment" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header <?php echo $modal_header_color;?> ">
                <button type="button" class="close" aria-hidden="true" onclick = "javascript:jQuery('#add-comment').modal('hide');"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">Add Comments</h4>
            </div>
              <?php echo $this->Form->create('Comment', array('class' => 'add-comment-form', 'id' => 'AddOnlyCommentForm')); ?>
            <div class="modal-body clearfix ">
              
                <div class="add-comment clearfix Add Comments  <?php echo $modal_header_color;?>">
                    <?php if($type!= "Eluminati"){?>
                    <p class= "">HI THERE <?php  echo strtoupper($adviceInfoData['ContextRoleUser']['User']['first_name'] . " " . $adviceInfoData['ContextRoleUser']['User']['last_name']) ?></p>
                    <?php }else{?>
                     <p class= "">HI THERE <?php  echo strtoupper($eluminati['Eluminati']['first_name'] . " " . $eluminati['Eluminati']['last_name']) ?></p>
                    <?php }?>

                    <ul>
                        <li> <span class=""><?php echo date("M j, Y"); ?></span> | My Comments and Feedback is:</li>
                    </ul>
                       <?php if($type!= "Eluminati"){?>
                    <input type="hidden" name="post_user_id" value="<?php echo $adviceInfoData['ContextRoleUser']['User']['id'];?>">
                  <?php }else{?>
                  <input type="hidden" name="post_user_id" value="">
                   <input type="hidden" name="eluminati_id" value="<?php echo $adviceInfoData['EluminatiDetail']['eluminati_id'];?>">
                       <?php }?>

                    <input type="hidden" name="data[Comment][user_id]" value="<?php echo $this->Session->read('user_id'); ?>">
                    <?php if ($type == "Advice") { ?>
                        <input type="hidden" name="data[Comment][advice_id]" value="<?php echo $adviceInfoData['Advice']['id']; ?>">
                    <?php } else if($type =='Hindsight') { ?>
                        <input type="hidden" name="data[Comment][hindsight_id]" value="<?php echo $adviceInfoData['Hindsight']['id']; ?>">
                    <?php } else{?>
                    <input type="hidden" name="data[Comment][eluminati_detail_id]" value="<?php echo $adviceInfoData['EluminatiDetail']['id']; ?>">
                    <?php }?>
                    <div class="form-group left">
                        <?php echo $this->Form->textarea('comments', array('class' => 'form-control', 'placeholder' => 'Comments', 'data-placeholder' => 'Comments', 'label' => false, 'id' => 'Comments', 'required')); ?>
                    </div>                        

                    <div class="add-comment-form-bottom <?php echo $modal_header_color;?>"><strong >From:</strong> <?php echo $this->Session->read('user_name'); ?></div>
                </div>
                
            </div>
            <div class="modal-footer">
                    <?php echo $this->Form->submit('Add', array('div' => false, 'class' => 'btn btn-black submit-comment')); ?>

                </div>
<?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>
<!----------------- End Add Comment ----------------->

<!----------------- Start Thanks Message ----------------->
<div class="modal fade" id="thanks-msg" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header  <?php echo $modal_header_color;?>">
                    <button type="button" class="close" aria-hidden="true" onclick = "javascript:jQuery('#thanks-msg').modal('hide');"><i class="icons close-icon"></i></button>
                    <h4 class="modal-title" id="myModalLabel">THANKS FOR YOUR COMMENT!</h4>
                </div>
                <div class="modal-body">
                    <?php if ($type == "Advice") { ?>
                    <p> Your feedback is really valuable to us as it helps us properly curate our archive and deliver amazing wisdom to help you and business owners around the world make better, faster ADVICEs without the angst.</p>
                     <?php } else if( $type == "Hindsight") { ?>
                     <p> Your feedback is really valuable to us as it helps us properly curate our archive and deliver amazing wisdom to help you and business owners around the world make better, faster decisions without the angst.</p>
                       <?php }else{?>
                         <p> Your feedback is really valuable to us as it helps us properly curate our archive and deliver amazing wisdom to help you and business owners around the world make better.</p>
                      <?php } ?>
                </div>
                <div class="modal-footer">
                  <!--   <button type="button" class="btn btn-black" data-dismiss="modal">DISALLOW</button> -->
                    <button type="button" class="btn btn-black" onclick = "javascript:jQuery('#thanks-msg').modal('hide');" >OK</button>

                </div>
            </div>
        </div>
    </div>
<!----------------- End Thanks Message ----------------->

<!----------------- Start Add Rating ----------------->
<div class="modal fade <?php echo $modal_color; ?>" id="add-rating" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <?php echo $this->Form->create('Comment', array('class' => 'add-comment-form', 'id' => 'AddCommentForm')); ?>
        <div class="modal-content left">
            <div class="modal-header <?php echo $modal_header_color;?> left" style="width:100%">
                <button type="button" class="close" onclick = "javascript:jQuery('#add-rating').modal('hide');" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">Comment and Rate</h4>
            </div>
            <div class="modal-body left <?php echo $modal_header_color;?> ">
                
                   <?php if($type!= "Eluminati"){?>
                    <input type="hidden" name="post_user_id" value="<?php echo $adviceInfoData['ContextRoleUser']['User']['id'];?>">
                  <?php }else{?>
                  <input type="hidden" name="post_user_id" value="">
                   <input type="hidden" name="eluminati_id" value="<?php echo $adviceInfoData['EluminatiDetail']['eluminati_id'];?>">
                       <?php }?>
                <input type="hidden" name="data[Comment][user_id]" value="<?php echo $this->Session->read('user_id'); ?>">

                 <?php if ($type == "Advice") { ?>
                        <input type="hidden" name="data[Comment][advice_id]" value="<?php echo $adviceInfoData['Advice']['id']; ?>">
                    <?php } else if($type =='Hindsight') { ?>
                        <input type="hidden" name="data[Comment][hindsight_id]" value="<?php echo $adviceInfoData['Hindsight']['id']; ?>">
                    <?php } else{?>
                    <input type="hidden" name="data[Comment][eluminati_detail_id]" value="<?php echo $adviceInfoData['EluminatiDetail']['id']; ?>">
                    <?php }?>

                <div class="add-comment <?php echo $modal_header_color;?>">
                    <?php if($type!= "Eluminati"){?>
                    <p class= "">HI THERE <?php  echo strtoupper($adviceInfoData['ContextRoleUser']['User']['first_name'] . " " . $adviceInfoData['ContextRoleUser']['User']['last_name']) ?></p>
                    <?php }else{?>
                     <p class= "">HI THERE <?php  echo strtoupper($eluminati['Eluminati']['first_name'] . " " . $eluminati['Eluminati']['last_name']) ?></p>
                    <?php }?>

                    <ul>
                        <li>
                            <?php if($type!= "Eluminati"){?>
                            <span class=""><?php echo date("M j, Y"); ?></span> | I found this <?php echo $type == 'Advice' ? 'advice' : 'hindsight'; ?> to be:
                             <?php }else{?>
                            <span class=""><?php echo date("M j, Y"); ?></span> | I found this to be:
                              <?php }?>
                          </li>
                    </ul>
                    <div class="form-group <?php echo $modal_header_color;?>">
                        <div class="radio-btn">

                            <input id="Excellent" checked="checked" type="radio" name="data[Comment][rating]" value="10">
                            <label class="custom-radio" for="Excellent">Excellent</label>

                        </div>
                        <div class="radio-btn">

                            <input id="good" type="radio" name="data[Comment][rating]" value="8">
                            <label class="custom-radio" for="good">Very good</label>

                        </div>
                        <div class="radio-btn">                       
                            <input id="Average" type="radio" name="data[Comment][rating]" value="6">
                            <label class="custom-radio" for="Average">Average</label>

                        </div>
                        <div class="radio-btn">

                            <input id="better" type="radio" name="data[Comment][rating]" value="4">
                            <label class="custom-radio" for="better">Could be better</label>

                        </div>
                        <div class="radio-btn">

                            <input id="Terrible" type="radio" name="data[Comment][rating]" value="2">
                            <label class="custom-radio" for="Terrible">Terrible</label> 

                        </div>
                        <div class="radio-btn">
                            <input id="Recommended" type="radio" name="data[Comment][rating]" value="2">
                            <label class="custom-radio" for="Recommended">Recommended</label> 

                        </div>

                          <div class="radio-btn">
                            <input id="Not Recommended" type="radio" name="data[Comment][rating]" value="2">
                            <label class="custom-radio" for="Not Recommended">Not Recommended</label> 

                        </div>

                    </div>


                    <div class="form-group left " style="margin-top:10px;">
                        <label for="exampleInputEmail1 " class="rating-label <?php echo $modal_header_color;?>">Comments (Optional):</label>

                        <?php echo $this->Form->textarea('comments', array('class' => 'form-control', 'placeholder' => 'Comments', 'data-placeholder' => 'Comments', 'label' => false, 'id' => 'Comments')); ?>
                    </div>                        

                    <div class="add-comment-form-bottom left <?php echo $modal_header_color;?>"><strong>From:</strong>  <?php echo $this->Session->read('user_name'); ?></div>
                </div>
               

                <?php echo $this->Form->end(); ?>
            </div>
             <div class="modal-footer left <?php echo $modal_header_color;?>" style="width:100%; margin-top:0px;">

                    <?php echo $this->Form->submit('Send Rating', array('div' => false, 'class' => 'btn btn-black')); ?>
                </div>

        </div>
    </div>
</div>
<!----------------- End Add Rating ----------------->

<!----------------- Start Thanks Message for rating -------->
<div class="modal fade" id="thanks-rating" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" onclick = "javascript:jQuery('#thanks-rating').modal('hide');" aria-hidden="true"><i class="icons close-icon"></i></button>
                        <h4 class="modal-title" id="myModalLabel">THANKS FOR RATING THIS <?php echo strtoupper($type);?> !</h4>
                    </div>
                    <div class="modal-body ">   
                     <?php if ($type == "Advice") { ?>
                    <p> Your feedback is really valuable to us as it helps us properly curate our archive and deliver amazing wisdom to help you and business owners around the world make better, faster ADVICEs without the angst.</p>
                     <?php } else if( $type == "Hindsight") { ?>
                     <p> Your feedback is really valuable to us as it helps us properly curate our archive and deliver amazing wisdom to help you and business owners around the world make better, faster decisions without the angst.</p>
                       <?php }else{?>
                         <p> Your feedback is really valuable to us as it helps us properly curate our archive and deliver amazing wisdom to help you and business owners around the world make better.</p>
                      <?php } ?>
                   </div>
                      <div class="modal-footer">
                      <!--   <button type="button" class="btn btn-black" data-dismiss="modal">Return to ADVICE</button> -->
                        <button type="button" class="btn btn-black" onclick = "javascript:jQuery('#thanks-rating').modal('hide');" >OK</button>
                      <!--   <a href="<?php echo Router::url(array('controller'=>'Advices', 'action'=>'index'))?>" class="btn btn-black">Do Another Search
</a> -->
                       
                     </div>
                  </div>
                </div>
</div>
<!----------------- End Thanks Message for rating -------->

 <!--Start modal for invitation-->
<div class="modal fade" id="invite-user" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header <?php echo $modal_header_color;?> ">
                <button type="button" class="close" onclick = "javascript:jQuery('#invite-user').modal('hide');" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">Invite User</h4>
            </div>
              <?php echo $this->Form->create('UserInvitation', array('class' => '', 'id' => 'send_invitation')); ?>
            <div class="modal-body clearfix ">
              
                <div class="add-comment clearfix Add Comments  <?php echo $modal_header_color;?>">

                   
                    <p class= "">HI THERE <?php  echo strtoupper($adviceInfoData['ContextRoleUser']['User']['first_name'] . " " . $adviceInfoData['ContextRoleUser']['User']['last_name']) ?></p>                   
                    <span>I would like to invite you to join my private network on Entropolis</span>
                    <ul>
                        <li><span class=""><?php echo date("M j, Y"); ?></span>|Personal Message:</li>
                    </ul>
                    
                     <?php if($type!= "Eluminati"){?>
                    <input type="hidden" name="data[UserInvitation][invitee_user_id]" value="<?php echo $adviceInfoData['ContextRoleUser']['User']['id'];?>">
                    <?php }else{?>
                    <input type="hidden" name="data[UserInvitation][invitee_user_id]" value="<?php echo $eluminati['Eluminati']['id'];?>">
                    <?php }?>

                    

                    <input type="hidden" name="data[UserInvitation][inviter_user_id]" value="<?php echo $this->Session->read('user_id'); ?>">
                   
                    <div class="form-group left">
                        <?php echo $this->Form->textarea('personal_message', array('class' => 'form-control', 'placeholder' => 'Message', 'label' => false, 'id' => 'personal_message', 'required')); ?>
                    </div>                        

                    <div class="add-comment-form-bottom <?php echo $modal_header_color;?>"><strong >From:</strong> <?php echo $this->Session->read('user_name'); ?></div>
                </div>
                
            </div>
            <div class="modal-footer">
                    <?php echo $this->Form->submit('Send', array('div' => false, 'class' => 'btn btn-black send_invitation_data')); ?>

                </div>
                

<?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>
<!--End modal for invitation-->

<!----------------- Start Thanks Message for Invitation -------->
<div class="modal fade" id="thanks-invitation" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" onclick = "javascript:jQuery('#thanks-invitation').modal('hide');"  aria-hidden="true"><i class="icons close-icon"></i></button>
                        <h4 class="modal-title" id="myModalLabel">GREAT!! AN INVITATION TO JOIN YOUR NETWORK HAS BEEN SENT TO</h4>
                         <?php if($type!= "Eluminati"){?>
                    <span><?php  echo strtoupper($adviceInfoData['ContextRoleUser']['User']['first_name'] . " " . $adviceInfoData['ContextRoleUser']['User']['last_name']) ?></span>
                    <?php }else{?>
                    <span><?php  echo strtoupper($eluminati['Eluminati']['first_name'] . " " . $eluminati['Eluminati']['last_name']) ?></span>
                    <?php }?>

                    </div>
                    <div class="modal-body ">                        
                         <p>Once your invitation has been accepted you will be alerted to any new advice from this Marketer so you can keep up to date.</p>
                   </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-black" onclick = "javascript:jQuery('#thanks-invitation').modal('hide');" >OK</button>
                        
                              </div>
                  </div>
                </div>
</div>
<!----------------- End Thanks Message for Invitation -------->

<!--Start modal for Send message-->
<div class="modal fade" id="send-message" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header <?php echo $modal_header_color;?> ">
                <button type="button" class="close" onclick = "javascript:jQuery('#send-message').modal('hide');" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">Send Message</h4>
            </div>
              <?php echo $this->Form->create('SendMessage', array('class' => '', 'id' => 'send_message')); ?>
            <div class="modal-body clearfix ">
              
                <div class=" clearfix <?php echo $modal_header_color;?>">
                   <div class="form-group clearfix">
                    <label class="col-sm-1 control-label">TO:</label>
                    <div class="col-sm-11">                        
                      <span><?php  echo strtoupper($adviceInfoData['ContextRoleUser']['User']['first_name'] . " " . $adviceInfoData['ContextRoleUser']['User']['last_name']) ?></span>

                     </div> 
                   </div>
                   <div class="form-group clearfix">
                    <label class="col-sm-1 control-label">From:</label>
                    <div class="col-sm-11">
                           <span><?php  echo $this->Session->read('user_name'); ?></span>
                    </div>
                  </div>
                    
                   <div class="form-group clearfix">
                    <label class="col-sm-1 control-label">RE:</label>
                    <div class="col-sm-11 reClass">
                    <?php if($type=='Advice'){?>

                           <span><?php echo date('D j F Y',strtotime($adviceInfoData['Advice']['advice_posted_date']));?></span>
                           <span><?php echo $adviceInfoData['Advice']['advice_title'];?></span>
                            <span><?php echo $adviceInfoData['DecisionType']['decision_type'];?>|<?php echo $adviceInfoData['Category']['category_name'];?></span>
                            <span>Last Updated: <?php echo date('j F Y',strtotime( $adviceInfoData['Advice']['advice_update_date']));?></span>
                            <?php }else{?>

                            <span><?php echo date('D j F Y',strtotime($adviceInfoData['Hindsight']['hindsight_posted_date']));?></span>
                           <span><?php echo $adviceInfoData['Hindsight']['hindsight_title'];?></span>
                            <span><?php echo $adviceInfoData['DecisionType']['decision_type'];?>|<?php echo $adviceInfoData['Category']['category_name'];?></span>
                            <span>Last Updated: <?php echo date('j F Y',strtotime( $adviceInfoData['Hindsight']['hindsight_update_date']));?></span>
                            <?php } ?>

                    </div>
                  </div>

                    <input type="hidden" name="data[SendMessage][invitee_user_id]" value="<?php echo $adviceInfoData['ContextRoleUser']['User']['id'];?>">
                    <input type="hidden" name="data[SendMessage][inviter_user_id]" value="<?php echo $this->Session->read('user_id'); ?>">
                   
                    <div class="form-group clearfix">
                      <label class="col-sm-1 control-label"></label>
                        <?php echo $this->Form->textarea('message', array('class' => 'col-sm-11 form-control', 'placeholder' => 'Message', 'label' => false, 'id' => 'message', 'required')); ?>
                    </div>                        

                </div>
                
            </div>
            <div class="modal-footer">
                    <?php echo $this->Form->submit('Send Message', array('div' => false, 'class' => 'btn btn-black send_invitation_data')); ?>

            </div>
                

<?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>
<!--End modal for Send message-->

<!----------------- Start Thanks Message for Sending message -------->
<div class="modal fade" id="thanks-message" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" onclick = "javascript:jQuery('#thanks-message').modal('hide');" aria-hidden="true"><i class="icons close-icon"></i></button>
                        <h4 class="modal-title" id="myModalLabel">MESSAGE SENT!</h4>
                    </div>
                    <div class="modal-body ">                        
                         <p>Your message has been sent to <?php  echo strtoupper($adviceInfoData['ContextRoleUser']['User']['first_name'] . " " . $adviceInfoData['ContextRoleUser']['User']['last_name']) ?>. Thank you for contacting the Advice|Marketer!!</p>
                   </div>
                      <div class="modal-footer">
                       <!--  <button type="button" class="btn btn-black" data-dismiss="modal">Return to ADVICE</button> -->
                        <button type="button" class="btn btn-black" onclick = "javascript:jQuery('#thanks-message').modal('hide');" >OK</button>
                              </div>
                  </div>
                </div>
</div>
<!----------------- End Thanks Message for Sending message -------->

<!----------------- Start Share Advice -------->
<div class="modal fade" id="share-advice" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" onclick = "javascript:jQuery('#share-advice').modal('hide');" aria-hidden="true"><i class="icons close-icon"></i></button>
                        <h4 class="modal-title" id="myModalLabel">Share Advice</h4>
                    </div>
                    <div class="modal-body">                        
                        <div class="addthis_sharing_toolbox"></div>
                   </div>
                      <div class="modal-footer">
                       <!--  <button type="button" class="btn btn-black" data-dismiss="modal">Return to ADVICE</button> -->
                        <button type="button" class="btn btn-black" onclick = "javascript:jQuery('#share-advice').modal('hide');" >OK</button>
                              </div>
                  </div>
                </div>
</div>
<!----------------- End Share Advice -------->


<script type="text/javascript">   
 jQuery("#AddOnlyCommentForm").submit(function(event){
        event.preventDefault();
        var datas=$(this).serialize();
        jQuery.ajax({
            type: 'POST',
            url: "<?php echo Router::url(array('controller' => 'Advices', 'action' => 'addComment')) ?>",
            data: datas,
            success: function(resp) {
                if (resp.result == 'success') {
                    $("#add-comment").modal('hide');
                    $("#thanks-msg").modal('show');
                }
                else{
                    return false;
                }
            }
        });
    });

    
    jQuery("#AddCommentForm").submit(function(event){
        event.preventDefault();
        var datas=$(this).serialize();
        jQuery.ajax({
            type: 'POST',
            url: "<?php echo Router::url(array('controller' => 'Advices', 'action' => 'addComment')) ?>",
            data: datas,
            success: function(resp) {
                if (resp.result == 'success') {
                    $("#add-rating").modal('hide');
                    $("#thanks-rating").modal('show');
                }
                else{
                    return false;
                }
            }
        });
    });

    jQuery("#send_invitation").submit(function(event){
        event.preventDefault();
        var datas=$(this).serialize();
        jQuery.ajax({
            type: 'POST',
            url: "<?php echo Router::url(array('controller' => 'pages', 'action' => 'addInvitation')) ?>",
            data: datas,
            success: function(resp) {
                if (resp.result == 'success') {
                    $("#invite-user").modal('hide');
                    $("#thanks-invitation").modal('show');
                }
                else{
                    return false;
                }
            }
        });
    });
    jQuery("#send_message").submit(function(event){
        event.preventDefault();
        var datas=$(this).serialize();
        jQuery.ajax({
            type: 'POST',
            url: "<?php echo Router::url(array('controller' => 'pages', 'action' => 'SendMessage')) ?>",
            data: datas,
            success: function(resp) {
                if (resp.result == 'success') {
                    $("#send-message").modal('hide');
                    $("#thanks-message").modal('show');
                }
                else{
                    return false;
                }
            }
        });
    });

    </script>

  <script type="text/javascript">
  var attach = {};
    //--------------------------- Attachments (File Upload)


    attach = {
        button: $('.atch-button'),
        wrapper: $('.atch-wrapper'),
        newFileButton: $('.atch-new-box'),
        newFile: $('.atch-new'),
        tempObject: null,
        bindUploader: function(object){ 

            if(!object || typeof object == 'undefined') return;
            object.fileupload({
                dataType: 'json',
                async:false,
                add: function (e, data) {
                    //console.log(data);
                    var goUpload = true;
                    var uploadFile = data.files[0];
                    //alert(uploadFile.name);
                   
                    if (goUpload == true) {                                 
                        var img = data.submit();
                        var imgName = img.responseText;
                        //console.log(img.responseText);
                        var newdata = imgName.split('~');
                        var str = '<div class="upload-post-img"><div class="close-img"></div><img class="add-post-img img-thumbnail" src="<?php echo Router::url('/', true); ?>'+newdata[0]+'" width="80" height="80">\n\
<input type="hidden" name="filesPath[]" value="'+newdata[1]+'"></div>';
                        
                        //$('.upload-progress-value').html(str);
                        $(str).appendTo('.image-bind');
                       
                    }
                },
                
                progressall: function (e, data) {
                    var $this = $(this);
                    
                    var progress = parseInt(data.loaded / data.total * 100, 10);    
                    $('.upload-progress-wrapper:hidden').fadeIn(100);   
                    $('.upload-progress-wrapper').find('.upload-progress-value span').text(progress);
                    console.log(data);
                }
            });
        } 
    }; 
   
    attach.newFile.each(function(){     
        attach.bindUploader($(this));
    });
 


$(document).ready(function(){
       $('.image-bind').on('click', '.close-img', function(){
        var $this = $(this),
        imgWrap = $this.closest('.upload-post-img'),
        imgName = imgWrap.find('.add-post-img').attr('src');
        imgName = imgName.split('upload/')[1];
        imgName = 'upload/'+imgName;
        bootbox.dialog({
            message: "Are you sure you want to delete this image ?",            
            buttons: {
                success: {
                    label: "Yes",
                    className: "btn-black",
                    callback: function() {
                        var datas = {'imgName':imgName} 
                        $.ajax({
                           type:'POST',
                           url:'<?php echo Router::url(array('controller'=>'escenes', 'action'=>'delete_post_image'));?>',
                           data:datas,
                           success:function(resp){
                               imgWrap.remove();
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
    
});

$(document).ready(function(){
   /*------ Start To apend footer modal here --------------*/
   $('.modal-footer').on('click', function(){
         var datas = {obj_id:'<?php echo $obj_id;?>', obj_type:'<?php echo $type;?>'};
//         jQuery.ajax({
//            type: 'POST',
//            url: "<?php echo Router::url(array('controller' => 'Pages', 'action' => 'loadFooterModal')) ?>",
//            data: datas,
//            success: function(resp) {
//                if (resp) {
//                    resp = '<div>'+resp+'</div>';
//                    $(resp).insertAfter(".footer-modal-apend");
//                    
//                }
//                else{
//                    return false;
//                }
//            }
//        });
   });
 });
   /*------ End To apend footer modal here --------------*/
</script>

E|Luminati Wisdom