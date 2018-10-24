<div class="col-md-10 content-wraaper admin-wrap">      
    <div class="sage-dash-wrap full-wrap">
        <div class="title dashboard-title">
            <h1>Success</h1>
            <div>Payment Successfull</div>
        </div>   

    </div>
</div> <!-- content-wraaper ends -->
   
<script type="text/javascript">
jQuery(document).ready(function(){

     jQuery("body").on("click",'.delete-eluminati',function(){
        var obj = jQuery(this);
        var vidHtml = '';
        var vid_id = jQuery(this).data('id');
        //var page_title = jQuery(this).closest ('tr').find('.page-title').attr('value'); 
        bootbox.dialog({
                    message: "Are you sure delete this video?",            
                    buttons: {
                        success: {
                            label: "Yes",
                            className: "btn-black",
                            callback: function() {
                              jQuery.ajax({
                                    type:'POST',
                                    url:'<?php echo Router::url(array('controller'=>'videos', 'action'=>'delete'));?>',
                                    data:
                                    {
                                        
                                        'vid_id':vid_id
                                    },
                                    success:function(data)
                                    {
                                       obj.closest ('tr').remove ();
                                       vidHtml = $.trim($("#postsPaging .table tbody tr").length);
                                      if(vidHtml == 0){
                                          $("#postsPaging .table tbody").append('<tr><td colspan="8"> No records found.</td></tr>');
                                       }
                                      
                                      
                                    }

                                });
                            }
                        },
                        danger: {
                            label: "No",
                            className: "btn-black"                   
                        }

                    }
                });
          
     });
   
});

</script>