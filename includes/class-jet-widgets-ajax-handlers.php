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

if ( ! class_exists( 'Jet_Widgets_Ajax_Handlers' ) ) {

	/**
	 * Define Jet_Widgets_Ajax_Handlers class
	 */
	class Jet_Widgets_Ajax_Handlers {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since  1.0.0
		 * @access private
		 * @var    object
		 */
		private static $instance = null;

		/**
		 * System message.
		 *
		 * @var array
		 */
		public $sys_messages = array();

		/**
		 * MailChimp API server
		 *
		 * @var string
		 */
		private $api_server = 'https://%s.api.mailchimp.com/2.0/';

		/**
		 * Init Handler
		 */
		public function init() {

			$this->sys_messages = apply_filters( 'jet-widgets_sys_messages', array(
				'invalid_mail'      => esc_html__( 'Please, provide valid mail', 'jet-widgets' ),
				'mailchimp'         => esc_html__( 'Please, set up MailChimp API key and List ID', 'jet-widgets' ),
				'internal'          => esc_html__( 'Internal error. Please, try again later', 'jet-widgets' ),
				'server_error'      => esc_html__( 'Server error. Please, try again later', 'jet-widgets' ),
				'subscribe_success' => esc_html__( 'Success', 'jet-widgets' ),
			) );

			$this->handlers_init();
		}

		/**
		 * Handlers init
		 *
		 * @return void
		 */
		public function handlers_init () {

			jet_widgets()->get_core()->init_module(
				'cherry-handler',
				array(
					'id'           => 'jet_subscribe_form_ajax',
					'action'       => 'jet_subscribe_form_ajax',
					'is_public'    => true,
					'callback'     => array( $this , 'jet_subscribe_form_ajax' ),
				)
			);
		}

		/**
		 * Proccesing subscribe form ajax
		 *
		 * @return void
		 */
		public function jet_subscribe_form_ajax() {
			$data = ( ! empty( $_POST['data'] ) ) ? $_POST['data'] : false;

			if ( ! $data ) {
				wp_send_json_error( array( 'type' => 'error', 'message' => $this->sys_messages['server_error'] ) );
			}

			$mail = $data['mail'];

			if ( empty( $mail ) || ! is_email( $mail ) ) {
				wp_send_json( array( 'type' => 'error', 'message' => $this->sys_messages['invalid_mail'] ) );
			}

			$double_opt_in = filter_var( jet_widgets_settings()->get( 'mailchimp-double-opt-in' ), FILTER_VALIDATE_BOOLEAN );

			$args = array(
				'email' => array(
					'email' => $mail,
				),
				'double_optin' => $double_opt_in,
			);

			$response = $this->api_call( 'lists/subscribe', $args );

			if ( false === $response ) {
				wp_send_json( array( 'type' => 'error', 'message' => $this->sys_messages['mailchimp'] ) );
			}

			$response = json_decode( $response, true );

			if ( empty( $response ) ) {
				wp_send_json( array( 'type' => 'error', 'message' => $this->sys_messages['internal'] ) );
			}

			if ( isset( $response['status'] ) && 'error' == $response['status'] ) {
				wp_send_json( array( 'type' => 'error', 'message' => esc_html( $response['error'] ) ) );
			}

			wp_send_json( array( 'type' => 'success', 'message' => $this->sys_messages['subscribe_success'] ) );
		}

		/**
		 * Make remote request to mailchimp API
		 *
		 * @param  string $method API method to call.
		 * @param  array  $args   API call arguments.
		 * @return array|bool
		 */
		public function api_call( $method, $args = array() ) {

			if ( ! $method ) {
				return false;
			}

			$api_key = jet_widgets_settings()->get( 'mailchimp-api-key' );
			$list_id = jet_widgets_settings()->get( 'mailchimp-list-id', '' );

			if ( ! $api_key || ! $list_id ) {
				return false;
			}

			$key_data = explode( '-', $api_key );

			if ( empty( $key_data ) || ! isset( $key_data[1] ) ) {
				return false;
			}

			$this->api_server = sprintf( $this->api_server, $key_data[1] );

			$url      = esc_url( trailingslashit( $this->api_server . $method ) );
			$defaults = array( 'apikey' => $api_key, 'id' => $list_id );
			$data     = json_encode( array_merge( $defaults, $args ) );

			$request = wp_remote_post( $url, array( 'body' => $data ) );

			return wp_remote_retrieve_body( $request );
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
 * Returns instance of Jet_Widgets_Ajax_Handlers
 *
 * @return object
 */
function jet_widgets_ajax_handlers() {
	return Jet_Widgets_Ajax_Handlers::get_instance();
}

jet_widgets_ajax_handlers()->init();
