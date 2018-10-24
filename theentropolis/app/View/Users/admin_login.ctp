<div class="title">
    <h1>Login</h1>
    <div class="title-sep-container">
        <div class="title-sep"></div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <?php echo $this->Session->flash('login-form');?>	
        <?php echo $this->Form->create('User', array('class' => 'form-horizontal register-form', 'role' => 'form', 'url' => '/Users/userAuth')); ?>

        <div class="form-group">
            <label class="col-sm-3 control-label ">Email</label>
            <div class="col-sm-9">
                <?php echo $this->Form->email('email_address', array('class' => 'form-control', 'label' => false)); ?>

            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label ">Password</label>
            <div class="col-sm-9">
                <?php echo $this->Form->password('password', array('class' => 'form-control', 'label' => false)); ?>

            </div>
        </div>


        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-9">
                <?php echo $this->Form->hidden('context_role_user_id', array('value'=>'1'));?>
                <?php echo $this->Form->end(array('class' => 'btn btn-orange')); ?>


            </div>
        </div>
        </form>	


    </div>
</div>
