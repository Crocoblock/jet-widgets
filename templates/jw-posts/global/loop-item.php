<?php
/**
 * Posts loop start template
 */
?>
<div class="jw-posts__item <?php echo esc_attr( jet_widgets_tools()->col_classes( array(
	'desk' => $this->get_attr( 'columns' ),
	'tab'  => $this->get_attr( 'columns_tablet' ),
	'mob'  => $this->get_attr( 'columns_mobile' ),
) ) ); ?>">
	<div class="jw-posts__inner-box"<?php $this->add_box_bg(); ?>><?php

		include $this->get_template( 'item-thumb' );

		echo '<div class="jw-posts__inner-content">';

			include $this->get_template( 'item-title' );
			include $this->get_template( 'item-meta' );
			include $this->get_template( 'item-content' );
			include $this->get_template( 'item-more' );

		echo '</div>';

	?></div>
</div>