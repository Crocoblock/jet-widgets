<?php
/**
 * Loop item template
 */
?>
<div class="jw-carousel__item">
	<div class="jw-carousel__item-inner">
	<figure class="jw-banner jw-effect-<?php echo esc_attr( $this->get_settings( 'animation_effect' ) ); ?>"><?php
		$target = $this->__loop_item( array( 'item_link_target' ), ' target="%s"' );

		echo wp_kses_post( $this->__loop_item( array( 'item_link' ), '<a href="%s" class="jw-banner__link"' . $target . '>' ) );
			echo '<div class="jw-banner__overlay"></div>';
			echo wp_kses_post( $this->get_advanced_carousel_img( 'jw-banner__img' ) );
			echo '<figcaption class="jw-banner__content">';
				echo '<div class="jw-banner__content-wrap">';
					echo wp_kses_post( $this->__loop_item( array( 'item_title' ), '<h5 class="jw-banner__title">%s</h5>' ) );
					echo wp_kses_post( $this->__loop_item( array( 'item_text' ), '<div class="jw-banner__text">%s</div>' ) );
				echo '</div>';
			echo '</figcaption>';
		echo wp_kses_post( $this->__loop_item( array( 'item_link' ), '</a>' ) );
	?></figure>
	</div>
</div>
