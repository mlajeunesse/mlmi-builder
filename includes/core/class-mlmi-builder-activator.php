<?php
/*
* Fired during plugin activation.
*/
class MLMI_Builder_Activator {
	
	public static function activate() {
		update_option('mlmi_builder_version', MLMI_BUILDER_VERSION);
	}
	
}
