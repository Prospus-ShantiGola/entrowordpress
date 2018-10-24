<script type="text/javascript">
 $(document).ready(function(){
    
var maxWords = 100;
$(".short_bio").on("input", function(event) {
 var $this, wordcount;
    $this = $(this);
    wordcount = $this.val().replace(/\n+/g, "IAMLINEBREAK ");
    wordcount = wordcount.split(" ").length;
    var textdata = $this.val();
    //mydata = textdata.replace(/  +/g, ' ');
    var total_cc = '100';   
        if (wordcount > maxWords) {
           setTimeout(function(){  
           textdata = textdata.replace(/\n+/g, "IAMLINEBREAK ");
           var limited = textdata.split((" "), maxWords);
           limited = limited.join(" "); 
           limited = limited.replace(/IAMLINEBREAK /g,"\n");
           limited = limited.replace(/IAMLINEBREAK/g,"");
           $this.val(limited);
           //return false;
             var new_cc = $this.val().replace(/\n+/g, "IAMLINEBREAK ");
             new_cc = new_cc.split(" ").length;
             jQuery(".count-remain").text((total_cc-new_cc)+" Words");
           
               if(event.keyCode != 8 && event.keyCode != 46 )
               {

                setTimeout(function(){
                  alert("You've reached the maximum allowed words.");
                  return false;
                }, 100);


              }
              }, 100);
        
     }
     else {


      if($this.val().trim() ==''){
           
              jQuery(".count-remain").text(total_cc+" Words");
          }
          else
          {
            jQuery(".count-remain").text((total_cc-wordcount)+" Words");
          }
    }
        });
});

