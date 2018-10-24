<div class="top-grey-strip-bg">
    <div class="container">
        <div class="page-title">
            Emergency Services
        </div>
    </div>
</div>
<div id="emergency-services">
<div class="container">
    <div class="content-wrap">
        <div  class="content">
           <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam adipiscing rutrum justo, ac imperdiet magna fermentum at. Sed at lectus ac elit sollicitudin euismod. Nam semper consequat ultricies. Morbi blandit faucibus mauris, vitae mattis tellus lobortis at.</p>
        </div>		
	<!-- 	<div class="search-wraps">
			 <?php echo $this->element('search_article_elements'); ?>
		</div> -->
		<div class="row">
			<!---<div class="col-md-4">
				<div class="content-block help-topics">
                                        <h3>Popular Help Topics</h3>
					<?php echo $this->element('article_box_elements',array('articleList'=>$articleData)); ?>
				</div>
			</div> -->
			<div class="col-md-8">

			</div>
		<!---	<div class="col-md-4">
				<div class="content-block support-wrap">
					<h3>Tech Support</h3>
					<div class="support-num">
						<div><i class="fa fa-user"></i> 24/7 Support </div>
						<div class="phone-num"><i class="fa fa-phone"></i> 1300-85-6171</div>
					</div>
					
				</div>
			</div> -->
			
		</div>
		



			</div>	
	</div>
<section class="">
  <div class= "container">
  <div class="content-wrap">
       <?php echo $this->Session->flash();?>
       

        <div class="">
                <div class="row ">
                    <div class="col-md-6 Contact-form grey-bg" style="padding: 10px;">
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
                            <div class="col-md-6">
                                      <div class="content-block topic-faq text-orange">
                                        <h3 class="capitalize">FAQs</h3>
          <?php echo $this->element('faq_box_elements',array('faqList'=>$faqlist)); ?>
        </div>
                            </div>
                        </div>
                    
                </div>
            </div>
</div>
            </section>
</div>
			
<div class="modal fade modal-popup" id="success-message" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myModalLabel" aria-hidden="true">
     <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><i class="icons close-icon"></i></button>
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
        
        if(inpData.val().trim() == ''){
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