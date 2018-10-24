
<?php
$youtubeUrl = $cityGuide['Cityguide']['video_url'];
$urlArr = explode("v=", $youtubeUrl);
$youtubeEmbedUrl = 'https://www.youtube.com/embed/' . $urlArr[1] . '?rel=0&amp;amp;enablejsapi=1&amp;amp;autoplay=0';
?>
<input type="hidden" id="videourl" value="<?php echo $youtubeEmbedUrl ?>">                    

<script type="text/javascript">
    $(document).ready(function () {


        jQuery('body').on('click', '.video-modal', function (e) {

            var videurl = $(this).data('url');

            var src = videurl;
            $('#video-pop').attr('src', src);


        });
        jQuery('body').on('click', '.close-video-button', function (e) {


            var src = $('#video-pop').attr('src');
            $('#video-pop').attr('src', '');
// $('#video').attr('src', src); 

        });

    });


</script>

<?php
$noclass = "col-md-6";
$class = "col-md-6";
?>


<div id="bgvid">

</div>
<?php echo $this->Form->create('Cityguide', array('name' => 'EditCityGuide', 'type' => 'file', 'enctype' => 'multipart/form-data', 'id' => 'EditCityGuide', 'novalidate')); ?>

<input type="hidden" id="cityimage1" value="<?php echo $cityGuide['Cityguide']['city_guide_image1']; ?>">
<input type="hidden" id="cityimage2" value="<?php echo $cityGuide['Cityguide']['city_guide_image2']; ?>">

<div id="polina">
    <div class="col-md-10 content-wraaper contentFullWidthContainer">
        <div class="sage-dash-wrap full-wrap">
            <div class="title dashboard-title fixed-ipad-top">
                <h2 class="main_title toolkit_title ">
                    <div class="col-md-9 padding_zero"><i class="icons city-guide-title-icon fl"></i><span> Tutorials</span> </div>
                    <div class="col-md-3 padding_zero">
                        <div class="pageAction_btn">
                            <button type="btn" class="btn right">Cancel</button>
                            <button type="btn" class="btn right">Save</button>

                        </div>
                    </div>
                </h2>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="title_text">
                        <div class="form-group margin-bottom-zero page_desc_text">
                            <?php echo $this->form->input('Cityguide.city_guide_title', array('class' => 'form-control', 'placeholder' => 'Title', 'label' => false, 'div' => false, 'value' => html_entity_decode($cityGuide['Cityguide']['city_guide_title'], ENT_QUOTES | ENT_IGNORE, "UTF-8"))); ?> 
                        </div>
                    </div>                
                </div>
            </div>
            <div class="city-guide-video margin_to_15">

          <!--   <iframe id="video" width="100%" height="100%" type="text/html" frameborder="0" allowfullscreen="" src="http://www.youtube.com/embed/IaszbI9txPM?rel=0&amp;amp;enablejsapi=1&amp;amp;"></iframe> -->

                <?php
                $youtubeUrl = $cityGuide['Cityguide']['video_url'];
                if (strpos($youtubeUrl, "v=") != false) {
                    $urlArr = explode("v=", $youtubeUrl);
                    $yId = $urlArr[1];
                } else {
                    $urlArr = explode("/", $youtubeUrl);
                    $yId = $urlArr[count($urlArr) - 1];
                }
                $youtubeEmbedUrl = 'https://www.youtube.com/embed/' . $yId . '?rel=0&amp;amp;enablejsapi=1&amp;amp;autoplay=0';
                ?>

                <iframe width="100%" height="100%" src="<?php echo $youtubeEmbedUrl; ?>" frameborder="0" allowfullscreen></iframe>

                <div class="form-group">
                    <?php echo $this->form->input('Cityguide.video_url', array('class' => 'form-control city_guide_edit_video', 'placeholder' => 'Enter URL', 'label' => false, 'div' => false, 'value' => $cityGuide['Cityguide']['video_url'])); ?>
                </div>
                <a href="#popover-box" class="video-modal" data-toggle="modal">INTRODUCTION VIDEO</a>            
            </div>
            <div class="mid-seprator"></div>
            <div class="clr"></div>
            <div class="title dashboard-title">
                <h2 class="main_title whats_new"><span> WHAT'S NEW </span></h2>
            </div>

            <!-------New Layout--------->
            <div class="row">
                <input type="hidden" value="<?php echo $cityGuide['Cityguide']['id']; ?>" name="cityguide_id">
                <?php for ($video = 1; $video < 9; $video++) { ?>
                    <div class="col-md-6">
                        <!--Title-->
                        <div class="form-group margin-bottom-zero page_desc_text">
                            <input type="text" name="city_guide_title[]"  class="form-control" value="<?php echo html_entity_decode($cityGuide['CityguideVideo'][$video - 1]['city_guide_title'], ENT_QUOTES | ENT_IGNORE, "UTF-8") ?>" placeholder="Title">  

                        </div>
                        <!--Video-->
                        <div class="city-guide-video margin_to_15">
                            <?php
                            $youtubeUrl = $cityGuide['CityguideVideo'][$video - 1]['video_url'];
                            if (strpos($youtubeUrl, "v=") != false) {
                                $urlArr = explode("v=", $youtubeUrl);
                                $yId = $urlArr[1];
                            } else {
                                $urlArr = explode("/", $youtubeUrl);
                                $yId = $urlArr[count($urlArr) - 1];
                            }
                            $youtubeEmbedUrl = 'https://www.youtube.com/embed/' . $yId . '?rel=0&amp;amp;enablejsapi=1&amp;amp;autoplay=0';
                            ?>

                            <iframe width="100%" height="100%" src="<?php echo $youtubeEmbedUrl; ?>" frameborder="0" allowfullscreen></iframe>

                            <div class="form-group">
                                <input type="text" name="video_url[]"  class="form-control city_guide_edit_video" value="<?php echo $cityGuide['CityguideVideo'][$video - 1]['video_url']; ?>" placeholder="Enter URL"> 
                            </div>
                            <a href="#popover-box" class="video-modal" data-toggle="modal" data-url="<?php echo $youtubeEmbedUrl; ?>">INTRODUCTION VIDEO </a>
                        </div>

                    </div>
                    <?php
                    if ($video % 2 == 0) {
                        ?></div>
                    <div class="row">
                        <?php
                    }
                }
                ?>
            </div>

            <!-------New Layout Ends here--------->


        </div>
    </div>
    <div class="modal fade" id="popover-box" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" src="">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close close-video-button" data-dismiss="modal"><i class="icons close-icon"></i></button>        
                </div>
                <div class="modal-body">
                    <iframe  id="video-pop"  width="700" height="398" frameborder="0" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
    
    
