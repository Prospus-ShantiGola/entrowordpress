
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-53c383bb6244e3e5"></script>
<script type="text/javascript">
// $(document).ready(function(){
//     var txt = $('#post_description'),
//         hiddenDiv = $(document.createElement('div')),
//         content = null;

//     txt.addClass('txtstuff');
//     hiddenDiv.addClass('hiddendiv common');

//     $('body').append(hiddenDiv);

//     txt.on('keyup', function () {

//         content = $(this).val();

//         content = content.replace(/\n/g, '<br>');
//         hiddenDiv.html(content + '<br class="lbr">');

//         $(this).css('height', hiddenDiv.height());

//     }); 
// });
</script>
 <div class="col-md-10 content-wraaper">
      <div class="title dashboard-title">
        <h1 style="text-transform:uppercase">E|Scene</h1>
        <div class="title-sep-container">
          <div class="title-sep"></div>
        </div>
      </div>
      <div class="home-display">
        <div>
          <div>
            <div>
              <div class="col-md-8 main-tab">
                <ul class="nav nav-tabs tabs">
                  <li class="active"><a href="#community" data-toggle="tab" class="community-tab">COMMUNITY</a></li>
                  <li><a href="#myposts" data-toggle="tab"  class="myposts-tab">MY POSTS</a></li>
                </ul>
                <div class="tab-content">
                  <div class="tab-pane active" id="community">

                    <div class="add-post background-white">
                      <div>
                        <div class="add-post-header col-md-12">
                          <div class="add-post-items"> <i class="fa fa-edit"></i><span class="add-post-text">Add Post</span> 
                            <span class="pull-right post-nav">                            
                              <a href="#" class="escene-action-right"><input class="atch-new post-nav-input" type="file" name="files[]" data-url="<?php echo Router::url(array('controller'=>'escenes', 'action'=>'upload'));?>"  multiple> <i class="fa fa-camera escene-action-fa"></i></a>
                            </span>
                          </div>
                        </div>
                      </div>
                     <?php echo $this->Form->create('Escene', array('id' => 'post_data')); ?>
                         <?php echo $this->Form->textarea('post_description',array('label'=>false,'class'=>'col-lg-12 common','rows'=>"3", 
                          'placeholder'=>"say something about your post",'id'=>'post_description')); ?>
                     <!--  <textarea class="col-lg-12" rows="3"  placeholder="say something about your post" ></textarea> -->
                      <div class="add-post-content">
                       
                                  <div class="attachment clearfix">
                              <div class="atch-wrapper clearfix">                                                                                                                                                
                                  <div class="image-bind">
                                   
                                  </div>    
                              </div>
                              <!-- atch-wrapper end --> 
                          </div> 
                       
                        
                        <div class="add-post-bottom">
                          <?php echo $this->Form->button('Add',array('class'=>'btn btn-orange-small add-escene ','div'=>false,'label'=>false,'type'=>'button'));?>
                        <!--  <button class=""></button> -->
                         </div>
                      </div>


                    </div>
                    <div class="" id="post-data-container">
                     <?php echo $this->element('add_post_element');
                      $remaining_count = $post_count-10;
                     ?>                   
                    </div>
                    <?php if($post_count>10){?>
                    <button class="btn btn-orange-small margin-top-small large right load-more-post" data-type= "<?php echo $type;?>" data-count ='<?php echo $remaining_count; ?>' data-startlimit= "0" id= "load-more-post">Load More</button>
                    <div class="page-loading"><?php echo $this->Html->image('loading-upload.gif');?></div>
                    <?php } ?>
                   
                  </div>             
              </div>
            </div><!-- col-md-8-->


              <div class="col-md-4" id="side-area">
                <div class="row e-scene-sidebar">
                  <div id="official-post"> <span>Entropolis Official Post</span> </div>
                  <div class="e-scene-bar-one">
                    
                     <?php echo $this->element('official_post_element');
                     $remaining_official_count = $official_post_count-10;
                     ?>  
                  </div>
                     <?php if($official_post_count>10){?>
                    <button class="btn btn-orange-small margin-top-small large right load-more-official_post" data-count ='<?php echo $remaining_official_count; ?>' data-startlimit= "0" id= "load-more-official_post">Load More</button>

                    <div class="page-loading"><?php echo $this->Html->image('loading-upload.gif');?></div>
                    <?php } ?>
                </div>
              </div>


            </div>
          </div>
        </div>
      </div>
    </div>


<?php 
if( @$this->Session->read('post_id') > 0){ ?>
<script type="text/javascript">
$('html, body').animate({
	scrollTop: $('.official-post-wrapper[data-id="<?php echo @$this->Session->read('post_id');?>"]').offset().top-100
}, 800);
</script>
<?php    
}

$_SESSION['post_id'] = 0;
?>
<script type="text/javascript">
        $(window).load(function() {
              
<?php
if( @$this->Session->read('post_type') != '' ){ 
    if($this->Session->read('post_type') == 'MY POSTS'){ ?>
         $('.myposts-tab').trigger('click');
         $.ajax({
         url:'<?php echo Router::url(array('controller'=>'Escenes', 'action'=>'blankExtraParam'));?>',
         data:{
           
         },
         type:'get',
         success:function(data){ 
           
        }
        
    });
         
   <?php   
   }
} ?>
        
        
   });     
    </script>   


<script type="text/javascript">

 jQuery(document).ready(function(){
  


 }); //document ready ends
 

 </script> 
 
