
<?php if($fetch_type != 'loadmore') { ?>
<div class="tab-pane active" id="<?php echo $tab_name; ?>" >
  <form method="post" action="">
    <?php  if(!empty($advice_data)) {  ?>
           <button type="button" name="button" class="btn search-bar-button1 delete-advice" disabled>Delete</button> 
           <?php }?>
    <table class="table table-striped table-condensed advice_management admin-advice remove-scroll">
      <?php if(!empty($advice_data)) { ?>   
      <thead>
        <tr>
                <th><input  type="checkbox" class="check_all" name="" value="" ></th>
                <th>Sub-Category</th> 
                <th>Date</th>
                <th>Posted By</th>
                <th>Title</th>                                   
                <th>Rating</th>
                 <th>View</th>
        </tr>
      </thead>   
      <tbody>
        <?php foreach($advice_data as $rec) { ?>
        <tr class= "get-new-modal" data-type = "Advice" data-id = <?php echo $rec['Advice']['id'];?>  data-direction='right'>
           <td><input  type="checkbox" class="check-hindsight" name="Advices[]" value="<?php echo $rec['Advice']['id'];?>" ></td>
              <td title= "<?php echo $rec['Category']['category_name'];?>"><?php echo $this->Eluminati->text_cut($rec['Category']['category_name'], $length = 10, $dots = true)  ?></td>
           <td><?php echo date('M j, Y', strtotime($rec['Advice']['advice_decision_date']));?></td>
          <td><?php echo $rec['ContextRoleUser']['User']['first_name'].' '.$rec['ContextRoleUser']['User']['last_name'];?></td>
               <td title= "<?php echo $rec['Advice']['advice_title'];?>"><a ><?php echo $this->Eluminati->text_cut($rec['Advice']['advice_title'], $length = 20, $dots = true); ?></a></td>
      
          
          <td><?php echo $this->Rating->getRating($rec['Advice']['id']); ?> / 10<br>
          </td>
            <td>
               <a ></i></a>
               
               
            </td>
        </tr>
        <?php } ?>
      </tbody>
      <?php } else {  ?>
         <tr><td colspan= '7' style = "background-color:#f2f2f2; text-align:center;">No records found.</td></tr>
      <?php } ?>
    </table>


</div>
 <?php  if(!empty($advice_data)) {  ?>

      <!--  <div class="margin-bottom clearfix  right margin-left">
    <button type="submit" name="submit" class="btn  btn-orange-small margin-top-small large right">Delete Selected </button>
  </div> -->
     <?php } ?>
   </form>

    <?php if($total>10){?>
    <div class="margin-bottom clearfix " id="loadmorebtn">
      <button class="btn  btn-orange-small margin-top-small large right" onclick="loadmoredata();">Load More</button>
    </div>
      <?php }?>

 <?php } else {?>  
 <?php foreach($advice_data as $rec) { ?>
        <tr class= "get-new-modal" data-type = "Advice" data-id = <?php echo $rec['Advice']['id'];?>  data-direction='right'>
          <td><input  type="checkbox" class="check-hindsight" name="Advices[]" value="<?php echo $rec['Advice']['id'];?>" ></td>
          <td title= "<?php echo $rec['Category']['category_name'];?>"><?php echo $this->Eluminati->text_cut($rec['Category']['category_name'], $length = 10, $dots = true)  ?></td>
           <td><?php echo date('M j, Y', strtotime($rec['Advice']['advice_decision_date']));?></td>
           <td><?php echo $rec['ContextRoleUser']['User']['username'];?></td>
             <td title= "<?php echo $rec['Advice']['advice_title'];?>"><a ><?php echo $this->Eluminati->text_cut($rec['Advice']['advice_title'], $length = 20, $dots = true); ?></a></td>
      
        
          
          <td><?php echo $this->Rating->getRating($rec['Advice']['id']); ?> / 10<br>
          </td>
            <td>
                <a ><i class="fa fa-eye"></i></a>
             
            </td>
              
        </tr>
        <?php } ?>
<?php } ?>
<?php echo '#$$#'.$total;?>



