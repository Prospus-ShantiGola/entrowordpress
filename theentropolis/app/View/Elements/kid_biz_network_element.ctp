<div class="feeds-section custom_scroll">
    <ul>



        <?php
        $invitation = $this->User->getAcceptedInvitation($this->Session->read('user_id'));
        if (!empty($invitation)) {                          //pr($invitation);
            foreach ($invitation as $accepted_invitation) {
                //if current user invite someone else then
                if ($accepted_invitation['Invitation']['inviter_user_id'] == $this->Session->read('user_id')) {

                    if (isset($val) && $val != "all") {
                        if (!array_key_exists($accepted_invitation['Invitation']['invitee_user_id'], $val)) {
                            continue;
                        }
                    }
                    // echo "fd";
                    //pr($accepted_invitation);

                    $userdata = $this->User->getUserData($accepted_invitation['Invitation']['invitee_user_id']);
                    //pr($userdata);
                } else {
                    if (isset($val) && $val != "all") {
                        if (!array_key_exists($accepted_invitation['Invitation']['inviter_user_id'], $val)) {
                            continue;
                        }
                    }


                    $userdata = $this->User->getUserData($accepted_invitation['Invitation']['inviter_user_id']);
                }


                $country = $this->User->getUserCountryNameById($userdata['country_id']);

                //pr($userdata);
                if (isset($userdata['registration_status']) && $userdata['registration_status'] == '1') {
                                    $flying_class = 'kid_business_profile_flyin';
                                    //pr($userdata);
                                    $business_profile = $this->Kidpreneur->businessProfileExist($userdata['id']);
                                     $business_profile_count = $this->Kidpreneur->businessProfileCount($userdata['id']);
                                    if(empty($business_profile))
                                    {
                                        $flying_class = '';
                                    }
                    
                    //pending request ie login user sent mail but not accepted by other user
                    //pr($accepted_invitation);
                    if (($accepted_invitation['Invitation']['inviter_user_id'] == $this->Session->read('user_id')) && $accepted_invitation['Invitation']['invitation_status'] == 0) {
                         
                                    
                                    
                        ?>

                        <div class="list-wrap <?php if ($accepted_invitation['Invitation']['invitation_status'] == 1) {
                    echo $class;
                } ?> getprofile update-view-status" data-type="<?php echo $user_type; ?>" data-id="<?php echo $owner_user_id; ?>" data-direction="right" >

                            <div class="list-profile"><?php if ($userdata['image']) { ?>
                                    <img src="<?php echo $this->Html->url('/') . $userdata['image']; ?>" />
                                <?php } else { ?>

                                    <img src="<?php echo $this->Html->url('/') . $this->Image->resize('img/dummy-pic.png', 100, 100, true); ?>" />
                                <?php } ?></div>

                            <div class="list-profile-detail <?php echo $flying_class?>" data-action="View" data-id="<?php echo @$business_profile['KidBusinessProfile']['id'];?>" data-action ="View" data-limit = '0' data-count =  '<?php echo $business_profile_count ;?>' data-event = "Business">
                                <button class="btn btn-blue right disabled "  data-type ="remove" data-id = '<?php echo $accepted_invitation['Invitation']['id']; ?>' >Pending</button>
                                <h1><?php echo $userdata['username']; ?></h1>
                                <?php if (@$userinfo) { ?> <h5><?php echo @$userinfo['UserProfile']['designation']; ?></h5>
                                <?php } if (!empty($userdata)) { ?>

                                    <span>
                                        <?php if ($userdata['country_id']) { ?> <i><?php echo $this->Html->image('pin.png', array('alt' => '')); ?></i><?php
                                            if (@$userinfo['UserProfile']['city']) {
                                                echo @$userinfo['UserProfile']['city'] . ", " . @@$country[0]['countries']['country_title'];
                                            } else {
                                                echo @$country[0]['countries']['country_title'];
                                            }
                                        }
                                        ?></span>
                <?php } ?>
                            </div>  
                <!--  <a class="right-anchor right" data-id = '<?php echo $accepted_invitation['Invitation']['id']; ?>' data-type ="remove">Pending</a>  --> 


                        </div>



            <?php
            }
            //accepted request ie other user sent mail  accepted by other user
            if (($accepted_invitation['Invitation']['inviter_user_id'] == $this->Session->read('user_id')) && $accepted_invitation['Invitation']['invitation_status'] == 1) {
                ?>

                        <div class="list-wrap <?php if ($accepted_invitation['Invitation']['invitation_status'] == 1) {
                    echo $class;
                } ?> getprofile update-view-status" data-type="<?php echo $user_type; ?>" data-id="<?php echo $owner_user_id; ?>" data-direction="right" >
                            <div class="list-profile"><?php if ($userdata['image']) { ?>
                                    <img src="<?php echo $this->Html->url('/') . $userdata['image']; ?>" />
                                <?php } else { ?>

                                    <img src="<?php echo $this->Html->url('/') . $this->Image->resize('img/dummy-pic.png', 100, 100, true); ?>" />
                                    <?php } ?></div>
                            <div class="list-profile-detail <?php echo $flying_class?>" data-action="View" data-id="<?php echo @$business_profile['KidBusinessProfile']['id'];?>" data-action ="View" data-limit = '0' data-count =  '<?php echo $business_profile_count ;?>' data-event = "Business">
                                    <?php if ($accepted_invitation['Invitation']['invitation_status'] == 1) { ?><a class="btn btn-blue right-anchor right people_remove_btn removed-data manage-invitation-status" data-id = '<?php echo $accepted_invitation['Invitation']['id']; ?>' data-type ="remove">Remove</a>
                                    <?php } ?> 
                                <h1><?php echo $userdata['username']; ?></h1>
                <?php if (@$userinfo) { ?> <h5><?php echo @$userinfo['UserProfile']['designation']; ?></h5>
                <?php } if (!empty($userdata)) { ?>

                                    <span>
                    <?php if ($userdata['country_id']) { ?> <i><?php echo $this->Html->image('pin.png', array('alt' => '')); ?></i><?php
                        if (@$userinfo['UserProfile']['city']) {
                            echo @$userinfo['UserProfile']['city'] . ", " . @@$country[0]['countries']['country_title'];
                        } else {
                            echo @$country[0]['countries']['country_title'];
                        }
                    }
                    ?></span>
                <?php } ?>
                            </div>  

                        </div>



                            <?php
                            }
                            //accepted request 

                            if (($accepted_invitation['Invitation']['invitee_user_id'] == $this->Session->read('user_id')) && $accepted_invitation['Invitation']['invitation_status'] == 1) {
                                ?>

                        <div class="list-wrap <?php if ($accepted_invitation['Invitation']['invitation_status'] == 1) {
                    echo $class;
                } ?> getprofile update-view-status" data-type="<?php echo $user_type; ?>" data-id="<?php echo $owner_user_id; ?>" data-direction="right" >
                            <div class="list-profile"><?php if ($userdata['image']) { ?>
                                    <img src="<?php echo $this->Html->url('/') . $userdata['image']; ?>" />
                <?php } else { ?>

                                    <img src="<?php echo $this->Html->url('/') . $this->Image->resize('img/dummy-pic.png', 100, 100, true); ?>" />
                <?php } ?></div>
                            <div class="list-profile-detail <?php echo $flying_class?>" data-action="View" data-id="<?php echo @$business_profile['KidBusinessProfile']['id'];?>" data-action ="View" data-limit = '0' data-count =  '<?php echo $business_profile_count ;?>' data-event = "Business">
                        <?php if ($accepted_invitation['Invitation']['invitation_status'] == 1) { ?><a class="btn btn-blue right-anchor right people_remove_btn removed-data manage-invitation-status" data-id = '<?php echo $accepted_invitation['Invitation']['id']; ?>' data-type ="remove">Remove</a>
                        <?php } ?> 
                                <h1><?php echo $userdata['username']; ?></h1>
                        <?php if (@$userinfo) { ?> <h5><?php echo @$userinfo['UserProfile']['designation']; ?></h5>
                        <?php } if (!empty($userdata)) { ?>

                                    <span>
                            <?php if ($userdata['country_id']) { ?> <i><?php echo $this->Html->image('pin.png', array('alt' => '')); ?></i><?php
                                if (@$userinfo['UserProfile']['city']) {
                                    echo @$userinfo['UserProfile']['city'] . ", " . @@$country[0]['countries']['country_title'];
                                } else {
                                    echo @$country[0]['countries']['country_title'];
                                }
                            }
                            ?></span>
                <?php } ?>
                            </div>  

                        </div>



            <?php
            }

            
        }
    }
    ?>

