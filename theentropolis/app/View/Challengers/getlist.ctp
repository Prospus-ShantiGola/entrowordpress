<?php if($fetch_type != 'loadmore') {?>
<div class="tab-pane active" id="<?php echo $tab_name?>">
    <table class="table table-striped table-condensed" >
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
          <td><?php echo $rec['User']['first_name'].' '.$rec['User']['last_name'];?></td>
          <td>5 / 10<br />
            <a href="view-and-rate-a-decision.php">View &amp; Rate</a></td>
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
          <td><?php echo $rec['User']['first_name'].' '.$rec['User']['last_name'];?></td>
          <td>5 / 10<br />
            <a href="view-and-rate-a-decision.php">View &amp; Rate</a></td>
        </tr>
        <?php } ?>
<?php } ?>