
<?php if($fetch_type != 'loadmore') { ?>
<div class="tab-pane active" id="<?php echo $tab_name; ?>" >
  <form>
     <?php  if(!empty($hindsight_data)) {  ?>

      
    <button type="button" name="delete-btn" class="btn  btn-orange-small margin-top-small large right del-btn my_decisionbank delete-hindsight" disabled>Delete</button>
 
     <?php } ?>
    <table class="table table-striped table-condensed my_decisionbank purpel-hover remove-scroll">
       
      <thead>
        <tr>
          <th><input  type="checkbox" class="check_all" name="" value="" ></th>
          <th>Sub-Category</th>
          <th>Date</th>
          <th>Posted By</th>
          <th>Title</th>          
          <th>Rating</th>
          <th>Actions</th>
           
        </tr>
      </thead> 
       <?php if(!empty($hindsight_data)) { ?>   
      <tbody>
        <?php foreach($hindsight_data as $rec) { ?>
        <tr  class="get-data-seeker-modal" data-toggle="modal" data-direction='right' data-id=<?php echo $rec['DecisionBank']['id'];?> data-type="DecisionBank">
          <td><input  type="checkbox" class="check-hindsight" name="DecisionBank[]" value="<?php echo $rec['DecisionBank']['id'];?>" ></td>
          <td title= "<?php echo $rec['Category']['category_name'];?>"><?php echo $this->Eluminati->text_cut($rec['Category']['category_name'], $length = 10, $dots = true); ?></td> 
                    <td><?php echo date('M j, Y', strtotime($rec['DecisionBank']['hindsight_decision_date']));?></td>
                    <td><?php echo $rec['ContextRoleUser']['User']['username'] ;?></td>
                     <td title= "<?php echo $rec['DecisionBank']['hindsight_title'];?>">
                                    <a><?php echo $this->Eluminati->text_cut($rec['DecisionBank']['hindsight_title'], $length = 25, $dots = true); ?></a>
                                </td>
                    
                    <td><?php echo $this->Rating->getHindsightRating($rec['DecisionBank']['id']);?> / 10<br /></td>
                     <td><a><i class="fa fa-eye"></i></a></td>
                      
        </tr>
        <?php } ?>
      </tbody>
      <?php } else {  ?>
        <tr  ><td colspan= '7' style = "background-color:#f2f2f2; text-align:center;" class="no-record">No records found.</td></tr>
      <?php } ?>
    </table>

</form>
</div>


 <?php } else {?>  
 <?php foreach($hindsight_data as $rec) { ?>
        <tr  class="get-data-seeker-modal" data-toggle="modal" data-direction='right' data-id=<?php echo $rec['DecisionBank']['id'];?> data-type="DecisionBank">
           <td><input  type="checkbox" class="check-hindsight" name="DecisionBank[]" value="<?php echo $rec['DecisionBank']['id'];?>" ></td>
           <td title= "<?php echo $rec['Category']['category_name'];?>"><?php echo $this->Eluminati->text_cut($rec['Category']['category_name'], $length = 10, $dots = true); ?></td> 
                    <td><?php echo date('M j, Y', strtotime($rec['DecisionBank']['hindsight_decision_date']));?></td>
                    <td><?php echo $rec['ContextRoleUser']['User']['username'] ;?></td>
                     <td title= "<?php echo $rec['DecisionBank']['hindsight_title'];?>">
                                    <a><?php echo $this->Eluminati->text_cut($rec['DecisionBank']['hindsight_title'], $length = 25, $dots = true); ?></a>
                                </td>
                   
                    
                    <td><?php echo $this->Rating->getHindsightRating($rec['DecisionBank']['id']);?> / 10<br /></td>
                     <td><a><i class="fa fa-eye"></i></a></td>
                     
        </tr>
        <?php } ?>
<?php } ?>
<?php echo '#$$#'.$total;?>


