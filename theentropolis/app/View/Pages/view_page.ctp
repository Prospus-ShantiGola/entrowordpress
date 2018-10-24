<?php
//pr($datas)

//echo $baseUrl = "http://".$_SERVER['HTTP_HOST']."/files/ckFinderFiles/";//working on prod

if(empty($datas) )
{
	echo  "No Result Found";
}
else
{
foreach ($datas as  $value) {
}
 ?>
<div class="title">
	<h1><?php 
	if($value['title']=='Home'){
		echo 'Welcome';
	}
	else if($value['title']=='The Team')
	{
		echo 'Meet the brains behind the brand';
	}
	else
	{
		echo ucwords($value['title']);
	}?></h1>
	<div class="title-sep-container">
		<div class="title-sep"></div>
	</div>
</div>
<?php if(strtoupper($value['title'])=='PRIVACY AND SECURITY'){
 echo $value['description'];
	

}else{?>
<?php if($value['title']=='Home'){?><div class="home-display"><?php }?>
<div class="row">
	<?php echo $value['description'];
	 ?>
	
</div>
<?php if($value['title']=='Home'){?></div><?php }}
}?>