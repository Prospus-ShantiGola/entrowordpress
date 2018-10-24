<div class="page-loading" style="color:red"><?php echo $this->Html->image('loading-upload.gif');?></div>
<!-- suggestion-box-starts -->
<div class="col-md-10 content-wraaper comment-block-wrap" id="suggestionBoxLink">
    <div class="sage-dash-wrap ask-Question-wrap">
        <div class="row">
          <div class="col-md-12">
       <div class="title dashboard-title fixed-ipad-top">
            <h1>Broadcasts</h1>
        </div>
            <div role="tabpanel" cl>
             
              <div class="tab-content">
                <div role="tabpanel" class="tab-pane active " id="Broadcast" >
                  <div id="demo" >
                    <div id="info" class="items">
                        <div class="forum-wrap add-post-data custom_scroll suggestion_view_wrapper">
                              <?php echo $this->element('broadcast_list'); ?>                                           
                      </div>
                    </div>
                  </div>
                </div>
                 <?php // echo "<pre>";print_r($this->request->params);die;
                 if(@$this->request->params['action'] =='index' && (@$this->request->params['pass']['0']=='' ||@$this->request->params['pass']['0']=='edit'))
                 { 
                   $addAction = "";
                   if(@$this->request->params['pass']['0'] == 'edit'){
                       $addAction = " data-actiontype=edit";
                   }  
                   if($total_count>10){?>
                    <button class="btn btn-orange-small large right load-more-broadcast-post margin_top_15" <?php echo $addAction;?>   data-tab ='Community' data-remainingcount ='<?php echo $remaining_count; ?>' data-offset = "10" data-loadcount = '10'>Load More</button>
                    <?php } }?>
              </div>

            </div>
          </div>
        </div>
    </div>
</div>
 <div class ='html_container'></div>
<!-- suggestion-box-starts -->

<?php 
// echo $this->element('suggestion_js_element');
// echo $this->element('advice_all_modal_element');
// echo $this->element('blog_js_element');
      ?>
<script type="text/javascript">

$("body").on('click','.broadcast_edit_modal',function(){

   var object_id = $(this).attr('id');
  // alert(object_id)

    $.ajax({
                type: 'POST',
                url: "<?php echo Router::url(array('controller'=>'BroadcastMessages', 'action'=>'getBroadcastMessageDetail'))?>",
                data: {
            
                    'object_id': object_id
                

                },
                success: function (data) {
         
                  $(".html_container").html(data)
                  $(".html_container").find("#new-advice").modal('show');
                  $(".html_container").find("#new-advice textarea.featured_blog_editor" ).ckeditor();
                }
            })
})
    </script>