<?php

/**
 * Plugin Name: Hostarling Elementor Galleries
 * Description: Custom Elementor widgets for creating fancy and awesome galleries.
 * Plugin URI:  https://hostarling.com
 * Version:     1.0.0
 * Author:      Abdallah Oraby
 * Author URI:  https://github.com/abdallahoraby
 * License: GPL3
 * Text Domain: hostarling-elementor-kit
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
* Main Hostarling Extension Class
 *
 * The main class that initiates and runs the plugin.
 *
 * @since 1.0.0
 */
final class Hostarling_Extension {

	/**
	 * Plugin Version
	 *
	 * @since 1.0.0
	 *
	 * @var string The plugin version.
	 */
	const VERSION = '1.0.0';

	/**
	 * Minimum Elementor Version
	 *
	 * @since 1.0.0
	 *
	 * @var string Minimum Elementor version required to run the plugin.
	 */
	const MINIMUM_ELEMENTOR_VERSION = '2.5.11';

	/**
	 * Minimum PHP Version
	 *
	 *
	 * @since 1.0.0
	 *
	 * @var string Minimum PHP version required to run the plugin.
	 */
	const MINIMUM_PHP_VERSION = '6.0';

	/**
	 * Instance
	 *
	 * @since 1.0.0
	 *
	 * @access private
	 * @static
	 *
	 * @var Hostarling_Extension The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 * @static
	 *
	 * @return Hostarling_Extension An instance of the class.
	 */
	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */

	public function __construct() {
		add_action( 'init', [ $this, 'i18n' ] );
		add_action( 'plugins_loaded', [ $this, 'init' ] );
	}

	/**
	 * Load Textdomain
	 *
	 * Load plugin localization files.
	 *
	 * Fired by `init` action hook.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function i18n() {}

	/**
	 * Initialize the plugin
	 *
	 * Load the plugin only after Elementor (and other plugins) are loaded.
	 * Checks for basic plugin requirements, if one check fail don't continue,
	 * if all check have passed load the files required to run the plugin.
	 *
	 * Fired by `plugins_loaded` action hook.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function init() {

		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
			return;
		}

		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			return;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return;
		}

		// Add Plugin actions
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );

		// Register Widget Styles
		add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'widget_styles' ] );


		function create_hostarling_widgets_categories( $elements_manager ) {

			$elements_manager->add_category(
				'hostarling-widgets',
				[
					'title' => __( 'Hostarling Galleries', 'hostarling-elementor-kit' ),
					'icon' => 'far fa-images',
				]
			);
		}
		add_action( 'elementor/elements/categories_registered', 'create_hostarling_widgets_categories' );

	}

	public function widget_styles() {
		wp_enqueue_style( 'hostarling-styles', plugins_url( '/css/styles.css', __FILE__ ), '', rand() );
		wp_enqueue_script("jquery");
	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have Elementor installed or activated.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_missing_main_plugin() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
		/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'hostarling-elementor-kit' ),
			'<strong>' . esc_html__( 'Hostarling Elementor Galleries', 'hostarling-elementor-kit' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'hostarling-elementor-kit' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required Elementor version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_minimum_elementor_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
		/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'hostarling-elementor-kit' ),
			'<strong>' . esc_html__( 'Hostarling Elementor Galleries', 'hostarling-elementor-kit' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'hostarling-elementor-kit' ) . '</strong>',
			self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Admin notice
	 *
	 * Warning when the site doesn't have a minimum required PHP version.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function admin_notice_minimum_php_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
		/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'hostarling-elementor-kit' ),
			'<strong>' . esc_html__( 'Hostarling Elementor Galleries', 'hostarling-elementor-kit' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'hostarling-elementor-kit' ) . '</strong>',
			self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	/**
	 * Init Widgets
	 *
	 * Include widgets files and register them
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function init_widgets() {

		// Include Widget files
		require_once( __DIR__ . '/widgets/accordion-gallery.php' );
		require_once( __DIR__ . '/widgets/hexa-gallery.php' );
		require_once( __DIR__ . '/widgets/accordion-two-gallery.php' );
		require_once( __DIR__ . '/widgets/cube-3d-gallery.php' );


		// Register widget
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \hostarlingAccordiongallery() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \hostarlingHexaGallery() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \hostarlingAccordionTwogallery() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \hostarlingCube3DGallery() );


	}

}

Hostarling_Extension::instance();



add_action( 'elementor/editor/after_enqueue_styles' , 'load_editor_styles');
function load_editor_styles(){
	wp_enqueue_style( 'hostarling-editor-styles', plugins_url( '/css/editor-styles.css', __FILE__ ), '', rand() );
}

