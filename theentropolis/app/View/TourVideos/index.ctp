<?php
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

<div class="col-md-10 content-wraaper admin-wrap">
    <?php if($this->Session->read('isAdmin')) { ?>
    <div class="sage-dash-wrap full-wrap">
        <div class="title dashboard-title take_tour_title relative">
            <h1>Start Here</h1>
            <?php 
            //if ($flagAdd) {
            //    echo $this->Html->link('Add Video',array('controller'=>'tourVideos','action'=>'add'),array('class'=>'right btn btn-orange-small ')); 
            //} ?>
        </div>   
        <div class="table-wrap" id="postsPaging">
            <table class="table table-striped eluminati-table table-hover user-table action-table take_tour_list" cellspacing="0" cellpadding="0" width="100%">
                <thead>
                    <tr>
                        <th>&nbsp;<?php echo ('S.No'); ?></th>
                        <th><?php echo ('Tag'); ?></th>
                        <th><?php echo ('Title'); ?></th>
                        <th><?php echo ('URL'); ?></th>
                        <th><?php echo ('Created Date'); ?></th>
                    </tr>
                </thead>
            <?php 
            $i=1;
            foreach ($tourVideos as $tourVideo) { ?>
                <tr>
                    <td>&nbsp;<?php echo ($i++);?></td>
                    <td>
			<?php echo $tourVideo['Tag']['tag_name']; ?>
                    </td>
                    <td><?php echo h($tourVideo['TourVideo']['title']); ?>&nbsp;</td>
                    <td><?php echo h($tourVideo['TourVideo']['video_url']); ?>&nbsp;</td>
                    <td><?php echo h(date('M d, Y', strtotime($tourVideo['TourVideo']['timestamp']))); ?>&nbsp;</td>
                </tr>
            <?php } ?>
            </table>
        </div>
    </div>
    <?php } else { ?>
        <!-- tour-video-wrapper-starts -->
        <div class="tour-video-wrap" id="">
            <div class="embed-responsive embed-responsive-16by9">
                <div class="iframe_icon"></div>
                <?php
                if(count($tourVideos) >0) {
                    $videoid = get_youtube_id_from_url($tourVideos[0]['TourVideo']['video_url']);
                    $videoUrl = "http://www.youtube.com/embed/".$videoid;
                    //$videoUrl = $this->Common->parseVideos($tourVideos[0]['TourVideo']['video_url']);
                    ?>
                    <!--<iframe width="100%" height="700" src="https://www.youtube.com/embed/IaszbI9txPM" frameborder="0" allowfullscreen></iframe>-->
                    <iframe width="100%" height="700" src="<?=$videoUrl?>" frameborder="0" allowfullscreen></iframe>
                <?php } else {
                    echo "No data found";
                }
                ?>
            </div>
        </div>
    <?php } ?>
    <!-- tour-video-wrapper-ends -->
</div> <!-- content-wraaper ends -->
<?php
echo $this->element('advice_all_modal_element');
echo $this->element('blog_js_element'); ?>