<div class="page-loading-modal" style="color:red"><?php echo $this->Html->image('loading-upload.gif'); ?></div>
<div class="middle-container content-wraaper kd-comment-block-wrap  " style="padding:1.12rem 1.56rem;" ><!--custom_scroll-->
<div class="kd-sage-dash-wrap kd-ask-Question-wrap  " id="kd-ask-Question">
        <div class="row">
            <div class="col-md-8 p-r-5">
                <div role="tabpanel" >
                    <!-- Nav tabs -->
                    <div class="kd-page-nav kd-forum-nav forum-nav">
                        <ul class="nav nav-pills" role="tablist">
                            <li role="presentation" class="get-question-post-data active community-data-tab kid_section_ " data-tab="Mypost">
                                <a href="#Mypost" aria-controls="home" role="tab" data-toggle="tab" class="default-cursor">MY POSTS</a>
                            </li>
                        </ul>
                    </div>
                    <!-- Tab panes -->
                    <div class="tab-content" id="ask-Question">
                        <div role="tabpanel" class="tab-pane active " id="Mypost" data-type='Kid'>
                            <div id="demo">
                                <div id="info" class="items">
                                    <div class="kd-forum-wrap add-post-data ">


                                      <?php 
                                      // pr($questionInfoData );
                                      // die;
                                      echo $this->element('kid_my_post_element'); ?>

                                        

                                    </div>
                                </div>
                            </div>
                        </div>
                     
                           <?php if ($total_count > 10) {?>
                      

                        <button class="btn blue_filled kd-large right kd-load-more-question-post kd-margin_top_15 load-more-question-post " data-tab ='Mypost' data-remainingcount ='<?php echo $remaining_count; ?>' data-offset = "10" data-loadcount = '10'>Load More</button>
                             <?php }?>
                    </div>

                </div>
            </div>
            <div class="col-md-4">


            <?php echo $this->element('askhq_kid_element'); ?>




                <div class="">
                    <div class="kd-title kd-dashboard-title">
                        <h1>TRENDING QUESTION</h1>
                    </div>

                


                            <div class="trand-question-panel kd-trand-question-panel">
                            <ul>
                            <?php 

                            if(!empty($trending))
                                {foreach ($trending as $value) {
                            ?>
                                    <li><a class ="get-trending-post" onclick = "GetQuestionById(<?php echo $value['AskQuestion']['id']; ?>)"data-id ="<?php echo $value['AskQuestion']['id']; ?>"><?php echo $value['AskQuestion']['question_title']; ?></a></li>

                                <?php }}else{?>
<p class="text-center">No Record Found.</p>
                                <?php } ?>

                            </ul>
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>

<?php echo $this->element('question_js_element');?>


<script type="text/javascript">

    $(window).load(function () {
        //  alert("fsd");

<?php if (@$this->request->params['action'] == 'kid_askhq' && @$this->request->params['pass']['0'] != '') { ?>
            var question_id = <?php echo @$this->request->params['pass']['0']; ?>;
            var tab_val = <?php echo @$this->request->params['pass']['1']; ?>;
            var obj_id = <?php echo @$this->request->params['pass']['1']; ?>;
            $.ajax({
                url: '<?php echo Router::url(array('controller' => 'askQuestions', 'action' => 'GetQuestionById')); ?>',
                data: {
                    'question_id': question_id,
                    'tab_val':tab_val,
                    'obj_id':obj_id
                },
                type: 'post',
                success: function (data) {
                    if (tab_val == 1) {
                        // jQuery('#ask-Question').find('.mypost-data-tab').addClass('active');
                        // jQuery('#ask-Question').find('#Mypost').addClass('active');
                        // jQuery('#ask-Question').find('.community-data-tab').removeClass('active');
                        // jQuery('#ask-Question').find('#Community').removeClass('active');

                        //jQuery('#ask-Question').find('#Mypost .add-post-data .mCSB_container').html(data);
                        jQuery('#ask-Question').find('.tab-pane.active .add-post-data').html(data);
                    } else {
                        // jQuery('#ask-Question').find('.mypost-data-tab').removeClass('active');
                        // jQuery('#ask-Question').find('#Mypost').removeClass('active');
                        // jQuery('#ask-Question').find('.community-data-tab').addClass('active');
                        // jQuery('#ask-Question').find('#Community').addClass('active');
                        jQuery('#ask-Question').find('.tab-pane.active .add-post-data').html(data);
                        //jQuery('#ask-Question').find('.tab-pane.active .add-post-data .mCSB_container').html(data);
                    }
                    
                    // if (!(jQuery('#ask-Question').find('.community-data-tab').hasClass('question-trend'))) {
                    //     jQuery('#ask-Question').find('.community-data-tab').addClass('question-trend');
                    // }

                }

            });

<?php }
?>
    });
</script>