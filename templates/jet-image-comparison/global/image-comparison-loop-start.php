<?php
/**
 * Image Comparison start template
 */
$settings = $this->get_settings();
$data_settings = $this->generate_setting_json();


$class_array[] = 'jet-image-comparison__instance';
$class_array[] = 'elementor-slick-slider';

$classes = implode( ' ', $class_array );

?>
<div class="<?php echo $classes; ?>" <?php echo $data_settings; ?>>
