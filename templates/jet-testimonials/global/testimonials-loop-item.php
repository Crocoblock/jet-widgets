<?php
/**
 * Testimonials item template
 */
$settings = $this->get_settings();

?>
<div class="jet-testimonials__item">
	<div class="jet-testimonials__item-inner">
		<div class="jet-testimonials__content"><?php
			echo $this->__loop_item( array( 'item_image', 'url' ), '<figure class="jet-testimonials__figure"><img class="jet-testimonials__tag-img" src="%s" alt=""></figure>' );
			echo $this->__loop_item( array( 'item_icon' ), '<div class="jet-testimonials__icon"><div class="jet-testimonials__icon-inner"><i class="%s"></i></div></div>' );
			echo $this->__loop_item( array( 'item_title' ), '<h5 class="jet-testimonials__title">%s</h5>' );
			echo $this->__loop_item( array( 'item_comment' ), '<p class="jet-testimonials__comment"><span>%s</span></p>' );
			echo $this->__loop_item( array( 'item_name' ), '<div class="jet-testimonials__name"><span>%s</span></div>' );
			echo $this->__loop_item( array( 'item_position' ), '<div class="jet-testimonials__position"><span>%s</span></div>' );
			echo $this->__loop_item( array( 'item_date' ), '<div class="jet-testimonials__date"><span>%s</span></div>' );
		?></div>
	</div>
</div>

