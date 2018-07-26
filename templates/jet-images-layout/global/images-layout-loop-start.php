<?php
/**
 * Features list start template
 */

$settings = $this->get_settings();
$class_array[] = 'jet-images-layout__list';
$attr_array = [];

if ( 'grid' === $settings['layout_type'] ) {
	$class_array[] = 'col-row';
	$class_array[] = 'disable-cols-gap';
	$class_array[] = 'disable-rows-gap';
}

if ( 'masonry' === $settings['layout_type'] ) {
	$attr_array[] = 'data-columns';
}

$columns        = $this->__get_html( 'columns' );
$columns_tablet = $this->__get_html( 'columns_tablet' );
$columns_mobile = $this->__get_html( 'columns_mobile' );

$columns        = empty( $columns ) ? 3 : $columns;
$columns_tablet = empty( $columns_tablet ) ? 2 : $columns_tablet;
$columns_mobile = empty( $columns_mobile ) ? 1 : $columns_mobile;

$class_array[] =  'column-desktop-' . $columns;
$class_array[] =  'column-tablet-' . $columns_tablet;
$class_array[] =  'column-mobile-' . $columns_mobile;

$classes = implode( ' ', $class_array );
$attrs = implode( ' ', $attr_array );

?>
<div class="<?php echo $classes; ?>" <?php echo $attrs; ?>>
