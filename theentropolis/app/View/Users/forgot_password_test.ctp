<div class="top-grey-strip-bg margin-bottom">
    <div class="">
        <div class="page-title">
            Forgot Password
        </div>
    </div>
</div>
<div class=" login-screen margin-bottom" >
    <div class="">
<?php //echo phpinfo();
echo $this->Session->Flash('reset-password');?>
<p>Enter the email address that you provided while registering at TrepiCity. You will recieve password reset instructions via email.</p>
<div class="row">
    <div class="col-md-12">	
        <?php echo $this->Form->create('User', array('class'=>'forgot-pass-form', 'role'=>'form'));?>
        
            <div class="form-group">
                <label class="col-sm-3 control-label">Email</label>
                <div class="col-sm-5">
                   <?php echo $this->Form->input('email_address', array('class'=>'form-control', 'label'=>false));?>
                    
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-5">
                    <?php echo $this->Form->button('Submit', array('class'=>'btn btn-orange'));?>
                    
                </div>
            </div>
        <?php echo $this->Form->end();?>
    </div>
</div>
</div></div>