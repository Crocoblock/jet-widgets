<?php
/**
 * Loop item template
 */

$title_tag     = $this->__get_html( 'title_html_tag', '%s' );
$title_tag     = jet_widgets_tools()->validate_html_tag( $title_tag );
$sub_title_tag = $this->__get_html( 'sub_title_html_tag', '%s' );
$sub_title_tag = jet_widgets_tools()->validate_html_tag( $sub_title_tag );
?>
<div class="jw-animated-box <?php $this->__html( 'animation_effect', '%s' ); ?>">
	<div class="jw-animated-box__front">
		<div class="jw-animated-box__overlay"></div>
		<div class="jw-animated-box__inner">
			<?php
				$this->_render_icon( 'front_side_icon', '<div class="jw-animated-box__icon jw-animated-box__icon--front "><div class="jw-animated-box-icon-inner"><span class="jet-widgets-icon">%s</span></div></div>' );
			?>
			<div class="jw-animated-box__content">
			<?php
				$this->__html( 'front_side_title', '<' . $title_tag . ' class="jw-animated-box__title jw-animated-box__title--front">%s</' . $title_tag . '>' );
				$this->__html( 'front_side_subtitle', '<' . $sub_title_tag . ' class="jw-animated-box__subtitle jw-animated-box__subtitle--front">%s</' . $sub_title_tag . '>' );
				$this->__html( 'front_side_description', '<p class="jw-animated-box__description jw-animated-box__description--front">%s</p>' );
			?>
			</div>
		</div>
	</div>
	<div class="jw-animated-box__back">
		<div class="jw-animated-box__overlay"></div>
		<div class="jw-animated-box__inner">
			<?php
				$this->_render_icon( 'back_side_icon', '<div class="jw-animated-box__icon jw-animated-box__icon--back"><div class="jw-animated-box-icon-inner">%s</div></div>' );
			?>
			<div class="jw-animated-box__content">
			<?php
				$this->__html( 'back_side_title', '<' . $title_tag . ' class="jw-animated-box__title jw-animated-box__title--back">%s</' . $title_tag . '>' );
				$this->__html( 'back_side_subtitle', '<' . $sub_title_tag . ' class="jw-animated-box__subtitle jw-animated-box__subtitle--back">%s</' . $sub_title_tag . '>' );
				$this->__html( 'back_side_description', '<p class="jw-animated-box__description jw-animated-box__description--back">%s</p>' );
				$this->__glob_inc_if( 'action-button', array( 'back_side_button_link', 'back_side_button_text' ) );
			?>
			</div>
		</div>
	</div>
</div>
