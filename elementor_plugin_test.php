<?php
/*
Plugin Name:       My Basics Plugin
Plugin URI:        https://example.com/plugins/the-basics/
Description:       Handle the basics with this plugin.
Version:           1.10.3
Requires at least: 5.2
Requires PHP:      7.2
Author:            Imran
Author URI:        https://author.example.com/
 License:           GPL v2 or later
License URI:      elementortest
Text Domain:       my-basics-plugin
 Domain Path:       /languages
 */
 
if(!define('ABSPATH')){
    die(__("Direct Access is not allowed","elementortest"));
}
final class Elementor_Test_Extension {

	const VERSION="1.0.1";
	const MINIMUM_ELEMENTOR_VERSION="2.0.1";
	const MINIMUM_PHP_VERSION="7.0";

	private static $_instance = null;
	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;

	}

	public function __construct() {
        add_action( 'plugins_loaded', [ $this, 'on_plugins_loaded' ] );
    }
	public function init() {
        load_plugin_textdomain( 'elementor-test-extension' );
        // Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
			return false;
        }
        // Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			return false;
        }     
        // Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return false;
        }
        add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );
    }
    public function init_widgets() {

		// Include Widget files
		require_once( __DIR__ . '/widgets/test-widget.php' );

		// Register widget
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor_Test_Widget() );

	}
    public function admin_notice_minimum_php_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'elementortest' ),
			'<strong>' . esc_html__( 'Elementor Test Extension', 'elementortest' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'elementortest' ) . '</strong>',
			 self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}
    public function admin_notice_minimum_elementor_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'elementortest' ),
			'<strong>' . esc_html__( 'Elementor Test Extension', 'elementortest' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'elementortest' ) . '</strong>',
			 self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}
    public function admin_notice_missing_main_plugin() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'elementortest' ),
			'<strong>' . esc_html__( 'Elementor Test Extension', 'elementortest' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'elementortest' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}


	public function includes() {}

}
Elementor_Test_Extension::instance();

 