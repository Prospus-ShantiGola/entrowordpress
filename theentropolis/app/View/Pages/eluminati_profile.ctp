<?php if(!empty($eluminati)) {?>
<script type="text/javascript">
  
  $(window).load(function(){  //  alert("fsd");
   
   <?php  
   if( $this->Session->read('user_id')){

   if(@$this->request->params['action'] =='eluminatiProfile' && @$this->request->params['pass']['1']!='')
   {?>
   var obj_id = <?php echo @$this->request->params['pass']['1']; ?>;
    
  
  // alert (obj_id);
    $('.get-eluminati-modal[data-id='+obj_id+']').addClass('open-popup');
    if( $('.get-eluminati-modal[data-id='+obj_id+']'))
    {
   
      $('.get-eluminati-modal.open-popup').trigger('click');
    }

   <?php }
 }else{
 $obj_id =  @$this->request->params['pass']['0'];?>
  
  location.href='<?php echo SITE_PATH.'pages/eluminatiProfile/'.$obj_id ; ?>';
 <?php }
 ?>
  })
</script>
<div class="page-loading" style="color:red"><?php echo $this->Html->image('loading-upload.gif');?></div>
<div class="top-grey-strip-bg margin-bottom">
  <div class="container">
    <div class="page-title">
      profile
    </div>
  </div>
</div>
<div id="eluminti-signup" class="container">
    <div class="">
        <div class="content">
            <div class="row  elumiat-panel sage-dashboard">
                <div class="col-md-3">
                    <div class="eluminti-signup-icon">
                        <?php 
                            if($eluminati['Eluminati']['image_url'])
                            {
                            
                              $user_image = $eluminati['Eluminati']['image_url'];?>
                        <img   src="<?php echo $this->Html->url('/'). $this->Image->resize($user_image, 140, 140, true);?>" alt=""/>
                        <?php   }else {?>
                          <img   src="<?php echo $this->Html->url('/'). $this->Image->resize('img/dummy-pic.png', 140, 140, true);?>" alt=""/>
                          
                        <?php  }
                            ?>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="">
                        <div class="eluminti-signup-top border">
                           
                            <div class="eluminti-signup-top-detail">
                                <h2 class="roboto_medium"><?php echo $eluminati['Eluminati']['first_name']." ".$eluminati['Eluminati']['last_name'];?>
                                <div class="eluminti-signup-top-icon"><?php echo $this->Html->image('eluminati-icon.png') ;?></div></h2>
                                <h3 class="roboto_light"><?php echo $eluminati['Eluminati']['title'];?></h3>
                               
                            </div>
                        </div>

                        <div class="">
                       <!--    <ul class="social-links">
                                                        
                                        <?php if(@$user_info['User']['twitter_followers']){?>
                                         <li><a href="<?php echo $user_info['User']['twitter_followers'];?>" target = "_blank">Twitter</a></li>
                                         <?php }   ?>

                                          <?php if(@$user_info['User']['facebook_network']){?>
                                         <li><a href="<?php echo $user_info['User']['facebook_network'];?>" target = "_blank">Facebook</a></li>
                                         <?php }   ?>
                                   
                                        <?php if(@$user_info['User']['linkedin_network']){?>
                                         <li><a href="<?php echo $user_info['User']['linkedin_network'];?>" target = "_blank">LinkedIn</a></li>
                                         <?php }   ?>
                                        <?php if(@$user_info['User']['other_url']){?>
                                        <li><a href="<?php echo $user_info['User']['other_url'];?>" target = "_blank">Website</a></li>
                                         <?php }   ?>
                                       
                                        
                                                          
                          </ul> -->
                        </div>
                       
                    </div>
                </div>
            </div>          
            
            <div class="biography sage-biography roboto_light">
              <h2 class="roboto_medium">Biography</h2>
               <?php if($eluminati['Eluminati']['short_description']){ ?>
                
              <div class=" <?php echo $eluminati['Eluminati']['first_name']; ?> person-content short-data"><?php 
                      echo nl2br($eluminati['Eluminati']['short_description']);?>
                    
               <?php if($eluminati['Eluminati']['testimonial']){ ?>
                <div class="words-wisdom">
                      <h2 class="roboto_medium">WORDS OF WISDOM</h2>
                <p class="italic"><?php if($eluminati['Eluminati']['testimonial']){?> "<?php echo $eluminati['Eluminati']['testimonial'];?>" <?php }?></p>
                </div>


                <?php } ?> 
                    </div>    
                                                
         <?php  }else{?> 
                         
              <div class=" <?php echo $eluminati['Eluminati']['first_name']; ?> person-content short-data">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.<br><br>
              Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.<br> </div>    
                                                
              <?php } ?>  
             <div class="person-content">
               
              </div> 
            </div>
               
           
          
            <div class="relative sage-table-wrap table-striped eluminati-color ">
               <h2 class="roboto_medium">My|WISDOM</h2>
                <table class="table eluminti-table remove-scroll">
                    <thead>
                        <tr>
                           
                            <th>category</th>
                            <th>Date</th>
                             <th>title</th>
                            <th>Rate</th>
                            <th>Comment</th>
                            
                        </tr>
                    </thead>
                      <?php if(!empty($eluminati_deatil)){?>
                    <tbody>
                        <?php  
                            foreach($eluminati_deatil as $eluminatideatil){
                            
                                ?>
                        <tr data-direction="right" data-toggle="modal" class="get-eluminati-modal" data-owner = "<?php echo $eluminatideatil['EluminatiDetail']['eluminati_id'];?>" data-type="Eluminati" data-id="<?php echo $eluminatideatil['EluminatiDetail']['id'];?>" >
                          
                            <td title= "<?php echo $eluminatideatil['Category']['category_name'];?>"><?php echo $eluminatideatil['Category']['category_name'];?></td>
                            <td><?php echo date('M j, Y',strtotime($eluminatideatil['EluminatiDetail']['date_published']));?></td>
                              <td><a ><?php echo $this->Eluminati->text_cut($eluminatideatil['EluminatiDetail']['source_name'], $length = 80, $dots = true);?></a></td>
                             <td><?php echo $this->Rating->eluminatiRatingCount($eluminatideatil['EluminatiDetail']['id']); ?> / 10 </td>
                           
                            <td><?php echo $this->Rating->eluminatiCommentCount($eluminatideatil['EluminatiDetail']['id']); ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                    <?php } else { ?>
                                   <tr><td colspan= '5' style = "background-color:#dddddd; text-align:center;">No records found.</td></tr>
                                <?php } ?>
                </table>
            </div>
            
        </div>
    </div>
</div>

<?php } ?>


        
