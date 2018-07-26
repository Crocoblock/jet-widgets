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

		return apply_filters( 'jet-widgets/shortcodes/jet-posts/atts', array(
			'number' => array(
				'type'       => 'number',
				'label'      => esc_html__( 'Posts Number', 'jet-widgets' ),
				'default'    => 3,
				'min'        => -1,
				'max'        => 30,
				'step'       => 1,
			),
			'columns' => array(
				'type'       => 'select',
				'responsive' => true,
				'label'      => esc_html__( 'Columns', 'jet-widgets' ),
				'default'    => 3,
				'options'    => $columns,
			),
			'columns_tablet' => array(
				'default' => 2,
			),
			'columns_mobile' => array(
				'default' => 1,
			),
			'equal_height_cols' => array(
				'label'        => esc_html__( 'Equal Columns Height', 'jet-widgets' ),
				'type'         => 'switcher',
				'label_on'     => esc_html__( 'Yes', 'jet-widgets' ),
				'label_off'    => esc_html__( 'No', 'jet-widgets' ),
				'return_value' => 'true',
				'default'      => '',
			),
			'post_type'   => array(
				'type'       => 'select',
				'label'      => esc_html__( 'Post Type', 'jet-widgets' ),
				'default'    => 'post',
				'options'    => jet_widgets_tools()->get_post_types(),
			),
			'posts_query' => array(
				'type'       => 'select',
				'label'      => esc_html__( 'Query posts by', 'jet-widgets' ),
				'default'    => 'latest',
				'options'    => array(
					'latest'   => esc_html__( 'Latest Posts', 'jet-widgets' ),
					'category' => esc_html__( 'From Category', 'jet-widgets' ),
					'ids'      => esc_html__( 'By Specific IDs', 'jet-widgets' ),
				),
				'condition' => array(
					'post_type' => array( 'post' ),
				),
			),
			'post_ids' => array(
				'type'      => 'text',
				'label'     => esc_html__( 'Set comma separated IDs list (10, 22, 19 etc.)', 'jet-widgets' ),
				'default'   => '',
				'condition' => array(
					'posts_query' => array( 'ids' ),
					'post_type'   => array( 'post' ),
				),
			),
			'post_cat' => array(
				'type'       => 'select2',
				'label'      => esc_html__( 'Category', 'jet-widgets' ),
				'default'    => '',
				'multiple'   => true,
				'options'    => jet_widgets_tools()->get_categories(),
				'condition' => array(
					'posts_query' => array( 'category' ),
					'post_type'   => array( 'post' ),
				),
			),
			'post_offset' => array(
				'type'    => 'number',
				'label'   => esc_html__( 'Post offset', 'jet-widgets' ),
				'default' => 0,
				'min'     => 0,
				'max'     => 100,
				'step'    => 1,
			),
			'show_title' => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Show Posts Title', 'jet-widgets' ),
				'label_on'     => esc_html__( 'Yes', 'jet-widgets' ),
				'label_off'    => esc_html__( 'No', 'jet-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			),

			'title_trimmed' => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Title Word Trim', 'jet-widgets' ),
				'label_on'     => esc_html__( 'Yes', 'jet-widgets' ),
				'label_off'    => esc_html__( 'No', 'jet-widgets' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'condition' => array(
					'show_title' => 'yes',
				),
			),

			'title_length' => array(
				'type'      => 'number',
				'label'     => esc_html__( 'Title Length', 'jet-widgets' ),
				'default'   => 5,
				'min'       => 1,
				'max'       => 50,
				'step'      => 1,
				'condition' => array(
					'title_trimmed' => 'yes',
				),
			),

			'title_trimmed_ending_text' => array(
				'type'      => 'text',
				'label'     => esc_html__( 'Title Trimmed Ending', 'jet-widgets' ),
				'default'   => '...',
				'condition' => array(
					'title_trimmed' => 'yes',
				),
			),

			'show_image' => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Show Posts Featured Image', 'jet-widgets' ),
				'label_on'     => esc_html__( 'Yes', 'jet-widgets' ),
				'label_off'    => esc_html__( 'No', 'jet-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			),
			'show_image_as' => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Show Featured Image As', 'jet-widgets' ),
				'default'     => 'image',
				'label_block' => true,
				'options'     => array(
					'image'      => esc_html__( 'Simple Image', 'jet-widgets' ),
					'background' => esc_html__( 'Box Background', 'jet-widgets' ),
				),
				'condition' => array(
					'show_image' => array( 'yes' ),
				),
			),
			'bg_size' => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Background Image Size', 'jet-widgets' ),
				'label_block' => true,
				'default'     => 'cover',
				'options'     => array(
					'cover'   => esc_html__( 'Cover', 'jet-widgets' ),
					'contain' => esc_html__( 'Contain', 'jet-widgets' ),
				),
				'condition'   => array(
					'show_image'    => array( 'yes' ),
					'show_image_as' => array( 'background' ),
				),
			),
			'bg_position' => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Background Image Position', 'jet-widgets' ),
				'label_block' => true,
				'default'     => 'center center',
				'options'     => array(
					'center center' => esc_html__( 'Center Center', 'Background Control', 'jet-widgets' ),
					'center left'   => esc_html__( 'Center Left', 'Background Control', 'jet-widgets' ),
					'center right'  => esc_html__( 'Center Right', 'Background Control', 'jet-widgets' ),
					'top center'    => esc_html__( 'Top Center', 'Background Control', 'jet-widgets' ),
					'top left'      => esc_html__( 'Top Left', 'Background Control', 'jet-widgets' ),
					'top right'     => esc_html__( 'Top Right', 'Background Control', 'jet-widgets' ),
					'bottom center' => esc_html__( 'Bottom Center', 'Background Control', 'jet-widgets' ),
					'bottom left'   => esc_html__( 'Bottom Left', 'Background Control', 'jet-widgets' ),
					'bottom right'  => esc_html__( 'Bottom Right', 'Background Control', 'jet-widgets' ),
				),
				'condition'   => array(
					'show_image'    => array( 'yes' ),
					'show_image_as' => array( 'background' ),
				),
			),
			'thumb_size' => array(
				'type'       => 'select',
				'label'      => esc_html__( 'Featured Image Size', 'jet-widgets' ),
				'default'    => 'post-thumbnail',
				'options'    => jet_widgets_tools()->get_image_sizes(),
				'condition' => array(
					'show_image'    => array( 'yes' ),
					'show_image_as' => array( 'image' ),
				),
			),
			'show_excerpt' => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Show Posts Excerpt', 'jet-widgets' ),
				'label_on'     => esc_html__( 'Yes', 'jet-widgets' ),
				'label_off'    => esc_html__( 'No', 'jet-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			),
			'excerpt_length' => array(
				'type'       => 'number',
				'label'      => esc_html__( 'Excerpt Length', 'jet-widgets' ),
				'default'    => 20,
				'min'        => 1,
				'max'        => 300,
				'step'       => 1,
				'condition' => array(
					'show_excerpt' => array( 'yes' ),
				),
			),
			'show_meta' => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Show Posts Meta', 'jet-widgets' ),
				'label_on'     => esc_html__( 'Yes', 'jet-widgets' ),
				'label_off'    => esc_html__( 'No', 'jet-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			),
			'show_author' => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Show Posts Author', 'jet-widgets' ),
				'label_on'     => esc_html__( 'Yes', 'jet-widgets' ),
				'label_off'    => esc_html__( 'No', 'jet-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition' => array(
					'show_meta' => array( 'yes' ),
				),
			),
			'show_date' => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Show Posts Date', 'jet-widgets' ),
				'label_on'     => esc_html__( 'Yes', 'jet-widgets' ),
				'label_off'    => esc_html__( 'No', 'jet-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition' => array(
					'show_meta' => array( 'yes' ),
				),
			),
			'show_comments' => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Show Posts Comments', 'jet-widgets' ),
				'label_on'     => esc_html__( 'Yes', 'jet-widgets' ),
				'label_off'    => esc_html__( 'No', 'jet-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition' => array(
					'show_meta' => array( 'yes' ),
				),
			),
			'show_more' => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Show Read More Button', 'jet-widgets' ),
				'label_on'     => esc_html__( 'Yes', 'jet-widgets' ),
				'label_off'    => esc_html__( 'No', 'jet-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			),
			'more_text' => array(
				'type'      => 'text',
				'label'     => esc_html__( 'Read More Button Text', 'jet-widgets' ),
				'default'   => esc_html__( 'Read More', 'jet-widgets' ),
				'condition' => array(
					'show_more' => array( 'yes' ),
				),
			),
			'more_icon' => array(
				'type'      => 'icon',
				'label'     => esc_html__( 'Read More Button Icon', 'jet-widgets' ),
				'condition' => array(
					'show_more' => array( 'yes' ),
				),
			),
			'columns_gap' => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Add gap between columns', 'jet-widgets' ),
				'label_on'     => esc_html__( 'Yes', 'jet-widgets' ),
				'label_off'    => esc_html__( 'No', 'jet-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			),
			'rows_gap' => array(
				'type'         => 'switcher',
				'label'        => esc_html__( 'Add gap between rows', 'jet-widgets' ),
				'label_on'     => esc_html__( 'Yes', 'jet-widgets' ),
				'label_off'    => esc_html__( 'No', 'jet-widgets' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			),
			'show_title_related_meta'       => array( 'default' => false ),
			'show_content_related_meta'     => array( 'default' => false ),
			'meta_title_related_position'   => array( 'default' => false ),
			'meta_content_related_position' => array( 'default' => false ),
			'title_related_meta'            => array( 'default' => false ),
			'content_related_meta'          => array( 'default' => false ),
		) );

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

		$offset = ! empty( $this->get_attr( 'post_offset' ) ) ? absint( $this->get_attr( 'post_offset' ) ) : 0;

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
		do_action( 'jet-widgets/shortcodes/jet-posts/loop-start' );

		include $loop_start;

		while ( $query->have_posts() ) {

			$query->the_post();
			$post = $query->post;

			setup_postdata( $post );

			/**
			 * Hook before loop item template included
			 */
			do_action( 'jet-widgets/shortcodes/jet-posts/loop-item-start' );

			include $loop_item;

			/**
			 * Hook after loop item template included
			 */
			do_action( 'jet-widgets/shortcodes/jet-posts/loop-item-end' );

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
