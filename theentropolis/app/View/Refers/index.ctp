<div class="col-md-10 content-wraaper admin-wrap">
    <div class="sage-dash-wrap full-wrap">
        <div class="title dashboard-title">
            <h1>Refernce Citizen</h1>
            
            <button type="button" class="btn btn-orange-small" data-toggle="modal" data-target="#reference-modal">Invite New Citizen</button>
        </div>
      
       
        <?php echo $this->element('reference_list_element');?>
    </div>
</div>
<!-- content-wraaper ends -->

 <div class="modal fade" id="reference-modal" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
                    <h4 class="modal-title" id="myModalLabel">Invite New Citizen</h4>
                </div>
                <div class="modal-body  ">

                    <div class="invitation">
        
              <?php echo $this->Form->create('Refer', array('class' => 'reference-form', 'id' => 'send_reference')); ?>
    
               
                <label>To:</label>
                <?php echo $this->Form->input('email_address', array('class' => '', 'placeholder' => 'Email Address', 'label' => false, 'id' => 'email_address_refer','required')); ?>                        
              
            <label>Message:</label>
            <?php echo $this->Form->textarea('message', array('class' => '', 'placeholder' => 'Message', 'label' => false)); ?>
                               
                        
        <?php echo $this->Form->Button('Send Invitation', array('div' => false, 'class' => 'btn btn-black save-referal-user','type'=>"submit")); ?>
        <?php echo $this->Form->end(); ?>                
        <!--    <button type="button" class="btn btn-default">Send Invitation</button>       -->                                
    </div>
                    
                </div>
               
            </div>
        </div>
    </div>  
<script type="text/javascript">
    
    jQuery('body').on('click','.save-referal-user',function(e){
        var datas = jQuery(".reference-form").serialize();
        // var email_add  = jQuery("#email_address_refer").val();
        // alert(email_add)
        e.preventDefault();
        alert("fs");
        jQuery.ajax({
                 type :'POST',
                  url:'<?php echo $this->webroot?>refers/saveReferalUser/',
                
                   'data':datas,
                   
                 'success':function(data)
                 {  
                     if(data.result=="error"){
                      $("#email_address_refer").nextAll().remove();
                        if(data.error_msg.email_address !== undefined && data.error_msg.email_address[0]!=''){
                            $("#email_address_refer").after('<div class="error-message">'+data.error_msg.email_address[0]+'</div>');
                        }
                    }
                    else
                    {
                         $("#email_address_refer").nextAll().remove();
                         $("#reference-modal").modal('hide');
                          window.location="<?php echo Router::url(array('controller' => 'refers', 'action' => 'index')) ?>";
                    }
                 }
                  });  
    });  

</script>