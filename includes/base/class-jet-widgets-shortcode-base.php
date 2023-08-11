<?php
/**
 * Abstract post type registration class
 */
if ( ! class_exists( 'Jet_Widgets_Shortcode_Base' ) ) {

	abstract class Jet_Widgets_Shortcode_Base {

		/**
		 * Information about shortcode
		 *
		 * @var array
		 */
		public $info = array();

		/**
		 * User attributes
		 *
		 * @var array
		 */
		public $atts = array();

		/**
		 * Initalize post type
		 * @return void
		 */
		public function __construct() {
			add_shortcode( $this->get_tag(), array( $this, 'do_shortcode' ) );
		}

		/**
		 * Returns shortcode tag. Should be rewritten in shortcode class.
		 *
		 * @return string
		 */
		public function get_tag() {}

		/**
		 * THis function shold be reritten in shortcode class with attributes array.
		 *
		 * @return [type] [description]
		 */
		public function get_atts() {
			return array();
		}

		/**
		 * Retrieve single shortocde argument
		 *
		 * @return string or bool false
		 */
		public function get_attr( $name = null ) {

			$allowed = $this->get_atts();
			$value   = false;
			$default = isset( $allowed[ $name ]['default'] ) ? $allowed[ $name ]['default'] : false;

			if ( isset( $this->atts[ $name ] ) ) {

				$value = $this->atts[ $name ];
				
				/**
				 * Check for only allowed values used
				 */
				$attr_data = isset( $allowed[ $name ] ) ? $allowed[ $name ] : false;

				/**
				 * If attribute not registered - returns nothing
				 */
				if ( ! $attr_data ) {
					return false;
				}

				/**
				 * If attribute has options - check if one of this options was used
				 */
				$allowed_options = isset( $attr_data['options'] ) ? array_keys( $attr_data['options'] ) : array();

				if ( ! empty( $allowed_options ) ) {
					$value = in_array( $value, $allowed_options ) ? $value : $default;
				} elseif ( ! empty( $attr_data['sanitize_cb'] ) && is_callable( $attr_data['sanitize_cb'] ) ) {
					$value = call_user_func( $attr_data['sanitize_cb'], $value );
				} else {
					$value = is_array( $value ) ? $value : esc_attr($value);
				}
				
				return $value;
			}

			if ( isset( $allowed[ $name ] ) && $default ) {
				return $allowed[ $name ]['default'];
			} else {
				return false;
			}

		}

		/**
		 * This is main shortcode callback and it should be rewritten in shortcode class
		 *
		 * @param  string $content [description]
		 * @return [type]          [description]
		 */
		public function _shortcode( $content = null ) {}

		/**
		 * Print HTML markup if passed text not empty.
		 *
		 * @param  string $text   Passed text.
		 * @param  string $format Required markup.
		 * @param  array  $args   Additional variables to pass into format string.
		 * @param  bool   $echo   Echo or return.
		 * @return string|void
		 */
		public function html( $text = null, $format = '%s', $args = array(), $echo = true ) {

			if ( empty( $text ) ) {
				return '';
			}

			$args   = array_merge( array( $text ), $args );
			$result = vsprintf( $format, $args );

			if ( $echo ) {
				echo jet_widgets_tools()->kses_post_extended( $result );
			} else {
				return $result;
			}

		}

		/**
		 * Return defult shortcode attributes
		 *
		 * @return array
		 */
		public function default_atts() {

			$result = array();

			foreach ( $this->get_atts() as $attr => $data ) {
				$result[ $attr ] = isset( $data['default'] ) ? $data['default'] : false;
			}

			return $result;
		}

		/**
		 * Shortcode calback
		 *
		 * @return string
		 */
		public function do_shortcode( $atts = array(), $content = null ) {

			$atts = shortcode_atts( $this->default_atts(), $atts, $this->get_tag() );
			$this->css_classes = array();

			if ( null !== $content ) {
				$content = do_shortcode( $content );
			}

			$this->atts = $atts;

			return $this->_shortcode( $content );
		}

		/**
		 * Get template depends to shortcode slug.
		 *
		 * @param  string $name Template file name (without extension).
		 * @return string
		 */
		public function get_template( $name ) {
			return jet_widgets()->get_template( $this->get_tag() . '/global/' . $name . '.php' );
		}

	}
}
