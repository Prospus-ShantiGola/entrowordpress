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
        <table class="table table-striped table-hover user-table action-table" cellspacing="0" cellpadding="0" width="100%">
            <thead>
                <tr>
                    <th>S.N</th>
                    
                    <th>Group Code</th>
					<th>Parent</th>
                    <th>Date Created</th>
                    <th>Actions</th>
					
                </tr>
            </thead>
            <tbody>
                <?php 
              //pr($users);
         if(count($GroupCode) > 0){       
                $indexer = $perPageLimit*($pageNum-1);
                foreach ($GroupCode as $key=>$GroupCode){
                  
                    $indexer++;
                    $show = 1;
                    $created = date('M j, Y', strtotime($GroupCode['GroupCode']['created']));
                ?>
                <tr class="user-list" data-id="<?php echo $GroupCode['GroupCode']['id'];?>">
                    <td class="user-index"><?php echo $indexer;?></td>
					<td><?php echo $GroupCode['GroupCode']['name']?></td>
					<td><?php $parentName = $this->GroupCode->parentName($GroupCode['GroupCode']['parent_id']);
							
						if(empty($parentName['GroupCode']['name']) || $parentName['GroupCode']['name']==''){
								echo '--';
						}
						else {
							echo $parentName['GroupCode']['name'];
						}?></td>
                    <td><?php echo $created;?></td>
					<td><?php echo $this->Html->link("Edit", array('action'=>'edit', $GroupCode['GroupCode']['id']));?> |
					<?php echo $this->Html->link("Delete", array('action'=>'delete', $GroupCode['GroupCode']['id']));?></td>
					
                    
                </tr>
                <?php  
                } 
         }else{
              echo "<tr><td colspan='8'> No records found.</td></tr>";
         }?>

            </tbody>
        </table>
<?php if(count($GroupCode) > 0){ ?>          
        <div class="pagination pagination-sm custom-page"><?php
        echo $this->Paginator->prev( __('<< Prev'), array(), null, array('class' => 'prev disabled pagination pagination-sm'));
        echo $this->Paginator->numbers(array('separator' => ''));
        echo $this->Paginator->next(__('Next >>'), array(), null, array('class' => 'next disabled'));
        echo $this->Js->writeBuffer();
        ?></div>
<?php } ?>        
  </div>


  
  
  
  