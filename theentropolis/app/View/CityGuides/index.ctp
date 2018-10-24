
<?php $youtubeUrl=$cityGuide['Cityguide']['video_url'];
    $urlArr=explode("v=",$youtubeUrl);
    $youtubeEmbedUrl='https://www.youtube.com/embed/'.$urlArr[1].'?rel=0&amp;amp;enablejsapi=1&amp;amp;autoplay=0';
    ?>
 <input type="hidden" id="videourl" value="<?php echo $youtubeEmbedUrl?>">                    

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


<?php $class = 'col-md-6';
     if(!empty($cityGuide['Cityguide']['city_guide_title2']) && empty($cityGuide['Cityguide']['city_guide_title3']) ){
         $class = "col-md-12"; 
     }
     else if (empty($cityGuide['Cityguide']['city_guide_title2']) && !empty($cityGuide['Cityguide']['city_guide_title3'])){
         $class = "col-md-12"; 
     }
     else {
        $class = 'col-md-6';
     }

    if(empty($cityGuide['Cityguide']['city_guide_title4']) && !empty($cityGuide['Cityguide']['city_guide_title5'])){
        $noclass = "col-md-12";   
    }
    else if(!empty($cityGuide['Cityguide']['city_guide_title4']) && empty($cityGuide['Cityguide']['city_guide_title5']) ){
        $noclass = "col-md-12";
    }
    else {
        $noclass = "col-md-6";
    }
    
    
?>


<div id="bgvid">

</div>
<div id="polina">
    <div class="col-md-10 content-wraaper contentFullWidthContainer">
        <div class="sage-dash-wrap full-wrap">
            <div class="title dashboard-title fixed-ipad-top" id="city-main_flex">
                <h2 class="main_title toolkit_title" id="city-mani_flex">
                    <div class="col-md-9 padding_zero"><i class="icons city-guide-title-icon fl"></i><span> Tutorials</span> </div>
                </h2>
                  <ul class="demo-quicklink ">
                            <li><a href="<?php echo Router::url(array('controller' => 'EmergencyServices', 'action' => 'index')) ?> " target= "_blank" class="disabled">FAQ</a></li>
                            <li>|</li>
                            <li><a href="<?= $this->webroot ?>pdf/citizen code expanded version_2017-12 update.pdf" target="_blank" class="">CITIZEN CODE</a></li>
                            <li>|</li>
                            <li><a href="<?= $this->webroot ?>pdf/entrepo_manifesto_2017-12 update.pdf" class="" target="_blank">MENIFESTO</a></li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="title_text">
                        <p><?php echo html_entity_decode($cityGuide['Cityguide']['city_guide_title']);?></p>
                    </div>                
                </div>
            </div>
            <div class="city-guide-video margin_to_15">

          <!--   <iframe id="video" width="100%" height="100%" type="text/html" frameborder="0" allowfullscreen="" src="http://www.youtube.com/embed/IaszbI9txPM?rel=0&amp;amp;enablejsapi=1&amp;amp;"></iframe> -->
                <?php $youtubeUrl=$cityGuide['Cityguide']['video_url'];
                    if(strpos($youtubeUrl,"v=") != false){
                    $urlArr=explode("v=",$youtubeUrl);
                    $yId=$urlArr[1];
                }
                else{
                    $urlArr=explode("/",$youtubeUrl);
                    $yId=$urlArr[count($urlArr)-1];
                }
                    $youtubeEmbedUrl='https://www.youtube.com/embed/'.$yId.'?rel=0&amp;amp;enablejsapi=1&amp;amp;autoplay=0';
                    ?>
                <iframe width="100%" height="100%" src="<?php echo $youtubeEmbedUrl;?>" frameborder="0" allowfullscreen></iframe>

                <a href="#popover-box" class="video-modal" data-toggle="modal">INTRODUCTION VIDEO</a>            
            </div>
            <div class="mid-seprator"></div>
            <div class="clr"></div>
            <div class="title dashboard-title">
                <h2 class="main_title"><span> WHAT'S NEW </span></h2>
            </div>

            <!-------------New Layout------------>
            <div class="row">
                 <?php for ($video = 1; $video < 9; $video++) {
                     if(trim($cityGuide['CityguideVideo'][$video - 1]['city_guide_title']) !="" || trim($cityGuide['CityguideVideo'][$video - 1]['video_url']) !=""){?>
                <div class="col-md-6">
                    <!--Title-->
                    <div class="title_text">
                    <p><?php echo html_entity_decode($cityGuide['CityguideVideo'][$video - 1]['city_guide_title']);?></p>
                    </div>
                    <!--Video-->
                    <div class="city-guide-video margin_to_15">

                        <?php $youtubeUrl=$cityGuide['CityguideVideo'][$video - 1]['video_url'];
                        if(strpos($youtubeUrl,"v=") != false){
                            $urlArr=explode("v=",$youtubeUrl);
                            $yId=$urlArr[1];
                        }
                        else{
                            $urlArr=explode("/",$youtubeUrl);
                            $yId=$urlArr[count($urlArr)-1];
                        }
                        $youtubeEmbedUrl='https://www.youtube.com/embed/'.$yId.'?rel=0&amp;amp;enablejsapi=1&amp;amp;autoplay=0';
                        ?>
                        <iframe width="100%" height="100%" src="<?php echo $youtubeEmbedUrl;?>" frameborder="0" allowfullscreen></iframe>

                        <a href="#popover-box" class="video-modal" data-toggle="modal" data-url="<?php echo $youtubeEmbedUrl; ?>">INTRODUCTION VIDEO</a>
                    </div>

                </div>
                <?php
                    if ($video % 2 == 0) {
                        ?></div>
                    <div class="row">
                        <?php
                    }
                     }
                }
                ?>
            </div>

            <!-------New Layout Ends here--------->

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
                    <?php 
                        if($cityGuide['Cityguide']['city_guide_image2']!=""){ 
                           echo $this->Html->image($cityGuide['Cityguide']['city_guide_image2'], array('alt' => 'entopolis'));    
                        }else {
                            echo $this->Html->image('DEMO Visuals ASK-sm.jpg', array('alt' => 'entopolis'));    
                        }
                    ?>
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
                    <?php if($cityGuide['Cityguide']['city_guide_image2']!=""){ 
                               echo $this->Html->image($cityGuide['Cityguide']['city_guide_image1'], array('alt' => 'entopolis'));    
                            }
                            else {
                                echo $this->Html->image('city_guide_dummy.jpg', array('alt' => 'entopolis'));    
                            } 
                            ?>
                </div>
            </div>
        </div>
    </div>
</div>