<?php
/**
 * MLMI Builder
 */
class MLMI_Builder {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 */
	public function __construct() {
		if ( defined( 'MLMI_BUILDER_VERSION' ) ) {
			$this->version = MLMI_BUILDER_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'mlmi-builder';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 */
	private function load_dependencies() {

        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/functions/functions.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/types/type-acf.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/core/class-mlmi-builder-loader.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/core/class-mlmi-builder-i18n.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-mlmi-builder-admin.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-mlmi-builder-public.php';

		$this->loader = new MLMI_Builder_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 */
	private function set_locale() {

		$plugin_i18n = new MLMI_Builder_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality.
	 */
	private function define_admin_hooks() {

		$plugin_admin = new MLMI_Builder_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality.
	 */
	private function define_public_hooks() {

		$plugin_public = new MLMI_Builder_Public( $this->get_plugin_name(), $this->get_version() );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
