<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
function hugeit_vp_html_showStyles($param_values, $op_type)
{
    ?>
<script>
jQuery(document).ready(function(){
	var strliID=jQuery(location).attr('hash');
	jQuery('#video_player-view-tabs > li').removeClass('active');
	if(jQuery('#video_player-view-tabs > li > a[href="'+strliID+'"]').length>0){
		jQuery('#video_player-view-tabs > li > a[href="'+strliID+'"]').parent().addClass('active');
	}else {
		jQuery('#video_player-view-tabs > li > a[href="#video_player-view-options-0"]').parent().addClass('active');
	}
	jQuery('#video_player-view-tabs-contents > li').removeClass('active');
	strliID=strliID.replace("#","");
	if(jQuery('#video_player-view-tabs-contents > li[data-id="'+strliID+'"]').length>0){
		jQuery('#video_player-view-tabs-contents > li[data-id="'+strliID+'"]').addClass('active');
	}else {
		jQuery('#video_player-view-tabs-contents > li[data-id="video_player-view-options-0"]').addClass('active');
	}
	jQuery('input[data-slider="true"]').bind("slider:changed", function (event, data) {
		 jQuery(this).parent().find('span').html(parseInt(data.value)+"%");
		 jQuery(this).val(parseInt(data.value));
	});	
});
</script>
<div class="wrap">
<?php $path_site2 = plugins_url("../images", __FILE__); ?>
<?php $path_site = plugins_url("Front_images", __FILE__); ?>
			<div class="slider-options-head">

		<?php include 'video_player_free_banner.php'; ?>
	<div style="clear:both;"></div>
<div style="margin-left: -20px;" id="poststuff">
		<div id="post-body-content" class="portfolio-options">
			<img style="width: 100%;" src="<?php echo $path_site2; ?>/video.player.general.options.jpg">
		</div>
</div>
</div>
<input type="hidden" name="option" value=""/>
<input type="hidden" name="task" value=""/>
<input type="hidden" name="controller" value="options"/>
<input type="hidden" name="op_type" value="styles"/>
<input type="hidden" name="boxchecked" value="0"/>
<?php
}