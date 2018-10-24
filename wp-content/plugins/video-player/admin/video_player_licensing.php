<?php wp_enqueue_style("admin_css", plugins_url("../style/admin.licensing.css", __FILE__), FALSE); ?>
<div style="width:95%">
    <p>
        <?php _e( 'You are using the Lite version of the Video Player for WordPress. If you want to get more awesome options,
        advanced features, settings to customize every area of the plugin, then check out the Full License plugin. The
        full version of the plugin is available in 3 different packages of one-time payment.', 'hugeit_maps' ); ?>
    </p>
    <a href="http://huge-it.com/video-player/" class="button-primary" target="_blank"><?php _e('Purchase a License', 'product-catalog' ); ?></a>
    <br/><br/>

    <div class="video-player">
        <div class="video-block">
            <div class="licens">
                <a target="_blank" href="http://huge-it.com/video-player/">
                    <span class="icon player-advanced"></span>
                    <span class="text">Player’s Advanced Styling</span>
                </a>
            </div>
            <div class="licens">
                <a target="_blank" href="http://huge-it.com/video-player/">
                    <span class="icon video-resizer"></span>
                    <span class="text">Video Resizer Settings</span>
                </a>
            </div>
            <div class="licens">
                <a target="_blank" href="http://huge-it.com/video-player/">
                    <span class="icon advanced-color"></span>
                    <span class="text">Advanced Color Styling</span>
                </a>
            </div>
            <div class="licens">
                <a target="_blank" href="http://huge-it.com/video-player/">
                    <span class="icon playlist"></span>
                    <span class="text">Playlist Full Customization</span>
                </a>
            </div>

            <div class="licens">
                <a target="_blank" href="http://huge-it.com/video-player/">
                    <span class="icon youtube"></span>
                    <span class="text">Advanced Youtube Options</span>
                </a>
            </div>
            <div class="licens">
                <a target="_blank" href="http://huge-it.com/video-player/">
                    <span class="icon vimeo"></span>
                    <span class="text">Advanced Vimeo Options</span>
                </a>
            </div>
            <div class="licens">
                <a target="_blank" href="http://huge-it.com/video-player/">
                    <span class="icon advanced"></span>
                    <span class="text">advanced customization</span>
                </a>
            </div>
        </div>
    </div>

    <br/><br/><br/>
    <p><?php _e( 'After the purchasing the full version follow this steps:', 'hugeit_maps' ); ?></p>
    <ol>
        <li><?php _e( 'Deactivate Huge-IT Video Player Plugin', 'hugeit_maps' ); ?></li>
        <li><?php _e( 'Delete Huge-IT Video Player Plugin', 'hugeit_maps' ); ?></li>
        <li><?php _e( 'Install the downloaded full version version of the plugin', 'hugeit_maps' ); ?></li>
    </ol>
</div>