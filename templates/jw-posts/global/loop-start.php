<?php
/**
 * Posts loop start template
 */

$classes = array(
	'jw-posts',
	'col-row',
	jet_widgets_tools()->gap_classes( $this->get_attr( 'columns_gap' ), $this->get_attr( 'rows_gap' ) ),
);

$equal = $this->get_attr( 'equal_height_cols' );

if ( $equal ) {
	$classes[] = 'jw-equal-cols';
}

?>
<div class="<?php echo implode( ' ', $classes ); ?>">