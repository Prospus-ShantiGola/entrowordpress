<div class="page-loading" style="color:red"><?php echo $this->Html->image('loading-upload.gif');?></div>
<script type="text/javascript">
  $(document).ready(function(){

//comment k liye tha

    //   $('body').on('click','.comment-popup' , function(e){

    //  if($(this).closest('ul').siblings('.comment-wrap').hasClass('in')) 
    //   { alert("11st")
    //     $(this).closest('ul').siblings('.comment-wrap').hide(); 
    //     $(this).closest('ul').siblings('.comment-wrap').removeClass('in');
    //   }

    //   else if($('.comment-wrap').hasClass('in')) 
    //   { 
    //      alert("21st")
        
    //     $('.comment-wrap').removeClass('in');
    //     $('.comment-wrap').hide();
    //     $(this).closest('ul').siblings('.comment-wrap').show(); 
    //     $(this).closest('ul').siblings('.comment-wrap').addClass('in');
    //     e.stopPropagation();
    //   }

    //   else     
    //    { 
    //     alert("3s1t")
    //       $(this).closest('ul').siblings('.comment-wrap').show();          
    //       $(this).closest('ul').siblings('.comment-wrap').addClass('in');
    //       e.stopPropagation();
    //   }
      
    // });



  
     $('body').on('click','.comment-wrap' , function(e){
      //alert("fsdf");
        e.stopPropagation();
    })

    $('body').click(function(){
      $('.comment-wrap').hide();
       $('.comment-wrap').removeClass('in');
    });



  });

</script>
<div class="col-md-10 content-wraaper" id="ask-Question">
    <div class="sage-dash-wrap ask-Question-wrap">
     
        <div class="row">
          <div class="col-md-8">
             <div class="title dashboard-title fixed-ipad-top">              
                <h1>Community</h1>
              </div>
              <a class = "active get-question-post-data community-data-tab admin-side" data-tab ="Community">See All Question</a>

            <div id="admin-demo" class="scrollTo-demo add-new-data">
              <div id="admin-info" class="items tab-pane active">
                <div class="forum-wrap demo-y set-wrap-height add-post-data">
                  
                  <?php echo $this->element('question_post_element'); ?>
                  
                </div>
              </div>
            </div>

            <?php if($total_count>10){?>
                    <button class="btn btn-orange-small large right load-more-question-post " data-tab ='Community' data-remainingcount ='<?php echo $remaining_count; ?>' data-offset = "10" data-loadcount = '10'>Load More</button>
                    <?php } ?>
          </div>
          <div class="col-md-4">
           
            <div class="">
              <div class="title dashboard-title">              
                <h1>TRENDING QUESTION</h1>
              </div>
              <div class="trand-question-panel">
                 <ul>
                  <?php  foreach($trending as $value){

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

<?php echo $this->element('question_js_element');?>
