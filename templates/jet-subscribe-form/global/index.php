<?php
/**
 * Subscribe Form main template
 */

$submit_button_text = $this->get_settings( 'submit_button_text' );
$submit_placeholder = $this->get_settings( 'submit_placeholder' );
$layout             = $this->get_settings( 'layout' );
$button_icon        = $this->get_settings( 'button_icon' );
$use_icon           = $this->get_settings( 'add_button_icon' );

$this->add_render_attribute( 'main-container', 'class', array(
	'jet-subscribe-form',
	'jet-subscribe-form--' . $layout . '-layout',
) );

$this->add_render_attribute( 'main-container', 'data-settings', $this->generate_setting_json() );

$instance_data = apply_filters( 'jet-widgets/subscribe-form/input-instance-data', array(), $this );

$instance_data = json_encode( $instance_data );

$this->add_render_attribute( 'form-input',
	array(
		'class'       => array(
			'jet-subscribe-form__input',
		),
		'type'               => 'email',
		'name'               => 'jet-subscribe-mail',
		'value'              => '',
		'placeholder'        => $submit_placeholder,
		'data-instance-data' => htmlspecialchars( $instance_data ),
	)
);

$icon_html = '';

if ( filter_var( $use_icon, FILTER_VALIDATE_BOOLEAN ) ) {
	$icon_html = sprintf( '<i class="jet-subscribe-form__submit-icon %s"></i>', $button_icon );
}

?>
<div <?php echo $this->get_render_attribute_string( 'main-container' ); ?>>
	<form method="POST" action="#" class="jet-subscribe-form__form">
		<div class="jet-subscribe-form__input-group">
			<input <?php echo $this->get_render_attribute_string( 'form-input' ); ?>>
			<?php echo sprintf( '<a class="jet-subscribe-form__submit elementor-button elementor-size-md" href="#">%s<span class="jet-subscribe-form__submit-text">%s</span></a>', $icon_html, $submit_button_text ); ?>
		</div>
		<div class="jet-subscribe-form__message"><div class="jet-subscribe-form__message-inner"><span></span></div></div>
	</form>
</div>
