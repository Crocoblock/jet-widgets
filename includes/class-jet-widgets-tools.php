<?php
/**
 * Cherry addons tools class
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Jet_Widgets_Tools' ) ) {

	/**
	 * Define Jet_Widgets_Tools class
	 */
	class Jet_Widgets_Tools {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since 1.0.0
		 * @var   object
		 */
		private static $instance = null;

		/**
		 * Returns columns classes string
		 * @param  [type] $columns [description]
		 * @return [type]          [description]
		 */
		public function col_classes( $columns = array() ) {

			$columns = wp_parse_args( $columns, array(
				'desk' => 1,
				'tab'  => 1,
				'mob'  => 1,
			) );

			$classes = array();

			foreach ( $columns as $device => $cols ) {
				if ( ! empty( $cols ) ) {
					$classes[] = sprintf( 'col-%1$s-%2$s', $device, $cols );
				}
			}

			return implode( ' ' , $classes );
		}

		/**
		 * Returns disable columns gap nad rows gap classes string
		 *
		 * @param  string $use_cols_gap [description]
		 * @param  string $use_rows_gap [description]
		 * @return [type]               [description]
		 */
		public function gap_classes( $use_cols_gap = 'yes', $use_rows_gap = 'yes' ) {

			$result = array();

			foreach ( array( 'cols' => $use_cols_gap, 'rows' => $use_rows_gap ) as $element => $value ) {
				if ( 'yes' !== $value ) {
					$result[] = sprintf( 'disable-%s-gap', $element );
				}
			}

			return implode( ' ', $result );

		}

		/**
		 * Returns image size array in slug => name format
		 *
		 * @return  array
		 */
		public function get_image_sizes() {

			global $_wp_additional_image_sizes;

			$sizes  = get_intermediate_image_sizes();
			$result = array();

			foreach ( $sizes as $size ) {
				if ( in_array( $size, array( 'thumbnail', 'medium', 'medium_large', 'large' ) ) ) {
					$result[ $size ] = ucwords( trim( str_replace( array( '-', '_' ), array( ' ', ' ' ), $size ) ) );
				} else {
					$result[ $size ] = sprintf(
						'%1$s (%2$sx%3$s)',
						ucwords( trim( str_replace( array( '-', '_' ), array( ' ', ' ' ), $size ) ) ),
						$_wp_additional_image_sizes[ $size ]['width'],
						$_wp_additional_image_sizes[ $size ]['height']
					);
				}
			}

			return array_merge( array( 'full' => esc_html__( 'Full', 'jet-widgets' ), ), $result );
		}

		/**
		 * Get categories list.
		 *
		 * @return array
		 */
		public function get_categories() {

			$categories = get_categories();

			if ( empty( $categories ) || ! is_array( $categories ) ) {
				return array();
			}

			return wp_list_pluck( $categories, 'name', 'term_id' );

		}

		/**
		 * Returns icons data list.
		 *
		 * @return array
		 */
		public function get_theme_icons_data() {

			$default = array(
				'icons'  => false,
				'format' => 'fa %s',
				'file'   => false,
			);

			/**
			 * Filter default icon data before useing
			 *
			 * @var array
			 */
			$icon_data = apply_filters( 'jet-widgets/controls/icon/data', $default );
			$icon_data = array_merge( $default, $icon_data );

			return $icon_data;
		}

		/**
		 * Returns allowed order by fields for options
		 *
		 * @return array
		 */
		public function orderby_arr() {
			return array(
				'none'          => esc_html__( 'None', 'jet-widgets' ),
				'ID'            => esc_html__( 'ID', 'jet-widgets' ),
				'author'        => esc_html__( 'Author', 'jet-widgets' ),
				'title'         => esc_html__( 'Title', 'jet-widgets' ),
				'name'          => esc_html__( 'Name (slug)', 'jet-widgets' ),
				'date'          => esc_html__( 'Date', 'jet-widgets' ),
				'modified'      => esc_html__( 'Modified', 'jet-widgets' ),
				'rand'          => esc_html__( 'Rand', 'jet-widgets' ),
				'comment_count' => esc_html__( 'Comment Count', 'jet-widgets' ),
				'menu_order'    => esc_html__( 'Menu Order', 'jet-widgets' ),
			);
		}

		/**
		 * Returns allowed order fields for options
		 *
		 * @return array
		 */
		public function order_arr() {

			return array(
				'desc' => esc_html__( 'Descending', 'jet-widgets' ),
				'asc'  => esc_html__( 'Ascending', 'jet-widgets' ),
			);

		}

		/**
		 * Returns allowed order by fields for options
		 *
		 * @return array
		 */
		public function verrtical_align_attr() {
			return array(
				'baseline'    => esc_html__( 'Baseline', 'jet-widgets' ),
				'top'         => esc_html__( 'Top', 'jet-widgets' ),
				'middle'      => esc_html__( 'Middle', 'jet-widgets' ),
				'bottom'      => esc_html__( 'Bottom', 'jet-widgets' ),
				'sub'         => esc_html__( 'Sub', 'jet-widgets' ),
				'super'       => esc_html__( 'Super', 'jet-widgets' ),
				'text-top'    => esc_html__( 'Text Top', 'jet-widgets' ),
				'text-bottom' => esc_html__( 'Text Bottom', 'jet-widgets' ),
			);
		}

		/**
		 * Returns array with numbers in $index => $name format for numeric selects
		 *
		 * @param  integer $to Max numbers
		 * @return array
		 */
		public function get_select_range( $to = 10 ) {
			$range = range( 1, $to );
			return array_combine( $range, $range );
		}

		/**
		 * Returns badge placeholder URL
		 *
		 * @return void
		 */
		public function get_badge_placeholder() {
			return jet_widgets()->plugin_url( 'assets/images/placeholder-badge.svg' );
		}

		/**
		 * Rturns image tag or raw SVG
		 *
		 * @param  string $url  image URL.
		 * @param  array  $attr [description]
		 * @return string
		 */
		public function get_image_by_url( $url = null, $attr = array() ) {

			$url = esc_url( $url );

			if ( empty( $url ) ) {
				return;
			}

			$ext  = pathinfo( $url, PATHINFO_EXTENSION );
			$attr = array_merge( array( 'alt' => '' ), $attr );

			if ( 'svg' !== $ext ) {
				return sprintf( '<img src="%1$s"%2$s>', $url, $this->get_attr_string( $attr ) );
			}

			$base_url = network_site_url( '/' );
			$svg_path = str_replace( $base_url, ABSPATH, $url );
			$key      = md5( $svg_path );
			$svg      = get_transient( $key );

			if ( ! $svg ) {
				$svg = file_get_contents( $svg_path );
			}

			if ( ! $svg ) {
				return sprintf( '<img src="%1$s"%2$s>', $url, $this->get_attr_string( $attr ) );
			}

			set_transient( $key, $svg, DAY_IN_SECONDS );

			unset( $attr['alt'] );

			return sprintf( '<div%2$s>%1$s</div>', $svg, $this->get_attr_string( $attr ) ); ;
		}

		/**
		 * Return attributes string from attributes array.
		 *
		 * @param  array  $attr Attributes string.
		 * @return string
		 */
		public function get_attr_string( $attr = array() ) {

			if ( empty( $attr ) || ! is_array( $attr ) ) {
				return;
			}

			$result = '';

			foreach ( $attr as $key => $value ) {
				$result .= sprintf( ' %s="%s"', esc_attr( $key ), esc_attr( $value ) );
			}

			return $result;
		}

		/**
		 * Returns carousel arrow
		 *
		 * @param  array $classes Arrow additional classes list.
		 * @return string
		 */
		public function get_carousel_arrow( $classes ) {

			$format = apply_filters( 'jet_widgets/carousel/arrows_format', '<i class="%s jw-arrow"></i>', $classes );

			return sprintf( $format, implode( ' ', $classes ) );
		}

		/**
		 * Get post types options list
		 *
		 * @return array
		 */
		public function get_post_types() {

			$post_types = get_post_types( array( 'public' => true ), 'objects' );

			$deprecated = apply_filters(
				'jet-widgets/post-types-list/deprecated',
				array( 'attachment', 'elementor_library' )
			);

			$result = array();

			if ( empty( $post_types ) ) {
				return $result;
			}

			foreach ( $post_types as $slug => $post_type ) {

				if ( in_array( $slug, $deprecated ) ) {
					continue;
				}

				$result[ $slug ] = $post_type->label;

			}

			return $result;

		}

		/**
		 * Return availbale arrows list
		 * @return [type] [description]
		 */
		public function get_available_prev_arrows_list() {

			return apply_filters(
				'jet_widgets/carousel/available_arrows/prev',
				array(
					'fa fa-angle-left'          => __( 'Angle', 'jet-widgets' ),
					'fa fa-chevron-left'        => __( 'Chevron', 'jet-widgets' ),
					'fa fa-angle-double-left'   => __( 'Angle Double', 'jet-widgets' ),
					'fa fa-arrow-left'          => __( 'Arrow', 'jet-widgets' ),
					'fa fa-caret-left'          => __( 'Caret', 'jet-widgets' ),
					'fa fa-long-arrow-left'     => __( 'Long Arrow', 'jet-widgets' ),
					'fa fa-arrow-circle-left'   => __( 'Arrow Circle', 'jet-widgets' ),
					'fa fa-chevron-circle-left' => __( 'Chevron Circle', 'jet-widgets' ),
					'fa fa-caret-square-o-left' => __( 'Caret Square', 'jet-widgets' ),
				)
			);

		}

		/**
		 * Return availbale arrows list
		 * @return [type] [description]
		 */
		public function get_available_next_arrows_list() {

			return apply_filters(
				'jet_widgets/carousel/available_arrows/next',
				array(
					'fa fa-angle-right'          => __( 'Angle', 'jet-widgets' ),
					'fa fa-chevron-right'        => __( 'Chevron', 'jet-widgets' ),
					'fa fa-angle-double-right'   => __( 'Angle Double', 'jet-widgets' ),
					'fa fa-arrow-right'          => __( 'Arrow', 'jet-widgets' ),
					'fa fa-caret-right'          => __( 'Caret', 'jet-widgets' ),
					'fa fa-long-arrow-right'     => __( 'Long Arrow', 'jet-widgets' ),
					'fa fa-arrow-circle-right'   => __( 'Arrow Circle', 'jet-widgets' ),
					'fa fa-chevron-circle-right' => __( 'Chevron Circle', 'jet-widgets' ),
					'fa fa-caret-square-o-right' => __( 'Caret Square', 'jet-widgets' ),
				)
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
 * Returns instance of Jet_Widgets_Tools
 *
 * @return object
 */
function jet_widgets_tools() {
	return Jet_Widgets_Tools::get_instance();
}
