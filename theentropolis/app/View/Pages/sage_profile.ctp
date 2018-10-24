<script type="text/javascript">
  
  $(window).load(function(){
   //  alert("fsd");
   
   <?php  
   if( $this->Session->read('user_id')){

   if(@$this->request->params['action'] =='sageProfile' && @$this->request->params['pass']['1']!='')
   {?>
   var obj_id = <?php echo @$this->request->params['pass']['1']; ?>;
    
  
   //alert (obj_id);
    $('.get-new-modal[data-id='+obj_id+']').addClass('open-popup');
    if( $('.get-new-modal[data-id='+obj_id+']'))
    {
   
      $('.get-new-modal.open-popup').trigger('click');
    }

   <?php }
 }else{
 $obj_id =  @$this->request->params['pass']['0'];


  ?>


   location.href='<?php echo SITE_PATH.'pages/sageProfile/'.$obj_id ; ?>';
 <?php }
 ?>
  })
</script>
<?php if(!empty($user_info)){?>

<?php  $SessionParentChildId = array();
    $group_code_user_id = substr($group_code_user_id,0,-1);
            $SessionParentChildId = array_unique(explode(",",$group_code_user_id));
    //pr($SessionParentChildId);
        //die;

  ?>
     <?php 

    $ch = curl_init();

 curl_setopt($ch, CURLOPT_URL, "https://subscriptions.zoho.com/api/v1/organizations?Authorization=Zoho-authtoken 42943dbb5e10abf43892ef7756b56f62");
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$dd  = curl_exec($ch);
json_decode($dd);

 die;

//      $ch = curl_init();

// curl_setopt($ch, CURLOPT_URL, "$ curl https://subscriptions.zoho.com/api/v1/organizations \
//     -H 'Authorization: Zoho-authtoken 42943dbb5e10abf43892ef7756b56f62'");

// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

//  $contents = curl_exec($ch);

//  echo $contents;
//  echo "fdfds";

 $cSession = curl_init(); 
//step2
curl_setopt($cSession,CURLOPT_URL,"http://www.google.com/search?q=curl");
curl_setopt($cSession,CURLOPT_RETURNTRANSFER,true);
curl_setopt($cSession,CURLOPT_HEADER, false); 
//step3
$result=curl_exec($cSession);
//step4
curl_close($cSession);
//step5
echo $result;
 die;
?>
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
                            if(@$user_info['User']['user_image'])
                            {
                            
                              $user_image = @$user_info['User']['user_image'];?>
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
                                <h2 class="roboto_medium"><?php echo @$user_info['User']['first_name']." ".@$user_info['User']['last_name'];?>
                                <div class="eluminti-signup-top-icon"><?php echo $this->Html->image('sage-icon.png') ;?></div></h2>
                                <h3 class="roboto_light"><?php //pr($user_info);
                                       echo @$user_info['UserProfile']['designation'];?></h3>
                                <span><?php if(@$countryName['Country']['country_title']){?><i class="fa fa-map-marker"></i><?php if(@$user_info['UserProfile']['city']){ echo @$user_info['UserProfile']['city'].", ".@$countryName['Country']['country_title'];}else{
                                  echo @$countryName['Country']['country_title'];
                                } }?></span>
                            </div>
                        </div>
                        <div class="">
                          <ul class="social-links">
                                                        
                                        <?php if(@$user_info['User']['twitter_followers']){?>
                                         <li><a href="<?php echo $user_info['User']['twitter_followers'];?>" target = "_blank">Twitter</a></li>
                                         <?php }   ?>

                                          <?php if(@$user_info['User']['facebook_network']){?>
                                         <li><a href="<?php echo $user_info['User']['facebook_network'];?>" target = "_blank">Facebook</a></li>
                                         <?php }   ?>
                                      <!--   <li><a href="#">Facebook</a></li> -->
                                        <?php if(@$user_info['User']['linkedin_network']){?>
                                         <li><a href="<?php echo $user_info['User']['linkedin_network'];?>" target = "_blank">LinkedIn</a></li>
                                         <?php }   ?>
                                        <?php if(@$user_info['User']['other_url']){?>
                                        <li><a href="<?php echo $user_info['User']['other_url'];?>" target = "_blank">Website</a></li>
                                         <?php }   ?>
                                       
                                        
                                                          
                          </ul>
                        </div>
                       
                    </div>
                </div>
            </div>          
            
            <div class="biography sage-biography">
              <h2 class="roboto_medium">Biography</h2>
               <?php if(@$user_info['UserProfile']['short_bio']){ ?>
                
              <div class=" <?php echo @$user_info['User']['first_name']; ?> person-content short-data"><?php 
                      echo nl2br(html_entity_decode($user_info['UserProfile']['short_bio']));?>
                    </div>    
                                                
         <?php  }else{?> 
                         
              <div class=" <?php echo @$user_info['User']['first_name']; ?> person-content short-data">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.<br><br>
              Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.<br></div>    
                                                
              <?php } ?>  
                      
                
                
            </div>
               
           
          
            <div class="relative sage-table-wrap table-striped ">
               <h2 class="roboto_medium">My|Advice</h2>
                <table class="table remove-scroll">
                    <thead>
                        <tr>
                           
                            <th>category</th>
                            <th>Date</th>
                             <th>title</th>
                            <th>Rate</th>
                            <th>View</th>
                            <th>Comment</th>
                            
                        </tr>
                    </thead>
                      <?php if(!empty($advice)){?>
                    <tbody>
                        <?php  
                            foreach($advice as $advicedetail){
                            
                                            if(($advicedetail['Advice']['network_type'] == 1 || $advicedetail['Advice']['network_type'] == 0) && in_array($advicedetail['ContextRoleUser']['User']['id'],$SessionParentChildId))
                                            {
                                                $new_class_var = 'get-new-modal';
                                                $new_icon = 'true';
                                               
                                            }
                                            
                                            if(($advicedetail['Advice']['network_type'] == 1) && (!in_array($advicedetail['ContextRoleUser']['User']['id'],$SessionParentChildId)))
                                            {
                                                $new_class_var = 'get-new-modal';
                                                $new_icon = 'true';
                                               
                                            }
                                            else if( $advicedetail['Advice']['network_type'] == 0 && (!in_array($advicedetail['ContextRoleUser']['User']['id'],$SessionParentChildId)))
                                            {
                                                $new_class_var = 'get-data-network-advice-modal';
                                                  $new_icon = 'false';
                                            }
                                ?>
                        <tr class= "<?php echo $new_class_var; ?>"   data-direction='right' data-type = "Advice" data-id = <?php echo $advicedetail['Advice']['id'];?> data-username="<?php  echo $advicedetail['ContextRoleUser']['User']['first_name']. ' '.$advicedetail['ContextRoleUser']['User']['last_name'] ?>" data-userid="<?php echo $advicedetail['ContextRoleUser']['User']['id'] ?>">
                          
                            <td title= "<?php echo $advicedetail['Category']['category_name'];?>"><?php echo $advicedetail['Category']['category_name'];?></td>
                            <td><?php echo date('M j, Y',strtotime($advicedetail['Advice']['advice_decision_date']));?></td>
                             <td><a ><?php echo $this->Eluminati->text_cut($advicedetail['Advice']['advice_title'], $length = 80, $dots = true);?></a></td>
                            <td><?php echo $this->Rating->getRating($advicedetail['Advice']['id']); ?> / 10 </td>
                            <td>
                                                <?php if($new_icon=='true'){?>
                                                <i class="fa fa-eye"></i>
                                                <?php }
                                                else{?>
                                                    <i class="fa fa-lock"></i>
                                                <?php } ?>
                                            </td>
                            <td><?php echo $this->Rating->IndividualCommentCount($advicedetail['Advice']['id'],'Advice'); ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                    <?php } else { ?>
                                   <tr><td colspan= '6' style = "background-color:#dddddd; text-align:center;">No records found.</td></tr>
                                <?php } ?>
                </table>
            </div>
            
        </div>
    </div>
</div>
<?php } ?>
