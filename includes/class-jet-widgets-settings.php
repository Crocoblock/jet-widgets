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

if ( ! class_exists( 'Jet_Widgets_Settings' ) ) {

	/**
	 * Define Jet_Widgets_Settings class
	 */
	class Jet_Widgets_Settings {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since  1.0.0
		 * @access private
		 * @var    object
		 */
		private static $instance = null;

		/**
		 * [$key description]
		 * @var string
		 */
		public $key = 'jet-widgets-settings';

		/**
		 * [$builder description]
		 * @var null
		 */
		public $builder  = null;

		/**
		 * [$settings description]
		 * @var null
		 */
		public $settings = null;

		/**
		 * Avaliable Widgets array
		 *
		 * @var array
		 */
		public $avaliable_widgets = array();

		/**
		 * Init page
		 */
		public function init() {

			$this->init_builder();

			add_action( 'admin_menu', array( $this, 'register_page' ), 99 );
			add_action( 'init', array( $this, 'save' ), 40 );
			add_action( 'admin_notices', array( $this, 'saved_notice' ) );

			foreach ( glob( jet_widgets()->plugin_path( 'includes/addons/' ) . '*.php' ) as $file ) {
				$data = get_file_data( $file, array( 'class'=>'Class', 'name' => 'Name', 'slug'=>'Slug' ) );

				$slug = basename( $file, '.php' );
				$this->avaliable_widgets[ $slug ] = $data['name'];
			}
		}

		/**
		 * Initialize page builder module if reqired
		 *
		 * @return [type] [description]
		 */
		public function init_builder() {

			if ( isset( $_REQUEST['page'] ) && $this->key === $_REQUEST['page'] ) {
				$this->builder = jet_widgets()->get_core()->init_module( 'cherry-interface-builder', array() );
			}
		}

		/**
		 * Show saved notice
		 *
		 * @return bool
		 */
		public function saved_notice() {

			if ( ! isset( $_GET['settings-saved'] ) ) {
				return false;
			}

			$message = esc_html__( 'Settings saved', 'jetwidgets-for-elementor' );

			printf( '<div class="notice notice-success is-dismissible"><p>%s</p></div>', $message );

			return true;

		}

		/**
		 * Returns allowed options list
		 *
		 * @return array
		 */
		public function allowed_settings() {
			return apply_filters( 'jet-widgets/allowed-settings', array(
				'svg_uploads',
				'mailchimp-api-key',
				'mailchimp-list-id',
				'mailchimp-double-opt-in',
				'avaliable_widgets',
			) );
		}

		/**
		 * validate given setting
		 *
		 * @return [type] [description]
		 */
		public function sanitize_setting( $input ) {

			if ( is_array( $input ) ) {

				$sanitized = array();

				foreach ( $input as $key => $value ) {
					$sanitized[ $key ] = $this->sanitize_setting( $value );
				}

				return $sanitized;

			} else {
				return sanitize_text_field( $input );
			}

		}

		/**
		 * Save settings
		 *
		 * @return void
		 */
		public function save() {

			if ( ! isset( $_REQUEST['page'] ) || $this->key !== $_REQUEST['page'] ) {
				return;
			}

			if ( ! isset( $_REQUEST['action'] ) || 'save-settings' !== $_REQUEST['action'] ) {
				return;
			}

			if ( ! current_user_can( 'manage_options' ) ) {
				return;
			}

			$current = get_option( $this->key, array() );
			$data    = array();

			foreach ( $this->allowed_settings() as $setting ) {
				$default             = isset( $current[ $setting ] ) ? $current[ $setting ] : false;
				$current[ $setting ] = isset( $_POST[ $setting ] ) ? $this->sanitize_setting( $_POST[ $setting ] ) : $default;
			}

			update_option( $this->key, $current );

			$redirect = add_query_arg(
				array( 'dialog-saved' => true ),
				$this->get_settings_page_link()
			);

			wp_redirect( $redirect );
			die();

		}

		/**
		 * Return settings page URL
		 *
		 * @return string
		 */
		public function get_settings_page_link() {

			return add_query_arg(
				array(
					'page' => $this->key,
				),
				esc_url( admin_url( 'admin.php' ) )
			);

		}

		public function get( $setting, $default = false ) {

			if ( null === $this->settings ) {
				$this->settings = get_option( $this->key, array() );
			}

			return isset( $this->settings[ $setting ] ) ? $this->settings[ $setting ] : $default;

		}

		/**
		 * Register add/edit page
		 *
		 * @return void
		 */
		public function register_page() {

			add_submenu_page(
				'elementor',
				esc_html__( 'JetWidgets Settings', 'jetwidgets-for-elementor' ),
				esc_html__( 'JetWidgets Settings', 'jetwidgets-for-elementor' ),
				'manage_options',
				$this->key,
				array( $this, 'render_page' )
			);

		}

		/**
		 * Render settings page
		 *
		 * @return void
		 */
		public function render_page() {

			foreach ( $this->avaliable_widgets as $key => $value ) {
				$default_avaliable_widgets[ $key ] = 'true';
			}

			$this->builder->register_section(
				array(
					'jet_widgets_settings' => array(
						'type'   => 'section',
						'scroll' => false,
						'title'  => esc_html__( 'JetWidgets Settings', 'jetwidgets-for-elementor' ),
					),
				)
			);

			$this->builder->register_form(
				array(
					'jet_widgets_settings_form' => array(
						'type'   => 'form',
						'parent' => 'jet_widgets_settings',
						'action' => add_query_arg(
							array( 'page' => $this->key, 'action' => 'save-settings' ),
							esc_url( admin_url( 'admin.php' ) )
						),
					),
				)
			);

			$this->builder->register_settings(
				array(
					'settings_top' => array(
						'type'   => 'settings',
						'parent' => 'jet_widgets_settings_form',
					),
					'settings_bottom' => array(
						'type'   => 'settings',
						'parent' => 'jet_widgets_settings_form',
					),
				)
			);

			$this->builder->register_component(
				array(
					'jet_widgets_tab_vertical' => array(
						'type'   => 'component-tab-vertical',
						'parent' => 'settings_top',
					),
				)
			);

			$this->builder->register_settings(
				array(
					'general_tab' => array(
						'parent'      => 'jet_widgets_tab_vertical',
						'title'       => esc_html__( 'General settings', 'jetwidgets-for-elementor' ),
					),
					'mailing_options' => array(
						'parent'      => 'jet_widgets_tab_vertical',
						'title'       => esc_html__( 'Mailing List Manager', 'jetwidgets-for-elementor' ),
					),
					'avaliable_widgets_options' => array(
						'parent'      => 'jet_widgets_tab_vertical',
						'title'       => esc_html__( 'Available Widgets', 'jetwidgets-for-elementor' ),
					),
				)
			);

			$controls = apply_filters( 'jet-widgets/settings-page/controls-list',
				array(
					'svg_uploads' => array(
						'type'        => 'select',
						'id'          => 'svg_uploads',
						'name'        => 'svg_uploads',
						'parent'      => 'general_tab',
						'value'       => $this->get( 'svg_uploads', 'enabled' ),
						'options'     => array(
							'enabled'  => esc_html__( 'Enabled', 'jetwidgets-for-elementor' ),
							'disabled' => esc_html__( 'Disabled', 'jetwidgets-for-elementor' ),
						),
						'title'       => esc_html__( 'SVG images upload status:', 'jetwidgets-for-elementor' ),
						'description' => esc_html__( 'Enable or disable SVG images uploading', 'jetwidgets-for-elementor' ),
					),

					'mailchimp-api-key' => array(
						'type'         => 'text',
						'parent'       => 'mailing_options',
						'title'        => esc_html__( 'MailChimp API key', 'jetwidgets-for-elementor' ),
						'placeholder'  => esc_html__( 'MailChimp API key', 'jetwidgets-for-elementor' ),
						'description'  => sprintf( '%1$s <a href="http://kb.mailchimp.com/integrations/api-integrations/about-api-keys">%2$s</a>', esc_html__( 'Input your MailChimp API key', 'jetwidgets-for-elementor' ), esc_html__( 'About API Keys', 'jetwidgets-for-elementor' ) ),
						'value'        => $this->get( 'mailchimp-api-key' ),
						'class'        => '',
						'label'        => '',
					),

					'mailchimp-list-id' => array(
						'type'         => 'text',
						'parent'       => 'mailing_options',
						'title'        => esc_html__( 'MailChimp list ID', 'jetwidgets-for-elementor' ),
						'placeholder'  => esc_html__( 'MailChimp list ID', 'jetwidgets-for-elementor' ),
						'description'  => sprintf( '%1$s <a href="http://kb.mailchimp.com/lists/managing-subscribers/find-your-list-id">%2$s</a>', esc_html__( 'MailChimp list ID', 'jetwidgets-for-elementor' ), esc_html__( 'list ID', 'jetwidgets-for-elementor' ) ),
						'value'        => $this->get( 'mailchimp-list-id' ),
						'class'        => '',
						'label'        => '',
					),

					'mailchimp-double-opt-in' => array(
						'type'        => 'switcher',
						'parent'      => 'mailing_options',
						'title'       => esc_html__( 'Double opt-in', 'jetwidgets-for-elementor' ),
						'description' => esc_html__( 'Send contacts an opt-in confirmation email when they subscribe to your list.', 'jetwidgets-for-elementor' ),
						'value'       => $this->get( 'mailchimp-double-opt-in' ),
						'toggle'      => array(
							'true_toggle'  => 'On',
							'false_toggle' => 'Off',
						),
					),

					'avaliable_widgets' => array(
						'type'        => 'checkbox',
						'id'          => 'avaliable_widgets',
						'name'        => 'avaliable_widgets',
						'parent'      => 'avaliable_widgets_options',
						'value'       => $this->get( 'avaliable_widgets', $default_avaliable_widgets ),
						'options'     => $this->avaliable_widgets,
						'title'       => esc_html__( 'Available Widgets', 'jetwidgets-for-elementor' ),
						'description' => esc_html__( 'List of widgets that will be available when editing the page', 'jetwidgets-for-elementor' ),
						'class'       => 'jet_widgets_settings_form__checkbox-group'
					),
				)
			);

			$this->builder->register_control( $controls );

			$this->builder->register_html(
				array(
					'save_button' => array(
						'type'   => 'html',
						'parent' => 'settings_bottom',
						'class'  => 'cherry-control dialog-save',
						'html'   => '<button type="submit" class="button button-primary">' . esc_html__( 'Save', 'jetwidgets-for-elementor' ) . '</button>',
					),
				)
			);

			echo '<div class="jet-widgets-settings-page">';
				$this->builder->render();
				$this->render_banner_html();
			echo '</div>';
		}

		/**
		 * Render banner html.
		 */
		public function render_banner_html() {
			$html = '<div class="jet-widgets-banner">
						<a class="jet-widgets-banner__link" href="https://crocoblock.com/plugins/jetelements/?_refer=crocoblock&utm_source=wpadmin&utm_medium=banner&utm_campaign=jetwidgets" target="_blank">
							<img class="jet-widgets-banner__img" src="%1$s" alt="%2$s">
						</a>
					</div>';

			printf( $html, jet_widgets()->plugin_url( 'assets/images/banner.png' ), esc_attr__( 'Crocoblock', 'jetwidgets-for-elementor' ) );
		}

		/**
		 * Returns the instance.
		 *
		 * @since  1.0.0
		 * @access public
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
 * Returns instance of Jet_Widgets_Settings
 *
 * @return object
 */
function jet_widgets_settings() {
	return Jet_Widgets_Settings::get_instance();
}

jet_widgets_settings()->init();
