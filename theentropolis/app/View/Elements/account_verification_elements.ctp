 <?php echo $this->Session->flash();?> 
   
    <div class=" login-screen margin-bottom" >
       <p>Sign in</p>

        <?php  echo $this->Form->create('Users', array('class' => 'register-form', 'role' => 'form','id'=>'user-authen-detail')); 
  //echo //$this->Form->create('Users', array('class'=>'form-horizontal','id'=>'user-authen-detail','role'=>'form'));

     //   echo $email_address;die;
        ?>
      
         <div id ="append-error" class="error">
            <div class="form-group">
                <label class="col-sm-3 control-label ">Email</label>
                <div class="col-sm-5">
                    <?php echo $this->Form->input('email_address', array('class' => 'form-control', 'label' => false, 'readonly'=>true, 'value'=>@$email_address)); ?>
                    <?php echo $this->Form->hidden('varification_code', array('label' => false, 'value'=>@$varificationCode)); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label ">Password</label>
                <div class="col-sm-5">
                    <?php echo $this->Form->password('password', array('class' => 'form-control', 'minLength'=>'6', 'label' => false)); ?>
                    <div class="error-message password-error"></div>
                </div>
            </div>
             <div class="form-group">
                <label class="col-sm-3 control-label ">Confirm Password</label>
                <div class="col-sm-5">
                    <?php echo $this->Form->password('confirm_password', array('class' => 'form-control', 'label' => false)); ?>
                </div>
            </div>
           
        </div>
        <div class="form-group login-screen-padding">
          <!--   <div class="col-sm-offset-3 col-sm-5"> -->
                 <?php //echo $this->Form->end(array('class' => 'btn btn-orange', 'div'=>false,)); ?>
                  <?php echo $this->Form->button('Login', array('class'=>'btn btn-orange user-authentication col-sm-offset-3','type'=>'submit'));?>
            <!-- </div> -->
        </div>
    <?php echo $this->Form->end(); ?>
   
    </div>