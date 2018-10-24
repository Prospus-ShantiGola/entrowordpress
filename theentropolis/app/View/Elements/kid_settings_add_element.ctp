
<div class="full-switch-viewwrapper ">
                            <div class="col-md-5 kd-custom_width_panel" style="padding-left: 0px;">
                                <div class="kd-account_info_wrap" style="margin-top: 0px;">
                                    <div class="kd-title_box">
                                        <h3 class="kd-dash_titles" style="flex:1 100px;">BUSINESS PROFILE</h3>
                                        <div class="arrow-kd <?php //pr($kid_info);
                                        $profile_count = $this->Kidpreneur->businessProfileCount($kid_info['User']['id']);
                                        echo ($profile_count>1)? "" : "hide";?>">
                                            <?php echo $this->Html->image('svg-icons/arrow-left-right1.svg',array('onClick'=>'flipProfile(".bussinessprofile-'.$businessKey.'",'.$businessKey.','.(count($kid_info['KidBusinessProfile'])-1).');')); ?>
                                            <?php //pr();?>
                                        </div>
                                    </div>
                                    <div class="kd-account_wrapper kd-white-bg custom_scroll view_setting_scroll ">
                                        <div class="">
                                            <div id="dashProfile" class="tab-pane active" style="padding-top: 15px;">
                                                <div class="row ">
                                                    <div class="col-md-12 ">
                                                        <div class="profile_detail relative">
                                                            <div class="profile-img-blck  profile_img kid">
                                                                <div class="row">
                                                                    <div class="col-md-3 p-r-0 text-center" id = "hidden_product">
                                                                        <input type="file" name="fileToUploadAdd[]" id="product_image_upload" class="atch-new  galleryimg_upload" data-multiple-caption="{count} files selected"  data-url="<?php echo Router::url(array('controller' => 'attachments', 'action' => 'kid_upload')); ?>" data-actual = "product_image">
                                                                            
                                                                        <label for="product_image_upload" > <?php echo $this->Html->image('dummy-pic.png'); ?> <input type ='hidden' name ="data[KidBusinessProfile][product_image]" value=""></label>
                                                                        <?php if($profile_count>0) {?>
                                                                        <button type="button" class="btn blue_filled <?php echo (count($kid_info['KidBusinessProfile'])==MAX_BUSINESS_PROFILE)? " hide ":"" ?>" style="margin: 10px auto; font-size: 11px; width: 100%;" onclick="cancelAddNewBusiness()">Cancel</button>
                                                                        <?php }?>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <div class="profile-block">
                                                                            <h4>Business Name</h4>
                                                                            <div class="form-group">
                                                                                <?php //echo htmlentities($value);?>

                                                                                <div class="col-sm-9">
                                                                                    <input type="hidden" value="save" name="data_event" />
                                                                                    <input name="data[KidBusinessProfile][business_name]" id="business_name" class="form-control" placeholder="Business Name" maxlength="100" type="text"  data-original-title="" title="" value = "">
                                                                                    <input   type="hidden" id = "username_logged"  value = "<?php echo htmlentities(@$studentinfo['User']['username']) ?>">
                                                                                    <?php $profile_count = $this->Kidpreneur->businessProfileCount($studentinfo['User']['id']); ?>
                                                                                    <input type="hidden" id = "total_count_business"  value = "<?php echo $profile_count; ?>">
                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                        <div class="profile-block">
                                                                            <h4>Founded</h4>
                                                                            <div class="form-group">
                                                                                <div class="col-sm-9">
                                                                                    <select name="data[KidBusinessProfile][founded_year]" class="form-control" id="foundedyear" data-original-title="" title="">
                                                                                        <option value="">Founded</option>
                                                                                        <?php for ($y = '1990'; $y < 2019; $y++) { ?>
                                                                                            <option value="<?php echo $y; ?>"><?php echo $y; ?></option>
        <?php } ?>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="profile-block">
                                                                            <h4>Start-up $$</h4>
                                                                            <div class="form-group">
                                                                                <div class="col-sm-9">
                                                                                    <input name="data[KidBusinessProfile][start_up]" id="start_up" class="form-control clear-title" placeholder="" maxlength="10" type="text"  data-original-title="" title="" required="required" data-original-title="" title="" value = "">
                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                        <div class="profile-block" style="margin: 10px 0px 0px 0px;">
                                                                            <h4 class="kd-addup-field">FOUNDERS / BUSINESS OWNERS</h4>
                                                                            <div class="form-group">
                                                                                <div class="col-sm-12">
                                                                                    
                                                                    
                                                                        <input name="data[KidBusinessOwner][business_owner][]"  class="form-control clear-title business_owner"  maxlength="100" type="text" value="" id="business_owner">                                                      <input name="data[KidBusinessOwner][kid_business_owner_id][]"  class="form-control clear-title kid_business_owner_id"  type="hidden" value="">
                                                                        <?php 
                                                                        ///echo '<a class="kid_addup"><i class="fa fa-minus-circle removeButton" id="removeButton" onclick="removeElem()"></i></a>';
                                                                        ?>
                                                                    
                                                                    
                                                                                <div id='TextBoxesGroup' class="">
                                                            </div>    
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-11" id="iconclass" style="margin-top: -15px;margin-left: 15px; padding: 0px;">
                                                                            <a class="st-addup"><i class="fa fa-plus-circle addButton" id='addButton'></i></a>

                                                                        </div>
                                                                        <div class="profile-block">
                                                                            <h4>About my business</h4>
                                                                            <div class="form-group">
                                                                                <div class="col-sm-12">
                                                                                    <textarea rows="2" name="data[KidBusinessProfile][about_business]" id="about_business"  required="required" class="form-control kd-form-style" maxlength="1000" placeholder=""></textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="profile-block">
                                                                            <h4>Mission</h4>
                                                                            <div class="form-group">
                                                                                <div class="col-sm-12">
                                                                                    <textarea rows="1" name="data[KidBusinessProfile][mission]" id = "mission" required="required" class="form-control kd-form-style" maxlength="1000" placeholder=""></textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="profile-block">
                                                                            <h4>vision and Goals</h4>
                                                                            <div class="form-group">
                                                                                <div class="col-sm-12">
                                                                                    <textarea rows="5" name="data[KidBusinessProfile][vision_goal]" id="vision_goal" required="required" class="form-control kd-form-style" maxlength="1000" placeholder=""></textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="profile-block">
                                                                            <h4>Revenue</h4>
                                                                            <div class="form-group">
                                                                                <div class="col-sm-12">
                                                                                    <textarea name="data[KidBusinessProfile][revenue]" id="revenue"  required="required" class="form-control kd-form-style" maxlength="1000" placeholder=""></textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="profile-block">
                                                                            <h4>Donated</h4>
                                                                            <div class="form-group">
                                                                                <div class="col-sm-12">
                                                                                    <textarea name="data[KidBusinessProfile][donated]" id="donated"   required="required" class="form-control kd-form-style" maxlength="1000" placeholder=""></textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
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
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <!-- end of tab-content -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 kd-custom_width_sidebar_panel" style="padding:0;">
                                <div class="kd-account_sidebar">
                                    <div class="kd-title_box">
                                        <h3 class="kd-dash_titles"> MY BUSINESS PROFILE</h3>
                                    </div>
                                    <div class="">
                                        <div class="kd-account_social_wrap kd-white-bg  custom_scroll view_setting_scroll ">
                                            <div class="row" style="padding-top: 15px;">
                                                <div class="col-md-12">
                                                    <h4 style="width: 75%;" class="kd-top-none">Product Features and Benefits</h4>
                                                </div>
                                                <div class="col-md-8">
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                          <textarea name="data[KidBusinessProfile][feature_benefit]" id="feature_benefit" required="required" class="form-control kd-form-style kd-txt-hgt" maxlength="1000" placeholder=""></textarea>
                                                        </div>
                                                    </div>
                                                    <h4>Website</h4>
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                             <input name="data[KidBusinessProfile][business_website]" id="business_website" class="form-control clear-title" placeholder="" maxlength="500" type="text" required="required" data-original-title="" title="" value="">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4" style="padding-left: 0">
                                                    <div class="kd-img-gallery kd-gallery" id = "hidden_logo">
                                                        <div class="kd-box" style="margin-top:0px;">
                                                            <input type="file" name="fileToUploadAdd[]" id="logo_image_upload" class="atch-new galleryimg_upload" data-multiple-caption="{count} files selected" data-url="<?php echo Router::url(array('controller' => 'attachments', 'action' => 'kid_upload')); ?>" data-actual = "logo_image">
                                                           <label for="logo_image_upload">LOGO<input type ='hidden' name ="data[KidBusinessProfile][logo_image]" value=""></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h4>Product Gallery</h4>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 kd-mg-rgt">
                                                    <div class="kd-img-gallery kd-gallery">
                                                        <div class="kd-box">
                                                            <input type="file" name="fileToUploadAdd[]" id="product_gallery_upload" class="atch-new galleryimg_upload " data-multiple-caption="{count} files selected"  data-url="<?php echo Router::url(array('controller' => 'attachments', 'action' => 'kid_upload')); ?>" data-actual = "[product_gallery][]" data-type ="product_gallery">
                                                           <label for="product_gallery_upload"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?><input type ='hidden' class="gallery_required" value=""></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mid_col">
                                                    <div class="kd-img-gallery kd-gallery">
                                                        <div class="kd-box">
                                                             <input type="file" name="fileToUploadAdd[]" id="product_gallery_upload_1" class="atch-new galleryimg_upload " data-multiple-caption="{count} files selected"  data-url="<?php echo Router::url(array('controller' => 'attachments', 'action' => 'kid_upload')); ?>" data-actual = "[product_gallery][1]" data-type ="product_gallery">
                                                            <label for="product_gallery_upload_1"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?><input type ='hidden' class="gallery_required" value=""></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 kd-mg-lft">
                                                    <div class="kd-img-gallery kd-gallery">
                                                        <div class="kd-box">
                                                            <input type="file" name="fileToUploadAdd[]" id="product_gallery_upload_2" class="atch-new galleryimg_upload " data-multiple-caption="{count} files selected"  data-url="<?php echo Router::url(array('controller' => 'attachments', 'action' => 'kid_upload')); ?>" data-actual = "[product_gallery][2]" data-type ="product_gallery">
                                                            <label for="product_gallery_upload_2"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?><input type ='hidden' class="gallery_required" value=""></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row kd-img-top">
                                                <div class="col-md-4 kd-mg-rgt">
                                                    <div class="kd-img-gallery kd-gallery required-product-gallery">
                                                        <div class="kd-box">
                                                            <input type="file" name="fileToUploadAdd[]" id="product_gallery_upload_3" class="atch-new galleryimg_upload " data-multiple-caption="{count} files selected"  data-url="<?php echo Router::url(array('controller' => 'attachments', 'action' => 'kid_upload')); ?>" data-actual = "[product_gallery][3]" data-type ="product_gallery">
                                                           <label for="product_gallery_upload_3"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?><input type ='hidden' class="gallery_required" value=""></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mid_col">
                                                    <div class="kd-img-gallery kd-gallery">
                                                        <div class="kd-box">
                                                            <input type="file" name="fileToUploadAdd[]" id="product_gallery_upload_4" class="atch-new galleryimg_upload " data-multiple-caption="{count} files selected"  data-url="<?php echo Router::url(array('controller' => 'attachments', 'action' => 'kid_upload')); ?>" data-actual = "[product_gallery][4]" data-type ="product_gallery" >
                                                             <label for="product_gallery_upload_4"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?><input type ='hidden' class="gallery_required" value=""></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 kd-mg-lft">
                                                    <div class="kd-img-gallery kd-gallery">
                                                        <div class="kd-box">
                                                            <input type="file" name="fileToUploadAdd[]" id="product_gallery_upload_5" class="atch-new galleryimg_upload " data-multiple-caption="{count} files selected"  data-url="<?php echo Router::url(array('controller' => 'attachments', 'action' => 'kid_upload')); ?>" data-actual = "[product_gallery][5]" data-type ="product_gallery">
                                                             <label for="product_gallery_upload_5"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?><input type ='hidden' class="gallery_required" value=""></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row pitch_video_scetion">
                                                <div class="col-md-12">
                                                    <h4 style="margin-top: 15px;">Pitch Video</h4>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="video kd-video">
                                                        <input  id="fileToUploadAdd" class="atch-new galleryimg_upload" data-file="businessprofilevideo">
                                                          <input type="hidden" value="" name="data[KidBusinessProfile][pitch_video_id]" id="businessprofilevideo">
                                                           <label for="fileToUploadAdd" class ="pending_approval"><?php echo $this->Html->image('wq4.svg',array('class'=>'kd-img-upload')); ?></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h4 style="margin-top: 15px;">Other Pics</h4>
                                                </div>
                                                <div class="col-md-4 kd-mg-rgt">
                                                    <div class="kd-img-gallery kd-gallery">
                                                        <div class="kd-box">
                                                             <input type="file" name="fileToUploadAdd[]" id="other_gallery_upload" class="atch-new galleryimg_upload" data-multiple-caption="{count} files selected"  data-url="<?php echo Router::url(array('controller' => 'attachments', 'action' => 'kid_upload')); ?>" data-actual = "[other_gallery][]" data-type ="other_gallery">
                                                            <label for="other_gallery_upload"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mid_col">
                                                    <div class="kd-img-gallery kd-gallery">
                                                        <div class="kd-box">
                                                            <input type="file" name="fileToUploadAdd[]" id="other_gallery_upload_1" class="atch-new galleryimg_upload" data-multiple-caption="{count} files selected"  data-url="<?php echo Router::url(array('controller' => 'attachments', 'action' => 'kid_upload')); ?>" data-actual = "[other_gallery][1]" data-type ="other_gallery">
                                                             <label for="other_gallery_upload_1"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 kd-mg-lft">
                                                    <div class="kd-img-gallery kd-gallery">
                                                        <div class="kd-box">
                                                             <input type="file" name="fileToUploadAdd[]" id="other_gallery_upload_2" class="atch-new galleryimg_upload" data-multiple-caption="{count} files selected"  data-url="<?php echo Router::url(array('controller' => 'attachments', 'action' => 'kid_upload')); ?>" data-actual = "[other_gallery][2]" data-type ="other_gallery">
                                                            <label for="other_gallery_upload_2"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row kd-img-top ">
                                                <div class="col-md-4 kd-mg-rgt">
                                                    <div class="kd-img-gallery kd-gallery">
                                                        <div class="kd-box">
                                                            <input type="file" name="fileToUploadAdd[]" id="other_gallery_upload_3" class="atch-new galleryimg_upload" data-multiple-caption="{count} files selected"  data-url="<?php echo Router::url(array('controller' => 'attachments', 'action' => 'kid_upload')); ?>" data-actual = "[other_gallery][3]" data-type ="other_gallery">
                                                           <label for="other_gallery_upload_3"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mid_col">
                                                    <div class="kd-img-gallery kd-gallery">
                                                        <div class="kd-box">
                                                            <input type="file" name="fileToUploadAdd[]" id="other_gallery_upload_4" class="atch-new galleryimg_upload" data-multiple-caption="{count} files selected"  data-url="<?php echo Router::url(array('controller' => 'attachments', 'action' => 'kid_upload')); ?>" data-actual = "[other_gallery][4]" data-type ="other_gallery">
                                                            <label for="other_gallery_upload_4"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 kd-mg-lft">
                                                    <div class="kd-img-gallery kd-gallery">
                                                        <div class="kd-box">
                                                            <input type="file" name="fileToUploadAdd[]" id="other_gallery_upload_5" class="atch-new galleryimg_upload" data-multiple-caption="{count} files selected"  data-url="<?php echo Router::url(array('controller' => 'attachments', 'action' => 'kid_upload')); ?>" data-actual = "[other_gallery][5]" data-type ="other_gallery">
                                                            <label for="other_gallery_upload_5"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>