<?php
/**
 * Animated box action button
 */

$position = $this->get_settings( 'button_icon_position' );
$use_icon = $this->get_settings( 'add_button_icon' );
$button_url = $this->get_settings( 'back_side_button_link' );

if ( empty( $button_url ) ) {
	return false;
}

if ( is_array( $button_url ) && empty( $button_url['url'] ) ) {
	return false;
}

$this->add_render_attribute( 'url', 'class', array(
	'elementor-button',
	'elementor-size-md',
	'jw-animated-box__button',
	'jw-animated-box__button--back',
	'jw-animated-box__button--icon-' . $position,
) );

if ( is_array( $button_url ) ) {
	$this->add_render_attribute( 'url', 'href', $button_url['url'] );

	if ( $button_url['is_external'] ) {
		$this->add_render_attribute( 'url', 'target', '_blank' );
	}

	if ( ! empty( $button_url['nofollow'] ) ) {
		$this->add_render_attribute( 'url', 'rel', 'nofollow' );
	}
} else {
	$this->add_render_attribute( 'url', 'href', $button_url );
}

?>
<a <?php echo $this->get_render_attribute_string( 'url' ); ?>><?php
	echo $this->__html( 'back_side_button_text', '<span class="jw-animated-box__button-text">%s</span>' );

	if ( filter_var( $use_icon, FILTER_VALIDATE_BOOLEAN ) ) {
		echo $this->_render_icon( 'button_icon', '%s', 'jw-animated-box__button-icon' );
	}
?></a>

