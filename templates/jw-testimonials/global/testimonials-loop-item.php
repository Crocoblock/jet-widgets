<?php
/**
 * Testimonials item template
 */
$settings = $this->get_settings();
$stars = $this->render_stars( $item );

?>
<div class="jw-testimonials__item">
	<div class="jw-testimonials__item-inner">
		<div class="jw-testimonials__content"><?php
			echo $this->__loop_item( array( 'item_image', 'url' ), '<figure class="jw-testimonials__figure"><img class="jw-testimonials__tag-img" src="%s" alt=""></figure>' );
			$this->_render_icon( 'item_icon' , '<div class="jw-testimonials__icon"><div class="jw-testimonials__icon-inner"><span class="jet-widgets-icon">%s</span></div></div>' );
			echo $this->__loop_item( array( 'item_title' ), '<h5 class="jw-testimonials__title">%s</h5>' );
			echo $this->__loop_item( array( 'item_comment' ), '<p class="jw-testimonials__comment"><span>%s</span></p>' );
			echo $this->__loop_item( array( 'item_name' ), '<div class="jw-testimonials__name"><span>%s</span></div>' );
			echo $this->__loop_item( array( 'item_position' ), '<div class="jw-testimonials__position"><span>%s</span></div>' );
			echo $this->__loop_item( array( 'item_date' ), '<div class="jw-testimonials__date"><span>%s</span></div>' );
			echo $this->__loop_item( array( 'item_rating' ), '<div class="jw-testimonials__rating">' . $stars . '</div>' );
		?></div>
	</div>
</div>

