<div class="top-grey-strip-bg margin-bottom">
    <div class="container">
        <div class="page-title">
            login
        </div>
    </div>
</div>
<div class=" container">
      <?php echo $this->Session->flash();?> 
   
    <div class=" login-screen margin-bottom" >
       <p>Sign in</p>

        <?php  echo $this->Form->create('Users', array('class' => 'register-form', 'role' => 'form','id'=>'user-authen-detail')); 
  //echo //$this->Form->create('Users', array('class'=>'form-horizontal','id'=>'user-authen-detail','role'=>'form'));
        ?>
      
         <div id ="append-error" class="error">
            <div class="form-group">
                <label class="col-sm-3 control-label ">Email</label>
                <div class="col-sm-5">
                    <?php echo $this->Form->input('email_address', array('class' => 'form-control', 'label' => false)); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label ">Password</label>
                <div class="col-sm-5">
                    <?php echo $this->Form->password('password', array('class' => 'form-control', 'label' => false)); ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-5">                      
                    <a href="forgot_password" class="forgot-pass">Forgot Password?</a>                       
                </div>
            </div> 
        </div>
        <div class="form-group login-screen-padding">
          <!--   <div class="col-sm-offset-3 col-sm-5"> -->
                 <?php //echo $this->Form->end(array('class' => 'btn btn-orange', 'div'=>false,)); ?>
                  <?php echo $this->Form->button('Submit', array('class'=>'btn btn-orange user-authentication col-sm-offset-3','type'=>'submit'));?>
            <!-- </div> -->
        </div>
    <?php echo $this->Form->end(); ?>
   
    </div>
  
</div>
