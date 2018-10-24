<?php
if ($fetch_type == 'loadmore') {
                                    foreach ($pipeline_data as $v) {

                                        $Pipeline = $v['Pipeline'];
                                        $Country = $v['Country'];
                                        $country = ($Country["country_title"] == "") ? "NA" : $Country["country_title"];
                                        $interested_in = ($Pipeline["intrested_in"] == "") ? "NA" : $Pipeline["intrested_in"];
                                        $school_name = ($Pipeline["school"] == "") ? "NA" : $Pipeline["school"];
                                        $full_name = $Pipeline['full_name'];
                                        $email = $Pipeline['email'];
                                        $form_id = $Pipeline['form_id'];
                                        ?>
                                        <tr> 
                                            <td><?= $full_name ?></td>  
                                            <td><?= $email ?></td>
                                            <td><?= $country ?></td>
                                            <td><?= $school_name ?></td>
                                            <td><?= $form_id ?></td>
                                        </tr>
<?php }
} else {?>
                                        <table class="table table-striped advices-table main-table-wrap table-condensed  remove-scroll pipeline-list ">
                                <thead>
                                    <tr>
                                        <th>Full Name</th>
                                        <th>Email Address</th>
                                        <th>Country</th>                          
                                        <th>School Name</th>
                                        <th>Form ID</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($pipeline_data as $v) {

                                        $Pipeline = $v['Pipeline'];
                                        $Country = $v['Country'];
                                        $country = ($Country["country_title"] == "") ? "NA" : $Country["country_title"];
                                        $interested_in = ($Pipeline["intrested_in"] == "") ? "NA" : $Pipeline["intrested_in"];
                                        $school_name = ($Pipeline["school"] == "") ? "NA" : $Pipeline["school"];
                                        $full_name = $Pipeline['full_name'];
                                        $email = $Pipeline['email'];
                                        $form_id = $Pipeline['form_id'];
                                        ?>
                                        <tr> 
                                            <td><?= $full_name ?></td>  
                                            <td><?= $email ?></td>
                                            <td><?= $country ?></td>
                                            <td><?= $school_name ?></td>
                                            <td><?= $form_id ?></td>
                                        </tr>
<?php } if(count($pipeline_data)==0){?>
    <tr>
                                            <td colspan= "6" style = "background-color:#f2f2f2; text-align:center;" class="no-record">No records found.</td>
                                        </tr><?php }?>
                                </tbody>
                            </table>
                                        <?php if ($total_count > 2) { ?>
            <div class="margin-bottom clearfix load-more-btn" id="loadmorebtn">
                <button class="btn btn-orange-small margin-top-small large right" onclick="loadmoredata();">Load More</button>
            </div>
    <?php } ?>
                                        <?php } ?>
<?php echo '#$$#' . $total_count; ?>
