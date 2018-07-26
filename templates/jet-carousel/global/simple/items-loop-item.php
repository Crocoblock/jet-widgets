<?php
/**
 * Loop item template
 */
?>
<div class="jet-carousel__item">
	<div class="jet-carousel__item-inner"><?php
		$target = $this->__loop_item( array( 'item_link_target' ), ' target="%s"' );

		echo $this->__loop_item( array( 'item_link' ), '<a href="%s" class="jet-carousel__item-link"' . $target . '>' );
		echo $this->get_advanced_carousel_img( 'jet-carousel__item-img' );
		echo $this->__loop_item( array( 'item_link' ), '</a>' );

		$title  = $this->__loop_item( array( 'item_title' ), '<h5 class="jet-carousel__item-title">%s</h5>' );
		$text   = $this->__loop_item( array( 'item_text' ), '<div class="jet-carousel__item-text">%s</div>' );
		$button =  $this->__loop_button_item( array( 'item_link', 'item_button_text' ), '<a class="elementor-button elementor-size-md jet-carousel__item-button" href="%1$s"' . $target . '>%2$s</a>' );

		if ( $title || $text ) {

			echo '<div class="jet-carousel__content">';
				echo $title;
				echo $text;
				echo $button;
			echo '</div>';
		}
?></div>
</div>
