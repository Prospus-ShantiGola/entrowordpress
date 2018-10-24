
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
                            <th>S.No</th>                          
                            <th>Email Id</th>                            
                            <th>Sent On</th>
                            <th>Status</th>
                 </tr>
            </thead>
            <tbody>
            <?php  
            $i = 1;
           foreach($reference_list as $value){
                ?>
            <tr>
            <td> <?php echo $i; ?></td>
            <td> <?php echo $value['Refer']['email_address'] ; ?></td>
            <td> <?php echo date('Y-m-d',strtotime($value['Refer']['creation_timestamp'])) ; ?></td>
            <td> <?php echo $value['Refer']['status'] ; ?></td>
            </tr>

          <?php  $i++ ; } ?>
            </tbody>
        </table>
 
  </div>
