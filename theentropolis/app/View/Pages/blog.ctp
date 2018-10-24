<?php
function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if (getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if (getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if (getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if (getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if (getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';

    return $ipaddress;
}

$my_local_ip = get_client_ip();

function get_youtube_id_from_url($url) {
    if (stristr($url, 'youtu.be/')) {
        preg_match('/(https:|http:|)(\/\/www\.|\/\/|)(.*?)\/(.{11})/i', $url, $final_ID);
        return $final_ID[4];
    } else {
        @preg_match('/(https:|http:|):(\/\/www\.|\/\/|)(.*?)\/(embed\/|watch.*?v=|)([a-z_A-Z0-9\-]{11})/i', $url, $IDD);
        return $IDD[5];
    }
}

?>
<style>
.page-loading {
    bottom: 10px;
    height: 58px;
    opacity: 0.2;
    display: none!important;
}
</style>

<div class="page-loading" style="color:red; display:none"><?php echo $this->Html->image('loading-upload.gif'); ?></div><div style="clear:both"></div>

    <div class="banner banner-pss carousel slide" id="pss-top-carousel" data-ride="carousel" data-interval="false">
        <div class="slides carousel-inner mediaslides">
            <div class="item active" align="center">
                <div class="mediaTop">
                    <div class="topInner">
                        <h1 class="H1-white upper">MEDIA</h1>
                    </div>
                </div>
                <div style="clear:both"></div>
                <?php echo $this->Html->image('media-banner.png', array('style' => 'width:100%')); ?>
            </div>
        </div>
    </div>

    <div style="clear:both"></div>

    <div class="media" align="center">
        <div class="mediaMenu" style="margin: 0px auto!important;">
            <div id="navsubmenu">
                <div class="menuSubLeft">
                <ul class="nav navbar-nav">
                  <li class="navbord"><a href="#campagins" id="link1" class="navText active">Campaigns</a></li>
                  <li class="navbord"><a href="#feature" id="link2" class="navText">Feature</a></li>
                  <li class="navbord"><a href="#media" id="link3" class="navText">Media and PR</a></li>
                  <li class="navbord"><a href="#videos" id="link4" class="navText">Videos</a></li>
                  <li class="navbord"><a href="#socialfeeds" id="link5" class="navText">Social Feed</a></li>
                  <a class="btn btn-default btnblue btnfilled upper btnfuture hover-green" href="http://futureproof.theentropolis.com/" target="_blank" style="position:relative; background-color: #3edd2b !important; border: 1px solid #3edd2b !important; ">FUTUREPROOF BLOG </a>
                </ul>
                </div>
                
                <div style="clear:both"></div>
            </div>
        </div>
        <div class="mediaBody" style="margin:55px auto 0px;">
          <h1 class="H1" id="#campagins"></h1>
            <div id="blog-slideshow">

                            <div>
                            <?php echo $this->Html->image('ENTR2018 CampaignBannerKC.PNG', array('alt' => '', 'class' => 'campImg', 'border' => '0')); ?>
                               <!--  <?php echo $this->Html->image('campaign-banner-3.png', array('alt' => '', 'class' => 'campImg', 'border' => '0')); ?> -->
                            </div>
                            <div>
                                <?php echo $this->Html->image('ENTR2018 CampaignBannerGTB 081216.PNG', array('alt' => '', 'class' => 'campImg', 'border' => '0')); ?>
                               <!--  <?php echo $this->Html->image('campaign-banner-2.png', array('alt' => '', 'class' => 'campImg', 'border' => '0')); ?> -->
                            </div>
                            <div>
                                 <?php echo $this->Html->image('ENTR2018 CampaignBannerNinja 081216 (1).PNG', array('alt' => '', 'class' => 'campImg', 'border' => '0')); ?>
                                <!-- <?php echo $this->Html->image('campaign-banner.png', array('alt' => '', 'class' => 'campImg', 'border' => '0')); ?> -->
                            </div>
                       
                            
                        </div>
        </div>
    </div>

    <div style="clear:both"></div>
    <div class="mediaSubBody custom-media-wrap">
        <h1 class="H1" id="feature">Feature</h1>
        <div class="stripe"></div>
        <div class="articleContainer ">
            <div class="articleL">
                 <div class="blogFeaturedImgWrap">
                   
                          <?php
                          $videoid ="";
                          if($tourVideo_blog['TourVideo']['video_url']!="")
                            $videoid = get_youtube_id_from_url($tourVideo_blog['TourVideo']['video_url']);
                          $videoUrl = "http://www.youtube.com/embed/".$videoid;?>                  
                    <div class="embed-responsive embed-responsive-16by9">
                          <iframe class="embed-responsive-item" src="<?=$videoUrl?>"></iframe>
                    </div>

                </div>
            </div>
            <div class="articleR">
                <div class="articleIn readmorelink more">
                    <strong class="medTxt "><?= $tourVideo_blog['TourVideo']['title'] ?></strong><br/><br/>
                   <?= strip_tags($tourVideo_blog['TourVideo']['blog_detail']) ?>
                </div>
                <div style="clear:both"></div>
                
                <div class="articleRB" style="float:right;width:70%;text-align:right;margin:10px 20px 10px">
                   <a href="https://www.facebook.com/sharer/sharer.php?u=<?=   strip_tags($tourVideo_blog['TourVideo']['blog_detail'])?>" target="_blank"><?php echo $this->Html->image('ico.facebook.png', array('style' => 'border="0"')); ?></a>
                    &nbsp;
                   
                    <a href="http://twitter.com/share?url=<?=  strip_tags($tourVideo_blog['TourVideo']['video_url'])?>;text=<?=   strip_tags($tourVideo_blog['TourVideo']['blog_detail'])?>;size=l&amp;count=none" target="_blank"><?php echo $this->Html->image('ico.twitter.png', array('style' => 'border="0"')); ?></a>&nbsp;
                    <a href="<?=$tourVideo_blog['TourVideo']['video_url']?>" target="_blank" class=""><?php echo $this->Html->image('ico.youtube.png', array('data-alt-src' => 'youtube-play-over.png','border' => '0')); ?></a>&nbsp;
                    <a href="https://in.linkedin.com/company/entropolis-pty-ltd" target="-blank"><?php echo $this->Html->image('ico.linkedin.png', array('data-alt-src' => 'linkedin-over.png', 'border' => '0')); ?></a>
                </div>
                
                <div style="clear:both"></div>
            </div>
            <div style="clear:both"></div>
        </div>
        <div style="clear:both"></div>

        <h1 class="H1" id="media">Media and PR</h1>
        <div class="stripe"></div>
        <div class="articleContainer">
            <?php
                        foreach ($blog_list as $k => $v) {
                            if ($v['Advice']['blog_type'] == 6) {
//                                debug($v);
//                                die;
                                $user_info = $this->User->getDetailByContextRoleUserId($v['Advice']['context_role_user_id']);
                                ?>
            <div class="articleL" style="text-align:center !important">
                <?php echo (($v['Advice']['advice_image'] == "") ? $this->Html->image("blog-sample.jpg", array('alt' => '', 'border' => '0', 'width' => '100%')) : $this->Html->image("../".str_replace("thumb_", "", $v['Advice']['advice_image']), array('class'=>'mediaImg','alt' => '', 'border' => '0', 'max-width' => '100%')));
                            ?>
                </div>
            <div class="articleR">
                <div class="articleIn readmorelink more">
                    <strong class="medTxt"><?php echo $v['Advice']['advice_title'] ?></strong><br/><br/>
                    <?= strip_tags($v['Advice']['feature_blog']); ?>
                </div>
                
                <div class="articleRB" style="float:right;width:70%;text-align:right;margin:10px 20px 10px">
                   <a href="https://www.facebook.com/sharer/sharer.php?u=<?=  strip_tags($v['Advice']['feature_blog'])?>" target="_blank"><?php echo $this->Html->image('ico.facebook.png', array('style' => 'border="0"')); ?></a>&nbsp;
                    <a href="http://twitter.com/share?url=<?=  strip_tags($v['Advice']['source_url'])?>;text=<?=  strip_tags($v['Advice']['feature_blog'])?>;size=l&amp;count=none" target="_blank"><?php echo $this->Html->image('ico.twitter.png', array('style' => 'border="0"')); ?></a>&nbsp;
                    <a href="<?=  strip_tags($v['Advice']['source_url'])?>" target="_blank">
                        
                    <?php echo $this->Html->image("ico.youtube.png", array('alt' => '', 'border' => '0')); ?>
                    </a>
                </div>
                <div style="clear:both"></div>
            </div>
            <div style="clear:both"></div>
             <?php
             break;
                            }
                        }
                        ?>
        </div>

        <h1 class="H1" id="videos">Videos</h1>
        <div class="stripe"></div>
        <div class="videosContainer">
            <?php
                        $i=0;
                        $videoUrl = array();
                        foreach ($blog_list as $k => $v) {
                            if ($v['Advice']['blog_type'] == 7) {
                                //debug($v);
                                
                                $user_info = $this->User->getUserData($v['Blog']['user_id_creator']);
                                //$videoUrl = $this->Common->parseVideos($v['Advice']['source_url']);
                                $videoidemb = get_youtube_id_from_url($v['Advice']['source_url']);
                                $youtubeUrl=$v['Advice']['source_url'];
                                if(strpos($youtubeUrl,"v=") != false){
                                    $urlArr=explode("v=",$youtubeUrl);
                                    $videoid=$urlArr[1];
                                }
                                else{
                                    $urlArr=explode("/",$youtubeUrl);
                                    $videoid=$urlArr[count($urlArr)-1];
                                }
                               // echo $yId;
                                $videoUrl = "http://www.youtube.com/watch?v=".$videoid;
                                $videoEmb = "http://www.youtube.com/embed/".$videoidemb;
                                $i++; 
                                $gridCls="vidBlockL";
                                if($i%3==0){
                                    $gridCls="vidBlockR";
                            }
    
                                ?>
<div class="<?=$gridCls?>">
                <div class="vidPics"> <a href="javascript:void(0)">
    
                                                </a> <?php echo (($v['Advice']['advice_image'] == "") ? $this->Html->image("Entr1.png", array('alt' => '', 'border' => '0')) : $this->Html->image("../".str_replace("thumb_", "", $v['Advice']['advice_image']), array('alt' => '', 'class' => 'vidPic', 'border' => '0'))); ?></div>
                <div class="vidTXT">
                    <strong class="medTxt"><?= $v['Advice']['advice_title'] ?></strong><br /><br />
                     <?php
                                            echo $this->Text->truncate(
                                                    $v['Advice']['feature_blog'], 50, array(
                                                'ellipsis' => '...',
                                                'exact' => false
                                                    )
                                            );
                                            ?>
                    <br /><br />
                    <div style="float:left;width:40%;margin:10px 0px">
                        <a href="javascript:void(0)" class="blue play-video-popup" data-toggle="modal" data-target="#blogVideoPopup" data-video="<?=$videoEmb?>" data-title="<?=$v['Advice']['advice_title']?>">Watch now</a>
                    </div>
                    <div style="float:right;width:50%;text-align:right;margin:8px 5px 0px">
                        
    
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?=  strip_tags($v['Advice']['feature_blog'])?>" target="_blank"><?php echo $this->Html->image('ico.facebook.png', array('style' => 'border="0"')); ?></a>&nbsp;
                    <a href="http://twitter.com/share?url=<?=  strip_tags($v['Advice']['source_url'])?>;text=<?=  strip_tags($v['Advice']['feature_blog'])?>;size=l&amp;count=none" target="_blank"><?php echo $this->Html->image('ico.twitter.png', array('style' => 'border="0"')); ?></a>&nbsp;
                    <a href="<?=$videoUrl?>" target="_blank">
                        
                    <?php echo $this->Html->image("ico.youtube.png", array('alt' => '', 'border' => '0')); ?>
                    </a>
                    </div>
                    <div style="clear:both"></div>
                </div>
            </div>
                            <?php 
                                
                                if($i%3 == 0) {
                                    echo "<div style='clear:both'></div>";
                                }
                            }
                        }
                        ?>
            
            
            
           
        </div>
        <div style="clear:both"></div>
        <h1 class="H1 hide" id="socialfeeds">Social feed</h1>
        <div class="stripe hide"></div>
        <div class="socialContainer hide"><!-- <div id="social-tabs"></div> -->
        </div>
    </div>
    <div style="clear:both"></div>
    <script type="text/javascript">
            $(document).ready(function () {
                $('body').on('click', '.play-video-popup', function () {
                    var $this = $(this);
                    var video = $this.data('video');
                    var title = $this.data('title');
                    $(".embed-responsive-item").attr('src', video);
                    $("#blogVideoPopup .modal-title").text(title);
                });
                $('#blogVideoPopup').on('hidden.bs.modal', function () {
    // do something…
                    $("#blogVideoPopup .embed-responsive-item").attr('src', "");
                });
            });

        </script>