<?php 
if(!empty($adviceInfoData)){?>
<script type="text/javascript">
     $(":file.custom-filefield").filestyle({buttonBefore: true});
</script>
<div class="row advice_user_id"  data-context = "<?php echo $adviceInfoData['EluminatiDetail']['eluminati_id'] ?>"  >
    <div class="col-lg-12">
        <div class="profile_detail relative">
            <div class="profile-img-blck profile_img">
                <?php 
        $obj_id = $adviceInfoData['EluminatiDetail']['id'];
        $obj_type = 'Eluminati';
        if($eluminati['Eluminati']['image_url'] != ''){?>
<!--        <img src="img/deve.jpg" alt="">-->
        <img src="<?php echo $this->Html->url('/'). $this->Image->resize($eluminati['Eluminati']['image_url'], 250, 250, true);?>" alt="" class="resize-image"/>
   <?php } else{ ?>
       <img   src="<?php echo $this->Html->url('/'). $this->Image->resize('img/dummy-pic.png',250, 250, true);?>" alt=""/>
       <?php  }  ?> 
       
       <div class="profile-title-block"> 
        <div class="profile-title">
           <?php echo $this->Html->image('e-SP.png');?>
           <!--  <div class="profile-title-name"><h1>E|LUMINATI WISDOM</h1></div> -->

        </div>
    </div>
            </div>
            
            <div class="advice_edit profile_detail_view break">
      
<!--            To set some data as hidden-->
            <input type="hidden" class="eluminati-detail-id" value="<?php echo $adviceInfoData['EluminatiDetail']['id'];?>">
            
            <h2><span><?php echo $eluminati['Eluminati']['first_name'].' '. $eluminati['Eluminati']['last_name'];?></span>   
                <ul class="roboto_light advice-bdr">
                    <li><a href="#">Total Wisdom: <strong> <?php echo $total_advice_count;?> </strong></a></li>
                    <li><a href="#" class= "avg-rating">AVG Rating: <strong><?php echo $this->Rating->eluminatiTotalAverageRating($adviceInfoData['EluminatiDetail']['eluminati_id']);?>/10 </strong></a></li>
                </ul>
            </h2>
            <span class="h4tag roboto_medium" title="<?php echo $adviceInfoData['EluminatiDetail']['source_name'];?>" ><?php echo trim($adviceInfoData['EluminatiDetail']['source_name']);?><a href="<?php echo $adviceInfoData['EluminatiDetail']['source_rss_feed'];?>" target = "_blank"><?php echo $this->Html->image('svg-icons/white-link.svg');?></a></span>
            <span><strong>Category: </strong><?php echo $adviceInfoData['DecisionType']['decision_type'];?>|<?php echo $adviceInfoData['Category']['category_name']; ?></span>
            <span><strong>Published On: </strong><?php echo date('M j, Y', strtotime($adviceInfoData['EluminatiDetail']['date_published'])); ?></span>
            <span><strong>Last Updated On: </strong><?php echo date('M j, Y', strtotime($adviceInfoData['EluminatiDetail']['added_on'])); ?></span>                                
            <ul class="top-notify">
                <li><a href="#"><strong>Views: </strong> <?php echo $adviceInfoData['EluminatiDetail']['view_status'];?></a></li><li><a href="#" class= "eluminati-rating"><strong>Rating:</strong> <?php echo $this->Rating->eluminatiRatingCount($adviceInfoData['EluminatiDetail']['id']);?>/10</a></li>
            </ul>
       
    </div> 
            
        </div>
    </div>
</div>                       
</div>
<div class="notification-bar">
    <section class="slider">
        <div class="flexslider carousel">
            <ul class="slides">
         <?php $i = 0;
               foreach($all_eluminati as $eluminatiDetail){ 
                   $i == 0? ($active ='active') : ($active = '');
                   ?>
                
                 <li class="<?php echo $active;?>" data-id="<?php echo $eluminatiDetail['EluminatiDetail']['id'];?>">
                  <!-- <a href="<?php echo $adviceInfoData['EluminatiDetail']['source_rss_feed'];?>" target = "_blank"><?php echo $this->Html->image('svg-icons/blue-link.svg');?><?php echo $this->Eluminati->text_cut($eluminatiDetail['EluminatiDetail']['source_name'], $length = 40, $dots = true); ?></a> -->
                </li>
            <?php $i++; } ?> 
            </ul>
        </div>
    </section>
</div>

<div class="row">
        <div class="col-md-12 ">
            <div class="col-md-12 profile_biography containerHeight custom_scroll">
                <div class="popups_detail_blocks">
                    <h4 class="small_title">Tag Line</h4>
                    <?php 
                      echo nl2br($adviceInfoData['EluminatiDetail']['tag_line']);?>
                </div>
                
                <div class="popups_detail_blocks">
                    <h4 class="small_title">Executive Summary</h4>
                    <?php
                            if(strlen($adviceInfoData['EluminatiDetail']['summary']) > 300)
                            {?>
                          <div class=" person-content short-data "><?php 
                              // echo substr($post['Escene']['post_description'], $remaining-1 );  
                              $actual_lenth = strlen(trim($adviceInfoData['EluminatiDetail']['summary'])); 
                              echo nl2br($this->Eluminati->text_cut($adviceInfoData['EluminatiDetail']['summary'], $length = 300, $dots = true)); 
                              $later_length =  strlen(trim($this->Eluminati->text_cut($adviceInfoData['EluminatiDetail']['summary'], $length = 300, $dots = true)));?></b></strong></a></em></i>
                          <div class=" person-content full-data hide"  data-to="1"> <?php echo  nl2br($adviceInfoData['EluminatiDetail']['summary']);  ?></div>  
                              <?php if( $actual_lenth != $later_length ){?>
                                             <a href="#1" class="right btn-readmorestuff">Read more</a>
                                         <?php } ?><?php } else{?>
                              <div class=" person-content short-data "><?php 
                              echo nl2br($this->Eluminati->text_cut($adviceInfoData['EluminatiDetail']['summary'], $length = 300, $dots = true));?>
                            </div>
                           <?php  }?>
                          </div>
                            
                </div>
                
                <div class="popups_detail_blocks">
                    <h4 class="small_title">The Entrepreneurship Challenge</h4>
                    <?php
                  if(strlen($adviceInfoData['EluminatiDetail']['challenge_addressing']) > 300)
                  {?>
                <div class=" person-content short-data"><?php 
                    // echo substr($post['Escene']['post_description'], $remaining-1 );  
                    $actual_lenth = strlen(trim($adviceInfoData['EluminatiDetail']['challenge_addressing'])); 
                    echo nl2br($this->Eluminati->text_cut($adviceInfoData['EluminatiDetail']['challenge_addressing'], $length = 300, $dots = true)); 
                    $later_length =  strlen(trim($this->Eluminati->text_cut($adviceInfoData['EluminatiDetail']['challenge_addressing'], $length = 300, $dots = true)));?></div>
                  <div class=" person-content full-data hide"  data-to="1"> <?php echo  nl2br($adviceInfoData['EluminatiDetail']['challenge_addressing']);  ?></div>  
                    <?php if( $actual_lenth != $later_length ){?>
                                   <a href="#1" class="right btn-readmorestuff">Read more</a>
                               <?php } ?><?php                  }
                  else{?>
                    <div class=" person-content short-data"><?php 
                    echo nl2br($this->Eluminati->text_cut($adviceInfoData['EluminatiDetail']['challenge_addressing'], $length = 300, $dots = true));?>
                  </div>
                 <?php }?>
                </div>
                
                <div class="popups_detail_blocks">
                    <h4 class="small_title">Key Advice Points</h4>
                    <div class="person-content short-data">
                        <?php 
                   echo nl2br($adviceInfoData['EluminatiDetail']['key_advice_points']);?>
                    </div>
                    
                </div>
                
                <?php count($attachments) > 0 ? ($display = '') : ($display = 'none'); ?>
                <div class="popups_detail_blocks" style="display:<?php echo $display;?>">
                    <h4 class="small_title">Attachments</h4>
                    <div class="row">
                            <div class="col-md-6">
                                <div class="">
                                    <h4 class="roboto_medium">Images</h4>
                                    <div class="image-wrap">
                           <?php foreach($attachments as $key=>$images){ 
                                    if($images['Attachment']['file_type'] == 'image'){
                                        $mainImage = str_replace('thumb_', '', $images['Attachment']['image_url']);
                                        ?>
                                        <div class="img-section row-wrap" data-id="<?php echo $images['Attachment']['id'];?>">
                                    <?php if(strtoupper(@$this->Session->read('roles')) == 'ADMINISTRATOR') { ?> 
                                            <div class="close-img"></div>
                                    <?php } ?>   
                                            <a target="_blank" href="<?php echo $this->Html->url('/', true).$mainImage;?>">
                                     
                                      <img src="<?php echo $this->Html->url('/', true).$images['Attachment']['image_url'];?>" alt=""></a>
                                    </div>
                                   
                                 <?php }
                                } ?> 
                                </div>
                                </div>


                            </div>
                            <div class="col-md-6">
                                <div class="">
                                    <h4 class="roboto_medium">Documents</h4>
                                     <div class="doc-wrap">
                                    
                         <?php foreach($attachments as $key=>$images){ 
                                    if($images['Attachment']['file_type'] != 'image'){
                                        if($images['Attachment']['file_type'] == 'doc' || $images['Attachment']['file_type'] == 'docx'){ ?>
                                        <div class="doc-section row-wrap" data-id="<?php echo $images['Attachment']['id'];?>"> 
                                    <?php if(strtoupper(@$this->Session->read('roles')) == 'ADMINISTRATOR') { ?> 
                                            <div class="close-img"></div>
                                    <?php } ?>        
                                            <a target="_blank" href="<?php echo $this->Html->url('/', true).$images['Attachment']['image_url'];?>">
                                                <i><?php echo $this->Html->image('doc.png');?></i><?php echo $images['Attachment']['file_name'];?></a>  
                                        </div>                                
                                    <?php } 
                                        else if($images['Attachment']['file_type'] == 'pdf'){ ?>
                                         <div class="doc-section row-wrap" data-id="<?php echo $images['Attachment']['id'];?>"> 
                                     <?php if(strtoupper(@$this->Session->read('roles')) == 'ADMINISTRATOR') { ?> 
                                            <div class="close-img"></div>
                                      <?php } ?>   
                                            <a target="_blank" href="<?php echo $this->Html->url('/', true).$images['Attachment']['image_url'];?>">
                                                <i><?php echo $this->Html->image('pdf.png');?></i><?php echo $images['Attachment']['file_name'];?></a>
                                          </div>
                                <?php   }
                                        else{ ?>
                                         <div class="doc-section row-wrap" data-id="<?php echo $images['Attachment']['id'];?>"> 
                                    <?php if(strtoupper(@$this->Session->read('roles')) == 'ADMINISTRATOR') { ?> 
                                            <div class="close-img"></div>
                                     <?php } ?>   
                                            <a target="_blank" href="<?php echo $this->Html->url('/', true).$images['Attachment']['image_url'];?>">
                                                <i><?php echo $this->Html->image('blank_page_icon.png');?></i><?php echo $images['Attachment']['file_name'];?></a>
                                          </div>
                                       <?php
                                        }
                                    }
                                } ?>     
                                 
                                </div>
                                </div>
                            </div>
                        </div>
                </div>
                
                <?php if(empty($latestComment)){ $dispCom = 'none'; }else{ $dispCom = ''; } ?>
                 <div class="popups_detail_blocks eluminati_comment-show-panel" style="display:<?php echo $dispCom; ?>">
                    <h4 class="small_title">Comments</h4>
                    <div class="media">
                     <?php //if(!empty($latestComment)){ ?>
                       
                    <?php if($commUserAvatar != ''){?>  
                            <a class="media-left media-middle" href="#">
                            <img src="<?php echo $this->Html->url('/'). $this->Image->resize($commUserAvatar, 60, 60, false);?>" class="comm-user-image">
                            </a>
                    <?php } else if(!empty($latestComment['EluminatiComment'])) {?> 
                         <a class="media-left media-middle" href="#">
                    <img   src="<?php echo $this->Html->url('/'). $this->Image->resize('img/dummy-pic.png', 60, 60, false);?>" alt=""/>    
                    </a>
                            <!-- <img src="<?php //echo $this->Html->url('/').'upload/60x60_dummy-pic.png';?>" class="comm-user-image"> -->
                            <?php //echo $this->Html->image('image1.jpg', array('class'=>'comm-user-image'));?>
                    <?php } ?>     
                        
                        <div class="media-body">
                        <?php // To get user name by user id
                             $userName = @$this->User->userName($latestComment['EluminatiComment']['user_id']);?>
                            <h4 class="media-heading comm-user-name roboto_medium"><?php echo $userName;?><span><?php echo @$latestComment['EluminatiComment']['added_on']!= '' ? date('M j, Y', strtotime($latestComment['EluminatiComment']['added_on'])) : '';?></span></h4>
                            
                            <?php
                            if(strlen(@$latestComment['EluminatiComment']['comments']) > 300)
                            {?>
                          <p class=" person-content short-data show-comment"><?php 
                              // echo substr($post['Escene']['post_description'], $remaining-1 );  
                              $actual_lenth = strlen(trim(@$latestComment['EluminatiComment']['comments'])); 
                              echo nl2br($this->Eluminati->text_cut(@$latestComment['EluminatiComment']['comments'], $length = 300, $dots = true)); 
                              $later_length =  strlen(trim($this->Eluminati->text_cut(@$latestComment['EluminatiComment']['comments'], $length = 300, $dots = true)));?></p>
                            <p class=" person-content full-data hide show-comment"  data-to="1"> <?php echo  nl2br(@$latestComment['EluminatiComment']['comments']);  ?></p>  
                              <?php if( $actual_lenth != $later_length ){?>
                                             <a href="#1" class="right btn-readmorestuff">Read more</a>
                                         <?php } ?><?php } else{?>
                              <p class=" person-content short-data show-comment"><?php 
                              echo nl2br($this->Eluminati->text_cut(@$latestComment['EluminatiComment']['comments'], $length = 300, $dots = true));?>
                            </p>
                           <?php  }?>
                            
                        </div>
                     <?php //} ?>   
                    </div>


                   <?php    if($total_comment_count>1){?>
                    <a class="right btn btn-orange load-more-eluminati-comment" data-totalcount = '<?php echo $total_comment_count-1; ?>' data-count ='<?php echo $total_comment_count-1; ?>' data-startlimit= "0" data-id= "<?php echo $latestComment['EluminatiComment']['eluminati_detail_id']; ?>" data-totalshow = "1">Load More</a>

                        <?php } ?>
                </div>
            </div>
        </div>
    </div>


                                <div class="bottom-wrap">
                                <div class="show-detail comment">
                                    <h5>Add your comment here<span><i class="icons close-grey-icon close-comment"></i></span></h5>
                                    <form onsubmit="return false">
                                        <!--                     To set logged in user image as -->
                                        <?php if($avatar != ''){ ?>
                                        <input type="hidden" class="logged-in-user-img" value="<?php echo $this->Html->url('/'). $this->Image->resize($avatar, 60, 60, true);?>">
                                        <?php } else{ ?>
                                        <input type="hidden" class="logged-in-user-img" value="<?php echo $this->Html->url('/').'upload/60x60_dummy-pic.png';?>">  
                                        <?php }   ?>
                                        <textarea class="form-control post-comment" rows="3" placeholder="Comments" required="required"></textarea>
                                        
                                        <button type="submit" class="btn btn-default submit-comment">Comment</button>
                                    </form>
                                </div>
                                <div class="show-detail rate">
                                    <div class="error-message alert-danger" style="display: none"></div>
                                    <h5>I found this wisdom to be:<span><i class="icons close-grey-icon"></i></span></h5>
                                    <div class="share-rate text-blue">
                                        <div class="rate-checkbox">
                                            <div class="radio-btn">
                                                <input id="eluminati-excellent" type="radio" class="rating" checked= "checked" name="rating" value="10">
                                                <label class="custom-radio checkbox-btn-padding" for="eluminati-excellent">Excellent</label>
                                            </div>
                                            <div class="radio-btn">
                                                <input id="eluminati-vgood" type="radio" class="rating" name="rating" value="8">
                                                <label class="custom-radio checkbox-btn-padding" for="eluminati-vgood">Very Good</label>
                                            </div>
                                            <div class="radio-btn">
                                                <input id="eluminati-good" type="radio" class="rating" name="rating" value="6">
                                                <label class="custom-radio checkbox-btn-padding" for="eluminati-good">Good</label>
                                            </div>
                                            <div class="radio-btn">
                                                <input id="eluminati-better" type="radio" class="rating" name="rating" value="4">
                                                <label class="custom-radio checkbox-btn-padding" for="eluminati-better">Could be better</label>
                                            </div>
                                            <div class="radio-btn">
                                                <input id="eluminati-terrible" type="radio" class="rating" name="rating" value="2"> 
                                                <label class="custom-radio checkbox-btn-padding" for="eluminati-terrible">Terrible</label>
                                            </div>
                                        </div>
                                        <form action="">
                                            <h5>Comments <i style="color:#817b7b">(optional)</i></h5>
                                            <textarea class="form-control opt-comment" rows="3" placeholder="Comments"></textarea>
                                            <button type="button" class="btn btn-default comment-rating">Send Rating</button>
                                        </form>
                                    </div>
                                </div>
                                <div class="show-detail attach">
                                    <h5>Documents/Images<span><i class="icons close-grey-icon dialog-close"></i></span></h5>
                                    <div class="attach-wrap">
                                       <?php echo $this->Form->create('Attachment',array('type' => 'file', "id"=>"attachment-handler")) ?>   
                                             <input type="hidden" name="obj_id" value="<?php echo $obj_id;?>" />
                                             <input type="hidden" name="obj_type" value="<?php echo $obj_type;?>" />  
                                             <input type="file" data-buttonbefore="true" id="fileToUpload" name="fileToUpload[]" multiple="true" class="filestyle custom-filefield">
                                            <?php //echo $this->Form->input('image_url', array('type' => 'file', 'class' => 'filestyle custom-filefield', 'data-buttonBefore'=>true,'label' => false,'multiple'=>'multiple')); ?>

                                           <button type="submit" class="btn btn-default attached-upload">Submit</button>  
                                             <?php echo $this->Form->end();?>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="modal-footer align-center modal-bottom-strip bottom-icon">
                                    <div class="modal-footer_actionlinks">
                         <?php if($this->Session->read('user_id')) {?>
                                    <a href="#" data-open="<?php echo $this->Session->read('user_id') ? 'comment' :('#');?>"><i class="icons comment" data-toggle="tooltip" data-placement="top" title="Add Your Comment"></i></a>
                                    <a href="#" data-open="<?php echo $this->Session->read('user_id') ? 'rate' :('#');?>"><i class="icons star" data-toggle="tooltip" data-placement="top" title="Rating"
                                    ></i></a>
                             <?php if(strtoupper($this->Session->read('roles')) == 'ADMINISTRATOR') { ?>    
                                        <a href="#" data-open="attach"><i class="icons library" data-toggle="tooltip" data-placement="top" title="My Library"></i></a>  
                             <?php } ?> 

                             <a class = "attach-library" data-type = "Eluminati" data-owner = "<?php echo $adviceInfoData['EluminatiDetail']['eluminati_id'];?>"data-id = "<?php echo $adviceInfoData['EluminatiDetail']['id']; ?> "><i class="icons library" data-toggle="tooltip" data-placement="top" title="My Library"></i></a>      
                          <?php }
                                else{?>
                                    <a href="<?php echo Router::url(array('controller'=>'users', 'action'=>'login'));?>" data-open=""><i class="icons comment" data-toggle="tooltip" data-placement="top" title="Add Your Comment"></i></a>
                                    <a href="<?php echo Router::url(array('controller'=>'users', 'action'=>'login'));?>" data-open=""><i class="icons star" data-toggle="tooltip" data-placement="top" title="Rating"
                                    ></i></a>
                                     <a href="<?php echo Router::url(array('controller'=>'users', 'action'=>'login'));?>"><i class="icons library" data-toggle="tooltip" data-placement="top" title="My Library"></i></a>
                        <?php   } ?>      
                                     </div>
                                </div>
<script>
$(function () {   
    $('.collapse').collapse({		  
        toggle: false
    });
    
    // To find out current eluminati detail
    var eluminatiDetailId = $('.eluminati-detail-id').val();
    var slideIndex = $('.slides').find("[data-id='"+eluminatiDetailId+"']").index();
    //alert(eluminatiDetailId);
    jQuery("#eluminati-popup").find('.flexslider').flexslider({
        animation: "slide",
        controlNav: false,
        slideshow:false,
        animationLoop: false,
        itemWidth:450,
        itemMargin:0,  
         prevText:"PREVIOUS ARTICLE",
        nextText:"NEXT ARTICLE",
        slideshowSpeed: 10000, 
        startAt:slideIndex,
         start: function(slider){
          $('.flexslider').resize();
        },
        after: function(slider){
            var curSlidePos = slider.currentSlide;
            // To remove active class from all ul li
            $('.slides > li').removeClass('active');                
            $('.slides > li').eq(curSlidePos).addClass('active');
            var currentEluminatiDetailId = $('.slides > li.active').data('id');
            //alert(currentEluminatiDetailId);
            // $('.slides .active').parent('li').addClass('active').siblings().removeClass('active');
             $('.page-loading-ajax').height($(window).height());                 
             $('.page-loading-ajax').show();
            
            var obj_id = currentEluminatiDetailId;
            

            jQuery.ajax({
                  type :'POST',
                  url:'<?php echo Router::url(array('controller'=>'pages', 'action'=>'getEluminatiModal'));?>',
                    'data':{
                     'obj_id':obj_id,            
                     
                    },
                  'success':function(data){   
                     $('.page-loading-ajax').hide();             
                 console.log('testing');

                       jQuery("#eluminati-popup").find('.tab-content .eluminati-detail-data').html(data); 
                       
                       containerHeight('.containerHeight');
                    customScroll();
                     $('[data-toggle="tooltip"]').tooltip();


                  }    

             });                
                        

        }
    });     

});
</script>    

<?php } ?>