<div class="col-md-10 content-wraaper admin-wrap">      
    <div class="sage-dash-wrap full-wrap">
        <div class="title dashboard-title">
            <h1>E|Icon</h1>
            <?php echo $this->Html->link('Add E|Icon',array('controller'=>'eluminatis','action'=>'addEluminati'),array('class'=>'right btn btn-orange-small ')); ?>
        </div>   
        <?php echo $this->element('manage_eluminati_element');?>
    </div>
</div> <!-- content-wraaper ends -->
   
<script type="text/javascript">
jQuery(document).ready(function(){

     jQuery("body").on("click",'.delete-eluminati',function(){
        var obj = jQuery(this);

        var eluminati_id = jQuery(this).data('id');
        //var page_title = jQuery(this).closest ('tr').find('.page-title').attr('value'); 
        bootbox.dialog({
                    message: "Are you sure delete this eluminati?",            
                    buttons: {
                        success: {
                            label: "Yes",
                            className: "btn-black",
                            callback: function() {
                              jQuery.ajax({
                                    type:'POST',
                                    url:'<?php echo Router::url(array('controller'=>'eluminatis', 'action'=>'deleteEluminati'));?>',
                                    data:
                                    {
                                        
                                        'eluminati_id':eluminati_id
                                    },
                                    success:function(data)
                                    {
                                        obj.closest ('tr').remove ();
                                        
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