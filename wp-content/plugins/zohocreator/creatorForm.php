<?php

/*
Plugin Name:Zoho-Creator 
Plugin URI: http://wordpress.org/extend/plugins/zohocreator
Description: Helpful in embedding creator forms or views into your WordPress blog.
Version: 1.0.5	
Author:Zoho Creator
Author URI: https://creator.zoho.com
*/

//Shortcode for embeding the form

add_shortcode('creator', 'creator');


function creator($atts, $content = null) {  
	extract(shortcode_atts(array(
		'src' => '',
		'bg' => '',
		'hdbg' => '',
		'fbg' => '',
		'width' => '',
		'height' => ''
	), $atts));	
    return '<div class="tutorial_image">
	    <iframe height="'.$atts['height'].'" width="'.$atts['width'].'" frameborder="0" allowTransparency="true" scrolling="auto" src="'.$atts['src'].'zc_BgClr='.$atts['bg'].'&zc_HdrClr='.$atts['hdbg'].'&zc_FtrClr='.$atts['fbg'].'"</iframe>
	    </div>';  
}  


// Creation of TinyMCE button

add_action('init', 'add_button');

// Adding filters for the external plugins.

function add_button() {  
   
     add_filter('mce_external_plugins', 'add_plugin');  
     add_filter('mce_buttons', 'register_button');  
     
}  

// Registering the TinyMCE button.

function register_button($buttons) {  
   array_push($buttons, "creator");  
   return $buttons;  
}  

// Returns the plugin_array which contains the values for the shortcode. 

function add_plugin($plugin_array) {  
   $plugin_array['creator'] = plugin_dir_url( __FILE__ ) . 'tinymce/zceditor_plugin.js'; 
   return $plugin_array;  
}  

?>