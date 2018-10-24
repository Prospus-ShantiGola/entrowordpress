
 <script type="text/javascript" src="<?php echo $this->Html->url('/') . 'js/tokenize2.js'; ?>"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo $this->Html->url('/') . 'css/tokenize2.css'; ?>" />
        <link rel="stylesheet" type="text/css" href="<?php echo $this->Html->url('/') . 'css/auto_suggest.css'; ?>" />

   

<div class="modal fade" id="add-to-group" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close clear_modal_data"  aria-hidden="true"><i class="icons close-icon "></i></button>
                <h4 class="modal-title" id="myModalLabel">Add To Group</h4>
            </div>
            <div class="modal-body  add-network-popup">

                <div class="invitation">
                  
                 
                    <?php echo $this->Form->create('GroupDetail', array('class' => 'send_group_invitation', 'id' => 'send_group_invitation')); ?>                   
        
                    <div class="invite-wrap">
                     <?php echo $this->Form->input('group_name', array('placeholder' => 'Group Name*', 'label' => false, 'id' => 'group_name','required'=>'true')); ?> 
                  <!--     <div class="col-md-6">
                <div class="panel">
                    
                    <div class="panel-body"> -->
                        <select   class="tokenize-sample-demo1 user_id_member" multiple name ="data[GroupDetail][member][]"  >
                            
                        </select>
               <!--      </div>
                </div>
            </div> --><input type = "hidden" class  = "action_type" value = ""  name = "data[GroupDetail][action_type]">
                    <input type = "hidden" class  = "group_id_data" value = ""  name = "data[GroupDetail][group_id_data]">
                    <input type = "hidden" class  = "conversation_type" value = ""  name = "data[GroupDetail][conversation_id]">
                  
                    <?php echo $this->Form->textarea('comment_text', array('placeholder' => 'Message', 'label' => false, 'id' => 'comment_text')); ?> 
                    </div>
                    <b><span><?php echo $this->Session->read('user_name'); ?></span> </b>
<?php echo $this->Form->Button('Save Group', array('div' => false, 'class' => 'btn btn-black ', 'type' => "submit")); ?>
<?php echo $this->Form->end(); ?>                
                </div>
            </div>
        </div>
    </div>
</div>  

<script>
    $('.tokenize-sample-demo1').tokenize2({

    searchFromStart: false,

    placeholder: 'Select Username*'




    });




</script>