<div class="bs-example advice-tabs " id = "business_profile_modal">

    <div class="tab-content " >

        <div id="dashkidProfile" class="tab-pane active">
            <form name = "SaveBusinessFlyin" id = "SaveBusinessFlyin" method="POST" style="padding-bottom: 15px;">
                <div class="kd-account_info_wrap" style="margin-top: 0px;">

                    <div class="kd-account_wrapper kd-white-buisness containerHeight custom_scroll" id="container2">

                        <div style="padding-top: 15px;">

                            <div class="row ">
                                <div class="col-md-12 ">
                                    <div class="profile_detail relative">

                                        <div class="profile-img-blck  profile_img kid">
                                            <div class="row">
                                                <div class="col-md-3 col-xs-3 p-r-0 text-center">


                                                    <div class="kd-img-gallery kd-gallery" id = "hidden_product">
                                                        <div class="kd-box" >

                                                            <input type="file" name="fileToUploadAdd[]" id="product_image_upload" class="atch-new  galleryimg_upload" data-multiple-caption="{count} files selected"  data-url="<?php echo Router::url(array('controller' => 'attachments', 'action' => 'kid_upload')); ?>" data-actual = "product_image">

                                                            <?php if($action =='Add'){ ?>

                                                                <label for="product_image_upload" > Product Image <input type ='hidden' name ="data[KidBusinessProfile][product_image]" value=""></label>
                                                            <?php }else{?>


                                                                <label for="product_image_upload"> <div class="img-section row-wrap"><img src="<?php echo $this->Html->url('/', true) .@$business_info['KidBusinessProfile']['product_image']; ?>"><input type="hidden" name="data[KidBusinessProfile][product_image]" value="<?php echo @$business_info['KidBusinessProfile']['product_image']?>"></div></label>
                                                            <?php } ?>





                                                        </div>


                                                    </div>


                                                </div>

                                                <div class="col-md-9 col-xs-9">
                                                    <div class="profile-block clearfix">
                                                        <h4>Business Name</h4>
                                                        <div class="form-group">
