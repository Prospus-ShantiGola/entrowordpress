<?php 

if(isset($escene)){
    foreach($escene as $key=>$esceneDetail){
    
    }
    //pr($esceneDetail);
}
?>
<div class="col-md-10 content-wraaper admin-wrap">
    <div class="title dashboard-title">
        <h1>Add Post</h1>
        <?php //echo $post_edit;?>
        <div class="title-sep-container">
            <div class="title-sep"></div>		
        </div>
        <a class="right btn btn-orange-small" href="<?php echo Router::url(array('controller'=>'escenes', 'action'=>'index'));?>">Back</a>
    </div>
    <div class="add-faq-form forms font-light">
        <?php 
        if($this->Session->check('Message.post_error')){
            $errorFlag = 1;
        }else{
            $errorFlag = 0;
        }
                 
        echo $this->Session->flash('post_error');?>
        
         <?php echo $this->Form->create('Escene', array('id' => 'post_data', 'class'=>'form-horizontal', 'role'=>'form', 'enctype'=>'multipart/form-data')); ?>
             <?php echo $this->Form->hidden('id', array('value'=>@$esceneDetail['Escene']['id'], 'label'=>false));?> 
             
             <div class="form-group">	                    
                <div class="col-sm-7">
                    <div class="add-post-header col-md-12">
                        <div class="add-post-items"> <i class="fa fa-plus-circle"></i><span class="add-post-text">Add Post</span> <a class="pull-right escene-action-right" href="#">

                           <input class="atch-new escene-action-input" type="file" name="files[]" data-url="<?php echo Router::url(array('controller'=>'escenes', 'action'=>'upload'));?>"  multiple>
                        <i class="fa fa-camera escene-action-fa"></i></a> </div>
                    </div>
             <?php if($errorFlag == 1){               
                        echo $this->Form->textarea('post_description',array('label'=>false,'class'=>'form-control','rows'=>"7" ));
                    }else{
                        echo $this->Form->textarea('post_description',array('label'=>false,'class'=>'form-control','rows'=>"7", 'value'=>@$esceneDetail['Escene']['post_description']));
                    } ?>
                        
                    
                    <span class="upload-images hide"> <span> <img alt="" src="images/post-image-small.png"> <a href="#"><i class="icons close-icon"></i></a> </span> <span>
                            <div class="file-uploader">
                                <div>Upload File</div>
                                
                                <span style="display: block;" class="magic-placeholder-text"></span>
                            </div>
                        </span>
                    </span>
                </div>
                
                <div class="attachment clearfix">
                    <div class="atch-wrapper clearfix">                                                                                                                                                
                        <div class="image-bind">
                         <?php 
                         if(isset($esceneDetail['EsceneImage'])){
                             foreach($esceneDetail['EsceneImage'] as $key=>$images){ 
                                 $image = $images['image_address'];
                                 // to get thumb 
                                 $image = str_replace('upload/', 'upload/thumb_', $image); ?>
                                 <div class="upload-post-img">
                                     <div class="close-img"></div>
                                     <img class="add-post-img img-thumbnail" src="<?php echo Router::url('/', true).$image;?>">
                                     <input type="hidden" name="filesPath[]" value="<?php echo $image;?>">
                                 </div>
                                 <?php 
                             }
                         }
                          ?>
                        </div>    
                    </div>
                    <!-- atch-wrapper end --> 
                </div>
                
            </div>
            <div class="form-group">
                <div class="col-sm-12"> 
                    <?php 
                    $post_edit == 1 ? ($button = 'Save') : ($button = 'Add');
                    echo $this->Form->submit($button, array('class'=>'btn btn-orange-small', 'div'=>false));?>
<!--                    <a href="e-scene.php" class="btn btn-orange-small" id="">Add</a> -->
                    <a href="<?php echo Router::url(array('controller'=>'escenes', 'action'=>'index'));?>" class="btn btn-orange-small" id="">Cancel</a> 
                </div>
            </div>
        </form>
    </div>
</div>






