
<style>
	
	.col-md-9.judge-tab-sidebar h2 span {
    color: #666666;
    font-size: 12px;
    font-weight: normal;
    margin-left: 10px;
}
.judge-challenge-div{ display:none;
}
</style>
<?php 
	if(!empty($challenge_data)){
		
?>
<div class="col-md-10 content-wraaper loader-fade-fullscreen my_challenge">	

			<div class="title dashboard-title  my_challenge">
				<h1><span class="challenge-id"><?php echo $challenge_data['Challenge']['id'];?> -</span> <?php echo $challenge_data['Challenge']['challenge_title'];?> </h1>
				<div class="title-sep-container">
				<div class="title-sep"></div>		
				</div>
				<div class ="loader-data"></div>
				<?php echo $this->Html->link('Back',array('Controller'=>'challenges','action'=>'challengeManagement'),array(' class'=>"right btn btn-orange-small"))?>
				
			</div>
		
			<div class="home-display set-challenge-id cantainer-scroller-margin" id="container-scroll" data-id = "<?php echo $challenge_data['Challenge']['id'];?>">
			
					<div class="col-md-12 judge-challenge">
						<p><strong>Start Date:</strong><?php echo date("d M Y",strtotime($challenge_data['Challenge']['challenge_start_date']));?></p>
						<p><strong>End Date:</strong><?php echo date("d M Y",strtotime($challenge_data['Challenge']['challenge_end_date']));?></p>
						<p><strong>Status:</strong><?php if($challenge_data['Challenge']['challenge_status']=='1'){ echo 'Ongoing';}else{echo 'Completed';} ?></p>
						<div class="row">
							<div class="col-md-5"> 

							<?php	//pr($decision_types );die; ?>
								<select class="form-control decision-type-hindsight"  onchange="getAllChallengeByDecisionTypeAdmin(this,<?php echo $challenge_data['Challenge']['id'];?>);">
									<?php 

									 foreach($decision_types as $result){?>
									<option value="<?php echo  $result['Challenge']['id']; ?>">Hindsight - <?php echo $result['Challenge']['decision_type'];?></option>
										<?php } ?>
								
										<option value="Grand Winner">Grand Winner</option>

									
									
								</select>
							</div>
						</div>
					</div>
			
				<div class="col-md-12 hindsight-tab judge-detail" id="div">
										  
				</div>	
			
				<button class="btn btn-orange-small margin-top-small large right " id="loadMore">Load More</button>
			</div>
		</div>
		<?php }?>

<script type="text/javascript">
 jQuery(document).ready(function(){

 	if(jQuery('.decision-type-hindsight').val()!='')
	{
		//alert("dg");
		obj = jQuery('.decision-type-hindsight');
		
		judgement_status ='pending';
		var challenge_id = jQuery(".set-challenge-id").data("id");
		
			//alert(challenge_id);

		getAllChallengeByDecisionTypeAdmin(obj,challenge_id,judgement_status);
	}


 });

//function to get values on tab on page "viewChallenge" of judge module 
function getChallengeByStatusAdmin(judgement_status,challenge_id,decision_type_id)
{
	//<img src="/entropolis/img/loading-upload.gif" >
	$(".loader-data").html('<div class="ajax-loader-style"><img src="<?php echo IMG_PATH.'img/loading-upload.gif'; ?>" ><div>');	
	decision_type_id = jQuery('.decision-type-hindsight').val();
	 challenge_type = (jQuery(obj).find(":selected").text()).split('-'); //either advice or hindsignt
	   challenge_type =  challenge_type[0];
	//alert(judgement_status);
	jQuery.ajax({
	 		'type':'POST',
	 		'url':'<?php echo Router::url(array('controller'=>'challenges', 'action'=>'getChallengeByStatusAdmin'));?>',
	 		'data':
	 		{
	 			'challenge_id':challenge_id,
	 			'decision_type_id':decision_type_id,
	 			'judgement_status':judgement_status,
	 			'challenge_type':challenge_type
	 		},
	 		'success':function(data)
	 		{
	 			$("div.ajax-loader-style").remove();
	 			var temp = data.split('~');
	 			jQuery('.tab-content').text('');
	 			jQuery('.tab-content').append(temp[0]);
	 			jQuery(".custom-pagination").text('');
	 			jQuery(".custom-pagination").append(temp[1]);
                
	 			//code for load more functionality
                size_li = $(".judge-challenge-div").size();

                if(size_li<=5){
                	jQuery("#loadMore").hide();
                }else{
                	jQuery("#loadMore").show();
                }

				x=5;
			    console.log(size_li);
			    $('.judge-challenge-div:lt('+x+')').show();
			    $('#loadMore').click(function () {
			        x= (x+5 <= size_li) ? x+5 : size_li;
			        $('.judge-challenge-div:lt('+x+')').show();
			         if( x== size_li )
			        {
			        	  $('#loadMore').hide();
			        }
			    });

	 		}

	 	});
}

function getAllChallengeByDecisionTypeAdmin(obj,challenge_id,judgement_status)
{
	//$(".loader-data").html('<div class="ajax-loader-style"><img src="/entropolis/img/loading-upload.gif" ><div>');	
	$(".loader-data").html('<div class="ajax-loader-style"><img src="<?php echo IMG_PATH.'img/loading-upload.gif'; ?>" ><div>');	
	var decision_type_id = jQuery(obj).val();
	if(decision_type_id =='Grand Winner')
	{
		judgement_status = 'shortlisted';

	}
	else
	{
		judgement_status = 'pending';
	}

	   challenge_type = (jQuery(obj).find(":selected").text()).split('-'); //either advice or hindsignt
	   challenge_type =  challenge_type[0];


	jQuery.ajax({
	 		'type':'POST',
	 		'url':'<?php echo Router::url(array('controller'=>'challenges', 'action'=>'getAllChallengeByDecisionTypeAdmin'));?>',
	 		'data':
	 		{
	 			'challenge_id':challenge_id,
	 			'decision_type_id':decision_type_id,
	 			'judgement_status':judgement_status,
	 			'challenge_type':challenge_type
	 			
	 		},
	 		'success':function(data)
	 		{
	 			$("div.ajax-loader-style").remove();
	 			//alert(data);
	 			jQuery('.hindsight-tab').text('');
	 			jQuery('.hindsight-tab').append(data);
	 			
	 			size_li = $(".judge-challenge-div").size();
	 			 if(size_li<=5){
                	jQuery("#loadMore").hide();
                }
                else{
                	jQuery("#loadMore").show();
                }
                               
			    
			    x=5;
			    console.log(size_li);
			    $('.judge-challenge-div:lt('+x+')').show();
			    $('#loadMore').click(function () {
			        x= (x+5 <= size_li) ? x+5 : size_li;
			        $('.judge-challenge-div:lt('+x+')').show();

			         if( x== size_li )
			        {
			        	  $('#loadMore').hide();
			        }
			    });


			}

		});

}


</script>


<!-- <script>
    
  $(document).ready(function () {
    size_li = $(".judge-challenge-div").size();
    x=5;
    console.log(size_li);
    $('.judge-challenge-div:lt('+x+')').show();
    $('#loadMore').click(function () {
        x= (x+5 <= size_li) ? x+5 : size_li;
        $('.judge-challenge-div:lt('+x+')').show();
    });
});
    </script> -->
   

