<?php
/**
 * Action box template
 */
?>
<div class="pricing-table__action">
	<?php $this->__html( 'button_before', '<div class="pricing-table__action-before">%s</div>' ); ?>
	<?php $this->__glob_inc_if( 'button', array( 'button_url', 'button_text' ) ); ?>
	<?php $this->__html( 'button_after', '<div class="pricing-table__action-after">%s</div>' ); ?>
</div>