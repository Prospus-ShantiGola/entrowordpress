<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-53c383bb6244e3e5"></script>
<div class="col-md-10 content-wraaper">
  <div class="sage-dash-wrap full-wrap">
    <div class="title dashboard-title">
        <h1 style="text-transform:uppercase">E|Scene</h1>
    </div>
    <div class="home-display row">
        <div class="admin-escene-wrap">
            <div>
                <div>
                    <div class="col-md-8">
                        <div class="tab-content" style="margin-top:-23px">
                            <div class="tab-pane active main-tab" id="community">
                                <div class="" id="post-data-container">
                                    <?php echo $this->element('add_post_element');
                                        $remaining_count = $post_count-10;
                                        ?>                   
                                </div>
                                <?php if($post_count>10){?>
                                <a class="btn btn-orange-small margin-top-small large right load-more-post" data-type= "<?php echo $type;?>" data-count ='<?php echo $remaining_count; ?>' data-startlimit= "0" id= "load-more-post">Load More</a>
                                <div class="page-loading"><?php echo $this->Html->image('loading-upload.gif');?></div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <!-- col-md-8-->
                    <div class="col-md-4" id="side-area">
                        <div class="e-scene-sidebar">
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
    //$this->Session->write('post_id','0');
    ?>