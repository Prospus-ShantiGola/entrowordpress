<div class="view-left-panel">
    <div class="view-left-panel-img">

        <?php if ($adviceInfoData['ContextRoleUser']['User']['user_image'] != '') { ?>
            <img src="<?php echo $this->Html->url('/') . $this->Image->resize($adviceInfoData['ContextRoleUser']['User']['user_image'], 100, 100, true); ?>" alt=""/>
        <?php } else { ?>
            <img src="<?php echo IMG_PATH ?>/img/dummy.jpg" alt=""/>
        <?php } ?>
        <p><?php echo $this->User->userName($adviceInfoData['ContextRoleUser']['User']['id']) ?></p>
    </div>
    <div class="view-rate">
        <span class="views view-color"><i class="fa fa-eye"></i><span class="views"><?php echo $adviceInfoData[$type][strtolower($type) . '_views'] ?></span></span>

    </div>
    <div class="view-rate">
        <?php if ($type == "Advice") { ?>
            <span class="advice-id" data-id="<?php echo $adviceInfoData['Advice']['id'];?>">
            <span class="views view-color"><i class="fa fa-star"></i><span class="views"><?php echo $this->Rating->getRating($adviceInfoData[$type]['id']); ?></span></span>
        <?php } else { ?>
            <span class="hindsight-id" data-id="<?php echo $adviceInfoData['Hindsight']['id'];?>">
            <span class="views view-color"><i class="fa fa-star"></i><span class="views"><?php echo $this->Rating->getHindsightRating($adviceInfoData[$type]['id']); ?></span></span>
        <?php } ?>
    </div>
    <div class="view-rate">
        <span class="views view-color"><i class="fa fa-comments-o"></i><span class="views"><?php echo $commentCount ?></span></span>

    </div>

    <button class="btn btn-orange-small view-left-panel-button view-comments" style = "width:135px" data-toggle="modal" data-target="#view-comment">View Comments</button>	
    <button class="btn btn-orange-small view-left-panel-button view-rates" style = "width:135px;margin-top:0px;" data-toggle="modal" data-target="#view-rate">View Rates</button>   										

    <div class="modal fade" id="view-comment" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header <?php echo $modal_header_color;?>">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
                    <h4 class="modal-title" id="myModalLabel">Comments</h4>
                </div>
                <div class="modal-body comment-scroll ">
                    <?php
                    if ($commentCount > 0) {
                        foreach ($adviceInfoData['Comment'] as $comment) {
                            if ($comment['comments'] != '') {
                                // pr($comment);    
                                ?>
                                <div class="comment-div clearfix <?php echo $modal_header_color;?>">
                                    <h5><?php echo $this->User->userName($comment['User']['id']) ?></h5>
                                    <span class="date"><?php echo date("M j, Y", strtotime($comment['comment_postedon'])); ?></span>
                                    <p><?php echo $comment['comments'] ?></p>
                                </div>
        <?php
        }
    }
} else {
    ?>
                        <p>No comments available. </p>
                    <?php } ?>
                </div>
                <div class="modal-footer add-comment-footer">
                    <button type="button" class="btn btn-black " data-dismiss="modal" data-toggle="modal" data-target="#add-comment">Add Comment</button>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="view-rate" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header <?php echo $modal_header_color;?>">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
                    <h4 class="modal-title" id="myModalLabel">Rates</h4>
                </div>
                <div class="modal-body comment-scroll ">
                    <?php
                    if ($rateCount > 0) {
                      //  pr($ratedata);
                       // die;
                        foreach ($ratedata as $comment) {
                            if ($comment['Comment']['rating'] != '') {

                                if($comment['Comment']['rating'] ==10)
                                {
                                        $rates= 'Excellent';
                                }
                                else if ( $comment['Comment']['rating'] ==8)
                                {
                                         $rates= 'Very good';
                                }
                                else if ( $comment['Comment']['rating'] ==6)
                                {
                                         $rates= 'Average';
                                }
                                else if ( $comment['Comment']['rating'] ==4)
                                {
                                         $rates= 'Could be better';
                                }
                                else if ( $comment['Comment']['rating'] ==2)
                                {
                                         $rates= 'Terrible';
                                }
                                // pr($comment);    
                                ?>
                                <div class="comment-div clearfix <?php echo $modal_header_color;?>">
                                    <h5><?php echo $this->User->userName($comment['User']['id']) ?></h5>
                                    <span class="date"><?php echo date("M j, Y", strtotime($comment['Comment']['comment_postedon'])); ?></span>
                                    <p><?php echo $rates; ?></p>
                                </div>
        <?php
        }
    }
} else {
    ?>
                        <p>No rates available. </p>
                    <?php } ?>
                </div>
                <!-- <div class="modal-footer add-comment-footer">
                    <button type="button" class="btn btn-black " data-dismiss="modal" data-toggle="modal" data-target="#add-comment">Add Comment</button>

                </div> -->
            </div>
        </div>
    </div>



  
    <div class="modal fade" id="thanks-msg" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header  <?php echo $modal_header_color;?>">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
                    <h4 class="modal-title" id="myModalLabel">Thanks For Your Comments</h4>
                </div>
                <div class="modal-body ">

                    <p>Your feedback is really valuable to us as it helps us properly curate our archive and deliver amazing wisdom to help you and business owners around the world make better, faster decisions without the angst</p>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="window.location.reload()" class="btn btn-black" data-dismiss="modal">Ok</button>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="add-comment" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header <?php echo $modal_header_color;?> ">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">Add Comments</h4>
            </div>
            <div class="modal-body clearfix add-comment-element">
                <?php echo $this->Form->create('Comment', array('class' => '', 'id' => 'AddOnlyCommentForm')); ?>
                <div class="<?php echo $modal_header_color;?>">

                    <p class= "popup-title">HI THERE <?php echo strtoupper($adviceInfoData['ContextRoleUser']['User']['first_name'] . " " . $adviceInfoData['ContextRoleUser']['User']['last_name']) ?><span class="date"><? echo date("M j, Y"); ?></span></p>
                    <ul>
                        <li >My Comments and Feedback is:</li>
                    </ul>
                    <input type="hidden" name="post_user_id" value="<?php echo $adviceInfoData['ContextRoleUser']['User']['id'];?>">
                    <input type="hidden" name="data[Comment][user_id]" value="<?php echo $this->Session->read('user_id'); ?>">
                    <?php if ($type == "Advice") { ?>
                        <input type="hidden" name="data[Comment][advice_id]" value="<?php echo $adviceInfoData['Advice']['id']; ?>">
                    <?php } else { ?>
                        <input type="hidden" name="data[Comment][hindsight_id]" value="<?php echo $adviceInfoData['Hindsight']['id']; ?>">
                    <?php } ?>
                    <div class="form-group left">
                        <?php echo $this->Form->textarea('comments', array('class' => 'form-control', 'placeholder' => 'Comments', 'data-placeholder' => 'Comments', 'label' => false, 'id' => 'Comments', 'required')); ?>
                    </div>											  

                    <div class=" <?php echo $modal_header_color;?>"><strong >From:</strong> <?php echo $this->Session->read('user_name'); ?></div>
                </div>
                
            </div>
            <div class="modal-footer">
                    <?php echo $this->Form->submit('Add', array('div' => false, 'class' => 'btn btn-black')); ?>


                </div>
                <?php echo $this->Form->end(); ?>

        </div>
    </div>
