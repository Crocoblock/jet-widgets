<?php

/**
 * Class WPML_Jet_Widgets_Image_Comparison
 */
class WPML_Jet_Widgets_Image_Comparison extends WPML_Elementor_Module_With_Items {

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
		return array( 'item_before_label', 'item_after_label' );
	}

	/**
	 * @param string $field
	 *
	 * @return string
	 */
	protected function get_title( $field ) {
		switch( $field ) {
			case 'item_before_label':
				return esc_html__( 'Jet Image Comparison: Before Label', 'jet-widgets' );

			case 'item_after_label':
				return esc_html__( 'Jet Image Comparison: After Label', 'jet-widgets' );

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
			case 'item_before_label':
				return 'LINE';

			case 'item_after_label':
				return 'LINE';

			default:
				return '';
		}
	}

}
