<?php
/**
 * Services main template
 */
$classes_list[] = 'jet-services';

$show_on_hover = $this->get_settings( 'show_on_hover' );
$header_position = $this->get_settings( 'header_position' );

$classes_list[] = 'jet-services--header-position-' . $header_position;

if ( filter_var( $show_on_hover, FILTER_VALIDATE_BOOLEAN ) ) {
	$classes_list[] = 'jet-services--cover-hover';
}

$classes = implode( ' ', $classes_list );

?>
<div class="<?php echo $classes; ?>">
	<div class="jet-services__inner">
		<div class="jet-services__header">
			<div class="jet-services__cover"><?php
			echo $this->__generate_icon( true );
			echo $this->__generate_title( true );
			echo $this->__generate_description( true );
			echo $this->__generate_action_button( true ); ?></div>
		</div>
		<div class="jet-services__content"><?php
			echo $this->__generate_icon();
			echo $this->__generate_title();
			echo $this->__generate_description();
			echo $this->__generate_action_button(); ?></div>
	</div>
</div>
