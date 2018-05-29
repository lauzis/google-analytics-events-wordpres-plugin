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
define( 'gae_PLUGIN_URL',  WP_CONTENT_URL.'/plugins/'.gae_PLUGIN_DIRECTORY);
define( 'gae_INCLUDES_PATH',  gae_PLUGIN_PATH."/includes");
define( 'gae_CURRENT_VERSION', '0.9.1' );
define( 'gae_CURRENT_BUILD', '1' );
$uloads_dir = wp_upload_dir();

define( 'gae_GENERATE_PATH', str_replace('\\', '/', $uloads_dir["basedir"].'/gae/'));
define( 'gae_GENERATE_FILE', gae_GENERATE_PATH.'gae.js');
define( 'gae_GENERATE_URL', $uloads_dir["baseurl"].'/gae/gae.js');

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

//
add_action('wp_enqueue_scripts','gea_register_scripts');

//

register_activation_hook(__FILE__, 'gae_activate');
register_deactivation_hook(__FILE__, 'gae_deactivate');
register_uninstall_hook(__FILE__, 'gae_uninstall');

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

	add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'gae_add_settings_link_to_plugin_list' );

}


function gae_register_settings() {
	//register settings
	//gea_register_scripts();
	gae_admin_register_scripts();
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


function gae_generate_combined()
{
		gae_writelog("Regenerating scrtip start.=========",__FUNCTION__,__LINE__);

		if (!is_dir(gae_GENERATE_PATH) || !file_exists(gae_GENERATE_PATH)){
			mkdir(gae_GENERATE_PATH,0655,true);
			if (!is_writable(gae_GENERATE_PATH)){
				gae_message("Cant wrtie to file, in directory:".gae_GENERATE_PATH,"error");
			}
		}

	  if (isset($_POST["option_page"]) && $_POST["option_page"] == 'gae-settings-group'){
	      //combining the scritps

	      $result_file_path = gae_PLUGIN_PATH."/js/gae-combined.js";

				$result_file_upload_path  = gae_GENERATE_FILE;

	      $main_file_path = gae_PLUGIN_PATH."/js-parts/gae-main.js";

	      $js_parts_to_include=["gae-variables","gae-functions"];

	      $all_js_parts= gae_get_js_parts();
	      foreach($all_js_parts as $js_part){
	        if (isset($_POST[$js_part]) && $_POST[$js_part]){
	          $js_parts_to_include[] = $js_part;
	        }
	      }

				print_r($js_parts_to_include);

	      $combined_js_content= file_get_contents($main_file_path);
	      foreach($js_parts_to_include as $js_part){
	        $file_to_include = gae_PLUGIN_PATH."/js-parts/$js_part.js";
					$start_text = "
					/* ------ $js_part --- $file_to_include ------ STARTS */
					";
					$end_text = "
					/* ------ $js_part ---  $file_to_include ------ ENDS */
					";
	        $combined_js_content = str_replace("//[$js_part]",$start_text.file_get_contents($file_to_include).$end_text,$combined_js_content);
	      }

				if (gae_DEVELOPMENT_MODE){
					gae_writelog("Trying save regenerated file to subfolder.=========",__FUNCTION__,__LINE__);
		      if (is_writable($result_file_path)){
		        if (file_put_contents($result_file_path,$combined_js_content)){
							gae_writelog("Result saved to: $result_file_path ",__FUNCTION__,__LINE__);
		        } else {
		          gae_writelog("FAILED (can be ignored) save to: $result_file_path ",__FUNCTION__,__LINE__);
		        };
		      } else {
		        gae_writelog("FAILED (can be ignored) file is not writable: $result_file_path ",__FUNCTION__,__LINE__);
		      }
				}

				if (is_writable(dirname($result_file_uload_path))|| 1){
	        if (file_put_contents($result_file_upload_path,$combined_js_content)){
						gae_writelog("Result saved to: $result_file_upload_path ",__FUNCTION__,__LINE__);
	        } else {
						gae_message("Cant save the generated file. $result_file_upload_path . The folder / file should be writable by php and accessible - readable publicly.","error");
	          gae_writelog("FAILED save to: $result_file_upload_path ",__FUNCTION__,__LINE__);
	        };
	      } else {
					gae_message("Folder is not writable. ".dirname($result_file_upload_path),"error");
	        gae_writelog("FAILED file is not writable: $result_file_upload_path ",__FUNCTION__,__LINE__);
	      }
	  }

		gae_writelog("Regenerating scrtip end.=========",__FUNCTION__,__LINE__);
}


function gae_message($text, $type="success")
{
	?>
		<div id="message" class="<?= $type ?>"><?= $text ?></div>
	<?php
}


function gae_get_sections()
{
	$sections = json_decode(file_get_contents(gae_INCLUDES_PATH."/sections.json"),true);
	foreach($sections as $sk => $s){
		foreach($s["fields"] as $fk => $f){
			if(isset($_POST[$f["id"]])){
				$sections[$sk]["fields"][$fk]["value"] = $_POST[$f["id"]];
				update_option($f["id"],$_POST[$f["id"]]);
			} elseif (get_option($f["id"])) {
				$sections[$sk]["fields"][$fk]["value"] = get_option($f["id"]);
			}
		}
	}
	return $sections;
}


function gae_is_debug(){
	//TODO check if the its debug mode, and what level
	return true;
}


function gae_is_settings_page(){
	//// TODO: check if we are on settings page to load addtional css
	return true;
}


function gae_add_custom_admin_css() {
  echo '<link id="'.gae_PLUGIN_DIRECTORY.'" rel="stylesheet" href="'.gae_PLUGIN_URL.'/css/gae-admin.css'.'" type="text/css" media="all" />';
}


function gae_admin_register_scripts(){
	if(is_admin()){
		if (gae_is_settings_page()){
			add_action('admin_head', 'gae_add_custom_admin_css');
		}
	}
}


function gea_register_scripts()
{

		wp_enqueue_script('gae-ga', gae_GENERATE_URL, array('jquery'));

		if (!is_admin() && gae_is_debug()){
				wp_enqueue_style('gae-css', gae_PLUGIN_URL.'/css/gae-debug.css');
				wp_enqueue_script('gae-debug', gae_PLUGIN_URL.'/js/gae-debug.js', array('jquery'));
		}

}

function gae_add_settings_link_to_plugin_list()
{
	$links[] = '<a href="'. esc_url( get_admin_url(null, 'options-general.php?page=google-analytics-events/gae_settings_page.php') ) .'">Settings</a>';
	///$links[] = '<a href="http://wp-buddy.com" target="_blank">More plugins by WP-Buddy</a>';
	return $links;
}
