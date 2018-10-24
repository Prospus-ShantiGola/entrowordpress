
<?php if($fetch_type != 'loadmore') { ?>
<div class="tab-pane active" id="<?php echo $tab_name; ?>" >
    <!--   <?php  if(!empty($data)) {  ?>
            <button type="button" name="delete-btn" class="btn Black-Btn btn-large margin-top-small adjust-delete-btn large right del-btn delete-hindsight" disabled style="opacity:0.2;">Delete</button>
            <?php } ?> -->
                    <table class="table table-striped ask-table-wrap">
                      <thead>
                        <th><input  type="checkbox" class="check_all" name="" value="" ></th>
                        <th>Sub - Category</th>
                        <th>Date</th>                    
                        <th>Question</th>
                        <th>Status</th>
                        <th>Action</th>
                       </thead>                  
                    </table> 
                    <div  class="scrollTo-demo"  id="demo">
                        <div class="items" id="info">
                            <div class="demo-y set-wrap-height"> 
                         <table class="table table-striped table-condensed ask-table-wrap">
                  <tbody> 
                     <?php  if(!empty($data)) { 

                      //pr($data);die;?>
                     <?php foreach($data as $rec) { ?>
                    <tr  class= "get-question-modal" data-type = "<?php echo $user_type; ?>" data-id = <?php echo $rec['AskQuestion']['id'];?>  data-direction='right' >
                      <td><input  type="checkbox" class="check-hindsight" name="AskQuestion[]" value="<?php echo $rec['AskQuestion']['id'];?>" ></td>
                    <td title= "<?php echo $rec['Category']['category_name'];?>"><?php echo $this->Eluminati->text_cut($rec['Category']['category_name'], $length = 10, $dots = true); ?></td>    
                       <td><?php echo date('M j, Y', strtotime($rec['AskQuestion']['added_on']));?></td>             
                      <td><a ><?php echo $this->Eluminati->text_cut($rec['AskQuestion']['description'], $length = 25, $dots = true); ?></a></td>  
                     <td class="<?php echo $rec['AskQuestion']['status'] ; ?>"><?php echo ucfirst($rec['AskQuestion']['status']) ; ?></td>                            
                      <td><a >View</a></td>
                    </tr>
                      <?php } ?>                         
                  </tbody> 
                  <?php } else { ?>
                      
                        <tr class= "<?php  echo '0'; ?>">
                            <td colspan= '7' style = "background-color:#f2f2f2; text-align:center;" class="no-record">No records found.</td>
                        </tr>
                        
                        <?php } ?>                 
                </table>  
                  <?php if($total_count>10){?>
                    <div class="margin-bottom clearfix load-more right" id="loadmorebtn">
                        <button class="btn  btn-orange-small large right" onclick="loadmoredata();">Load More</button>
                    </div>
                    <?php }?>

              </div>   
            </div> 
          </div>  
</div>
 <?php } else {?>  
 <?php foreach($data as $rec) { ?>
       <tr class= "get-question-modal" data-type = "<?php echo $user_type; ?>" data-id = <?php echo $rec['AskQuestion']['id'];?>  data-direction='right'>
                      <td><input  type="checkbox" class="check-hindsight" name="AskQuestion[]" value="<?php echo $rec['AskQuestion']['id'];?>" ></td>
                    <td title= "<?php echo $rec['Category']['category_name'];?>"><?php echo $this->Eluminati->text_cut($rec['Category']['category_name'], $length = 10, $dots = true); ?></td>    
                       <td><?php echo date('M j, Y', strtotime($rec['AskQuestion']['added_on']));?></td>             
                      <td><a ><?php echo $this->Eluminati->text_cut($rec['AskQuestion']['description'], $length = 25, $dots = true); ?></a></td>  
                     <td class="<?php echo $rec['AskQuestion']['status'] ; ?>"><?php echo ucfirst($rec['AskQuestion']['status']) ; ?></td>                            
                      <td><a >View</a></td>
                    </tr>
        <?php } ?>
<?php } ?>
<?php echo '#$$#'.$total_count;?>