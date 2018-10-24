<div class="col-md-12">
    <?php
  //pr($students); echo $user_type;
    if(count($students)<=0) {
        echo "<p class='text-center'>Please enter the details of your ".$user_type." who are participating in the Kidpreneur Challenge.</p>";
    }
    foreach ($students as $v) { ?>
        <div class="dash_team_wrap clearfix">
            <div class="dash_team_img_wrap">
                <?php echo $this->Html->image('svg-icons/profile-no-pic-icon.svg', array('alt' => '')); ?>
            </div>
            <div class="dash_team_title_wrap">
                <div class="dash_team_info">
                    <span class="student_name"><?= ($v["User"]["username"]) ?></span>
                    <?php
                    $detail = '';
                    if ($v["UserTeacherProfile"]["organization"] != "") {
                        $detail .= $v["UserTeacherProfile"]["organization"];
                    }
                    if ($v["UserTeacherProfile"]["kbn_number"] != "") {
                        $detail .= (($detail == "") ? $v["UserTeacherProfile"]["kbn_number"] : " / " . $v["UserTeacherProfile"]["kbn_number"]);
                    }
                    ?>
                    <span class="student_desc"><?=$detail?></span>

                    <i class="icons view-icon view-student-info" data-role ="<?php echo $role;?>"  data-formtitle ='' data-action ="View" data-id="<?= $v["User"]["id"] ?>"></i>
                </div>
                <div class="team_remove">
                    <a href="#" data-id="<?= $v["User"]["id"] ?>" data-role= "<?php echo $role; ?>" class="remove-student">Remove</a>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
<script type="text/javascript">

    jQuery('body').on('click', '.remove-student', function (event) {
        var obj = $(this);
        var student_id = $(this).data('id');
        var role = $(this).data('role');
        if(role=='Parent')
        {
            var user_type = 'Kidpreneur';
        }
        else
        {
            var user_type = 'Student';
        }


        bootbox.dialog({
            title: "Confirm Deletion",
            message: "Are you sure you want to remove this "+user_type+"?",
            buttons: {
                success: {
                    label: "Yes",
                     className:'btn-default', 
                    callback: function () {
                        $('.loading').show();
                        $.ajax({
                            type: 'POST',
                            url: '<?php echo Router::url(array('controller' => 'users', 'action' => 'remove_student')); ?>',
                            data: {
                                'student_id': student_id,
                            },
                            success: function (data) {
                                $('.loading').hide();
                                if (data.result == "error") {
                                    // bootbox.alert({
                                    //     title: "Error!!",
                                    //     message: data.error_msg,
                                      
                                    // });

                                    bootbox.dialog({
                                      message: data.error_msg,
                                      title: "Error!!",
                                      buttons: {
                                        success: {
                                          label: "OK",
                                          className: "btn-default",
                                          // callback: function() {
                                          //   Example.show("great success");
                                          // }
                                        }}
                                    });

                                } else {
                                    // bootbox.alert({
                                    //     title: user_type +" Removed!!",
                                    //     message: data.result,

                                    // });

                                    bootbox.dialog({
                                      message: data.result,
                                      title: user_type +" Removed!!",
                                      buttons: {
                                        success: {
                                          label: "OK",
                                          className: "btn-default",
                                          // callback: function() {
                                          //   Example.show("great success");
                                          // }
                                        }}
                                    });

                                    $('.teacher_profile_detail_wrap').html(data.data);
                                    if(obj.hasClass('hide-flyout'))
                                    {
                                        // alert('sd');
                                        $('#addStudentFlyout').modal('hide');
                                    }
                                    customScroll();
                                    manageTopPanelHeight();

                                }
                            }
                        });
                    }
                },
                danger: {
                    label: "No",
                    className:'btn-default'
                }
            }
        });
    });


    $('body').on('click','.add-student-flyout',function(){


        var student_id = $(this).data('id');

        $.ajax({
            url:'<?php echo Router::url(array("controller"=>"users", "action"=>"getKidFlyoutModal"));?>',

            data: {
                'student_id':student_id,
                'role':$(this).data('role'),
                'action':$(this).data('action'),
                'formtitle':$(this).data('formtitle')

            },
            type: 'POST',
            success: function (data) {

                $('#viewStudentFlyout').modal('hide');
                // $('#editStudentFlyout').modal('show');
                //  $('#editStudentFlyout').html(data);
                $('#addStudentFlyout').modal('show');
                $('#addStudentFlyout').html(data);
                addKidpreneurForm.init();

            }
        });
    })

 

</script>