$(document).ready(function(){
    // stop user to copy and paste in confirm email text box.
   $('#UserConfirmEmailAddress').on('copy paste', function(event) {
        event.preventDefault();
    });

 // work for stage id
var stage_id = <?php if(@$this->request->data['User']['stage_id']){ echo @$this->request->data['User']['stage_id'] ;}else {echo "0";}?>;

        if(jQuery('.user-role').is(':checked')){

             
                var checkd_value = $(".user-role:checked").val();
               
                jQuery.ajax({
                type:'post',
                url:"<?php echo Router::url(array('controller'=>'users', 'action'=>'getStage'))?>",
                data :
                {
                    'id':checkd_value,
                    'selected':stage_id
                },
                success:function(msg)
                {
                   jQuery('#stage_id').html(msg);
                }

            })

            } 

        $('.user-role').click(function(){
            
            var $this = $(this);
            // if($(this).is(':checked')){
            //      $('.checkbox-select.active').removeClass('active'); 
            //      $(this).siblings('.checkbox-select').addClass('active');                               
            // } 

            jQuery.ajax({
                type:'post',
                url:"<?php echo Router::url(array('controller'=>'users', 'action'=>'getStage'))?>",
                data :
                {
                    'id':$this.val(),
                    'selected':''
                },
                success:function(msg)
                {
                   jQuery('#stage_id').html(msg);
                }

            })
        });

    $('.register-user').click(function(){
    
    var pass = $("#UserEmailAddress").val();
    var confPass = $('#UserConfirmEmailAddress').val();
    //alert(pass +'>>>'+confPass);
    if(pass != confPass){
        var elements = document.getElementById("UserConfirmEmailAddress");    
        elements.setCustomValidity("Your email confirmation does not match.");        
       // return false;
    }
    
    else{
        
        var elements = document.getElementById("UserConfirmEmailAddress");   
        elements.setCustomValidity("");        
    }
    });    

});
</script>
<?php
//$this->request->data['User']['role']==''
// pr($_POST);
// echo $this->Session->read('flyout');
if(empty($_POST) && !$this->Session->read('flyout'))
{?>
<script type="text/javascript"> 
$(document).ready(function(){
jQuery('#citizenship').modal('show');

});
</script>
<?php  }?>



    <div class="top-grey-strip-bg margin-bottom">
        <div class="container">
            <div class="page-title">
                CITIZENSHIP APPLICATION
            </div>
        </div>
    </div> 

    <div class="register-display register-wrap container margin-bottom roboto_light" >
       <?php if(!$this->Session->read('register')){ 
        echo $this->Session->flash();
        } ?> 
        <div class="instruction">
            <p class="fitCaps"><b>You are going to fit right in here!</b></p>
            <p class="anySmall">Anyone who is part of the entrepreneurial adventure can apply to become a citizen of our private online city for entrepreneurs. Entrepreneurs, experts, advisors and thought leaders will join a rapidly growing, brilliant and committed group from around the world who are championing entrepreneurship and laying the foundations for a new, collaborative way of doing business.</p>
            <p class="becomeSmall">Becoming a Citizen of TrepiCity is easy:</p>
        </div>
          <?php echo $this->Form->create('User', array('class'=>'form-horizontal register-form', 'url'=>'/users/register'));?>
        <div class="city-type-section register-section bg-style alignResolve">
            <div class="row">
                <div class="col-md-5">
                    <div class="numeric-no modNumericNo">
                        1
                    </div>
                    <div class="register-title modRegisterTitle">
                        <h1>SELECT YOUR CITIZEN TYPE</h1>
                    </div>
                </div>
                <div class="col-md-7">
                    <summary>
                        <div class="row">
                        <div class="col-md-4">
                            <div class="city-radio">
                            <input type="radio" class="user-role <?php if(@$this->request->data['User']['role']=='5'){echo 'checked-class';}?>" value="5" name="data[User][role]" <?php if(@$this->request->data['User']['role']=='5'){ echo "checked='checked'";

                        }else{

                            echo "checked='checked'";

                            } ?>>
                            </div>
                            <div class="light-purpel checkbox-select active" data-type="seeker">
                                 <?php echo $this->Html->image("seeker-icon.png") ?>
                               <!--  SEEKER <br> BADGE -->
                            </div>
                        </div>
                        <div class="col-md-8">
                            <p><span><b>SEEKER</b></span></p>
                            <p class="citizen-title">Graduates | Entrepreneurs | Incubators | SMEs | Intrapreneurs | Socialpreneurs | Accelerators | Professional Networks | Training Organisations</p>
                        </div>
                    </div>
                    </summary>
                    
                    <summary>
                        <div class="row">
                        <div class="col-md-4">
                            <div class="city-radio">
                             <input type="radio" class="user-role <?php if(@$this->request->data['User']['role']=='6'){echo 'checked-class';}?> " value="6" <?php if(@$this->request->data['User']['role']=='6'){ echo "checked='checked'";

                        } ?> name="data[User][role]">
                            </div>
                            <div class="light-yellow checkbox-select active" data-type="seeker">
                                  <?php echo $this->Html->image("sage-icon.png")?>
                               <!--  SEEKER <br> BADGE -->
                            </div>
                        </div>
                        <div class="col-md-8">
                            <p><span><b>SAGE</b></span></p>
                              <p class="citizen-title">Experts | Service Providers | Mentors | Consultants | Advisors | Agencies | Coaches | Academics | Innovation & Ideation Firms | Authors | Expert Bloggers | Future Thinkers</p>
                        </div>
                    </div>
                    </summary>
                </div>
            </div>
        </div>
        <div class="account-type-section register-section bg-style">
            <div class="row">
                <div class="col-md-5">
                    <div class="numeric-no modNumericNo">
                        2
                    </div>
                    <div class="register-title modRegisterTitle">
                        <h1>SELECT YOUR ACCOUNT TYPE</h1>
                    </div>
                </div>
                <div class="col-md-7">
                <div class="register-account-type">
                    <div class="row">
                        <div class="col-md-4">

                          <div class="radio">
                            <label>
                             <input type="radio" class="account-type <?php if(@$this->request->data['User']['account_type']=='Individual'){echo 'checked-class';}?>" value="Individual" name="data[User][account_type]" <?php if(@$this->request->data['User']['account_type']=='Individual'){ echo "checked='checked'";

                        } else{

                            echo "checked='checked'";}?>>Individual
                             <!--  <input type="radio">  -->
                            </label>
                          </div>
                        </div>
                        <div class="col-md-8">

                           <div class="radio">
                                <label>
                                 <input type="radio" class="account-type <?php if(@$this->request->data['User']['account_type']=='Business/Organisation'){echo 'checked-class';}?>" value="Business/Organisation" name="data[User][account_type]" <?php if(@$this->request->data['User']['account_type']=='Business/Organisation'){ echo "checked='checked'";

                        } ?>>Business/Organisation
                                  <!-- <input type="radio"> Business/ Organisation -->
                                </label>
                          </div>
                        </div>
                    </div>
                </div>
                    
               
                </div>
            </div>
        </div>
        <div class="account-fields-section register-section clearfix bg-style step3">
            <div class="row">
                <div class="col-md-6">
                    <div class="numeric-no modNumericNo">
                        3
                    </div>
                    <div class="register-title modRegisterTitle">
                        <h1>ALL ABOUT YOU</h1>
                    </div>
                </div>
            </div>

            <div class="registration-form-fields register-display-detail">
                <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-sm-6 first">
                             <div class="form-group">
                             <!--   <input type="text" class="form-control" id="" placeholder="Email |"> -->
                                 <?php
                                  if(@$this->request->query['authorize'] || @$this->request->data['User']['authorize']=='linkedin' )
                                   {
                                     $dis = 'readonly';
                                   }
                                   else{
                                      $dis = '';
                                   }

                                  echo $this->Form->input('email_address',array('type'=>'email', 'class'=>'form-control input-email', 'placeholder'=>'EMAIL |', 'label'=>false,'value'=>@$this->request->query['email'],$dis, 'autocomplete'=>"off")); ?>
                                  <?php echo $this->Form->input('authorize', array('type'=>'hidden','value'=>@$this->request->query['authorize']));?>
                              </div>
                              <div class="form-group"> 
                                <!-- <input type="text" class="form-control" id="" placeholder="First Name |"> -->
                                 <?php 

                                 echo $this->Form->input('first_name', array('class'=>'form-control', 'placeholder'=>'FIRST NAME |', 'label'=>false,'value'=>@$this->request->query['first_name'],$dis, 'autocomplete'=>"off"));?>
                 <?php echo $this->Form->input('registration_type', array('type'=>'hidden','value'=>@$_REQUEST['type']));?>
                              </div>
                              <div class="form-group">
                                <!-- <input type="text" class="form-control" id="" placeholder="Last  Name |"> -->
                                <?php echo $this->Form->input('last_name', array('class'=>'form-control', 'placeholder'=>'LAST NAME |', 'label'=>false ,'value'=>@$this->request->query['last_name'],$dis, 'autocomplete'=>"off"));?>
                              </div>
                              <div class="form-group">
                                   <label class="custom-select">
                                     <!--    <?php echo $this->Form->input('stage_id', array('options'=>array(''=>'COUNTRY |'),'id'=>'stage_id', 'class'=>'form-control', 'label'=>false));?>       -->      
                                      <?php echo $this->Form->input('country_id', array('options'=>$country,'id'=>'COUNTRY |', 'class'=>'form-control', 'label'=>false));?>               
                                    </label>
                              </div>
                        </div>
                        <div class="col-sm-6 second">
                            <div class="form-group">
                            <!--    <input type="text" class="form-control" id="" placeholder="Confirm Email |"> -->
                              <?php echo $this->Form->input('confirm_email_address',array('type'=>'email', 'class'=>'form-control input-email', 'placeholder'=>'CONFIRM EMAIL |', 'label'=>false,'value'=>@$this->request->query['email'],$dis, 'autocomplete'=>"off")); ?>
                            </div>
                            <div class="form-group">
                               <label class="custom-select">
                                   <!--  <?php echo $this->Form->input('stage_id', array('options'=>array(''=>'ENTROPOLIS PRECINCT |'),'id'=>'stage_id', 'class'=>'form-control', 'label'=>false));?>   -->  
                                       <?php echo $this->Form->input('decision_type_id', array('options'=>$decisiontypes,'id'=>'decision_type_id', 'class'=>'form-control', 'label'=>false));?>                                           
                                </label>
                            </div>
                            <div class="form-group">
                               <label class="custom-select">
                                    <?php echo $this->Form->input('stage_id', array('options'=>array(''=>'SEEKER OR SAGE INDENTITY |'),'id'=>'stage_id', 'class'=>'form-control', 'label'=>false));?>                          
                                </label>
                            </div>
                           <div class="form-group">
                                <?php echo $this->Form->input('group_code', array('class'=>'form-control', 'placeholder'=>'Are you part of a group? | [ENTER YOUR CODE HERE]', 'label'=>false, 'autocomplete'=>"off"));?>         
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
                    <div class="numeric-no modNumericNo">
                        4
                    </div>
                    <div class="register-title modRegisterTitle">
                        <h1>JUST A LITTLE MORE</h1>
                        <p class="littleMoreTitle">To help us place you properly in our city and curate our vital resources to add the most value to you whenever you are working in entropolis, please also share the following information <i>(Optional)</i></p>
                    </div>
                </div>
            </div>

            <div class="registration-form-fields register-display-detail Registration">
                <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-sm-6 first">
                             <div class="form-group">
                        <!--        <input type="text" class="form-control" id="" placeholder="Your Website |"> -->
                        <?php echo $this->Form->input('blog',array('class'=>'form-control', 'placeholder'=>'YOUR WEBSITE |', 'label'=>false)); ?>
                              </div>
                              <div class="form-group">
                                <label class="custom-select">
                                    <!--     <?php echo $this->Form->input('stage_id', array('options'=>array(''=>'YOUR NETWORK'),'id'=>'stage_id', 'class'=>'form-control', 'label'=>false));?>      -->  

                                     <?php 
                                       $opt = array(''=>'YOUR NETWORK','0-50'=>'0-50', '51-100'=>'51-100', '101-500'=>'101-500', '500-1,000'=>'500-1,000','1,000-10,000'=>'1,000-10,000','10,000-50,000'=>'10,000-50,000','50,000-100,000'=>'50,000-100,000','100,000+'=>'100,000+');
                                     echo $this->Form->input('influence_network', array( 'class'=>'form-control', 'label'=>false,
                            'options' => $opt
                            )); ?>                   
                                </label>
                              </div>
                              <div class="form-group">
                        <!--        <input type="text" class="form-control" id="" placeholder="Linked In |"> --> <?php echo $this->Form->input('linkedin_network',array('class'=>'form-control', 'placeholder'=>'LINKEDIN |', 'label'=>false, 'autocomplete'=>"off")); ?>
                              </div>
                              <div class="form-group">
                                   <!-- <input type="text" class="form-control" id="" placeholder="Twitter |"> -->
                                    <?php echo $this->Form->input('twitter_followers',array('class'=>'form-control', 'placeholder'=>'TWITTER |', 'label'=>false, 'autocomplete'=>"off")); ?>
                              </div> 
                              <div class="form-group">
                                <!--    <input type="text" class="form-control" id="" placeholder="Facebook |"> -->
                                 <?php echo $this->Form->input('facebook_network',array('class'=>'form-control', 'placeholder'=>'FACEBOOK |', 'label'=>false, 'autocomplete'=>"off")); ?>
                              </div>
                              <div class="form-group">
                                  <!--  <input type="text" class="form-control" id="" placeholder="Other Network |"> -->
                                    <?php echo $this->Form->input('other_url',array('class'=>'form-control', 'placeholder'=>'OTHER NETWORK |', 'label'=>false, 'autocomplete'=>"off")); ?>
                              </div>
                        </div>
                        <div class="col-sm-6 second-col">
                            <div class="form-group">

                                <textarea class="form-control short_bio"  name = "data[UserProfile][short_bio]"rows="3"  placeholder="TELL US ABOUT YOURSELF |"></textarea>
                            </div>
                            <!-- <div class="count small right">100 Words</div> -->
                        <div class="count-remain small right">100 Words</div>
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
                <!--    <a href="/entropolis/users/register" class="btn btn-Orange-white">Set up your subscription</a> -->
                  <?php echo $this->Form->submit('Set up your subscription', array('class'=>'btn btn-Orange-white align-center register-user', 'div'=>false));?>
                </div>
                <div class="col-md-9">
                    <span class="white subscribe-txt">You will be directed to Paypal to complete your transaction</span>
                </div>
            </div>
        </div>

            <?php echo $this->Form->end();?>
        <div class="terms-wrap">
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
              <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                  <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                      *REGISTRATION AND PAYMENT TERMS & CONDITIONS
                     <i class="fa fa-angle-up"></i>
                    </a>
                  </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                   
                    <ul>
                        <li>TrepiCity is a private business network therefore all applications received by TrepiCity|HQ will be qualified and citizenship will be confirmed based on meeting our population selection criteria.</li>
                        <li>Your Citizenship will be confirmed via email and you will be provided an activation code to finish setting up your account online.
                        </li>
                        <li>Applicants who can be qualified as SAGES  may be eligible to have their Citizenship subscription fee waived by invitation or under circumstances to be assessed individually by TrepiCity|HQ.
                        </li>
                        <li>Citizens who enter a  qualified promotional code will also receive a waiver or discount.
                        </li>
                        <li>Discount and waiver of fees will be confirmed in writing via email in conjunction with your account activation.
                        </li>
                    </ul>

                  </div>
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
<!--Start registration thanks message's-->
<?php if($this->Session->read('register')){ ?>
    <a href="#thanksMessage" class="show-thanks-message" data-toggle="modal">&nbsp;</a>
    <div class="modal fade modal-popup" id="thanksMessage" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">

                    <button type="button" class="close" data-dismiss="modal" onclick= "location.href='<?php echo SITE_PATH.'pages'; ?>';"><span aria-hidden="true"><i class="icons close-icon"></i></span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">THANKS FOR REGISTERING!</h4>
                </div>
                <?php echo $this->Form->create('Pages', array('class' => 'form-horizontal', 'id' => 'user-authen-detail', 'role' => 'form', 'action' => '/index')); ?>
                <div class="modal-body" id = "append-error">
                    <div class="form-group">
            <div class="col-sm-12">
                            <?php 
                            echo $this->Session->flash(); ?>
                            
                        </div>
                    </div>

                </div>
                <div class="modal-footer">

                    <?php echo $this->Form->button('Okay', array('action' => '', 'class' => 'btn btn-orange', 'div' => false, 'label' => false, 'type' => 'submit')); ?>
                </div>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>  
<script>
    $(document).ready(function(){
       $('.show-thanks-message').trigger('click'); 
    });
</script>    
<?php 
unset($_SESSION['register']);
unset($_SESSION['flyout']);
} ?>
<!--End registration thanks message's-->




