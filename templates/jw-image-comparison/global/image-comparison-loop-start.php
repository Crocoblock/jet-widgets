<?php
/**
 * Image Comparison start template
 */
$settings = $this->get_settings();
$data_settings = $this->generate_setting_json();


$class_array[] = 'jw-image-comparison__instance';
$class_array[] = 'elementor-slick-slider';

$classes = implode( ' ', $class_array );

?>
<div class="<?php echo esc_attr( $classes ); ?>" <?php echo jet_widgets_tools()->esc_attr( $data_settings ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
