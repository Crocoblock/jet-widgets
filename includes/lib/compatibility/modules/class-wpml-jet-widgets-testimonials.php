<?php

/**
 * Class WPML_Jet_Widgets_Testimonials
 */
class WPML_Jet_Widgets_Testimonials extends WPML_Elementor_Module_With_Items {

	/**
	 * @return string
	 */
	public function get_items_field() {
		return 'item_list';
	}

	/**
	 * @return array
	 */
	public function get_fields() {
		return array( 'item_title', 'item_comment', 'item_name', 'item_position', 'item_date' );
	}

	/**
	 * @param string $field
	 *
	 * @return string
	 */
	protected function get_title( $field ) {
		switch( $field ) {
			case 'item_title':
				return esc_html__( 'Jet Testimonials: Item Title', 'jetwidgets-for-elementor' );

			case 'item_comment':
				return esc_html__( 'Jet Testimonials: Item Comment', 'jetwidgets-for-elementor' );

			case 'item_name':
				return esc_html__( 'Jet Testimonials: Item Name', 'jetwidgets-for-elementor' );

			case 'item_position':
				return esc_html__( 'Jet Testimonials: Item Position', 'jetwidgets-for-elementor' );

			case 'item_date':
				return esc_html__( 'Jet Testimonials: Item Date', 'jetwidgets-for-elementor' );

			default:
				return '';
		}
	}

	/**
	 * @param string $field
	 *
	 * @return string
	 */
	protected function get_editor_type( $field ) {
		switch( $field ) {
			case 'item_title':
				return 'LINE';

			case 'item_comment':
				return 'VISUAL';

			case 'item_name':
				return 'LINE';

			case 'item_position':
				return 'LINE';

			case 'item_date':
				return 'LINE';

			default:
				return '';
		}
	}

}
