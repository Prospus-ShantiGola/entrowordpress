
 <?php 
 $perPageLimit;
 $pageNum = 1;
 if(isset($this->params['named']['page'])){
    $pageNum = $this->params['named']['page'];   
 }
 
 $page = '';
 if(isset($pass[0])){
    $page = $pass[0];
 }
 $this->Paginator->options(array('update'=> '#postsPaging','before' => $this->Js->get('#spinner')->effect('fadeIn', array('buffer' => false)),'complete' => $this->Js->get('#spinner')->effect('fadeOut', array('buffer' => false))));?>
    <div class="table-wrap" id="postsPaging">
        <input type="hidden" class="currentNumPage" value="<?php echo $pageNum;?>">
        <table class="table table-striped table-condensed  my_decisionbank table-hover user-table action-table" cellspacing="0" cellpadding="0" width="100%">
            <thead>
                <tr>
                    <th></th>
                    <th>Challenge Name</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                    <th>Winner</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php 
         if(count($challenge) > 0){       
                $indexer = $perPageLimit*($pageNum-1);
                foreach ($challenge as $key=>$value){
                    $indexer++;
                    $show = 1;
                  
                ?>
                    <tr>
                        <td class="user-index"><?php echo $indexer;?></td>
                            <td><?php echo $value['Challenge']['challenge_title'];?></td>
                            <td><?php echo date("m-d-Y",strtotime($value['Challenge']['challenge_start_date']));?></td>
                            <td><?php echo date("m-d-Y",strtotime($value['Challenge']['challenge_end_date']));?></td>
                            <td><?php if($value['Challenge']['challenge_status']=='1'){echo 'Ongoing';}else{echo 'Completed';}?></td>
                            <td>
                                <?php if($value['Challenge']['challenge_status']=='1'){echo '--';}else{echo 'winner';}?>
                                </td>
                            <td>
                                <div class="actions">
                                    <?php if($value['Challenge']['challenge_status']=='1'){?>
                                    
                                    <?php echo $this->Html->link('Edit',array('controller'=>'challenges','action'=>'editChallenge',$value['Challenge']['id']))?>

                                    <?php } ?>
                                

                                    <?php echo $this->Html->link('View Entries',array('controller'=>'challenges','action'=>'viewEntry',$value['Challenge']['id']))?>


                                    <?php if($value['Challenge']['challenge_status']=='1'){?>
                                    <?php echo $this->Html->link('View Judges',array('controller'=>'challenges','action'=>'viewJudge',$value['Challenge']['id']))?>
                                    <?php }else{

                                        echo $this->Html->link('View Judges',array('controller'=>'challenges','action'=>'challengeCompleted',$value['Challenge']['id']));}

                                        ?>
                                    <?php if($value['Challenge']['challenge_status']=='1'){?>
                                    <a href="#" class = 'cancel-challenge' data-id ="<?php echo $value['Challenge']['id'];?>">Cancel</a>
                                    <?php }?>
                                </div>
                            </td>
                        </tr>
                        

                <?php  
                } 
         }else{
              echo "<tr><td colspan='8'> No records found.</td></tr>";
         }?>

            </tbody>
        </table>
<?php if(count($challenge) > 0){ ?>          
        <div class="pagination pagination-sm custom-page"><?php
        echo $this->Paginator->prev( __('<< Prev'), array(), null, array('class' => 'prev disabled pagination pagination-sm'));
        echo $this->Paginator->numbers(array('separator' => ''));
        echo $this->Paginator->next(__('Next >>'), array(), null, array('class' => 'next disabled'));
        echo $this->Js->writeBuffer();
        ?></div>
<?php } ?>        
  </div>

