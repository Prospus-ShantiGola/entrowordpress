 <?php 
 $perPageLimit;
 $pageNum = 1;
 if(isset($this->params['named']['page'])){
    $pageNum = $this->params['named']['page'];   
 }
 
 $page = '';
 if(isset($pass[0])){
    $page = $pass[0];
 }
 $this->Paginator->options(array('update'=> '#postsPaging','before' => $this->Js->get('#spinner')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#spinner')->effect('fadeOut', array('buffer' => false))));?>
    <div class="table-wrap" id="postsPaging">
        <input type="hidden" class="currentNumPage" value="<?php echo $pageNum;?>">
        <table class="table table-striped table-hover user-table action-table" cellspacing="0" cellpadding="0" width="100%">
            <thead>
                <tr>
                    <th></th>
                    <th>Name</th>
                    <th>Email Id</th>
                    <th>Gender</th>
                    <th>User Type</th>
                    <th>Last login</th>
                    <th>User Since</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php 
              //pr($users);
         if(count($users) > 0){       
                $indexer = $perPageLimit*($pageNum-1);
                foreach ($users as $key=>$user){
                  
                    $indexer++;
                    $show = 1;
                    $registrationDate = date('M j, Y', strtotime($user['User']['registration_date']));
                    $userRole = '';
                  
                    $role_exists ='';
                    
                    if(!empty($user['ContextRoleUser'])){
                        
                        foreach($user['ContextRoleUser'] as $roleValue)
                        {
                           $role = $this->User->getRoleByContextRoleUserId($roleValue['id']);  
                            if($role_exists=='')
                            {
                                $role_exists = $role['roles'];
                            }
                            else
                            {
                                $role_exists .=", ". $role['roles'];
                            }

                            if(strtoupper($role['contexts']) == 'GENERAL' && strtoupper($role['roles']) == 'ADMINISTRATOR'){
                             $role_exists = 'Administrator';
                            $show = 0;
                            }
                        }
                        
                       
                    
                      
                        // if(strtoupper($role['contexts']) == 'GENERAL' && strtoupper($role['roles']) == 'ADMINISTRATOR'){
                        //      $userRole = 'Administrator';
                        //     $show = 0;
                        //  }
                       

                        // if(strtoupper($role['roles']) == 'JUDGE'){
                        //     $userRole = 'Judge';
                        // }
                        // else if(strtoupper($role['contexts']) == 'PIONEER' ){
                        //     $userRole = 'Pioneer';
                        // }
                        // elseif(strtoupper($role['contexts']) == 'GENERAL' && strtoupper($role['roles']) == 'ADMINISTRATOR'){
                        //     $userRole = 'Administrator';
                        //     $show = 0;
                        // }
                        // else{
                        //     $userRole = 'Visitor';
                        // }
                        
                       }
                       
                    if( $role_data)
                    {
                        $role_exists = $role_data;
                    }
                                        
                    $lastLogin = $user['User']['last_login'];
                    $lastLoginDif = '';
                    
                    if($lastLogin != '0000-00-00 00:00:00'){
                        $dif = $this->User->dateDifference($lastLogin);

                        if($dif['year'] == '1'){
                            $lastLoginDif .= $dif['year'].' year, '; 
                        }
                        else if($dif['year'] > '1' )
                        {
                            $lastLoginDif .= $dif['year'].' years, '; 
                        }
                        if($dif['day'] == '1'){
                            $lastLoginDif .= $dif['day'].' day, '; 
                        }
                        else if($dif['day'] > '1')
                        {
                            $lastLoginDif .= $dif['day'].' days, '; 
                        }
                        if($dif['hrs'] == '1'){
                            $lastLoginDif .= $dif['hrs'].' hr, '; 
                        }
                        else if($dif['hrs'] > '1')
                        {
                            $lastLoginDif .= $dif['hrs'].' hrs, '; 
                        }
                        if($dif['min'] =='1'){
                            $lastLoginDif .= $dif['min'].' min ago'; 
                        }
                        else if( $dif['min'] >'1' ){
                              $lastLoginDif .= $dif['min'].' mins ago'; 
                        }                

                            }
                   
                ?>
                <tr class="user-list" data-id="<?php echo $user['User']['id'];?>">
                    <td class="user-index"><?php echo $indexer;?></td>
                    <td><?php echo $user['User']['first_name']. ' '.$user['User']['last_name'];?></td>
                    <td><?php echo $user['User']['email_address'];?></td>
                    <td><?php echo $user['User']['gender'];?></td>
                  <!--   <td><?php echo $userRole == '' ? $user['User']['user_type'] : $userRole;?></td> -->
                    <td><?php echo $role_exists;?></td>
                    <td><?php echo $lastLoginDif;?> </td>
                    <td><?php echo $registrationDate;?></td>
                    <td>
                        <?php  if($show == 1){
                         ?>
                        <div class="actions">
                  <?php 
                  if($page == 'invited'){ ?>
                       <a href="javascript:void(0)" class="update-user-status" data-id="delete" data-toggle="modal">Cancel Invitation</a>
                 <?php            
                  }
                  elseif($page == 'blocked'){ ?>
                          <a href="javascript:void(0)" class="update-user-status" data-id="unblock" data-toggle="modal">unblock</a>
                       <?php }
                       else{ ?>
                           <a href="javascript:void(0)" class="update-user-status" data-id="block" data-toggle="modal">Block</a>
                      <?php } 
                      if($page =='blocked' ){ ?>   
                          <a href="javascript:void(0)" class="update-user-status" data-id="delete" data-toggle="modal">Delete</a> 
                      <?php }?>
                          
                        </div>
                        <?php } ?>
                    </td>
                </tr>
                <?php  
                } 
         }else{
              echo "<tr><td colspan='8'> No records found.</td></tr>";
         }?>

            </tbody>
        </table>
<?php if(count($users) > 0){ ?>          
        <div class="pagination pagination-sm custom-page"><?php
        echo $this->Paginator->prev( __('<< Prev'), array(), null, array('class' => 'prev disabled pagination pagination-sm'));
        echo $this->Paginator->numbers(array('separator' => ''));
        echo $this->Paginator->next(__('Next >>'), array(), null, array('class' => 'next disabled'));
        echo $this->Js->writeBuffer();
        ?></div>
<?php } ?>        
  </div>

