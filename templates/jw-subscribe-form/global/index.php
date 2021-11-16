<?php
/**
 * Subscribe Form main template
 */

$submit_button_text = $this->get_settings( 'submit_button_text' );
$submit_placeholder = $this->get_settings( 'submit_placeholder' );
$layout             = $this->get_settings( 'layout' );
$use_icon           = $this->get_settings( 'add_button_icon' );

$this->add_render_attribute( 'main-container', 'class', array(
	'jw-subscribe-form',
	'jw-subscribe-form--' . $layout . '-layout',
) );

$this->add_render_attribute( 'main-container', 'data-settings', $this->generate_setting_json() );

$instance_data = apply_filters( 'jet-widgets/subscribe-form/input-instance-data', array(), $this );

$instance_data = json_encode( $instance_data );

$this->add_render_attribute( 'form-input',
	array(
		'class'              => array( 'jw-subscribe-form__input' ),
		'type'               => 'email',
		'name'               => 'jw-subscribe-mail',
		'value'              => '',
		'placeholder'        => $submit_placeholder,
		'data-instance-data' => htmlspecialchars( $instance_data ),
	)
);

$icon_html = '';

if ( filter_var( $use_icon, FILTER_VALIDATE_BOOLEAN ) ) {
	$icon_html = $this->_get_icon( 'button_icon', '<span class="jw-subscribe-form__submit-icon jet-widgets-icon">%s</span>' );
}

?>
<div <?php echo jet_widgets_tools()->esc_attr( $this->get_render_attribute_string( 'main-container' ) ); ?>>
	<form method="POST" action="#" class="jw-subscribe-form__form">
		<div class="jw-subscribe-form__input-group">
			<input <?php echo jet_widgets_tools()->esc_attr( $this->get_render_attribute_string( 'form-input' ) ); ?>>
			<?php echo sprintf( '<a class="jw-subscribe-form__submit elementor-button elementor-size-md" href="#">%s<span class="jw-subscribe-form__submit-text">%s</span></a>', $icon_html, $submit_button_text ); ?>
		</div>
		<div class="jw-subscribe-form__message"><div class="jw-subscribe-form__message-inner"><span></span></div></div>
	</form>
</div>
