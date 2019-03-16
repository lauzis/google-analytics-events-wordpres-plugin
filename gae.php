<?php
/*
Plugin Name: GAE - Google analytics events wordpress plugin
Plugin URI: https://github.com/lauzis/google-analytics-events-wordpres-plugin
Description: The plugin that adds some basic events to the site, to track clikcs on cta buttons and forms.
Version: 0.9.7
Author: Aivars Lauzis
Author URI: https://github.com/lauzis
License: GPL3
*/

/*
		Aivars Lauzis  (email : lauzis@inbox.lv)
		This plugin is started by using plugin template (EPT plugin)
		EPT - Empty Plugin Template.
        At current stage, there not much left of initial plugin, but anyway wanted to shout out for the guy/guys.
		http://1manfactory.com/ept
		Author: Juergen Schulze, 1manfactory@gmail.com
		Author URI: http://1manfactory.com
*/

require_once("inc/constants.php");
require_once("inc/Gae_Logger.php");
require_once("inc/Gae_Admin.php");
require_once("inc/Gae_Frontend.php");

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

register_activation_hook(__FILE__, 'Gae_Admin::activate');
register_deactivation_hook(__FILE__, 'Gae_Admin::deactivate');
register_uninstall_hook(__FILE__, 'Gae_Admin::uninstall');

require_once("inc/hooks.php");

if (gae_DEVELOPER && isset($_GET["generate-pot-file"])){
    Gae_Admin::generate_pot_file();
}