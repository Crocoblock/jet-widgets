<?php

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Jet_Widgets_Compatibility' ) ) {

	/**
	 * Define Jet_Widgets_Compatibility class
	 */
	class Jet_Widgets_Compatibility {

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

			// WPML String Translation plugin exist check
			if ( defined( 'WPML_ST_VERSION' ) ) {
				$this->load_files();
				add_filter( 'wpml_elementor_widgets_to_translate', array( $this, 'add_translatable_nodes' ) );
			}
		}

		/**
		 * Load required files.
		 *
		 * @return void
		 */
		public function load_files() {
			require jet_widgets()->plugin_path( 'includes/lib/compatibility/modules/class-wpml-jet-widgets-advanced-carousel.php' );
			require jet_widgets()->plugin_path( 'includes/lib/compatibility/modules/class-wpml-jet-widgets-images-layout.php' );
			require jet_widgets()->plugin_path( 'includes/lib/compatibility/modules/class-wpml-jet-widgets-pricing-table.php' );
			require jet_widgets()->plugin_path( 'includes/lib/compatibility/modules/class-wpml-jet-widgets-team-member.php' );
			require jet_widgets()->plugin_path( 'includes/lib/compatibility/modules/class-wpml-jet-widgets-testimonials.php' );
			require jet_widgets()->plugin_path( 'includes/lib/compatibility/modules/class-wpml-jet-widgets-image-comparison.php' );
		}

		/**
		 * Add jet widgets translation nodes
		 *
		 * @param array
		 */
		public function add_translatable_nodes( $nodes_to_translate ) {

			$nodes_to_translate[ 'jw-animated-box' ] = array(
				'conditions' => array( 'widgetType' => 'jw-animated-box' ),
				'fields'     => array(
					array(
						'field'       => 'front_side_title',
						'type'        => esc_html__( 'Jet Animated Box: Front Title', 'jet-widgets' ),
						'editor_type' => 'LINE',
					),
					array(
						'field'       => 'front_side_subtitle',
						'type'        => esc_html__( 'Jet Animated Box: Front SubTitle', 'jet-widgets' ),
						'editor_type' => 'LINE',
					),
					array(
						'field'       => 'front_side_description',
						'type'        => esc_html__( 'Jet Animated Box: Front Description', 'jet-widgets' ),
						'editor_type' => 'VISUAL',
					),
					array(
						'field'       => 'back_side_title',
						'type'        => esc_html__( 'Jet Animated Box: Back Title', 'jet-widgets' ),
						'editor_type' => 'LINE',
					),
					array(
						'field'       => 'back_side_subtitle',
						'type'        => esc_html__( 'Jet Animated Box: Back SubTitle', 'jet-widgets' ),
						'editor_type' => 'LINE',
					),
					array(
						'field'       => 'back_side_description',
						'type'        => esc_html__( 'Jet Animated Box: Back Description', 'jet-widgets' ),
						'editor_type' => 'VISUAL',
					),
				),
			);

			$nodes_to_translate[ 'jw-posts' ] = array(
				'conditions' => array( 'widgetType' => 'jw-posts' ),
				'fields'     => array(
					array(
						'field'       => 'more_text',
						'type'        => esc_html__( 'Jet Posts: Read More Button Text', 'jet-widgets' ),
						'editor_type' => 'LINE',
					),
				),
			);

			$nodes_to_translate[ 'jw-carousel' ] = array(
				'conditions'        => array( 'widgetType' => 'jw-carousel' ),
				'fields'            => array(),
				'integration-class' => 'WPML_Jet_Widgets_Advanced_Carousel',
			);

			$nodes_to_translate[ 'jw-images-layout' ] = array(
				'conditions'        => array( 'widgetType' => 'jw-images-layout' ),
				'fields'            => array(),
				'integration-class' => 'WPML_Jet_Widgets_Images_Layout',
			);

			$nodes_to_translate[ 'jw-pricing-table' ] = array(
				'conditions' => array( 'widgetType' => 'jw-pricing-table' ),
				'fields'     => array(
					array(
						'field'       => 'title',
						'type'        => esc_html__( 'Jet Pricing Table: Title', 'jet-widgets' ),
						'editor_type' => 'LINE',
					),
					array(
						'field'       => 'subtitle',
						'type'        => esc_html__( 'Jet Pricing Table: Subtitle', 'jet-widgets' ),
						'editor_type' => 'LINE',
					),
					array(
						'field'       => 'price_suffix',
						'type'        => esc_html__( 'Jet Pricing Table: Price Suffix', 'jet-widgets' ),
						'editor_type' => 'LINE',
					),
					array(
						'field'       => 'button_before',
						'type'        => esc_html__( 'Jet Pricing Table: Button Before', 'jet-widgets' ),
						'editor_type' => 'LINE',
					),
					array(
						'field'       => 'button_text',
						'type'        => esc_html__( 'Jet Pricing Table: Button Text', 'jet-widgets' ),
						'editor_type' => 'LINE',
					),
					array(
						'field'       => 'button_after',
						'type'        => esc_html__( 'Jet Pricing Table: Button After', 'jet-widgets' ),
						'editor_type' => 'LINE',
					),
				),
				'integration-class' => 'WPML_Jet_Widgets_Pricing_Table',
			);

			$nodes_to_translate[ 'jw-services' ] = array(
				'conditions' => array( 'widgetType' => 'jw-services' ),
				'fields'     => array(
					array(
						'field'       => 'services_title',
						'type'        => esc_html__( 'Jet Services: Title', 'jet-widgets' ),
						'editor_type' => 'LINE',
					),
					array(
						'field'       => 'services_description',
						'type'        => esc_html__( 'Jet Services: Description', 'jet-widgets' ),
						'editor_type' => 'VISUAL',
					),
					array(
						'field'       => 'button_text',
						'type'        => esc_html__( 'Jet Services: Button Text', 'jet-widgets' ),
						'editor_type' => 'LINE',
					),
				),
			);

			$nodes_to_translate[ 'jw-team-member' ] = array(
				'conditions' => array( 'widgetType' => 'jw-team-member' ),
				'fields'     => array(
					array(
						'field'       => 'member_first_name',
						'type'        => esc_html__( 'Jet Team Member: First Name', 'jet-widgets' ),
						'editor_type' => 'LINE',
					),
					array(
						'field'       => 'member_last_name',
						'type'        => esc_html__( 'Jet Team Member: Last Name', 'jet-widgets' ),
						'editor_type' => 'LINE',
					),
					array(
						'field'       => 'member_position',
						'type'        => esc_html__( 'Jet Team Member: Position', 'jet-widgets' ),
						'editor_type' => 'LINE',
					),
					array(
						'field'       => 'member_description',
						'type'        => esc_html__( 'Jet Team Member: Description', 'jet-widgets' ),
						'editor_type' => 'VISUAL',
					),
				),
				'integration-class' => 'WPML_Jet_Widgets_Team_Member',
			);

			$nodes_to_translate[ 'jw-testimonials' ] = array(
				'conditions' => array( 'widgetType' => 'jw-testimonials' ),
				'fields'     => array(),
				'integration-class' => 'WPML_Jet_Widgets_Testimonials',
			);

			$nodes_to_translate[ 'jw-image-comparison' ] = array(
				'conditions'        => array( 'widgetType' => 'jw-image-comparison' ),
				'fields'            => array(),
				'integration-class' => 'WPML_Jet_Widgets_Image_Comparison',
			);

			$nodes_to_translate[ 'jw-headline' ] = array(
				'conditions' => array( 'widgetType' => 'jw-headline' ),
				'fields'     => array(
					array(
						'field'       => 'first_part',
						'type'        => esc_html__( 'Jet Headline: First Part', 'jet-widgets' ),
						'editor_type' => 'LINE',
					),
					array(
						'field'       => 'second_part',
						'type'        => esc_html__( 'Jet Headline: Second Part', 'jet-widgets' ),
						'editor_type' => 'LINE',
					),
				),
			);

			$nodes_to_translate[ 'jw-subscribe-form' ] = array(
				'conditions' => array( 'widgetType' => 'jw-subscribe-form' ),
				'fields'     => array(
					array(
						'field'       => 'submit_button_text',
						'type'        => esc_html__( 'Jet Subscribe Form: Submit Text', 'jet-widgets' ),
						'editor_type' => 'LINE',
					),
					array(
						'field'       => 'submit_placeholder',
						'type'        => esc_html__( 'Jet Subscribe Form: Input Placeholder', 'jet-widgets' ),
						'editor_type' => 'LINE',
					),
				),
			);

			return $nodes_to_translate;
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
 * Returns instance of Jet_Widgets_Compatibility
 *
 * @return object
 */
function jet_widgets_compatibility() {
	return Jet_Widgets_Compatibility::get_instance();
}
