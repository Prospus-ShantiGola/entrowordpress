
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
        <table class="table table-striped eluminati-table table-hover user-table action-table" cellspacing="0" cellpadding="0" width="100%">
            <thead>
                <tr>
                            <th>S.No</th>
                            <th>Name</th>                         
                            <th>Title</th>
                            <th>Created Date</th>
                            <th>Actions</th>
                 </tr>
            </thead>
            <tbody>
                <?php 
         if(count($userdata) > 0){       
                $indexer = $perPageLimit*($pageNum-1);
                foreach ($userdata as $key=>$query_value){
                    $indexer++;
                    $show = 1;
                  
                ?>

                <tr>
                            <td><?php echo $indexer;?></td>
                            <td><?php echo $query_value['Eluminati']['first_name']." ". $query_value['Eluminati']['last_name'];?></td>
                            <td><?php echo $query_value['Eluminati']['title']; ?></td>                          
                            <td><?php echo date("M j,Y ",strtotime($query_value['Eluminati']['creation_timestamp']));?></td> 
                            <td>
                                 <div class="actions"><?php 
                        
                        echo $this->Html->link('View',array('controller'=>'eluminatis','action'=>'viewProfile',$query_value['Eluminati']['id']));?> 

                            <!-- <a href="edit-pages.php">Edit</a> -->
                            <?php echo $this->Html->link('Edit',array('controller'=>'eluminatis','action'=>'editEluminati',$query_value['Eluminati']['id']));?>
                                <a href="#" class= 'delete-eluminati' data-id ="<?php echo $query_value['Eluminati']['id'];?>">Delete</a>  
                            
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
<?php if(count($userdata) > 0){ ?>          
        <div class="pagination pagination-sm custom-page"><?php
        echo $this->Paginator->prev( __('<< Prev'), array(), null, array('class' => 'prev disabled pagination pagination-sm'));
        echo $this->Paginator->numbers(array('separator' => ''));
        echo $this->Paginator->next(__('Next >>'), array(), null, array('class' => 'next disabled'));
        echo $this->Js->writeBuffer();
        ?></div>
<?php } ?>        
  </div>

