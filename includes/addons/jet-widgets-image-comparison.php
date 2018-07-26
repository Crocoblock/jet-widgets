<?php
/**
 * Class: Jet_Widgets_Image_Comparison
 * Name: Image Comparison
 * Slug: jet-image-comparison
 */

namespace Elementor;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Scheme_Color;
use Elementor\Scheme_Typography;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Jet_Widgets_Image_Comparison extends Jet_Widgets_Base {

	public function get_name() {
		return 'jw-image-comparison';
	}

	public function get_title() {
		return esc_html__( 'Image Comparison', 'jet-widgets' );
	}

	public function get_icon() {
		return 'jetwidgets-icon-29';
	}

	public function get_categories() {
		return array( 'jet-widgets' );
	}

	public function get_script_depends() {
		return array(
			'jquery-slick',
			'jet-juxtapose',
		);
	}

	protected function _register_controls() {
		$css_scheme = apply_filters(
			'jet-widgets/image-comparison/css-scheme',
			array(
				'instance'         => '.jet-image-comparison__instance',
				'jx_instance'      => '.jx-slider',
				'before_container' => '.jx-left',
				'before_label'     => '.jx-left .jx-label',
				'after_container'  => '.jx-right',
				'after_label'      => '.jx-right .jx-label',
				'handle'           => '.jx-handle',
				'arrow'            => '.jet-arrow',
				'dots'             => '.jet-slick-dots',
			)
		);

		$this->start_controls_section(
			'section_settings',
			array(
				'label' => esc_html__( 'Settings', 'jet-widgets' ),
			)
		);

		$this->add_responsive_control(
			'slides_to_show',
			array(
				'label'   => esc_html__( 'Slides to Show', 'jet-widgets' ),
				'type'    => Controls_Manager::SELECT,
				'default' => '1',
				'options' => jet_widgets_tools()->get_select_range( 10 ),
			)
		);

		$this->add_control(
			'slides_to_scroll',
			array(
				'label'     => esc_html__( 'Slides to Scroll', 'jet-widgets' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '1',
				'options'   => jet_widgets_tools()->get_select_range( 10 ),
				'condition' => array(
					'slides_to_show!' => '1',
				),
			)
		);

		$this->add_control(
			'pause_on_hover',
			array(
				'label'        => esc_html__( 'Pause on Hover', 'jet-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'jet-widgets' ),
				'label_off'    => esc_html__( 'No', 'jet-widgets' ),
				'return_value' => 'true',
				'default'      => '',
			)
		);

		$this->add_control(
			'autoplay',
			array(
				'label'        => esc_html__( 'Autoplay', 'jet-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'jet-widgets' ),
				'label_off'    => esc_html__( 'No', 'jet-widgets' ),
				'return_value' => 'true',
				'default'      => 'true',
			)
		);

		$this->add_control(
			'autoplay_speed',
			array(
				'label'     => esc_html__( 'Autoplay Speed', 'jet-widgets' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 5000,
				'condition' => array(
					'autoplay' => 'true',
				),
			)
		);

		$this->add_control(
			'infinite',
			array(
				'label'        => esc_html__( 'Infinite Loop', 'elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'jet-widgets' ),
				'label_off'    => esc_html__( 'No', 'jet-widgets' ),
				'return_value' => 'true',
				'default'      => 'true',
			)
		);

		$this->add_control(
			'effect',
			array(
				'label'   => esc_html__( 'Effect', 'jet-widgets' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'slide',
				'options' => array(
					'slide' => esc_html__( 'Slide', 'jet-widgets' ),
					'fade'  => esc_html__( 'Fade', 'jet-widgets' ),
				),
				'condition' => array(
					'slides_to_show' => '1',
				),
			)
		);

		$this->add_control(
			'speed',
			array(
				'label'   => esc_html__( 'Animation Speed', 'jet-widgets' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 500,
			)
		);

		$this->add_control(
			'arrows',
			array(
				'label'        => esc_html__( 'Show Arrows Navigation', 'jet-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'jet-widgets' ),
				'label_off'    => esc_html__( 'No', 'jet-widgets' ),
				'return_value' => 'true',
				'default'      => 'false',
			)
		);

		$this->add_control(
			'prev_arrow',
			array(
				'label'   => esc_html__( 'Prev Arrow Icon', 'jet-widgets' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'fa fa-angle-left',
				'options' => jet_widgets_tools()->get_available_prev_arrows_list(),
				'condition' => array(
					'arrows' => 'true',
				),
			)
		);

		$this->add_control(
			'next_arrow',
			array(
				'label'   => esc_html__( 'Next Arrow Icon', 'jet-widgets' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'fa fa-angle-right',
				'options' => jet_widgets_tools()->get_available_next_arrows_list(),
				'condition' => array(
					'arrows' => 'true',
				),
			)
		);

		$this->add_control(
			'dots',
			array(
				'label'        => esc_html__( 'Show Dots Navigation', 'jet-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'jet-widgets' ),
				'label_off'    => esc_html__( 'No', 'jet-widgets' ),
				'return_value' => 'true',
				'default'      => 'true',
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_items_data',
			array(
				'label' => esc_html__( 'Items', 'jet-widgets' ),
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'item_before_label',
			array(
				'label'   => esc_html__( 'Before Label', 'jet-widgets' ),
				'type'    => Controls_Manager::TEXT,
			)
		);

		$repeater->add_control(
			'item_before_image',
			array(
				'label'   => esc_html__( 'Before Image', 'jet-widgets' ),
				'type'    => Controls_Manager::MEDIA,
			)
		);

		$repeater->add_control(
			'item_after_label',
			array(
				'label'   => esc_html__( 'After Label', 'jet-widgets' ),
				'type'    => Controls_Manager::TEXT,
			)
		);

		$repeater->add_control(
			'item_after_image',
			array(
				'label'   => esc_html__( 'After Image', 'jet-widgets' ),
				'type'    => Controls_Manager::MEDIA,
			)
		);

		$this->add_control(
			'item_list',
			array(
				'type'        => Controls_Manager::REPEATER,
				'fields'      => array_values( $repeater->get_controls() ),
				'default'     => array(
					array(
						'item_before_label' => esc_html__( 'Before', 'jet-widgets' ),
						'item_before_image' => array(
							'url' => Utils::get_placeholder_image_src(),
						),
						'item_after_label' => esc_html__( 'After', 'jet-widgets' ),
						'item_after_image' => array(
							'url' => Utils::get_placeholder_image_src(),
						),
					),
					array(
						'item_before_label' => esc_html__( 'Before', 'jet-widgets' ),
						'item_before_image' => array(
							'url' => Utils::get_placeholder_image_src(),
						),
						'item_after_label' => esc_html__( 'After', 'jet-widgets' ),
						'item_after_image' => array(
							'url' => Utils::get_placeholder_image_src(),
						),
					),
				),
				'title_field' => '{{{ item_before_label }}}',
			)
		);

		$this->end_controls_section();

		/**
		 * General Style Section
		 */
		$this->start_controls_section(
			'section_services_general_style',
			array(
				'label'      => esc_html__( 'General', 'jet-widgets' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'container_border',
				'label'       => esc_html__( 'Border', 'jet-widgets' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'  => '{{WRAPPER}} ' . $css_scheme['instance'],
			)
		);

		$this->add_responsive_control(
			'container_border_radius',
			array(
				'label'      => __( 'Border Radius', 'jet-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['instance'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'container_padding',
			array(
				'label'      => __( 'Padding', 'jet-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['instance'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name' => 'container_box_shadow',
				'exclude' => array(
					'box_shadow_position',
				),
				'selector' => '{{WRAPPER}} ' . $css_scheme['instance'],
			)
		);

		$this->end_controls_section();

		/**
		 * Label Style Section
		 */
		$this->start_controls_section(
			'section_image_comparison_label_style',
			array(
				'label'      => esc_html__( 'Label', 'jet-widgets' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->start_controls_tabs( 'tabs_label_styles' );

		$this->start_controls_tab(
			'tab_label_before',
			array(
				'label' => esc_html__( 'Before', 'jet-widgets' ),
			)
		);

		$this->add_control(
			'before_label_color',
			array(
				'label' => esc_html__( 'Color', 'jet-widgets' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['before_label'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'before_label_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}}  ' . $css_scheme['before_label'],
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'before_label_background',
				'selector' => '{{WRAPPER}} ' . $css_scheme['before_label'],
				'fields_options' => array(
					'color' => array(
						'scheme' => array(
							'type'  => Scheme_Color::get_type(),
							'value' => Scheme_Color::COLOR_2,
						),
					),
				),
			)
		);

		$this->add_responsive_control(
			'before_label_margin',
			array(
				'label'      => __( 'Margin', 'jet-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['before_label'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'before_label_padding',
			array(
				'label'      => __( 'Padding', 'jet-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['before_label'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'before_label_horizontal_alignment',
			array(
				'label'   => esc_html__( 'Horizontal Alignment', 'jet-widgets' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'flex-start',
				'options' => array(
					'flex-start'    => esc_html__( 'Left', 'jet-widgets' ),
					'center'        => esc_html__( 'Center', 'jet-widgets' ),
					'flex-end'      => esc_html__( 'Right', 'jet-widgets' ),
				),
				'selectors'  => array(
					'{{WRAPPER}} '. $css_scheme['before_container'] => 'justify-content: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'before_label_vertical_alignment',
			array(
				'label'   => esc_html__( 'Vertical Alignment', 'jet-widgets' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'flex-start',
				'options' => array(
					'flex-start'    => esc_html__( 'Top', 'jet-widgets' ),
					'center'        => esc_html__( 'Center', 'jet-widgets' ),
					'flex-end'      => esc_html__( 'Bottom', 'jet-widgets' ),
				),
				'selectors'  => array(
					'{{WRAPPER}} '. $css_scheme['before_container'] => 'align-items: {{VALUE}};',
				),
			)
		);


		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_label_after',
			array(
				'label' => esc_html__( 'After', 'jet-widgets' ),
			)
		);

		$this->add_control(
			'after_label_color',
			array(
				'label' => esc_html__( 'Color', 'jet-widgets' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['after_label'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'after_label_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}}  ' . $css_scheme['after_label'],
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'after_label_background',
				'selector' => '{{WRAPPER}} ' . $css_scheme['after_label'],
				'fields_options' => array(
					'color' => array(
						'scheme' => array(
							'type'  => Scheme_Color::get_type(),
							'value' => Scheme_Color::COLOR_2,
						),
					),
				),
			)
		);

		$this->add_responsive_control(
			'after_label_margin',
			array(
				'label'      => __( 'Margin', 'jet-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['after_label'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'after_label_padding',
			array(
				'label'      => __( 'Padding', 'jet-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['after_label'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'after_label_horizontal_alignment',
			array(
				'label'   => esc_html__( 'Horizontal Alignment', 'jet-widgets' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'flex-end',
				'options' => array(
					'flex-start'    => esc_html__( 'Left', 'jet-widgets' ),
					'center'        => esc_html__( 'Center', 'jet-widgets' ),
					'flex-end'      => esc_html__( 'Right', 'jet-widgets' ),
				),
				'selectors'  => array(
					'{{WRAPPER}} '. $css_scheme['after_container'] => 'justify-content: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'after_label_vertical_alignment',
			array(
				'label'   => esc_html__( 'Vertical Alignment', 'jet-widgets' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'flex-start',
				'options' => array(
					'flex-start'    => esc_html__( 'Top', 'jet-widgets' ),
					'center'        => esc_html__( 'Center', 'jet-widgets' ),
					'flex-end'      => esc_html__( 'Bottom', 'jet-widgets' ),
				),
				'selectors'  => array(
					'{{WRAPPER}} '. $css_scheme['after_container'] => 'align-items: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/**
		 * Handle Style Section
		 */
		$this->start_controls_section(
			'section_image_comparison_handle_style',
			array(
				'label'      => esc_html__( 'Handle', 'jet-widgets' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_responsive_control(
			'handle_control_width',
			array(
				'label'      => esc_html__( 'Control Width', 'jet-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 20,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['handle']                     => 'width: {{SIZE}}{{UNIT}}; margin-left: calc( {{SIZE}}{{UNIT}} / -2 );',
					'{{WRAPPER}} ' . $css_scheme['handle'] . ' .jx-control'    => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} ' . $css_scheme['handle'] . ' .jx-controller' => 'width: {{SIZE}}{{UNIT}};',
				)
			)
		);

		$this->add_responsive_control(
			'handle_control_height',
			array(
				'label'      => esc_html__( 'Height', 'jet-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 20,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['handle'] . ' .jx-controller' => 'height: {{SIZE}}{{UNIT}};',
				)
			)
		);

		$this->start_controls_tabs( 'tabs_handle_styles' );

		$this->start_controls_tab(
			'tab_handle_normal',
			array(
				'label' => esc_html__( 'Normal', 'jet-widgets' ),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'handle_control_background',
				'selector' => '{{WRAPPER}} ' . $css_scheme['jx_instance'] . ' .jx-controller',
				'fields_options' => array(
					'color' => array(
						'scheme' => array(
							'type'  => Scheme_Color::get_type(),
							'value' => Scheme_Color::COLOR_1,
						),
					),
				),
			)
		);

		$this->add_control(
			'handle_arrow_color',
			array(
				'label' => esc_html__( 'Arrow Color', 'jet-widgets' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['jx_instance'] . ' .jx-controller i' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name' => 'handle_control_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['jx_instance'] . ' .jx-controller',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_handle_hover',
			array(
				'label' => esc_html__( 'Hover', 'jet-widgets' ),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'handle_control_background_hover',
				'selector' => '{{WRAPPER}} ' . $css_scheme['jx_instance'] . ':hover .jx-controller',
				'fields_options' => array(
					'color' => array(
						'scheme' => array(
							'type'  => Scheme_Color::get_type(),
							'value' => Scheme_Color::COLOR_2,
						),
					),
				),
			)
		);

		$this->add_control(
			'handle_arrow_color_hover',
			array(
				'label' => esc_html__( 'Arrow Color', 'jet-widgets' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['jx_instance'] . ':hover .jx-controller i' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name' => 'handle_control_box_shadow_hover',
				'selector' => '{{WRAPPER}} ' . $css_scheme['jx_instance'] . ':hover .jx-controller',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'handle_divider_margin',
			array(
				'label'      => __( 'Margin', 'jet-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['handle'] . ' .jx-controller' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'handle_divider_radius',
			array(
				'label'      => __( 'Border Radius', 'jet-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['handle'] . ' .jx-controller' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'handle_control_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'jet-widgets' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'label_block' => false,
				'options' => array(
					'flex-start' => array(
						'title' => esc_html__( 'Top', 'jet-widgets' ),
						'icon'  => 'eicon-v-align-top',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'jet-widgets' ),
						'icon'  => 'eicon-v-align-middle',
					),
					'flex-end' => array(
						'title' => esc_html__( 'Bottom', 'jet-widgets' ),
						'icon'  => 'eicon-v-align-bottom',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['jx_instance'] . ' .jx-controller' => 'align-self: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'heading_handle_divider_style',
			array(
				'label'     => esc_html__( 'Handle Divider', 'jet-widgets' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'handle_divider_width',
			array(
				'label'      => esc_html__( 'Divider Width', 'jet-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 1,
						'max' => 10,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['handle'] . ' .jx-control:before' => 'width: {{SIZE}}{{UNIT}}; margin-left: calc( {{SIZE}}{{UNIT}}/-2);',
				)
			)
		);

		$this->add_control(
			'handle_divider_color',
			array(
				'label'   => esc_html__( 'Divider Color', 'jet-widgets' ),
				'type'    => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['handle'] . ' .jx-control:before' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'starting_position',
			array(
				'label'      => esc_html__( 'Divider Starting Position', 'jet-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( '%' ),
				'range'      => array(
					'%' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default' => array(
					'unit' => '%',
					'size' => 50,
				),
				'render_type' => 'template',
			)
		);

		$this->add_control(
			'heading_handle_arrow_style',
			array(
				'label'     => esc_html__( 'Handle Arrow', 'jet-widgets' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'handle_prev_arrow',
			array(
				'label'       => esc_html__( 'Prev Arrow Icon', 'jet-widgets' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'fa fa-angle-left',
				'render_type' => 'template',
				'options'     => jet_widgets_tools()->get_available_prev_arrows_list(),
			)
		);

		$this->add_control(
			'handle_next_arrow',
			array(
				'label'       => esc_html__( 'Next Arrow Icon', 'jet-widgets' ),
				'type'        => Controls_Manager::SELECT,
				'default'     => 'fa fa-angle-right',
				'render_type' => 'template',
				'options'     => jet_widgets_tools()->get_available_next_arrows_list(),
			)
		);

		$this->add_responsive_control(
			'handle_arrow_size',
			array(
				'label'      => esc_html__( 'Icon Size', 'jet-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px', 'em'
				),
				'range'      => array(
					'px' => array(
						'min' => 1,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['jx_instance'] . ' .jx-controller i' => 'font-size: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'handle_arrow_margin',
			array(
				'label'      => __( 'Margin', 'jet-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['handle'] . ' .jx-controller i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		/*
		 * Arrows section
		 */
		$this->start_controls_section(
			'section_arrows_style',
			array(
				'label'      => esc_html__( 'Arrows', 'jet-widgets' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->start_controls_tabs( 'tabs_arrows_style' );

		$this->start_controls_tab(
			'tab_arrows_normal',
			array(
				'label' => esc_html__( 'Normal', 'jet-widgets' ),
			)
		);

		$this->add_group_control(
			\Jet_Widgets_Group_Control_Box_Style::get_type(),
			array(
				'name'           => 'arrows_style',
				'label'          => esc_html__( 'Arrows Style', 'jet-widgets' ),
				'selector'       => '{{WRAPPER}} ' . $css_scheme['arrow'],
				'fields_options' => array(
					'color' => array(
						'scheme' => array(
							'type'  => Scheme_Color::get_type(),
							'value' => Scheme_Color::COLOR_1,
						),
					),
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_arrows_hover',
			array(
				'label' => esc_html__( 'Hover', 'jet-widgets' ),
			)
		);

		$this->add_group_control(
			\Jet_Widgets_Group_Control_Box_Style::get_type(),
			array(
				'name'           => 'arrows_hover_style',
				'label'          => esc_html__( 'Arrows Style', 'jet-widgets' ),
				'selector'       => '{{WRAPPER}} ' . $css_scheme['arrow'] . ':hover',
				'fields_options' => array(
					'color' => array(
						'scheme' => array(
							'type'  => Scheme_Color::get_type(),
							'value' => Scheme_Color::COLOR_4,
						),
					),
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'prev_arrow_position',
			array(
				'label'     => esc_html__( 'Prev Arrow Position', 'jet-widgets' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'prev_vert_position',
			array(
				'label'   => esc_html__( 'Vertical Postition by', 'jet-widgets' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'top',
				'options' => array(
					'top'    => esc_html__( 'Top', 'jet-widgets' ),
					'bottom' => esc_html__( 'Bottom', 'jet-widgets' ),
				),
			)
		);

		$this->add_responsive_control(
			'prev_top_position',
			array(
				'label'      => esc_html__( 'Top Indent', 'jet-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => -400,
						'max' => 400,
					),
					'%' => array(
						'min' => -100,
						'max' => 100,
					),
					'em' => array(
						'min' => -50,
						'max' => 50,
					),
				),
				'condition' => array(
					'prev_vert_position' => 'top',
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['arrow'] . '.prev-arrow' => 'top: {{SIZE}}{{UNIT}}; bottom: auto;',
				),
			)
		);

		$this->add_responsive_control(
			'prev_bottom_position',
			array(
				'label'      => esc_html__( 'Bottom Indent', 'jet-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => -400,
						'max' => 400,
					),
					'%' => array(
						'min' => -100,
						'max' => 100,
					),
					'em' => array(
						'min' => -50,
						'max' => 50,
					),
				),
				'condition' => array(
					'prev_vert_position' => 'bottom',
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['arrow'] . '.prev-arrow' => 'bottom: {{SIZE}}{{UNIT}}; top: auto;',
				),
			)
		);

		$this->add_control(
			'prev_hor_position',
			array(
				'label'   => esc_html__( 'Horizontal Postition by', 'jet-widgets' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'left',
				'options' => array(
					'left'  => esc_html__( 'Left', 'jet-widgets' ),
					'right' => esc_html__( 'Right', 'jet-widgets' ),
				),
			)
		);

		$this->add_responsive_control(
			'prev_left_position',
			array(
				'label'      => esc_html__( 'Left Indent', 'jet-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => -400,
						'max' => 400,
					),
					'%' => array(
						'min' => -100,
						'max' => 100,
					),
					'em' => array(
						'min' => -50,
						'max' => 50,
					),
				),
				'condition' => array(
					'prev_hor_position' => 'left',
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['arrow'] . '.prev-arrow' => 'left: {{SIZE}}{{UNIT}}; right: auto;',
				),
			)
		);

		$this->add_responsive_control(
			'prev_right_position',
			array(
				'label'      => esc_html__( 'Right Indent', 'jet-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => -400,
						'max' => 400,
					),
					'%' => array(
						'min' => -100,
						'max' => 100,
					),
					'em' => array(
						'min' => -50,
						'max' => 50,
					),
				),
				'condition' => array(
					'prev_hor_position' => 'right',
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['arrow'] . '.prev-arrow' => 'right: {{SIZE}}{{UNIT}}; left: auto;',
				),
			)
		);

		$this->add_control(
			'next_arrow_position',
			array(
				'label'     => esc_html__( 'Next Arrow Position', 'jet-widgets' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'next_vert_position',
			array(
				'label'   => esc_html__( 'Vertical Postition by', 'jet-widgets' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'top',
				'options' => array(
					'top'    => esc_html__( 'Top', 'jet-widgets' ),
					'bottom' => esc_html__( 'Bottom', 'jet-widgets' ),
				),
			)
		);

		$this->add_responsive_control(
			'next_top_position',
			array(
				'label'      => esc_html__( 'Top Indent', 'jet-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => -400,
						'max' => 400,
					),
					'%' => array(
						'min' => -100,
						'max' => 100,
					),
					'em' => array(
						'min' => -50,
						'max' => 50,
					),
				),
				'condition' => array(
					'next_vert_position' => 'top',
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['arrow'] . '.next-arrow' => 'top: {{SIZE}}{{UNIT}}; bottom: auto;',
				),
			)
		);

		$this->add_responsive_control(
			'next_bottom_position',
			array(
				'label'      => esc_html__( 'Bottom Indent', 'jet-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => -400,
						'max' => 400,
					),
					'%' => array(
						'min' => -100,
						'max' => 100,
					),
					'em' => array(
						'min' => -50,
						'max' => 50,
					),
				),
				'condition' => array(
					'next_vert_position' => 'bottom',
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['arrow'] . '.next-arrow' => 'bottom: {{SIZE}}{{UNIT}}; top: auto;',
				),
			)
		);

		$this->add_control(
			'next_hor_position',
			array(
				'label'   => esc_html__( 'Horizontal Postition by', 'jet-widgets' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'right',
				'options' => array(
					'left'  => esc_html__( 'Left', 'jet-widgets' ),
					'right' => esc_html__( 'Right', 'jet-widgets' ),
				),
			)
		);

		$this->add_responsive_control(
			'next_left_position',
			array(
				'label'      => esc_html__( 'Left Indent', 'jet-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => -400,
						'max' => 400,
					),
					'%' => array(
						'min' => -100,
						'max' => 100,
					),
					'em' => array(
						'min' => -50,
						'max' => 50,
					),
				),
				'condition' => array(
					'next_hor_position' => 'left',
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['arrow'] . '.next-arrow' => 'left: {{SIZE}}{{UNIT}}; right: auto;',
				),
			)
		);

		$this->add_responsive_control(
			'next_right_position',
			array(
				'label'      => esc_html__( 'Right Indent', 'jet-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => -400,
						'max' => 400,
					),
					'%' => array(
						'min' => -100,
						'max' => 100,
					),
					'em' => array(
						'min' => -50,
						'max' => 50,
					),
				),
				'condition' => array(
					'next_hor_position' => 'right',
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['arrow'] . '.next-arrow' => 'right: {{SIZE}}{{UNIT}}; left: auto;',
				),
			)
		);

		$this->end_controls_section();

		/*
		 * Dots section
		 */
		$this->start_controls_section(
			'section_dots_style',
			array(
				'label'      => esc_html__( 'Dots', 'jet-widgets' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->start_controls_tabs( 'tabs_dots_style' );

		$this->start_controls_tab(
			'tab_dots_normal',
			array(
				'label' => esc_html__( 'Normal', 'jet-widgets' ),
			)
		);

		$this->add_group_control(
			\Jet_Widgets_Group_Control_Box_Style::get_type(),
			array(
				'name'           => 'dots_style',
				'label'          => esc_html__( 'Dots Style', 'jet-widgets' ),
				'selector'       => '{{WRAPPER}} ' . $css_scheme['dots'] .' li span',
				'fields_options' => array(
					'color' => array(
						'scheme' => array(
							'type'  => Scheme_Color::get_type(),
							'value' => Scheme_Color::COLOR_3,
						),
					),
				),
				'exclude' => array(
					'box_font_color',
					'box_font_size',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_dots_hover',
			array(
				'label' => esc_html__( 'Hover', 'jet-widgets' ),
			)
		);

		$this->add_group_control(
			\Jet_Widgets_Group_Control_Box_Style::get_type(),
			array(
				'name'           => 'dots_style_hover',
				'label'          => esc_html__( 'Dots Style', 'jet-widgets' ),
				'selector'       => '{{WRAPPER}} ' . $css_scheme['dots'] . ' li span:hover',
				'fields_options' => array(
					'color' => array(
						'scheme' => array(
							'type'  => Scheme_Color::get_type(),
							'value' => Scheme_Color::COLOR_1,
						),
					),
				),
				'exclude' => array(
					'box_font_color',
					'box_font_size',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_dots_active',
			array(
				'label' => esc_html__( 'Active', 'jet-widgets' ),
			)
		);

		$this->add_group_control(
			\Jet_Widgets_Group_Control_Box_Style::get_type(),
			array(
				'name'           => 'dots_style_active',
				'label'          => esc_html__( 'Dots Style', 'jet-widgets' ),
				'selector'       => '{{WRAPPER}} ' . $css_scheme['dots'] .' li.slick-active span',
				'fields_options' => array(
					'color' => array(
						'scheme' => array(
							'type'  => Scheme_Color::get_type(),
							'value' => Scheme_Color::COLOR_4,
						),
					),
				),
				'exclude' => array(
					'box_font_color',
					'box_font_size',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'dots_gap',
			array(
				'label' => esc_html__( 'Gap', 'jet-widgets' ),
				'type' => Controls_Manager::SLIDER,
				'default' => array(
					'size' => 5,
					'unit' => 'px',
				),
				'range' => array(
					'px' => array(
						'min' => 0,
						'max' => 50,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['dots'] . ' li' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}}',
				),
				'separator' => 'before',
			)
		);

		$this->add_control(
			'dots_margin',
			array(
				'label'      => esc_html__( 'Dots Box Margin', 'jet-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['dots'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'dots_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'jet-widgets' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => array(
					'flex-start' => array(
						'title' => esc_html__( 'Left', 'jet-widgets' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'jet-widgets' ),
						'icon'  => 'fa fa-align-center',
					),
					'flex-end' => array(
						'title' => esc_html__( 'Right', 'jet-widgets' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['dots'] => 'justify-content: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

	}

	protected function render() {

		$this->__context = 'render';

		$this->__open_wrap();
		include $this->__get_global_template( 'index' );
		$this->__close_wrap();
	}

	/**
	 * Generate setting json
	 *
	 * @return string
	 */
	public function generate_setting_json() {
		$settings = $this->get_settings();

		$instance_settings = array(
			'slidesToShow'   => array(
				'desktop' => absint( $settings['slides_to_show'] ),
				'tablet'  => absint( $settings['slides_to_show_tablet'] ),
				'mobile'  => absint( $settings['slides_to_show_mobile'] ),
			),
			'autoplaySpeed'  => absint( $settings['autoplay_speed'] ),
			'autoplay'       => filter_var( $settings['autoplay'], FILTER_VALIDATE_BOOLEAN ),
			'infinite'       => filter_var( $settings['infinite'], FILTER_VALIDATE_BOOLEAN ),
			'pauseOnHover'   => filter_var( $settings['pause_on_hover'], FILTER_VALIDATE_BOOLEAN ),
			'speed'          => absint( $settings['speed'] ),
			'arrows'         => filter_var( $settings['arrows'], FILTER_VALIDATE_BOOLEAN ),
			'dots'           => filter_var( $settings['dots'], FILTER_VALIDATE_BOOLEAN ),
			'slidesToScroll' => absint( $settings['slides_to_scroll'] ),
			'prevArrow'      => jet_widgets_tools()->get_carousel_arrow(
				array( $settings['prev_arrow'], 'prev-arrow' )
			),
			'nextArrow'      => jet_widgets_tools()->get_carousel_arrow(
				array( $settings['next_arrow'], 'next-arrow' )
			),
		);

		if ( 'fade' === $settings['effect'] ) {
			$instance_settings['fade'] = true;
		}

		$instance_settings = json_encode( $instance_settings );

		return sprintf( 'data-settings=\'%1$s\'', $instance_settings );
	}
}
