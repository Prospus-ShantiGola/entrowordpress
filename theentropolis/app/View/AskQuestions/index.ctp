<div class="page-loading" style="color:red"><?php echo $this->Html->image('loading-upload.gif'); ?></div>


<script type="text/javascript">
    $(document).ready(function () {


        $('body').on('click', '.comment-wrap', function (e) {
            //alert("fsdf");
            e.stopPropagation();
        })

        $('body').click(function () {
            $('.comment-wrap').hide();
            $('.comment-wrap').removeClass('in');
        });
        $('body').on('click', '.radio-button-function', function (e) {
            $this = $(this);
            if ($this.is(':checked'))
                if ($this.hasClass('enable-network'))
                {
                    jQuery('.network-user-div').show();

                } else
                {
                    jQuery('.network-user-div').hide();

                }

        });

    });

</script>

<script type="text/javascript">

    $(window).load(function () {
        //  alert("fsd");

<?php if (@$this->request->params['action'] == 'index' && @$this->request->params['pass']['0'] != '') { ?>
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
                    
                    if (!(jQuery('#ask-Question').find('.community-data-tab').hasClass('question-trend'))) {
                        jQuery('#ask-Question').find('.community-data-tab').addClass('question-trend');
                    }

                }

            });

<?php }
?>
    });
</script>
<?php
if (!empty($suggestionObjId)) {
    $ObjId = $suggestionObjId;
    $actclass = '';
    $activeclass = 'active';
} else {
    $ObjId = "";
    $actclass = 'active';
    $activeclass = '';
}
?>
<!-- ask-trepicity-starts -->
<div class="col-md-10 content-wraaper comment-block-wrap" id="ask-Question">
    <div class="sage-dash-wrap ask-Question-wrap">
        <div class="row">
            <div class="col-md-8">
                <div role="tabpanel" cl>
                    <!-- Nav tabs -->
                    <div class="page-nav forum-nav">
                        <ul class="nav nav-pills" role="tablist">
                            <li role="presentation" class="get-question-post-data <?php echo $actclass ?> community-data-tab" data-tab ="Community"><a href="#Community" aria-controls="home"  role="tab" data-toggle="tab">Community</a></li>
                            <li role="presentation" class ="get-question-post-data mypost-data-tab" data-tab ="MyPost"><a href="#Mypost" aria-controls="profile" role="tab" data-toggle="tab">My Posts</a></li>               
<?php
if ($this->Session->read("isAdmin") != 1) {
    if (!empty($suggestionObjId)) {
        $ObjId = $suggestionObjId;
    } else {
        $ObjId = "";
    }
    ?>  
                                <li role="presentation" class ="get-suggetion-post-data mypost-data-tab <?php echo $activeclass ?>" data-tab ="MySuggestion" data-value="<?php echo $ObjId; ?>"><a href="#MySuggestion" aria-controls="profile" role="tab" data-toggle="tab">My Suggestions</a></li>               
                            <?php } ?> 

                              <li role="presentation" class ="get-question-post-data kidpreneur-data-tab  " data-tab ="Kidpreneur" data-value=""><a href="#KidpreneurQuestion" aria-controls="profile" role="tab" data-toggle="tab" class = "brand-color2-bg">Kidpreneur</a></li>                  
                        </ul>
                    </div>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane <?php echo $actclass ?> " id="Community"  data-type='Adult'>
                            <div id="demo" >
                                <div id="info" class="items">
                                    <div class="forum-wrap add-post-data">

<?php echo $this->element('question_post_element'); ?>                      

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="Mypost" data-type='Adult'>
                            <div id="Mypost-demo" class="scrollTo-demo">
                                <div id="Mypost-info" class="items">
                                    <div class="forum-wrap add-post-data">                     
                                    </div>
                                </div>
                            </div>
                        </div>

<?php if ($this->Session->read("isAdmin") != 1) { ?>  
                            <div role="tabpanel" class="tab-pane <?php echo $activeclass; ?>" id="MySuggestion" >
                                <div id="Mypost-demo" class="scrollTo-demo">
                                    <div id="Mypost-info" class="items">
                                        <div class="forum-wrap add-post-data1">  
                            <?php echo $this->element('suggestion_post_element'); ?> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                                        <?php } ?> 
                                         <div role="tabpanel" class="tab-pane" id="KidpreneurQuestion" data-type='Adult'>
                                <div id="Mypost-demo" class="scrollTo-demo">
                                    <div id="Mypost-info" class="items">
                                        <div class="forum-wrap add-post-data">  
                           
                                        </div>
                                    </div>
                                </div>
                            </div>

<?php
if (@$this->request->params['action'] == 'index' && @$this->request->params['pass']['0'] == '') {
    if ($total_count > 10) {
        ?>
                                <button class="btn btn-orange-small large right load-more-question-post margin_top_15" data-tab ='Community' data-remainingcount ='<?php echo $remaining_count; ?>' data-offset = "10" data-loadcount = '10'>Load More</button>
                            <?php }
                        } ?>
                    </div>

                </div>
            </div>
            <div class="col-md-4">
                <div class="">
                    <div class="title dashboard-title fixed-ipad-top">              
                        <h1>Ask for Advice</h1>
                    </div>
                    <div class="ask-question-panel">
