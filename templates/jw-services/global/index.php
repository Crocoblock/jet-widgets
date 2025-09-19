<?php
/**
 * Services main template
 */
$classes_list[] = 'jw-services';

$show_on_hover = $this->get_settings( 'show_on_hover' );
$header_position = $this->get_settings( 'header_position' );

$classes_list[] = 'jw-services--header-position-' . $header_position;

if ( filter_var( $show_on_hover, FILTER_VALIDATE_BOOLEAN ) ) {
	$classes_list[] = 'jw-services--cover-hover';
}

$classes = implode( ' ', $classes_list );

?>
<div class="<?php echo esc_attr( $classes ); ?>">
	<div class="jw-services__inner">
		<div class="jw-services__header">
			<div class="jw-services__cover"><?php
			echo $this->__generate_icon( true ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo jet_widgets_tools()->kses_post_extended( $this->__generate_title( true ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo wp_kses_post( $this->__generate_description( true ) );
			echo jet_widgets_tools()->kses_post_extended( $this->__generate_action_button( true ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
		</div>
		<div class="jw-services__content"><?php
			echo $this->__generate_icon(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo jet_widgets_tools()->kses_post_extended( $this->__generate_title() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			echo wp_kses_post( $this->__generate_description() );
			echo jet_widgets_tools()->kses_post_extended( $this->__generate_action_button() ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></div>
	</div>
</div>

