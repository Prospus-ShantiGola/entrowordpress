
<script type="text/javascript">
    $(document).ready(function () {


        jQuery('body').on('click', '.video-modal', function (e) {


            var src = 'https://www.youtube.com/embed/ePa5425NcZA?rel=0&amp;amp;enablejsapi=1&amp;amp;autoplay=1';
            $('#video-pop').attr('src', src);
// $('#video').attr('src', src); 

        });
        jQuery('body').on('click', '.close-video-button', function (e) {


            var src = $('#video-pop').attr('src');
            $('#video-pop').attr('src', '');
// $('#video').attr('src', src); 

        });

    });


</script>
<div id="bgvid">

</div>
<div id="polina">
    <div class="col-md-10 content-wraaper contentFullWidthContainer">
        <div class="sage-dash-wrap full-wrap">
            <div class="title dashboard-title">
                <h2 class="main_title title dashboard-title toolkit_title">
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
                            <input type="text" class="form-control" name=""  />
                        </div>
                    </div>                
                </div>
            </div>
            <div class="city-guide-video margin_to_15">

          <!--   <iframe id="video" width="100%" height="100%" type="text/html" frameborder="0" allowfullscreen="" src="http://www.youtube.com/embed/IaszbI9txPM?rel=0&amp;amp;enablejsapi=1&amp;amp;"></iframe> -->

                <iframe width="100%" height="100%" src="https://www.youtube.com/embed/XJlJ1y7ez64?rel=0&amp;amp;enablejsapi=1&amp;amp;autoplay=0" frameborder="0" allowfullscreen></iframe>

                <div class="form-group">
                    <input type="text" class="form-control city_guide_edit_video" placeholder="Enter URL" />
                </div>
                <a href="#popover-box" class="video-modal" data-toggle="modal">INTRODUCTION VIDEO</a>            
            </div>
            <div class="mid-seprator"></div>
            <div class="clr"></div>
            <div class="title dashboard-title">
                <h2 class="main_title"><span> WHAT'S NEW </span></h2>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="hover-effect">
                        <div class="project-img-wrap">
                            <?php echo $this->Html->image('city_guide_dummy.jpg', array('alt' => 'entopolis')); ?>
                        </div>
                        <div class="hoverText">
                            <div class="view-case-btn-wrap">
                                <div class="align-center">
                                    <div class="more-news">
                                        <a  class="city-btn" href="#enlarge-ppup1" data-toggle="modal"><?php echo $this->Html->image('clicktoenlarge.png', array('alt' => 'entopolis')); ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="file" class="filestyle" />
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="hover-effect">
                        <div class="project-img-wrap">
                            <?php echo $this->Html->image('DEMO Visuals ASK-sm.jpg', array('alt' => 'entopolis')); ?>
                        </div>
                        <div class="hoverText">
                            <div class="view-case-btn-wrap">
                                <div class="align-center">
                                    <div class="more-news">
                                        <a class="city-btn" href="#enlarge-ppup" data-toggle="modal"><?php echo $this->Html->image('clicktoenlarge.png', array('alt' => 'entopolis')); ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="file" class="filestyle" />
                    </div>
                </div>
            </div>        
            <div class="mid-seprator"></div>
            <div class="home-display row">
                <div class="col-md-6">
                    <div class="title dashboard-title">
                        <div class="form-group margin-bottom-zero grey_heading">
                            <input type="text" class="form-control" name="" placeholder="Title" />
                        </div>
                    </div>
                    <div class="form-group margin-bottom-zero title_description">
                        <textarea type="text" class="form-control" name="" rows="6" placeholder="Description"></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="title dashboard-title">
                        <div class="form-group margin-bottom-zero grey_heading">
                            <input type="text" class="form-control" name="" placeholder="Title" />
                        </div>
                    </div>
                    <div class="form-group margin-bottom-zero title_description">
                        <textarea type="text" class="form-control" name="" rows="6" placeholder="Description"></textarea>
                    </div>
                </div>
            </div>
            <div class="mid-seprator"></div>
            <div class="row">
                <div class="col-md-6">
                    <div class="title dashboard-title">
                        <div class="form-group margin-bottom-zero grey_heading">
                            <input type="text" class="form-control" name="" placeholder="Title" />
                        </div>
                    </div>
                    <div class="form-group title_description">
                        <textarea type="text" class="form-control" name="" rows="6" placeholder="Description"></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="title dashboard-title">
                        <div class="form-group margin-bottom-zero grey_heading">
                            <input type="text" class="form-control" name="" placeholder="Title" />
                        </div>
                    </div>
                    <div class="form-group title_description">
                        <textarea type="text" class="form-control" name="" rows="6" placeholder="Description"></textarea>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- http://www.youtube.com/embed/IaszbI9txPM?rel=0&amp;amp;enablejsapi=1&amp;amp;autoplay=1-->
    <div class="modal fade" id="popover-box" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" src="">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close close-video-button" data-dismiss="modal"><i class="icons close-icon"></i></button>        
                </div>
                <div class="modal-body">
                    <!-- <iframe id="video-pop" width="700" height="398" type="text/html" frameborder="0" allowfullscreen="" src="http://www.youtube.com/embed/IaszbI9txPM?rel=0&amp;amp;enablejsapi=1&amp;amp;autoplay=1"></iframe> -->
                    <!-- src="https://www.youtube.com/embed/ePa5425NcZA?rel=0&amp;amp;enablejsapi=1&amp;amp;autoplay=0"-->
                    <iframe  id="video-pop"  width="700" height="398" frameborder="0" allowfullscreen></iframe>
                    <!-- <div class="popover-wrap">
                    <h1>Welcome to ENTROPOLIS!</h1>
                      <p>Hello Citizen, great to see you in Entropolis! We want you to be able to get down to business asap so if you need to know how to navigate through the city and get the most out of your time here watch and read on …</p>
                      <div class="popover-bottom">
                          <button class="btn btn-orange-small margin-top-small large">CITY|GUIDE</button>
                          <button class="btn btn-orange-small margin-top-small large close-video-button" data-dismiss="modal">No Thanks</button>
                      </div> 
                  </div>-->
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade large-images" id="enlarge-ppup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close close-video-button-pop" data-dismiss="modal"><i class="icons close-icon"></i></button>        
                </div>
                <div class="modal-body">
                    <?php echo $this->Html->image('DEMO-Visuals-ASK.jpg', array('alt' => 'entopolis')); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade large-images" id="enlarge-ppup1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close close-video-button-pop" data-dismiss="modal"><i class="icons close-icon"></i></button>        
                </div>
                <div class="modal-body">
                    <?php echo $this->Html->image('city_guide_dummy.jpg', array('alt' => '')); ?>
                </div>
            </div>
        </div>
    </div>
</div>