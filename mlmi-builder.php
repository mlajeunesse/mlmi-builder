<?php
/*
* Plugin Name:       MLMI Builder
* Plugin URI:        https://mathieulajeunesse.com
* Description:       Outil de construction avancé et extensible de pages Wordpress.
* Version:           0.13.5
* Author:            Mathieu Lajeunesse médias interactifs
* Author URI:        https://mathieulajeunesse.com
* Text Domain:       mlmi-builder
* Domain Path:       /languages
*/

define('MLMI_BUILDER_VERSION', '0.13.5');

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

/*
*	Require general functions
*/
require_once plugin_dir_path(__FILE__).'includes/functions/functions.php';

/*
* Plugin activation.
*/
function mlmi_builder_activate() {
	require_once plugin_dir_path(__FILE__).'includes/core/class-mlmi-builder-activator.php';
	MLMI_Builder_Activator::activate();
}
register_activation_hook(__FILE__, 'mlmi_builder_activate');

/*
* Plugin deactivation.
*/
function mlmi_builder_deactivate() {
	require_once plugin_dir_path(__FILE__).'includes/core/class-mlmi-builder-deactivator.php';
	MLMI_Builder_Deactivator::deactivate();
}
register_deactivation_hook(__FILE__, 'mlmi_builder_deactivate');

/*
* Core plugin class
*/
require plugin_dir_path(__FILE__).'includes/class-mlmi-builder.php';

/*
* Begins execution of the plugin.
*/
function mlmi_builder_run() {
	// Check for ACF Pro requirement
  require_once ABSPATH.'/wp-admin/includes/plugin.php';
	if (!is_plugin_active('advanced-custom-fields-pro/acf.php')) {
    add_action('admin_notices', 'mlmi_builder_notice_acf_pro_missing');
    deactivate_plugins(plugin_basename(__FILE__));
	
	// Check for legacy grid requirement
	} else if (is_admin() && !get_option('mlmi_builder_version') && !defined('MLMI_BUILDER_USE_LEGACY_GRID')) {
		add_action('admin_notices', 'mlmi_builder_notice_use_legacy_grid');
    
  // All checks passed: run plugin
  } else {
		$mlmi_builder = new MLMI_Builder();
		$mlmi_builder->run();
	}
}
mlmi_builder_run();
