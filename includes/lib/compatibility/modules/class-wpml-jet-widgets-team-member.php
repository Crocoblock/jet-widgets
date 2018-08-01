<?php

/**
 * Class WPML_Jet_Widgets_Team_Member
 */
class WPML_Jet_Widgets_Team_Member extends WPML_Elementor_Module_With_Items {

	/**
	 * @return string
	 */
	public function get_items_field() {
		return 'social_list';
	}

	/**
	 * @return array
	 */
	public function get_fields() {
		return array( 'social_label' );
	}

	/**
	 * @param string $field
	 *
	 * @return string
	 */
	protected function get_title( $field ) {
		switch( $field ) {
			case 'social_label':
				return esc_html__( 'Jet Team Member: Social Label', 'jetwidgets-for-elementor' );

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
			case 'social_label':
				return 'LINE';

			default:
				return '';
		}
	}

}
