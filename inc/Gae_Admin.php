<?php

class Gae_Admin
{
    
    public static $folder_that_should_be_writable = [gae_GENERATE_PATH, gae_LOG_PATH];
    private static $messages= [];


    public static function uninstall()
    {
        # delete all data stored
        delete_option('gae_option_3');
        // delete log files and folder only if needed
        if (function_exists('gae_deleteLogFolder')) gae_deleteLogFolder();
    }


    public static function init()
    {
        //register settings
        //gea_register_scripts();
        self::add_scripts();
    }

    public static function check_folder_access_rights()
    {
        # check for folder

        foreach (self::$folder_that_should_be_writable as $folder) {
            if (!is_dir($folder) || !is_writable($folder)) {
                if (!is_dir($folder)) {
                    if (!mkdir($folder, 0777, true)) {
                        self::add_message(sprintf(__("Google Analytics Events (GAE) Error: Could not create folder %s", EMU2_I18N_DOMAIN) . " " . __("Php process should be allowed to write to that folder.", EMU2_I18N_DOMAIN), $folder), "error");
                    }
                }
                if (!is_writable($folder)) {
                    self::add_message(sprintf(__("Google Analytics Events (GAE) Error: Can't write to folder %s", EMU2_I18N_DOMAIN) . " " . __("Php process should be allowed to write to that folder.", EMU2_I18N_DOMAIN), $folder), "error");
                }
            }
        }
    }


    public static function create_menu()
    {

        // or create options menu page
        add_options_page(
                __('Google Analytics Events', EMU2_I18N_DOMAIN), //'My Options',
                __("Google Analytics Events", EMU2_I18N_DOMAIN), //'My Plugin',
                "manage_options", //cap
                gae_PLUGIN_DIRECTORY . '/gae_settings_page.php'//file
        );
        // or create sub menu page
        $parent_slug = "index.php";    # For Dashboard
        #$parent_slug="edit.php";		# For Posts
        // more examples at http://codex.wordpress.org/Administration_Menus
        //add_submenu_page( $parent_slug, __("HTML Title 4", EMU2_I18N_DOMAIN), __("Menu title 4", EMU2_I18N_DOMAIN), 9, gae_PLUGIN_DIRECTORY.'/gae_settings_page.php');
        add_filter('plugin_action_links_' . plugin_basename(gae_PLUGIN_FILE), 'Gae_Admin::add_settings_link_to_plugin_list');

    }


// check if debug is activated
    public static function debug()
    {
        # only run debug on localhost
        $ips = trim(get_option("gea-debug-ip"));
        if (!empty($ips)) {
            $ips = explode(",", $ips);
            $ips = array_unique($ips);
            if (count($ips) > 0) {
                if (!in_array($_SERVER["REMOTE_ADDR"], $ips)) {
                    return false;
                }
            }
        }

        $debug_level = get_option("gae-debug");
        switch ($debug_level) {
            case "disabled":
                return false;
                break;
            case "enable-php-log":
                return 1;
                break;
            case "enable-console-log":
                return 2;
                break;
            case "enable-show-on-front":
                return 3;
                break;

            default:
                return $debug_level;
                break;
        }
        return false;
    }

    public static function get_js_parts()
    {
        return [
            "gae-contact-links",
            "gae-custom-links",
            "gae-custom-element-tracking",
            "gae-file-downloads",
            "gae-form-tracking-field-change",
            "gae-form-submission-tracking",
            "gae-form-tracking-gravity-success",
            "gae-mailchimp",
            "gae-outgoing-links",
            "gae-track-links-to-specific-urls",
            "gae-search",
            "gae-social-links",
            "gae-time-trigger"
        ];
    }


