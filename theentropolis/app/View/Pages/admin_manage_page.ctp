<div class="col-md-10 content-wraaper admin-wrap">		
	<div class="title dashboard-title">
		<h1>Manage Pages</h1>
		<div class="title-sep-container">
			<div class="title-sep"></div>		
		</div>
		<?php echo $this->Html->link('Add New',array('controller'=>'pages','action'=>'addPage'),array('class'=>'right btn btn-orange-small ')); ?>
	</div>			
	<div class="table-wrap">
		<table class="table table-striped table-hover manage-table action-table" cellspacing="0" cellpadding="0" width="100%">
			<thead>
				<tr>
					<th>S.No</th>
					<th>Page Title</th>							
					<th>Created Date</th>
					<th>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php static $count = 1;	
				foreach ($page_data as $page_detail) { ?>
				<tr>
					<td><?php echo $count; $count++;?></td>
					<td class = 'page-title' value = "<?php echo ucfirst($page_detail['Page']['title']);?> "><?php echo ucwords($page_detail['Page']['title']);?></td>
					<td><?php echo date("M j, Y ",strtotime($page_detail['Page']['page_created']));?></td>							
					<td>
						<div class="actions">
							<!--  <a href="viewPage">View</a>  -->

						 <?php 

						   $a =  urldecode($page_detail['Page']['title']);
						echo $this->Html->link('View',array('admin'=>false,'controller'=>'pages','action'=>'cms',$a));?> 

							<!-- <a href="edit-pages.php">Edit</a> -->
							<?php echo $this->Html->link('Edit',array('controller'=>'pages','action'=>'editPage','?'=>array('page_id'=>$page_detail['Page']['id'])));?>
								<a href="#" class= 'delete-page' data-id ="<?php echo $page_detail['Page']['id'];?>">Delete</a>  
							
						</div>
					</td>
				</tr>						
				<?php }?>
			</tbody>
		</table>
	</div>
</div> <!-- content-wraaper ends -->

