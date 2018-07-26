<?php
/**
 * Testimonials start template
 */
$settings = $this->get_settings();
$data_settings = $this->generate_setting_json();

$use_comment_corner = $this->get_settings( 'use_comment_corner' );

$class_array[] = 'jet-testimonials__instance';
$class_array[] = 'elementor-slick-slider';

if ( filter_var( $use_comment_corner, FILTER_VALIDATE_BOOLEAN ) ) {
	$class_array[] = 'jet-testimonials--comment-corner';
}

$classes = implode( ' ', $class_array );

?>
<div class="<?php echo $classes; ?>" <?php echo $data_settings; ?>>
