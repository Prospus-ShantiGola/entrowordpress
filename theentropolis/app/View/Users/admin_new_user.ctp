<div class="col-md-10 content-wraaper admin-wrap">
    <div class="sage-dash-wrap full-wrap">
        <div class="title dashboard-title">
            <h1>Invite New User</h1>
             <?php echo $this->Html->link('Back', array('controller'=>'Users', 'action'=>'admin_manage_users'), array('class'=>'btn btn-orange-small'));?>
           
        </div>
        <div class="invite-user-form forms">
            <?php echo $this->Session->Flash('new-user');?>
            <?php echo $this->Form->create('User', array('class'=>'form-horizontal', 'role'=>'form',  'url'=>'/admin/Users/new_user'));?>  
            <div class="form-group">
                <label class="col-sm-2 control-label">First Name</label>
                <div class="col-sm-4">
                    <?php echo $this->Form->input('first_name', array('class'=>'form-control', 'label'=>false));?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Last Name</label>
                <div class="col-sm-4">
                    <?php echo $this->Form->input('last_name', array('class'=>'form-control', 'label'=>false));?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label ">Gender</label>
                <div class="col-sm-4">
                    <?php 
                        $options = array(''=>'Select',  'Male'=>'Male', 'Female'=>'Female');
                        echo $this->Form->input('gender', array('options'=>$options, 'class'=>'form-control', 'label'=>false));?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Email Id:</label>
                <div class="col-sm-4">
                    <?php echo $this->Form->input('email_address', array('class'=>'form-control', 'label'=>false));?>
                </div>
            </div>
            <div class="form-group inline-radio">
                <?php //pr(@$this->request->data['User']['user_type']);?>
                <label class="col-sm-2 control-label">User Type</label>
                <div class="col-sm-8">
                    <div class="radio-btn">
                        <input type="radio" name="data[User][user_type]" value="Challenger" <?php echo @$this->request->data['User']['user_type'] == 'Challenger' ? 'checked' :'';?> id="challenger">
                        <label class="custom-radio" for="challenger">Challenger</label>
                    </div>
                    <div class="radio-btn">
                        <input type="radio" name="data[User][user_type]" value="Visitor" <?php echo @$this->request->data['User']['user_type'] == 'Visitor' ? 'checked' :'';?> id="visitor">
                        <label class="custom-radio" for="visitor">Visitor</label>
                    </div>
                    <div class="radio-btn">
                        <input type="radio" name="data[User][user_type]" value="Judge" <?php echo @$this->request->data['User']['user_type'] == 'Judge' ? 'checked' :'';?> id="judge">
                        <label class="custom-radio" for="judge">Judge</label>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10"> 
                    <?php echo $this->Form->submit('Send Invitation', array('class'=>'btn btn-orange-small user-invitation', 'div'=>false));?>
                    <?php echo $this->Html->link('Cancel', array('controller'=>'Users', 'action'=>'admin_manage_users'), array('class'=>'btn btn-orange-small'));?>
                </div>
            </div>
            <?php echo $this->Form->end();?>
        </div>
    </div>
</div>
<!-- content-wraaper ends -->