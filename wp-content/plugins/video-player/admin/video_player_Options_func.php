<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

function hugeit_vp_showStyles($op_type = "0")
{
    global $wpdb;
    $query = "SELECT *  from " . $wpdb->prefix . "huge_it_video_params ";

    $rows = $wpdb->get_results($query);

    $param_values = array();
    foreach ($rows as $row) {
        $key = $row->name;
        $value = $row->value;
        $param_values[$key] = $value;
    }
    hugeit_vp_html_showStyles($param_values, $op_type);
}

?>