</div>
<?php echo $this->Form->end(); ?>


<?php
echo $this->Html->script('jquery.validate');
echo $this->Html->script('additional-methods');
?>
<script type="text/javascript">
    $.validator.addMethod('filesize', function (value, element, param) {
        // param = size (in bytes) 
        // element = element to validate (<input>)
        // value = value of the element (file name)
        return this.optional(element) || (element.files[0].size <= param)
    }, "File size must be less than 2MB");



    var validator = $("#EditCityGuide").validate({
        errorClass: 'selected-error-fields',
        rules: {
            "data[Cityguide][video_url]": {
                required: true,
                url: true
            },
            "data[Cityguide][video_url1]": {
                required: true,
                url: true
            },
            "data[Cityguide][video_url2]": {
                required: true,
                url: true
            },
            "data[Cityguide][video_url3]": {
                required: true,
                url: true
            },
            "data[Cityguide][video_url4]": {
                required: true,
                url: true
            },
            "data[Cityguide][video_url5]": {
                required: true,
                url: true
            },
            "data[Cityguide][video_url6]": {
                required: true,
                url: true
            },
            "data[Cityguide][video_url7]": {
                required: true,
                url: true
            }

        },
        submitHandler: function (form) {
            var datas = $('#EditCityGuide')[0];
            var formData = new FormData(datas);

            jQuery.ajax({
                'type': 'POST',
                'url': '<?php echo Router::url(array('controller' => 'cityGuides', 'action' => 'saveCityGuide')); ?>',
                'data': formData,
                enctype: 'multipart/form-data',
                processData: false, // tell jQuery not to process the data
                contentType: false,
                'success': function (data)
                {
                    if (data.result == "success") {
                        window.location = "<?php echo Router::url(array('controller' => 'cityGuides', 'action' => 'index')) ?>";
                    }
                }
            });
        }

    });

//# sourceURL=CityGuidesedit.js
</script>

