<?php

class Gae_Admin {

  // uninstalling

  public static $folder_that_should_be_writable = [gae_GENERATE_PATH,gae_LOG_PATH];

  public static function uninstall() {
    # delete all data stored
    delete_option('gae_option_3');
    // delete log files and folder only if needed
    if (function_exists('gae_deleteLogFolder')) gae_deleteLogFolder();
  }


  public static function init() {
    //register settings
    //gea_register_scripts();
    self::add_scripts();
  }

  public static function check_folder_access_rights(){
    # check for folder

    foreach(self::$folder_that_should_be_writable as $folder){
        print($folder);
        if (!is_dir($folder) || !is_writable($folder)){
            if (!is_dir($folder)){
                if (!mkdir($folder,0777,true)){
                  self::message(sprintf(__("Google Analytics Events (GAE) Error: Could not create folder %s", EMU2_I18N_DOMAIN)  . " " . __("Php process should be allowed to write to that folder.", EMU2_I18N_DOMAIN),$folder), "error");
                }
            }
            if (!is_writable($folder)){
                self::message(sprintf(__("Google Analytics Events (GAE) Error: Can't write to folder %s", EMU2_I18N_DOMAIN)  . " " . __("Php process should be allowed to write to that folder.", EMU2_I18N_DOMAIN),$folder), "error");
            }
        }
    }
  }


  public static function create_menu() {

    // or create options menu page
    add_options_page(__('Google Analytics Events', EMU2_I18N_DOMAIN), __("Google Analytics Events", EMU2_I18N_DOMAIN), 9,  gae_PLUGIN_DIRECTORY.'/gae_settings_page.php');
    // or create sub menu page
    $parent_slug="index.php";	# For Dashboard
    #$parent_slug="edit.php";		# For Posts
    // more examples at http://codex.wordpress.org/Administration_Menus
    //add_submenu_page( $parent_slug, __("HTML Title 4", EMU2_I18N_DOMAIN), __("Menu title 4", EMU2_I18N_DOMAIN), 9, gae_PLUGIN_DIRECTORY.'/gae_settings_page.php');
    add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'Gae_Admin::add_settings_link_to_plugin_list' );

  }


// check if debug is activated
  public static function debug() {
    # only run debug on localhost
    if ($_SERVER["HTTP_HOST"]=="localhost" && defined('EPS_DEBUG') && EPS_DEBUG==true) return true;
  }

  public static function get_js_parts()
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


  public static function generate_combined()
  {
    Gae_Logger::write_log("Regenerating scrtip start.=========",__FUNCTION__,__LINE__);

    if (!is_dir(gae_GENERATE_PATH) || !file_exists(gae_GENERATE_PATH)){
      mkdir(gae_GENERATE_PATH,0655,true);
      if (!is_writable(gae_GENERATE_PATH)){
        Gae_Admin::message("Cant wrtie to file, in directory:".gae_GENERATE_PATH,"error");
      }
    }

    if (isset($_POST["option_page"]) && $_POST["option_page"] == 'gae-settings-group'){
      //combining the scritps

      $result_file_path = gae_PLUGIN_PATH."/js/gae-combined.js";

      $result_file_upload_path  = gae_GENERATE_FILE;

      $main_file_path = gae_PLUGIN_PATH."/js-parts/gae-main.js";

      $js_parts_to_include=["gae-variables","gae-functions"];

      $all_js_parts= self::get_js_parts();
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
        Gae_Logger::write_log("Trying save regenerated file to subfolder.=========",__FUNCTION__,__LINE__);
        if (is_writable($result_file_path)){
          if (file_put_contents($result_file_path,$combined_js_content)){
            Gae_Logger::write_log("Result saved to: $result_file_path ",__FUNCTION__,__LINE__);
          } else {
            Gae_Logger::write_log("FAILED (can be ignored) save to: $result_file_path ",__FUNCTION__,__LINE__);
          };
        } else {
          Gae_Logger::write_log("FAILED (can be ignored) file is not writable: $result_file_path ",__FUNCTION__,__LINE__);
        }
      }

      if (is_writable(dirname($result_file_uload_path))|| 1){
        if (file_put_contents($result_file_upload_path,$combined_js_content)){
          Gae_Logger::write_log("Result saved to: $result_file_upload_path ",__FUNCTION__,__LINE__);
        } else {
          gae_message("Cant save the generated file. $result_file_upload_path . The folder / file should be writable by php and accessible - readable publicly.","error");
          Gae_Logger::write_log("FAILED save to: $result_file_upload_path ",__FUNCTION__,__LINE__);
        };
      } else {
        gae_message("Folder is not writable. ".dirname($result_file_upload_path),"error");
        Gae_Logger::write_log("FAILED file is not writable: $result_file_upload_path ",__FUNCTION__,__LINE__);
      }
    }

    Gae_Logger::write_log("Regenerating scrtip end.=========",__FUNCTION__,__LINE__);
  }


  public static function message($text, $type="success")
  {
    ?>
    <div id="message" class="<?= $type ?>"><?= $text ?></div>
    <?php
  }


  public static function get_sections()
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


  public static function gae_is_debug(){
    //TODO check if the its debug mode, and what level
    return true;
  }


  public static function is_settings_page(){
    //// TODO: check if we are on settings page to load addtional css
    return true;
  }


  public static function add_custom_admin_css() {
    echo '<link id="'.gae_PLUGIN_DIRECTORY.'" rel="stylesheet" href="'.gae_PLUGIN_URL.'/css/gae-admin.css'.'" type="text/css" media="all" />';
  }


  public static function add_scripts(){
    if(is_admin()){
      if (self::is_settings_page()){
        add_action('admin_head', 'gae_add_custom_admin_css');
      }
    }
  }


  public static function add_settings_link_to_plugin_list($links)
  {
    $links[] = '<a href="'. esc_url( get_admin_url(null, 'options-general.php?page=google-analytics-events/gae_settings_page.php') ) .'">Settings</a>';
    ///$links[] = '<a href="http://wp-buddy.com" target="_blank">More plugins by WP-Buddy</a>';
    return $links;
  }


  public static function show_donation_block(){
      //todo check the last interaction ignore for a while
     return true;
  }



}