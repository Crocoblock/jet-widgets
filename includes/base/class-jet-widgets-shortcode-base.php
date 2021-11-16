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
		 * @return void
		 */
		public function get_attr( $name = null ) {

			if ( isset( $this->atts[ $name ] ) ) {
				return $this->atts[ $name ];
			}

			$allowed = $this->get_atts();

			if ( isset( $allowed[ $name ] ) && isset( $allowed[ $name ]['default'] ) ) {
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
				echo wp_kses_post( $result );
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
