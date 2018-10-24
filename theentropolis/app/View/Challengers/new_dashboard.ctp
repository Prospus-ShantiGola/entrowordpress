+<div class="col-md-10 content-wraaper">
    <div class="new-dashboard">
        <div class="row">
            <div class="col-md-9 border-right">
                <div class="new-dashboard-left-panel">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="relative">
                                <div class="select-img">  
                                        <?php  


                                         $context_ary = $this->Session->read('context-array');

                                        if( in_array('5',$context_ary) && in_array('6',$context_ary)){
                                          $role = "Seeker, Sage";
                                        }
                                        else if( in_array('5',$context_ary))
                                        {
                                           $role = "Seeker";
                                        }
                                        else if( in_array('6',$context_ary))
                                        {
                                           $role = "Sage";
                                        }
                                          if($avatar != ''){
                                                                                 ?>   
                                                     <img src="<?php echo $this->Html->url('/'). $this->Image->resize($avatar,128, 128, false);?>" alt="" class="img-thumbnail user-avatar-select "/>
                                                   <?php }
                                                   else{?>
                                                      <img src="<?php echo $this->Html->url('/'). $this->Image->resize('upload/avatar-male-1.png',128, 128, false);?>" alt="" class="img-thumbnail user-avatar-select "/>
                                                    <!-- <img src="/entropolis/upload/avatar-male-1.png" class="img-thumbnail user-avatar-select "> -->
                                                 <?php   } ?>                        
                                  <!--  <img src="/entropolis/upload/avatar-male-1.png" class="img-thumbnail user-avatar-select "> -->
                                   <!--  <span class="upload-img">
                                        <span class="choose-file">Choose File</span>
                                        <input type="file" class="new-dashboard-upload-img">
                                    </span> -->
                                </div>
                                 
                             </div>
                        </div>
                        <div class="col-md-9">
                            <div class="">
                                <div class="citizen-title">
                                <?php //echo $this->Hindsight->numPublishedHindsight($this->Session->read('user_id'), 'week');
                                      //echo $this->Hindsight->numPublishedHindsight($this->Session->read('user_id'), 'month');?>
                                    <span>Citizen Id</span>
                                    <span class="name" style="text-transform: uppercase;" ><?php echo $this->Session->read('user_name');?></span>
                                </div>
                                <div class="citizen-title">
                                    <span class="category-type">Pioneer (<?php echo  $role;?>)</span>
                                    <span class="category-type">Starter Score</span>
                                </div>
                            </div>                           
                        </div>
                    </div>
                    <div class="biography new-dashboard-wrap">
                         <h3>Biography</h3> 

               <?php if(!empty($user_info)){
                echo $user_info[0]['UserProfile']['short_bio'];

               }else{ ?>
                         <p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.</p>
                         <p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>     
                         <?php } ?> 
                    </div>

                   <?php if( in_array('5',$context_ary) && in_array('6',$context_ary)){
                        echo $this->element('my_advice_element');
                           echo $this->element('my_hindsight_element');
                             echo $this->element('my_question_element');
                    
                   } else if( in_array('5',$context_ary)) {

                      echo $this->element('my_hindsight_element');
                      echo $this->element('my_question_element');
             

                    

                   } else if( in_array('6',$context_ary)) {
                    echo $this->element('my_advice_element');
             
                    } ?>

                </div>                
            </div>
            <div class="col-md-3">
                <div class="my-advice new-dashboard-right-panel">                
                    <div class="new-dashboard-side-wrap">
                        <h3>Badges</h3>
                        <div class="row">
                            <div class="col-md-4">
                                <?php  echo $this->Html->image('Hydrangeas.jpg',array('class'=>'img-round'))?>
                              <!--   <img src="/entropolis/img/Hydrangeas.jpg" alt="" class="img-round"> -->
                            </div>
                            <div class="col-md-4">
                                <?php echo $this->Html->image('Chrysanthemum.jpg',array('class'=>'img-round'))?>
                            <!--     <img src="/entropolis/img/Chrysanthemum.jpg" alt="" class="img-round"> -->
                            </div>
                            <div class="col-md-4"></div>
                        </div>
                    </div>
                    <div class="new-dashboard-side-wrap">
                        <div class="row">
                            <div class="col-md-6">
                                <h3>Health</h3>
                                  <?php  echo $this->Html->image('heath.png')?>
                               
                            </div>
                            <div class="col-md-6 right">
                                <h3>Pollution</h3>
                                  <?php  echo $this->Html->image('populations.png')?>
                            
                            </div>
                        </div>        
                    </div>
                    <div class="new-dashboard-side-wrap">
                        <h3>Notification</h3>
                        <div class="new-dashboard-side-panel align-center">
                            <a href="#">
                                <?php  echo $this->Html->image('chat.png')?>
                                
                            </a>
                            <div class="">
                                <span class="orange">9</span> 
                                <span class="purpel">49</span>
                            </div>                                                                      
                           
                        </div>
                        <div class="new-dashboard-side-panel align-center">
                            <a href="#">
                                 <?php  echo $this->Html->image('star.png')?>
                              
                            </a>
                            <div class="">
                                <span class="orange">5</span> 
                                <span class="purpel">28</span>
                            </div>
                        </div>
                        <div class="new-dashboard-side-panel align-center">
                            <a href="#">
                                 <?php  echo $this->Html->image('group.png')?>
                             
                            </a>
                            <div class="">
                                <span class="orange">23</span> 
                                <span class="purpel">110</span>
                            </div>
                                                                      
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    

    // jQuery('.def').on('click',function(){
    //     alert("dsd");
    //     $(this).parent('.abc').trigger('change');
    // });
</script>