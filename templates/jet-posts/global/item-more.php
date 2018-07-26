<?php
/**
 * Loop item more button
 */

if ( 'yes' !== $this->get_attr( 'show_more' ) ) {
	return;
}

jet_widgets()->utility()->attributes->get_button( array(
	'class' => 'btn btn-primary elementor-button elementor-size-md jet-more',
	'text'  => $this->get_attr( 'more_text' ),
	'icon'  => $this->html( $this->get_attr( 'more_icon' ), '<i class="jet-more-icon %1$s"></i>', array(), false ),
	'html'  => '<div class="jet-more-wrap"><a href="%1$s" %3$s><span class="btn__text">%4$s</span>%5$s</a></div>',
	'echo'  => true,
) );