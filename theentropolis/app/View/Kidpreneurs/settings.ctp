<?php
//pr($kid_info);
$parent_info = $this->User->getUserData($kid_info['User']['parent_id']);
//pr($parent_info);
$students = $kid_info;
if ((isset($this->params['pass'][0]))) {
    $userImage="";
    if(isset($kid_info['User']['user_image'])){
        
        $userImage=  explode("/", @$kid_info['User']['user_image']);
    }
    $imageIndexSlide=explode(".",$userImage[1]);
    ?>
    <!--============ACCOUNT SETTING EDIT MODE================================-->
    <div class="middle-container  setting-wrapper  " style="padding:1.12rem 1.56rem; position:relative;" ng-app="kidpreneur" ng-controller="settings">
        <div class="kd-middle-flex-container ">
            <form action="/settings/edit" class="form-horizontal ng-pristine ng-valid" enctype="multipart/form-data" id="UserSettingsForm" method="post" accept-charset="utf-8">
                <div class="page-loading-modal" style="color: red; display: none;"><?php echo $this->Html->image('loading-upload.gif'); ?></div>
                <div class="kd-home-display">
                    <div class="col-md-5 kd-custom_width_panel " style="padding-left:0;">
                        <div class="kd-form_info_wrap" style="margin-top: 0;">
                            <div class="kd-title_box">
                                <h3 class="kd-dash_titles">MY PROFILE</h3>
                            </div>
                            <div class="custom_scroll view_setting_scroll">
                                <div class="kd-profile_wrapper kd-white-bg">
                                    <div class="clearfix"></div>
                                    <!--                                    <div>-->
                                    <!--                                        <span class="kd-avatar-left prev"><i class="icons left-icon"></i></span>-->
                                    <!--                                        <span class="kd-avatar-right next"><i class="icons right-icon"></i></span>-->
                                    <!--                                    </div>-->
                                    <div>
                                        <div class="kd-slide ">
                                            <div class='<?php echo ($userImage[1]=='1.svg')? "activeele":"notactive"?>'><?php echo $this->Html->image('1.svg', array('class' => 'kd-img-bg')); ?></div>
                                            <div class='<?php echo ($userImage[1]=='2.svg')? "activeele":"notactive"?>'><?php echo $this->Html->image('2.svg', array('class' => 'kd-img-bg')); ?></div>
                                            <div class='<?php echo ($userImage[1]=='3.svg')? "activeele":"notactive"?>'><?php echo $this->Html->image('3.svg', array('class' => 'kd-img-bg')); ?></div>
                                            <div class='<?php echo ($userImage[1]=='4.svg')? "activeele":"notactive"?>'><?php echo $this->Html->image('4.svg', array('class' => 'kd-img-bg')); ?></div>
                                            <div class='<?php echo ($userImage[1]=='5.svg')? "activeele":"notactive"?>'><?php echo $this->Html->image('5.svg', array('class' => 'kd-img-bg')); ?></div>
                                            <div class='<?php echo ($userImage[1]=='6.svg')? "activeele":"notactive"?>'><?php echo $this->Html->image('6.svg', array('class' => 'kd-img-bg')); ?></div>
                                            <div class='<?php echo ($userImage[1]=='7.svg')? "activeele":"notactive"?>'><?php echo $this->Html->image('7.svg', array('class' => 'kd-img-bg')); ?></div>
                                            <div class='<?php echo ($userImage[1]=='8.svg')? "activeele":"notactive"?>'><?php echo $this->Html->image('8.svg', array('class' => 'kd-img-bg')); ?></div>
                                            <div class='<?php echo ($userImage[1]=='9.svg')? "activeele":"notactive"?>'> <?php echo $this->Html->image('9.svg', array('class' => 'kd-img-bg')); ?></div>
                                        </div>
                                        <!--                                    <ul class="kd-slide">
                                                                                <li class="divControl">
                                        <?php echo $this->Html->image('1.svg', array('class' => 'kd-img-bg '.($userImage[1]=='1.svg')? "activeele":"".'')); ?>
                                                                                </li>
                                                                                <li class="divControl">
                                        <?php echo $this->Html->image('2.svg', array('class' => 'kd-img-bg '.($userImage[1]=='2.svg')? "activeele":"".'')); ?>
                                                                                </li>
                                                                                <li class="divControl">
                                        <?php echo $this->Html->image('3.svg', array('class' => 'kd-img-bg '.($userImage[1]=='3.svg')? "activeele":"".'')); ?>
                                                                                </li>
                                                                                <li>
                                        <?php echo $this->Html->image('4.svg', array('class' => 'kd-img-bg '.($userImage[1]=='4.svg')? "activeele":"".'')); ?>
                                                                                </li class="divControl">
                                                                                <li>
                                        <?php echo $this->Html->image('5.svg', array('class' => 'kd-img-bg '.($userImage[1]=='5.svg')? "activeele":"".'')); ?>
                                                                                </li>
                                                                                <li class="divControl" style="display: none">
                                        <?php echo $this->Html->image('6.svg', array('class' => 'kd-img-bg '.($userImage[1]=='6.svg')? "activeele":"".'')); ?>
                                                                                </li>
                                                                                <li class="divControl" style="display: none">
                                        <?php echo $this->Html->image('7.svg', array('class' => 'kd-img-bg '.($userImage[1]=='7.svg')? "activeele":"".'')); ?>
                                                                                </li>
                                                                                <li class="divControl" style="display: none">
                                        <?php echo $this->Html->image('8.svg', array('class' => 'kd-img-bg '.($userImage[1]=='8.svg')? "activeele":"".'')); ?>
                                                                                </li>
                                                                                <li class="divControl" style="display: none">
                                        <?php echo $this->Html->image('8.svg', array('class' => 'kd-img-bg '.($userImage[1]=='9.svg')? "activeele":"".'')); ?>
                                                                                </li>
                                                                            </ul>-->
                                    </div>
                                </div>
                                <div class=" kd-form_wrapper kd-white-bg" style="padding-top: 15px;">
                                    <div class="form-group">
                                        <div class="col-sm-6" style=" padding: 0 5px 0 15px;">
                                            <legend>Your First Name</legend>
                                            <input name="data[User][first_name]" id="question_title" class="form-control clear-title" placeholder="Your First Name" maxlength="500" type="text" required="required" data-original-title="" title="" value="<?php echo @$kid_info['User']['first_name'] ?>">
                                            <input name="data[User][user_image]" id="user_image" class="form-control clear-title" type="hidden"  value="<?php echo @$kid_info['User']['user_image'] ?>">
                                        </div>
                                        <div class="col-sm-6" style=" padding: 0 15px 0 5px;">
                                            <legend>Your Last Initial</legend>
                                            <input name="data[User][last_name]" id="question_title" class="form-control clear-title" placeholder="Your Last Initial" maxlength="500" type="text" required="required" data-original-title="" title="" value="<?php echo @$kid_info['User']['last_name'] ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <legend>Your Kidpreneur Avatar Name</legend>
                                            <input  id="question_title" class="form-control clear-title" placeholder="Your Kidpreneur Avatar Name" maxlength="500" type="text" required="required" data-original-title="" title="" value="<?php echo @$kid_info['User']['username'] ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <legend>Create a Secret Password</legend>
                                            <input  id="question_title" class="form-control clear-title" placeholder="Create a Secret Password" maxlength="500" required="required" data-original-title="" title="" type="password" readonly value="<?php echo @$kid_info['User']['password'] ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <legend>Responsible Adult (Parent/Educator) name</legend>
                                            <input  id="question_title" class="form-control clear-title" placeholder="Responsible Adult (Parent/Educator) name" maxlength="500" type="text" required="required" data-original-title="" title="" readonly value="<?php  echo $parent_info['first_name'] ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <legend>Responsible Adult (Parent/Educator) email</legend>
                                            <input  id="question_title" class="form-control clear-title" placeholder="Responsible Adult (Parent/Educator) email" maxlength="500" type="text" required="required" data-original-title="" title="" readonly value="<?php echo $parent_info['email_address'] ?>">
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <div class="col-sm-12">
                                            <legend>KBN Code (if applicable)</legend>
                                            <input  id="question_title" class="form-control clear-title " placeholder="KBN Code (if applicable)" maxlength="500" type="text" required="required" data-original-title="" title="" readonly value="<?php echo @$kid_info['UserTeacherProfile']['kbn_number'] ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <legend>My School Name (if entered at registration)</legend>
                                            <input name="data[User][school]" id="question_title" class="form-control clear-title" placeholder="My School Name (if entered at registration)" maxlength="500" type="text" required="required" data-original-title="" title="" readonly value="<?php echo @$kid_info['UserTeacherProfile']['organization'] ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <legend>My Grade</legend>
                                            <input  id="question_title" class="form-control clear-title" placeholder="My Grade" maxlength="500" type="text" required="required" data-original-title="" title="" readonly value="<?php echo @$kid_info['User']['grade'] ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-6" style=" padding: 0px 5px 0px 15px;">
                                            <legend>My Age</legend>
                                            <input name="data[User][age]" id="question_title" class="form-control clear-title" placeholder="My Age" maxlength="500" type="text" required="required" data-original-title="" title="" value="<?php echo @$kid_info['User']['age'] ?>">
                                        </div>
                                        <div class="col-sm-6" style=" padding: 0px 15px 0px 5px;">
                                            <legend>My Gender</legend>
                                            <input   class="form-control clear-title" placeholder="My Gender" maxlength="500" type="text" required="required" data-original-title="" title="" value="<?php echo @$kid_info['User']['gender'] ?>" readonly="readonly">
                                            
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-6 first_name_wrap" style=" padding: 0px 5px 0px 15px;">
                                            <legend>Date of Birth</legend>
                                            <?php pr(@$kid_info["UserTeacherProfile"]);?>
                                            <input  class="form-control calender hasDatepicker"  id="datepicker" placeholder="Date of Birth" autocomplete="off" type="text" required="required" data-original-title="" title="" value="<?php echo date("m/d/y",  strtotime($kid_info["UserTeacherProfile"]["birth_date"]))?>"  readonly="readonly">
                                        </div>
                                        <div class="col-sm-6 last_name_wrap" style=" padding: 0px 15px 0px 5px;">
                                            <legend> Do you live In Australia?</legend>
                                            <!--class="kd-check-form"-->

                                            <div class="col-sm-6" style=" padding: 0px 5px 0px 15px;">
                                                <label class="radio-inline">
                                                    <input type="radio" class="radio-button-function unable-network" name="data[User][is_australian]" value="1" <?php echo (@$kid_info['UserTeacherProfile']['is_australian']) ? "checked" : ""; ?>  style="display:inline-block;" readonly>Yes</label>
                                            </div>
                                            <div class="col-sm-6" style=" padding: 0px 15px 0px 5px;">
                                                <label class="radio-inline"><!-- style="padding-top: 0px;"-->
                                                    <input type="radio" class="radio-button-function unable-network" name="data[User][is_australian]" value="0" <?php echo (!@$kid_info['UserTeacherProfile']['is_australian']) ? "checked" : ""; ?>  style="display:inline-block;" readonly>No</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Start element for edit-->
                    <div id="businessprofile">
                        <?php
                        if($this->params['pass'][0] =="edit"){
                            if ($total_count > 0 ) {
                            echo $this->element('kid_settings_edit_element', array('businessKey' => 0, 'kid_info' => $kid_info));
                        } else {
                            echo $this->element('kid_settings_add_element', array('businessKey' => 0, 'kid_info' => $kid_info));
                        }
                        }else {
                            echo $this->element('kid_settings_add_element', array('businessKey' => 0, 'kid_info' => $kid_info));
                        }
                        
                        ?>
                    </div>
                    <!-- end element for edit-->


            </form>
        </div>
    </div>
<?php } else { ?>

    <!--============ACCOUNT SETTING VIEW MODE================================-->
    
    <?php //pr($students["UserTeacherProfile"]);die;?>
    <div class="middle-container  setting-wrapper  <?php echo (!isset($this->params['pass'][0])) ? "" : "hide"; ?>" style="padding:1.12rem 1.56rem;" ng-app="kidpreneur" ng-controller="settings">
        <div class="kd-middle-flex-container ">
            <form action="/settings/edit" class="form-horizontal ng-pristine ng-valid" enctype="multipart/form-data" id="UserSettingsForm" method="post" accept-charset="utf-8">
                <div class="kd-display-view">
                    <div class="col-md-5 kd-custom_width_panel " style="padding-left:0;">
                        <div class="kd-title_box">
                            <h3 class="kd-dash_titles">MY PROFILE</h3>
                        </div>
                        <div class="kd-form_wrapper custom_scroll view_setting_scroll " style="background-color: white;padding: 15px;">
                            <div class="formview" style="margin-top: -5px;">
                                <div class="form-group">
                                    <div class="col-sm-6">
                                        <label class="control-label" for="">Your First Name</label>
                                        <div class="filled-details" >
                                            {{first_name}}
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="control-label" for="">Your Last Initial</label>
                                        <div class="filled-details">
                                            {{last_name}}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-12" for="">Your Kidpreneur Avatar Name</label>
                                    <div class="col-sm-12">
                                        <div class="filled-details">
                                            {{username}}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group hide">
                                    <label class="control-label col-sm-12" for="">Create a Secret Password</label>
                                    <div class="col-sm-12">
                                        <div class="filled-details">

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-12" for="">Responsible Adult (Parent/Educator) name</label>
                                    <div class="col-sm-12">
                                        <div class="filled-details">
                                            {{adult_name}}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-12" for="">Responsible Adult (Parent/Educator) email</label>
                                    <div class="col-sm-12">
                                        <div class="filled-details">
                                            {{adult_email}}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-12" for="">KBN Code (if applicable)</label>
                                    <div class="col-sm-12">
                                        <div class="filled-details">

                                            {{kbn_code}}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-12" for="">My School Name (if entered at registration)</label>
                                    <div class="col-sm-12">
                                        <div class="filled-details">
                                            {{school_name}}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group hide">
                                    <label class="control-label col-sm-12" for="">My Grade</label>
                                    <div class="col-sm-12">
                                        <div class="filled-details">
                                            {{my_grade}}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-6">
                                        <label class="control-label" for="">My Age</label>
                                        <div class="filled-details">
                                            {{age}}
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="control-label" for="">My Gender</label>
                                        <div class="filled-details">
                                            {{gender}}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-6">
                                        <label class="control-label" for="">Date Of Birth</label>
                                        <div class="filled-details">
                                           <?php echo date("m/d/y",  strtotime($kid_info["UserTeacherProfile"]["birth_date"]))?>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <label class="control-label" for="">Do you live In Australia?</label>
                                        <div class="filled-details" >
                                            {{is_australian}}
                                        </div>
                                    </div>
                                </div>
                            </div> <!--end of from view-->
                        </div>
                    </div> <!--====== end 1st col===-->
                    <?php for ($businessKey = 0; $businessKey < count($kid_info['KidBusinessProfile']); $businessKey++) { ?>
                        <?php echo $this->element('kid_settings_element', array('businessKey' => $businessKey, 'kid_info' => $kid_info)); ?>
                    <?php } ?>
                </div> <!--====== end of kd-display view===-->
            </form>
        </div>
    </div>

<?php } ?>





