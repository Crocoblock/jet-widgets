<?php
/**
 * Loop item thumbnail
 */
if ( 'yes' !== $this->get_attr( 'show_image' ) || 'background' === $this->get_attr( 'show_image_as' ) ) {
	return;
}

jet_widgets()->utility()->media->get_image( array(
	'size'        => $this->get_attr( 'thumb_size' ),
	'class'       => 'post-thumbnail__link',
	'html'        => '<div class="post-thumbnail"><a href="%1$s" %2$s><img class="post-thumbnail__img wp-post-image" src="%3$s" alt="%4$s" %5$s></a></div>',
	'placeholder' => false,
	'echo'        => true,
) );