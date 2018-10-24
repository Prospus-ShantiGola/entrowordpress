<?php
$SessionParentChildId = array();
if (!empty($this->request->data['groupcode_search'])) {
    $groupCode = $this->request->data['groupcode_search'];
}
$group_code_user_id = substr($group_code_user_id, 0, -1);
$SessionParentChildId = array_unique(explode(",", $group_code_user_id));
if ($fetch_type != 'loadmore') {
    ?>
    <div class="tab-pane active" id="<?php echo $tab_name; ?>" >

        <table class="table table-striped advices-table library-wrap main-table-wrap table-condensed remove-scroll cred-street tableHT <?php if ($this->Session->read('isAdmin') == 1) { ?>hq<?php } else{ ?>user-cred-street<?php }?>">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <?php if ($this->Session->read('isAdmin') == 1) { ?><th>First Name</th>
                                            <th>Last Name</th><?php }?>
                                            <th>Username</th>
                                               <?php if ($this->Session->read('isAdmin') != 1) { ?>  <th>School Name</th><?php }?>
                                            <?php if ($this->Session->read('isAdmin') == 1) { ?><th>Email ID</th><?php }?>
                                            <th>Identity</th>
                                            <th>Status</th>
                                              <th>Actions</th>
                                      
                                        </tr>
                                    </thead>
                                    <tbody >
                                        <?php $disbleClass = "";
                                        if (!empty($user_data)) {
                                            foreach ($user_data as $rec) {
                                                
                                                 echo   $this->element('listing_cred_element',array('rec'=>$rec,'SessionParentChildId'=>$SessionParentChildId));                                     
                                                }
                                            
                                        } else {
                                            ?>
                                             <?php if ($this->Session->read('isAdmin') == 1) { 
                                                    $col = 8;
                                                }else {
                                                    $col = 6;
                                                }?>
                                        <tr>
                                            <td colspan= "<?php echo $col;?>" style = "background-color:#f2f2f2; text-align:center;" class="no-record">No records found.</td>
                                        </tr>
                                <?php } ?>
                                    </tbody>
                                </table>

    <?php if ($total_count > 2) { ?>
            <div class="margin-bottom clearfix load-more-btn" id="loadmorebtn">
                <button class="btn btn-orange-small margin-top-small large right" onclick="loadmoredata();">Load More</button>
            </div>
    <?php } ?>
    </div>
<?php } else { ?>  
    <?php
    //pr($user_data);                            // die;
    foreach ($user_data as $rec) {
        
            echo   $this->element('listing_cred_element',array('rec'=>$rec,'SessionParentChildId'=>$SessionParentChildId));      
           } ?>
        
    <?php }

?>
<?php echo '#$$#' . $total_count; ?>
