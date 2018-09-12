<?php


// some definition we will use
define( 'gae_PUGIN_NAME', 'Google Analytcs Events');
define( 'gae_PLUGIN_DIRECTORY', 'google-analytics-events');
define( 'gae_PLUGIN_PATH',  WP_CONTENT_DIR.'/plugins/'.gae_PLUGIN_DIRECTORY);
define( 'gae_PLUGIN_URL',  WP_CONTENT_URL.'/plugins/'.gae_PLUGIN_DIRECTORY);

define( 'gae_ASSETS_URL',  gae_PLUGIN_URL."/assets");
define( 'gae_ASSETS_PATH',  gae_PLUGIN_PATH."/assets");

define( 'gae_JS_URL',  gae_ASSETS_URL."/js");
define( 'gae_CSS_URL',  gae_ASSETS_URL."/css");

define( 'gae_JS_PARTS_PATH',  gae_ASSETS_PATH."/js/parts");



define( 'gae_INCLUDES_PATH',  gae_PLUGIN_PATH."/inc");
define( 'gae_CURRENT_VERSION', '0.9.6' );

$uloads_dir = wp_upload_dir();

define( 'gae_GENERATE_PATH', str_replace('\\', '/', $uloads_dir["basedir"].'/gae/'));
define( 'gae_GENERATE_FILE', gae_GENERATE_PATH.'gae.js');
define( 'gae_GENERATE_URL', $uloads_dir["baseurl"].'/gae/gae.js');

define( 'gae_LOG_PATH', str_replace('\\', '/', WP_CONTENT_DIR).'/gae-logs/');
define( 'gae_DEBUG', false);		# never use debug mode on productive systems
// i18n plugin domain for language files
define( 'EMU2_I18N_DOMAIN', 'gae' );