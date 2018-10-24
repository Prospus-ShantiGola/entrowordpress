
<script type="text/javascript">


     /* $( 'textarea.executive-summary' ).ckeditor();
      $( 'textarea.challenge-addressing' ).ckeditor();
      $( 'textarea.key-advice-points' ).ckeditor();*/
      
</script>
<div class="row advice_user_id" data-userid = "<?php echo $adviceInfoData['ContextRoleUser']['User']['id'] ?>" data-context = "<?php echo $adviceInfoData['ContextRoleUser']['id'] ?>" >
    <div class="col-md-12">
        <div class="profile_detail relative">
            <div class="profile-img-blck profile_img"> <?php 
  
               $obj_id = $adviceInfoData['Advice']['id'];
               $obj_type = 'Advice';
               $adv_type = '';

                if($adviceInfoData['Blog']['blog_type']) {
                  $adv_type = $adviceInfoData['Blog']['blog_type'];
                }
                if($adviceInfoData['Advice']['executive_summary']) {
                  $adv_type = 'Blog';
                } else if($adviceInfoData['Advice']['feature_blog']) {
                  $adv_type = 'Feature';
                };
              
              if($adviceInfoData['ContextRoleUser']['User']['user_image']) {
                $user_image = $adviceInfoData['ContextRoleUser']['User']['user_image'];?>
                <img src="<?php echo $this->Html->url('/'). $this->Image->resize($user_image, 250, 250, true);?>" alt="" class="resize-image"/>
           <?php   }else { ?>
                <img   src="<?php echo $this->Html->url('/').$this->Image->resize('img/dummy-pic.png' , 250, 250, true);?>" alt="" class="resize-image" />     
         <?php  }
              ?>
                
                <div class="profile-title-block">
        <div class="profile-title">
            
              <?php  
       if($adviceInfoData['ContextRoleUser']['context_role_id']=='6')
       {
        echo $img = $this->Html->image('sage-gray.png');
        }
      elseif($adviceInfoData['ContextRoleUser']['context_role_id']==PARENT_CONTEXT_ID)
      {
       echo $img = $this->Html->image('sage-icon1.svg');
      }
      else
      {

       echo $img = $this->Html->image('t-sp.svg');

       }
      ?>
             <!--  <img src="/entropolis/img/sage-icon1.svg" alt=""> -->
            </div>
            <!-- <div class="profile-title-name"><h1>Sage Advice</h1></div> -->
            
        </div>
               </div>
            <div class="profile_detail_view advice_edit custom_scroll">
        <div class="">
            <h2>

<input type="hidden" class="obj-id" value="<?php echo $adviceInfoData['Advice']['id'];?>">
<input type="hidden" class="adv-type" value="<?php echo $adv_type;?>">
              <span class= "sage-name">

             <!--    <?php   
                     if(strlen($adviceInfoData['ContextRoleUser']['User']['first_name']." ".$adviceInfoData['ContextRoleUser']['User']['last_name']) > 10)
                    {

                    echo $this->Eluminati->text_cut($adviceInfoData['ContextRoleUser']['User']['first_name']." ".$adviceInfoData['ContextRoleUser']['User']['last_name'], $length = 5, $dots = true); }else{
          echo $this->Eluminati->text_cut($adviceInfoData['ContextRoleUser']['User']['first_name']." ".$adviceInfoData['ContextRoleUser']['User']['last_name'], $length = 5, $dots = true);

                } ?> -->
