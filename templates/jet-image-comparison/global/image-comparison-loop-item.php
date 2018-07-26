<?php
/**
 * Image Comparison item template
 */
$settings = $this->get_settings();
$prevArrow = $settings['handle_prev_arrow'];
$nextArrow = $settings['handle_next_arrow'];
$starting_position = $settings['starting_position'];
$starting_position_string = $starting_position['size'] . $starting_position['unit'];

$item_before_label = $this->__loop_item( array( 'item_before_label' ), 'data-label="%s"' );
$item_before_image = $this->__loop_item( array( 'item_before_image', 'url' ), '%s' );
$item_after_label = $this->__loop_item( array( 'item_after_label' ), 'data-label="%s"' );
$item_after_image = $this->__loop_item( array( 'item_after_image', 'url' ), '%s' );

?>
<div class="jet-image-comparison__item">
	<div class="jet-image-comparison__container jet-juxtapose" data-prev-icon="<?php echo $prevArrow; ?>" data-next-icon="<?php echo $nextArrow; ?>" data-makeresponsive="true" data-startingposition="<?php echo $starting_position_string; ?>">
		<img class="jet-image-comparison__before-image" src="<?php echo $item_before_image; ?>" <?php echo $item_before_label; ?> alt="">
		<img class="jet-image-comparison__after-image" src="<?php echo $item_after_image; ?>" <?php echo $item_after_label; ?> alt="">
	</div>
</div>

