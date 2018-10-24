<div class="title">
    <h1>Register</h1>
    <div class="title-sep-container">
        <div class="title-sep"></div>
    </div>
</div>
<p>Ut quis dapibus quam. Integer scelerisque mollis elit, a porttitor enim condimentum eget. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Duis diam dui, dictum quis iaculis ut, ullamcorper sodales nisl. Nam eu diam ut augue tristique lobortis sed quis sem. </p>
<br>
<?php 
echo $this->Session->flash('role-form');
echo $this->Form->create('User');?>
<div class="avatar-choise-wrap">
    <div class="avatar-choosed" style="display:none"></div>
    <h3>SELECT YOUR AVATAR</h3>
    <div class="avatar-wrap">
        <h4>Choose your Avatar</h4>
        <?php echo $this->Form->hidden('user_image', array('class'=>'user-image', 'value'=>''));?>
        <div class="user-avatar">
            <img src="<?php echo $this->Html->url('/').'upload/'.'avatar-male-1.png';?>" class="img-thumbnail user-avatar-select">           
        </div>
        <div class="user-avatar">
            <img src="<?php echo $this->Html->url('/').'upload/'.'avatar-male-2.png';?>" class="img-thumbnail user-avatar-select">                       
        </div>
    </div>
    <div class="align-right">
    <?php echo $this->Form->submit('Continue', array('class'=>'btn btn-orange'));?>
    </div>
</div>
<?php echo $this->Form->end();?>