<!--  <?php //echo $this->Eluminati->text_cut($adviceInfoData['ContextRoleUser']['User']['first_name']." ".$adviceInfoData['ContextRoleUser']['User']['last_name'], $length = 4, $dots = true);?> -->

  <?php echo $adviceInfoData['ContextRoleUser']['User']['username'];//$adviceInfoData['ContextRoleUser']['User']['first_name']." ".$adviceInfoData['ContextRoleUser']['User']['last_name'];?>

              </span>   
                <ul class="advice-bdr">
                    <li><a href="#">Total Advice:<strong> <?php echo $total_advice_count;?></strong> </a></li>                  
                    <li><a href="#" class= "average-rating">AVG Rating: <strong> <?php echo $this->Rating->getRatingAllAdvice($adviceInfoData['ContextRoleUser']['id']); ?>/10 </strong> </a></li>
                </ul>
            </h2>
            <input type ="hidden" value = "<?=$adviceInfoData['Advice']['advice_title'];?>" class= "sage-title">
             <input type ="hidden" value = "<?php echo $adviceInfoData['DecisionType']['decision_type'];?>" class= "sage-category">
              <input type ="hidden" value = "<?php echo date('D j F Y',strtotime($adviceInfoData['Advice']['advice_decision_date']));?>" class= "sage-published">
               <input type ="hidden" value = "<?php echo date('D j F Y',strtotime($adviceInfoData['Advice']['advice_update_date']));?>" class= "sage-updated">
               <div class="form-group">
                   <p class="txt-wrapper clearfix"><strong class="txt-left">Advice Title:</strong> 
                   <input type ="text" value="<?php echo $adviceInfoData['Advice']['advice_title'];?>" class="sage-title-inp form-control" name="sage_title">
                   <span class="error-message"> </span>
               </p>
               </div>
               
               <div class="form-group">
                   <span class="txt-wrapper clearfix"><strong class="txt-left">Category*:</strong>
            <!--     <select name="decision_type_id" class="decision-types form-control">
          <?php  foreach($decisionTypes as $key=>$decType){ ?>
                    <option value="<?php echo $decType['DecisionType']['id'];?>" 
                        <?php echo $adviceInfoData['DecisionType']['id'] == $decType['DecisionType']['id'] ? 'selected' : '' ;?>>
                   <?php echo $decType['DecisionType']['decision_type'];?></option>
                    <?php
                }?>
                </select>  -->


                 <?php echo $this->Form->input('decision_type_id', array('options' => $decisionTypes, 'id' => 'decision_type_id', 'class' => 'decision-types form-control width-100', 'label' => false, 'empty' => 'Category*', 'data-toggle' => 'popover', 'data-placement' => 'bottom','value' => $adviceInfoData['DecisionType']['id'])); ?>
                   <span class="error-message"> </span>
            </span>
               </div>
               <div class="form-group">
                   <p class="txt-wrapper clearfix"><strong class="txt-left">Sub-Category*:</strong>
                <select name="category_id" class="category-id form-control">
                    <option value="">Sub-Category*</option>
          <?php  foreach($categoryList as $key=>$category){ ?>
                    <option value="<?php echo $category['Category']['id'];?>" 
                        <?php echo $adviceInfoData['Category']['id'] == $category['Category']['id'] ? 'selected' : '' ;?>>
                   <?php echo $category['Category']['category_name'];?></option>
                    <?php
                }?>
                </select>
                <span class="error-message"> </span>
            </p>
               </div>
                   
               <div class="form-group">
                   <p class="txt-wrapper clearfix"><strong class="txt-left">Published On:</strong>
                <input type="text" value="<?php echo date('m/d/Y', strtotime($adviceInfoData['Advice']['advice_decision_date']));?>" name="advice_decision_date" class="form-control calender fa fa-calendar" disable="disable" id="datepicker_advice" readonly autocomplete="off"/>
                <span class="error-message"></span>
            </p> 
               </div>  
               
<!--            <p><strong>Published On:</strong><?php echo date('D j F Y',strtotime($adviceInfoData['Advice']['advice_decision_date']));?></p>-->
            
               <p class="txt-wrapper clearfix"><strong>Last Updated On:</strong><?php echo date('M j, Y',strtotime($adviceInfoData['Advice']['advice_update_date']));?></p>                                
            <ul class="top-notify">
                <li><a href="#"><strong>Views:</strong> <?php echo $advice_views; ?></a></li>
                <li><a href="#" class= "total-rating"><strong>Rating:</strong> <?php echo $this->Rating->getRating($adviceInfoData['Advice']['id']); ?>/10</a></li>
            </ul>
        </div>
    </div> 
        </div>
    </div>                       
