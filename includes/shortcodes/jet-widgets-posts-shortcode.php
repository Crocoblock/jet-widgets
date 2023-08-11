<?php
/**
 * Posts shortcode class
 */
class Jet_Widgets_Posts_Shortcode extends Jet_Widgets_Shortcode_Base {

	/**
	 * Shortocde tag
	 *
	 * @return string
	 */
	public function get_tag() {
		return 'jw-posts';
	}

	/**
	 * Shortocde attributes
	 *
	 * @return array
	 */
	public function get_atts() {

		$columns = jet_widgets_tools()->get_select_range( 6 );

		return apply_filters( 'jet-widgets/shortcodes/jw-posts/atts', array(
			'number' => array(
				'type'       => 'number',
				'label'      => esc_html__( 'Posts Number', 'jetwidgets-for-elementor' ),
				'default'    => 3,
				'min'        => -1,
				'max'        => 30,
				'step'       => 1,
				'sanitize_cb' => 'absint'
			),
			'columns' => array(
				'type'               => 'select',
				'responsive'         => true,
				'label'              => esc_html__( 'Columns', 'jetwidgets-for-elementor' ),
				'default'            => 3,
				'options'            => $columns,
				'frontend_available' => true,
				'render_type'        => 'template',
			),
			'equal_height_cols' => array(
				'label'        => esc_html__( 'Equal Columns Height', 'jetwidgets-for-elementor' ),
				'type'         => 'switcher',
				'label_on'     => esc_html__( 'Yes', 'jetwidgets-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'jetwidgets-for-elementor' ),
				'return_value' => 'true',
				'default'      => '',
				'sanitize_cb'  => array( $this, 'sanitize_boolean' ),
			),
			'post_type'   => array(
				'type'       => 'select',
				'label'      => esc_html__( 'Post Type', 'jetwidgets-for-elementor' ),
				'default'    => 'post',
				'options'    => jet_widgets_tools()->get_post_types(),
			),
			'posts_query' => array(
				'type'       => 'select',
				'label'      => esc_html__( 'Query posts by', 'jetwidgets-for-elementor' ),
				'default'    => 'latest',
				'options'    => array(
					'latest'   => esc_html__( 'Latest Posts', 'jetwidgets-for-elementor' ),
					'category' => esc_html__( 'From Category', 'jetwidgets-for-elementor' ),
					'ids'      => esc_html__( 'By Specific IDs', 'jetwidgets-for-elementor' ),
				),
				'condition' => array(
					'post_type' => array( 'post' ),
				),
			),
			'post_ids' => array(
				'type'      => 'text',
				'label'     => esc_html__( 'Set comma separated IDs list (10, 22, 19 etc.)', 'jetwidgets-for-elementor' ),
				'default'   => '',
				'condition' => array(
					'posts_query' => array( 'ids' ),
					'post_type'   => array( 'post' ),
				),
				'sanitize_cb' => function( $value ) {
					// Keep only numbers and commas
					$value = preg_replace( '/[^/d,]/', '', $value );
					return $value;
				}
			),
			'post_cat' => array(
				'type'        => 'select2',
				'label'       => esc_html__( 'Category', 'jetwidgets-for-elementor' ),
				'default'     => '',
				'multiple'    => true,
				'label_block' => true,
				'options'     => jet_widgets_tools()->get_categories(),
				'condition'   => array(
					'posts_query' => array( 'category' ),
					'post_type'   => array( 'post' ),
				),
			),
			'post_offset' => array(
				'type'    => 'number',
				'label'   => esc_html__( 'Post offset', 'jetwidgets-for-elementor' ),
				'default' => 0,
				'min'     => 0,
				'max'     => 100,
				'step'    => 1,
				'sanitize_cb' => 'absint'
			),
			'show_title' => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Show Posts Title', 'jetwidgets-for-elementor' ),
				'label_on'     => esc_html__( 'Yes', 'jetwidgets-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'jetwidgets-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'sanitize_cb'  => array( $this, 'sanitize_boolean' ),
			),

			'title_trimmed' => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Title Word Trim', 'jetwidgets-for-elementor' ),
				'label_on'     => esc_html__( 'Yes', 'jetwidgets-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'jetwidgets-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'sanitize_cb'  => array( $this, 'sanitize_boolean' ),
				'condition' => array(
					'show_title' => 'yes',
				),
			),

			'title_length' => array(
				'type'      => 'number',
				'label'     => esc_html__( 'Title Length', 'jetwidgets-for-elementor' ),
				'default'   => 5,
				'min'       => 1,
				'max'       => 50,
				'step'      => 1,
				'sanitize_cb' => 'absint',
				'condition' => array(
					'title_trimmed' => 'yes',
				),
			),

			'title_trimmed_ending_text' => array(
				'type'      => 'text',
				'label'     => esc_html__( 'Title Trimmed Ending', 'jetwidgets-for-elementor' ),
				'default'   => '...',
				'sanitize_cb' => 'wp_kses_post',
				'condition' => array(
					'title_trimmed' => 'yes',
				),
			),

			'show_image' => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Show Posts Featured Image', 'jetwidgets-for-elementor' ),
				'label_on'     => esc_html__( 'Yes', 'jetwidgets-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'jetwidgets-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'sanitize_cb'  => array( $this, 'sanitize_boolean' ),
			),
			'show_image_as' => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Show Featured Image As', 'jetwidgets-for-elementor' ),
				'default'     => 'image',
				'label_block' => true,
				'options'     => array(
					'image'      => esc_html__( 'Simple Image', 'jetwidgets-for-elementor' ),
					'background' => esc_html__( 'Box Background', 'jetwidgets-for-elementor' ),
				),
				'condition' => array(
					'show_image' => array( 'yes' ),
				),
			),
			'bg_size' => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Background Image Size', 'jetwidgets-for-elementor' ),
				'label_block' => true,
				'default'     => 'cover',
				'options'     => array(
					'cover'   => esc_html__( 'Cover', 'jetwidgets-for-elementor' ),
					'contain' => esc_html__( 'Contain', 'jetwidgets-for-elementor' ),
				),
				'condition'   => array(
					'show_image'    => array( 'yes' ),
					'show_image_as' => array( 'background' ),
				),
			),
			'bg_position' => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Background Image Position', 'jetwidgets-for-elementor' ),
				'label_block' => true,
				'default'     => 'center center',
				'options'     => array(
					'center center' => esc_attr_x( 'Center Center', 'Background Control', 'jetwidgets-for-elementor' ),
					'center left'   => esc_attr_x( 'Center Left', 'Background Control', 'jetwidgets-for-elementor' ),
					'center right'  => esc_attr_x( 'Center Right', 'Background Control', 'jetwidgets-for-elementor' ),
					'top center'    => esc_attr_x( 'Top Center', 'Background Control', 'jetwidgets-for-elementor' ),
					'top left'      => esc_attr_x( 'Top Left', 'Background Control', 'jetwidgets-for-elementor' ),
					'top right'     => esc_attr_x( 'Top Right', 'Background Control', 'jetwidgets-for-elementor' ),
					'bottom center' => esc_attr_x( 'Bottom Center', 'Background Control', 'jetwidgets-for-elementor' ),
					'bottom left'   => esc_attr_x( 'Bottom Left', 'Background Control', 'jetwidgets-for-elementor' ),
					'bottom right'  => esc_attr_x( 'Bottom Right', 'Background Control', 'jetwidgets-for-elementor' ),
				),
				'condition'   => array(
					'show_image'    => array( 'yes' ),
					'show_image_as' => array( 'background' ),
				),
			),
			'thumb_size' => array(
				'type'       => 'select',
				'label'      => esc_html__( 'Featured Image Size', 'jetwidgets-for-elementor' ),
				'default'    => 'post-thumbnail',
				'options'    => jet_widgets_tools()->get_image_sizes(),
				'condition' => array(
					'show_image'    => array( 'yes' ),
					'show_image_as' => array( 'image' ),
				),
			),
			'show_excerpt' => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Show Posts Excerpt', 'jetwidgets-for-elementor' ),
				'label_on'     => esc_html__( 'Yes', 'jetwidgets-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'jetwidgets-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'sanitize_cb'  => array( $this, 'sanitize_boolean' ),
			),
			'excerpt_length' => array(
				'type'       => 'number',
				'label'      => esc_html__( 'Excerpt Length', 'jetwidgets-for-elementor' ),
				'default'    => 20,
				'min'        => 1,
				'max'        => 300,
				'step'       => 1,
				'sanitize_cb'  => 'absint',
				'condition' => array(
					'show_excerpt' => array( 'yes' ),
				),
			),
			'show_meta' => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Show Posts Meta', 'jetwidgets-for-elementor' ),
				'label_on'     => esc_html__( 'Yes', 'jetwidgets-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'jetwidgets-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'sanitize_cb'  => array( $this, 'sanitize_boolean' ),
			),
			'show_author' => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Show Posts Author', 'jetwidgets-for-elementor' ),
				'label_on'     => esc_html__( 'Yes', 'jetwidgets-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'jetwidgets-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'sanitize_cb'  => array( $this, 'sanitize_boolean' ),
				'condition' => array(
					'show_meta' => array( 'yes' ),
				),
			),
			'show_date' => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Show Posts Date', 'jetwidgets-for-elementor' ),
				'label_on'     => esc_html__( 'Yes', 'jetwidgets-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'jetwidgets-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'sanitize_cb'  => array( $this, 'sanitize_boolean' ),
				'condition' => array(
					'show_meta' => array( 'yes' ),
				),
			),
			'show_comments' => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Show Posts Comments', 'jetwidgets-for-elementor' ),
				'label_on'     => esc_html__( 'Yes', 'jetwidgets-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'jetwidgets-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'sanitize_cb'  => array( $this, 'sanitize_boolean' ),
				'condition' => array(
					'show_meta' => array( 'yes' ),
				),
			),
			'show_more' => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Show Read More Button', 'jetwidgets-for-elementor' ),
				'label_on'     => esc_html__( 'Yes', 'jetwidgets-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'jetwidgets-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'sanitize_cb'  => array( $this, 'sanitize_boolean' ),
			),
			'more_text' => array(
				'type'      => 'text',
				'label'     => esc_html__( 'Read More Button Text', 'jetwidgets-for-elementor' ),
				'default'   => esc_html__( 'Read More', 'jetwidgets-for-elementor' ),
				'sanitize_cb'  => 'wp_kses_post',
				'condition' => array(
					'show_more' => array( 'yes' ),
				),
			),
			'more_icon' => array(
				'type'        => 'icon',
				'label'       => esc_html__( 'Read More Button Icon', 'jetwidgets-for-elementor' ),
				'label_block' => false,
				'skin'        => 'inline',
				'sanitize_cb'  => array( jet_widgets_tools(), 'kses_post_extended' ),
				'condition'   => array(
					'show_more' => array( 'yes' ),
				),
			),
			'columns_gap' => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Add gap between columns', 'jetwidgets-for-elementor' ),
				'label_on'     => esc_html__( 'Yes', 'jetwidgets-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'jetwidgets-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'sanitize_cb'  => array( $this, 'sanitize_boolean' ),
			),
			'rows_gap' => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Add gap between rows', 'jetwidgets-for-elementor' ),
				'label_on'     => esc_html__( 'Yes', 'jetwidgets-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'jetwidgets-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'sanitize_cb'  => array( $this, 'sanitize_boolean' ),
			),
			'show_title_related_meta'       => array( 'default' => false, 'sanitize_cb'  => array( $this, 'sanitize_boolean' ), ),
			'show_content_related_meta'     => array( 'default' => false, 'sanitize_cb'  => array( $this, 'sanitize_boolean' ), ),
			'meta_title_related_position'   => array( 'default' => false /* Sanitized on output */ ),
			'meta_content_related_position' => array( 'default' => false /* Sanitized on output */ ),
			'title_related_meta'            => array( 'default' => false /* Sanitized on output */ ),
			'content_related_meta'          => array( 'default' => false /* Sanitized on output */ ),
		) );

	}

	/**
	 * Sanitize boolen-like data
	 * 
	 * @param  [type] $value [description]
	 * @return [type]        [description]
	 */
	public function sanitize_boolean( $value ) {
		return ( true === filter_var( $value, FILTER_VALIDATE_BOOLEAN ) ) ? 'yes' : false;
	}

	/**
	 * Query posts by attributes
	 *
	 * @return object
	 */
	public function query() {

		$query_args = array(
			'post_type'           => 'post',
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true,
			'posts_per_page'      => intval( $this->get_attr( 'number' ) ),
		);

		$post_type = $this->get_attr( 'post_type' );

		if ( ! $post_type ) {
			$post_type = 'post';
		}

		$query_args['post_type'] = $post_type;

		$offset = $this->get_attr( 'post_offset' );
		$offset = ! empty( $offset ) ? absint( $offset ) : 0;

		if ( $offset ) {
			$query_args['offset'] = $offset;
		}

		if ( 'post' === $post_type ) {
			switch ( $this->get_attr( 'posts_query' ) ) {

				case 'category':

					if ( '' !== $this->get_attr( 'post_cat' ) ) {
						$query_args['category__in'] = explode( ',', $this->get_attr( 'post_cat' ) );
					}

					break;

				case 'ids':

					if ( '' !== $this->get_attr( 'post_ids' ) ) {
						$query_args['post__in'] = explode(
							',',
							str_replace( ' ', '', $this->get_attr( 'post_ids' ) )
						);
					}
					break;
			}
		}

		return new WP_Query( $query_args );
	}

	/**
	 * Posts shortocde function
	 *
	 * @param  array  $atts Attributes array.
	 * @return string
	 */
	public function _shortcode( $content = null ) {

		$query = $this->query();

		if ( ! $query->have_posts() ) {
			$not_found = $this->get_template( 'not-found' );
		}

		$loop_start = $this->get_template( 'loop-start' );
		$loop_item  = $this->get_template( 'loop-item' );
		$loop_end   = $this->get_template( 'loop-end' );

		global $post;

		ob_start();

		/**
		 * Hook before loop start template included
		 */
		do_action( 'jet-widgets/shortcodes/jw-posts/loop-start' );

		include $loop_start;

		while ( $query->have_posts() ) {

			$query->the_post();
			$post = $query->post;

			setup_postdata( $post );

			/**
			 * Hook before loop item template included
			 */
			do_action( 'jet-widgets/shortcodes/jw-posts/loop-item-start' );

			include $loop_item;

			/**
			 * Hook after loop item template included
			 */
			do_action( 'jet-widgets/shortcodes/jw-posts/loop-item-end' );

		}

		include $loop_end;

		/**
		 * Hook after loop end template included
		 */
		do_action( 'jet-widgets/shortcodes/jet-posts/loop-end' );

		wp_reset_postdata();

		return ob_get_clean();

	}

	/**
	 * Add box backgroud image
	 */
	public function add_box_bg() {

		if ( 'yes' !== $this->get_attr( 'show_image' ) ) {
			return;
		}

		if ( 'background' !== $this->get_attr( 'show_image_as' ) ) {
			return;
		}

		if ( ! has_post_thumbnail() ) {
			return;
		}

		$thumb_id  = get_post_thumbnail_id();
		$thumb_url = wp_get_attachment_image_url( $thumb_id, 'full' );

		printf(
			' style="background-image: url(\'%1$s\');background-repeat:no-repeat;background-size: %2$s;background-position: %3$s;"',
			$thumb_url,
			$this->get_attr( 'bg_size' ),
			$this->get_attr( 'bg_position' )
		);

	}

	/**
	 * Render meta for passed position
	 *
	 * @param  string $position [description]
	 * @return [type]           [description]
	 */
	public function render_meta( $position = '', $base = '', $context = array( 'before' ) ) {

		$config_key    = $position . '_meta';
		$show_key      = 'show_' . $position . '_meta';
		$position_key  = 'meta_' . $position . '_position';
		$meta_show     = $this->get_attr( $show_key );
		$meta_position = $this->get_attr( $position_key );
		$meta_config   = $this->get_attr( $config_key );

		if ( 'yes' !== $meta_show ) {
			return;
		}

		if ( ! $meta_position || ! in_array( $meta_position, $context ) ) {
			return;
		}

		if ( empty( $meta_config ) ) {
			return;
		}

		$result = '';

		foreach ( $meta_config as $meta ) {

			if ( empty( $meta['meta_key'] ) ) {
				continue;
			}

			$key      = $meta['meta_key'];
			$callback = ! empty( $meta['meta_callback'] ) ? $meta['meta_callback'] : false;
			$value    = get_post_meta( get_the_ID(), $key, false );

			if ( ! $value ) {
				continue;
			}

			$callback_args = array( $value[0] );

			if ( $callback && 'wp_get_attachment_image' === $callback ) {
				$callback_args[] = 'full';
			}

			if ( ! empty( $callback ) && is_callable( $callback ) ) {
				$meta_val = call_user_func_array( $callback, $callback_args );
			} else {
				$meta_val = $value[0];
			}

			$meta_val = sprintf( $meta['meta_format'], $meta_val );

			$label = ! empty( $meta['meta_label'] )
				? sprintf( '<div class="%1$s__item-label">%2$s</div>', $base, $meta['meta_label'] )
				: '';

			$result .= sprintf(
				'<div class="%1$s__item">%2$s<div class="%1$s__item-value">%3$s</div></div>',
				$base, $label, $meta_val
			);

		}

		printf( '<div class="%1$s">%2$s</div>', $base, $result );

	}

}
