

<table class="table table-striped ask-table-wrap">
			<thead>
				<th>Category</th>
				<th>Sub - Category</th>
				<th>Question</th>
				<th>Date</th>
				<th>Status</th>
				<th>Action</th>
			</thead>
			<tbody>	
				<?php 

				if(!empty($data)){
				foreach($data as $question){?>
				<tr>			
					<td><?php echo $question['DecisionType']['decision_type'] ; ?></td>
					<td><?php echo $question['Category']['category_name'] ; ?></td>
					<td><a href="#"><?php echo $question['AskQuestion']['question_title'] ; ?></a></td>
					<td><?php echo date("M j,Y",strtotime($question['AskQuestion']['added_on'] )); ?></td>
					<td class="pending"><?php echo ucfirst($question['AskQuestion']['status']) ; ?></td>
					<td><a href="">View</a></td>
				</tr>
			
				<!-- <tr>			
					<td>Technology</td>
					<td>Human Resources Strategy</td>
					<td><a href="#">Lorem ipsum dolor sit amet, consectetur adipisci elit, sed dobvbvnnbvb eiusmod tempr ...</a></td>
					<td>Jan 2, 2015</td>
					<td class="rejected">Replied</td>
					<td><a href="">View</a></td>
				</tr> -->
				<?php }}else{?>
			  <tr><td colspan= '7' style = "background-color:#f1f1f1; text-align:center;">No records found.</td></tr>
				<?php }?>
				 
							
			</tbody>
		
		</table>