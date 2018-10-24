<?php

if($fetch_type != 'loadmore') { ?>
<div class="tab-pane active" id="<?php echo $tab_name; ?>" >
    <table class="table table-striped table-condensed">
      <?php if(!empty($hindsight_data)) { ?>   
      <thead>
        <tr>
            <th>Select</th>
          <th>Date</th>
          <th>Posted By</th>
          <th>Title</th>
          <th>Category</th>
          
          <th>Rating</th>
        </tr>
      </thead>   
      <tbody>
        <?php foreach($hindsight_data as $rec) { 
            $rec['DecisionBank']=$rec['Hindsight'];
            ?>
        <tr>
            <td><div class="checkbox-btn">
              <input id="showmy" type="checkbox" class="check-hindsight" name="Hindsight[]" value="<?php echo $rec['DecisionBank']['id'];?>" >
                    </div></td>
          <td><?php echo date('d-M-Y', strtotime($rec['DecisionBank']['hindsight_decision_date']));?></td>
          <td><?php echo $rec['ContextRoleUser']['User']['first_name'].' '.$rec['ContextRoleUser']['User']['last_name'];?></td>
          <td><?php echo $rec['DecisionBank']['hindsight_title'];?> </td>
          <td><?php echo $rec['Category']['category_name'];?></td>
          
          <td><?php echo $this->Rating->getHindsightRating($rec['DecisionBank']['id']);?> / 10<br />
            </td>
        </tr>
        <?php } ?>
      </tbody>
      <?php } else {  ?>
        <tr><td>No records found!</td></tr>
      <?php } ?>
    </table>
</div>
 <?php } else {?>  
 <?php foreach($hindsight_data as $rec) { ?>
        <tr>
          <td><?php echo date('d-M-Y', strtotime($rec['DecisionBank']['hindsight_decision_date']));?></td>
           <td><?php echo $rec['ContextRoleUser']['User']['username'];?></td>
          <td><?php echo $rec['DecisionBank']['hindsight_title'];?> </td>
          <td><?php echo $rec['Category']['category_name'];?></td>
          <td><?php echo $this->Rating->getHindsightRating($rec['DecisionBank']['id']);?> / 10<br />
            <a href="<?php echo Router::url(array('controller'=>'decisionBanks', 'action'=>'viewAndRate',$rec['DecisionBank']['id']))?>">View & Rate</a></td>
        </tr>
        <?php } ?>
<?php } ?>
<?php echo '#$$#'.$total;?>