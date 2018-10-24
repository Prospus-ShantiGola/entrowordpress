<script>
$('body').on('click','.load_more_feed',function(){
	var $this = $(this);
var tab_name = $this.data('tab');
var startlimit =   $this.data('startlimit');
var remainingcount =   $this.data('remainingcount');
var loadcount =   $this.data('loadcount');
// alert(startlimit)
// alert(remainingcount)
  $.ajax({
           url:'<?php echo $this->webroot?>kidpreneurs/loadMoreLatestFeed/',
           data:{          
           	tab_name: tab_name,
           	startlimit :startlimit
           },
           type:'POST',
           success:function(data){ 
           var div_elm =  jQuery('.feeds-section .feed-data-list li:last').after(data);
     //  jQuery(data).insertAfter(div_elm);
          remaining_cc = remainingcount - loadcount;
       
          startlimit  = startlimit + loadcount;
          $this.data("remainingcount",remaining_cc);
            $this.data("startlimit",startlimit);
            
          if(remaining_cc <=0)
          {
            $this.hide();
          }

		}
	});
});

$('body').on('click','.live_feed_data',function(){
$this = $(this);
var tab_name = $this.data('tab');

$.ajax({
    
      url:'<?php echo $this->webroot?>kidpreneurs/getFeedData/',
      data:{'tab_name':tab_name},
      type:'POST',
      success:function(data){ 
          if(data)
          {
            jQuery('.feed-data-list').html(data);
          }
        }
    });

});

jQuery('body').on('click', 'update-view-status.active', function (e) {
        var $this = jQuery(this);


        var current_obj = $this.data("objid");
        var article = $this.data("article")
        var data_type = $this.data("type");
        var articleid = $this.data('articleid');

        if (article == 'askQuestion')
        {
            jQuery.ajax({
                type: 'POST',
                url: "<?php echo Router::url(array('controller' => 'askQuestions', 'action' => 'updateAskQuestionViewStatus')) ?>",
                data:
                        {
                            'question_id': articleid,
                            'data_type': data_type,
                            'obj_id':current_obj
                        },
                success: function (resp) {
                    //updateUnreadNumComment();
                    $this.removeClass('active');

                    // $('.list-wrap.update-view-status.active.askQuestion-class').each(function ()
                    // {
                    //     if ($(this).data("articleid") == question_id && $(this).data("type") == 'Like')
                    //     {
                    //         //alert("fd");
                    //         $(this).removeClass('active');
                    //     }
                    // });


                }
            });
        } 
    })

</script>