</div>
<div class="notification-bar">
    <section class="slider">
        <div class="flexslider carousel">
<!--  <ul class="slides">      

            <?php foreach($all_advice as $advicedetail){
              ?>
             <li><a href="#"><?php echo $this->Html->image('svg-icons/blue-link.svg');?><?php echo $this->Eluminati->text_cut($advicedetail['Advice']['advice_title'], $length = 40, $dots = true); ?></a></li>
            <?php } ?> 
       
            </ul>  
 -->


              <ul class="slides">
         <?php $i = 0;
               foreach($all_advice as $advicedetail){ 
                   $i == 0? ($active ='active') : ($active = '');
                   ?>
                
           
                    <li class="<?php echo $active;?>" data-advice-type="<?php echo $advicedetail['Blog']['blog_type']; ?>" data-id="<?php echo $advicedetail['Advice']['id'];?>"> 
<!--                  <a href="<?php echo $adviceInfoData['Advice']['source_url'];?>" target="_blank"><?php echo $this->Html->image('svg-icons/blue-link.svg');?><?php echo $this->Eluminati->text_cut($advicedetail['Advice']['advice_title'], $length = 35, $dots = true); ?></a>-->
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
                <h4 class="small_title">Snapshot</h4>
                <?php  $exSummary = html_entity_decode($adviceInfoData['Advice']['executive_summary']);?>
                      <div class="person-content short-data txt-wrapper">
<!--                          <div class="editable executive-summary"><?php //echo $exSummary;?></div>-->
                         <textarea name="editor1" class="executive-summary" id="executive-summary" rows=""><?php echo $exSummary;?></textarea>
<!--                         <script> CKEDITOR.replace( 'editor1' ); </script>-->
                          <span class="error-message"> </span>
                    </div> 
            </div>
            <div class="popups_detail_blocks">
                <h4 class="small_title">The Entrepreneurship Challenge</h4>
                <div class=" person-content short-data">
<!--                      <div class="editable challenge-addressing"><?php //echo $adviceInfoData['Advice']['challenge_addressing'];?></div>-->
                      <textarea name="editor2" class="challenge-addressing"><?php echo $adviceInfoData['Advice']['challenge_addressing'];?></textarea>
<!--                     <script> CKEDITOR.replace( 'editor2' ); </script>-->
                  </div>
            </div>
            
            <div class="popups_detail_blocks">
                <h4 class="small_title">Key Advice Points</h4>
                <div class=" person-content short-data">
<!--                     <div class="editable key-advice-points"><?php //echo $adviceInfoData['Advice']['key_advice_points'];?></div>-->
                     <textarea name="key_advice_points" class="key-advice-points"><?php echo $adviceInfoData['Advice']['key_advice_points'];?></textarea>
                     
                 </div>
            </div>
            
            <?php count($attachments) > 0 ? ($display = '') : ($display = 'none'); ?>
            <div class="popups_detail_blocks" style="display:<?php echo $display;?>">
                <h4 class="small_title">Attachments</h4>
                <div class="row">
                        <div class="col-md-6">
                            <div class="">
                                <h4 class="roboto_medium">Image</h4>
<!--                                <div class="image-wrap">
                                    <img src="images/image1.jpg" alt="">
                                    <img src="images/image2.jpg" alt=""> 
                                </div>-->
                                <div class="image-wrap">
                          <?php foreach($attachments as $key=>$images){ 
                                    if($images['Attachment']['file_type'] == 'image'){
                                        $mainImage = str_replace('thumb_', '', $images['Attachment']['image_url']);
                                        ?>
                                        <div class="img-section row-wrap" data-id="<?php echo $images['Attachment']['id'];?>">
                                 <?php if($this->Session->read('context_role_user_id') == $adviceInfoData['Advice']['context_role_user_id']){ ?>
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
<!--                                <div class="doc-wrap">
                                  <a href=""><i><img src="images/doc.png" alt=""></i>LoremIpsum2014.docx</a>
                                   <a href=""><i><img src="images/pdf.png" alt=""></i>LoremIpsum2013.pdf</a> 
                                </div>-->
                                <div class="doc-wrap">
                                    
                         <?php foreach($attachments as $key=>$images){ 
                                    if($images['Attachment']['file_type'] != 'image'){
                                        if($images['Attachment']['file_type'] == 'doc' || $images['Attachment']['file_type'] == 'docx'){ ?>
                                        <div class="doc-section row-wrap" data-id="<?php echo $images['Attachment']['id'];?>"> 
                                   <?php if($this->Session->read('context_role_user_id') == $adviceInfoData['Advice']['context_role_user_id']){ ?>
                                          <div class="close-img"></div>
                                   <?php } ?>        
                                            <a target="_blank" href="<?php echo $this->Html->url('/', true).$images['Attachment']['image_url'];?>">
                                                <i><?php echo $this->Html->image('doc.png');?></i><?php echo $images['Attachment']['file_name'];?></a>  
                                        </div>                                
                                    <?php } 
                                        else if($images['Attachment']['file_type'] == 'pdf'){ ?>
                                         <div class="doc-section row-wrap" data-id="<?php echo $images['Attachment']['id'];?>"> 
                                    <?php if($this->Session->read('context_role_user_id') == $adviceInfoData['Advice']['context_role_user_id']){ ?>         
                                          <div class="close-img"></div>
                                    <?php } ?>      
                                            <a target="_blank" href="<?php echo $this->Html->url('/', true).$images['Attachment']['image_url'];?>">
                                                <i><?php echo $this->Html->image('pdf.png');?></i><?php echo $images['Attachment']['file_name'];?></a>
                                          </div>
                                <?php   }
                                        else{ ?>
                                         <div class="doc-section row-wrap" data-id="<?php echo $images['Attachment']['id'];?>"> 
                                   <?php if($this->Session->read('context_role_user_id') == $adviceInfoData['Advice']['context_role_user_id']){ ?>        
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
            <div class="attach-wrap btn-yellow upload-file">
        <h4 class="roboto_medium">Upload image or pdf documents (Max: 1MB)</h4>
                       <!--<form action="" method="POST" id="attachment-handler" enctype="multipart/form-data">-->   
                           
                      <?php echo $this->Form->create('Sage',array('class'=>'form-horizontal form-style-1 margin-bottom-0x','type' => 'file','id'=>"attachment-handler"));?>
                           
                       <input type="hidden" name="obj_id" value="<?php echo $obj_id;?>" />
                       <input type="hidden" name="obj_type" value="Advice" />
                       <input type="hidden" name="adv_type" value="<?php echo $adv_type;?>" />
                       <input type="file" data-buttonbefore="true" id="fileToUpload" name="fileToUpload[]" multiple="true" class="filestyle custom-filefield">
                       <?php //echo  $this->Form->input('fileToUpload[]', array('type' => 'file','class'=>'filestyle custom-filefield', 'multiple'=>true, 'data-buttonbefore'=>true,  'label'=>false,'id'=>'fileToUpload')); ?>
                       <button class="btn btn-black attached-upload" type="submit">UPLOAD</button>
                   <!-- </form>      -->
                    <?php echo $this->Form->end();?>
                   </div> 
        </div>  
    </div>
</div>

    
 <div class="bottom-wrap">
                <div class="show-detail attach">
                   <h5 class="roboto_medium">Images/Documents<span><i class="icons close-grey-icon"></i></span></h5>
                   <div class="attach-wrap btn-yellow">
                       <!--<form action="" method="POST" id="attachment-handler" enctype="multipart/form-data">-->   
                           
                      <?php echo $this->Form->create('Sage',array('class'=>'form-horizontal form-style-1 margin-bottom-0x','type' => 'file','id'=>"attachment-handler"));?>
                           
                       <input type="hidden" name="obj_id" value="<?php echo $obj_id;?>" />
                       <input type="hidden" name="obj_type" value="Advice" />
                       <input type="hidden" name="adv_type" value="<?php echo $adv_type;?>" />
                       <input type="file" data-buttonbefore="true" id="fileToUpload" name="fileToUpload[]" multiple="true" class="filestyle custom-filefield">
                       <?php //echo  $this->Form->input('fileToUpload[]', array('type' => 'file','class'=>'filestyle custom-filefield', 'multiple'=>true, 'data-buttonbefore'=>true,  'label'=>false,'id'=>'fileToUpload')); ?>
                       <button class="btn btn-default attached-upload" type="submit">Submit</button>
                   <!-- </form>      -->
                    <?php echo $this->Form->end();?>
                   </div>                                      
                </div>
            </div>
            <div class="modal-footer align-center modal-bottom-strip">
                       <?php if($this->Session->read('user_id')){
                                // if owner of this article is viewing then neen not to show
                                if($this->Session->read('context_role_user_id') == $adviceInfoData['Advice']['context_role_user_id']){ ?>                 
                                   
                                    <button name="publish"  class="btn btn-style grey_button publish-advice">PUBLISH </button>
                                    <button name="cancel" data-advice-type="<?php echo $adv_type;?>" data-id="<?php echo $adviceInfoData['Advice']['id'];?>" data-type="Advice" class="btn btn-style grey_button cancel-advice get-new-modal set-data-advice">CANCEL </button>
                                    
                                <?php
                                    }
                                 }
                                ?>                    
            </div>

<script>
$(function () {   
    $('.collapse').collapse({     
        toggle: false
    });

    $("#datepicker_advice").datepicker();
     
    $("#datepicker_advice").bind('click',function(){
        var tp =  $('#datepicker_advice').offset().top+34;
        var lt = $('#datepicker_advice').offset().left;
        $('.ui-datepicker').fadeIn('fast');
        $('.ui-datepicker').offset({'top':tp,'left':lt}) 
    });
    
    // To find out current eluminati detail
    var advice_id = $('.eluminati-detail-id').val();
    var slideIndex = $('.slides').find("[data-id='"+advice_id+"']").index();
   // alert(slideIndex);
    jQuery("#sageadvice-popup, #viewCred").find('.flexslider').flexslider({
        animation: "slide",
        controlNav: false,
        slideshow:false,
        animationLoop: false,
        itemWidth:450,
        itemMargin:0,  
        keyboard:false,
        prevText:"PREVIOUS ARTICLE",
        nextText:"NEXT ARTICLE",
        slideshowSpeed: 100000, 
        startAt:slideIndex,
       start: function(slider){
          $('.flexslider').resize();

        //           $('.flex-direction-nav a.flex-prev').attr("disabled", "disabled"); ;

        // //THEN INSERT YOUR CUSTOM JQUERY CLICK ACTIONS TO REVEAL THEM AGAIN
        // slider.find('flex-direction-nav a.flex-next').on('click',function(){
        // $('#slider .flex-direction-nav').removeAttr("disabled");
        // });



        },
        after: function(slider){

            var currentContainerId = $(slider).closest('.modal').attr('id');
            var curSlidePos = slider.currentSlide;
            // To remove active class from all ul li
            $('.slides > li').removeClass('active');                
            $('.slides > li').eq(curSlidePos).addClass('active');

   


            var currentEluminatiDetailId = $('.slides > li.active').data('id');
              var currentEluminatiAdviceType = $('.slides > li.active').data('advice-type');
            //alert(currentEluminatiDetailId);
            // $('.slides .active').parent('li').addClass('active').siblings().removeClass('active');
          
           $('.page-loading-ajax').height($(window).height());                   
           // $('.page-loading-ajax').show();
        
            var obj_id = currentEluminatiDetailId;
            var obj_type = 'Advice';
             var adv_type = currentEluminatiAdviceType;
            jQuery("#sageadvice-popup").data("id", obj_id);
              jQuery(".set-data-advice").data("id", obj_id);
            jQuery("#sageadvice-popup").find(".comment_obj_id").val(obj_id);
            jQuery("#sageadvice-popup").find("#comment_obj_type").val(obj_type);
            $('.slides > li').removeClass('active'); 

            $('.slides').find("[data-id='"+obj_id+"']").addClass('active');
 //alert(obj_id);
            jQuery.ajax({
                  type :'POST',
                   url:'<?php echo $this->webroot?>pages/getModalFront/',
                    'data':{
                     'obj_id':obj_id,              
                     'obj_type':obj_type,
                     'adv_type':adv_type,
                    },
                    beforeSend: function() {
                            if(currentContainerId == 'viewCred') {
                                $('.cred-street-profile-loading-ajax').show();
                            } else {
                                $('.page-loading-ajax').show();
                            }
                    },
                    'success':function(data){   
//                  alert("fsd");
                    
                       jQuery("#"+currentContainerId).find('.tab-content .sage-advice-data').html(data);
                       if(currentContainerId === 'viewCred') {
                            containerCredHeight('.containerHeight', ['.top-section', '.profile_detail.relative', '.modal-footer', '.notification-bar']);
                        } else {
                            containerHeight('.containerHeight');
                        }
                       $('.cred-street-profile-loading-ajax, .page-loading-ajax').hide();
                       setTimeout(function() {
                        if(jQuery("#"+currentContainerId).is(":hidden")) {
                              jQuery("#"+currentContainerId).modal('show');
                        }                        
                       }, 1000);

                     
                      //var main_div = jQuery("#sageadvice-popup").find('.tab-content .sage-advice-data .advice_user_id').height();
                      //var inner_div = jQuery("#sageadvice-popup").find('.tab-content .sage-advice-data .advice_user_id .profile-img-blck').height();
                      //jQuery("#sageadvice-popup").find('.tab-content .sage-advice-data .advice_user_id .profile-title').height(main_div -inner_div);
                          

                       if( jQuery(".sage-advice-data").find('.user-active-status').val() =='1')
                       {
                        
                         jQuery("#sageadvice-popup").find(".get-sage-profile").removeClass('inactive-profile-tab');
                       }
                       else if(jQuery(".sage-advice-data").find('.user-active-status').val() =='0'){
                           jQuery("#sageadvice-popup").find(".get-sage-profile").addClass('inactive-profile-tab');
                       }
                      if( jQuery(".sage-advice-data").find('.advice_user_id').data('context') ==null )
                      {
                        
                         jQuery("#sageadvice-popup").find(".get-sage-profile").data("id",jQuery("#sageadvice-popup").find(".get-sage-profile").data("id"));
                        
                      }

                      else
                      {
                         jQuery("#sageadvice-popup").find(".get-sage-profile").data("id", jQuery(".sage-advice-data").find('.advice_user_id').data('context')); 
                      }
                   
                    customScroll(); 
                  }          
             });                
                           
        }
    });     


/*-------------Start to manage Category and sub-category -----------*/
$('body').on('change', '.decision-types', function () {
    getSubCategory(this, '<?php echo $this->webroot ?>challengers/decision_category/', '.category-id');
});
    /*$('.decision-types').change(function(){
        var $this = $(this),
        decisionTypeId = $this.val();
        $.ajax({
           type:'POST',
           url:'<?php echo $this->webroot?>challengers/decision_category/?id='+decisionTypeId,
           data:'',
           success:function(resp){
               resp = resp.replace('Select Category', 'Select Sub-category');
               $('.category-id').html(resp)
           }
        });
        
    });*/
/*-------------End to manage Category and sub-category -----------*/

$('input').each(function(){
    //this.contentEditable = true;
});


});

//# sourceURL=sage_modal_edit_element.ctpjs
</script>  