<?php //echo htmlentities($value);?>
                                                            <div class="row">
                                                                <div class="col-sm-9">
                                                                    <input name="data[KidBusinessProfile][business_name]" id="business_name" class="form-control clear-title" placeholder="" maxlength="50" type="text"  data-original-title="" title="" value = "<?php echo htmlentities(@$business_info['KidBusinessProfile']['business_name'])?>">
                                                                    <input   type="hidden" id = "username_logged"  value = "<?php echo htmlentities(@$studentinfo['User']['username'])?>">
                                                                    <?php   $profile_count =  $this->Kidpreneur->businessProfileCount($studentinfo['User']['id']); ?>
                                                                     <input type="hidden" id = "total_count_business"  value = "<?php echo $profile_count ;?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- <h4 class="kd-top-none" style="color:#000;font-size: 14px;"><strong><?php echo $studentinfo['User']['username'];?></strong></h4> -->
                                                    <div class="profile-block clearfix">
                                                        <h4>Founded</h4>
                                                        <div class="form-group">
                                                            <div class="row">
                                                                <div class="col-sm-9">
                                                                    <select name="data[KidBusinessProfile][founded_year]" class="form-control" id="founded_year" data-original-title="" title="" style="padding-left: 8px;">
                                                                        <option value="">Founded</option>
                                                                        <?php  for ($y ='1990';$y< 2019 ;$y++) {?>
                                                                        <option value="<?php echo $y;?>" <?php if(@$business_info['KidBusinessProfile']['founded_year'] ==$y ){echo "selected='selected'";}?>><?php echo  $y;?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="profile-block clearfix">
                                                        <h4>Start-up $$</h4>
                                                        <div class="form-group">

                                                            <div class="row">
                                                                <div class="col-sm-9">
                                                                    <input name="data[KidBusinessProfile][start_up]" id="start_up" class="form-control clear-title" placeholder="" maxlength="10" type="text"  data-original-title="" title="" value = "<?php echo @$business_info['KidBusinessProfile']['start_up']?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="profile-block clearfix" style="margin: 10px 0px 0px 0px;">
                                                        <h4 class="kd-addup-field">FOUNDERS / BUSINESS OWNERS</h4>
                                                        <div class="form-group">

                                                            <?php


                                                            if($action =='Edit'){
                                                                $i = 0;
                                                                foreach (@$business_info['KidBusinessOwner'] as $business_owner) {?>
                                                                    <div id = "TextBoxDiv<?php echo $i;?>">
                                                                        <input name="data[KidBusinessOwner][business_owner][<?php echo $i;?>]"  class="form-control clear-title business_owner"  maxlength="100" type="text" value="<?php echo htmlentities($business_owner['business_owner']);?>" id = "textbox<?php echo $i;?>">                                                      <input name="data[KidBusinessOwner][kid_business_owner_id][<?php echo $i;?>]"  class="form-control clear-title kid_business_owner_id"  type="hidden" value="<?php echo $business_owner['id'];?>">
                                                                        <?php if($i>0){
                                                                        echo '<a class="kid_addup"><i class="fa fa-minus-circle removeButton" id="removeButton" onclick="removeElem('.($i).')"></i></a>';
                                                                    }?>
                                                                    </div>
                                                                    <?php $i++; }

                                                            }else
                                                            {  ?>

                                                               <input name="data[KidBusinessOwner][business_owner][]" id="business_owner" class="form-control clear-title business_owner"   maxlength="100" type="text" >                                                      <input name="data[KidBusinessOwner][kid_business_owner_id][]" id="kid_business_owner_id" class="form-control clear-title kid_business_owner_id"  type="hidden">
                                                               
                                                            <?php } ?>

                                                            <div id='TextBoxesGroup' class="">
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-11"  id="iconclass" style="margin-top: -15px;margin-left: 10px;padding: 0px;">
                                                        <a class="kd-addup"><i class="fa fa-plus-circle " id='addButton'></i></a>
                                                        <!-- <a class="kd-addup" style="margin-right: 5px;"><i class="fa fa-minus-circle " id='removeButton'></i></a> -->
                                                    </div>


                                                    <div class="profile-block clearfix">
                                                        <h4>About my business</h4>
                                                        <div class="form-group">

                                                            <textarea rows="2" name="data[KidBusinessProfile][about_business]" id="about_business" class="form-control kd-form-style dsds"  placeholder=""><?php echo @$business_info['KidBusinessProfile']['about_business']?></textarea>

                                                        </div>
                                                    </div>
                                                    <div class="profile-block clearfix">
                                                        <h4>Mission</h4>
                                                        <div class="form-group">

                                                            <textarea rows="1" name="data[KidBusinessProfile][mission]"  id = "mission"  class="form-control kd-form-style" placeholder=""><?php echo @$business_info['KidBusinessProfile']['mission']?></textarea>

                                                        </div>
                                                    </div>
                                                    <div class="profile-block clearfix">
                                                        <h4>vision and Goals</h4>
                                                        <div class="form-group">

                                                            <textarea rows="5" name="data[KidBusinessProfile][vision_goal]" id="vision_goal"  class="form-control kd-form-style"  placeholder=""><?php echo @$business_info['KidBusinessProfile']['vision_goal']?></textarea>

                                                        </div>

                                                    </div>
                                                    <div class="profile-block clearfix">
                                                        <h4>Revenue</h4>
                                                        <div class="form-group">

                                                            <textarea name="data[KidBusinessProfile][revenue]" id="revenue"  class="form-control kd-form-style" placeholder=""><?php echo @$business_info['KidBusinessProfile']['revenue']?></textarea>

                                                        </div>
                                                    </div>
                                                    <div class="profile-block clearfix">
                                                        <h4>Donated</h4>
                                                        <div class="form-group">

                                                            <textarea name="data[KidBusinessProfile][donated]" id="donated"  class="form-control kd-form-style"  placeholder=""><?php echo @$business_info['KidBusinessProfile']['donated']?></textarea>

                                                        </div>
                                                    </div>


                                                </div>

                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="kd-buisness_footer border-0 m-r-15 p-r-0">
                    <?php if(@$business_info['KidBusinessProfile']['status'] !='save'){?>
                    <button type="button" class="btn blue_filled save_add_business" data-event = "draft" data-id = "<?php echo @$business_info['KidBusinessProfile']['id']?>"  data-page ="first">SAVE DRAFT</button>&nbsp;
                    <?php } ?>

                    <button type="button" class="btn blue_filled save_continue_business m-l-10" data-event = "continue" data-id = "<?php echo @$business_info['KidBusinessProfile']['id']?>" >SAVE AND CONTINUE</button>&nbsp;

                    <button type="button" class="btn blue_filled cancel_business_modal m-l-10">CANCEL</button>


                </div>
            </form>
        </div>  <!-- end of dashProfile -->



        <div id="dashkidGallery" class="tab-pane ">
            <form name = "SaveGalleryFlyin" id = "SaveGalleryFlyin" method="POST">
                <div class="sage-advice-data">
                    <div class="kd-account_sidebar">
                        <div class="">
                            <div class="kd-account_social_wrap kd-account_wrapper custom_scroll p-15" id="container3">
                                <div class="row" style="padding-top: 15px;">
                                    <div class="col-md-12">
                                        <h4 class="kd-top-none m-t-10 m-b-10">Product Features and Benefits</h4>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <textarea name="data[KidBusinessProfile][feature_benefit]" id="feature_benefit"  class="form-control kd-form-style kd-txt-hgt"  placeholder=""><?php echo  @$business_info['KidBusinessProfile']['feature_benefit'];?></textarea>

                                        </div>
                                        <h4 class="m-t-10 m-b-10">Website</h4>

                                        <div class="form-group">

                                            <input name="data[KidBusinessProfile][business_website]" id="business_website" class="form-control clear-title" placeholder=""  type="text" data-original-title="" title="" value="<?php echo  @$business_info['KidBusinessProfile']['business_website'];?>">

                                        </div>

                                    </div>
                                    <div class="col-md-4" style="padding-left: 0">
                                        <div class="kd-img-gallery kd-gallery" id = "hidden_logo">
                                            <div class="kd-box" style="margin-top:0px;">

                                                <input type="file" name="fileToUploadAdd[]" id="logo_image_upload" class="atch-new galleryimg_upload" data-multiple-caption="{count} files selected"  data-url="<?php echo Router::url(array('controller' => 'attachments', 'action' => 'kid_upload')); ?>" data-actual = "logo_image">


                                                <?php if($action =='Add'){ ?>

                                                    <label for="logo_image_upload">LOGO<input type ='hidden' name ="data[KidBusinessProfile][logo_image]" value=""></label>
                                                <?php }else{

                                        if(@$business_info['KidBusinessProfile']['logo_image']){
                                                        ?>


                                                      <label for="logo_image_upload"> <div class="img-section row-wrap">
                                                        <img src="<?php echo $this->Html->url('/', true) .@$business_info['KidBusinessProfile']['logo_image']; ?>">

                                                        <input type="hidden" name="data[KidBusinessProfile][logo_image]" value="<?php echo @$business_info['KidBusinessProfile']['logo_image']?>"></div></label>
                                                    <?php }else{?>
                                                        <label for="logo_image_upload"><input type ='hidden' name ="data[KidBusinessProfile][logo_image]" value=""><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?></label>
                                                    <?php } } ?>
                                                    





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
                                        <div class="kd-img-gallery kd-gallery">
                                            <div class="kd-box">


                                                <input type="file" name="fileToUploadAdd[]" id="product_gallery_upload" class="atch-new galleryimg_upload " data-multiple-caption="{count} files selected"  data-url="<?php echo Router::url(array('controller' => 'attachments', 'action' => 'kid_upload')); ?>" data-actual = "[product_gallery][]" data-type ="product_gallery">

                                                <?php if($action =='Add'){ ?>

                                                    <label for="product_gallery_upload"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?><input type ='hidden' class="gallery_required" value=""></label>
                                                <?php }else{

                                                    if(@$business_info['KidProductGallery'][0]['gallery_image_path']){
                                                        ?>


                                                        <label for="product_gallery_upload"> <div class="img-section row-wrap"><img src="<?php echo $this->Html->url('/', true) .@$business_info['KidProductGallery'][0]['gallery_image_path']; ?>"><input type="hidden" name="data[KidProductGallery][product_gallery][]" value="<?php echo @$business_info['KidProductGallery'][0]['gallery_image_path']?>"></div></label>
                                                    <?php }else{?>

                                                        <label for="product_gallery_upload"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?><input type ='hidden' class="gallery_required" value=""></label>
                                                    <?php   } } ?>



                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mid_col">
                                        <div class="kd-img-gallery kd-gallery">
                                            <div class="kd-box">
                                                <!--   <input type="file" name="file-2[]" id="file-2" class="" data-multiple-caption="{count} files selected" >
                                                            <label for="file-2"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?></label> -->

                                                <input type="file" name="fileToUploadAdd[]" id="product_gallery_upload_1" class="atch-new galleryimg_upload " data-multiple-caption="{count} files selected"  data-url="<?php echo Router::url(array('controller' => 'attachments', 'action' => 'kid_upload')); ?>" data-actual = "[product_gallery][1]" data-type ="product_gallery">


                                                <?php if($action =='Add'){ ?>

                                                    <label for="product_gallery_upload_1"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?><input type ='hidden' class="gallery_required" value=""></label>
                                                <?php }else{

                                                    if(@$business_info['KidProductGallery']['1']['gallery_image_path']){
                                                        ?>


                                                        <label for="product_gallery_upload_1"> <div class="img-section row-wrap"><img src="<?php echo $this->Html->url('/', true) .@$business_info['KidProductGallery'][1]['gallery_image_path']; ?>"><input type="hidden" name="data[KidProductGallery][product_gallery][1]" value="<?php echo @$business_info['KidProductGallery'][1]['gallery_image_path']?>"></div></label>
                                                    <?php }else{?>
                                                        <label for="product_gallery_upload_1"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?><input type ='hidden' class="gallery_required" value=""></label>
                                                    <?php } } ?>

                                                <!--  <label for="product_gallery_upload_1"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?></label> -->
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

                                                    if(@$business_info['KidProductGallery']['2']['gallery_image_path']){
                                                        ?>


                                                        <label for="product_gallery_upload_2"> <div class="img-section row-wrap"><img src="<?php echo $this->Html->url('/', true) .@$business_info['KidProductGallery'][2]['gallery_image_path']; ?>"><input type="hidden" name="data[KidProductGallery][product_gallery][2]" value="<?php echo @$business_info['KidProductGallery'][2]['gallery_image_path']?>"></div></label>
                                                    <?php }else{?>
                                                        <label for="product_gallery_upload_2"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?><input type ='hidden' class="gallery_required" value=""></label>
                                                    <?php  } }?>


                                                <!--  <label for="product_gallery_upload_2"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?></label> -->
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

                                                    if($business_info['KidProductGallery'][3]['gallery_image_path']){
                                                        ?>



                                                        <label for="product_gallery_upload_3"> <div class="img-section row-wrap"><img src="<?php echo $this->Html->url('/', true) .@$business_info['KidProductGallery'][3]['gallery_image_path']; ?>"><input type="hidden" name="data[KidProductGallery][product_gallery][3]" value="<?php echo @$business_info['KidProductGallery'][3]['gallery_image_path']?>"></div></label>
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

                                                    if($business_info['KidProductGallery'][4]['gallery_image_path']){
                                                        ?>




                                                        <label for="product_gallery_upload_4"> <div class="img-section row-wrap"><img src="<?php echo $this->Html->url('/', true) .@$business_info['KidProductGallery'][4]['gallery_image_path']; ?>"><input type="hidden" name="data[KidProductGallery][product_gallery][4]" value="<?php echo @$business_info['KidProductGallery'][4]['gallery_image_path']?>"></div></label>
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

                                                    if($business_info['KidProductGallery'][5]['gallery_image_path']){
                                                        ?>



                                                        <label for="product_gallery_upload_5"> <div class="img-section row-wrap"><img src="<?php echo $this->Html->url('/', true) .@$business_info['KidProductGallery'][5]['gallery_image_path']; ?>"><input type="hidden" name="data[KidProductGallery][product_gallery][5]" value="<?php echo @$business_info['KidProductGallery'][5]['gallery_image_path']?>"></div></label>
                                                    <?php }else{?>
                                                        <label for="product_gallery_upload_5"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?><input type ='hidden' class="gallery_required" value=""></label>
                                                    <?php } }?>


                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row pitch_video_scetion">
                                    <div class="col-md-12">
                                        <h4 class="m-t-10 m-b-10">Pitch Video</h4>
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
                                                            <input type="hidden" value="<?php echo $business_info['KidBusinessProfile']['pitch_video_id'] ?>" name="data[KidBusinessProfile][pitch_video_id]" id="businessprofilevideo">
                                                           <label for="fileToUploadAdd" class ="pending_approval"><?php  if($business_info['KidBusinessProfile']['pitch_video_id']!=''){ echo $this->Html->image('pending_approval.png',array('class'=>'kd-img-upload'));}else{  echo $this->Html->image('wq4.svg',array('class'=>'kd-img-upload')); } ?></label>
                                                               
                                                          <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <h4 class="m-t-10 m-b-10">Other Pics</h4>
                                    </div>

                                    <div class="col-md-4 kd-mg-rgt">
                                        <div class="kd-img-gallery kd-gallery">
                                            <div class="file-upload ">
                                                <div class="kd-box">


                                                    <input type="file" name="fileToUploadAdd[]" id="other_gallery_upload" class="atch-new galleryimg_upload" data-multiple-caption="{count} files selected"  data-url="<?php echo Router::url(array('controller' => 'attachments', 'action' => 'kid_upload')); ?>" data-actual = "[other_gallery][]" data-type ="other_gallery">

                                                    <!--       <label for="other_gallery_upload"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?></label> -->
                                                    <?php if($action =='Add'){ ?>

                                                        <label for="other_gallery_upload"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?></label>
                                                    <?php }else{

                                                        if($business_info['KidProductGallery'][6]['gallery_image_path']){
                                                            ?>


                                                            <label for="other_gallery_upload"> <div class="img-section row-wrap"><img src="<?php echo $this->Html->url('/', true) .@$business_info['KidProductGallery'][6]['gallery_image_path']; ?>"><input type="hidden" name="data[KidProductGallery][other_gallery][]" value="<?php echo @$business_info['KidProductGallery'][6]['gallery_image_path']?>"></div></label>
                                                        <?php }else{?>

                                                            <label for="other_gallery_upload"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?></label>
                                                        <?php } }?>


                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mid_col">
                                        <div class="kd-img-gallery kd-gallery">
                                            <div class="kd-box">
                                                <!--   <input type="file" name="file-2[]" id="file-2" class="" data-multiple-caption="{count} files selected" >
                                                            <label for="file-2"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?></label> -->

                                                <input type="file" name="fileToUploadAdd[]" id="other_gallery_upload_1" class="atch-new galleryimg_upload" data-multiple-caption="{count} files selected"  data-url="<?php echo Router::url(array('controller' => 'attachments', 'action' => 'kid_upload')); ?>" data-actual = "[other_gallery][1]" data-type ="other_gallery">
                                                <!-- <label for="other_gallery_upload_1"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?></label> -->
                                                <?php if($action =='Add'){ ?>

                                                    <label for="other_gallery_upload_1"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?></label>
                                                <?php }else{

                                                    if($business_info['KidProductGallery'][7]['gallery_image_path']){
                                                        ?>


                                                        <label for="other_gallery_upload_1"> <div class="img-section row-wrap"><img src="<?php echo $this->Html->url('/', true) .@$business_info['KidProductGallery'][7]['gallery_image_path']; ?>"><input type="hidden" name="data[KidProductGallery][other_gallery][1]" value="<?php echo @$business_info['KidProductGallery'][7]['gallery_image_path']?>"></div></label>
                                                    <?php }else{?>

                                                        <label for="other_gallery_upload_1"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?></label>
                                                    <?php } }?>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 kd-mg-lft">
                                        <div class="kd-img-gallery kd-gallery">
                                            <div class="kd-box">
                                                <!--  <input type="file" name="file-2[]" id="file-2" class="" data-multiple-caption="{count} files selected" >
                                                            <label for="file-2"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?></label> -->

                                                <input type="file" name="fileToUploadAdd[]" id="other_gallery_upload_2" class="atch-new galleryimg_upload" data-multiple-caption="{count} files selected"  data-url="<?php echo Router::url(array('controller' => 'attachments', 'action' => 'kid_upload')); ?>" data-actual = "[other_gallery][2]" data-type ="other_gallery">
                                                <!--  <label for="other_gallery_upload_2"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?></label> -->
                                                <?php if($action =='Add'){ ?>

                                                    <label for="other_gallery_upload_2"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?></label>
                                                <?php }else{

                                                    if($business_info['KidProductGallery'][8]['gallery_image_path']){
                                                        ?>



                                                        <label for="other_gallery_upload_2"> <div class="img-section row-wrap"><img src="<?php echo $this->Html->url('/', true) .@$business_info['KidProductGallery'][8]['gallery_image_path']; ?>"><input type="hidden" name="data[KidProductGallery][other_gallery][2]" value="<?php echo @$business_info['KidProductGallery'][8]['gallery_image_path']?>"></div></label>
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
                                                <!--   <input type="file" name="file-2[]" id="file-2" class="" data-multiple-caption="{count} files selected" >
                                                            <label for="file-2"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?></label>
                                                             -->
                                                <input type="file" name="fileToUploadAdd[]" id="other_gallery_upload_3" class="atch-new galleryimg_upload" data-multiple-caption="{count} files selected"  data-url="<?php echo Router::url(array('controller' => 'attachments', 'action' => 'kid_upload')); ?>" data-actual = "[other_gallery][3]" data-type ="other_gallery">
                                                <!--   <label for="other_gallery_upload_3"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?></label> -->

                                                <?php if($action =='Add'){ ?>

                                                    <label for="other_gallery_upload_3"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?></label>
                                                <?php }else{

                                                    if($business_info['KidProductGallery'][9]['gallery_image_path']){
                                                        ?>




                                                        <label for="other_gallery_upload_3"> <div class="img-section row-wrap"><img src="<?php echo $this->Html->url('/', true) .@$business_info['KidProductGallery'][9]['gallery_image_path']; ?>"><input type="hidden" name="data[KidProductGallery][other_gallery][3]" value="<?php echo @$business_info['KidProductGallery'][9]['gallery_image_path']?>"></div></label>
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

                                                    if($business_info['KidProductGallery'][10]['gallery_image_path']){
                                                        ?>




                                                        <label for="other_gallery_upload_4"> <div class="img-section row-wrap"><img src="<?php echo $this->Html->url('/', true) .@$business_info['KidProductGallery'][10]['gallery_image_path']; ?>"><input type="hidden" name="data[KidProductGallery][other_gallery][4]" value="<?php echo @$business_info['KidProductGallery'][10]['gallery_image_path']?>"></div></label>
                                                    <?php }else{?>

                                                        <label for="other_gallery_upload_4"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?></label>
                                                    <?php } }?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 kd-mg-lft">
                                        <div class="kd-img-gallery kd-gallery">
                                            <div class="kd-box">
                                                <!--  <input type="file" name="file-2[]" id="file-2" class="" data-multiple-caption="{count} files selected" >
                                                            <label for="file-2"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?></label> -->
                                                <input type="file" name="fileToUploadAdd[]" id="other_gallery_upload_5" class="atch-new galleryimg_upload" data-multiple-caption="{count} files selected"  data-url="<?php echo Router::url(array('controller' => 'attachments', 'action' => 'kid_upload')); ?>" data-actual = "[other_gallery][5]" data-type ="other_gallery">
                                                <!--  <label for="other_gallery_upload_5"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?></label> -->
                                                <?php if($action =='Add'){ ?>

                                                    <label for="other_gallery_upload_5"><?php echo $this->Html->image('wq3.svg',array('class'=>'kd-img-upload')); ?></label>
                                                <?php }else{

                                                    if($business_info['KidProductGallery'][11]['gallery_image_path']){
                                                        ?>





                                                        <label for="other_gallery_upload_5"> <div class="img-section row-wrap"><img src="<?php echo $this->Html->url('/', true) .@$business_info['KidProductGallery'][11]['gallery_image_path']; ?>"><input type="hidden" name="data[KidProductGallery][other_gallery][5]" value="<?php echo @$business_info['KidProductGallery'][11]['gallery_image_path']?>"></div></label>
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


                    <div class="kd-buisness_footer border-0" style="    padding: 0px 15px 15px 6px; ">
                        <button type="button" class="btn blue_filled back_business_profile" data-event = "back" >back</button>&nbsp;
                         <?php if(@$business_info['KidBusinessProfile']['status'] !='save'){?>
                        <button style="margin-left: 10px;" type="button" class="btn blue_filled save_add_business" data-event = "draft" data-id = "<?php echo @$business_info['KidBusinessProfile']['id']?>" data-page ="second" >SAVE DRAFT</button>&nbsp;
                        <?php } ?>
                        <button type="button" class="btn blue_filled save_add_business m-l-10" data-event = "save" data-id = "<?php echo @$business_info['KidBusinessProfile']['id']?>" >SAVE AND ADD</button>&nbsp;

                        <button type="button" class="btn blue_filled cancel_business_modal m-l-10">CANCEL</button>

                        <!-- <button type="button" class="btn blue_filled disabled">ADD A NEW BUSINESS</button> -->
                    </div>

                </div>
            </form>
        </div>


        <div id=" " class="tab-pane">
            <div class="row">
                <div class="col-md-12">
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aspernatur at atque debitis et explicabo, incidunt libero nemo neque quia rerum totam veniam. Deserunt distinctio doloremque magni minima minus officia similique?</p>

                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad adipisci architecto asperiores atque cum doloremque, eius eos esse facere fuga itaque laborum nemo nostrum officia perspiciatis possimus temporibus voluptates. Ipsam!</p>

                </div>
            </div>
        </div>

    </div><!-- end of tab-content -->


</div>

<script type="text/javascript">

//*******Remove dynamically added boxes*********//
function removeElem(counter){
$("#TextBoxDiv"+counter).remove();
 manupulateEle();
}



//****************//

function manupulateEle(){
var counter= $('.business_owner').length;

if(counter>=4){
 $(".kd-addup").addClass("hide");
}
else{
$(".kd-addup").removeClass("hide")
}
}
    $(document).ready(function(){
manupulateEle();

        $("#addButton").click(function () {
            var counter = $('.business_owner').length;
            
            var newTextBoxDiv = $(document.createElement('div'))
                .attr({"id": 'TextBoxDiv' + counter,"class":"kk-position"});

            newTextBoxDiv.after('<input type="text" name="data[KidBusinessOwner][kid_business_owner_id]['+counter+']" maxlength="100"  id="textbox' + counter + '" value="" />').html('<input type="text" name="data[KidBusinessOwner][business_owner]['+counter+']" id="textbox' + counter + '" class="form-control box-padding business_owner" maxlength="100" value="" /> <input type="hidden" name="data[KidBusinessOwner][kid_business_owner_id]['+counter+']"  class="form-control box-padding " value="" /> <a class="kid_addup"><i class="fa fa-minus-circle " id="removeButton" onclick="removeElem(' + counter + ')"></i></a>');


            newTextBoxDiv.appendTo("#TextBoxesGroup");
            newTextBoxDiv.appendTo("#reflectminus");

            manupulateEle();
            counter++;
        });

        $(".removeButton").click(function () {
            var counter = $('.business_owner').length;
           
            if(counter==1){
                alert("No more textbox to remove");
                return false;
            }
            $("#TextBoxDiv" + counter).remove();

            counter--;

        });

        $('textarea#about_business' ).ckeditor();
        $('textarea#mission' ).ckeditor();
        $('textarea#vision_goal' ).ckeditor();
        $('textarea#revenue' ).ckeditor();
        $('textarea#donated' ).ckeditor();
        $( 'textarea#feature_benefit' ).ckeditor();


    });


    var adviceattach = {};
    //--------------------------- Attachments (File Upload)
    adviceattach = {
        newFileButton: $('.atch-new-box'),
        newFile: $('.atch-new'),
        tempObject: null,
        bindUploader: function (object) {


            if (!object || typeof object == 'undefined') {
                return;
            }

            object.fileupload({

                dataType: 'json',
                async: false,
                add: function (e, data) {
                    var  attach_image_obj =  $(this);
                    var goUpload = true;
                    var uploadFile = data.files[0];

                    $('.page-loading-modal').show();

                    setTimeout(function () {
                        if (goUpload == true) {

                            var img = data.submit();
                            var imgName = img.responseText;
                            // console.log(img.responseText);

                            resp = JSON.parse(imgName);

                            if (resp[0].error != undefined) {
                                $('.page-loading-modal').hide();

                                bootbox.alert({
                                    title: 'Error',
                                    message: resp[0].error
                                });
                                $('.bootstrap-filestyle input').val('');
                                return;

                            } else {

                                jQuery('.bootstrap-filestyle').find('input').val(uploadFile.name);

                                var name_variable =  attach_image_obj.data('actual');
                                var data_type =   attach_image_obj.data('type');
                                for (i = 0; i < resp.length; i++) {

                                    var fileType = resp[i].type;
                                    var fileName = resp[i].source;
                                    var filePath = resp[i].path;
                                    var attachId = resp[i].attachmentId;
                                    if(data_type == 'product_gallery')
                                    {
                                        var name_val = 'data[KidProductGallery]'+ name_variable;
                                    }
                                    else if(data_type == 'other_gallery')
                                    {
                                        var name_val = 'data[KidProductGallery]'+ name_variable;
                                    }
                                    else{
                                        var name_val = 'data[KidBusinessProfile]['+name_variable+']';
                                    }




                                    //  alert(fileType + '~' + fileName + '~' + filePath);
                                    var orgfilePath = filePath.replace("thumb_", "");
                                    var imgPath = '<img src="<?php echo $this->Html->url('/', true); ?>' + filePath + '">';
                                    var str = '<div class="img-section row-wrap">' + imgPath + '<input type="hidden" name = "' + name_val + '" value= "' + filePath + '"></div>';


                                    attach_image_obj.next().html(str);
                                    $('#business-flyin #business_profile_modal').addClass('form-edited');


                                }


                            }

                            $('#attachment-handler .form-control').val('');
                        }

                        $('.page-loading-modal').hide();
                    }, 500);


                },

                progressall: function (e, data) {
                    var $this = $(this);

                    var progress = parseInt(data.loaded / data.total * 100, 10);
                    $('.upload-progress-wrapper:hidden').fadeIn(100);
                    $('.upload-progress-wrapper').find('.upload-progress-value span').text(progress);
                    // console.log(data);
                }
            });
        }
    };

    adviceattach.newFile.each(function () {

        adviceattach.bindUploader($(this));
    });


    $(function () {
        $("#fileToUploadAdd").on("click",function(e){
            e.preventDefault();
            console.log($(this))
            var fileName=$(this).attr("data-file");
            var userInfo={
                submitterFullName:$('#username_logged').val(),

                bussiness_name:$('#business_name').val(),
                uploadDate:new Date(),
                logo:'<?php echo $this->Html->url('/', true);?>img/500.png'
            }
            businessFormModule.integrateClipchamp(fileName,userInfo);
        });
        jQuery(".btn-default").on('click', function (e) {
          
            adviceattach.bindUploader(adviceattach.newFile);

        });
    });

    //# sourceURL=bussiness_modal.ctpjs


</script>

<script type="text/javascript">
    // var addmodalstudentscroll = '.kd-account_wrapper';
    // containerHeightTemp(addmodalstudentscroll)
    
    // customScroll();
    // function containerHeightTemp(selector) {
    //     setTimeout(function () {
    //         var totalHeight = $('.modal-content:visible').outerHeight(true),
    //             bufferH = 40,
    //             profileDetailsH = $('.top-section:visible').outerHeight(true)
    //                 + $('.modal-footer:visible').outerHeight(true)
    //                 + parseInt($('.modal-dialog:visible').css('margin-top'));


    //         var calculatedHeight = totalHeight - (profileDetailsH) - bufferH;
    //        // console.log(calculatedHeight+'@@');

    //         $(selector+":visible").css('height', calculatedHeight+'px');
    //     }, 200);
    // }
    //# sourceURL=busineess_add_modal_element.ctpjs

   
    if(typeof CKEDITOR.instances['about_business'] != "undefined"){   
        CKEDITOR.instances['about_business'].on('change', function() {  

        $('#business-flyin #business_profile_modal').addClass('form-edited');
        });
    }

     if(typeof CKEDITOR.instances['mission'] != "undefined"){   
        CKEDITOR.instances['mission'].on('change', function() {  

        $('#business-flyin #business_profile_modal').addClass('form-edited');
        });
    }

      if(typeof CKEDITOR.instances['vision_goal'] != "undefined"){   
        CKEDITOR.instances['vision_goal'].on('change', function() {  

        $('#business-flyin #business_profile_modal').addClass('form-edited');
        });
    }

      if(typeof CKEDITOR.instances['revenue'] != "undefined"){   
        CKEDITOR.instances['revenue'].on('change', function() {  

        $('#business-flyin #business_profile_modal').addClass('form-edited');
        });
    }

      if(typeof CKEDITOR.instances['donated'] != "undefined"){   
        CKEDITOR.instances['donated'].on('change', function() {  

        $('#business-flyin #business_profile_modal').addClass('form-edited');
        });
    }
</script>