<div class="bs-example advice-tabs">
    <div class="tab-content ">
        <div id="dashkidProfile" class="tab-pane active p-15">
            <div class="row">
                <div class="col-md-4">
                    <div class="profile_detail relative">

                        <div class="profile-img-blck  profile_img">

                            <div class="kd-img-gallery kd-gallery" id = "hidden_product">
                                <div class="kd-box" >
                                    <?php if(@$business_info['KidBusinessProfile']['product_image']){
                                        ?>


                                        <label for="product_image_upload"> <div class="img-section row-wrap">
                                                <img src="<?php echo $this->Html->url('/', true) .@$business_info['KidBusinessProfile']['product_image']; ?>">

                                                <input type="hidden" name="data[KidBusinessProfile][product_image]" value="<?php echo @$business_info['KidBusinessProfile']['product_image']?>"></div></label>
                                    <?php }else{?>
                                        <label for="product_image_upload">Product Image<input type ='hidden' name ="data[KidBusinessProfile][product_image]" value=""> </label>
                                    <?php }  ?>

                                </div> </div>


                            <p class="text-center m-5 profile-web" ><a target="_blank" href="<?php echo $business_info['KidBusinessProfile']['business_website'];?>"><?php echo $business_info['KidBusinessProfile']['business_website'];?></a></p>

                            <?php



                            if($business_info['KidBusinessProfile']['user_id'] == $this->Session->read('user_id')){

                                // // $dd = $this->Kidpreneur->getAllBusinessProfileData($business_info['KidBusinessProfile']['user_id'],$business_info['KidBusinessProfile']['id']);
                                // pr($dd);

                                $profile_count =  $this->Kidpreneur->businessProfileCount($business_info['KidBusinessProfile']['user_id']);

                                $class_added = 'disabled';
                                if($profile_count>1)
                                {
                                    $class_added = '';
                                }
                            }
                            else
                            {
                                $profile_count =  $this->Kidpreneur->getPublishedBusinessProfileCount($business_info['KidBusinessProfile']['user_id']);
                                $class_added = 'disabled';
                                if($profile_count>1)
                                {
                                    $class_added = '';
                                }
                            }
                            ?>
                            <button class="btn filled-btn switch_business_flyin kid_business_profile_flyin kid-new-theme-btn <?php echo $class_added ;?>" data-id="<?php echo $next_info_id; ?>" data-count =  '<?php echo $profile_count ;?>' data-action="View" data-event="Switch"  data-limit  =  >Switch profile

                                <?php echo $this->Html->image('arrow-left-right.png',array('style'=>'width: 12px; margin-left: 5px;'))?>

                            </button>


                            <?php


                            if ($business_info['KidBusinessProfile']['user_id'] == $this->Session->read('user_id')){?>

                                <a class="btn wht-filled-btn kid-new-theme-btn fff-color   kid_business_profile_flyin" data-toggle="modal" data-id="<?php echo $business_info['KidBusinessProfile']['id'] ?>" data-action="Edit" data-event="Business">EDIT</a>
                            <?php } ?>

                            <input type = 'hidden' value ='<?php echo $profile_count -1 ;?>' class = 'total_business_flyin'>


                        </div>
                    </div>
                </div>

                <div class="col-md-8 p-l-10">

                    <div class="row">
                        <div class="col-md-12 col-xs-12 p-0">
                            <div class="col-md-9 col-xs-9" style="padding-right: 0">
                                <div class="profile-about-block">
                                    <h4 style="margin-top: 5px;"> <span><?php echo $business_info['KidBusinessProfile']['business_name'];?></span></h4>
                                    <h4 class="m-b-0">Founded: <span><?php echo $business_info['KidBusinessProfile']['founded_year'];?></span></h4>
                                    <h4>Start-up $$: <span><?php echo $business_info['KidBusinessProfile']['start_up'];?>$</span></h4>
                                </div>
                            </div>
                            <div class="col-md-3 col-xs-3">
                                <div class="advice_edit profile_detail_view ">
                                    <div class="profile_rating">
                                        <a href="#" class="pull-left no_border">
 <?php 
                                                    if(isset($business_info['User']['user_image']) && $business_info['User']['user_image'] !=""){
                                                        ?><img src="<?php echo $this->Html->url('/') . $business_info['User']['user_image']; ?>" class="resize-image" width="100%" />
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
                    </div>
                    <div class="row containerHeight custom_scroll" style="margin-top: 10px;">
                        <div class="col-md-12">
                            <div class="" >
                                <div class="profile-block clearfix" >
                                    <h4>Founders / business owners</h4>
                                    <ul>
                                        <?php $i = 1;foreach ($business_info['KidBusinessOwner'] as $business_owner) {?>
                                           <li> <span class="m-r-10"><?php echo $i;?></span><?php echo $business_owner['business_owner'];?></li>
                                        <?php $i++;  } ?>
                                    </ul>
                                </div>
                                <div class="profile-block clearfix">
                                    <h4>About my Business</h4>

                                    <?php

                                    $about_business = $business_info['KidBusinessProfile']['about_business'];
                                    $about_business = preg_replace('/<!--(.|\s)*?-->/', '', $about_business);
                                    if (strlen($about_business) > 400) {
                                        ?>
                                        <div class=" person-content short-data m-b-10"><?php
                                            // echo substr($post['Escene']['post_description'], $remaining-1 );
                                            $actual_lenth = strlen(trim($about_business));
                                            echo $this->Eluminati->text_cut($about_business, $length = 400, $dots = true);
                                            $later_length = strlen(trim($this->Eluminati->text_cut($about_business, $length = 400, $dots = true)));
                                            ?></b></strong></a></em></i></div>
                                        <div class=" person-content full-data hide"  data-to="1"> <?php echo $about_business; ?></div>
                                        <?php if ($actual_lenth != $later_length) { ?>
                                            <a href="#1" class="right btn-readmorestuffKid">Read more</a>
                                        <?php } ?><?php } else {
                                        ?>
                                        <div class=" person-content short-data m-b-10"><?php echo $this->Eluminati->text_cut($about_business, $length = 400, $dots = true); ?>
                                        </div>
                                    <?php } ?>

                                </div>

                                <div class="profile-block clearfix">
                                    <h4>Mission</h4>

                                    <?php

                                    $mission = $business_info['KidBusinessProfile']['mission'];
                                    $mission = preg_replace('/<!--(.|\s)*?-->/', '', $mission);
                                    if (strlen($mission) > 400) {
                                        ?>
                                        <div class=" person-content short-data m-b-10"><?php
                                            // echo substr($post['Escene']['post_description'], $remaining-1 );
                                            $actual_lenth = strlen(trim($mission));
                                            echo $this->Eluminati->text_cut($mission, $length = 400, $dots = true);
                                            $later_length = strlen(trim($this->Eluminati->text_cut($mission, $length = 400, $dots = true)));
                                            ?></b></strong></a></em></i></div>
                                        <div class=" person-content full-data hide"  data-to="1"> <?php echo $mission; ?></div>
                                        <?php if ($actual_lenth != $later_length) { ?>
                                            <a href="#1" class="right btn-readmorestuffKid">Read more</a>
                                        <?php } ?><?php } else {
                                        ?>
                                        <div class=" person-content short-data m-b-10"><?php echo $this->Eluminati->text_cut($mission, $length = 400, $dots = true); ?>
                                        </div>
                                    <?php } ?>



                                </div>

                                <div class="profile-block clearfix">
                                    <h4>Vision and goals</h4>


                                    <?php

                                    $vision_goal = $business_info['KidBusinessProfile']['vision_goal'];
                                    $vision_goal = preg_replace('/<!--(.|\s)*?-->/', '', $vision_goal);
                                    if (strlen($vision_goal) > 400) {
                                        ?>
                                        <div class=" person-content short-data m-b-10"><?php
                                            // echo substr($post['Escene']['post_description'], $remaining-1 );
                                            $actual_lenth = strlen(trim($vision_goal));
                                            echo $this->Eluminati->text_cut($vision_goal, $length = 400, $dots = true);
                                            $later_length = strlen(trim($this->Eluminati->text_cut($vision_goal, $length = 400, $dots = true)));
                                            ?></b></strong></a></em></i></div>
                                        <div class=" person-content full-data hide"  data-to="1"> <?php echo $vision_goal; ?></div>
                                        <?php if ($actual_lenth != $later_length) { ?>
                                            <a href="#1" class="right btn-readmorestuffKid">Read more</a>
                                        <?php } ?><?php } else {
                                        ?>
                                        <div class=" person-content short-data m-b-10"><?php echo $this->Eluminati->text_cut($vision_goal, $length = 400, $dots = true); ?>
                                        </div>
                                    <?php } ?>


                                </div>


                                <div class="profile-block clearfix">
                                    <h4>Revenue</h4>


                                    <?php

                                    $revenue = $business_info['KidBusinessProfile']['revenue'];
                                    $revenue = preg_replace('/<!--(.|\s)*?-->/', '', $revenue);
                                    if (strlen($revenue) > 400) {
                                        ?>
                                        <div class=" person-content short-data m-b-10"><?php
                                            // echo substr($post['Escene']['post_description'], $remaining-1 );
                                            $actual_lenth = strlen(trim($revenue));
                                            echo $this->Eluminati->text_cut($revenue, $length = 400, $dots = true);
                                            $later_length = strlen(trim($this->Eluminati->text_cut($revenue, $length = 400, $dots = true)));
                                            ?></b></strong></a></em></i></div>
                                        <div class=" person-content full-data hide"  data-to="1"> <?php echo $revenue; ?></div>
                                        <?php if ($actual_lenth != $later_length) { ?>
                                            <a href="#1" class="right btn-readmorestuffKid">Read more</a>
                                        <?php } ?><?php } else {
                                        ?>
                                        <div class=" person-content short-data m-b-10"><?php echo $this->Eluminati->text_cut($revenue, $length = 400, $dots = true); ?>
                                        </div>
                                    <?php } ?>

                                </div>


                                <div class="profile-block clearfix">
                                    <h4>Donated</h4>


                                    <?php

                                    $donated = $business_info['KidBusinessProfile']['donated'];
                                    $donated = preg_replace('/<!--(.|\s)*?-->/', '', $donated);
                                    if (strlen($donated) > 400) {
                                        ?>
                                        <div class=" person-content short-data m-b-10"><?php
                                            // echo substr($post['Escene']['post_description'], $remaining-1 );
                                            $actual_lenth = strlen(trim($donated));
                                            echo $this->Eluminati->text_cut($donated, $length = 400, $dots = true);
                                            $later_length = strlen(trim($this->Eluminati->text_cut($donated, $length = 400, $dots = true)));
                                            ?></b></strong></a></em></i></div>
                                        <div class=" person-content full-data hide"  data-to="1"> <?php echo $donated; ?></div>
                                        <?php if ($actual_lenth != $later_length) { ?>
                                            <a href="#1" class="right btn-readmorestuffKid">Read more</a>
                                        <?php } ?><?php } else {
                                        ?>
                                        <div class=" person-content short-data m-b-10"><?php echo $this->Eluminati->text_cut($donated, $length = 400, $dots = true); ?>
                                        </div>
                                    <?php } ?>



                                </div>

                                <div class="profile-block clearfix">
                                    <?php
                                    $class_disable = '';
                                    $business_profile_count = $this->Kidpreneur->businessProfileCount($business_info['KidBusinessProfile']['user_id']);
                                    if($business_profile_count>=3)
                                    {
                                        $class_disable = 'disabled';
                                    }

                                    ?>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

            <div class="kd-buisness_footer border-0 p-r-0">
                <?php if ($business_info['KidBusinessProfile']['user_id'] == $this->Session->read('user_id')){?>
                    <a style="width: 200px" href="" class="btn filled-btn  kid-new-theme-btn kid_business_profile_flyin pull-right <?php echo $class_disable; ?>" data-toggle="modal" data-id="<?php echo $business_info['KidBusinessProfile']['user_id'] ?>" data-action="Add" data-event="Business">Add A New business</a>

                    <a style="width: 150px !important;" href="" class="border-radius-20 btn wht-filled-btn pull-right delete_business_flyin m-l-10" data-toggle="modal" data-id="<?php echo $business_info['KidBusinessProfile']['id'] ?>" data-action="Delete" data-event="Business">Delete</a>
                <?php } ?>
            </div>


        </div>


        <div id="dashkidGallery" class="tab-pane">

            <div class="sage-advice-data">
                <div class="kd-account_sidebar">
                    <div class="">
                        <div class="kd-account_social_wrap kd-account_wrapper custom_scroll containerHeight p-15" id="container3">
                            <div class="row" style="padding-top: 5px;">
                                <div class="col-md-8">
                                    <div class="profile-block m-t-0">
                                        <h4 >Product Features and Benefits</h4>

                                        <?php

                                        $feature_benefit = $business_info['KidBusinessProfile']['feature_benefit'];
                                        $feature_benefit = preg_replace('/<!--(.|\s)*?-->/', '', $feature_benefit);
                                        if (strlen($feature_benefit) > 400) {
                                            ?>
                                            <div class=" person-content short-data m-b-10"><?php
                                                // echo substr($post['Escene']['post_description'], $remaining-1 );  
                                                $actual_lenth = strlen(trim($feature_benefit));
                                                echo $this->Eluminati->text_cut($feature_benefit, $length = 400, $dots = true);
                                                $later_length = strlen(trim($this->Eluminati->text_cut($feature_benefit, $length = 400, $dots = true)));
                                                ?></b></strong></a></em></i></div>
                                            <div class=" person-content full-data hide"  data-to="1"> <?php echo $feature_benefit; ?></div>
                                            <?php if ($actual_lenth != $later_length) { ?>
                                                <a href="#1" class="right btn-readmorestuffKid">Read more</a>
                                            <?php } ?><?php } else {
                                            ?>
                                            <div class=" person-content short-data m-b-10"><?php echo $this->Eluminati->text_cut($feature_benefit, $length = 400, $dots = true); ?>
                                            </div>
                                        <?php } ?>
                                    </div>


                                    <h4 class="m-b-10 m-t-20">Website</h4>
                                    <div class="form-group">
                                        <div class="col-sm-12 profile-web " style="padding: 0">
                                            <a href="<?php echo $business_info['KidBusinessProfile']['business_website'];?>" target="_blank"><?php echo $business_info['KidBusinessProfile']['business_website'];?></a>
                                        </div>
                                    </div>

                                </div>


                                <div class="col-md-4" style="padding-left: 0">
                                    <div class="kd-img-gallery kd-gallery">
                                        <div class="kd-box" style="margin-top:0px;">

                                            <?php if(@$business_info['KidBusinessProfile']['logo_image']){
                                                ?>


                                                <label for="logo_image_upload"> <div class="img-section row-wrap">
                                                        <img src="<?php echo $this->Html->url('/', true) .@$business_info['KidBusinessProfile']['logo_image']; ?>">

                                                        <input type="hidden" name="data[KidBusinessProfile][logo_image]" value="<?php echo @$business_info['KidBusinessProfile']['logo_image']?>"></div></label>
                                            <?php }else{?>
                                                <label for="logo_image_upload">LOGO<input type ='hidden' name ="data[KidBusinessProfile][logo_image]" value=""> </label>
                                            <?php }  ?>

                                            <!--   <img src="<?php echo $this->Html->url('/', true) .$business_info['KidBusinessProfile']['logo_image']; ?>" alt=""> -->
                                        </div>
                                    </div>
                                </div>
                            </div>




                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="m-t-10 m-b-10">Product Gallery</h4>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 kd-mg-rgt">

                                    <?php echo $this->element('product_gallery_element', array('gallery'=> $business_info['KidProductGallery'][0],'action'=>'View')); ?>


                                </div>
                                <div class="col-md-4 mid_col">
                                    <?php echo $this->element('product_gallery_element', array('gallery'=> $business_info['KidProductGallery'][1],'action'=>'View')); ?>
                                </div>
                                <div class="col-md-4 kd-mg-lft">
                                    <?php echo $this->element('product_gallery_element', array('gallery'=> $business_info['KidProductGallery'][2],'action'=>'View')); ?>
                                </div>
                            </div>

                            <div class="row kd-img-top">
                                <div class="col-md-4 kd-mg-rgt">
                                    <?php echo $this->element('product_gallery_element', array('gallery'=> $business_info['KidProductGallery'][3],'action'=>'View')); ?>
                                </div>
                                <div class="col-md-4 mid_col">
                                    <?php echo $this->element('product_gallery_element', array('gallery'=> $business_info['KidProductGallery'][4],'action'=>'View')); ?>
                                </div>
                                <div class="col-md-4 kd-mg-lft">
                                    <?php echo $this->element('product_gallery_element', array('gallery'=> $business_info['KidProductGallery'][5],'action'=>'View')); ?>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <h4 class="m-t-10 m-b-10">Pitch Video</h4>
                                </div>

                                <div class="col-md-12">
                                    <div class="video kd-video">



                                        <?php if($business_info['KidBusinessProfile']['pitch_video_id']!='')
                                        {
                                            $videoId=explode("v=",$business_info['KidBusinessProfile']['pitch_video_id']);
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
                                    <h4 class="m-t-10 m-b-10">Other Pics</h4>
                                </div>

                                <div class="col-md-4 kd-mg-rgt">
                                    <?php echo $this->element('product_gallery_element', array('gallery'=> $business_info['KidProductGallery'][6],'action'=>'View')); ?>
                                </div>
                                <div class="col-md-4 mid_col">
                                    <?php echo $this->element('product_gallery_element', array('gallery'=> $business_info['KidProductGallery'][7],'action'=>'View')); ?>
                                </div>
                                <div class="col-md-4 kd-mg-lft">
                                    <?php echo $this->element('product_gallery_element', array('gallery'=> $business_info['KidProductGallery'][8],'action'=>'View')); ?>
                                </div>
                            </div>
                            <div class="row kd-img-top">
                                <div class="col-md-4 kd-mg-rgt">
                                    <?php echo $this->element('product_gallery_element', array('gallery'=> $business_info['KidProductGallery'][9],'action'=>'View')); ?>
                                </div>
                                <div class="col-md-4 mid_col">
                                    <?php echo $this->element('product_gallery_element', array('gallery'=> $business_info['KidProductGallery'][10],'action'=>'View')); ?>
                                </div>
                                <div class="col-md-4 kd-mg-lft">
                                    <?php echo $this->element('product_gallery_element', array('gallery'=> $business_info['KidProductGallery'][5],'action'=>'View')); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>



            </div>
        </div>

        <div id="" class="tab-pane">
            <div class="row">
                <div class="col-md-12">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aspernatur at atque debitis et explicabo, incidunt libero nemo neque quia rerum totam veniam. Deserunt distinctio doloremque magni minima minus officia similique?</p>

                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad adipisci architecto asperiores atque cum doloremque, eius eos esse facere fuga itaque laborum nemo nostrum officia perspiciatis possimus temporibus voluptates. Ipsam!</p>

                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    // var addmodalstudentscroll = '.kd-account_wrapper';
    // containerHeightTemp(addmodalstudentscroll)
    // //rightFlyoutContainerHeightTemp();
    // customScroll();
    // function containerHeightTemp(selector) {
    //     alert('fds')
    //     setTimeout(function () {
    //         var totalHeight = $('.modal-content:visible').outerHeight(true),
    //             bufferH = 16,
    //             profileDetailsH = $('.top-section:visible').outerHeight(true)
    //                 + $('.modal-footer:visible').outerHeight(true)
    //                 + parseInt($('.modal-dialog:visible').css('margin-top'));
    //
    //
    //         var calculatedHeight = totalHeight - (profileDetailsH) - bufferH;
    //         console.log(calculatedHeight+'@@');
    //
    //         $(selector+":visible").css('height', calculatedHeight+'px');
    //     }, 200);
    // }
    //# sourceURL=busineess_add_modal_element.ctpjs



    //# sourceURL=busineess_view_modal_element.ctpjs
</script>