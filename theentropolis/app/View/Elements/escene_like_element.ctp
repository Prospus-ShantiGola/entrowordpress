
<?php
//pr($like_data);
foreach($like_data as $username)
{?>
<p><a href="#" data-id="user-<?php echo $username['User']['id'] ?>"><?php echo $username['User']['first_name']." ".$username['User']['last_name'];?></a></p>
<?php }
?>
