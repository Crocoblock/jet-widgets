<?php
/**
 * Class description
 *
 * @package   package_name
 * @author    Cherry Team
 * @license   GPL-2.0+
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'Jet_Widgets_SVG_Manager' ) ) {

	/**
	 * Define Jet_Widgets_SVG_Manager class
	 */
	class Jet_Widgets_SVG_Manager {

		/**
		 * A reference to an instance of this class.
		 *
		 * @since 1.0.0
		 * @var   object
		 */
		private static $instance = null;

		/**
		 * Constructor for the class
		 */
		public function init() {

			$svg_enabled = jet_widgets_settings()->get( 'svg_uploads', 'enabled' );

			if ( 'enabled' !== $svg_enabled ) {
				return;
			}

			add_filter( 'upload_mimes', array( $this, 'allow_svg' ) );
			add_action( 'admin_head', array( $this, 'fix_svg_thumb_display' ) );
		}

		/**
		 * Allow SVG images uploading
		 *
		 * @return array
		 */
		public function allow_svg( $mimes ) {
			$mimes['svg'] = 'image/svg+xml';
			return $mimes;
		}

		/**
		 * Fix thumbnails display
		 *
		 * @return void
		 */
		public function fix_svg_thumb_display() {
			?>
			<style type="text/css">
				td.media-icon img[src$=".svg"], img[src$=".svg"].attachment-post-thumbnail {
					width: 100% !important;
					height: auto !important;
				}
			</style>
			<?php
		}

		/**
		 * Returns the instance.
		 *
		 * @since  1.0.0
		 * @return object
		 */
		public static function get_instance() {

			// If the single instance hasn't been set, set it now.
			if ( null == self::$instance ) {
				self::$instance = new self;
			}
			return self::$instance;
		}
	}

}

/**
 * Returns instance of Jet_Widgets_SVG_Manager
 *
 * @return object
 */
function jet_widgets_svg_manager() {
	return Jet_Widgets_SVG_Manager::get_instance();
}
