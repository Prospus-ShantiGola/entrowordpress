<div class="col-md-10 content-wraaper admin-wrap">
    <div class="sage-dash-wrap full-wrap">
        <div class="title dashboard-title">
            <h1>Refernce Citizen</h1>
            <?php echo $this->Html->link('Invite New Citizen', array('controller'=>'users', 'action'=>'admin_new_user'), array('class'=>'btn btn-orange-small'));?>
        </div>
      
       
        <?php echo $this->element('reference_list_element');?>
    </div>
</div>
<!-- content-wraaper ends -->