<?php include_once 'admin-header.php';?>


<section id="admin-users">
	<div class="container-fluid" id="content">
		<?php include_once 'admin-sidebar.php';?>

		<div class="col-md-10 content-wraaper admin-wrap">		
			<div class="title dashboard-title">
				<h1>Users</h1>
				<div class="title-sep-container">
					<div class="title-sep"></div>		
				</div>
				<a href="new-user.php" class="right btn btn-orange-small">Invite New User</a>
			</div>
			<div class="page-nav">
				<ul class="nav nav-pills">
					<li><a href="users-active.php" class="active">Active</a></li>
					<li><a href="users-blocked.php">Blocked</a></li>
					<li><a href="user-invited.php">Invited</a></li>
				</ul>
			</div>
			<div class="bg filter-box">
				<h4>Filter</h4>
				<form action="" class="form-inline">
					<div class="form-group">
				    	<label class="">Name</label>
				   	 	<input type="text" class="form-control" placeholder="Enter name">
				  	</div>
					<div class="form-group">
				    	<label class="">Email address</label>
				   	 	<input type="email" class="form-control" placeholder="Enter email">
				  	</div>
				  	<button type="submit" class="btn btn-orange-small">Filter</button>
				</form>
			</div>
			<div class="table-wrap">
				<table class="table table-striped table-hover user-table action-table" cellspacing="0" cellpadding="0" width="100%">
					<thead>
						<tr>
							<th></th>
							<th>Name</th>
							<th>Email Id</th>
							<th>Gender</th>
							<th>User Type</th>
							<th>Last login</th>
							<th>User Since</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php static $count = 1;
						for ($i=0; $i<=2; $i++) { ?>
						<tr>
							<td><?php echo $count; $count++;?></td>
							<td>Brian Smith</td>
							<td>briansmith@gmail.com</td>
							<td>Male</td>
							<td>Challenger</td>
							<td>4 mins ago</td>
							<td>4th May 2005</td>
							<td>
								<div class="actions">
									<a href="#block-user" data-toggle="modal">Block</a>
									<a href="#delete-user" data-toggle="modal">Delete</a>
								</div>
							</td>
						</tr>
						<tr>
							<td><?php echo $count; $count++;?></td>
							<td>Chad Diamond</td>
							<td>chaddiamond@gmail.com</td>
							<td>Male</td>
							<td>Visitor</td>
							<td>41 mins ago</td>
							<td>14th June 2005</td>
							<td>
								<div class="actions">
									<a href="#block-user" data-toggle="modal">Block</a>
									<a href="#delete-user" data-toggle="modal">Delete</a>
								</div>
							</td>
						</tr>
						<tr>
							<td><?php echo $count; $count++;?></td>
							<td>James Donovan</td>
							<td>jamesdonovan@gmail.com</td>
							<td>Male</td>
							<td>Judge</td>
							<td>15 mins ago</td>
							<td>14th August 2005</td>
							<td>
								<div class="actions">
									<a href="#block-user" data-toggle="modal">Block</a>
									<a href="#delete-user" data-toggle="modal">Delete</a>
								</div>
							</td>
						</tr>
						<?php }?>
						<tr>
							<td>10</td>
							<td>Brian Smith</td>
							<td>briansmith@gmail.com</td>
							<td>Male</td>
							<td>Challenger</td>
							<td>4 mins ago</td>
							<td>4th May 2005</td>
							<td>
								<div class="actions">
									<a href="#block-user" data-toggle="modal">Block</a>
									<a href="#delete-user" data-toggle="modal">Delete</a>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="align-right">
				<ul class="pagination pagination-sm">
					<li><a href="#">«</a></li>
					<li class="active"><a href="#">1</a></li>
					<li><a href="#">2</a></li>
					<li><a href="#">3</a></li>
					<li><a href="#">4</a></li>
					<li><a href="#">5</a></li>
					<li><a href="#">»</a></li>
				</ul>
			</div>
			
		</div> <!-- content-wraaper ends -->
	</div> <!-- container-fluid ends -->
</section>

<div class="modal fade in" id="block-user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
	<div class="modal-dialog">
	    <div class="modal-content">
		    <div class="modal-body no-header ">
		    	<button type="button" class="close no-header-button" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
		      	<p>Are you sure you want to block this user?</p>
			</div>
	        <div class="modal-footer">
		        <button type="button" class="btn btn-black" data-dismiss="modal">Yes</button>
		        <button type="button" class="btn btn-black" data-dismiss="modal">No</button>
		    </div>
	    </div>
	</div>
</div>

<div class="modal fade in" id="delete-user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
	<div class="modal-dialog">
	    <div class="modal-content">
		    <div class="modal-body no-header ">
		    	<button type="button" class="close no-header-button" data-dismiss="modal" aria-hidden="true"><i class="icons close-icon"></i></button>
		      	<p>Are you sure you want to delete this user?</p>
			</div>
	        <div class="modal-footer">
		        <button type="button" class="btn btn-black" data-dismiss="modal">Yes</button>
		        <button type="button" class="btn btn-black" data-dismiss="modal">No</button>
		    </div>
	    </div>
	</div>
</div>





