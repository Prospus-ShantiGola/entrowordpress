<?php //pr($kid_info['KidBusinessProfile'][$businessKey]['status']);?>
<input type="hidden" value="<?php echo strtolower($kid_info['KidBusinessProfile'][$businessKey]['status']);?>" id="profile-status"/>
<div class="full-switch-viewwrapper ">
                            <div class="col-md-5 kd-custom_width_panel" style="padding-left: 0px;">
                                <div class="kd-account_info_wrap" style="margin-top: 0px;">
                                    <div class="kd-title_box">
                                        <h3 class="kd-dash_titles" style="flex:1 100px;">BUSINESS PROFILE</h3>
                                        <div class="arrow-kd <?php //pr($kid_info);
                                        echo (count($kid_info['KidBusinessProfile'])>1)? "" : "hide";?>">
                                            <?php echo $this->Html->image('svg-icons/arrow-left-right1.svg',array('onClick'=>'flipProfile(".bussinessprofile-'.$businessKey.'",'.$businessKey.','.(count($kid_info['KidBusinessProfile'])-1).');')); ?>
                                            <?php //pr();?>
                                        </div>
                                    </div>
                                    <div class="kd-account_wrapper kd-white-bg custom_scroll view_setting_scroll">
                                        <div class="">
                                            <div id="dashProfile" class="tab-pane active" style="padding-top: 15px;">
                                                <div class="row ">
                                                    <div class="col-md-12 ">
                                                        <div class="profile_detail relative">
                                                            <div class="profile-img-blck  profile_img kid">
                                                                <div class="row">
                                                                    <div class="col-md-3 p-r-0 text-center" id = "hidden_product">
                                                                        <input type="file" name="fileToUploadAdd[]" id="product_image_upload" class="atch-new  galleryimg_upload" data-multiple-caption="{count} files selected"  data-url="<?php echo Router::url(array('controller' => 'attachments', 'action' => 'kid_upload')); ?>" data-actual = "product_image">
                                                                        <label for="product_image_upload"> <div class="img-section row-wrap"><img src="<?php echo $this->Html->url('/', true) .@$kid_info['KidBusinessProfile'][$businessKey]['product_image']; ?>"><input type="hidden" name="data[KidBusinessProfile][product_image]" value="<?php echo @$kid_info['KidBusinessProfile'][$businessKey]['product_image']?>"></div></label>
                                                                        <p class="text-center profile-web" style="margin: 10px 0;font-size: 0.8em;"><a target="_blank" href="<?php echo $kid_info['KidBusinessProfile'][$businessKey]['business_website'];?>"><?php echo @$kid_info['KidBusinessProfile'][$businessKey]['business_website'] ?></a></p>
                                                                       
                                                                        
                                                                        <button type="button" class="btn blue_filled btnipad<?php echo (count($kid_info['KidBusinessProfile'])==MAX_BUSINESS_PROFILE)? " hide ":"" ?>" style="margin: 10px auto; font-size: 11px;" onclick="addNewBusiness();">ADD BUSINESS</button>
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <div class="profile-block m-t-0">
                                                                            <h4>Business Name</h4>
                                                                            <div class="form-group">
                                                                                <?php //echo htmlentities($value);?>

                                                                                <div class="col-sm-9">
                                                                                    <input type="hidden" value="<?php echo htmlentities(@$kid_info['KidBusinessProfile'][$businessKey]['id']) ?>" name="data_id" />
                                                                                    <input type="hidden" value="save" name="data_event" />
                                                                                    <input name="data[KidBusinessProfile][business_name]" id="business_name" class="form-control" placeholder="Business Name" maxlength="100" type="text"  data-original-title="" title="" value = "<?php echo htmlentities(@$kid_info['KidBusinessProfile'][$businessKey]['business_name']) ?>">
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
                                                                                            <option value="<?php echo $y; ?>" <?php if (@$kid_info['KidBusinessProfile'][$businessKey]['founded_year'] == $y) {
                                                                                    echo "selected='selected'";
                                                                                } ?>><?php echo $y; ?></option>
        <?php } ?>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="profile-block">
                                                                            <h4>Start-up $$</h4>
                                                                            <div class="form-group">
                                                                                <div class="col-sm-9">
                                                                                    <input name="data[KidBusinessProfile][start_up]" id="start_up" class="form-control clear-title" placeholder="Start-up" maxlength="500" type="text" required="required" data-original-title="" title="" value = "<?php echo @$kid_info['KidBusinessProfile'][$businessKey]['start_up'] ?>">
                                                                                </div>

                                                                            </div>
                                                                        </div>
                                                                        <div class="profile-block" style="margin: 10px 0px 0px 0px;">
                                                                            <h4 class="kd-addup-field">FOUNDERS / BUSINESS OWNERS</h4>
                                                                            <div class="form-group">
                                                                                <div class="col-sm-12">
                                                                                    <?php $i = 0;
                                                                                    $business_owners=$this->KidBusinessOwner->getKidBusinessOwnerById($kid_info['KidBusinessProfile'][$businessKey]['id']);
                                                                                    pr($business_owners);
                                                                                    $addClass="";
                                                                                    if(count($business_owners)>0){
                                                                foreach (@$business_owners as $business_owner) {?>
                                                                    <div id = "TextBoxDiv<?php echo $i;?>">
                                                                        <input name="data[KidBusinessOwner][business_owner][<?php echo $i;?>]"  class="form-control clear-title business_owner"  maxlength="100" type="text" value="<?php echo htmlentities($business_owner['KidBusinessOwner']['business_owner']);?>" id="business_owner">                                                      <input name="data[KidBusinessOwner][kid_business_owner_id][<?php echo $i;?>]"  class="form-control clear-title kid_business_owner_id"  type="hidden" value="<?php echo $business_owner['KidBusinessOwner']['id'];?>">
                                                                        <?php if($i>0){
                                                                            // $addClass="mar-icon";
                                                                        echo '<a class="set_addup"><i class="fa fa-minus-circle removeButton" id="removeButton" onclick="removeElem('.($i).')"></i></a>';
                                                                    }?>
                                                                    </div>
                                                                    <?php $i++; }
                                                                                    }else{?>
                                                                                    <div id = "TextBoxDiv1">
                                                                        <input name="data[KidBusinessOwner][business_owner][]"  class="form-control clear-title business_owner"  maxlength="100" type="text" value="" id="business_owner">                                                      <input name="data[KidBusinessOwner][kid_business_owner_id][]"  class="form-control clear-title kid_business_owner_id"  type="hidden" value="">
                                                                        <?php 
                                                                        echo '<a class="set_addup"><i class="fa fa-minus-circle removeButton" id="removeButton" onclick="removeElem()"></i></a>';
                                                                        ?>
                                                                    </div>
                                                                                    <?php }?>
                                                                                    <div id='TextBoxesGroup' class="">
                                                            </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-sm-11 <?php echo $addClass;?>" id="iconclass" style="margin-top: -15px;margin-left: 10px;padding: 0;">
                                                                            <a class="st-addup"><i class="fa fa-plus-circle addButton" id='addButton'></i></a>

                                                                        </div>
                                                                        <div class="profile-block">
                                                                            <h4>About my business</h4>
                                                                            <div class="form-group">
                                                                                <div class="col-sm-12">
                                                                                    <textarea rows="2" name="data[KidBusinessProfile][about_business]" id="about_business"  required="required" class="form-control kd-form-style" maxlength="1000" placeholder=""><?php echo @$kid_info['KidBusinessProfile'][$businessKey]['about_business'] ?></textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="profile-block">
                                                                            <h4>Mission</h4>
                                                                            <div class="form-group">
                                                                                <div class="col-sm-12">
                                                                                    <textarea rows="1" name="data[KidBusinessProfile][mission]" id = "mission" required="required" class="form-control kd-form-style" maxlength="1000" placeholder=""><?php echo @$kid_info['KidBusinessProfile'][$businessKey]['mission'] ?></textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="profile-block">
                                                                            <h4>vision and Goals</h4>
                                                                            <div class="form-group">
                                                                                <div class="col-sm-12">
                                                                                    <textarea rows="5" name="data[KidBusinessProfile][vision_goal]" id="vision_goal" required="required" class="form-control kd-form-style" maxlength="1000" placeholder=""><?php echo @$kid_info['KidBusinessProfile'][$businessKey]['vision_goal'] ?></textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="profile-block">
                                                                            <h4>Revenue</h4>
                                                                            <div class="form-group">
                                                                                <div class="col-sm-12">
                                                                                    <textarea name="data[KidBusinessProfile][revenue]" id="revenue"  required="required" class="form-control kd-form-style" maxlength="1000" placeholder=""><?php echo @$kid_info['KidBusinessProfile'][$businessKey]['revenue'] ?></textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="profile-block">
                                                                            <h4>Donated</h4>
                                                                            <div class="form-group">
                                                                                <div class="col-sm-12">
                                                                                    <textarea name="data[KidBusinessProfile][donated]" id="donated"   required="required" class="form-control kd-form-style" maxlength="1000" placeholder=""><?php echo @$kid_info['KidBusinessProfile'][$businessKey]['donated'] ?></textarea>
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
                                                            <textarea name="data[KidBusinessProfile][feature_benefit]" id="feature_benefit" required="required" class="form-control kd-form-style kd-txt-hgt" maxlength="1000" placeholder=""><?php echo @$kid_info['KidBusinessProfile'][$businessKey]['feature_benefit'] ?></textarea>
                                                        </div>
                                                    </div>
                                                    <h4>Website</h4>
                                                    <div class="form-group">
                                                        <div class="col-sm-12">
                                                            <input name="data[KidBusinessProfile][business_website]" id="business_website" class="form-control clear-title" placeholder="" maxlength="500" type="text" required="required" data-original-title="" title="" value="<?php echo @$kid_info['KidBusinessProfile'][$businessKey]['business_website'] ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4" style="padding-left: 0">
                                                    <div class="kd-img-gallery kd-gallery " id = "hidden_logo">
                                                        <div class="kd-box" style="margin-top:0px;">
                                                            <input type="file" name="fileToUploadAdd[]" id="logo_image_upload" class="atch-new galleryimg_upload" data-multiple-caption="{count} files selected" data-url="<?php echo Router::url(array('controller' => 'attachments', 'action' => 'kid_upload')); ?>" data-actual = "logo_image">
                                                            <?php if($action =='Add'){ ?>

                                                    <label for="logo_image_upload">LOGO<input type ='hidden' name ="data[KidBusinessProfile][logo_image]" value=""></label>
                                                <?php }else{

                                        if(@$kid_info['KidBusinessProfile'][$businessKey]['logo_image']){
                                                        ?>


                                                      <label for="logo_image_upload"> <div class="img-section row-wrap">
                                                        <img src="<?php echo $this->Html->url('/', true) .@$kid_info['KidBusinessProfile'][$businessKey]['logo_image']; ?>">

                                                        <input type="hidden" name="data[KidBusinessProfile][logo_image]" value="<?php echo @$kid_info['KidBusinessProfile'][$businessKey]['logo_image']?>"></div></label>
                                                    <?php }else{?>
                                                        <label for="logo_image_upload"><input type ='hidden' name ="data[KidBusinessProfile][logo_image]" value=""><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?></label>
                                                    <?php } } ?>
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

                                                <?php if($action =='Add'){ ?>

                                                    <label for="product_gallery_upload"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?><input type ='hidden' class="gallery_required" value=""></label>
                                                <?php }else{
                                                    $this->KidProductGallery->recursive= 1;
                                                     $business_images=$this->KidProductGallery->getKidProductGalleryById($kid_info['KidBusinessProfile'][$businessKey]['id']);
                                                     //debug($business_images);
                                                     //die;
                                                     
                                                    if(@$business_images[0]['KidProductGallery']['gallery_image_path']){
                                                        ?>


                                                        <label for="product_gallery_upload"> <div class="img-section row-wrap"><img src="<?php echo $this->Html->url('/', true) .@$business_images[0]['KidProductGallery']['gallery_image_path']; ?>"><input type="hidden" name="data[KidProductGallery][product_gallery][]" value="<?php echo @$business_images[0]['KidProductGallery']['gallery_image_path']?>"></div></label>
                                                    <?php }else{?>

                                                        <label for="product_gallery_upload"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?><input type ='hidden' class="gallery_required" value=""></label>
                                                    <?php   } } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mid_col">
                                                    <div class="kd-img-gallery kd-gallery">
                                                        <div class="kd-box">
                                                             <input type="file" name="fileToUploadAdd[]" id="product_gallery_upload_1" class="atch-new galleryimg_upload " data-multiple-caption="{count} files selected"  data-url="<?php echo Router::url(array('controller' => 'attachments', 'action' => 'kid_upload')); ?>" data-actual = "[product_gallery][1]" data-type ="product_gallery">


                                                <?php if($action =='Add'){ ?>

                                                    <label for="product_gallery_upload_1"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?><input type ='hidden' class="gallery_required" value=""></label>
                                                <?php }else{

                                                    if(@$business_images[1]['KidProductGallery']['gallery_image_path']){
                                                        ?>


                                                        <label for="product_gallery_upload_1"> <div class="img-section row-wrap"><img src="<?php echo $this->Html->url('/', true) .@$business_images[1]['KidProductGallery']['gallery_image_path']; ?>"><input type="hidden" name="data[KidProductGallery][product_gallery][1]" value="<?php echo @$business_images[1]['KidProductGallery']['gallery_image_path']?>"></div></label>
                                                    <?php }else{?>
                                                        <label for="product_gallery_upload_1"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?><input type ='hidden' class="gallery_required" value=""></label>
                                                    <?php } } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 kd-mg-lft">
                                                    <div class="kd-img-gallery kd-gallery">
                                                        <div class="kd-box">
                                                             <input type="file" name="fileToUploadAdd[]" id="product_gallery_upload_2" class="atch-new galleryimg_upload " data-multiple-caption="{count} files selected"  data-url="<?php echo Router::url(array('controller' => 'attachments', 'action' => 'kid_upload')); ?>" data-actual = "[product_gallery][2]" data-type ="product_gallery">
                                                <?php if($action =='Add'){ ?>

                                                    <label for="product_gallery_upload_2"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?><input type ='hidden' class="gallery_required" value=""></label>
                                                <?php }else{

                                                    if(@$business_images[2]['KidProductGallery']['gallery_image_path']){
                                                        ?>


                                                        <label for="product_gallery_upload_2"> <div class="img-section row-wrap"><img src="<?php echo $this->Html->url('/', true) .@$business_images[2]['KidProductGallery']['gallery_image_path']; ?>"><input type="hidden" name="data[KidProductGallery][product_gallery][2]" value="<?php echo @$business_images[2]['KidProductGallery']['gallery_image_path']?>"></div></label>
                                                    <?php }else{?>
                                                        <label for="product_gallery_upload_2"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?><input type ='hidden' class="gallery_required" value=""></label>
                                                    <?php  } }?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row kd-img-top required-product-gallery">
                                                <div class="col-md-4 kd-mg-rgt">
                                                    <div class="kd-img-gallery kd-gallery">
                                                        <div class="kd-box">
                                                             <input type="file" name="fileToUploadAdd[]" id="product_gallery_upload_3" class="atch-new galleryimg_upload " data-multiple-caption="{count} files selected"  data-url="<?php echo Router::url(array('controller' => 'attachments', 'action' => 'kid_upload')); ?>" data-actual = "[product_gallery][3]" data-type ="product_gallery">
                                                <!--   <label for="product_gallery_upload_3"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?></label>-->
                                                <?php if($action =='Add'){ ?>

                                                    <label for="product_gallery_upload_3"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?><input type ='hidden' class="gallery_required" value=""></label>
                                                <?php }else{

                                                    if($business_images[3]['KidProductGallery']['gallery_image_path']){
                                                        ?>



                                                        <label for="product_gallery_upload_3"> <div class="img-section row-wrap"><img src="<?php echo $this->Html->url('/', true) .@$business_images[3]['KidProductGallery']['gallery_image_path']; ?>"><input type="hidden" name="data[KidProductGallery][product_gallery][3]" value="<?php echo @$business_images[3]['KidProductGallery']['gallery_image_path']?>"></div></label>
                                                    <?php }else{?>
                                                        <label for="product_gallery_upload_3"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?><input type ='hidden' class="gallery_required" value=""></label>
                                                    <?php } }?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mid_col">
                                                    <div class="kd-img-gallery kd-gallery">
                                                        <div class="kd-box">
                                                            
                                                <input type="file" name="fileToUploadAdd[]" id="product_gallery_upload_4" class="atch-new galleryimg_upload " data-multiple-caption="{count} files selected"  data-url="<?php echo Router::url(array('controller' => 'attachments', 'action' => 'kid_upload')); ?>" data-actual = "[product_gallery][4]" data-type ="product_gallery" >

                                                <?php if($action =='Add'){ ?>

                                                    <label for="product_gallery_upload_4"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?><input type ='hidden' class="gallery_required" value=""></label>
                                                <?php }else{

                                                    if($business_images[4]['KidProductGallery']['gallery_image_path']){
                                                        ?>




                                                        <label for="product_gallery_upload_4"> <div class="img-section row-wrap"><img src="<?php echo $this->Html->url('/', true) .@$business_images[4]['KidProductGallery']['gallery_image_path']; ?>"><input type="hidden" name="data[KidProductGallery][product_gallery][4]" value="<?php echo @$business_images[4]['KidProductGallery']['gallery_image_path']?>"></div></label>
                                                    <?php }else{?>
                                                        <label for="product_gallery_upload_4"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?><input type ='hidden' class="gallery_required" value=""></label>
                                                    <?php } }?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 kd-mg-lft">
                                                    <div class="kd-img-gallery kd-gallery">
                                                        <div class="kd-box">
                                                            <input type="file" name="fileToUploadAdd[]" id="product_gallery_upload_5" class="atch-new galleryimg_upload " data-multiple-caption="{count} files selected"  data-url="<?php echo Router::url(array('controller' => 'attachments', 'action' => 'kid_upload')); ?>" data-actual = "[product_gallery][5]" data-type ="product_gallery">

                                                <?php if($action =='Add'){ ?>

                                                    <label for="product_gallery_upload_5"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?><input type ='hidden' class="gallery_required" value=""></label>
                                                <?php }else{

                                                    if($business_images[5]['KidProductGallery']['gallery_image_path']){
                                                        ?>



                                                        <label for="product_gallery_upload_5"> <div class="img-section row-wrap"><img src="<?php echo $this->Html->url('/', true) .@$business_images[5]['KidProductGallery']['gallery_image_path']; ?>"><input type="hidden" name="data[KidProductGallery][product_gallery][5]" value="<?php echo @$business_images[5]['KidProductGallery']['gallery_image_path']?>"></div></label>
                                                    <?php }else{?>
                                                        <label for="product_gallery_upload_5"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?><input type ='hidden' class="gallery_required" value=""></label>
                                                    <?php } }?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row pitch_video_scetion">
                                                <div class="col-md-12">
                                                    <h4>Pitch Video</h4>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="video kd-video">
                                                        
 <?php if($action =='Add'){ ?>

                                                          <input  id="fileToUploadAdd" class="atch-new galleryimg_upload" data-file="businessprofilevideo">
                                                          <input type="hidden" value="" name="data[KidBusinessProfile][pitch_video_id]" id="businessprofilevideo">
                                                           <label for="fileToUploadAdd" class ="pending_approval"><?php echo $this->Html->image('wq4.svg',array('class'=>'kd-img-upload')); ?></label>
                                                           <?php  }else{
                                                            // pr($business_info);

                                                            ?>
                                                                <input  id="fileToUploadAdd" class="atch-new galleryimg_upload" data-file="businessprofilevideo">
                                                            <input type="hidden" value="<?php echo @$kid_info['KidBusinessProfile'][$businessKey]['pitch_video_id'] ?>" name="data[KidBusinessProfile][pitch_video_id]" id="businessprofilevideo">
                                                            
                                                            
                                                            <?php if($kid_info['KidBusinessProfile'][$businessKey]['pitch_video_id']!='')
                                        {
                                            $videoId=explode("v=",$kid_info['KidBusinessProfile'][$businessKey]['pitch_video_id']);
                                            $videodata = file_get_contents("https://www.googleapis.com/youtube/v3/videos?key=AIzaSyDXmcVVM_xgfixa1YGqEbmHLDSSysFRk7k&part=snippet&id=".$videoId[1]);
$jsondata = json_decode($videodata);
if (count($jsondata->items[0])==0) {
    ?> <label for="fileToUploadAdd" class ="pending_approval"><?php echo $this->Html->image('pending_approval.png',array('class'=>'kd-img-upload'));?> </label><?php
   
}else{
    ?><a href="javascript:void(0)" class="blue play-video-popup" data-toggle="modal" data-target="#blogVideoPopup" data-video="http://www.youtube.com/embed/<?php echo $videoId[1];?>" data-title="eco">
        <label for="fileToUploadAdd" class ="pending_approval"><img src="https://img.youtube.com/vi/<?php echo $videoId[1];?>/hqdefault.jpg"></label>
                                        </a>
        <?php
}
                                            
                                        }else
                                        {?>
                                            <label for="fileToUploadAdd"><?php echo $this->Html->image('wq4.svg',array('class'=>'kd-img-upload')); ?></label>
                                        <?php  } ?>
                                            
                                            
                                                          
                                                               
                                                          <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h4>Other Pics</h4>
                                                </div>
                                                <div class="col-md-4 kd-mg-rgt">
                                                    <div class="kd-img-gallery kd-gallery">
                                                        <div class="kd-box">
                                                           <input type="file" name="fileToUploadAdd[]" id="other_gallery_upload" class="atch-new galleryimg_upload" data-multiple-caption="{count} files selected"  data-url="<?php echo Router::url(array('controller' => 'attachments', 'action' => 'kid_upload')); ?>" data-actual = "[other_gallery][]" data-type ="other_gallery">

                                                    <!--       <label for="other_gallery_upload"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?></label> -->
                                                    <?php if($action =='Add'){ ?>

                                                        <label for="other_gallery_upload"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?></label>
                                                    <?php }else{

                                                        if($business_images[6]['KidProductGallery']['gallery_image_path']){
                                                            ?>


                                                            <label for="other_gallery_upload"> <div class="img-section row-wrap"><img src="<?php echo $this->Html->url('/', true) .@$business_images[6]['KidProductGallery']['gallery_image_path']; ?>"><input type="hidden" name="data[KidProductGallery][other_gallery][]" value="<?php echo @$business_images[6]['KidProductGallery']['gallery_image_path']?>"></div></label>
                                                        <?php }else{?>

                                                            <label for="other_gallery_upload"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?></label>
                                                        <?php } }?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mid_col">
                                                    <div class="kd-img-gallery kd-gallery">
                                                        <div class="kd-box">
                                                            <input type="file" name="fileToUploadAdd[]" id="other_gallery_upload_1" class="atch-new galleryimg_upload" data-multiple-caption="{count} files selected"  data-url="<?php echo Router::url(array('controller' => 'attachments', 'action' => 'kid_upload')); ?>" data-actual = "[other_gallery][1]" data-type ="other_gallery">
                                                <!-- <label for="other_gallery_upload_1"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?></label> -->
                                                <?php if($action =='Add'){ ?>

                                                    <label for="other_gallery_upload_1"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?></label>
                                                <?php }else{

                                                    if($business_images[7]['KidProductGallery']['gallery_image_path']){
                                                        ?>


                                                        <label for="other_gallery_upload_1"> <div class="img-section row-wrap"><img src="<?php echo $this->Html->url('/', true) .@$business_images[7]['KidProductGallery']['gallery_image_path']; ?>"><input type="hidden" name="data[KidProductGallery][other_gallery][1]" value="<?php echo @$business_images[7]['KidProductGallery']['gallery_image_path']?>"></div></label>
                                                    <?php }else{?>

                                                        <label for="other_gallery_upload_1"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?></label>
                                                    <?php } }?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 kd-mg-lft">
                                                    <div class="kd-img-gallery kd-gallery">
                                                        <div class="kd-box">
                                                            <input type="file" name="fileToUploadAdd[]" id="other_gallery_upload_2" class="atch-new galleryimg_upload" data-multiple-caption="{count} files selected"  data-url="<?php echo Router::url(array('controller' => 'attachments', 'action' => 'kid_upload')); ?>" data-actual = "[other_gallery][2]" data-type ="other_gallery">
                                                <!--  <label for="other_gallery_upload_2"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?></label> -->
                                                <?php if($action =='Add'){ ?>

                                                    <label for="other_gallery_upload_2"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?></label>
                                                <?php }else{

                                                    if($business_images[8]['KidProductGallery']['gallery_image_path']){
                                                        ?>



                                                        <label for="other_gallery_upload_2"> <div class="img-section row-wrap"><img src="<?php echo $this->Html->url('/', true) .@$business_images[8]['KidProductGallery']['gallery_image_path']; ?>"><input type="hidden" name="data[KidProductGallery][other_gallery][2]" value="<?php echo @$business_images[8]['KidProductGallery']['gallery_image_path']?>"></div></label>
                                                    <?php }else{?>

                                                        <label for="other_gallery_upload_2"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?></label>
                                                    <?php } }?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row kd-img-top">
                                                <div class="col-md-4 kd-mg-rgt">
                                                    <div class="kd-img-gallery kd-gallery">
                                                        <div class="kd-box">
                                                             <input type="file" name="fileToUploadAdd[]" id="other_gallery_upload_3" class="atch-new galleryimg_upload" data-multiple-caption="{count} files selected"  data-url="<?php echo Router::url(array('controller' => 'attachments', 'action' => 'kid_upload')); ?>" data-actual = "[other_gallery][3]" data-type ="other_gallery">
                                                <!--   <label for="other_gallery_upload_3"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?></label> -->

                                                <?php if($action =='Add'){ ?>

                                                    <label for="other_gallery_upload_3"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?></label>
                                                <?php }else{

                                                    if($business_images[9]['KidProductGallery']['gallery_image_path']){
                                                        ?>




                                                        <label for="other_gallery_upload_3"> <div class="img-section row-wrap"><img src="<?php echo $this->Html->url('/', true) .@$business_images[9]['KidProductGallery']['gallery_image_path']; ?>"><input type="hidden" name="data[KidProductGallery][other_gallery][3]" value="<?php echo @$business_images[9]['KidProductGallery']['gallery_image_path']?>"></div></label>
                                                    <?php }else{?>

                                                        <label for="other_gallery_upload_3"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?></label>
                                                    <?php } }?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 mid_col">
                                                    <div class="kd-img-gallery kd-gallery">
                                                        <div class="kd-box">
                                                             <input type="file" name="fileToUploadAdd[]" id="other_gallery_upload_4" class="atch-new galleryimg_upload" data-multiple-caption="{count} files selected"  data-url="<?php echo Router::url(array('controller' => 'attachments', 'action' => 'kid_upload')); ?>" data-actual = "[other_gallery][4]" data-type ="other_gallery">
                                                <!--   <label for="other_gallery_upload_4"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?></label> -->
                                                <?php if($action =='Add'){ ?>

                                                    <label for="other_gallery_upload_4"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?></label>
                                                <?php }else{

                                                    if($business_images[10]['KidProductGallery']['gallery_image_path']){
                                                        ?>




                                                        <label for="other_gallery_upload_4"> <div class="img-section row-wrap"><img src="<?php echo $this->Html->url('/', true) .@$business_images[10]['KidProductGallery']['gallery_image_path']; ?>"><input type="hidden" name="data[KidProductGallery][other_gallery][4]" value="<?php echo @$business_images[10]['KidProductGallery']['gallery_image_path']?>"></div></label>
                                                    <?php }else{?>

                                                        <label for="other_gallery_upload_4"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?></label>
                                                    <?php } }?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 kd-mg-lft">
                                                    <div class="kd-img-gallery kd-gallery">
                                                        <div class="kd-box">
                                                             <input type="file" name="fileToUploadAdd[]" id="other_gallery_upload_5" class="atch-new galleryimg_upload" data-multiple-caption="{count} files selected"  data-url="<?php echo Router::url(array('controller' => 'attachments', 'action' => 'kid_upload')); ?>" data-actual = "[other_gallery][5]" data-type ="other_gallery">
                                                <!--  <label for="other_gallery_upload_5"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?></label> -->
                                                <?php if($action =='Add'){ ?>

                                                    <label for="other_gallery_upload_5"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?></label>
                                                <?php }else{

                                                    if($business_images[11]['KidProductGallery']['gallery_image_path']){
                                                        ?>





                                                        <label for="other_gallery_upload_5"> <div class="img-section row-wrap"><img src="<?php echo $this->Html->url('/', true) .@$business_images[11]['KidProductGallery']['gallery_image_path']; ?>"><input type="hidden" name="data[KidProductGallery][other_gallery][5]" value="<?php echo @$business_images[11]['KidProductGallery']['gallery_image_path']?>"></div></label>
                                                    <?php }else{?>

                                                        <label for="other_gallery_upload_5"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?></label>
                                                    <?php } }?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>