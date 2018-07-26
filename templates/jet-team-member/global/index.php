<?php
/**
 * Team Member main template
 */
$cover_hint = $this->get_settings( 'cover_like_hint' );
$hint_corner = $this->get_settings( 'use_hint_corner' );
$show_on_hover = $this->get_settings( 'show_on_hover' );

$classes_list[] = 'jet-team-member';

if ( filter_var( $cover_hint, FILTER_VALIDATE_BOOLEAN ) ) {
	$classes_list[] = 'jet-team-member--cover-hint';
}

if ( filter_var( $hint_corner, FILTER_VALIDATE_BOOLEAN ) ) {
	$classes_list[] = 'jet-team-member--hint-corner';
}

if ( filter_var( $show_on_hover, FILTER_VALIDATE_BOOLEAN ) ) {
	$classes_list[] = 'jet-team-member--cover-hover';
}

$classes = implode( ' ', $classes_list );

?>
<div class="<?php echo $classes; ?>">
	<div class="jet-team-member__inner">
		<div class="jet-team-member__image">
			<div class="jet-team-member__cover"><?php
				echo $this->__generate_name( true );
				echo $this->__generate_position( true );
				echo $this->__generate_description( true );
				echo $this->__generate_social_icon_list( true );
				echo $this->__generate_action_button( true ); ?></div>
			<?php echo $this->__get_member_image(); ?>
		</div>
		<div class="jet-team-member__content"><?php
			echo $this->__generate_name();
			echo $this->__generate_position();
			echo $this->__generate_description();
			echo $this->__generate_social_icon_list();
			echo $this->__generate_action_button(); ?></div>
	</div>
</div>
