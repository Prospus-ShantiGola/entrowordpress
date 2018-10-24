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
                                            <th>Teacher's Full Name</th>
                                            <th>Teacher's Email </th>
                                            <th># Kids</th>
                                            <th>Submission Date</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>
                                    <tbody >
                                        <?php foreach ($pitchDetails as $pitchEntry) {?>
                                       <tr>
                                            <td><?=$pitchEntry['PitchCompetitionEntryForm']['school_name']?></td>
                                            <td><?=$pitchEntry['PitchCompetitionEntryForm']['kbn']?></td>
                                            <td><?=$pitchEntry['PitchCompetitionEntryForm']['first_name']." ".$pitchEntry['PitchCompetitionEntryForm']['last_name']?></td>
                                            <td><?=$pitchEntry['PitchCompetitionEntryForm']['email_address']?></td>
                                            <td><?=$pitchEntry['PitchCompetitionEntryForm']['role_id']?></td>
                                            <td><?=$pitchEntry['PitchCompetitionEntryForm']['teacher_full_name']?></td>
                                            <td><?=$pitchEntry['PitchCompetitionEntryForm']['teacher_email_address']?></td>
                                            <td><?=$pitchEntry['PitchCompetitionEntryForm']['kidpreneur_no']?></td>
                                            <td><?=date("m/d/y",strtotime($pitchEntry['PitchCompetitionEntryForm']['registration_date']))?></td>
                                           <td><a href="../Users/downloadkcgtstudent/<?=$pitchEntry['PitchCompetitionEntryForm']['id']?>/KcpcStudent"><img src="../img/download-icon.png" data-toggle="tooltip" data-placement="left" title="Download Kidpreneur List" alt=""></a></td>
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
<?php foreach ($pitchDetails as $pitchEntry) {?>
                                        <tr>
                                            <td><?=$pitchEntry['PitchCompetitionEntryForm']['school_name']?></td>
                                            <td><?=$pitchEntry['PitchCompetitionEntryForm']['kbn']?></td>
                                            <td><?=$pitchEntry['PitchCompetitionEntryForm']['first_name']." ".$pitchEntry['PitchCompetitionEntryForm']['last_name']?></td>
                                            <td><?=$pitchEntry['PitchCompetitionEntryForm']['email_address']?></td>
                                            <td><?=$pitchEntry['PitchCompetitionEntryForm']['role_id']?></td>
                                            <td><?=$pitchEntry['PitchCompetitionEntryForm']['teacher_full_name']?></td>
                                            <td><?=$pitchEntry['PitchCompetitionEntryForm']['teacher_email_address']?></td>
                                            <td><?=$pitchEntry['PitchCompetitionEntryForm']['kidpreneur_no']?></td>
                                            <td><?=date("m/d/y",strtotime($pitchEntry['PitchCompetitionEntryForm']['registration_date']))?></td>
                                           <td><a href="../Users/downloadkcgtstudent/<?=$pitchEntry['PitchCompetitionEntryForm']['id']?>/KcpcStudent"><img src="../img/download-icon.png"  data-toggle="tooltip" data-placement="left" title="Download Kidpreneur List" alt=""></a></td>
                                        </tr>
                                        <?php } ?>
    <?php 
}
?>
<?php echo '#$$#' . $total_count; ?>
