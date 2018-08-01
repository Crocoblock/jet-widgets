<?php

/**
 * Class WPML_Jet_Widgets_Images_Layout
 */
class WPML_Jet_Widgets_Images_Layout extends WPML_Elementor_Module_With_Items {

	/**
	 * @return string
	 */
	public function get_items_field() {
		return 'image_list';
	}

	/**
	 * @return array
	 */
	public function get_fields() {
		return array( 'item_title', 'item_desc' );
	}

	/**
	 * @param string $field
	 *
	 * @return string
	 */
	protected function get_title( $field ) {
		switch( $field ) {
			case 'item_title':
				return esc_html__( 'Jet Images Layout: Item Title', 'jetwidgets-for-elementor' );

			case 'item_desc':
				return esc_html__( 'Jet Images Layout: Item Description', 'jetwidgets-for-elementor' );

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

			case 'item_desc':
				return 'VISUAL';

			default:
				return '';
		}
	}

}
