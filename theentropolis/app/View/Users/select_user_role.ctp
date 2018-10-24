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
<div class="top-grey-strip-bg">
    <div class="container">
        <div class="page-title">
            CHOOSE YOUR CITIZEN TYPE
        </div>
    </div>
</div>
<div class="register-display container margin-bottom">
    <div class="citizen-type">

    <?php 

        echo $this->Session->flash('role-form');
     ?>
       <?php echo $this->Form->create('User', array('url'=>'/users/select_user_role'));?>
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-4">
                        <input type="radio" class="chk-input" value="6" name="data[User][role]">
                        <div class="light-yellow checkbox-select">
                            <?php echo $this->Html->image('sage-icon.png') ;?>
                             <!-- <img src="/entropolis/img/sage-icon.png" alt="">      -->                      <!--  SAGE <br> BADGE -->
                        </div>
                    </div>
                    <div class="col-md-8">
                        <p class="margin-none roboto_medium">SAGE</p>
                        <p>You will be building a scalable expert body of work while delivering brilliant advice and vital resources to help our entrepreneurs win at the game of business.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-4">
                        <input type="radio" class="chk-input " value="5" name="data[User][role]">
                        <div class="light-purpel checkbox-select">
                              <?php echo $this->Html->image('seeker-icon.png') ;?>
                                            <!--  SEEKER <br> BADGE -->
                        </div>
                    </div>
                    <div class="col-md-8">
                        <p class="margin-none roboto_medium">SEEKER</p>
                        <p>You will be building a private global business network and seeking advice, education, mentoring and collaboration within the ecosystem to help you build your real-world business.</p>
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
        <div class="submit continue-btn"> <?php echo $this->Form->submit('Continue', array('class'=>'btn btn-orange right', 'name'=>'submit'));?>

     <!--   <input class="btn btn-orange right" name="submit" type="submit" value="Continue"> -->
   </div>
   <?php echo $this->Form->end();?>


    </div>
</div>

<!--Start registration thanks message's-->
<?php if($this->Session->read('confirm_msg')){ ?>
    <a href="#thanksMessage" class="show-thanks-message" data-toggle="modal">&nbsp;</a>
    <div class="modal fade modal-popup" id="thanksMessage" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"><i class="icons close-icon"></i></span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" id="myModalLabel">Email Confirmation</h4>
                </div>
                <?php echo $this->Form->create('Users', array('class' => 'form-horizontal', 'id' => 'user-authen-detail', 'role' => 'form', 'action' => '/select_user_role')); ?>
                <div class="modal-body" id = "append-error">


                    <div class="form-group">

                        <div class="col-sm-12">
                            <?php
                             echo $this->Session->flash();  ?>
                            
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
unset($_SESSION['confirm_msg']);
} ?>





