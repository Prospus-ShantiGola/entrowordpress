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
                
                <div class="tab-content" style="padding-top:3px;">
                  <div class="tab-pane active" id="community">
                      <div class="admin-single-post">
                          <div class="Escense-back">
                              <div class="btn btn-orange-small margin-top-small large right"><a href="<?php echo Router::url(array('controller' => 'escenes', 'action' => 'index')); ?>">Back</a></div>
                          </div>

                          <div class="" id="post-data-container" style="margin-top:20px">
                              <?php echo $this->element('single_post_element'); ?>                   
                          </div>
                      </div>
                   
                  </div>             
              </div>
            </div><!-- col-md-8-->

              <div class="col-md-4" id="side-area">
                <div class="row e-scene-sidebar">
                  <div id="official-post"> <span>Entropolis Official Post</span> 
                  <span class="escene-action right">
                    <a href="<?php echo Router::url(array('controller'=>'escenes', 'action'=>'addPost'));?>"><i class="fa fa-plus-circle"></i>Add Post</a>	                            
	           </span>
                  </div>
                  
                  <div class="e-scene-bar-one">
                    
                     <?php echo $this->element('admin_official_post_element');
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


