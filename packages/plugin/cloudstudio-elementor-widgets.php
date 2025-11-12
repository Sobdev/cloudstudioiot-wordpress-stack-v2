<?php
/**
 * Plugin Name: CloudStudio Elementor Widgets
 * Plugin URI: https://cloud.studio/wordpress-stack
 * Description: Professional Elementor widgets and components for Cloud Studio IoT platform - Built with modern architecture and zero infinite loops.
 * Version: 2.0.0
 * Requires at least: 6.4
 * Requires PHP: 8.0
 * Author: Cloud Studio IoT
 * Author URI: https://cloud.studio
 * License: Proprietary
 * Text Domain: cloudstudio-elementor-widgets
 * Domain Path: /languages
 * Elementor tested up to: 3.18.0
 * Elementor Pro tested up to: 3.18.0
 *
 * @package CloudStudio\ElementorWidgets
 */

namespace CloudStudio\ElementorWidgets;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main Plugin Class
 *
 * @since 2.0.0
 */
final class Plugin {
	/**
	 * Plugin version.
	 *
	 * @var string
	 */
	const VERSION = '2.0.0';

	/**
	 * Minimum Elementor version.
	 *
	 * @var string
	 */
	const MINIMUM_ELEMENTOR_VERSION = '3.10.0';

	/**
	 * Minimum PHP version.
	 *
	 * @var string
	 */
	const MINIMUM_PHP_VERSION = '8.0';

	/**
	 * Instance.
	 *
	 * @var Plugin|null
	 */
	private static ?Plugin $instance = null;

	/**
	 * Get Instance.
	 *
	 * @return Plugin
	 */
	public static function instance(): Plugin {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor.
	 */
	private function __construct() {
		add_action( 'plugins_loaded', [ $this, 'on_plugins_loaded' ] );
	}

	/**
	 * On Plugins Loaded.
	 */
	public function on_plugins_loaded(): void {
		// Check if Elementor is installed and activated.
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_elementor' ] );
			return;
		}

		// Check Elementor version.
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			return;
		}

		// Check PHP version.
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return;
		}

		// Load plugin.
		$this->init();
	}

	/**
	 * Initialize plugin.
	 */
	private function init(): void {
		// Load text domain.
		load_plugin_textdomain( 'cloudstudio-elementor-widgets', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

		// Initialize components.
		add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );
		add_action( 'elementor/elements/categories_registered', [ $this, 'register_categories' ] );
		add_action( 'elementor/editor/before_enqueue_scripts', [ $this, 'editor_scripts' ] );
		add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'frontend_styles' ] );
		add_action( 'elementor/frontend/after_enqueue_scripts', [ $this, 'frontend_scripts' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_scripts' ] );
	}

	/**
	 * Register widgets.
	 *
	 * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
	 */
	public function register_widgets( $widgets_manager ): void {
		// Load widget files only when needed.
		require_once __DIR__ . '/src/widgets/class-button-widget.php';
		require_once __DIR__ . '/src/widgets/class-heading-widget.php';
		require_once __DIR__ . '/src/widgets/class-hero-widget.php';

		// Register widgets.
		$widgets_manager->register( new Widgets\Button_Widget() );
		$widgets_manager->register( new Widgets\Heading_Widget() );
		$widgets_manager->register( new Widgets\Hero_Widget() );
	}

	/**
	 * Register categories.
	 *
	 * @param \Elementor\Elements_Manager $elements_manager Elementor elements manager.
	 */
	public function register_categories( $elements_manager ): void {
		$elements_manager->add_category(
			'cloudstudio',
			[
				'title' => esc_html__( 'Cloud Studio', 'cloudstudio-elementor-widgets' ),
				'icon'  => 'fa fa-cloud',
			]
		);
	}

	/**
	 * Enqueue editor scripts.
	 */
	public function editor_scripts(): void {
		$asset_file = __DIR__ . '/dist/editor.js';
		if ( file_exists( $asset_file ) ) {
			wp_enqueue_script(
				'cloudstudio-editor',
				plugins_url( 'dist/editor.js', __FILE__ ),
				[ 'jquery', 'elementor-editor' ],
				self::VERSION,
				true
			);
		}

		$css_file = __DIR__ . '/dist/css/editor.css';
		if ( file_exists( $css_file ) ) {
			wp_enqueue_style(
				'cloudstudio-editor',
				plugins_url( 'dist/css/editor.css', __FILE__ ),
				[],
				self::VERSION
			);
		}
	}

	/**
	 * Enqueue frontend styles.
	 */
	public function frontend_styles(): void {
		$css_file = __DIR__ . '/dist/css/frontend.css';
		if ( file_exists( $css_file ) ) {
			wp_enqueue_style(
				'cloudstudio-frontend',
				plugins_url( 'dist/css/frontend.css', __FILE__ ),
				[],
				self::VERSION
			);
		}
	}

	/**
	 * Enqueue frontend scripts.
	 */
	public function frontend_scripts(): void {
		$asset_file = __DIR__ . '/dist/frontend.js';
		if ( file_exists( $asset_file ) ) {
			wp_enqueue_script(
				'cloudstudio-frontend',
				plugins_url( 'dist/frontend.js', __FILE__ ),
				[ 'jquery' ],
				self::VERSION,
				true
			);
		}
	}

	/**
	 * Enqueue admin scripts.
	 *
	 * @param string $hook Current admin page hook.
	 */
	public function admin_scripts( string $hook ): void {
		// Only load on plugin pages.
		if ( strpos( $hook, 'cloudstudio' ) === false ) {
			return;
		}

		$asset_file = __DIR__ . '/dist/admin.js';
		if ( file_exists( $asset_file ) ) {
			wp_enqueue_script(
				'cloudstudio-admin',
				plugins_url( 'dist/admin.js', __FILE__ ),
				[ 'jquery' ],
				self::VERSION,
				true
			);
		}

		$css_file = __DIR__ . '/dist/css/admin.css';
		if ( file_exists( $css_file ) ) {
			wp_enqueue_style(
				'cloudstudio-admin',
				plugins_url( 'dist/css/admin.css', __FILE__ ),
				[],
				self::VERSION
			);
		}
	}

	/**
	 * Admin notice - Missing Elementor.
	 */
	public function admin_notice_missing_elementor(): void {
		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'cloudstudio-elementor-widgets' ),
			'<strong>' . esc_html__( 'CloudStudio Elementor Widgets', 'cloudstudio-elementor-widgets' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'cloudstudio-elementor-widgets' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%s</p></div>', wp_kses_post( $message ) );
	}

	/**
	 * Admin notice - Minimum Elementor version.
	 */
	public function admin_notice_minimum_elementor_version(): void {
		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'cloudstudio-elementor-widgets' ),
			'<strong>' . esc_html__( 'CloudStudio Elementor Widgets', 'cloudstudio-elementor-widgets' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'cloudstudio-elementor-widgets' ) . '</strong>',
			self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%s</p></div>', wp_kses_post( $message ) );
	}

	/**
	 * Admin notice - Minimum PHP version.
	 */
	public function admin_notice_minimum_php_version(): void {
		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'cloudstudio-elementor-widgets' ),
			'<strong>' . esc_html__( 'CloudStudio Elementor Widgets', 'cloudstudio-elementor-widgets' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'cloudstudio-elementor-widgets' ) . '</strong>',
			self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%s</p></div>', wp_kses_post( $message ) );
	}
}

// Initialize plugin.
Plugin::instance();
