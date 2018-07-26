<?php

/**
 * Class WPML_Jet_Widgets_Advanced_Carousel
 */
class WPML_Jet_Widgets_Advanced_Carousel extends WPML_Elementor_Module_With_Items {

	/**
	 * @return string
	 */
	public function get_items_field() {
		return 'items_list';
	}

	/**
	 * @return array
	 */
	public function get_fields() {
		return array( 'item_title', 'item_text' );
	}

	/**
	 * @param string $field
	 *
	 * @return string
	 */
	protected function get_title( $field ) {
		switch( $field ) {
			case 'item_title':
				return esc_html__( 'Advanced Carousel: Item Title', 'jet-widgets' );

			case 'item_text':
				return esc_html__( 'Advanced Carousel: Item Description', 'jet-widgets' );

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

			case 'item_text':
				return 'VISUAL';

			default:
				return '';
		}
	}

}
