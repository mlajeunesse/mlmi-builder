<?php

/**
* Plugin Name:       MLMI Builder
* Plugin URI:        https://mathieulajeunesse.com
* Description:       Outil de construction avancé et extensible de pages Wordpress.
* Version:           0.9.17
* Author:            Mathieu Lajeunesse médias interactifs
* Author URI:        https://mathieulajeunesse.com
* Text Domain:       mlmi-builder
* Domain Path:       /languages
*/

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}

/**
* Currently plugin version.
*/
define('MLMI_BUILDER_VERSION', '0.9.17');

/**
* The code that runs during plugin activation.
*/
function activate_mlmi_builder() {
	require_once plugin_dir_path(__FILE__).'includes/core/class-mlmi-builder-activator.php';
	MLMI_Builder_Activator::activate();
}

/**
* The code that runs during plugin deactivation.
*/
function deactivate_mlmi_builder() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/core/class-mlmi-builder-deactivator.php';
	MLMI_Builder_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_mlmi_builder' );
register_deactivation_hook( __FILE__, 'deactivate_mlmi_builder' );

/**
* The core plugin class
*/
require plugin_dir_path( __FILE__ ) . 'includes/class-mlmi-builder.php';

/**
* Begins execution of the plugin.
*/
function run_mlmi_builder()
{
	// Run the plugin
	$mlmi_builder = new MLMI_Builder();
	$mlmi_builder->run();
}
run_mlmi_builder();
