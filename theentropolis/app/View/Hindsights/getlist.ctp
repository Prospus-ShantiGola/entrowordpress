<?php if($fetch_type != 'loadmore') { ?>
<div class="tab-pane active" id="<?php echo $tab_name; ?>" >
    <table class="table table-striped table-condensed">
      <?php if(!empty($hindsight_data)) { ?>   
      <thead>
        <tr>
          <th>Date</th>
          <th>Title</th>
          <th>Category</th>
          <th>Posted By</th>
          <th>Rating</th>
        </tr>
      </thead>   
      <tbody>
        <?php foreach($hindsight_data as $rec) { ?>
        <tr>
          <td><?php echo date('d-M-Y', strtotime($rec['Hindsight']['hindsight_decision_date']));?></td>
          <td><?php echo $rec['Hindsight']['hindsight_title'];?> </td>
          <td><?php echo $rec['Category']['category_name'];?></td>
          <td><?php echo $rec['ContextRoleUser']['User']['first_name'].' '.$rec['ContextRoleUser']['User']['last_name'];?></td>
          <td><?php echo $this->Rating->getHindsightRating($rec['Hindsight']['id']);?> / 10<br />
            <a href="<?php echo Router::url(array('controller'=>'hindsights', 'action'=>'viewAndRate',$rec['Hindsight']['id']))?>">View & Rate</a></td>
        </tr>
        <?php } ?>
      </tbody>
      <?php } else {  ?>
        <tr><td>No records found!!</td></tr>
      <?php } ?>
    </table>
</div>
 <?php } else {?>  
 <?php foreach($hindsight_data as $rec) { ?>
        <tr>
          <td><?php echo date('d-M-Y', strtotime($rec['Hindsight']['hindsight_decision_date']));?></td>
          <td><?php echo $rec['Hindsight']['hindsight_title'];?> </td>
          <td><?php echo $rec['Category']['category_name'];?></td>
          <td><?php echo $rec['ContextRoleUser']['User']['username'];?></td>
          <td><?php echo $this->Rating->getHindsightRating($rec['Hindsight']['id']);?> / 10<br />
            <a href="<?php echo Router::url(array('controller'=>'hindsights', 'action'=>'viewAndRate',$rec['Hindsight']['id']))?>">View & Rate</a></td>
        </tr>
        <?php } ?>
<?php } ?>
<?php echo '#$$#'.$total;?>