    public static function generate_combined()
    {

        $result_file_path = gae_PLUGIN_PATH . "/js/gae-combined.js";
        $result_file_upload_path = gae_GENERATE_FILE;

        Gae_Logger::write_log("Regenerating scrtip start.=========", __FUNCTION__, __LINE__);

        if (!is_dir(gae_GENERATE_PATH) || !file_exists(gae_GENERATE_PATH)) {
            mkdir(gae_GENERATE_PATH, 0655, true);
            if (!is_writable(gae_GENERATE_PATH)) {
                Gae_Admin::add_message("Cant write to file, in directory:" . gae_GENERATE_PATH, "error");
            }
        }

        if (isset($_POST["option_page"]) && $_POST["option_page"] == 'gae-settings-group') {
            //combining the scritps
            $main_file_path = gae_JS_PARTS_PATH . "/gae-main.js";

            $js_parts_to_include = ["gae-variables", "gae-functions"];

            $all_js_parts = self::get_js_parts();
            foreach ($all_js_parts as $js_part) {
                if (isset($_POST[$js_part]) && $_POST[$js_part]) {
                    $js_parts_to_include[] = $js_part;
                }
            }

            $combined_js_content = file_get_contents($main_file_path);
            foreach ($js_parts_to_include as $js_part) {

                $file_to_include = gae_JS_PARTS_PATH . "/$js_part.js";


                $start_text = "\n\n/* ------ $js_part --- $file_to_include ------ STARTS */\n\n";
                $end_text = "\n\n/* ------ $js_part ---  $file_to_include ------ ENDS */\n\n";


                $js_part_content = $start_text . file_get_contents($file_to_include) . $end_text;

                $js_part_content = str_replace("[gae-debug-level]", Gae_Admin::debug(), $js_part_content);
                $js_part_content = str_replace("[gae-script-type]", Gae_Admin::script_type(), $js_part_content);

                $sections = self::get_sections();
                foreach ($sections as $s) {
                    foreach ($s["fields"] as $field) {
                        $js_part_content = str_replace("[" . $field["id"] . "]", $field["value"], $js_part_content);
                    }
                }

                $combined_js_content = str_replace("//[$js_part]", $js_part_content, $combined_js_content);
            }

            if (self::debug()) {
                Gae_Logger::write_log("Trying save regenerated file to subfolder.=========", __FUNCTION__, __LINE__);
                if (is_writable($result_file_path)) {
                    if (file_put_contents($result_file_path, $combined_js_content)) {
                        Gae_Logger::write_log("Result saved to: $result_file_path ", __FUNCTION__, __LINE__);
                        self::add_message("Result saved to: $result_file_path " . gae_GENERATE_PATH, "success");
                    } else {
                        Gae_Logger::write_log("FAILED (can be ignored) save to: $result_file_path ", __FUNCTION__, __LINE__);
                    };
                } else {
                    Gae_Logger::write_log("FAILED (can be ignored) file is not writable: $result_file_path ", __FUNCTION__, __LINE__);
                }
            }

            if (is_writable(dirname($result_file_upload_path))) {
                if (file_put_contents($result_file_upload_path, $combined_js_content)) {
                    self::add_message("Result saved to: $result_file_upload_path " . gae_GENERATE_PATH, "success");
                    Gae_Logger::write_log("Result saved to: $result_file_upload_path ", __FUNCTION__, __LINE__);
                } else {
                    self::add_message("Cant save the generated file. $result_file_upload_path . The folder / file should be writable by php and accessible - readable publicly.", "error");
                    Gae_Logger::write_log("FAILED save to: $result_file_upload_path ", __FUNCTION__, __LINE__);
                };
            } else {
                self::add_message("Folder is not writable. " . dirname($result_file_upload_path), "error");
                Gae_Logger::write_log("FAILED file is not writable: $result_file_upload_path ", __FUNCTION__, __LINE__);
            }
        }

        Gae_Logger::write_log("Regenerating script end.=========", __FUNCTION__, __LINE__);
    }


    public static function add_message($text, $type = "success")
    {
        array_push(self::$messages,["type"=>$type, "message" =>$text]);
    }


    public static function get_sections()
    {
        $options_updated = false;
        $sections = json_decode(file_get_contents(gae_INCLUDES_PATH . "/sections.json"), true);

        foreach ($sections as $sk => $s) {

            foreach ($s["fields"] as $fk => $f) {

                if (isset($_POST[$f["id"]])) {
                    update_option($f["id"], $_POST[$f["id"]]);
                    $sections[$sk]["fields"][$fk]["value"] = $_POST[$f["id"]];
                    $options_updated = true;
                } else {
                    $sections[$sk]["fields"][$fk]["value"] = get_option($f["id"]);
                }
            }
        }
        if ($options_updated) {
            update_option("gae-assets-version", time());
        }
        return $sections;
    }


    public static function is_settings_page()
    {
        //// TODO: check if we are on settings page to load addtional css
        return true;
    }


    public static function add_css()
    {
        echo '<link id="' . gae_PLUGIN_DIRECTORY . '" rel="stylesheet" href="' . gae_CSS_URL . '/gae-admin.css' . '" type="text/css" media="all" />';
    }


    public static function add_scripts()
    {
        if (is_admin()) {
            if (self::is_settings_page()) {
                add_action('admin_head', 'Gae_Admin::add_css');
            }
        }
    }


    public static function add_settings_link_to_plugin_list($links)
    {
        if (ģae_DONATION_SHOW_LINKS) {
            $links[] = '<a target="_blank" href="' . gae_DONATION_URL . '">Donate</a>';
        }
        $links[] = '<a href="' . esc_url(get_admin_url(null, 'options-general.php?page=google-analytics-events/gae_settings_page.php')) . '">Settings</a>';

        ///$links[] = '<a href="http://wp-buddy.com" target="_blank">More plugins by WP-Buddy</a>';
        return $links;
    }


    public static function show_donation_block()
    {
        //todo check the last interaction ignore for a while
        return true;
    }


    public static function script_type()
    {
        // function returs if the googla analytics script used or google tag manager.

        $is_ga = -1;
        switch (get_option("gae-script-type")) {
            case "added-tag-manager":
                $is_ga = 1;
                break;
            case "added-tag-analytics":
                $is_ga = 0;
                break;
            case "added-idk":
                $is_ga = -1;
                break;
            case "tag-manager":
                $is_ga = 2;
                break;
            case "analytics":
                $is_ga = 3;
                break;
            default:
                $is_ga = -1;
                break;
        }
        return $is_ga;

    }

    private static function print_message($id, $message, $type){

        ?>
        <div id="message-<?= $id; ?>" class="gae-message notice notice-<?= $type; ?> is-dismissible">
            <p>
                <?= $message; ?>
            </p>
            <button type="button" class="notice-dismiss">
                <span class="screen-reader-text">Dismiss this notice.</span>
            </button>
        </div>
        <?php
    }


    public static function print_all_messages(){
        foreach(self::$messages as $id => $message){
            self::print_message($id,$message["message"],$message["type"]);
        }
    }


}