<?php
/*
Plugin Name: T2 Export
Plugin URI: http://themeton.com
Description: Advanced Wordpress Exporter that exports specific page/pages content with attachement and related things
Version: 1.0.0
Author: ThemeTon
Author URI: http://themeton.com
License: GPLv2 or later
*/


//Admin menu
add_action('admin_menu', 't2export_admin_menu');
function t2export_admin_menu() {
    add_menu_page('T2 Export', 'T2 Export', 'manage_options', 't2export_settings', 'render_t2export_settings');
}

function render_t2export_settings() {
    if (!current_user_can('manage_options')) {
        wp_die(__('You do not have sufficient permissions to access this page.', 'themeton'));
    }

    require_once(dirname( __FILE__ ).'/form.php');
}


if (isset($_GET['page']) && $_GET['page'] == 't2export_settings') {
    add_action('admin_enqueue_scripts', 't2export_enquee_scripts');

    function t2export_enquee_scripts() {

    	wp_enqueue_script('jquery');
        
        /** Select-2 */
        wp_enqueue_style('select2', plugins_url('assets/select2/select2.css', __FILE__));
        wp_enqueue_script('select2', plugins_url('assets/select2/select2.min.js', __FILE__), false, false, true);

        /** Plugin Scripts */
        wp_enqueue_style('t2export-style', plugins_url('assets/style.css', __FILE__));
        wp_enqueue_script('t2export-script', plugins_url('assets/scripts.js', __FILE__), false, false, true);
    }

}


?>