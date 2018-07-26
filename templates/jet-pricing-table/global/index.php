<?php
/**
 * Pricing table main template
 */
?>
<div class="pricing-table <?php $this->__html( 'featured', 'featured-table' ); ?>">
	<?php $this->__glob_inc_if( 'heading', array( 'icon', 'title', 'subtitle' ) ); ?>
	<?php $this->__glob_inc_if( 'price', array( 'price_prefix', 'price', 'price_suffix' ) ); ?>
	<?php $this->__get_global_looped_template( 'features', 'features_list' ); ?>
	<?php $this->__glob_inc_if( 'action', array( 'button_before', 'button_url', 'button_text', 'button_after' ) ); ?>
	<?php $this->__glob_inc_if( 'badge', array( 'featured' ) ); ?>
</div>
