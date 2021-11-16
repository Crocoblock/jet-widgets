<?php
/**
 * Image Comparison template
 */

$classes_list[] = 'jw-image-comparison';
$classes = implode( ' ', $classes_list );
?>

<div class="<?php echo esc_attr( $classes ); ?>">
	<?php $this->__get_global_looped_template( 'image-comparison', 'item_list' ); ?>
</div>
