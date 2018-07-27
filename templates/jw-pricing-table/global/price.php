<?php
/**
 * Pricing table price block template
 */
?>
<div class="pricing-table__price"><?php
	$this->__html( 'price_prefix', '<span class="pricing-table__price-prefix">%s</span>' );
	$this->__html( 'price', '<span class="pricing-table__price-val">%s</span>' );
	$this->__html( 'price_suffix', '<span class="pricing-table__price-suffix">%s</span>' );
	$this->__html( 'price_desc', '<p class="pricing-table__price-desc">%s</p>' );
?></div>