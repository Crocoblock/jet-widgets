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

			add_filter( 'wp_handle_sideload_prefilter', array( $this, 'sanitize_svg' ) );
			add_filter( 'wp_handle_upload_prefilter', array( $this, 'sanitize_svg' ) );
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
		 * Sanitize SVG files on upload
		 *
		 * @param array $file File data.
		 *
		 * @return mixed
		 */
		public function sanitize_svg( $file ) {

			if ( ! isset( $file['tmp_name'] ) ) {
				return $file;
			}

			$file_name   = isset( $file['name'] ) ? $file['name'] : '';
			$wp_filetype = wp_check_filetype_and_ext( $file['tmp_name'], $file_name );
			$type        = ! empty( $wp_filetype['type'] ) ? $wp_filetype['type'] : '';

			if ( 'image/svg+xml' === $type ) {

				if ( ! $this->sanitize_file( $file['tmp_name'] ) ) {
					$file['error'] = __(
						'File contains dangerous content. Please clean it and try again',
						'jet-widgets'
					);
				}
			}

			return $file;
		}

		/**
		 * Sanitize
		 * @return [type] [description]
		 */
		public function sanitize_file( $file ) {

			$dirty = file_get_contents( $file );

			// Is the SVG gzipped? If so we try and decode the string
			$is_zipped = $this->is_gzipped( $dirty );
			if ( $is_zipped ) {
				$dirty = gzdecode( $dirty );

				// If decoding fails, bail as we're not secure
				if ( false === $dirty ) {
					return false;
				}
			}

			$sanitizer = new \enshrined\svgSanitize\Sanitizer();
			$clean     = $sanitizer->sanitize( $dirty );

			if ( false === $clean ) {
				return false;
			}

			// If we were gzipped, we need to re-zip
			if ( $is_zipped ) {
				$clean = gzencode( $clean );
			}

			file_put_contents( $file, $clean );

			return true;
		}

		/**
		 * Check if the contents are gzipped
		 *
		 * @see http://www.gzip.org/zlib/rfc-gzip.html#member-format
		 *
		 * @param string $contents Content to check.
		 *
		 * @return bool
		 */
		protected function is_gzipped( $contents ) {
			if ( function_exists( 'mb_strpos' ) ) {
				return 0 === mb_strpos( $contents, "\x1f" . "\x8b" . "\x08" );
			} else {
				return 0 === strpos( $contents, "\x1f" . "\x8b" . "\x08" );
			}
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
