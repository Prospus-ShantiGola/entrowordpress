<div class="col-md-10 content-wraaper admin-wrap">
    <div class="sage-dash-wrap full-wrap">
        <div class="title dashboard-title">
            <h1>Users</h1>
            <?php echo $this->Html->link('Invite New User', array('controller'=>'users', 'action'=>'admin_new_user'), array('class'=>'btn btn-orange-small'));?>
        </div>
        <div class="page-nav">
            <?php 
                // pr($this->params['named']['page']);
                     $activeClass = '';
                     $blokedClass = '';
                     $invClass = '';
                     $page = '';
                     if(isset($pass[0])){
                         $page = $pass[0];
                     }
                     if($page == 'blocked'){
                         $blokedClass = 'active';
                     }
                     elseif($page == 'invited'){
                         $invClass = 'active';
                     }
                     else{
                         $activeClass = 'active';
                     }
                 ?>
            <ul class="nav nav-pills">
                <li>
                    <?php echo $this->Html->link('Active', array('controller'=>'users', 'action'=>'manage_users/active'), array('class'=>$activeClass));?>    
                </li>
                <li>
                    <?php echo $this->Html->link('Blocked', array('controller'=>'users', 'action'=>'manage_users/blocked'), array('class'=>$blokedClass));?>    
                </li>
                <li><?php echo $this->Html->link('Invited', array('controller'=>'users', 'action'=>'manage_users/invited'), array('class'=>$invClass));?></li>
            </ul>
        </div>
        <div class="bg filter-box">
            <h4>Filter</h4>
            <?php echo $this->Form->create('filter_user', array('class'=>'form-inline', 'url'=>"/admin/users/manage_users/$page"));?>
            <input type="hidden" class="curr-tab" value="<?php echo $page;?>">
            <div class="form-group">
                <label class="">Name</label>
                <input type="text" name="user_name" class="form-control" placeholder="Enter name">
            </div>
            <div class="form-group">
                <label class="">Email address</label>
                <input type="text" name="email_address" class="form-control" placeholder="Enter email">
            </div>
            <div class="form-group">
                <label class="">Role</label>               
                <select name="choose_role" class="form-control">
                    <option value=''>Select Role</option>
                    <?php
                        foreach ($user_roles as $value) {?>
                    <option value = "<?php echo $value['Role']['id'];?>"><?php echo $value['Role']['role'];?></option>
                    <?php } 
                        ?>
                </select>
            </div>
            <button type="submit" class="btn btn-orange-small">Filter</button>
            </form>
        </div>
        <?php echo $this->element('user_list');?>
    </div>
</div>
<!-- content-wraaper ends -->