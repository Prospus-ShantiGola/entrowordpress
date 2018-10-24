<div class="full-switch-viewwrapper <?php echo ($businessKey == 0) ? "" : " hide ";
        echo "bussinessprofile-$businessKey" ?> ">
                            <div class="col-md-5 kd-custom_width_panel " style="padding-left:0;">
                                <div class="kd-title_box">
                                    <h3 class="kd-dash_titles"  style="flex:1 100px;">BUSINESS PROFILE</h3>
                                    <div class="arrow-kd">
                                            <?php 
                                            $profile_count = $this->Kidpreneur->businessProfileCount($kid_info['User']['id']);
                                            if($profile_count>1){
                                            echo $this->Html->image('svg-icons/arrow-left-right1.svg',array('onClick'=>'flipProfile(".bussinessprofile-'.$businessKey.'",'.$businessKey.','.(count($kid_info['KidBusinessProfile'])-1).');')); 
                                            
                                            }?>
                                            <?php //pr();?>
                                        </div>
                                </div>
                                <div class="kd-account_wrapper custom_scroll view_setting_scroll" style="background-color: white;padding: 15px;">
                                    <div class="profile_detail relative">
                                        <div class="profile-img-blck  profile_img">
                                            <div class="row">
                                                <div class="col-md-3 col-xs-3 p-r-0 text-center">
                                                    <?php 
//                                                    pr(@$kid_info);
//                                                    die;
                                                    //$avatar=@$kid_info['User']['user_image'];
                                                    
                                                    if ($kid_info['KidBusinessProfile'][$businessKey]['product_image'] != '') { ?>
                                                        <img src="<?php echo $this->Html->url('/', true) .@$kid_info['KidBusinessProfile'][$businessKey]['product_image']; ?>">
        <?php } else { ?>
                                                        <img width="100%" src="<?php echo $this->Html->url('/') . $this->Image->resize('img/icon-default-user.png', 128, 128, true); ?>" class="resize-image" />
        <?php } ?>
                                                        <p class="text-center profile-web" style="margin: 10px 0;font-size: 0.8em;"><a target="_blank" href="<?php echo $kid_info['KidBusinessProfile'][$businessKey]['business_website'];?>"><?php echo @$kid_info['KidBusinessProfile'][$businessKey]['business_website'] ?></a></p>
                                                        <?php if(count($kid_info['KidBusinessProfile'])!=MAX_BUSINESS_PROFILE) { ?>
                                                        <a href="<?php echo Router::url(array('controller' => 'kidpreneurs', 'action' => 'settings','add')) ?>">      <button type="button" class="btn blue_filled btnipad<?php echo (count($kid_info['KidBusinessProfile'])==MAX_BUSINESS_PROFILE)? " hide ":"" ?>" style="margin: 10px auto; font-size: 11px;">ADD BUSINESS</button></a>
                                                        <?php }?>
                                                </div> <!--col md 3-->

                                                <div class="col-md-9">
                                                     <div class="col-md-12 col-xs-12 p-0">
                                                        <div class="col-md-9 col-xs-9" style="padding: 0px">
                                                            <div class="profile-about-block">
                                                                <h4><strong><?php echo $kid_info['KidBusinessProfile'][$businessKey]['business_name']; ?></strong></h4>
                                                                <h4 class="m-b-0">Founded: <span><?php echo $kid_info['KidBusinessProfile'][$businessKey]['founded_year']; ?></span></h4> 
                                                                <h4>Start-up $$: <span><?php echo $kid_info['KidBusinessProfile'][$businessKey]['start_up']; ?>$</span></h4>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 col-xs-3">
                                                            <div class="advice_edit profile_detail_view ">
                                                                <div class="profile_rating">
                                                                    <a href="#" class="pull-left no_border">

                                                                            <?php 
                                                        if(isset($kid_info['User']['user_image']) && $kid_info['User']['user_image'] !=""){
                                                            ?><img src="<?php echo $this->Html->url('/') . $kid_info['User']['user_image']; ?>" class="resize-image" width="100%" />
                                                        <?php }
                                                        else{
                                                            echo $this->Html->image('2.svg'); 
                                                        }
                                                        ?>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                      </div>
