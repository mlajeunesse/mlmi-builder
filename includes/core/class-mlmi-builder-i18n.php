<?php
/**
 * Define the internationalization functionality.
 */
class MLMI_Builder_i18n {

	/**
	 * Load the plugin text domain for translation.
	 */
	public function load_plugin_textdomain() {
		load_plugin_textdomain('mlmi-builder', false, 'mlmi-builder/languages');
	}
}
