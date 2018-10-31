<?php

//--------------------------------_Admin side hooks --------------------


add_action( 'admin_init', 'Gae_Admin::init' );

// create custom plugin settings menu
add_action( 'admin_menu', 'Gae_Admin::create_menu' );

// checking folder permissions.
add_action('admin_notices', 'Gae_Admin::check_folder_access_rights');

if (!Gae_Admin::is_settings_page_visited()){
    add_action('admin_notices', function(){
        if (!isset($_GET['page']) || $_GET['page']!==Gae_Admin::get_settings_page_relative_path()){
            Gae_Admin::print_message(
                "gae-visit-plugin",
                'Please visit '.gae_PUGIN_NAME.' plugins  <a href="'.Gae_Admin::get_settings_page_url().'">settings page</a>.',
                "warning");
        }
    });
}

//-------------------------------- Frontend hooks hooks --------------------
add_action('wp_enqueue_scripts','Gae_Frontend::add_scripts');
add_action('wp_head','Gae_Frontend::add_inline_scripts',0);