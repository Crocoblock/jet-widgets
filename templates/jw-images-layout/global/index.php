<?php
/**
 * Images Layout template
 */
$settings = $this->get_settings();
$data_settings = $this->generate_setting_json();

$classes_list[] = 'layout-type-' . $settings['layout_type'];
$classes = implode( ' ', $classes_list );
?>

<div class="jw-images-layout <?php echo esc_attr( $classes ); ?>" <?php echo jet_widgets_tools()->esc_attr( $data_settings ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<?php $this->__get_global_looped_template( 'images-layout', 'image_list' ); ?>
</div>
