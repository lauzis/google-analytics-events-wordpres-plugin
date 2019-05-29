<?php


// some definition we will use
define( 'gae_PUGIN_NAME', 'Google Analytics Events');
define( 'gae_PLUGIN_DIRECTORY', basename(dirname(plugin_dir_url(__FILE__))));

define( 'gae_PLUGIN_DIRECTORY_NAME', "google-analytics-events");
define( 'gae_PLUGIN_PATH',  dirname(plugin_dir_path(__FILE__)));
define( 'gae_PLUGIN_FILE', gae_PLUGIN_PATH."/gae.php");
define( 'gae_PLUGIN_URL', dirname(plugin_dir_url(__FILE__)));

define( 'gae_ASSETS_URL',  gae_PLUGIN_URL."/assets");
define( 'gae_ASSETS_PATH',  gae_PLUGIN_PATH."/assets");

define( 'gae_JS_URL',  gae_ASSETS_URL."/js");
define( 'gae_CSS_URL',  gae_ASSETS_URL."/css");

define( 'gae_JS_PARTS_PATH',  gae_ASSETS_PATH."/js/parts");


define( 'gae_INCLUDES_PATH',  gae_PLUGIN_PATH."/inc");
define( 'gae_CURRENT_VERSION', '0.9.7' );

$uloads_dir = wp_upload_dir();

define( 'gae_GENERATE_PATH', str_replace('\\', '/', $uloads_dir["basedir"].'/gae/'));
define( 'gae_GENERATE_URL', $uloads_dir["baseurl"].'/gae/');
define( 'gae_GENERATE_FILE', gae_GENERATE_PATH.'gae.js');
define( 'gae_GENERATE_FILE_URL', gae_GENERATE_URL.'gae.js');

define( 'gae_LOG_PATH', str_replace('\\', '/', $uloads_dir["basedir"].'/gae-logs/'));
define( 'gae_DEVELOPER', true);
// i18n plugin domain for language files
define( 'EMU2_I18N_DOMAIN', 'gae' );

define('ģae_DONATION_SHOW_LINKS',true);
define('gae_DONATION_URL','https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=aivars.lauzis@gmail.com&lc=US&item_name=Donation+for+Google+Analytics+Event+Wordpres+Plugin+Support+And+Development&no_note=0&cn=&currency_code=USD&bn=PP-DonationsBF:btn_donateCC_LG.gif:NonHosted');
define('ģae_PLUGIN_SITE_URL','https://github.com/lauzis/google-analytics-events-wordpres-plugin');

define('gae_TRANSLATION_IDS_FILE',gae_GENERATE_PATH . gae_PLUGIN_DIRECTORY_NAME . ".serialized.php");