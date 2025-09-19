<?php
/**
 * Image Comparison item template
 */
$settings = $this->get_settings_for_display();

$prevArrow = ! empty( $settings['selected_handle_prev_arrow']['value'] ) ? $settings['selected_handle_prev_arrow']['value'] : '';
$nextArrow = ! empty( $settings['selected_handle_next_arrow']['value'] ) ? $settings['selected_handle_next_arrow']['value'] : '';

if ( empty( $prevArrow ) ) {
	$prevArrow = ! empty( $settings['handle_prev_arrow'] ) ? $settings['handle_prev_arrow'] : '';
}

if ( empty( $nextArrow ) ) {
	$nextArrow = ! empty( $settings['handle_next_arrow'] ) ? $settings['handle_next_arrow'] : '';
}

$starting_position = $settings['starting_position'];
$starting_position_string = $starting_position['size'] . $starting_position['unit'];

$item_before_label = $this->__loop_item( array( 'item_before_label' ), '%s' );
$item_before_image = $this->__loop_item( array( 'item_before_image', 'url' ), '%s' );
$item_after_label = $this->__loop_item( array( 'item_after_label' ), '%s' );
$item_after_image = $this->__loop_item( array( 'item_after_image', 'url' ), '%s' );

?>
<div class="jw-image-comparison__item">
	<div class="jw-image-comparison__container jw-juxtapose" data-prev-icon="<?php echo esc_attr( $prevArrow ); ?>" data-next-icon="<?php echo esc_attr( $nextArrow ); ?>" data-makeresponsive="true" data-startingposition="<?php echo esc_attr( $starting_position_string ); ?>">
		<img class="jw-image-comparison__before-image" src="<?php echo esc_url( $item_before_image ); ?>" data-label="<?php echo esc_attr( $item_before_label ); ?>" alt="">
		<img class="jw-image-comparison__after-image" src="<?php echo esc_url( $item_after_image ); ?>" data-label="<?php echo esc_attr( $item_after_label ); ?>" alt="">
	</div>
</div>