<script type="text/javascript">

    //*******************Angular Code *********************//

    app.controller("settings", function ($scope) {

        $scope.first_name = "<?php echo $students["User"]["first_name"]; ?>";
        $scope.last_name = "<?php echo $students["User"]["last_name"]; ?>";

        $scope.username = "<?php echo $students["User"]["username"]; ?>";
        $scope.adult_name = "<?php echo $parent_info["first_name"]; ?>";
        $scope.adult_email = "<?php echo $parent_info["email_address"]; ?>";
        $scope.kbn_code = "<?php echo $students["UserTeacherProfile"]["kbn_number"]; ?>";
        $scope.school_name = "<?php echo $students["UserTeacherProfile"]["organization"]; ?>";
        $scope.age = "<?php echo $students["User"]["age"]; ?>";
        $scope.gender = "<?php echo $students["User"]["gender"]; ?>";
        $scope.dob = "<?php echo $students["UserTeacherProfile"]["birth_date"]; ?>";
        $scope.is_australian = "<?php echo ($students["UserTeacherProfile"]["is_australian"] == 0) ? 'No' : 'Yes'; ?>";
        $scope.is_australian = "<?php echo ($students["UserTeacherProfile"]["is_australian"] == 0) ? 'No' : 'Yes'; ?>";


    });

    //*******************Angular Code *********************//


    CKEDITOR.replaceAll();
    function removeElem(counter) {
        $("#TextBoxDiv" + counter).remove();
        manupulateEle();
    }
    function manupulateEle() {
        var counter = $('.business_owner').length;

        if (counter >= 4) {
            $(".st-addup").addClass("hide");
        }
        else {
            $(".st-addup").removeClass("hide")
        }
        // if(counter==1){
        //    $("#addButton").parents('div.mar-icon').removeClass('mar-icon');
        // }
    }
    $("#fileToUploadAdd").on("click", function (e) {
        e.preventDefault();
        console.log($(this))
        var fileName = $(this).attr("data-file");
        var userInfo = {
            submitterFullName: $('#username_logged').val(),
            bussiness_name: $('#business_name').val(),
            uploadDate: new Date(),
            logo: '<?php echo $this->Html->url('/', true); ?>img/500.png'
        }
        businessFormModule.integrateClipchamp(fileName, userInfo);
    });
    jQuery(".btn-default").on('click', function (e) {

        adviceattach.bindUploader(adviceattach.newFile);

    });
    $('.kd-slide').slick({
        dots: false,
        infinite: true,
        speed: 300,
        slidesToShow: 4,
        slidesToScroll: 4,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    infinite: true,
                    dots: true
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
        ]
    });
    $('.kd-slide').slick('slickGoTo',<?php echo ($imageIndexSlide[0]!="")? $imageIndexSlide[0]:0;?>, true);
    //******//
    manupulateEle();

    //***************************//
    //Flip profile
    function flipProfile(eleM, currentKey, totalElem) {
        if ($('#UserSettingsForm').hasClass('form-edited')) {

            bootbox.dialog({
                title: 'Confirmation',
                message: "Are you sure want to cancel?",
                buttons: {
                    noclose: {
                        label: "Yes",
                        className: 'btn-default',
                        callback: function () {

                            $('#UserSettingsForm').removeClass('form-edited');
                            confirmFlip(eleM, currentKey, totalElem);
                        }
                    },
                    ok: {
                        label: "No",
                        className: 'btn-default',
                        callback: function () {
                            //  $('.submit-kidform').trigger('click');

                        }
                    }
                }
            });
        }
        else
        {
            confirmFlip(eleM, currentKey, totalElem);

        }
        //readMore();
    }
    function confirmFlip(eleM, currentKey, totalElem){
        jQuery.ajax({
            type: 'post',
            url: "<?php echo Router::url(array('controller' => 'kidpreneurs', 'action' => 'getBussinessProfile')) ?>",
            data:
                    {
                        'id': currentKey,
                    },
            success: function (data)
            {
                $("#businessprofile").html(data);
                if($("#profile-status").val().toLowerCase()=="save")
                    $("#draft-data").addClass("hide");
                else
                    $("#draft-data").removeClass("hide");
                addButtonEventWrapper();
                changeMode();
                bindUpload();
                var view_setting_scroll = '.view_setting_scroll';
                tableBodyHeight(view_setting_scroll);
                CKEDITOR.replaceAll();
                
                
            }
        })
        for (businessProfileKey = 0; businessProfileKey <= totalElem; businessProfileKey++) {
            $(".bussinessprofile-" + businessProfileKey + "").addClass('hide');
        }
        if (currentKey == totalElem)
            $(".bussinessprofile-0").removeClass("hide");
        else
            $(eleM).next(".bussinessprofile-" + (currentKey + 1) + "").removeClass("hide");
        
        $('#UserSettingsForm').removeClass('form-edited');
        setTimeout(function(){
//            var view_setting_scroll = '.view_setting_scroll';
//        tableBodyHeight(view_setting_scroll);
        changeMode();
        
        },500);
        
    }
    //***************************//

    //***************************//
    bindUpload();
    function bindUpload() {
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
                        var attach_image_obj = $(this);
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

                                    var name_variable = attach_image_obj.data('actual');
                                    var data_type = attach_image_obj.data('type');
                                    for (i = 0; i < resp.length; i++) {

                                        var fileType = resp[i].type;
                                        var fileName = resp[i].source;
                                        var filePath = resp[i].path;
                                        var attachId = resp[i].attachmentId;
                                        if (data_type == 'product_gallery')
                                        {
                                            var name_val = 'data[KidProductGallery]' + name_variable;
                                        }
                                        else if (data_type == 'other_gallery')
                                        {
                                            var name_val = 'data[KidProductGallery]' + name_variable;
                                        }
                                        else {
                                            var name_val = 'data[KidBusinessProfile][' + name_variable + ']';
                                        }




                                        //  alert(fileType + '~' + fileName + '~' + filePath);
                                        var orgfilePath = filePath.replace("thumb_", "");
                                        var imgPath = '<img src="<?php echo $this->Html->url('/', true); ?>' + filePath + '">';
                                        var str = '<div class="img-section row-wrap">' + imgPath + '<input type="hidden" name = "' + name_val + '" value= "' + filePath + '"></div>';


                                        attach_image_obj.next().html(str);
                                        $('#UserSettingsForm').addClass('form-edited');


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
    }
    function maintainRemoveButton(){
    $(".removeButton").click(function () {
            var counter = $('.business_owner').length;
           
            if(counter==1){
                alert("No more textbox to remove");
                return false;
            }
            $("#TextBoxDiv" + counter).remove();

            counter--;

        });
}
    function addNewBusiness() {
        jQuery.ajax({
            type: 'post',
            url: "<?php echo Router::url(array('controller' => 'kidpreneurs', 'action' => 'addBussinessProfile')) ?>",
            success: function (data)
            {

                $("#businessprofile").html(data);
                $("#draft-data").removeClass("hide");
                $(".profile_rating img").attr('src',$(".activeele img").attr("src"));
                maintainRemoveButton();
                CKEDITOR.replaceAll();
                changeMode();
                bindUpload();
                $(".addButton").click(function () {
                    var counter = $('.business_owner').length;

                    var newTextBoxDiv = $(document.createElement('div'))
                            .attr({"id": 'TextBoxDiv' + counter, "class": "kk-position"});

                    newTextBoxDiv.after('<input type="text" name="data[KidBusinessOwner][kid_business_owner_id][' + counter + ']" maxlength="100"  id="textbox' + counter + '" value="" />').html('<input type="text" name="data[KidBusinessOwner][business_owner][' + counter + ']" id="textbox' + counter + '" class="form-control box-padding business_owner" maxlength="100" value="" /> <input type="hidden" name="data[KidBusinessOwner][kid_business_owner_id][' + counter + ']"  class="form-control box-padding " value="" /> <a class="set_addup"><i class="fa fa-minus-circle removeButton" id="removeButton" onclick="removeElem(' + counter + ')"></i></a>');


                    newTextBoxDiv.appendTo("#TextBoxesGroup");
                    newTextBoxDiv.appendTo("#reflectminus");
                    maintainRemoveButton();
                    manupulateEle();
                    counter++;
                });
                $("#fileToUploadAdd").on("click", function (e) {
                    e.preventDefault();
                    console.log($(this))
                    var fileName = $(this).attr("data-file");
                    var userInfo = {
                        submitterFullName: $('#username_logged').val(),
                        bussiness_name: ($('#business_name').val() == "") ? "Business name" : $('#business_name').val(),
                        uploadDate: new Date(),
                        logo: '<?php echo $this->Html->url('/', true); ?>img/500.png'
                    }
                    businessFormModule.integrateClipchamp(fileName, userInfo);
                });
                jQuery(".btn-default").on('click', function (e) {

                    adviceattach.bindUploader(adviceattach.newFile);

                });
                var view_setting_scroll = '.view_setting_scroll';
                tableBodyHeight(view_setting_scroll);
            }
        })

    }
    //***************************//
    addButtonEventWrapper();
    function addButtonEventWrapper() {
        $(".addButton").click(function () {
            
            var counter = $('.business_owner').length;

            var newTextBoxDiv = $(document.createElement('div'))
                    .attr({"id": 'TextBoxDiv' + counter, "class": "kk-position"});

            newTextBoxDiv.after('<input type="text" name="data[KidBusinessOwner][kid_business_owner_id][' + counter + ']" maxlength="100"  id="textbox' + counter + '" value="" />').html('<input type="text" name="data[KidBusinessOwner][business_owner][' + counter + ']" id="textbox' + counter + '" class="form-control box-padding business_owner" maxlength="100" value="" /> <input type="hidden" name="data[KidBusinessOwner][kid_business_owner_id][' + counter + ']"  class="form-control box-padding " value="" /> <a class="set_addup"><i class="fa fa-minus-circle removeButton" id="removeButton" onclick="removeElem(' + counter + ')"></i></a>');


            newTextBoxDiv.appendTo("#TextBoxesGroup");
            newTextBoxDiv.appendTo("#reflectminus");
            maintainRemoveButton();
            manupulateEle();
            //$(this).parents("div#iconclass").addClass('mar-icon');
            
            counter++;
        });

        $(".removeButton").click(function () {
            var counter = $('.business_owner').length;

            if (counter == 1) {
                alert("No more textbox to remove");
                return false;
            }
            $("#TextBoxDiv" + counter).remove();

            counter--;

        });
    }
    readMore();
    function readMore() {
        $('body').on("click", "a.btn-readmorestuff", function (event) {
            //alert('fdfs')

            var $this = $(this),
                    target = $this.prev(".person-content.full-data");
            //console.log(target);


            if ($this.hasClass('expanded')) {
                target.addClass('hide');
                //alert("df");

                target.prev('.short-data').removeClass('hide');
                $this.removeClass('expanded').text("Read more");
            } else {
                //alert("hhh");
                target.prev('.short-data').addClass('hide');

                target.removeClass('hide'); //
                //console.log($this);    
                $this.addClass('expanded').text("Read less");
            }

            event.preventDefault();
            containerHeight('.containerHeight');
            customScroll();

        });
    }

    //**************//
    $(document).ready(function () {
        
        //*****************hide show draft button *****************//
        <?php if(isset($this->params['pass'][0])){?>
        if($("#profile-status").val()=="save")
                    $("#draft-data").addClass("hide");
                else
                    $("#draft-data").removeClass("hide");
        <?php }?>
        //********************************************************//
        //********slider script**************//
        $(".kd-img-bg").each(function () {
            
            $(this).click(function () {
                $(".kd-img-bg").parent('div').removeClass("activeele");
                $("#user_image").val(($(this)[0].src));
                $(".profile_rating img").attr('src',$(this)[0].src)
                $(this).parent('div').addClass("activeele");
            })
        })
        manupulateEle();
        $("#deactivate-user").click(function () {
            bootbox.confirm("Are you sure you want to deactivate your account?", function (result) {
                if (result) {
                    var userId = jQuery("#deactivate-div").data("id");
                    jQuery.ajax({
                        type: 'post',
                        url: "<?php echo Router::url(array('controller' => 'users', 'action' => 'deactivated')) ?>",
                        data:
                                {
                                    'id': userId,
                                },
                        success: function (msg)
                        {
                            if (msg == 'ok') {
                                bootbox.dialog({
                                    title: "Alert",
                                    message: 'YOUR ENTROPOLIS ACCOUNT IS NOW DEACTIVATED. SORRY TO SEE YOU GO. IF YOU WOULD LIKE TO REACTIVATE YOUR ACCOUNT IN THE FUTURE',
                                    onEscape: function () {
                                        window.location = '<?php echo Router::url(array('controller' => '/')) ?>';
                                    }
                                });
//                                bootbox.alert({
//                                    message: 'YOUR TREPICITY ACCOUNT IS NOW DEACTIVATED. SORRY TO SEE YOU GO. IF YOU WOULD LIKE TO REACTIVATE YOUR ACCOUNT IN THE FUTURE',
//                                    callback: function () { //your callback code 
//                                        window.location = '<?php echo Router::url(array('controller' => '/')) ?>';
//                                    },
//                                });
                            }
                        }
                    })
                }
            });
        });
    });


    var view_setting_scroll = '.view_setting_scroll';
    tableBodyHeight(view_setting_scroll);

    function cancelAddNewBusiness(mode) {
    if(typeof mode != "undefined" && mode=="edit"){
        url="<?php echo Router::url(array('controller' => 'kidpreneurs', 'action' => 'settings')) ?>";
    }
    else
       url="<?php echo Router::url(array('controller' => 'kidpreneurs', 'action' => 'settings', 'edit')) ?>";
    if ($('#UserSettingsForm').hasClass('form-edited')) {

            bootbox.dialog({
                title: 'Confirmation',
                message: "Are you sure want to cancel?",
                buttons: {
                    noclose: {
                        label: "Yes",
                        className: 'btn-default',
                        callback: function () {

                            $('#UserSettingsForm').removeClass('form-edited');
                            window.location = url;
                        }
                    },
                    ok: {
                        label: "No",
                        className: 'btn-default',
                        callback: function () {
                            //  $('.submit-kidform').trigger('click');

                        }
                    }
                }
            });
        }
        else
        {
           window.location = url;

        }
        
    }
    changeMode();
    function changeMode() {
        if (typeof CKEDITOR.instances['about_business'] != "undefined") {
            CKEDITOR.instances['about_business'].on('change', function () {

                $('#UserSettingsForm').addClass('form-edited');
            });
        }

        if (typeof CKEDITOR.instances['mission'] != "undefined") {
            CKEDITOR.instances['mission'].on('change', function () {

                $('#UserSettingsForm').addClass('form-edited');
            });
        }

        if (typeof CKEDITOR.instances['vision_goal'] != "undefined") {
            CKEDITOR.instances['vision_goal'].on('change', function () {

                $('#UserSettingsForm').addClass('form-edited');
            });
        }

        if (typeof CKEDITOR.instances['revenue'] != "undefined") {
            CKEDITOR.instances['revenue'].on('change', function () {

                $('#UserSettingsForm').addClass('form-edited');
            });
        }

        if (typeof CKEDITOR.instances['donated'] != "undefined") {
            CKEDITOR.instances['donated'].on('change', function () {

                $('#UserSettingsForm').addClass('form-edited');
            });
        }
    }

    $('body').on('click', '.save_add_business_profile', function () {
        var $this = $(this);
        var $returnVar=true;
        
        var data_event = $this.data('event');
        var data_page = $this.data('page');

        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }
        var datas = $('#UserSettingsForm').serialize();
        

        //if()
        //var data_gallery =$('#SaveGalleryFlyin').serialize();  
        $('#UserSettingsForm .error-message').remove();
        $('#UserSettingsForm .error-message').remove();
        datas = datas+ '&data_event=' + data_event;
        $('.page-loading-modal').show();
        jQuery.ajax({
            type: 'POST',
            url: '<?php echo $this->webroot ?>kidpreneurs/saveBusinessProfileData/',
            'data': datas,
            'success': function (data)
            {

                $('.page-loading-modal').hide();
                
                 var count_cc = 0;
                    $(".gallery_required").each(function () {

                        if ($(this).val() == '')
                        {

                            count_cc = count_cc + 1;
                        }
                        else {
                            count_cc = 0;

                        }
                    });

                    if (count_cc == '6')
                    {
                        $('.required-product-gallery').after('<div class="error-message">Atleast one image is required </div>');
                       
                    }
                
                //alert(data.result);
                if (data.result == "error") {

                    if (data.error_msg.founded_year !== undefined && data.error_msg.founded_year[0] != '') {
                        $("#foundedyear").after('<div class="error-message">' + data.error_msg.founded_year[0] + '</div>');
                    }
                    if (data.error_msg.start_up !== undefined && data.error_msg.start_up[0] != '') {
                        $("#start_up").after('<div class="error-message">' + data.error_msg.start_up[0] + '</span>');
                    }
                    if (data.error_msg.business_name !== undefined && data.error_msg.business_name[0] != '') {
                        $("#business_name").after('<div class="error-message">' + data.error_msg.business_name[0] + '</div>');
                    }
                    if (data.error_msg.business_owner !== undefined && data.error_msg.business_owner[0] != '') {
                        $("#business_owner").after('<div class="error-message">' + data.error_msg.business_owner[0] + '</div>');
                    }

                    if (data.error_msg.product_image !== undefined && data.error_msg.product_image[0] != '') {
                        $("#hidden_product").append('<div class="error-message">' + data.error_msg.product_image[0] + '</div>');
                    }
                    if (data.error_msg.logo_image !== undefined && data.error_msg.logo_image[0] != '') {
                        $("#hidden_logo").after('<div class="error-message">' + data.error_msg.logo_image[0] + '</div>');
                    }


                    if (data.error_msg.about_business !== undefined && data.error_msg.about_business[0] != '') {
                        $("#cke_about_business").after('<div class="error-message">' + data.error_msg.about_business[0] + '</div>');
                    }
                    if (data.error_msg.mission !== undefined && data.error_msg.mission[0] != '') {
                        $("#cke_mission").after('<div class="error-message">' + data.error_msg.mission[0] + '</div>');
                    }
                    if (data.error_msg.vision_goal !== undefined && data.error_msg.vision_goal[0] != '') {
                        $("#cke_vision_goal").after('<div class="error-message">' + data.error_msg.vision_goal[0] + '</div>');
                    }

                    if (data.error_msg.revenue !== undefined && data.error_msg.revenue[0] != '') {
                        $("#cke_revenue").after('<div class="error-message">' + data.error_msg.revenue[0] + '</div>');
                    }

                    if (data.error_msg.donated !== undefined && data.error_msg.donated[0] != '') {
                        $("#cke_donated").after('<div class="error-message">' + data.error_msg.donated[0] + '</div>');
                    }
                    if (data.error_msg.feature_benefit !== undefined && data.error_msg.feature_benefit[0] != '') {
                        $("#cke_feature_benefit").after('<div class="error-message">' + data.error_msg.feature_benefit[0] + '</div>');
                    }
                    if (data.error_msg.business_website !== undefined && data.error_msg.business_website[0] != '') {
                        $("#business_website").after('<div class="error-message">' + data.error_msg.business_website[0] + '</div>');
                    }
                    if (data.error_msg.pitch_video_id !== undefined && data.error_msg.pitch_video_id[0] != '') {
                        $(".pitch_video_scetion").after('<div class="error-message">' + data.error_msg.pitch_video_id[0] + '</div>');
                    }
                    //  $('.pitch_video_scetion').after('<div class="error-message">Please upload business pitch video </div>');



                }
                else if (data.result == "success")
                {


                    bootbox.dialog({
                        title: data.success_message.title,
                        message: data.success_message.msg,
                        buttons: {
                            noclose: {
                                label: "OK",
                                className: 'btn-default',
                                callback: function () {
                                    window.location="<?php echo Router::url(array('controller' => 'kidpreneurs', 'action' => 'settings')) ?>";
                                    

                                }
                            },
                        }
                    });

                    var biz_ids = data.success_message.total_value;
                    var total_count = data.success_message.total_count;
                    if (total_count == 3)
                    {
                        //alert('dsad')
                        $('.add_new_business').addClass('disabled');
                    }
                    else if (total_count == 1)
                    {
                        $('.view_business_profile').removeClass('disabled');
                        $('.view_business_profile').data('id', data.success_message.kid_business_profile_id);
                        $('.view_business_profile_layout').data('action', 'View');
                        $('.view_business_profile_layout').data('id', data.success_message.kid_business_profile_id);
                    }

                    var html_data = manageBusinessLink(biz_ids, total_count);
                    $('.add_kid_biz').html(html_data);


                }

                else if (data.result == "count")
                {
                    bootbox.dialog({
                        title: 'Alert Message',
                        message: data.error_msg,
                        buttons: {
                            noclose: {
                                label: "OK",
                                className: 'btn-default',
                                callback: function () {
                                    
                                    $('#UserSettingsForm').removeClass('form-edited');

                                }
                            },
                        }
                    });
                }
            }
        });


    });
    //# sourceURL=settings.ctpjs
</script>