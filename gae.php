<?php
/*
Plugin Name: GAE - Google analytics events wordpress plugin
Plugin URI: https://github.com/lauzis
Description: The plugin that adds some basic events to the site, to track clikcs on cta buttons and forms.
Version: 0.9.1
Author: Aivars Lauzis
Author URI: https://github.com/lauzis
License: GPL3
*/

/*
		Aivars Lauzis  (email : lauzis@inbox.lv)
		This plugin is started by using plugin template (EPT plugin)
		EPT - Empty Plugin Template
		http://1manfactory.com/ept
		Author: Juergen Schulze, 1manfactory@gmail.com
		Author URI: http://1manfactory.com
*/
?><?php

// some definition we will use
define( 'gae_PUGIN_NAME', 'Google Analytcs Events');
define( 'gae_PLUGIN_DIRECTORY', 'google-analytics-events');
define( 'gae_PLUGIN_PATH',  WP_CONTENT_DIR.'/plugins/'.gae_PLUGIN_DIRECTORY);
define( 'gae_CURRENT_VERSION', '0.9.1' );
define( 'gae_CURRENT_BUILD', '1' );
define( 'gae_LOGPATH', str_replace('\\', '/', WP_CONTENT_DIR).'/gae-logs/');
define( 'gae_DEBUG', false);		# never use debug mode on productive systems
// i18n plugin domain for language files
define( 'EMU2_I18N_DOMAIN', 'gae' );

// how to handle log files, don't load them if you don't log
require_once('gae_logfilehandling.php');

// load language files
function gae_set_lang_file() {
	# set the language file
	$currentLocale = get_locale();
	if(!empty($currentLocale)) {
		$moFile = dirname(__FILE__) . "/lang/" . $currentLocale . ".mo";
		if (@file_exists($moFile) && is_readable($moFile)) {
			load_textdomain(EMU2_I18N_DOMAIN, $moFile);
		}

	}
}
gae_set_lang_file();

// create custom plugin settings menu
add_action( 'admin_menu', 'gae_create_menu' );

//call register settings function
add_action( 'admin_init', 'gae_register_settings' );


register_activation_hook(__FILE__, 'gae_activate');
register_deactivation_hook(__FILE__, 'gae_deactivate');
register_uninstall_hook(__FILE__, 'gae_uninstall');

// activating the default values
function gae_activate() {
	add_option('gae_option_3', 'any_value');
}

// deactivating
function gae_deactivate() {
	// needed for proper deletion of every option
	delete_option('gae_option_3');
}

// uninstalling
function gae_uninstall() {
	# delete all data stored
	delete_option('gae_option_3');
	// delete log files and folder only if needed
	if (function_exists('gae_deleteLogFolder')) gae_deleteLogFolder();
}

function gae_create_menu() {


	// or create options menu page
	add_options_page(__('Google Analytics Events', EMU2_I18N_DOMAIN), __("Google Analytics Events", EMU2_I18N_DOMAIN), 9,  gae_PLUGIN_DIRECTORY.'/gae_settings_page.php');

	// or create sub menu page
	$parent_slug="index.php";	# For Dashboard
	#$parent_slug="edit.php";		# For Posts
	// more examples at http://codex.wordpress.org/Administration_Menus
	//add_submenu_page( $parent_slug, __("HTML Title 4", EMU2_I18N_DOMAIN), __("Menu title 4", EMU2_I18N_DOMAIN), 9, gae_PLUGIN_DIRECTORY.'/gae_settings_page.php');
}


function gae_register_settings() {
	//register settings
	register_setting( 'ept-settings-group', 'new_option_name' );
	register_setting( 'ept-settings-group', 'some_other_option' );
	register_setting( 'ept-settings-group', 'option_etc' );
}

// check if debug is activated
function gae_debug() {
	# only run debug on localhost
	if ($_SERVER["HTTP_HOST"]=="localhost" && defined('EPS_DEBUG') && EPS_DEBUG==true) return true;
}

function gae_get_js_parts()
{
	return [
		"gae-contact-links",
		"gae-custom-links",
		"gae-custome-element-tracking",
		"gae-file-downloads",
		"gae-form-tracking-field-change",
		"gae-form-tracking-gravity",
		"gae-form-tracking",
		"gae-mailchimp",
		"gae-outgoing-links",
		"gae-search",
		"gae-social-links",
		"gae-time-trigger"
	];
}


function gae_generate_combined(){
	?>
	<pre>
	<?php
	  print_r($_POST);

	  if (isset($_POST["option_page"]) && $_POST["option_page"] == 'gae-settings-group'){
	      //combining the scritps

	      $result_file_path = gae_PLUGIN_PATH."/js/gae-combined.js";

	      $main_file_path = gae_PLUGIN_PATH."/js-parts/gae-main.js";

	      $js_parts_to_include=["gae-variables","gae-functions"];

	      $all_js_parts= gae_get_js_parts();
	      foreach($all_js_parts as $js_part){
	        if (isset($_POST[$js_part]) && $_POST[$js_part]){
	          $js_parts_to_include[] = $js_part;
	        }
	      }

	      $combined_js_content= file_get_contents($main_file_path);
	      foreach($js_parts_to_include as $js_part){
	        $file_to_include = gae_PLUGIN_PATH."/js-parts/$js_part.js";
	        $combined_js_content = str_replace("//[$js_part]",file_get_contents($file_to_include),$combined_js_content);
	      }


	      if (is_writable($result_file_path)){
	        if (file_put_contents($result_file_path,$combined_js_content)){
	          print("result saved to: $result_file_path");
	        } else {
	          print("failed");
	        };
	      } else {
	        print("Cabt generate file!");
	      }
	  }

	?>
	</pre>
	<?php
}
?>
