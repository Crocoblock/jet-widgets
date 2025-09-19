<?php
/**
 * Featured badge template
 */

$badge = $this->get_settings( 'featured_badge' );

if ( isset( $badge['url'] ) ) {
	echo jet_widgets_tools()->get_image_by_url( $badge['url'], array( 'class' => 'pricing-table__badge' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}