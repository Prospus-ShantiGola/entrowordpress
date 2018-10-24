<?php
if ($fetch_type != 'loadmore') {
    ?>
    <div class="tab-pane active" id="<?php echo $tab_name; ?>" >

        <table class="table table-striped  main-table-wrap table-condensed remove-scroll kcpc-list kcpc-table-format">
                                    <thead>
                                        <tr>
                                           
                                            
                                            <th>School Name</th>
                                            <th>KBN</th>
                                            <th>Submitter's Full Name</th>
                                            <th>Submitter's Email</th>  
                                            <th>ID</th>
                                            <th>Principal's Full Name</th>                                          
                                            <th># Kids</th>
                                            <th>Submission Date</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tbody >
                                        <?php foreach ($pitchDetails as $pitchEntry) {
                                             if(($pitchEntry['PitchGoldenEntryForm']['school_name'])==''){
                                                $school_name_val = $pitchEntry['PitchGoldenEntryForm']['teacher_school'];
                                            }
                                            else
                                                {
                                                     $school_name_val = $pitchEntry['PitchGoldenEntryForm']['school_name'];
                                                }?>

                                       <tr>
                                            <td><?=$pitchEntry['PitchGoldenEntryForm']['first_name']." ".$pitchEntry['PitchGoldenEntryForm']['last_name']?></td>
                                            <td><?=$pitchEntry['PitchGoldenEntryForm']['email_address']?></td>
                                            <td><?=$pitchEntry['PitchGoldenEntryForm']['phone']?></td>
                                            <td><?=$pitchEntry['PitchGoldenEntryForm']['state']?></td>
                                            <td><?=$pitchEntry['PitchGoldenEntryForm']['role_id']?></td>
                                            
                                            <td><?=$school_name_val?></td>
                                            <td><?=$pitchEntry['PitchGoldenEntryForm']['teacher_full_name']?></td>
                                            <td><?=$pitchEntry['PitchGoldenEntryForm']['kidpreneur_no']?></td>
                                            <td><?=date("m/d/y",strtotime($pitchEntry['PitchGoldenEntryForm']['registration_date']))?></td>
                                            <td><a href="../Users/downloadkcgtstudent/<?=$pitchEntry['PitchGoldenEntryForm']['id']?>/KgpcStudent"><img src="../img/download-icon.png"  data-toggle="tooltip" data-placement="left" title="Download Kidpreneur List" alt=""></a></td>
                                          
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
<?php } else {?>
<?php foreach ($pitchDetails as $pitchEntry) {
 if(($pitchEntry['PitchGoldenEntryForm']['school_name'])==''){
                                                $school_name_val = $pitchEntry['PitchGoldenEntryForm']['teacher_school'];
                                            }
                                            else
                                                {
                                                     $school_name_val = $pitchEntry['PitchGoldenEntryForm']['school_name'];
                                                }?>


    ?>
                                       <tr>
                                            <td><?=$pitchEntry['PitchGoldenEntryForm']['first_name']." ".$pitchEntry['PitchGoldenEntryForm']['last_name']?></td>
                                            <td><?=$pitchEntry['PitchGoldenEntryForm']['email_address']?></td>
                                            <td><?=$pitchEntry['PitchGoldenEntryForm']['phone']?></td>
                                            <td><?=$pitchEntry['PitchGoldenEntryForm']['state']?></td>
                                            <td><?=$pitchEntry['PitchGoldenEntryForm']['role_id']?></td>
                                            
                                            <td><?=$school_name_val?></td>
                                            <td><?=$pitchEntry['PitchGoldenEntryForm']['teacher_full_name']?></td>
                                            <td><?=$pitchEntry['PitchGoldenEntryForm']['kidpreneur_no']?></td>
                                            <td><?=date("m/d/y",strtotime($pitchEntry['PitchGoldenEntryForm']['registration_date']))?></td>
                                            <td><a href="../Users/downloadkcgtstudent/<?=$pitchEntry['PitchGoldenEntryForm']['id']?>/KgpcStudent"><img src="../img/download-icon.png"  data-toggle="tooltip" data-placement="left" title="Download Kidpreneur List" alt=""></a></td>
                                          
                                        </tr>
                                        <?php } ?>
    <?php 
}
?>
<?php echo '#$$#' . $total_count; ?>
