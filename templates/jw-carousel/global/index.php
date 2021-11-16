<?php
/**
 * Advanced carousel template
 */
$layout     = $this->get_settings( 'item_layout' );
$equal_cols = $this->get_settings( 'vertical_carousel' ) ? false : $this->get_settings( 'equal_height_cols' );
$cols_class = ( 'true' === $equal_cols ) ? ' jw-equal-cols' : ''
?>
<div class="jw-carousel-wrap<?php echo esc_attr( $cols_class ); ?>">
	<?php $this->__get_global_looped_template( esc_attr( $layout ) . '/items', 'items_list' ); ?>
</div>