</div>
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
    
    // to change status with readable mode
    $(document).ready(function(){


        $('.view-comments').click(function(){
           var hindsightId = $('.hindsight-id').data('id'),
           adviceId = $('.advice-id').data('id');
           if(hindsightId > 0){
               var PostType ='hindsight';
           }
           else{
               var PostType = 'advice';
           }
           var datas = {postType:PostType,hindsightId:hindsightId, adviceId:adviceId};
           jQuery.ajax({
            type: 'POST',
            url: "<?php echo Router::url(array('controller' => 'Advices', 'action' => 'updateCommentStatus')) ?>",
            data: datas,
            success: function(resp) {
               updateUnreadNumComment();
            }
        });
           
        });
         $('.view-rates').click(function(){
           var hindsightId = $('.hindsight-id').data('id'),
           adviceId = $('.advice-id').data('id');
           if(hindsightId > 0){
               var PostType ='hindsight';
           }
           else{
               var PostType = 'advice';
           }
           var datas = {postType:PostType,hindsightId:hindsightId, adviceId:adviceId};
           jQuery.ajax({
            type: 'POST',
            url: "<?php echo Router::url(array('controller' => 'Advices', 'action' => 'updateRateStatus')) ?>",
            data: datas,
            success: function(resp) {
               updateUnreadNumComment();
            }
        });
           
        });
    
    });
</script>