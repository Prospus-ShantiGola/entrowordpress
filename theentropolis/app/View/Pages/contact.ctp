<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
 <script>

  function initialize() {
    var mapOptions = {
      zoom: 18,
      center: new google.maps.LatLng(-33.869667,151.206245),
       
       styles: [{featureType:"landscape",stylers:[{saturation:-100},{lightness:-1},{visibility:"on"}]},
       

     {featureType:"poi",stylers:[{saturation:-100},{lightness:0},{visibility:"on"}]},

     {featureType:"road.highway",stylers:[{saturation:-100},{visibility:"simplified"}]},

    {featureType:"road.arterial",stylers:[{saturation:-100},{lightness:20},{visibility:"on"}]},

   {featureType:"road.local",stylers:[{saturation:-100},{lightness:20},{visibility:"on"}]},

 {featureType:"transit",stylers:[{saturation:-100},{lightness:20},{visibility:"simplified"}]},

{featureType:"administrative.province",stylers:[{visibility:"off"}]/**/},

{featureType:"administrative.locality",stylers:[{visibility:"off"}]},{featureType:"administrative.neighborhood",stylers:[{visibility:"on"}]/**/},

{featureType:"water",elementType:"labels",stylers:[{visibility:"on"},{lightness:40},{saturation:-100}]},

{featureType:"water",elementType:"geometry",stylers:[{hue:"#DBDBDB"},{lightness:40},{saturation:-97}]}]
    };

    var map = new google.maps.Map(document.getElementById('map-canvas'),
        mapOptions);    

    

    var marker = new google.maps.Marker({
      position: map.getCenter(),
      icon: '<?php echo IMG_PATH;?>img/map-icon.png',
        fillColor:"#0000ff",
      map: map
    });
  // var goldStar = {
  //   path: 'M 125,5 155,90 245,90 175,145 200,230 125,180 50,230 75,145 5,90 95,90 z',
  //   fillColor: 'yellow',
  //   fillOpacity: 0.8,
  //   scale: 1,
  //   strokeColor: 'gold',
  //   strokeWeight: 14
  // };

  // var marker = new google.maps.Marker({
  //   position: map.getCenter(),
  //   icon: goldStar,
  //   map: map
  // });

    myInfoWindowOptions = {
      content: '<div class="info-window-content"><h4>TrepiCity</h4><p>Level 3 | 50 York Street,<br> Sydney NSW 2000<br> Australia</p></div>',
      maxWidth: 275
    };

    infoWindow = new google.maps.InfoWindow(myInfoWindowOptions);

    google.maps.event.addListener(marker, 'mouseover', function() {
      infoWindow.open(map,marker);
    }); 

  }

  google.maps.event.addDomListener(window, 'load', initialize);
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



var post_data = jQuery(".message").text();
//alert(post_data);
if(post_data!='')
{
    var $contactform = $('.register-form')
    $($contactform).find("input[type=text] , textarea ").each(function(){
                $(this).val('');            
    });

     jQuery("#success-message").modal('show');
      jQuery('.modal-body').append('<span>'+post_data+'</span>');
}

});

</script>


