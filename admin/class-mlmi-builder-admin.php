<?php
/*
* The admin-specific functionality of the plugin.
*/
class MLMI_Builder_Admin {
	
	/*
	* The ID of this plugin.
	*/
	private $plugin_name;
	
	/*
	* The version of this plugin.
	*/
	private $version;
	
	/*
	* Initialize the class and set its properties.
	*/
	public function __construct($plugin_name, $version) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}
	
	/*
	* Register the stylesheets for the admin area.
	*/
	public function enqueue_styles() {
		if (!defined('MLMI_BUILDER_LOAD_ADMIN_CSS') || MLMI_BUILDER_LOAD_ADMIN_CSS){
			wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__).'css/mlmi-builder-admin.css', [], $this->version, 'all');
		}
	}
	
	/*
	* Register the JavaScript for the admin area.
	*/
	public function enqueue_scripts() {
		if (!defined('MLMI_BUILDER_LOAD_ADMIN_JS') || MLMI_BUILDER_LOAD_ADMIN_JS){
			wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__).'js/mlmi-builder-admin.js', ['jquery'], $this->version, true);
		}
	}
}
