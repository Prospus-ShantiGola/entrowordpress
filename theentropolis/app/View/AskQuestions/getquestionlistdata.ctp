
<?php if($fetch_type != 'loadmore') { ?>
<div class="tab-pane active" id="<?php echo $tab_name; ?>" >
      <?php  if(!empty($data)) {  ?>
                <button type="button" name="delete-btn" class="btn  btn-orange-small margin-top-small large right del-btn my_decisionbank delete-hindsight" disabled>Delete</button>
                <?php } ?>
                    <table class="table table-striped ask-table-wrap ques-table">
                      <thead>
                        <th><input  type="checkbox" class="check_all" name="" value="" ></th>
                        <th>Sub - Category</th>
                        <th>Date</th> 
                         <th>Name</th>                     
                        <th>Question</th>
                        <th>Status</th>
                        <th>Action</th>
                       </thead>                  
                    </table> 
                    <div  class="scrollTo-demo"  id="demo">
                        <div class="items" id="info">
                            <div class="demo-y set-wrap-height"> 
                         <table class="table table-striped  table-condensed ask-table-wrap ques-table">
                  <tbody> 
                     <?php  if(!empty($data)) { 

                      //pr($data);die;?>
                     <?php foreach($data as $rec) { 

                            $user_role = $this->User->getUserData($rec['AskQuestion']['user_id_creator']);
                             if($user_role['context_role_id'] =='5')
                            {
                                $user_type = 'Hindsight';
                            }
                            else
                            {
                                $user_type = 'Advice';
                            }


                      ?>
                    <tr class= "get-question-modal"  data-type = "<?php echo $user_type; ?>" data-id = <?php echo $rec['AskQuestion']['id'];?>  data-direction='right'>
                      <td><input  type="checkbox" class="check-hindsight" name="AskQuestion[]" value="<?php echo $rec['AskQuestion']['id'];?>" ></td>
                    <td title= "<?php echo $rec['Category']['category_name'];?>"><?php echo $this->Eluminati->text_cut($rec['Category']['category_name'], $length = 10, $dots = true); ?></td>    
                       <td><?php echo date('M j, Y', strtotime($rec['AskQuestion']['added_on']));?></td>             
                       <td><?php echo $rec['User']['first_name']." ".$rec['User']['last_name'];?></td>       
                    <td><a ><?php echo $this->Eluminati->text_cut($rec['AskQuestion']['description'], $length = 25, $dots = true); ?></a></td>  
                     <td class="<?php echo $rec['AskQuestion']['status'] ; ?>" data-id = '<?php echo $rec['AskQuestion']['id'];?>'><?php echo ucfirst($rec['AskQuestion']['status']) ; ?></td>                         
                        <td><a   >View &amp; Reply</a></td>
                    </tr>
                      <?php } ?>                         
                  </tbody> 
                  <?php } else { ?>
                      
                        <tr>
                            <td colspan= '7' style = "background-color:#f2f2f2; text-align:center;" class="no-record">No records found.</td>
                        </tr>
                        
                        <?php } ?>                 
                </table>  
                  <?php if($total_count>10){?>
                    <div class="margin-bottom clearfix manage-space right " id="loadmorebtn">
                        <button class="btn  btn-orange-small margin-top-small large right" onclick="loadmoredata();">Load More</button>
                    </div>
                    <?php }?>

              </div>   
            </div> 
          </div>  
</div>
 <?php } else {?>  
 <?php foreach($data as $rec) {
    $user_role = $this->User->getUserData($rec['AskQuestion']['user_id_creator']);
      if($user_role['context_role_id'] =='5')
    {
        $user_type = 'Hindsight';
    }
    else
    {
        $user_type = 'Advice';
    }


  ?>
      <tr class= "get-question-modal"  data-type = "<?php echo $user_type; ?>" data-id = <?php echo $rec['AskQuestion']['id'];?>  data-direction='right'>
                      <td><input  type="checkbox" class="check-hindsight" name="AskQuestion[]" value="<?php echo $rec['AskQuestion']['id'];?>" ></td>
                    <td title= "<?php echo $rec['Category']['category_name'];?>"><?php echo $this->Eluminati->text_cut($rec['Category']['category_name'], $length = 10, $dots = true); ?></td>    
                       <td><?php echo date('M j, Y', strtotime($rec['AskQuestion']['added_on']));?></td>             
                       <td><?php echo $rec['User']['first_name']." ".$rec['User']['last_name'];?></td>       
                    <td><a   ><?php echo $this->Eluminati->text_cut($rec['AskQuestion']['description'], $length = 25, $dots = true); ?></a></td>  
                     <td class="<?php echo $rec['AskQuestion']['status'] ; ?>" data-id = '<?php echo $rec['AskQuestion']['id'];?>'><?php echo ucfirst($rec['AskQuestion']['status']) ; ?></td>                         
                        <td><a >View &amp; Reply</a></td>
                    </tr>
        <?php } ?>
<?php } ?>
<?php echo '#$$#'.$total_count;?>