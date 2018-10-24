
<?php if($fetch_type != 'loadmore') { ?>
<div class="tab-pane active" id="<?php echo $tab_name; ?>" >
    <?php  if(!empty($library_data)) {  ?>
    <button type="button" name="advice" class="btn search-bar-button1 delete-advice" disabled="">Remove</button> 
 
     <?php } ?>
    <table class="table table-striped advices-table  script-call library-wrap main-table-wrap table-condensed  remove-scroll">
     
      <thead>
        <tr>
          <th><input type="checkbox" class="check_all" name="" value=""></th>
          <th>Sub-Category</th>
          <th>Date</th>
          <th></th>
          <th>Posted By</th>
          <th>Title</th>
          <th>Rating</th>
          <th>View</th>
      </tr>
      </thead>   
 
      <tbody>
       <?php  
										 $commonclass= '';$commonFlag= '0'; $i=-1; $objType= '';
                                         if(!empty($library_data)) { ?>
                                           <?php foreach($library_data as $keys=> $rec) { 

                                                 $category_ary = $this->Rating->getCategoryTitle($rec['MyLibrary']['category_id']);
                                                 if(strtoupper($rec['MyLibrary']['object_type']) == strtoupper('advice') )
                                                {
                                                    
													$objType = 'Advice';
													$image =  $this->Html->image('sage-gray.png');
                                                    $modal_class ='get-new-modal';
                                                    $rating_count = $this->Rating->getRating($rec['MyLibrary']['object_id']).' / 10';
                                                    $result =  $this->Advice->getAdviceByAdviceId($rec['MyLibrary']['object_id']);
                                                    $date  = date("j M Y",strtotime($result['Advice']['advice_decision_date'])); 
													$userDetail = $this->Rating->UserInfo($rec['MyLibrary']['owner_user_id'],'Advice');
                                                     $full_name = $userDetail['User']['username'];
													if($result['Advice']['draft']=='1'){
														$commonclass = 'edit-advice-mylibrary';
														$commonFlag = '1';
                              $modal_class ='edit-advice-mylibrary';
													}


                                                }
                                                else if(strtoupper($rec['MyLibrary']['object_type']) == strtoupper('hindsight')) {
													
                                                    $image = $this->Html->image('seeker-icon.png');
                                                    $modal_class ='get-data-seeker-modal';
                                                    $rating_count =  $this->Rating->getHindsightRating($rec['MyLibrary']['object_id']).' / 10';
                                                    $result =  $this->Advice->getHindsightByHindsightId($rec['MyLibrary']['object_id']);
                                                    $date  = date("j M Y",strtotime($result['DecisionBank']['hindsight_decision_date'])); 
                                                    $userDetail = $this->Rating->UserInfo($rec['MyLibrary']['owner_user_id'],'Advice');
                                                    $full_name = $userDetail['User']['username'];
													 
													if($result['DecisionBank']['draft']=='1'){
														$commonclass = 'edit-hindsight-mylibrary';
														$commonFlag = '1';
														 $objType = 'Hindsight';
                               $modal_class ='edit-advice-mylibrary';
													}
                                                
												}
												
												else if(strtoupper($rec['MyLibrary']['object_type']) == strtoupper('wisdom')) {
													$objType = '';
												  $userdata = $this->User->getUserData($rec['MyLibrary']['owner_user_id']);
																		
												   if($userdata['context_role_id']=='5'){
														$image = $this->Html->image('seeker-icon.png');
												   } else {
														$image = $this->Html->image('sage-gray.png');
												   }                                                    
													
                                                    $modal_class ='get-data-wisdom-modal';
                                                    $rating_count =  $this->Rating->getWisdomRating($rec['MyLibrary']['object_id']).' / 10';
                                                    $result =  $this->Advice->getWisdomByPublicationId($rec['MyLibrary']['object_id']);
                                                    $date  = date("j M Y",strtotime($result['Publication']['date_published'])); 
                                                    $userDetail = $this->Rating->wisdomUserInfo($rec['MyLibrary']['owner_user_id'],'Wisdom');
                                                    $full_name = $userDetail['User']['username'];
													$commonFlag = 0;
                                                }
												else
                                                {
                                                    $objType = '';
													$image = $this->Html->image('eluminate-icon.png');
                                                    $modal_class ='get-eluminati-modal';
                                                    $rating_count = $this->Rating->eluminatiRatingCount($rec['MyLibrary']['object_id']).' / 10';

                                                    $userDetail = $this->Rating->UserInfo($rec['MyLibrary']['owner_user_id'],'Eluminati');
                                                    $full_name = $userDetail['Eluminati']['first_name']." ".$userDetail['Eluminati']['last_name'];
                                                    $result = $this->Eluminati->getEluminatiDetailById($rec['MyLibrary']['object_id']);
                                                    $date  = date("j M Y",strtotime($result['EluminatiDetail']['date_published'])); 
													$commonFlag = 0;

                                                } 
                                               //  pr($userDetail);

                                            ?>
       <tr   class="<?php echo $modal_class; ?>" data-type="<?php echo $rec['MyLibrary']['object_type'] ?>" data-owner = "<?php echo $rec['MyLibrary']['owner_user_id']?>" data-id="<?php echo $rec['MyLibrary']['object_id'] ?>" data-direction="right">
                                            <td><input type="checkbox" class="check-hindsight" name="MyLibrary[]" value="<?php echo $rec['MyLibrary']['id']; ?>"></td>
                                             <td title= "<?php echo $category_ary['Category']['category_name'];?>"><?php echo $this->Eluminati->text_cut($category_ary['Category']['category_name'], $length = 10, $dots = true); ?></td>

                                            <td><?php echo $date ;?></td>
                                            <td> <?php echo $image; ?> </td>
                                            <td><?php echo $full_name; ?></td>

                                            <td title="<?php echo $rec['MyLibrary']['title'];?>"><a><?php echo $this->Eluminati->text_cut($rec['MyLibrary']['title'], $length = 25, $dots = true); ?></a></td>

                                            <td><?php echo $rating_count;?><br></td>

                                            <td>
                                             <?php if( $modal_class!='edit-hindsight-mylibrary' && $modal_class!='edit-advice-mylibrary' )
                                                
                                                {?>
                                                <a><i class="fa fa-eye"></i></a> 
                                                <?php } ?>                           
												<?php if($commonFlag=='1' && $objType=='Advice'){?>
												<a  data-id ="<?php echo $rec['MyLibrary']['object_id']; ?>" class="<?php echo $commonclass;?>"><i class="fa fa-pencil" ></i></a>
												<?php } ?>
												<?php  if($commonFlag=='1' && $objType=='Hindsight'){?>
												<a  data-id ="<?php echo $rec['MyLibrary']['object_id']; ?>" class="<?php echo $commonclass;?> add-hindsight my_decisionbank"><i class="fa fa-pencil" ></i></a>
												<?php } ?>
                                            </td>
                                        </tr>
										<?php if($commonFlag=='1' && $objType=='Advice'){ 
											$AdviceDetails = $this->Advice->getAdviceDetails($rec['MyLibrary']['object_id']);
											echo $this->element('edit_advice_modal_element', array('adviceData'=>$AdviceDetails));
										 }?>
										 
										 <?php if($commonFlag=='1' && $objType=='Hindsight'){ 
										 	$hindsightDetails = $this->Hindsight->getHindsightDetails($rec['MyLibrary']['object_id']);
											echo $this->element('edit_hindsight_modal_element', array('adviceInfoData'=>$hindsightDetails));
											
										 }?>
       <?php } ?>


   <?php } else { ?>
   
  <tr>
      <td colspan= '8' style = "background-color:#f2f2f2; text-align:center;">No records found.</td>
  </tr>

   <?php } ?>
     </tbody>
    </table>
    
<?php if($total>10){?>
                           <div class="margin-bottom clearfix load-more-btn" id="loadmorebtn">
                                <button class="btn btn-orange-small margin-top-small large right" onclick="loadmoredata();">Load More</button>
                            </div>
                            <?php }?> 
</div>
 <?php }

  else {?>  
 <?php  
                     $commonclass= '';$commonFlag= '0'; $i=-1; $objType= '';
                                         if(!empty($library_data)) { ?>
                                           <?php foreach($library_data as $keys=> $rec) { 

                                                 $category_ary = $this->Rating->getCategoryTitle($rec['MyLibrary']['category_id']);
                                                 if(strtoupper($rec['MyLibrary']['object_type']) == strtoupper('advice') )
                                                {
                                                    
                          $objType = 'Advice';
                          $image =  $this->Html->image('sage-gray.png');
                                                    $modal_class ='get-new-modal';
                                                    $rating_count = $this->Rating->getRating($rec['MyLibrary']['object_id']).' / 10';
                                                    $result =  $this->Advice->getAdviceByAdviceId($rec['MyLibrary']['object_id']);
                                                    $date  = date("j M Y",strtotime($result['Advice']['advice_decision_date'])); 
                          $userDetail = $this->Rating->UserInfo($rec['MyLibrary']['owner_user_id'],'Advice');
                                                     $full_name = $userDetail['User']['username'];
                          if($result['Advice']['draft']=='1'){
                            $commonclass = 'edit-advice-mylibrary';
                            $commonFlag = '1';
                              $modal_class ='edit-advice-mylibrary';
                          }


                                                }
                                                else if(strtoupper($rec['MyLibrary']['object_type']) == strtoupper('hindsight')) {
                          
                                                    $image = $this->Html->image('seeker-icon.png');
                                                    $modal_class ='get-data-seeker-modal';
                                                    $rating_count =  $this->Rating->getHindsightRating($rec['MyLibrary']['object_id']).' / 10';
                                                    $result =  $this->Advice->getHindsightByHindsightId($rec['MyLibrary']['object_id']);
                                                    $date  = date("j M Y",strtotime($result['DecisionBank']['hindsight_decision_date'])); 
                                                    $userDetail = $this->Rating->UserInfo($rec['MyLibrary']['owner_user_id'],'Advice');
                                                    $full_name = $userDetail['User']['username'];
                           
                          if($result['DecisionBank']['draft']=='1'){
                            $commonclass = 'edit-hindsight-mylibrary';
                            $commonFlag = '1';
                             $objType = 'Hindsight';
                               $modal_class ='edit-hindsight-mylibrary';
                          }
                                                
                        }
                        
                        else if(strtoupper($rec['MyLibrary']['object_type']) == strtoupper('wisdom')) {
                          $objType = '';
                          $userdata = $this->User->getUserData($rec['MyLibrary']['owner_user_id']);
                                    
                           if($userdata['context_role_id']=='5'){
                            $image = $this->Html->image('seeker-icon.png');
                           } else {
                            $image = $this->Html->image('sage-gray.png');
                           }                                                    
                          
                                                    $modal_class ='get-data-wisdom-modal';
                                                    $rating_count =  $this->Rating->getWisdomRating($rec['MyLibrary']['object_id']).' / 10';
                                                    $result =  $this->Advice->getWisdomByPublicationId($rec['MyLibrary']['object_id']);
                                                    $date  = date("j M Y",strtotime($result['Publication']['date_published'])); 
                                                    $userDetail = $this->Rating->wisdomUserInfo($rec['MyLibrary']['owner_user_id'],'Wisdom');
                                                    $full_name = $userDetail['User']['username'];
                          $commonFlag = 0;
                                                }
                        else
                                                {
                                                    $objType = '';
                          $image = $this->Html->image('eluminate-icon.png');
                                                    $modal_class ='get-eluminati-modal';
                                                    $rating_count = $this->Rating->eluminatiRatingCount($rec['MyLibrary']['object_id']).' / 10';

                                                    $userDetail = $this->Rating->UserInfo($rec['MyLibrary']['owner_user_id'],'Eluminati');
                                                    $full_name = $userDetail['Eluminati']['first_name']." ".$userDetail['Eluminati']['last_name'];
                                                    $result = $this->Eluminati->getEluminatiDetailById($rec['MyLibrary']['object_id']);
                                                    $date  = date("j M Y",strtotime($result['EluminatiDetail']['date_published'])); 
                          $commonFlag = 0;

                                                } 
                                               //  pr($userDetail);

                                            ?>
       <tr   class="<?php echo $modal_class; ?>" data-type="<?php echo $rec['MyLibrary']['object_type'] ?>" data-owner = "<?php echo $rec['MyLibrary']['owner_user_id']?>" data-id="<?php echo $rec['MyLibrary']['object_id'] ?>" data-direction="right">
                                            <td><input type="checkbox" class="check-hindsight" name="MyLibrary[]" value="<?php echo $rec['MyLibrary']['id']; ?>"></td>
                                             <td title= "<?php echo $category_ary['Category']['category_name'];?>"><?php echo $this->Eluminati->text_cut($category_ary['Category']['category_name'], $length = 10, $dots = true); ?></td>

                                            <td><?php echo $date ;?></td>
                                            <td> <?php echo $image; ?> </td>
                                            <td><?php echo $full_name; ?></td>

                                            <td title="<?php echo $rec['MyLibrary']['title'];?>"><a><?php echo $this->Eluminati->text_cut($rec['MyLibrary']['title'], $length = 25, $dots = true); ?></a></td>

                                            <td><?php echo $rating_count;?><br></td>

                                            <td>
                                               <?php if( $modal_class!='edit-hindsight-mylibrary' && $modal_class!='edit-advice-mylibrary' )
                                                {?>
                                                <a><i class="fa fa-eye"></i></a> 
                                                <?php } ?>                           
                                                <?php if($commonFlag=='1' && $objType=='Advice'){?>
                                                <a  data-id ="<?php echo $rec['MyLibrary']['object_id']; ?>" class="<?php echo $commonclass;?>"><i class="fa fa-pencil" ></i></a>
                                                <?php } ?>
                                                <?php  if($commonFlag=='1' && $objType=='Hindsight'){?>
                                                <a  data-id ="<?php echo $rec['MyLibrary']['object_id']; ?>" class="<?php echo $commonclass;?> add-hindsight my_decisionbank"><i class="fa fa-pencil" ></i></a>
                                                <?php } ?>
                                            </td>
                                        </tr>
                    <?php if($commonFlag=='1' && $objType=='Advice'){ 
                      $AdviceDetails = $this->Advice->getAdviceDetails($rec['MyLibrary']['object_id']);
                      echo $this->element('edit_advice_modal_element', array('adviceData'=>$AdviceDetails));
                     }?>
                     
                     <?php if($commonFlag=='1' && $objType=='Hindsight'){ 
                      $hindsightDetails = $this->Hindsight->getHindsightDetails($rec['MyLibrary']['object_id']);
                      echo $this->element('edit_hindsight_modal_element', array('adviceInfoData'=>$hindsightDetails));
                      
                     }?>
       <?php } ?>
<?php } ?>  <?php } ?>
<?php echo '#$$#'.$total;?>
<?php //echo '#$$#12';?>