<?php echo $this->Form->create('AskQuestion', array('id' => "question-form-data", 'role' => 'form')); ?>      
                        <input type = "hidden" name = "data[AskQuestion][submit_type]" value ="Post">
                        <div class="form-group new-form-group">
                            <div class="input select">
                        <?php echo $this->Form->input('category_id', array('options' => $decisiontypes, 'id' => 'decision_type', 'class' => 'form-control clear-decision_type', 'label' => false)); ?>
                            </div> 
                        </div>
                        <div class="form-group new-form-group">
                            <div class="input select">
<?php echo $this->Form->input('sub_category_id', array('options' => array('' => 'Sub-Category*'), 'id' => 'categoryid', 'class' => 'form-control clear-category_id', 'label' => false)); ?>  
                            </div> 
                        </div>                                        
                        <div class="form-group new-form-group">
                                <?php echo $this->Form->input('question_title', array('id' => 'question_title', 'class' => 'form-control clear-title', 'placeholder' => 'Title*', 'label' => false, 'maxlength' => '500')); ?>  
                        </div>
                        <div class="form-group new-form-group">
                    
                            <?php echo $this->Form->textarea('description', array('id' => 'description', 'placeholder' => 'Your question*', 'class' => 'form-control clear-desc', 'label' => false, 'maxlength' => '1000')); ?>

                        </div>



                         <div class="form-group new-form-group">
                           <div class="row">
                                   <div class="col-md-6">
                                   <label class="radio-inline">
                                                                           <input type="radio" class="radio-button-function unable-network" name="data[AskQuestion][post_type]" value="0" checked style = "display:inline-block;"> Ask All Entropolis
                                                                   </label>
                               </div>
                               <div class="col-md-6">
                               
                                   <label class="radio-inline">
                           <input type="radio" class ="radio-button-function enable-network"  name="data[AskQuestion][post_type]" value="1" style = "display:inline-block;"> Ask A User
                           </label>
                               
                               </div>
                           </div>
                       </div> 

                        <div class="form-group network-user-div new-form-group" style = "display:none;">

<?php echo $this->Form->input('network_user', array('options' => $network_user, 'id' => 'network_user', 'class' => 'form-control ', 'label' => false)); ?>

                        </div>


                        <!--  <button class="btn btn-black  margin-right right" type="submit">Ask|E</button> -->
<?php echo $this->Form->submit('ASK', array('class' => 'btn btn-black  margin-right right add-question-post ask-question-image', 'div' => false)); ?>

<?php echo $this->Form->end(); ?> 
                        <button class="btn btn-black right clear-ask-question" type="button ">Cancel</button>

                    </div>
                </div>
                <div class="">
                    <div class="title dashboard-title">              
                        <h1>TRENDING QUESTION</h1>
                    </div>
                    <div class="trand-question-panel">
                        <ul>
<?php foreach ($trending as $value) {
    ?>
                                <li><a class ="get-trending-post" onclick = "GetQuestionById(<?php echo $value['AskQuestion']['id']; ?>)"data-id ="<?php echo $value['AskQuestion']['id']; ?>"><?php echo $value['AskQuestion']['question_title']; ?></a></li>

                            <?php } ?>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ask-trepicity-ends -->

<!-- suggestion-box-starts -->

<div class="col-md-10 content-wraaper comment-block-wrap" id="suggestionBoxLink" style="display:none">
    <div class="sage-dash-wrap ask-Question-wrap">
        <div class="row">
            <div class="col-md-12">
                <div role="tabpanel" cl>
                    <!-- Nav tabs -->
                    <div class="page-nav forum-nav m-b-15">
                        <ul class="nav nav-pills m-b-15" role="tablist">
                            <li role="presentation" class="active get-question-post-data community-data-tab" data-tab ="Suggestions"><a href="#Suggestions" aria-controls="home"  role="tab" data-toggle="tab">Suggestions</a></li>           
                        </ul>
                    </div>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active " id="Suggestions" >
                            <div id="demo" >
                                <div id="info" class="items">
                                    <div class="forum-wrap add-post-data custom_scroll suggestion_view_wrapper">
<?php echo $this->element('questions_suggestion_link'); ?>                                           
                                    </div>
                                </div>
                            </div>
                        </div>
<?php
if (@$this->request->params['action'] == 'index' && @$this->request->params['pass']['0'] == '') {
    if ($total_count > 10) {
        ?>
                                <button class="btn btn-orange-small large right load-more-question-post margin_top_15" data-tab ='Community' data-remainingcount ='<?php echo $remaining_count; ?>' data-offset = "10" data-loadcount = '10'>Load More</button>
                            <?php }
                        } ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade modal-para-gap" id="question-post-modal-confirm" tabindex="-1" role="dialog" data-backdrop="static"  aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">THANKS, WE'RE ON IT!</h4>
            </div>
                
                    
            <div class="modal-body">
                <p></p>
            </div>
            <div class="modal-footer model-footer1 ">
                <button type="button" class="btn btn-black"  data-share-type="blog" data-dismiss="modal" onclick="refreshafterquestion();">OK</button>

            </div>
        </div>
    </div>
</div>

<!-- suggestion-box-starts -->

<?php
echo $this->element('question_js_element');


if ($this->Session->read("isAdmin") != 1) {
    //Added for My Suggestions tab
    echo $this->element('suggestion_js_element');
}

echo $this->element('advice_all_modal_element');
echo $this->element('blog_js_element');
?>
