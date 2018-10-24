<?php  echo $this->Facebook->html();  ?>

<script type="text/javascript">
    $(document).ready(function(){
        $('.register-form-mask').height( $('.register-form-fade').height()+15);
         $('.register-form-mask').width( $('.register-form-fade').width());

          if(jQuery('.chk-input').is(':checked')){
                 $('.checkbox-select.active').removeClass('active'); 
                 jQuery('.checked-class').siblings('.checkbox-select').addClass('active'); 

                  $('.register-form-mask').hide();                 
            } 

            else{      
                 //$(this).siblings('.checkbox-select').removeClass('active');             
                 $('.register-form-mask').show();
            }

        $('.chk-input').click(function(){
            var $this = $(this);
            if($(this).is(':checked')){
                 $('.checkbox-select.active').removeClass('active'); 
                 $(this).siblings('.checkbox-select').addClass('active'); 

                  $('.register-form-mask').hide();                 
            } 

            else{      
                 //$(this).siblings('.checkbox-select').removeClass('active');             
                 $('.register-form-mask').show();
            }
        });
    });
    
    
$(document).ready(function() {
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
 <?php //pr($_POST);
// echo $this->request->data['User']['role'];
// die;?>
<div class="top-heading margin-bottom ">
    <div class="container">
        <div class="title">
            <h1>BECOME A PIONEER CITIZEN</h1>
        </div>
    </div>
</div>
<div class="register-display container margin-bottom" >
    <p>Joining our colony is easy! Select the type of citizen you are closest to below and help us out with a few details and then you are all set to enter the Entropolis and start sharing your wisdom!</p>
    <?php echo $this->Session->flash();?>
    <?php echo $this->Form->create('User', array('class'=>'form-horizontal register-form', 'url'=>'/users/register'));?>
    <div class="citizen-type">
        <h2>1. CHOOSE YOUR CITIZEN TYPE</h2>
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-4">
                        <input type="radio" class="chk-input <?php if(@$this->request->data['User']['role']=='6'){echo 'checked-class';}?> " value="6" <?php if(@$this->request->data['User']['role']=='6'){ echo "checked='checked'";

                        } ?> name="data[User][role]">
                        <div class="light-yellow checkbox-select">
                             <?php echo $this->Html->image("sage-icon.png")?>
                           <!--  SAGE <br> BADGE -->
                        </div>
                    </div>
                    <div class="col-md-8">
                        <p class="margin-none">SAGE</p>
                        <p>You will be building a scalable expert body of work while delivering brilliant advice and vital resources to help our Seekers win at the game of business.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-4">
                        <input type="radio" class="chk-input <?php if(@$this->request->data['User']['role']=='5'){echo 'checked-class';}?>" value="5" name="data[User][role]" <?php if(@$this->request->data['User']['role']=='5'){ echo "checked='checked'";

                        } ?>>
                        <div class="light-purpel checkbox-select">
                             <?php echo $this->Html->image("seeker-icon.png") ?>
                           <!--  SEEKER <br> BADGE -->
                        </div>
                    </div>
                    <div class="col-md-8">
                        <p class="margin-none">SEEKER</p>
                        <p>You will be building a private global business network and I seeking advice, education, mentoring and collaboration within the ecosystem to help you build your real-world business.</p>
                    </div>
                </div>
            </div>
            <!-- <div class="col-md-2">
                <div class="row">
                    <div class="col-md-12">
                        <input type="radio" class="chk-input" value="5-6" name="data[User][role]">
                        <div class="light-blue checkbox-select">
                            BIT OF <br>  BOTH
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
    </div>
   
    <div class="register-form-mask"></div>
    <div class="register-form-fade"> 
        <div class="register-display-detail register-forms">
        <label class="control-label">2. TELL US A BIT ABOUT YOURSELF</label>
        <div class="form-group row">
            <div class="col-sm-6">
                <?php echo $this->Form->input('first_name', array('class'=>'form-control', 'placeholder'=>'First Name', 'label'=>false));?>
            </div>
            <div class="col-sm-6">
                <?php echo $this->Form->input('last_name', array('class'=>'form-control', 'placeholder'=>'Last Name', 'label'=>false));?>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-6">
                <?php echo $this->Form->input('email_address',array('class'=>'form-control input-email', 'placeholder'=>'Email Address', 'label'=>false)); ?>
            </div>

            <div class="col-sm-6">
                <?php echo $this->Form->input('confirm_email_address',array('class'=>'form-control input-email', 'placeholder'=>'Confirm Email Address', 'label'=>false)); ?>
            </div>

        </div>
        <!-- <div class="form-group row">
            <div class="col-sm-12">
                <?php echo $this->Form->input('password', array('class'=>'form-control', 'placeholder'=>'Password', 'label'=>false));?>
            </div>
        </div> -->
        <div class="form-group row">
            <div class="col-sm-12">
                <label class="custom-select">
                <?php echo $this->Form->input('country_id', array('options'=>$country,'id'=>'country', 'class'=>'form-control', 'label'=>false));?>                          
                </label>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-12">
                <?php   // pr($user_status);
                    //   die; ?>
                <label class="custom-select">
                <?php echo $this->Form->input('user_current_status_id', array('options'=>$user_status,'id'=>'user_status', 'class'=>'form-control', 'label'=>false));?>     
                </label>
                <?php  //echo $this->Form->input('current_status',array('class'=>'form-control', 'placeholder'=>'Current Status', 'label'=>false)); ?>
            </div>
        </div>
    </div>
        <div class="register-display-detail">
            <label class="control-label">3. TELL US ABOUT YOUR INFLUENCE</label>
            <div class="form-group">
                <label for="" class="col-sm-4">Your Influence</label>
                <div class="col-sm-8">
                    <label class="custom-select">
                        <!-- <select name = "data[User][influence_network]" class= 'form-control'>
                            <option value = ''>My personal network of influence is</option>
                            <option value = '0-50'>0-50</option>
                            <option value = '51-100'>51-100</option>
                            <option value = '101-500'>101-500</option>
                            <option value = ' 500-1,000'>500-1,000</option>
                            <option value = '1000-1,0000'>1000-1,0000</option>
                            <option value = '1,000-10,000'>1,000-10,000</option>
                            <option value = '10,000-50,000'>10,000-50,000</option> 
                            <option value = '50,000-100,000'>50,000-100,000</option>
                            <option value = '100,000+'>100,000+</option>
                                
                            </select> -->
                        <?php echo $this->Form->input('influence_network', array( 'class'=>'form-control', 'label'=>false,
                            'options' => array('0-50', '51-100', '101-500', '500-1,000', '1000-1,0000','1,000-10,000','10,000-50,000','50,000-100,000','100,000+'),
                            'empty' => 'My personal network of influence is'
                            )); ?>
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-sm-4">LinkedIn</label>
                <div class="col-sm-8">
                    <?php echo $this->Form->input('linkedin_network',array('class'=>'form-control', 'placeholder'=>'URL', 'label'=>false)); ?>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-sm-4">Twitter</label>
                <div class="col-sm-8">
                    <?php echo $this->Form->input('twitter_followers',array('class'=>'form-control', 'placeholder'=>'URL', 'label'=>false)); ?>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-sm-4">Blog</label>
                <div class="col-sm-8">
                    <?php echo $this->Form->input('blog',array('class'=>'form-control', 'placeholder'=>'URL', 'label'=>false)); ?>
                </div>
            </div>
            <div class="form-group">
                <label for="" class="col-sm-4">Other</label>
                <div class="col-sm-8">
                    <?php echo $this->Form->input('other_url',array('class'=>'form-control', 'placeholder'=>'URL', 'label'=>false)); ?>
                </div>
            </div>
        </div>
        <div class="register-display-detail">
            <label class="control-label">4. WHAT DO YOU VALUE MOST FROM AN ECOSYSTEM?</label>
            <div class="form-group">
                <?php 
                    //pr($guideLines);
                    foreach($guideLines as $key=>$guideLine){ 
                        $checked = '';
                        if(@$this->request->data['guidelines']){
                            if(in_array($guideLine['EntropolisGuideline']['id'], $this->request->data['guidelines'])){
                                $checked = 'checked'; 
                            }
                        }
                        //pr($this->request->data['guidelines']);
                        ?>
                <div class="checkbox-btn">
                    <input id="chk<?php echo $key;?>" <?php echo $checked;?> type="checkbox" name="guidelines[]" class="gender-inp" value="<?php echo $guideLine['EntropolisGuideline']['id'];?>">
                    <label class="custom-radio" for="chk<?php echo $key;?>"><span><?php echo $guideLine['EntropolisGuideline']['guideline'];?></span></label>
                </div>
                <?php 
                    } ?>
            </div>
        </div>
        <p class="align-center">By clicking "Register" you indicate that you have read and agree to the Terms of Service.</p>
        <div class="register-display-bottom align-center">
            <?php echo $this->Form->submit('JOIN', array('class'=>'btn btn-orange align-center register-user', 'div'=>false));?>
            <!-- <div class="option-or">OR</div>
                <a href="<?php echo Router::url(array('controller'=>'Users', 'action'=>'index'))?>" class="signup-link linkedin-div btn btn-blue ">
                <i class="fa fa-linkedin div-icon div-link-sapretor"></i>Sign up with LinkedIn
                </a> -->
        </div>
    </div>
    <?php echo $this->Form->end();?>
</div>
<?php echo $this->Facebook->init(); ?>
