<?php

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Jet_Widgets_Assets' ) ) {

	/**
	 * Define Jet_Widgets_Assets class
	 */
	class Jet_Widgets_Assets {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since 1.0.0
		 * @var   object
		 */
		private static $instance = null;

		/**
		 * Constructor for the class
		 */
		public function init() {
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
			add_action( 'elementor/frontend/before_register_scripts', array( $this, 'register_scripts' ) );
			add_action( 'admin_enqueue_scripts',  array( $this, 'admin_enqueue_styles' ) );
		}

		/**
		 * Enqueue public-facing stylesheets.
		 *
		 * @since 1.0.0
		 * @access public
		 * @return void
		 */
		public function enqueue_styles() {

			wp_enqueue_style(
				'jet-widgets',
				jet_widgets()->plugin_url( 'assets/css/jet-widgets.css' ),
				false,
				jet_widgets()->get_version()
			);

			if ( is_rtl() ) {
				wp_enqueue_style(
					'jet-widgets-rtl',
					jet_widgets()->plugin_url( 'assets/css/jet-widgets-rtl.css' ),
					false,
					jet_widgets()->get_version()
				);
			}

			$default_theme_enabled = apply_filters( 'jet-widgets/assets/css/default-theme-enabled', true );

			if ( ! $default_theme_enabled ) {
				return;
			}

			wp_enqueue_style(
				'jet-widgets-skin',
				jet_widgets()->plugin_url( 'assets/css/jet-widgets-skin.css' ),
				false,
				jet_widgets()->get_version()
			);

			// Register vendor twentytwenty-css styles
			wp_enqueue_style(
				'jet-juxtapose-css',
				jet_widgets()->plugin_url( 'assets/css/lib/juxtapose/juxtapose.css' ),
				false,
				'1.3.0'
			);
		}

		/**
		 * Register plugin scripts
		 *
		 * @return void
		 */
		public function register_scripts() {
			// Register vendor isotope.js script (https://github.com/rnmp/salvattore)
			wp_register_script(
				'jet-salvattore',
				jet_widgets()->plugin_url( 'assets/js/lib/salvattore/salvattore.min.js' ),
				array(),
				'1.0.9',
				true
			);

			// Register vendor jquery.twentytwenty.js script
			wp_register_script(
				'jet-juxtapose',
				jet_widgets()->plugin_url( 'assets/js/lib/juxtapose/juxtapose.min.js' ),
				array(),
				'1.3.0',
				true
			);
		}

		/**
		 * Enqueue admin styles
		 *
		 * @return void
		 */
		public function admin_enqueue_styles() {
			$screen = get_current_screen();

			// Jet setting page check
			if ( 'elementor_page_jet-widgets-settings' === $screen->base ) {
				wp_enqueue_style(
					'jet-widgets-admin-css',
					jet_widgets()->plugin_url( 'assets/css/jet-widgets-admin.css' ),
					false,
					jet_widgets()->get_version()
				);
			}
		}

		/**
		 * Returns the instance.
		 *
		 * @since  1.0.0
		 * @return object
		 */
		public static function get_instance() {

			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self;
			}
			return self::$instance;
		}
	}

}

/**
 * Returns instance of Jet_Widgets_Assets
 *
 * @return object
 */
function jet_widgets_assets() {
	return Jet_Widgets_Assets::get_instance();
}