<!-- 
                                                    <h4 class="kd-top-none" style="color:#000;font-size: 14px; width: 75%;"><strong><?php echo $kid_info['KidBusinessProfile'][$businessKey]['business_name']; ?></strong></h4>
                                                    <div class="profile-block">
                                                        <h4>Founded: <span><?php echo $kid_info['KidBusinessProfile'][$businessKey]['founded_year']; ?></span></h4> 
                                                    </div>

                                                    <div class="profile-block">
                                                        <h4>Start-up: <span>$<?php echo $kid_info['KidBusinessProfile'][$businessKey]['start_up']; ?></span></h4>
                                                    </div> -->
                                                    <div class="col-md-12" style="padding: 0px;">
                                                        <div class="profile-block">
                                                            <h4>Founders / business owners</h4>
                                                            <ol type="1">
                                                                <?php 
                                                                $business_owners=$this->KidBusinessOwner->getKidBusinessOwnerById($kid_info['KidBusinessProfile'][$businessKey]['id']);
                                                                pr($business_owners);
                                                                if (count($business_owners) > 0 ) { ?>
                                                                    <?php foreach ($business_owners as $business_owner) { ?>
                                                                        <li><?php echo $business_owner['KidBusinessOwner']['business_owner']; ?></li>
                <?php }
            }
            ?>
                                                            </ol>
                                                        </div>
                                                        <div class="profile-block">
                                                            <h4>About my Business</h4>
                                                            <p><?php
                                                                $about_business = $kid_info['KidBusinessProfile'][$businessKey]['about_business'];
                                                                $about_business = preg_replace('/<!--(.|\s)*?-->/', '', $about_business);
                                                                if (strlen($about_business) > 400) {
                                                                    ?>
                                                                <div class=" person-content short-data"><?php
                                                                    // echo substr($post['Escene']['post_description'], $remaining-1 );
                                                                    $actual_lenth = strlen(trim($about_business));
                                                                    echo $this->Eluminati->text_cut($about_business, $length = 400, $dots = true);
                                                                    $later_length = strlen(trim($this->Eluminati->text_cut($about_business, $length = 400, $dots = true)));
                                                                    ?></b></strong></a></em></i></div>
                                                                <div class=" person-content full-data hide"  data-to="1"> <?php echo $about_business; ?></div>
                                                                <?php if ($actual_lenth != $later_length) { ?>
                                                                    <a href="#1" class="right btn-readmorestuff">Read more</a>
                                                                <?php } ?><?php } else {
                                                                ?>
                                                                <div class=" person-content short-data"><?php echo $this->Eluminati->text_cut($about_business, $length = 400, $dots = true); ?>
                                                                </div>
            <?php } ?></p>
                                                        </div>
                                                        <div class="profile-block">
                                                            <h4>Mission</h4>
                                                            <p><?php
                                                                $mission = $kid_info['KidBusinessProfile'][$businessKey]['mission'];
                                                                $mission = preg_replace('/<!--(.|\s)*?-->/', '', $mission);
                                                                if (strlen($mission) > 400) {
                                                                    ?>
                                                                <div class=" person-content short-data"><?php
                                                                    // echo substr($post['Escene']['post_description'], $remaining-1 );
                                                                    $actual_lenth = strlen(trim($mission));
                                                                    echo $this->Eluminati->text_cut($mission, $length = 400, $dots = true);
                                                                    $later_length = strlen(trim($this->Eluminati->text_cut($mission, $length = 400, $dots = true)));
                                                                    ?></b></strong></a></em></i></div>
                                                                <div class=" person-content full-data hide"  data-to="1"> <?php echo $mission; ?></div>
                                                                <?php if ($actual_lenth != $later_length) { ?>
                                                                    <a href="#1" class="right btn-readmorestuff">Read more</a>
                <?php } ?><?php } else {
                ?>
                                                                <div class=" person-content short-data"><?php echo $this->Eluminati->text_cut($mission, $length = 400, $dots = true); ?>
                                                                </div>
            <?php } ?></p>
                                                        </div>
                                                        <div class="profile-block">
                                                            <h4>Vision and goals</h4>
                                                            <p> <?php
                                                                $vision_goal = $kid_info['KidBusinessProfile'][$businessKey]['vision_goal'];
                                                                $vision_goal = preg_replace('/<!--(.|\s)*?-->/', '', $vision_goal);
                                                                if (strlen($vision_goal) > 400) {
                                                                    ?>
                                                                <div class=" person-content short-data"><?php
                                                                    // echo substr($post['Escene']['post_description'], $remaining-1 );
                                                                    $actual_lenth = strlen(trim($vision_goal));
                                                                    echo $this->Eluminati->text_cut($vision_goal, $length = 400, $dots = true);
                                                                    $later_length = strlen(trim($this->Eluminati->text_cut($vision_goal, $length = 400, $dots = true)));
                                                                    ?></b></strong></a></em></i></div>
                                                                <div class=" person-content full-data hide"  data-to="1"> <?php echo $vision_goal; ?></div>
                                                                <?php if ($actual_lenth != $later_length) { ?>
                                                                    <a href="#1" class="right btn-readmorestuff">Read more</a>
                                                                <?php } ?><?php } else {
                                                    ?>
                                                                <div class=" person-content short-data"><?php echo $this->Eluminati->text_cut($vision_goal, $length = 400, $dots = true); ?>
                                                                </div>
            <?php } ?></p>
                                                        </div>
                                                        <div class="profile-block">
                                                            <h4>Revenue</h4>
                                                            <p><?php
                                                                $revenue = $kid_info['KidBusinessProfile'][$businessKey]['revenue'];
                                                                $revenue = preg_replace('/<!--(.|\s)*?-->/', '', $revenue);
                                                                if (strlen($revenue) > 400) {
                                                                    ?>
                                                                <div class=" person-content short-data"><?php
                                                                    // echo substr($post['Escene']['post_description'], $remaining-1 );
                                                                    $actual_lenth = strlen(trim($revenue));
                                                                    echo $this->Eluminati->text_cut($revenue, $length = 400, $dots = true);
                                                                    $later_length = strlen(trim($this->Eluminati->text_cut($revenue, $length = 400, $dots = true)));
                                                                    ?></b></strong></a></em></i></div>
                                                                <div class=" person-content full-data hide"  data-to="1"> <?php echo $revenue; ?></div>
                                                                <?php if ($actual_lenth != $later_length) { ?>
                                                                    <a href="#1" class="right btn-readmorestuff">Read more</a>
                                                                <?php } ?><?php } else {
                                                                ?>
                                                                <div class=" person-content short-data"><?php echo $this->Eluminati->text_cut($revenue, $length = 400, $dots = true); ?>
                                                                </div>
                                                            <?php } ?></p>
                                                        </div>
                                                        <div class="profile-block">
                                                            <h4>Donated</h4>
                                                            <p> <?php
                                                                $donated = $kid_info['KidBusinessProfile'][$businessKey]['donated'];
                                                                $donated = preg_replace('/<!--(.|\s)*?-->/', '', $donated);
                                                                if (strlen($donated) > 400) {
                                                                    ?>
                                                                <div class=" person-content short-data"><?php
                                                        // echo substr($post['Escene']['post_description'], $remaining-1 );
                                                        $actual_lenth = strlen(trim($donated));
                                                        echo $this->Eluminati->text_cut($donated, $length = 400, $dots = true);
                                                        $later_length = strlen(trim($this->Eluminati->text_cut($donated, $length = 400, $dots = true)));
                                                                    ?></b></strong></a></em></i></div>
                                                                <div class=" person-content full-data hide"  data-to="1"> <?php echo $donated; ?></div>
                                                                <?php if ($actual_lenth != $later_length) { ?>
                                                                    <a href="#1" class="right btn-readmorestuff">Read more</a>
                                                                <?php } ?><?php } else {
                                                                ?>
                                                                <div class=" person-content short-data"><?php echo $this->Eluminati->text_cut($donated, $length = 400, $dots = true); ?>
                                                                </div>
                                                            <?php } ?></p>
                                                        </div>
                                                        <div class="profile-block hide <?php echo (count($kid_info['KidBusinessProfile'])==MAX_BUSINESS_PROFILE)? " hide ":"" ?>">
                                                            <button class="btn filled-btn btnipad  kid-new-theme-btn pull-right" onclick="addNewBusiness()" style="border-radius: 0;">Add business</button>
                                                        </div>
                                                    </div><!--col md 12-->
                                                </div> <!--col md 9-->
                                            </div> <!--row-->
                                        </div> <!--imgblck-->
                                        <!-- <div class="advice_edit profile_detail_view ">
                                            <div class="profile_rating">
                                                <a href="#" class="pull-left no_border">
                                                   <?php 
                                                    if(isset($kid_info['User']['user_image']) && $kid_info['User']['user_image'] !=""){
                                                        ?><img src="<?php echo $this->Html->url('/') . $kid_info['User']['user_image']; ?>" class="resize-image" width="100%" />
                                                    <?php }
                                                    else{
                                                        echo $this->Html->image('2.svg'); 
                                                    }
                                                    ?>
                                                </a>
                                            </div> 
                                        </div>  --><!--profile avatar-->
                                    </div>
                                </div> 
                            </div> <!--====== end 2nd col===-->
                            <div class="col-md-2 kd-custom_width_sidebar_panel" style="padding:0;">
                                <div class="kd-title_box">
                                    <h3 class="kd-dash_titles">MY BUSINESS PROFILE</h3>
                                    
                                </div>
                                <div class="kd-account_social_wrap custom_scroll view_setting_scroll" style="background-color: white;padding: 15px;">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4 class="kd-top-none">Product Features and Benefits</h4>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="filled-details" style="margin-top: -10px;">
                                                <p><?php

                                        $feature_benefit = $kid_info['KidBusinessProfile'][$businessKey]['feature_benefit'];
                                        $feature_benefit = preg_replace('/<!--(.|\s)*?-->/', '', $feature_benefit);
                                        if (strlen($feature_benefit) > 400) {
                                            ?>
                                            <div class=" person-content short-data"><?php
                                                // echo substr($post['Escene']['post_description'], $remaining-1 );  
                                                $actual_lenth = strlen(trim($feature_benefit));
                                                echo $this->Eluminati->text_cut($feature_benefit, $length = 400, $dots = true);
                                                $later_length = strlen(trim($this->Eluminati->text_cut($feature_benefit, $length = 400, $dots = true)));
                                                ?></b></strong></a></em></i></div>
                                            <div class=" person-content full-data hide"  data-to="1"> <?php echo $feature_benefit; ?></div>
                                            <?php if ($actual_lenth != $later_length) { ?>
                                                <a href="#1" class="right btn-readmorestuff">Read more</a>
                                            <?php } ?><?php } else {
                                            ?>
                                            <div class=" person-content short-data"><?php echo $this->Eluminati->text_cut($feature_benefit, $length = 400, $dots = true); ?>
                                            </div>
                                        <?php } ?></p>
                                            </div>
                                            <h4>Website</h4>
                                            <div class="filled-details">
                                                <p class="profile-web m-b-5"><a href="<?php echo $kid_info['KidBusinessProfile'][$businessKey]['business_website'];?>" target="_blank"><?php echo $kid_info['KidBusinessProfile'][$businessKey]['business_website'];?></a></p>
                                            </div>
                                        </div>
                                        <div class="col-md-4" style="padding-left: 0">
                                            <div class="kd-img-gallery kd-gallery">
                                                <div class="kd-box" style="margin-top:0px;">
                                                   <?php if(@$kid_info['KidBusinessProfile'][$businessKey]['logo_image']){
                                                ?>


                                                <label for="logo_image_upload"> <div class="img-section row-wrap">
                                                        <img src="<?php echo $this->Html->url('/', true) .@$kid_info['KidBusinessProfile'][$businessKey]['logo_image']; ?>">

                                                        <input type="hidden" name="data[KidBusinessProfile][logo_image]" value="<?php echo @$kid_info['KidBusinessProfile'][$businessKey]['logo_image']?>"></div></label>
                                            <?php }else{?>
                                                <label for="logo_image_upload">LOGO<input type ='hidden' name ="data[KidBusinessProfile][logo_image]" value=""> </label>
                                            <?php }  ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!--row end--> 
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4>Product Gallery</h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 kd-mg-rgt">
                                            <div class="kd-img-gallery kd-gallery">
                                                <div class="kd-box" style="padding: 0px;">
                                                    <?php $business_images=$this->KidProductGallery->getKidProductGalleryById($kid_info['KidBusinessProfile'][$businessKey]['id']);  // pr($business_images);die;?>
                                                    <?php echo $this->element('product_gallery_element', array('gallery'=> $business_images[0]['KidProductGallery'],'action'=>'View')); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mid_col">
                                            <div class="kd-img-gallery kd-gallery">
                                                <div class="kd-box" style="padding: 0px;">
                                                    <?php echo $this->element('product_gallery_element', array('gallery'=> $business_images[1]['KidProductGallery'],'action'=>'View')); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 kd-mg-lft">
                                            <div class="kd-img-gallery kd-gallery">
                                                <div class="kd-box" style="padding: 0px;">
                                                    <?php echo $this->element('product_gallery_element', array('gallery'=> $business_images[2]['KidProductGallery'],'action'=>'View')); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row kd-img-top">
                                        <div class="col-md-4 kd-mg-rgt">
                                            <div class="kd-img-gallery kd-gallery">
                                                <div class="kd-box" style="padding: 0px;">
                                                    <?php echo $this->element('product_gallery_element', array('gallery'=> $business_images[3]['KidProductGallery'],'action'=>'View')); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mid_col">
                                            <div class="kd-img-gallery kd-gallery">
                                                <div class="kd-box" style="padding: 0px;">
                                                    <?php echo $this->element('product_gallery_element', array('gallery'=> $business_images[4]['KidProductGallery'],'action'=>'View')); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 kd-mg-lft">
                                            <div class="kd-img-gallery kd-gallery">
                                                <div class="kd-box"  style="padding: 0px;"style="padding: 0px;">
                                                    <?php echo $this->element('product_gallery_element', array('gallery'=> $business_images[5]['KidProductGallery'],'action'=>'View')); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4 style="margin-top: 15px;">Pitch Video</h4>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="video kd-video">
                                                 <?php if($kid_info['KidBusinessProfile'][$businessKey]['pitch_video_id']!='')
                                        {
                                            $videoId=explode("v=",$kid_info['KidBusinessProfile'][$businessKey]['pitch_video_id']);
                                            $videodata = file_get_contents("https://www.googleapis.com/youtube/v3/videos?key=AIzaSyDXmcVVM_xgfixa1YGqEbmHLDSSysFRk7k&part=snippet&id=".$videoId[1]);
$jsondata = json_decode($videodata);
if (count($jsondata->items[0])==0) {
   echo $this->Html->image('pending_approval.png',array('class'=>'kd-img-upload'));
   
}else{
    ?><a href="javascript:void(0)" class="blue play-video-popup" data-toggle="modal" data-target="#blogVideoPopup" data-video="http://www.youtube.com/embed/<?php echo $videoId[1];?>" data-title="eco">
                                        <img src="https://img.youtube.com/vi/<?php echo $videoId[1];?>/hqdefault.jpg">
                                        </a>
        <?php
}
                                            
                                        }else
                                        {?>
                                            <label for="fileToUploadAdd"><?php echo $this->Html->image('wq4.svg',array('class'=>'kd-img-upload')); ?></label>
                                        <?php  } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4 style="margin-top: 15px;">Other Pics</h4>
                                        </div>
                                        <div class="col-md-4 kd-mg-rgt">
                                            <div class="kd-img-gallery kd-gallery">
                                                <div class="kd-box" style="padding: 0px;">
                                                    <?php echo $this->element('product_gallery_element', array('gallery'=> $business_images[6]['KidProductGallery'],'action'=>'View')); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mid_col">
                                            <div class="kd-img-gallery kd-gallery">
                                                <div class="kd-box" style="padding: 0px;">
                                                    <?php echo $this->element('product_gallery_element', array('gallery'=> $business_images[7]['KidProductGallery'],'action'=>'View')); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 kd-mg-lft">
                                            <div class="kd-img-gallery kd-gallery" >
                                                <div class="kd-box" style="padding: 0px;">
                                                    <?php echo $this->element('product_gallery_element', array('gallery'=> $business_images[8]['KidProductGallery'],'action'=>'View')); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row kd-img-top">
                                        <div class="col-md-4 kd-mg-rgt">
                                            <div class="kd-img-gallery kd-gallery">
                                                <div class="kd-box" style="padding: 0px;"> 
                                                    <?php echo $this->element('product_gallery_element', array('gallery'=> $business_images[9]['KidProductGallery'],'action'=>'View')); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mid_col">
                                            <div class="kd-img-gallery kd-gallery">
                                                <div class="kd-box" style="padding: 0px;">
                                                    <?php echo $this->element('product_gallery_element', array('gallery'=> $business_images[10]['KidProductGallery'],'action'=>'View')); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4 kd-mg-lft">
                                            <div class="kd-img-gallery kd-gallery">
                                                <div class="kd-box" style="padding: 0px;">
                                                   <?php echo $this->element('product_gallery_element', array('gallery'=> $business_images[11]['KidProductGallery'],'action'=>'View')); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                            </div><!--====== end 3rd col===-->
                        </div> <!--====== end switch wrapper===-->