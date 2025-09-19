<?php
/**
 * Class: Jet_Widgets_Services
 * Name: Services
 * Slug: jw-services
 */

namespace Elementor;

use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Jet_Widgets_Services extends Jet_Widgets_Base {

	public function get_name() {
		return 'jw-services';
	}

	public function get_title() {
		return esc_html__( 'Services', 'jetwidgets-for-elementor' );
	}

	public function get_icon() {
		return 'jetwidgets-icon-26';
	}

	public function get_categories() {
		return array( 'jet-widgets' );
	}

	protected function register_controls() {
		$css_scheme = apply_filters(
			'jet-widgets/services/css-scheme',
			array(
				'instance'         => '.jw-services',
				'instance_inner'   => '.jw-services__inner',
				'header'           => '.jw-services__header',
				'cover'            => '.jw-services__cover',
				'figure'           => '.jw-services__figure',
				'content'          => '.jw-services__content',
				'icon'             => '.jw-services__icon',
				'title'            => '.jw-services__title',
				'title_icon'       => '.jw-services__title-icon',
				'title_text'       => '.jw-services__title-text',
				'desc'             => '.jw-services__desc',
				'button'           => '.jw-services__button',
				'button_icon'      => '.jw-services__button-icon',
				'button_text'      => '.jw-services__button-text',
			)
		);

		$this->start_controls_section(
			'section_content',
			array(
				'label' => esc_html__( 'Content', 'jetwidgets-for-elementor' ),
			)
		);

		$this->_add_advanced_icon_control(
			'services_icon',
			array(
				'label'       => esc_html__( 'Icon', 'jetwidgets-for-elementor' ),
				'type'        => Controls_Manager::ICON,
				'label_block' => true,
				'file'        => '',
				'default'     => 'fa fa-cogs',
				'fa5_default' => array(
					'value'   => 'fas fa-cogs',
					'library' => 'fa-solid',
				),
			)
		);

		$this->add_control(
			'services_title',
			array(
				'label'   => esc_html__( 'Title', 'jetwidgets-for-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Title', 'jetwidgets-for-elementor' ),
			)
		);

		$this->add_control(
			'services_title_size',
			array(
				'label'   => esc_html__( 'Title HTML Tag', 'jetwidgets-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'h1'   => esc_html__( 'H1', 'jetwidgets-for-elementor' ),
					'h2'   => esc_html__( 'H2', 'jetwidgets-for-elementor' ),
					'h3'   => esc_html__( 'H3', 'jetwidgets-for-elementor' ),
					'h4'   => esc_html__( 'H4', 'jetwidgets-for-elementor' ),
					'h5'   => esc_html__( 'H5', 'jetwidgets-for-elementor' ),
					'h6'   => esc_html__( 'H6', 'jetwidgets-for-elementor' ),
					'div'  => esc_html__( 'div', 'jetwidgets-for-elementor' ),
					'span' => esc_html__( 'span', 'jetwidgets-for-elementor' ),
					'p'    => esc_html__( 'p', 'jetwidgets-for-elementor' ),
				),
				'default' => 'h3',
			)
		);

		$this->add_control(
			'services_description',
			array(
				'label'   => esc_html__( 'Description', 'jetwidgets-for-elementor' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 'jetwidgets-for-elementor' ),
			)
		);

		$this->add_control(
			'button_text',
			array(
				'label'   => esc_html__( 'Button Text', 'jetwidgets-for-elementor' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'More', 'jetwidgets-for-elementor' ),
			)
		);

		$this->add_control(
			'button_url',
			array(
				'label'       => esc_html__( 'Button Link', 'jetwidgets-for-elementor' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => 'http://your-link.com',
				'default' => array(
					'url' => '',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * General Style Section
		 */
		$this->start_controls_section(
			'section_services_general_style',
			array(
				'label'      => esc_html__( 'General', 'jetwidgets-for-elementor' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'container_background',
				'selector' => '{{WRAPPER}} ' . $css_scheme['instance_inner'],
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'container_border',
				'label'       => esc_html__( 'Border', 'jetwidgets-for-elementor' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'  => '{{WRAPPER}} ' . $css_scheme['instance_inner'],
			)
		);

		$this->add_responsive_control(
			'container_border_radius',
			array(
				'label'      => __( 'Border Radius', 'jetwidgets-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['instance_inner'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'container_padding',
			array(
				'label'      => __( 'Padding', 'jetwidgets-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['instance_inner'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'selector' => '{{WRAPPER}} ' . $css_scheme['instance_inner'],
			)
		);

		$this->end_controls_section();

		/**
		 * Header Style Section
		 */
		$this->start_controls_section(
			'section_services_header_style',
			array(
				'label'      => esc_html__( 'Header', 'jetwidgets-for-elementor' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'header_position',
			array(
				'label'   => esc_html__( 'Header Postition', 'jetwidgets-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'top',
				'options' => array(
					'left'  => esc_html__( 'Left', 'jetwidgets-for-elementor' ),
					'top'   => esc_html__( 'Top', 'jetwidgets-for-elementor' ),
					'right' => esc_html__( 'Right', 'jetwidgets-for-elementor' ),
				),
			)
		);

		$this->add_responsive_control(
			'header_width',
			array(
				'label'      => esc_html__( 'Width', 'jetwidgets-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px', '%',
				),
				'range'      => array(
					'px' => array(
						'min' => 10,
						'max' => 1000,
					),
					'%' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default' => array(
					'size' => 80,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['header'] => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'header_height',
			array(
				'label'      => esc_html__( 'Height', 'jetwidgets-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px', '%',
				),
				'range'      => array(
					'px' => array(
						'min' => 50,
						'max' => 800,
					),
					'%' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default' => array(
					'size' => 80,
					'unit' => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['header'] => 'height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'header_background',
				'selector' => '{{WRAPPER}} ' . $css_scheme['header'],
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'header_border',
				'label'       => esc_html__( 'Border', 'jetwidgets-for-elementor' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'  => '{{WRAPPER}} ' . $css_scheme['header'],
			)
		);

		$this->add_responsive_control(
			'header_border_radius',
			array(
				'label'      => __( 'Border Radius', 'jetwidgets-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['header'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} ' . $css_scheme['figure'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'header_margin',
			array(
				'label'      => __( 'Margin', 'jetwidgets-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['header'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name' => 'header_box_shadow',
				'exclude' => array(
					'box_shadow_position',
				),
				'selector' => '{{WRAPPER}} ' . $css_scheme['header'],
			)
		);

		$this->end_controls_section();

		/**
		 * Icon Style Section
		 */
		$this->start_controls_section(
			'section_services_icon_style',
			array(
				'label'      => esc_html__( 'Icon', 'jetwidgets-for-elementor' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'icon_cover_location',
			array(
				'label'        => esc_html__( 'Display in header', 'jetwidgets-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'jetwidgets-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'jetwidgets-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'icon_color',
			array(
				'label' => esc_html__( 'Icon Color', 'jetwidgets-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['icon'] . ' .jet-widgets-icon' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'icon_bg_color',
			array(
				'label' => esc_html__( 'Icon Background Color', 'jetwidgets-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['icon'] . ' .inner' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'icon_font_size',
			array(
				'label'      => esc_html__( 'Icon Font Size', 'jetwidgets-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px', 'em', 'rem',
				),
				'range'      => array(
					'px' => array(
						'min' => 18,
						'max' => 200,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['icon'] . ' .jet-widgets-icon' => 'font-size: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'icon_size',
			array(
				'label'      => esc_html__( 'Icon Box Size', 'jetwidgets-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px', 'em', '%',
				),
				'range'      => array(
					'px' => array(
						'min' => 18,
						'max' => 200,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['icon'] . ' .inner' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'icon_border',
				'label'       => esc_html__( 'Border', 'jetwidgets-for-elementor' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['icon'] . ' .inner',
			)
		);

		$this->add_control(
			'icon_box_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'jetwidgets-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['icon'] . ' .inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'icon_box_margin',
			array(
				'label'      => __( 'Margin', 'jetwidgets-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['icon'] . ' .inner' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'icon_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['icon'] . ' .inner',
			)
		);

		$this->add_responsive_control(
			'icon_box_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'jetwidgets-for-elementor' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => array(
					'flex-start'    => array(
						'title' => esc_html__( 'Left', 'jetwidgets-for-elementor' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'jetwidgets-for-elementor' ),
						'icon'  => 'fa fa-align-center',
					),
					'flex-end' => array(
						'title' => esc_html__( 'Right', 'jetwidgets-for-elementor' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['icon'] => 'align-self: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Title Style Section
		 */
		$this->start_controls_section(
			'section_services_title_style',
			array(
				'label'      => esc_html__( 'Title', 'jetwidgets-for-elementor' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'title_cover_location',
			array(
				'label'        => esc_html__( 'Display in header', 'jetwidgets-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'jetwidgets-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'jetwidgets-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'false',
			)
		);

		$this->add_control(
			'use_title_icon',
			array(
				'label'        => esc_html__( 'Use title icon?', 'jetwidgets-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'jetwidgets-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'jetwidgets-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'false',
			)
		);

		$this->_add_advanced_icon_control(
			'title_icon',
			array(
				'label'       => esc_html__( 'Title Icon', 'jetwidgets-for-elementor' ),
				'type'        => Controls_Manager::ICON,
				'label_block' => true,
				'file'        => '',
				'default'     => '',
				'fa5_default' => array(
					'value'   => '',
					'library' => 'fa-solid',
				),
				'condition'   => array(
					'use_title_icon' => 'yes',
				),
			)
		);

		$this->add_control(
			'title_icon_color',
			array(
				'label'     => esc_html__( 'Color', 'jetwidgets-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['title_icon'] => 'color: {{VALUE}}',
				),
				'condition' => array(
					'use_title_icon' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'title_icon_size',
			array(
				'label'      => esc_html__( 'Icon Font Size', 'jetwidgets-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px', 'em',
				),
				'range'      => array(
					'px' => array(
						'min' => 1,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['title_icon'] => 'font-size: {{SIZE}}{{UNIT}};',
				),
				'condition' => array(
					'use_title_icon' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'title_icon_margin',
			array(
				'label'      => __( 'Icon Margin', 'jetwidgets-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['title_icon'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'  => esc_html__( 'Color', 'jetwidgets-for-elementor' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['title_text'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} ' . $css_scheme['title_text'],
				'global' => array(
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				),
			)
		);

		$this->add_responsive_control(
			'title_padding',
			array(
				'label'      => __( 'Padding', 'jetwidgets-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['title'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'title_margin',
			array(
				'label'      => __( 'Margin', 'jetwidgets-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['title'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'title_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'jetwidgets-for-elementor' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => array(
					'flex-start'    => array(
						'title' => esc_html__( 'Left', 'jetwidgets-for-elementor' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'jetwidgets-for-elementor' ),
						'icon'  => 'fa fa-align-center',
					),
					'flex-end' => array(
						'title' => esc_html__( 'Right', 'jetwidgets-for-elementor' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['title'] => 'align-self: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'title_text_alignment',
			array(
				'label'   => esc_html__( 'Text Alignment', 'jetwidgets-for-elementor' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => array(
					'left'    => array(
						'title' => esc_html__( 'Left', 'jetwidgets-for-elementor' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'jetwidgets-for-elementor' ),
						'icon'  => 'fa fa-align-center',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'jetwidgets-for-elementor' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['title'] => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Description Style Section
		 */
		$this->start_controls_section(
			'section_services_desc_style',
			array(
				'label'      => esc_html__( 'Description', 'jetwidgets-for-elementor' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'desc_cover_location',
			array(
				'label'        => esc_html__( 'Display in header', 'jetwidgets-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'jetwidgets-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'jetwidgets-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'false',
			)
		);

		$this->add_control(
			'desc_color',
			array(
				'label'  => esc_html__( 'Color', 'jetwidgets-for-elementor' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['desc'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'desc_typography',
				'selector' => '{{WRAPPER}} ' . $css_scheme['desc'],
				'global' => array(
					'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
				),
			)
		);

		$this->add_responsive_control(
			'desc_padding',
			array(
				'label'      => __( 'Padding', 'jetwidgets-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['desc'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'desc_margin',
			array(
				'label'      => __( 'Margin', 'jetwidgets-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['desc'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'desc_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'jetwidgets-for-elementor' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => array(
					'flex-start'    => array(
						'title' => esc_html__( 'Left', 'jetwidgets-for-elementor' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'jetwidgets-for-elementor' ),
						'icon'  => 'fa fa-align-center',
					),
					'flex-end' => array(
						'title' => esc_html__( 'Right', 'jetwidgets-for-elementor' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['desc'] => 'align-self: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'desc_text_alignment',
			array(
				'label'   => esc_html__( 'Text Alignment', 'jetwidgets-for-elementor' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => array(
					'left'    => array(
						'title' => esc_html__( 'Left', 'jetwidgets-for-elementor' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'jetwidgets-for-elementor' ),
						'icon'  => 'fa fa-align-center',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'jetwidgets-for-elementor' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['desc'] => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Action Button Style Section
		 */
		$this->start_controls_section(
			'section_action_button_style',
			array(
				'label'      => esc_html__( 'Action Button', 'jetwidgets-for-elementor' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'button_cover_location',
			array(
				'label'        => esc_html__( 'Display in header', 'jetwidgets-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'jetwidgets-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'jetwidgets-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'false',
			)
		);

		$this->add_responsive_control(
			'button_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'jetwidgets-for-elementor' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => array(
					'flex-start'    => array(
						'title' => esc_html__( 'Left', 'jetwidgets-for-elementor' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'jetwidgets-for-elementor' ),
						'icon'  => 'fa fa-align-center',
					),
					'flex-end' => array(
						'title' => esc_html__( 'Right', 'jetwidgets-for-elementor' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['button'] => 'align-self: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'add_button_icon',
			array(
				'label'        => esc_html__( 'Add Icon', 'jetwidgets-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'jetwidgets-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'jetwidgets-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'false',
			)
		);

		$this->_add_advanced_icon_control(
			'button_icon',
			array(
				'label'       => esc_html__( 'Icon', 'jetwidgets-for-elementor' ),
				'type'        => Controls_Manager::ICON,
				'label_block' => true,
				'file'        => '',
				'default'     => 'fa fa-check',
				'fa5_default' => array(
					'value'   => 'fas fa-check',
					'library' => 'fa-solid',
				),
				'condition' => array(
					'add_button_icon' => 'yes',
				),
			)
		);

		$this->add_control(
			'button_icon_position',
			array(
				'label'   => esc_html__( 'Icon Position', 'jetwidgets-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'before'  => esc_html__( 'Before Text', 'jetwidgets-for-elementor' ),
					'after' => esc_html__( 'After Text', 'jetwidgets-for-elementor' ),
				),
				'default'     => 'after',
				'render_type' => 'template',
				'condition' => array(
					'add_button_icon' => 'yes',
				),
			)
		);

		$this->add_control(
			'button_icon_size',
			array(
				'label' => esc_html__( 'Icon Size', 'jetwidgets-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'range' => array(
					'px' => array(
						'min' => 7,
						'max' => 90,
					),
				),
				'condition' => array(
					'add_button_icon' => 'yes',
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button_icon'] => 'font-size: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'button_icon_color',
			array(
				'label'     => esc_html__( 'Icon Color', 'jetwidgets-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'add_button_icon' => 'yes',
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button_icon'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'button_icon_margin',
			array(
				'label'      => esc_html__( 'Icon Margin', 'jetwidgets-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['button_icon'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			array(
				'label' => esc_html__( 'Normal', 'jetwidgets-for-elementor' ),
			)
		);

		$this->add_control(
			'button_bg_color',
			array(
				'label' => esc_html__( 'Background Color', 'jetwidgets-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'global' => array(
					'default' => Global_Colors::COLOR_PRIMARY,
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'button_color',
			array(
				'label'     => esc_html__( 'Text Color', 'jetwidgets-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'button_typography',
				'selector' => '{{WRAPPER}}  ' . $css_scheme['button_text'],
				'global' => array(
					'default' => Global_Typography::TYPOGRAPHY_ACCENT,
				),
			)
		);

		$this->add_responsive_control(
			'button_padding',
			array(
				'label'      => esc_html__( 'Padding', 'jetwidgets-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['button'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'button_margin',
			array(
				'label'      => __( 'Margin', 'jetwidgets-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['button'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'button_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'jetwidgets-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['button'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'button_border',
				'label'       => esc_html__( 'Border', 'jetwidgets-for-elementor' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['button'],
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'button_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['button'],
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			array(
				'label' => esc_html__( 'Hover', 'jetwidgets-for-elementor' ),
			)
		);

		$this->add_control(
			'primary_button_hover_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'jetwidgets-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] . ':hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'button_hover_color',
			array(
				'label'     => esc_html__( 'Text Color', 'jetwidgets-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] . ':hover ' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'button_hover_typography',
				'selector' => '{{WRAPPER}}  ' . $css_scheme['button'] . ':hover ' . $css_scheme['button_text'],
			)
		);

		$this->add_responsive_control(
			'button_hover_padding',
			array(
				'label'      => esc_html__( 'Padding', 'jetwidgets-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['button'] . ':hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'button_hover_margin',
			array(
				'label'      => __( 'Margin', 'jetwidgets-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['button'] . ':hover' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'button_hover_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'jetwidgets-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['button'] . ':hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'button_hover_border',
				'label'       => esc_html__( 'Border', 'jetwidgets-for-elementor' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['button'] . ':hover',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'button_hover_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['button'] . ':hover',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/**
		 * Overlay Style Section
		 */
		$this->start_controls_section(
			'section_services_overlay_style',
			array(
				'label'      => esc_html__( 'Overlay', 'jetwidgets-for-elementor' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'show_on_hover',
			array(
				'label'        => esc_html__( 'Show on hover', 'jetwidgets-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'jetwidgets-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'jetwidgets-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'false',
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'overlay_background',
				'selector' => '{{WRAPPER}} ' . $css_scheme['cover'] . ':before',
			)
		);

		$this->add_responsive_control(
			'overlay_paddings',
			array(
				'label'      => __( 'Padding', 'jetwidgets-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['cover'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Order Style Section
		 */
		$this->start_controls_section(
			'section_order_style',
			array(
				'label'      => esc_html__( 'Content Order and Alignment', 'jetwidgets-for-elementor' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'icon_order',
			array(
				'label'   => esc_html__( 'Icon Order', 'jetwidgets-for-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 1,
				'min'     => 1,
				'max'     => 4,
				'step'    => 1,
				'selectors' => array(
					'{{WRAPPER}} '. $css_scheme['icon'] => 'order: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'title_order',
			array(
				'label'   => esc_html__( 'Title Order', 'jetwidgets-for-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 2,
				'min'     => 1,
				'max'     => 4,
				'step'    => 1,
				'selectors' => array(
					'{{WRAPPER}} '. $css_scheme['title'] => 'order: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'desc_order',
			array(
				'label'   => esc_html__( 'Description Order', 'jetwidgets-for-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 3,
				'min'     => 1,
				'max'     => 4,
				'step'    => 1,
				'selectors' => array(
					'{{WRAPPER}} '. $css_scheme['desc'] => 'order: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'button_order',
			array(
				'label'   => esc_html__( 'Button Order', 'jetwidgets-for-elementor' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 4,
				'min'     => 1,
				'max'     => 4,
				'step'    => 1,
				'selectors' => array(
					'{{WRAPPER}} '. $css_scheme['button'] => 'order: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'cover_alignment',
			array(
				'label'   => esc_html__( 'Cover Content Vertical Alignment', 'jetwidgets-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'center',
				'options' => array(
					'flex-start'    => esc_html__( 'Top', 'jetwidgets-for-elementor' ),
					'center'        => esc_html__( 'Center', 'jetwidgets-for-elementor' ),
					'flex-end'      => esc_html__( 'Bottom', 'jetwidgets-for-elementor' ),
					'space-between' => esc_html__( 'Space between', 'jetwidgets-for-elementor' ),
				),
				'selectors'  => array(
					'{{WRAPPER}} '. $css_scheme['cover'] => 'justify-content: {{VALUE}};',
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

	public function __generate_icon( $cover_location = false ) {
		$is_cover = filter_var( $this->get_settings( 'icon_cover_location' ), FILTER_VALIDATE_BOOLEAN );

		if ( ( $cover_location && ! $is_cover ) || ( ! $cover_location && $is_cover ) ) {
			return;
		}

		$format = apply_filters( 'jet-widgets/services/icon-format', '<div class="jw-services__icon"><div class="inner"><span class="jet-widgets-icon">%s</span></div></div>' );

		return $this->_get_icon( 'services_icon', $format );
	}

	public function __generate_title( $cover_location = false ) {
		$title = $this->get_settings( 'services_title' );

		$is_cover = filter_var( $this->get_settings( 'title_cover_location' ), FILTER_VALIDATE_BOOLEAN );

		$title_html = '';

		if ( ( $cover_location && ! $is_cover ) || ( ! $cover_location && $is_cover ) ) {
			return;
		}

		if ( empty( $title ) ) {
			return;
		}

		$icon_html = $this->_get_icon( 'title_icon', '<span class="jw-services__title-icon jet-widgets-icon">%s</span>' );

		if ( ! empty( $title ) ) {

			$title_html = sprintf( '<span class="jw-services__title-text">%s</span>', $title );
		}

		$title_tag = $this->get_settings( 'services_title_size' );
		$title_tag = jet_widgets_tools()->validate_html_tag( $title_tag );

		$format = apply_filters( 'jet-widgets/services/name-format', '<%3$s class="jw-services__title">%1$s%2$s</%3$s>' );

		return sprintf( $format, $icon_html, $title_html, $title_tag );

	}

	public function __generate_description( $cover_location = false ) {
		$desc = $this->get_settings( 'services_description' );
		$is_cover = filter_var( $this->get_settings( 'desc_cover_location' ), FILTER_VALIDATE_BOOLEAN );

		if ( ( $cover_location && ! $is_cover ) || ( ! $cover_location && $is_cover ) ) {
			return '';
		}

		if ( empty( $desc ) ) {
			return '';
		}

		$format = apply_filters( 'jet-widgets/services/description-format', '<p class="jw-services__desc">%s</p>' );

		return sprintf( $format, $desc );
	}

	public function __generate_action_button( $cover_location = false ) {
		$button_url    = $this->get_settings( 'button_url' );
		$button_text   = $this->get_settings( 'button_text' );
		$use_icon      = $this->get_settings( 'add_button_icon' );
		$icon_position = $this->get_settings( 'button_icon_position' );
		$icon_html     = '';

		$is_cover = filter_var( $this->get_settings( 'button_cover_location' ), FILTER_VALIDATE_BOOLEAN );

		if ( ( $cover_location && ! $is_cover ) || ( ! $cover_location && $is_cover ) ) {
			return;
		}

		if ( empty( $button_url ) ) {
			return false;
		}

		if ( is_array( $button_url ) && empty( $button_url['url'] ) ) {
			return false;
		}

		if ( filter_var( $use_icon, FILTER_VALIDATE_BOOLEAN ) ) {
			$icon_html = $this->_get_icon( 'button_icon', '<span class="jw-services__button-icon jet-widgets-icon">%s</span>' );
		}

		$this->add_render_attribute( 'url', 'class', array(
			'elementor-button',
			'elementor-size-md',
			'jw-services__button',
			'jw-services__button--icon-' . $icon_position,
		) );

		if ( is_array( $button_url ) ) {
			$this->add_render_attribute( 'url', 'href', esc_url( $button_url['url'] ) );

			if ( $button_url['is_external'] ) {
				$this->add_render_attribute( 'url', 'target', '_blank' );
			}

			if ( ! empty( $button_url['nofollow'] ) ) {
				$this->add_render_attribute( 'url', 'rel', 'nofollow' );
			}

		} else {
			$this->add_render_attribute( 'url', 'href', esc_url( $button_url ) );
		}

		$format = apply_filters( 'jet-widgets/services/action-button-format', '<a %1$s><span class="jw-services__button-text">%2$s</span>%3$s</a>' );

		return sprintf( $format, $this->get_render_attribute_string( 'url' ), $button_text, $icon_html );
	}

}
