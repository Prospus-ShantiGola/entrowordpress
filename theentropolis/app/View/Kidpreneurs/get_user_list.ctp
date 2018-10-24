<?php
//var_dump($this->Session->read('roles'));
if ($fetch_type != 'loadmore') {
    ?>
    <div class="active list-view kidpreneur-tab " id="<?php echo $tab_name; ?>" >

        <table class="table table-striped advices-table library-wrap main-table-wrap table-condensed remove-scroll cred-street tableHT <?php if ($this->Session->read('isAdmin') == 1) { ?>hq <?php } else{ ?>user-cred-street kid-wrap<?php }?>">
            <thead class="<?php echo ($this->Session->read('isAdmin') == 1) ? "" : "hide";?>">
                                        <tr>
                                            <th></th>
                                            <th>Full Name</th>
                                            <th>USERNAME</th>                                         
                                            <th>DOB</th>                                            
                                            <th>Responsible Adult Name</th>                            
                                            <th>Relationship to child</th>
                                            <th>school name</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                            </tr>
                                    </thead>
                                     <thead class="<?php echo ($this->Session->read('isAdmin') == 1) ? "hide" : "";?>">
                            <tr>
                                <th></th>
                                <th>Username</th>
<!--                                <th>kidpreneurs</th>-->
                                <th>School Name</th>
                                <th>View Business Profile</th>
                                <th>Direct message</th>
                            </tr>
                            </thead>
                                    <tbody class="custom_scroll_"  >
                                        <?php $disbleClass = "";
                                        if (!empty($user_data)) {
                                            foreach ($user_data as $rec) {
                                                
                                                 echo   $this->element('listing_kid_element',array('rec'=>$rec));                                     
                                                }
                                            
                                        } else {
                                            ?>
                                             <?php if ($this->Session->read('isAdmin') == 1) { 
                                                    $col = 9;
                                                }else {
                                                    $col = 6;
                                                }?>
                                        <tr>
                                            <td colspan= "<?php echo $col;?>" style = "background-color:#fff; text-align:center;" class="no-record">No records found.</td>
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
        
            echo   $this->element('listing_kid_element',array('rec'=>$rec));      
           } ?>
        
    <?php }

?>
<?php echo '#$$#' . $total_count; ?>
