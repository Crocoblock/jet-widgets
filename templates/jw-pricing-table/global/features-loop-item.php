<?php
/**
 * Features list item template
 */

$classes  = 'pricing-feature-' . $this->__loop_item( array( '_id' ) );
$classes .= ' ' . $this->__loop_item( array( 'item_included' ) );

?>
<div class="pricing-feature <?php echo esc_attr( $classes ); ?>">
	<div class="pricing-feature__inner"><?php
		echo jet_widgets_tools()->kses_post_extended(  $this->__pricing_feature_icon() );
		printf( '<span class="pricing-feature__text">%s</span>', $this->__loop_item( array( 'item_text' ) ) );
	?></div>
</div>