<?php } else { ?>

            <div class="no-record"><p>You don’t have anyone added to your network yet</p></div>
<?php } ?>  
    </ul>
</div>
<script type="text/javascript">
    jQuery('body').on('click', '.manage-invitation-status', function (e) {

        e.stopPropagation();
        var $this = $(this);
        var obj_type = $this.data('type');
        var obj_id = $this.data('id');
        if ($this.hasClass('removed-data'))
        {
            bootbox.dialog({
                title: 'Remove user',
                message: "Are you sure you want to remove this Kidpreneur from your network?",
                buttons: {
                    success: {
                        label: "Yes",
                        className: "btn-black",
                        callback: function () {
                            $.ajax({
                                type: 'POST',
                                url: '<?php echo Router::url(array('controller' => 'advices', 'action' => 'invitationStatus')); ?>',
                                data: {

                                    'invitation_id': obj_id,
                                    'status': obj_type,

                                },
                                success: function (resp) {
                                    if (resp == 1) {
                                        //   alert("ddjjjd");
                                        //  alert($this.closest('.list-wrap').attr('class'));
                                        $this.closest('.list-wrap').remove();
                                    } else {
                                        bootbox.alert('Sorry! Kidpreneur not removed from your network.');
                                    }
                                }
                            });
                        }
                    },
                    danger: {
                        label: "No",
                        className: "btn-black"
                    }

                }
            });

        } else
        {

            jQuery.ajax({
                url: '<?php echo Router::url(array('controller' => 'advices', 'action' => 'invitationStatus')); ?>',
                data: {

                    'invitation_id': obj_id,
                    'status': obj_type,

                },
                type: 'POST',
                success: function (data) {

                    if (data == 1)
                    {
                        if (obj_type == 'accept')
                        {
                            $this.next('button').remove();
                            $this.replaceWith('<button class="btn Gray-Btn">Accepted</button>');


                        } else
                        {
                            $this.prev(".accept-data").remove();

                            $this.replaceWith('<button class="btn Gray-Btn">Rejected</button>');


                        }

                        var invCount = $('.activity-count').text();
                        $('.activity-count').text(parseInt(invCount - 1));
                    }

                }
            });
        }
    });
    </script>

