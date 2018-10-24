<div class="top-grey-strip-bg margin-bottom">
    <div class="container">
        <div class="page-title">
            BECOME A PIONEER CITIZEN
        </div>
    </div>
</div> 

<div class="register-display register-wrap container margin-bottom roboto_light" >
	<p><b>You are going to fit right in here!</b></p>
	<p>Anyone who is part of the entrepreneurial adventure can apply to become a citizen of our private online city for entrepreneurs. Entrepreneurs, experts, advisors and thought leaders will join a rapidly growing, brilliant and committed group from around the world who are championing entrepreneurship and laying the foundations for a new, collaborative way of doing business.</p>
<p>Becoming a Citizen of TrepiCity is easy:</p>
	<div class="city-type-section register-section bg-style">
		<div class="row">
			<div class="col-md-5">
				<div class="numeric-no">
					1
				</div>
				<div class="register-title">
					<h1>SELECT YOUR CITIZEN TYPE</h1>
				</div>
			</div>
			<div class="col-md-7">
				<summary>
					<div class="row">
                    <div class="col-md-4">
                        <div class="city-radio">
                        	<input type="radio" value="" name="city" checked='checked'>
                        </div>
                        <div class="light-purpel checkbox-select active" data-type="seeker">
                             <?php echo $this->Html->image("seeker-icon.png") ?>
                           <!--  SEEKER <br> BADGE -->
                        </div>
                    </div>
                    <div class="col-md-8">
                        <p><span><b>SEEKER</b></span> - Citizens seeking qualified advice, mentoring, tools and apps, products and services required to build businesses in the real-world.</p>
                        
                    </div>
                </div>
				</summary>
				
                <summary>
                	<div class="row">
                    <div class="col-md-4">
                        <div class="city-radio">
                        	<input type="radio" name="city" value="" checked=''>
                        </div>
                        <div class="light-yellow checkbox-select active" data-type="seeker">
                              <?php echo $this->Html->image("sage-icon.png")?>
                           <!--  SEEKER <br> BADGE -->
                        </div>
                    </div>
                    <div class="col-md-8">
                        <p><span><b>SAGE</b></span> - Citizens providing wisdom, expertise and high quality resources purpose-built for entreprenurs.</p>
                        
                    </div>
                </div>
                </summary>
			</div>
		</div>
	</div>
	<div class="account-type-section register-section bg-style">
		<div class="row">
			<div class="col-md-5">
				<div class="numeric-no">
					2
				</div>
				<div class="register-title">
					<h1>SELECT YOUR ACCOUNT TYPE</h1>
				</div>
			</div>
			<div class="col-md-7">
			<summary>
				<div class="row">
                    <div class="col-md-4">

				      <div class="radio">
				        <label>
				          <input type="radio"> Individual
				        </label>
				      </div>
                    </div>
                    <div class="col-md-8">

                       <div class="radio">
					        <label>
					          <input type="radio"> Business/ Organisation
					        </label>
				      </div>
                    </div>
                </div>
			</summary>
				
           
			</div>
		</div>
	</div>
	<div class="account-fields-section register-section clearfix bg-style">
		<div class="row">
			<div class="col-md-6">
				<div class="numeric-no">
					3
				</div>
				<div class="register-title">
					<h1>Tell us a little bit about yourself</h1>
				</div>
			</div>
		</div>

		<div class="registration-form-fields register-display-detail">
			<div class="row">
			<div class="col-md-12">
				<div class="row">
		            <div class="col-sm-6 first">
			             <div class="form-group">
			              	<input type="text" class="form-control" id="" placeholder="Email">
			              </div>
			              <div class="form-group">
			              	<input type="text" class="form-control" id="" placeholder="First Name">
			              </div>
			              <div class="form-group">
			              	<input type="text" class="form-control" id="" placeholder="Last  Name">
			              </div>
			              <div class="form-group">
			              	   <label class="custom-select">
					                <?php echo $this->Form->input('stage_id', array('options'=>array(''=>'Country'),'id'=>'stage_id', 'class'=>'form-control', 'label'=>false));?>                          
					            </label>
			              </div>
		            </div>
		            <div class="col-sm-6 second">
		            	<div class="form-group">
		                	<input type="text" class="form-control" id="" placeholder="Confirm Email">
		                </div>
		              	<div class="form-group">
		              	   <label class="custom-select">
				                <?php echo $this->Form->input('stage_id', array('options'=>array(''=>'Entropolis Precinct'),'id'=>'stage_id', 'class'=>'form-control', 'label'=>false));?>                          
				            </label>
			            </div>
		                <div class="form-group">
		              	   <label class="custom-select">
				                <?php echo $this->Form->input('stage_id', array('options'=>array(''=>'Seeker or Sage Indentity'),'id'=>'stage_id', 'class'=>'form-control', 'label'=>false));?>                          
				            </label>
			            </div>
		               <div class="form-group">
		              	<input type="text" class="form-control" id="" placeholder="Are you part of a group? | [ENTER YOUR CODE HERE]">
		              </div>
		            </div>
		        </div>
			</div>
			<div class="col-md-6"></div>

		</div>
		</div>



	</div>
	<div class="account-fields-section register-section clearfix bg-style">
				<div class="row">
			<div class="col-md-12">
				<div class="numeric-no">
					4
				</div>
				<div class="register-title">
					<h1>To help us place you proprely in our city and curate our vital resources to add the most value to you whenever you are working in entropolis, please also share the following information(Optional)</h1>
				</div>
			</div>
		</div>

		<div class="registration-form-fields register-display-detail">
			<div class="row">
			<div class="col-md-12">
				<div class="row">
		            <div class="col-sm-6 first">
			             <div class="form-group">
			              	<input type="text" class="form-control" id="" placeholder="Your Website">
			              </div>
			              <div class="form-group">
			              	<label class="custom-select">
					                <?php echo $this->Form->input('stage_id', array('options'=>array(''=>'Your Network'),'id'=>'stage_id', 'class'=>'form-control', 'label'=>false));?>                          
					        </label>
			              </div>
			              <div class="form-group">
			              	<input type="text" class="form-control" id="" placeholder="Linked In">
			              </div>
			              <div class="form-group">
			              	   <input type="text" class="form-control" id="" placeholder="Twitter">
			              </div> 
			              <div class="form-group">
			              	   <input type="text" class="form-control" id="" placeholder="Facebook">
			              </div>
			              <div class="form-group">
			              	   <input type="text" class="form-control" id="" placeholder="Other Network">
			              </div>
		            </div>
		            <div class="col-sm-6 second">
		            	<div class="form-group">
		                	<textarea class="form-control" rows="3" placeholder="Tell us about yourself"></textarea>
		                </div>
		     
		            </div>
		        </div>
			</div>
			<div class="col-md-6"></div>

		</div>
		</div>
	</div>

 	<div class="subscribe-wrap">
 		<div class="row">
 			<div class="col-md-3">
 				<a href="/entropolis/users/register" class="btn btn-Orange-white">Set up your subscription</a>
 			</div>
 			<div class="col-md-9">
 				<span class="white subscribe-txt">You will be directed to Paypal to complete your transaction</span>
 			</div>
 		</div>
 	</div>
 	<div class="terms-wrap">
 		<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
		  <div class="panel panel-default">
		    <div class="panel-heading" role="tab" id="headingOne">
		      <h4 class="panel-title">
		        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
		          REGISTRATION AND PAYMENT TERMS & CONDITIONS
		         <i class="fa fa-angle-up"></i>
		        </a>
		      </h4>
		    </div>
		    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
		      <div class="panel-body">
		       
		      	<ul>
		      		<li>TrepiCity is a private business network therefore all applications received by TrepiCity|HQ will be qualified and 	citizenship will be confirmed based on meeting our population selection criteria.</li>
		      		<li>Your Citizenship will be confirmed via email and you will be provided an activation code to finish setting up your 		account online.
					</li>
		      		<li>Applicants who can be qualified as SAGES  may be eligible to have their Citizenship subscription fee waived by 			invitation or under circumstances to be assessed individually by TrepiCity | HQ
					</li>
		      		<li>Citizens who enter a  qualified promotional code will also receive a waiver or discount.
					</li>
					<li>Discount and waiver of fees will be confirmed in writing via email in conjunction with your account activation 
					</li>
		      	</ul>

		      </div>
		    </div>
		  </div>
 		</div>
</div>

<script type="text/javascript">
	
	$(".terms-wrap .panel-title a").click(function(){
		$(this).children('i.fa-angle-up').toggleClass('rotate');
	});
</script>