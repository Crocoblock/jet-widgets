<?php
/**
 * Loop item more button
 */

if ( 'yes' !== $this->get_attr( 'show_more' ) ) {
	return;
}

jet_widgets()->utility()->attributes->get_button( array(
	'class' => 'btn btn-primary elementor-button elementor-size-md jw-more',
	'text'  => $this->get_attr( 'more_text' ),
	'icon'  => $this->html( $this->get_attr( 'more_icon' ), '<span class="jet-widgets-icon jw-more-icon">%1$s</span>', array(), false ),
	'html'  => '<div class="jw-more-wrap"><a href="%1$s" %3$s><span class="btn__text">%4$s</span>%5$s</a></div>',
	'echo'  => true,
) );