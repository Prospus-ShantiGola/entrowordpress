<?php 
if($total > 0 ){
foreach($publication_data as $rec) { ?>
<tr>
    <td title ="<?php echo $rec['Category']['category_name'];?>" ><?php if(strlen($rec['Category']['category_name']) > 20){
          echo substr($rec['Category']['category_name'], 0, 20).'..';
      }
      else{  
    echo $rec['Category']['category_name']; 
      } ?></td>
      <td><?php echo ucfirst(htmlspecialchars_decode($rec['Publication']['author_first'], ENT_NOQUOTES)).' '.ucfirst(htmlspecialchars_decode($rec['Publication']['author_last'], ENT_NOQUOTES)) ;?></td>
      <td><?php echo $rec['Publication']['date_published']!= '0000-00-00' ?  date('j M Y', strtotime($rec['Publication']['date_published'])) : '';?></td>      
      <td title ="<?php echo $rec['Publication']['source_name'];?>"><?php if(strlen($rec['Publication']['source_name']) > 25){
          echo substr($rec['Publication']['source_name'], 0, 25).'..';
      }
      else{  
    echo $rec['Publication']['source_name']; 
      } ?></td>
      <td><a href="<?php echo $rec['Publication']['rss_feed'];?>" target="_blank">
<?php if(strlen($rec['Publication']['rss_feed']) > 25){
          echo substr($rec['Publication']['rss_feed'], 0, 25).'..';
      }
      else{  
	  echo $rec['Publication']['rss_feed']; 
      } ?></a></td>                                     
  </tr>
<?php } 
}
else{
    echo '<tr class="no-record"><td colspan="5" style="background-color: #f7f7f7">No records found.</td></tr>';	
}
?>
  <tr style="display:none;" class="numberRecord">
<td colspan="5" class="numData"><?php echo count($publication_data);?></td></tr>

                               