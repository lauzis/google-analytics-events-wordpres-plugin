<?php

//--------------------------------_Admin side hooks --------------------


add_action( 'admin_init', 'Gae_Admin::init' );

// create custom plugin settings menu
add_action( 'admin_menu', 'Gae_Admin::create_menu' );


add_action('admin_notices', 'Gae_Admin::check_folder_access_rights');



//-------------------------------- Frontend hooks hooks --------------------
add_action('wp_enqueue_scripts','Gae_Frontend::add_scripts');
add_action('wp_head','Gae_Frontend::add_inline_scripts',0);


