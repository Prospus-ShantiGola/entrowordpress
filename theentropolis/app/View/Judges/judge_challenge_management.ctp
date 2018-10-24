<?php 

//pr($challenge);
if(!empty($challenge)){
	 $challenge_id = $challenge[0]['challenges']['id'];
}else{
	$challenge_id ='';
}?>
<div class="col-md-10 content-wraaper admin-wrap" id = "<?php echo $challenge_id;?>">		
			<div class="title dashboard-title">
				<h1>Challenges</h1>
				<div class="title-sep-container">
					<div class="title-sep"></div>		
				</div>				
			</div>	 
			<!-- <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. </p>
					 -->
			<div class="table-wrap">
				<?php  if(empty($challenge) && (empty($grandjudge))){echo "No records found.";}else{?>
				<table class="table table-striped table-hover challenge-management action-table" cellspacing="0" cellpadding="0" width="100%">
					<thead>
						<tr>
							<th>Challenge Name</th>
						    <th>Decision Type</th> 
							<th>Start Date</th>
							<th>End Date</th>
							<th>Status</th>
							<!-- <th>Winner</th> -->
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php 
							if(!empty($challenge)){
							foreach ($challenge as  $value) {?>
						<tr>
							<td><?php echo $value['challenges']['challenge_title'];?></td>
							<td><?php echo $value['decision_types']['decision_type'];?></td>

							<td><?php echo date("m-d-Y",strtotime($value['challenges']['challenge_start_date']));?></td>
							<td><?php echo date("m-d-Y",strtotime($value['challenges']['challenge_end_date']));?></td>
							<td><?php if($value['challenges']['challenge_status']=='1'){echo 'Ongoing';}else{echo 'Completed';}?></td>
							<!-- <td>
								<?php if($value['challenges']['challenge_status']=='1'){echo '--';}else{echo 'winner';}?>
								</td> -->
							<td>
								<div class="actions">
									<?php if($value['challenge_judges']['invitation_status']=='1'){ echo $this->Html->link('View',array('controller'=>'judges','action'=>'viewChallenge',$value['challenges']['id']));}?>									
									<?php if($value['challenge_judges']['invitation_status']=='0'){?>
									<a href="javascript:void(0);" class = 'challenge-status' data-id ="challenge_judges-<?php echo $value['challenge_judges']['id'];?>">Accept</a>
									<a href="javascript:void(0);" class = 'challenge-status' data-id ="challenge_judges-<?php echo $value['challenge_judges']['id'];?>">Reject</a>
									<?php }
									?>
								</div>
							</td>
						</tr>
						<?php }}
							if(!empty($grandjudge)){
								foreach ($grandjudge as  $value) {
								?>
							<tr>
							<td><?php echo $value['challenges']['challenge_title'];?> (Grand Judge) </td>
								<td></td>
							<td><?php echo date("m-d-Y",strtotime($value['challenges']['challenge_start_date']));?></td>
							<td><?php echo date("m-d-Y",strtotime($value['challenges']['challenge_end_date']));?></td>
							<td><?php if($value['challenges']['challenge_status']=='1'){echo 'Ongoing';}else{echo 'Completed';}?></td>
							<!-- <td>
								<?php if($value['challenges']['challenge_status']=='1'){echo '--';}else{echo 'winner';}?>
								</td> -->
							<td>
								<div class="actions">
									<?php if($value['challenge_judge_grand_winners']['invitation_status']=='1'){ echo $this->Html->link('View',array('controller'=>'judges','action'=>'viewChallenge',$value['challenges']['id']));}?>									
									<?php if($value['challenge_judge_grand_winners']['invitation_status']=='0'){?>
									<a href="javascript:void(0);" class = 'challenge-status' data-id ="grand_judges-<?php echo $value['challenge_judge_grand_winners']['id'];?>">Accept</a>
									<a href="javascript:void(0);" class = 'challenge-status' data-id ="grand_judges-<?php echo $value['challenge_judge_grand_winners']['id'];?>">Reject</a>
									<?php }
									?>
								</div>
							</td>
						</tr>
							<?php } }?>
						
					</tbody>


				</table>
				<?php } ?>


			</div>



		</div> <!-- content-wraaper ends -->
<script type="text/javascript">
jQuery(document).ready(function(){

	 jQuery('.challenge-status').on('click',function(){
	 	var cancelobj = jQuery(this);
	 	var temp = (jQuery(this).data('id')).split('-');
	 	var challenge_id  = temp[1];
	 	var type = temp[0];
	 	var action = jQuery(this).text();
	 	if( action =='Accept')
	 	{
         bootbox.dialog({
                        message: "Do you want to accept this challenge ?",            
                        buttons: {
                            success: {
                                label: "Yes",
                                className: "btn-black",
                                callback: function() {
                                    updateChallengeStatusByJudge(cancelobj,challenge_id,type,action);
                                }
                            },
                            danger: {
                                label: "No",
                                className: "btn-black"                   
                            }

                        }
                    });
	 	
	 	}
	 	else
	 	{
                         bootbox.dialog({
                            message: "Are you sure you want to reject this challenge?",            
                            buttons: {
                                success: {
                                    label: "Yes",
                                    className: "btn-black",
                                    callback: function() {
                                        updateChallengeStatusByJudge(cancelobj,challenge_id,type,action);
                                    }
                                },
                                danger: {
                                    label: "No",
                                    className: "btn-black"                   
                                }

                            }
                        });
                         
                         
	 	}
	 	
});


});

function updateChallengeStatusByJudge(obj,challenge_id,type,action){
    //	alert(action);

  		jQuery.ajax({
 		'type':'POST',
 		'url':'<?php echo Router::url(array('controller'=>'judges', 'action'=>'updateChallengeStatusByJudge'));?>',
 		'data':
 		{
 			
 			'challenge_id':challenge_id,
 			'type':type,
 			 'action':action
 		},
 		'success':function(data)
 		{
 			//alert(data);
 			if(data)
 			{
 		
 				 if(action =='Accept')
 				 {
 				
 				 	obj.next( ".challenge-status" ).remove();
 				
 				 	obj.replaceWith("<a href='<?php echo Router::url(array('controller'=>'judges', 'action'=>'viewChallenge'));?>/"+data+"' target = '_blank'>View</a>");

 				}
 				 else
 				 {
 				 	obj.closest ('tr').remove();

 				 	 var rowCount = $('.action-table >tbody >tr').length;
	 				//alert(rowCount)
	 				if(rowCount=='0')
	 				{
	 					jQuery(".action-table").remove();
	 					jQuery(".table-wrap").append("No records found.");
	 				}

 				 }
 			}
 			
 		}

 	});
}



</script>