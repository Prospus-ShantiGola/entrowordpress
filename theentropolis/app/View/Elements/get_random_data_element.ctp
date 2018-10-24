
<?php  

if(strtoupper($obj_type) == strtoupper('Publication')){
    foreach($publication as $public){

  //  $string =	$public['Publication']['source_name'];
 //echo $this->Eluminati->Cut($string, 35);
    	?>

<li>


   <a href="<?php if(!($this->Session->read('user_id'))){echo Router::url(array('controller'=>'users', 'action'=>'register'));}else {echo $public['Publication']['rss_feed'];}?>" target= "_blank" title ="<?php echo $public['Publication']['source_name']; ?>"><?php echo $this->Eluminati->text_cut(trim($public['Publication']['source_name']), $length = 35, $dots = true); ?></a>
 <!--  <a href="#"><?php echo $public['Publication']['source_name']; ?></a> -->
<!--     <span>Category: <?php echo $public['Category']['category_name'];?></span> -->

<span  title = "<?php echo $public['Category']['category_name']; ?>"> Category: <?php echo $this->Eluminati->text_cut(trim($public['Category']['category_name']), $length = 10, $dots = true); ?></span>


    <span>Published By: <?php echo $public['Publication']['author_first']." ".$public['Publication']['author_last'];?></span>
</li>
<?php }
}else if(strtoupper($obj_type) == strtoupper('hindsight')){


  foreach($hindsight as $hindsight_data){
    $context_role_user_id = $hindsight_data["ContextRoleUser"]["id"];
    $hindsight_id = $hindsight_data["Hindsight"]["id"];
    ?>
<li>
<!-- <a href="<?php if(!($this->Session->read('user_id'))){echo Router::url(array('controller'=>'users', 'action'=>'register'));}else{?>javascript:void(0);<?php }?>"><?php echo $this->Eluminati->text_cut(trim($hindsight_data['Hindsight']['hindsight_title']), $length = 35, $dots = true); ?></a> -->


<a href="<?php if(!($this->Session->read('user_id'))){echo Router::url(array('controller'=>'users', 'action'=>'register'));}else{echo Router::url(array('controller'=>'pages', 'action'=>'seekerProfile/'.$context_role_user_id.'/'.$hindsight_id)); }?>" <?php if($this->Session->read('user_id')){ ?>target='_blank' <?php } ?> title ="<?php echo $hindsight_data['Hindsight']['hindsight_title']; ?>"><?php echo $this->Eluminati->text_cut(trim($hindsight_data['Hindsight']['hindsight_title']), $length = 35, $dots = true); ?></a>

     <span  title = "<?php echo $hindsight_data['Category']['category_name']; ?>"> Category: <?php echo $this->Eluminati->text_cut(trim($hindsight_data['Category']['category_name']), $length = 10, $dots = true); ?></span>


    <span>Published By: <?php echo $hindsight_data['ContextRoleUser']['User']['first_name']." ".$hindsight_data['ContextRoleUser']['User']['last_name'];?></span>
</li>


 <?php } }else {


  // for($i =0 $i<=count($result);$i++){
  	foreach ($result as $key => $value) {
     $context_role_user_id = $value["other_id"];
     $obj_id = $value["id"];

  	?>
<li>

  <?php 
  if( $value['obj_type'] =='Advice' )
  {?>

<a href="<?php if(!($this->Session->read('user_id'))){echo Router::url(array('controller'=>'users', 'action'=>'register'));}else{echo Router::url(array('controller'=>'pages', 'action'=>'sageProfile/'.$context_role_user_id.'/'.$obj_id)); }?>" <?php if($this->Session->read('user_id')) { ?>target='_blank' <?php } ?> title ="<?php echo $value['title']; ?>" data-type="<?php echo $value['obj_type'];  ?>"><?php echo $this->Eluminati->text_cut(trim($value['title']), $length = 35, $dots = true); ?></a>

 <?php  }else{?>

<a href="<?php if(!($this->Session->read('user_id'))){echo Router::url(array('controller'=>'users', 'action'=>'register'));}else{echo Router::url(array('controller'=>'pages', 'action'=>'eluminatiProfile/'.$context_role_user_id.'/'.$obj_id)); }?>" <?php if($this->Session->read('user_id')) { ?>target='_blank' <?php } ?>  title ="<?php echo $value['title']; ?>"  data-type="<?php echo $value['obj_type'];  ?>"><?php echo $this->Eluminati->text_cut(trim($value['title']), $length = 35, $dots = true); ?></a>


 <?php }

  ?>
 
<!-- <a href="#" data-type="<?php echo $value['obj_type'];  ?>"><?php echo $value['title']; ?></a> -->
   <!--  <span>Category: <?php echo $value['category'];?></span> -->
   <span  title = "<?php echo $value['category']; ?>"> Category: <?php echo $this->Eluminati->text_cut(trim($value['category']), $length = 10, $dots = true); ?></span>
    <span>Published By: <?php echo $value['author_name'];?></span>
</li>


 <?php   if($key==3)
{
	break;
}}

 } ?>
