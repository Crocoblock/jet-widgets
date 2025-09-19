<?php
/**
 * Pricing table action button
 */

$this->add_render_attribute( 'button', array(
	'class' => array(
		'elementor-button',
		'elementor-size-md',
		'pricing-table-button',
		'button-' . $this->get_settings( 'button_size' ) . '-size',
	),
	'href' => esc_url( $this->get_settings( 'button_url' ) ),
) );

?>
<a <?php echo jet_widgets_tools()->esc_attr( $this->get_render_attribute_string( 'button' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php

	$position = $this->get_settings( 'button_icon_position' );
	$icon     = $this->get_settings( 'add_button_icon' );

	if ( $icon && 'left' === $position ) {
		$this->_render_icon( 'button_icon', '<span class="jet-widgets-icon button-icon">%s</span>' );
	}

	echo $this->__html( 'button_text' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	if ( $icon && 'right' === $position ) {
		$this->_render_icon( 'button_icon', '<span class="jet-widgets-icon button-icon">%s</span>' );
	}

?></a>
