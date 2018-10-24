



<div id="business-flyin" class="modal fade left" role="dialog"  >
    <div class="modal-dialog advice-slide-wrap advive-slide-left-sm">
        <div class="page-loading-modal" style="color:red; display:none"><?php echo $this->Html->image('loading-upload.gif'); ?></div>

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header top-section">

                <div class="row">
                   <ul class="dash_profileTab">
                        <li class = "business_tab active"><a href="#dashkidProfile" data-toggle="tab" class="popup_profile business_profile  light-grey" data-id = "<?php echo $loggedin_kid_id;?>" data-action ='' data-event = 'Business' >Business Profile</a></li>
                        <li class = "gallery_tab"><a href="#dashkidGallery" data-toggle="tab" class=" blue business_profile_gallery" data-id = "<?php echo $loggedin_kid_id;?>"  data-action ='' data-event = 'Gallery'>Gallery</a></li>
                        <li class = "like_tab  disabled" ><a href="" data-toggle="tab" class="dark-grey business_profile_like" data-id = "<?php echo $loggedin_kid_id;?>"  data-action =''  data-event = 'Like'>Likes</a></li>
                    </ul>
                </div>
               
            </div>
            <div class="modal-body" data-mcs-theme="">

               

            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-para-gap" id="business-modal-success" tabindex="-1" role="dialog" data-backdrop="static"  aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header ">
                <button type="button" class="close" data-dismiss="modal" id="confirmadvice" aria-hidden="true"><i class="icons close-icon"></i></button>
                <h4 class="modal-title" id="myModalLabel">Business Profile Added Successfully!</h4>
            </div>
            <div class="modal-body"><p>Thanks for adding business profile.</p>
            </div>
            <div class="modal-footer model-footer1 ">
                <button type="button" class="btn btn-black" data-dismiss="modal" id="confirmadvice">OK</button>
               <!--  <button type="button" class="btn btn-black" data-dismiss="modal">NOT NOW</button> -->
            </div>
        </div>
    </div>
</div>


