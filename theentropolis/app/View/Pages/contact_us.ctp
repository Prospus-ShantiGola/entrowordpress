
<section>
    <div class="top-grey-strip-bg">
        <div class="container">
            <div class="page-title">
                GET IN TOUCH
            </div>
        </div>
    </div>
    <div class="container">
        
        <div class="content-wrap bind-wrap Contact-wrap">
            <?php echo $this->Session->flash();?>
            <div class="row">
                <div class="col-md-6 ">
                    <h1>We love visitors</h1>
                    <p>TrepiCity is a virtual world, but behind it lies some very real people. If you would like to connect in person, find us here:</p>
                    <div class="row contact-address">
                        <div class="col-md-6">
                            <?php echo $this->Html->image('contact.png');?>
                            
                        </div>
                        <div class="col-md-6">
                            <h2>TREPICITY PTY LTD</h2>
                            <p><strong>abn:</strong> 74 168 344 018</p>
                            <p>Level 4 | 16 Spring Street,<br>Sydney NSW 2000,<br>Australia</p>
                            <p><strong>P</strong> | 1300 85 6171<br><strong>E</strong> | <a href="mailTo:citizens@theentropolis.com">citizens@theentropolis.com</a></p>
                       <!--      <a href="http://goo.gl/N52XEf" target="_blank" class="btn btn-Orange">Locate | us</a> -->
     <a href="https://www.google.co.in/maps/place/4%2F16+Spring+St,+Sydney+NSW+2000,+Australia/@-33.8649941,151.2090477,17z/data=!3m1!4b1!4m2!3m1!1s0x6b12ae41c1d9cddf:0x9c3fce5b2d404297?hl=en" target="_blank" class="btn btn-Orange">Locate | us</a>
                          <!--   https://www.google.co.in/maps/place/4%2F16+Spring+St,+Sydney+NSW+2000,+Australia/@-33.8649941,151.2090477,17z/data=!3m1!4b1!4m2!3m1!1s0x6b12ae41c1d9cddf:0x9c3fce5b2d404297?hl=en -->
                        </div>
                    </div>
                </div>
                <div class="col-md-6 Contact-form">

                    <h1>SEND US A MESSAGE</h1>
                    <p>If you have any questions, suggestions or just want to connect, please send us an email and we will respond within 24 hours.</p>
                    <?php echo $this->Form->create('Page',array('role'=>'form','class'=>'register-form' ,'id'=>'UserchallangeinfoProfileForm')); ?>
                        <div class="form-group" style="margin-top:-7px;">
                            <span class="error-msg">* All fields required</span>
                        </div>
                        <div class="form-group relative">
                            <?php echo $this->Form->input('name',array('label'=>false,'class'=>'form-control','id'=>'firstName','maxlength'=>'100', "placeholder"=>"First | Name"));?>

                            <span class="astrik">*</span>
                        </div>
                        <div class="form-group relative">
                            <?php echo $this->Form->input('last_name',array('label'=>false,'class'=>'form-control','id'=>'lastName','maxlength'=>'100',"placeholder"=>"Last | Name"));?>

                            <span class="astrik set-astrik-pos1">*</span>
                        </div>
                        <div class="form-group relative">
                            <?php echo $this->Form->input('email_address',array( 'label'=>false,'class'=>'form-control','id'=>'emailAddress','maxlength'=>'50',"placeholder"=>"Email | Address"));?>

                            <span class="astrik set-astrik-pos2">*</span>
                        </div>
                        <div class="form-group relative">
                            <?php echo $this->Form->input('subject',array('label'=>false,'class'=>'form-control','id'=>'subject','maxlength'=>'50',"placeholder"=>"Re |",'type'=>'text'));?>

                            <span class="astrik set-astrik-pos3">*</span>
                        </div>
                        <div class="form-group relative">
                            <?php echo $this->Form->textarea('message',array( 'label'=>false, 'class'=>'form-control','id'=>'message','rows'=>'5','cols'=>'30','maxLength'=>'200',"placeholder"=>"Message |"));?>

                            <span class="astrik set-astrik-pos4">*</span>
                        </div>
                        <div class="form-group relative">
                            <h5>Let us know you are not a machine!<span>*</span></h5>
                            <p class="security-code">Type in the security code. <a href="#" id="a-reload" >Try another one</a></p>
                        </div>
                        <div class="form-group">
                            <div class="Capture">
                                <?php echo $this->Html->image($this->Html->url(array('controller'=>'pages', 'action'=>'captcha'), true),array('id'=>'img-captcha','vspace'=>2));?>

                                <?php  echo $this->Form->input('captcha',array('autocomplete'=>'off','label'=>false,
                                           'class'=>'form-control', 'div'=>false));?>
                            </div>                                     
                        </div>
                        <div class="form-group">

                            <?php echo $this->Form->input('Send',array('label'=>false,'type'=>'submit','class'=>'btn btn-Orange right','div'=>false)); ?>
                        </div>
                    </form>
                </div>
            </div> <!--row -->
        </div>
    </div>

</section>


<div class="modal fade modal-popup" id="success-message" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
     <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"><i class="icons close-icon"></i></span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="myModalLabel">Success Message</h4>
          </div>
       
          <div class="modal-body">        
              
          
          </div>
          <div class="modal-footer">
         <input type = "button" class= "btn btn-orange" value = "Okay" data-dismiss="modal">
          </div>
         
        </div>
      </div>
    </div>

      <!-- code for contact us -->
   <script>
$(document).ready(function(){
   $(".register-form input:text, .register-form textarea").focus(function(){

        var $this = $(this),
        wrap = $this.closest('.form-group'),
        astrikCls = wrap.find('.astrik');       
        astrikCls.hide();        
   }); 
   
   $(".register-form input:text, .register-form textarea").blur(function(){
       var $this = $(this),
        wrap = $this.closest('.form-group'),
        inpData = wrap.find('.form-control'),
        astrikCls = wrap.find('.astrik');       
        console.log( $(this).attr("placeholder"));
        if(inpData.val().trim() == ''){

   //$("#lastName").attr("placeholder", "New placeholder text");
         $(this).val().replace(/ /g,'');
       //  $(this).attr("placeholder", $(this).attr("placeholder"));
       //console.log( $(this).attr("placeholder"));
            astrikCls.show();
        }

   });

 

});    
</script>    

    <script>
$('#a-reload').click(function() {
  var $captcha = $("#img-captcha");
    $captcha.attr('src', $captcha.attr('src')+'?'+Math.random());
  return false;
});

</script>

<script type="text/javascript">
jQuery(document).ready(function(){
  
InvalidInputHelper(document.getElementById("PageCaptcha"), {
  defaultText: "Please enter Captcha Code.",

  emptyText: "Please enter Captcha Code.",

  invalidText: function (input) {
    //return 'The Captcha Code "' + input.value + '" is invalid.';
    return "Please enter valid Captcha Code.";
  }

});


   var inputelm =    $(".register-form input:text, .register-form textarea").closest('.form-group').find('.form-control');
   var astrick = $(".register-form input:text, .register-form textarea").closest('.form-group').find('.astrik'); 
var post_data = jQuery(".message").text();
//alert(post_data);
if(post_data!='')
{
    
      inputelm.val('');
         astrick.show();  

     jQuery("#success-message").modal('show');
      jQuery('.modal-body').append('<span>'+post_data+'</span>');
}
else
{
   

    if(inputelm.val().trim() != ''){
      //alert("fsd");
            astrick.hide();
        }
}

});

</script>