<div class="top-heading margin-bottom  ">
        <div class="container">
            <div class="title">
                <h1>GET IN TOUCH</h1>
            </div>
            <div class="bredcumb-menu right">
                <ul>
                    <li><a href="<?php echo Router::url(array('controller'=>'pages', 'action'=>'index'));?>">Home</a></li>
                    <li>/</li>
                   <li><a href="<?php echo Router::url(array('controller'=>'pages', 'action'=>'contact'));?>">Contact</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div id="contact" class="container">
        <div class="content-wrap">
         <?php echo $this->Session->flash();?>
            
            <div class="contact content">
                   
                <div class="row">
                  <div class="col-md-6">
                    <h3>WE LOVE VISITORS!</h3>
                    <p>TrepiCity is a virtual world, but behind it lies some very real people. If you would like to connect in person, you can find us here:</p>
                  </div>
                  <div class="col-md-6">
                    <h3>TREPICITY PTY LTD ACN:</h3>
                    <p class="font-small">Level 3 | 50 York Street, Sydney NSW 2000 Australia<br>  P|1300 XXX XXX  E|citizens@theentropolis.com</p>
                  </div>
                </div>
                
                
                <div class="row">
                    <div class="contact-wrap"> 
                        <div class="col-md-6">
                           <div id="map-canvas"></div>
                           <h5>If you have any questions, suggestions or just want to connect, please send us an email and we will respond within 24 hours.</h5>
                           <!-- <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3312.959239555197!2d151.20784668279134!3d-33.86494132221066!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6b12ae413b2b255d%3A0x438a1663e41fc67b!2sSuccessionplus!5e0!3m2!1sen!2sin!4v1413180462035" width="100%" height="320" frameborder="0" style="border:0; background-color:#eee"></iframe> -->
                        </div>
                        <div class="col-md-6">
                          <!--   <img src="images/contact.png" alt=""> -->
                            <?php echo $this->Html->image("contact.png")?>
                        </div>
                    </div>
                </div>
               
            <div class="contact-form margin-bottom">
                <div class="row">
                    <div class="col-md-6">
                       
                            <?php echo $this->Form->create('Page',array('role'=>'form','class'=>'register-form' ,'id'=>'UserchallangeinfoProfileForm')); ?>
                            <div class="form-group">
                              <?php echo $this->Form->input('name',array('label'=>false,'class'=>'form-control','id'=>'firstName','maxlength'=>'100',"placeholder"=>"First|Name"));?>
                               <!--  <input type="text" class="form-control" placeholder="First|Name"> -->
                            </div>
                            <div class="form-group">
                               <!--  <input type="text" class="form-control"  placeholder="Last|Name"> -->
                                <?php echo $this->Form->input('last_name',array('label'=>false,'class'=>'form-control','id'=>'lastName','maxlength'=>'100',"placeholder"=>"Last|Name"));?>
                            </div>
                            <div class="form-group">
                                <!-- <input type="text" class="form-control" placeholder="Email|Address"> -->
                                 <?php echo $this->Form->input('email_address',array( 'label'=>false,'class'=>'form-control','id'=>'emailAddress','maxlength'=>'50',"placeholder"=>"Email|Address"));?>
                            </div>
                            <div class="form-group">
                              <!--   <input type="text" class="form-control"  placeholder="RE|"> -->
                                    <?php echo $this->Form->input('subject',array('label'=>false,'class'=>'form-control','id'=>'lastName','maxlength'=>'100',"placeholder"=>"RE|"));?>
                            </div>
                            <div class="form-group">
                               <!-- <textarea name="" id="" cols="30" rows="5"  placeholder="Message" ></textarea> -->
                               <?php echo $this->Form->textarea('message',array( 'label'=>false, 'class'=>'form-control','id'=>'message','rows'=>'5','cols'=>'30','maxLength'=>'200',"placeholder"=>"Message"));?>
                            </div>
                            <div class="form-group">
                                <p>LET US KNOW YOU’RE NOT A MACHINE!</p>
                                <span class="font-small"> Type in the security code.  <a href="#" id="a-reload" >Reload if you can’t read it clearly.</a></span>
                            </div>
                            <div class="form-group">
                                <div class="capture">
                                      <?php echo $this->Html->image($this->Html->url(array('controller'=>'pages', 'action'=>'captcha'), true),array('id'=>'img-captcha','vspace'=>2));?>
                                          

                                           <?php  echo $this->Form->input('captcha',array('autocomplete'=>'off','label'=>false,
                                           'class'=>'form-control capture-txt'));?>


                                
                                  <?php echo $this->Form->input('Send',array('label'=>false,'type'=>'submit','class'=>'btn send ','div'=>false)); ?>
                             
                               
                            </div>
                                </div>                                     
                            </div>
                            
                        </div>
                    <div class="col-md-6"></div>
                </div>
            </div>
            </div>
            
            </div>            
      </div>
    <script>
$('#a-reload').click(function() {
  var $captcha = $("#img-captcha");
    $captcha.attr('src', $captcha.attr('src')+'?'+Math.random());
  return false;
});

</script>

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
