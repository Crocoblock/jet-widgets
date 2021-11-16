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
			echo wp_kses_post( $this->__generate_icon( true ) );
			echo wp_kses_post( $this->__generate_title( true ) );
			echo wp_kses_post( $this->__generate_description( true ) );
			echo wp_kses_post( $this->__generate_action_button( true ) ); ?></div>
		</div>
		<div class="jw-services__content"><?php
			echo wp_kses_post( $this->__generate_icon() );
			echo wp_kses_post( $this->__generate_title() );
			echo wp_kses_post( $this->__generate_description() );
			echo wp_kses_post( $this->__generate_action_button() ); ?></div>
	</div>
</div>
