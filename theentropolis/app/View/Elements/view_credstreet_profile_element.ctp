<div id="viewCred" class="modal fade left" role="dialog" >
    <div class="modal-dialog advice-slide-wrap advive-slide-left-sm">

        <!-- Modal content-->
        <div class="modal-content">
        <div class="modal-header top-section">
                    <div class="row">
                    <ul class="dash_profileTab">
                        <li><a href="#dashProfile" data-toggle="tab" class="popup_profile">Profile</a></li>
                        <li><a href="#dashMyWisdom" data-toggle="tab" class="greytab">My Wisdom</a></li>
                        <li><a href="#dashMyEndorsments" data-toggle="tab" class="lightgrey_tab" data-id="<?= $this->Session->read('user_id'); ?>" data-context="<?= $this->Session->read('context_role_user_id') ?>">My Endorsements</a></li>
                    </ul>
                </div>
        </div> 
            <div class="modal-body padding_zero ">
            
            <div class="bs-example advice-tabs">
        
                <div class="tab-content">
                    <div id="dashProfile" class="tab-pane active">
                        <div class="row">
                            <div class="col-md-12 ">
                                <div class="profile_detail relative">
                                    
                                    <div class="profile-img-blck  profile_img">
                                        <?php if ($avatar != '') { ?>   
                                            <img src="<?php echo $this->Html->url('/') . $this->Image->resize($avatar, 128, 128, true); ?>" class="resize-image" />
                                        <?php } else { ?>
                                            <img src="<?php echo $this->Html->url('/') . $this->Image->resize('img/icon-default-user.png', 128, 128, true); ?>" class="resize-image" />
                                        <?php } ?> 
                                       
                                    </div>
                                    <div class="advice_edit profile_detail_view ">
                                         <div class="inside-profile">
                                            <span>

                                            <?php
                                             echo ($user_info['User']['first_name'] . " " . $user_info['User']['last_name']); ?></span> 
                                        

                                            <span class="breakword"><?php echo $user_info['User']['email_address']; ?></span>
                                            <span><?php
                                              

                                            if ($this->session->read("isAdmin")) {
                                                echo "HQ";
                                          
                                            } elseif (strtoupper($arrRole[$info['context_role_id']])=="TEACHER") {
                                                echo "EntropolisKC | Educator";
                                             
                                            } else {
                                                echo "EntropolisKC | ".$arrRole[$info['context_role_id']];
                                                
                                            }

                                            $image_icon_name = $this->Common->getRoleIcon($user_info['User']['id']);

                                            ?>
                                            </span>

                                            <span><?php echo $user_info['User']['account_type']; ?></span>
                                            <?php
                                            if(isset($countryName['Country']['country_title'])) {?>
                                            <span><?php echo $countryName['Country']['country_title']; ?></span>
                                            <?php }?>

                                    </div>
                                    <div class="profile_rating">
                                        <a href="#" class="pull-left no_border"><?php echo $this->Html->image($image_icon_name , array('alt' => ''));  ?></a>
                  
                                        <a href="#" class="pull-right">Rating <span><?php echo ($this->Rating->getHindsightAverageRating($this->Session->read('context_role_user_id')) + $this->Rating->getRatingAllAdvice($this->Session->read('context_role_user_id')) / 2); ?>/10</span></a>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 ">
                                <div class="col-md-7  profile_biography containerHeight custom_scroll">
                                    <h4 class="small_title">Biography</h4>
                                    <?= html_entity_decode($user_info['UserProfile']['short_bio']) ?>
                                    <h4 class="small_title">Experience</h4>
                                    <?= html_entity_decode($user_info['UserProfile']['executive_summary']) ?>
                                </div>
                                <div class="col-md-5 cred_poplinks containerHeight custom_scroll">
                                    <?php if ($user_info['User']['blog'] != "") { ?>
                                        <a href="<?= $user_info['User']['blog'] ?>"><?= $user_info['User']['blog'] ?></a>
                                    <?php }
                                    ?>

                                    <div class="social_links padding_zero">
                                        <?php if ($user_info['User']['twitter_followers'] != "") { ?>
                                            <a target="_blank" href="<?= $user_info['User']['twitter_followers'] ?>"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                                            <?php
                                        }
                                        if ($user_info['User']['facebook_network'] != "") {
                                            ?>
                                            <a target="_blank" href="<?= $user_info['User']['facebook_network'] ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                                            <?php
                                        }
                                        if ($user_info['User']['linkedin_network'] != "") {
                                            ?>
                                            <a target="_blank" href="<?= $user_info['User']['linkedin_network'] ?>"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                                        <?php } ?>
                                    </div>
                                    <?php if ($user_info['User']['blog'] != "") { ?>
                                        <a target="_blank" href="<?= $user_info['User']['other_url']; ?>" class="margin_bottom_30"><?= $user_info['User']['other_url'] ?></a>
                                    <?php }
                                    ?>
                                    <div class="profilePopup_bottomImg">
                                        <span>Image File</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="dashMyWisdom" class="tab-pane">
                       
                                <div class="sage-advice-data">
                                   <?php
                                    echo $this->element('sage_modal_element');
                                    ?>
                        </div>
                    </div>
                    <div id="dashMyEndorsments" class="tab-pane">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="">
                                    <?php
                                    echo $this->element('endorsement_modal_element');
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--                    <div class="row">
                                            <div class="col-md-12">
                                                <div class="profile_popup_bottom_link">
                                                    <div class="modal-footer_actionlinks">
                                                        <a href="#"><i class ="icons add-friend"></i></a>
                                                        <a href="#"><i class ="icons send-mail"></i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>-->
                <div class="cred-street-profile-loading-ajax"><?php echo $this->Html->image('loading-upload.gif', array('alt' => '')); ?></div>
                </div><!-- end of tab-content -->
             </div> 
            
            </div>
        </div>
    </div>



</div>