<!-- Special Offer Modal Popup -->
<div id="specialOfferPopup" class="modal fade" role="dialog" >
    <div class="modal-dialog popup_design">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><i class="icons close-icon"></i></button>
                <h4 class="modal-title">Special Offer</h4>
            </div>
            <div class="modal-body">
                <h5>Aenean non tempus risus, ut sodales massa. Suspendisse iaculis euismod cursus. Curabitur blandit urna dolor</h5>
                <p>Aenean non tempus risus, ut sodales massa. Suspendisse iaculis euismod cursus. Curabitur blandit urna dolor, in consequat quam euismod sit amet. Sed ut libero eget sapien facilisis iaculis. Sed in massa eget mi eleifend dapibus. Nulla non consequat orci. Suspendisse potenti.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn line_button popup_button" data-dismiss="modal">Accept Offer</button>
            </div>
        </div>

    </div>
</div>




<div class="modal fade semi-large flyInUpdateModal" id="citizenship" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
         <button type="button" class="close close-video-button" data-dismiss="modal"><span aria-hidden="true"><i class="icons close-icon"></i></span><span class="sr-only">Close</span></button>      

		<!--flyIn modal-img-box-starts-->
		<div class="flyInModalImgBox">
			 <?php  echo $this->Html->image('flyIn-modal-img.png');?>
		</div>

		<!--flyIn modal-img-box-ends-->
        
        <div class="citizenship-wrap flyInCitizenshipWrap">
           <div class="citizenship-title flyInTopCitizen">
                <h4>Pioneer Citizen</h4>
                <h3>Special Offer</h3>
                <p>Enjoying the benefits of being an early architect of the future of business</p>
           </div>
           <div class="citizenship-head flyInCitizenshipHead">
            <div class="row">
                <div class="col-md-6">
                   <div class="citizenship-panel first">
                      
                        <p>We are offering great benefits to our existing citizens and those who sign up before December 31, 2015: 
                        </p>
                        <ul class="list-box">
                        	<li>Free citizenship up to March 1, 2016 including 1 month trial period and 2 months BONUS Pioneer trial period.</li>
                        	<li>Unlimited use of all functionality.</li>
                          <li>Invitation to #PP2B4E exclusive event series and partner special offers.</li>
                            
                        </ul>

                   </div>
                </div>
                <div class="col-md-6">
                    <div class="citizenship-panel second">
                         <p>
                          We designed our online city to be owned, shaped and powered by the entrepreneur community, and ensure that every time you are working in the city we deliver on your <span class="fontBold">Less Time | Less Risk | More Value</span> promise. 
                         </p>
						            <p>
                        	TrepiCity will quickly become a large and vibrant online global community and we are working overtime to put the building blocks in place to make it a valuable experience from day one. 
                        </p>
                        <p>  See you soon! </p>
                    </div>
                </div>
            </div>
           </div>
          
        </div>

      </div>
       <div class="strip"></div>
    </div>
  </div>
</div>