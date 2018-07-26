<?php
/**
 * Pricing table heading template
 */
?>
<div class="pricing-table__heading">
	<?php $this->__html( 'icon', '<div class="pricing-table__icon"><div class="pricing-table__icon-box"><i class="%s"></i></div></div>' ); ?>
	<?php $this->__html( 'title', '<h2 class="pricing-table__title">%s</h2>' ); ?>
	<?php $this->__html( 'subtitle', '<h4 class="pricing-table__subtitle">%s</h4>' ); ?>
</div>