<?php
/**
 * Loop item template
 */

$title_tag     = $this->__get_html( 'title_html_tag', '%s' );
$sub_title_tag = $this->__get_html( 'sub_title_html_tag', '%s' );
?>
<div class="jet-animated-box <?php $this->__html( 'animation_effect', '%s' ); ?>">
	<div class="jet-animated-box__front">
		<div class="jet-animated-box__overlay"></div>
		<div class="jet-animated-box__inner">
			<?php
				$this->__html( 'front_side_icon', '<div class="jet-animated-box__icon jet-animated-box__icon--front"><div class="jet-animated-box-icon-inner"><i class="%s"></i></div></div>' );
			?>
			<div class="jet-animated-box__content">
			<?php
				$this->__html( 'front_side_title', '<' . $title_tag . ' class="jet-animated-box__title jet-animated-box__title--front">%s</' . $title_tag . '>' );
				$this->__html( 'front_side_subtitle', '<' . $sub_title_tag . ' class="jet-animated-box__subtitle jet-animated-box__subtitle--front">%s</' . $sub_title_tag . '>' );
				$this->__html( 'front_side_description', '<p class="jet-animated-box__description jet-animated-box__description--front">%s</p>' );
			?>
			</div>
		</div>
	</div>
	<div class="jet-animated-box__back">
		<div class="jet-animated-box__overlay"></div>
		<div class="jet-animated-box__inner">
			<?php
				$this->__html( 'back_side_icon', '<div class="jet-animated-box__icon jet-animated-box__icon--back"><div class="jet-animated-box-icon-inner"><i class="%s"></i></div></div>' );
			?>
			<div class="jet-animated-box__content">
			<?php
				$this->__html( 'back_side_title', '<' . $title_tag . ' class="jet-animated-box__title jet-animated-box__title--back">%s</' . $title_tag . '>' );
				$this->__html( 'back_side_subtitle', '<' . $sub_title_tag . ' class="jet-animated-box__subtitle jet-animated-box__subtitle--back">%s</' . $sub_title_tag . '>' );
				$this->__html( 'back_side_description', '<p class="jet-animated-box__description jet-animated-box__description--back">%s</p>' );
				$this->__glob_inc_if( 'action-button', array( 'back_side_button_link', 'back_side_button_text' ) );
			?>
			</div>
		</div>
	</div>
</div>
