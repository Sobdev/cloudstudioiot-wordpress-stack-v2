<?php
/**
 * CloudStudio Hello Child Theme Functions
 *
 * @package CloudStudio\Theme
 * @since 2.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Theme version.
 */
define( 'CLOUDSTUDIO_THEME_VERSION', '2.0.0' );

/**
 * Enqueue parent theme styles.
 */
function cloudstudio_enqueue_parent_styles(): void {
	wp_enqueue_style(
		'hello-elementor',
		get_template_directory_uri() . '/style.css',
		[],
		wp_get_theme()->parent()->get( 'Version' )
	);
}
add_action( 'wp_enqueue_scripts', 'cloudstudio_enqueue_parent_styles' );

/**
 * Enqueue child theme styles.
 */
function cloudstudio_enqueue_child_styles(): void {
	$css_file = get_stylesheet_directory() . '/dist/css/style.css';
	
	if ( file_exists( $css_file ) ) {
		wp_enqueue_style(
			'cloudstudio-child-style',
			get_stylesheet_directory_uri() . '/dist/css/style.css',
			[ 'hello-elementor', 'elementor-frontend' ],
			CLOUDSTUDIO_THEME_VERSION
		);
	}
}
add_action( 'wp_enqueue_scripts', 'cloudstudio_enqueue_child_styles', 999 );

/**
 * Enqueue child theme scripts.
 */
function cloudstudio_enqueue_child_scripts(): void {
	$js_file = get_stylesheet_directory() . '/dist/main.js';
	
	if ( file_exists( $js_file ) ) {
		wp_enqueue_script(
			'cloudstudio-child-script',
			get_stylesheet_directory_uri() . '/dist/main.js',
			[ 'jquery' ],
			CLOUDSTUDIO_THEME_VERSION,
			true
		);

		// Localize script with theme data.
		wp_localize_script(
			'cloudstudio-child-script',
			'cloudstudioTheme',
			[
				'version'   => CLOUDSTUDIO_THEME_VERSION,
				'ajaxUrl'   => admin_url( 'admin-ajax.php' ),
				'nonce'     => wp_create_nonce( 'cloudstudio_nonce' ),
				'isRTL'     => is_rtl(),
				'isDarkMode' => get_theme_mod( 'cloudstudio_dark_mode', false ),
			]
		);
	}
}
add_action( 'wp_enqueue_scripts', 'cloudstudio_enqueue_child_scripts' );

/**
 * Add theme support.
 */
function cloudstudio_theme_support(): void {
	// Add support for editor styles.
	add_theme_support( 'editor-styles' );

	// Add support for responsive embeds.
	add_theme_support( 'responsive-embeds' );

	// Add support for custom logo.
	add_theme_support(
		'custom-logo',
		[
			'height'      => 100,
			'width'       => 400,
			'flex-height' => true,
			'flex-width'  => true,
		]
	);
}
add_action( 'after_setup_theme', 'cloudstudio_theme_support' );

/**
 * Register customizer settings.
 */
function cloudstudio_customize_register( WP_Customize_Manager $wp_customize ): void {
	// Add section for theme options.
	$wp_customize->add_section(
		'cloudstudio_options',
		[
			'title'    => esc_html__( 'CloudStudio Options', 'cloudstudio-hello-child' ),
			'priority' => 30,
		]
	);

	// Dark mode setting.
	$wp_customize->add_setting(
		'cloudstudio_dark_mode',
		[
			'default'           => false,
			'sanitize_callback' => 'rest_sanitize_boolean',
		]
	);

	$wp_customize->add_control(
		'cloudstudio_dark_mode',
		[
			'label'   => esc_html__( 'Enable Dark Mode by Default', 'cloudstudio-hello-child' ),
			'section' => 'cloudstudio_options',
			'type'    => 'checkbox',
		]
	);
}
add_action( 'customize_register', 'cloudstudio_customize_register' );

/**
 * Add body classes.
 */
function cloudstudio_body_classes( array $classes ): array {
	if ( get_theme_mod( 'cloudstudio_dark_mode', false ) ) {
		$classes[] = 'cloudstudio-dark-mode';
	}

	return $classes;
}
add_filter( 'body_class', 'cloudstudio_body_classes' );
