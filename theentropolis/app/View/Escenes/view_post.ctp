<?php 
//pr($post_data);
?>
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
                  <?php $postDate = date('d-m-Y', strtotime(@$post_data[0]['Escene']['post_date']));?>  
                  <li><a href="#community" data-toggle="tab" class="community-tab">COMMUNITY</a></li>
                  <li><a href="#myposts" data-toggle="tab"  class="myposts-tab">MY POSTS</a></li>
                  <li class="active-post-date"><?php echo $post_data[0]['User']['first_name'].' '.$post_data[0]['User']['last_name'];?>, <?php echo $postDate;?></li>
                </ul>
                <div class="tab-content">
                  <div class="tab-pane active main-tab" id="community">
                    <div class="Escense-back">
                          <div class="btn btn-orange-small margin-top-small large right"><a href="<?php echo Router::url(array('controller'=>'escenes', 'action'=>'index'));?>">Back</a></div>
                      </div>
                    
                    <div class="" id="post-data-container">
                     <?php echo $this->element('single_post_element');?>                   
                  </div>
                   
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


