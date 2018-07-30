<?php
/**
 * Class description
 *
 * @package   package_name
 * @author    Cherry Team
 * @license   GPL-2.0+
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Jet_Widgets_Integration' ) ) {

	/**
	 * Define Jet_Widgets_Integration class
	 */
	class Jet_Widgets_Integration {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since 1.0.0
		 * @var   object
		 */
		private static $instance = null;

		/**
		 * Check if processing elementor widget
		 *
		 * @var boolean
		 */
		private $is_elementor_ajax = false;

		/**
		 * Localize data array
		 *
		 * @var array
		 */
		public $localize_data = array();

		/**
		 * Initalize integration hooks
		 *
		 * @return void
		 */
		public function init() {

			add_action( 'elementor/init', array( $this, 'register_category' ) );

			add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_addons' ), 10 );
			add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_vendor_addons' ), 20 );

			add_action( 'elementor/controls/controls_registered', array( $this, 'add_controls' ), 10 );

			add_action( 'wp_ajax_elementor_render_widget', array( $this, 'set_elementor_ajax' ), 10, -1 );

			add_action( 'elementor/frontend/before_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
			add_action( 'elementor/editor/before_enqueue_scripts', array( $this, 'editor_scripts' ) );
			add_action( 'elementor/editor/after_enqueue_styles', array( $this, 'editor_styles' ) );

			// Frontend messages
			$this->localize_data['messages'] = array(
				'invalidMail' => esc_html__( 'Please specify a valid e-mail', 'jet-widgets' ),
			);
		}

		/**
		 * Enqueue editor styles
		 *
		 * @return void
		 */
		public function editor_styles() {

			wp_enqueue_style(
				'jet-widgets-font',
				jet_widgets()->plugin_url( 'assets/css/lib/jetwidgets-font/css/jetwidgets.css' ),
				array(),
				jet_widgets()->get_version()
			);

		}

		/**
		 * Enqueue plugin scripts only with elementor scripts
		 *
		 * @return void
		 */
		public function enqueue_scripts() {
			wp_enqueue_script(
				'jet-widgets',
				jet_widgets()->plugin_url( 'assets/js/jet-widgets.js' ),
				array( 'jquery', 'elementor-frontend', 'cherry-handler-js' ),
				jet_widgets()->get_version(),
				true
			);

			wp_localize_script(
				'jet-widgets',
				'jetWidgets',
				apply_filters( 'jet-widgets/frontend/localize-data', $this->localize_data )
			);
		}

		/**
		 * Enqueue plugin scripts only with elementor scripts
		 *
		 * @return void
		 */
		public function editor_scripts() {
			wp_enqueue_script(
				'jet-widgets-editor',
				jet_widgets()->plugin_url( 'assets/js/jet-widgets-editor.js' ),
				array( 'jquery' ),
				jet_widgets()->get_version(),
				true
			);
		}

		/**
		 * Set $this->is_elementor_ajax to true on Elementor AJAX processing
		 *
		 * @return  void
		 */
		public function set_elementor_ajax() {
			$this->is_elementor_ajax = true;
		}

		/**
		 * Check if we currently in Elementor mode
		 *
		 * @return void
		 */
		public function in_elementor() {

			$result = false;

			if ( wp_doing_ajax() ) {
				$result = $this->is_elementor_ajax;
			} elseif ( Elementor\Plugin::instance()->editor->is_edit_mode()
				|| Elementor\Plugin::instance()->preview->is_preview_mode() ) {
				$result = true;
			}

			/**
			 * Allow to filter result before return
			 *
			 * @var bool $result
			 */
			return apply_filters( 'jet-widgets/in-elementor', $result );
		}

		/**
		 * Register plugin addons
		 *
		 * @param  object $widgets_manager Elementor widgets manager instance.
		 * @return void
		 */
		public function register_addons( $widgets_manager ) {

			$avaliable_widgets = jet_widgets_settings()->get( 'avaliable_widgets' );

			require jet_widgets()->plugin_path( 'includes/base/class-jet-widgets-base.php' );

			foreach ( glob( jet_widgets()->plugin_path( 'includes/addons/' ) . '*.php' ) as $file ) {
				$slug = basename( $file, '.php' );

				$enabled = isset( $avaliable_widgets[ $slug ] ) ? $avaliable_widgets[ $slug ] : '';

				if ( filter_var( $enabled, FILTER_VALIDATE_BOOLEAN ) || ! $avaliable_widgets ) {
					$this->register_addon( $file, $widgets_manager );
				}
			}
		}

		/**
		 * Register vendor addons
		 *
		 * @param  object $widgets_manager Elementor widgets manager instance.
		 * @return void
		 */
		public function register_vendor_addons( $widgets_manager ) {

			$allowed_vendors = apply_filters(
				'jet-widgets/allowed-vendor-addons',
				array(
					'contact_form7' => array(
						'file' => jet_widgets()->plugin_path(
							'includes/addons/vendor/jet-widgets-contact-form7.php'
						),
						'conditional' => array(
							'cb'  => 'defined',
							'arg' => 'WPCF7_PLUGIN_URL',
						),
					),
				)
			);

			foreach ( $allowed_vendors as $vendor ) {
				if ( is_callable( $vendor['conditional']['cb'] )
					&& true === call_user_func( $vendor['conditional']['cb'], $vendor['conditional']['arg'] ) ) {
					$this->register_addon( $vendor['file'], $widgets_manager );
				}
			}
		}

		/**
		 * Add new controls.
		 *
		 * @param  object $controls_manager Controls manager instance.
		 * @return void
		 */
		public function add_controls( $controls_manager ) {

			$grouped = array(
				'jet-widgets-box-style' => 'Jet_Widgets_Group_Control_Box_Style',
			);

			foreach ( $grouped as $control_id => $class_name ) {
				if ( $this->include_control( $class_name, true ) ) {
					$controls_manager->add_group_control( $control_id, new $class_name() );
				}
			}
		}

		/**
		 * Include control file by class name.
		 *
		 * @param  [type] $class_name [description]
		 * @return [type]             [description]
		 */
		public function include_control( $class_name, $grouped = false ) {

			$filename = sprintf(
				'includes/controls/%2$sclass-%1$s.php',
				str_replace( '_', '-', strtolower( $class_name ) ),
				( true === $grouped ? 'groups/' : '' )
			);

			if ( ! file_exists( jet_widgets()->plugin_path( $filename ) ) ) {
				return false;
			}

			require jet_widgets()->plugin_path( $filename );

			return true;
		}

		/**
		 * Register addon by file name
		 *
		 * @param  string $file            File name.
		 * @param  object $widgets_manager Widgets manager instance.
		 * @return void
		 */
		public function register_addon( $file, $widgets_manager ) {

			$base  = basename( str_replace( '.php', '', $file ) );
			$class = ucwords( str_replace( '-', ' ', $base ) );
			$class = str_replace( ' ', '_', $class );
			$class = sprintf( 'Elementor\%s', $class );

			require $file;

			if ( class_exists( $class ) ) {
				$widgets_manager->register_widget_type( new $class );
			}
		}

		/**
		 * Register cherry category for elementor if not exists
		 *
		 * @return void
		 */
		public function register_category() {

			$elements_manager = Elementor\Plugin::instance()->elements_manager;
			$cherry_cat       = 'jet-widgets';

			$elements_manager->add_category(
				$cherry_cat,
				array(
					'title' => esc_html__( 'JetWidgets', 'jet-widgets' ),
					'icon'  => 'font',
				),
				1
			);
		}

		/**
		 * Returns the instance.
		 *
		 * @since  1.0.0
		 * @return object
		 */
		public static function get_instance( $shortcodes = array() ) {

			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self( $shortcodes );
			}
			return self::$instance;
		}
	}

}

/**
 * Returns instance of Jet_Widgets_Integration
 *
 * @return object
 */
function jet_widgets_integration() {
	return Jet_Widgets_Integration::get_instance();
}
