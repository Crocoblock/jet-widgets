<?php
/**
 * Class: Jet_Widgets_Team_Member
 * Name: Team Memeber
 * Slug: jet-team-member
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

class Jet_Widgets_Team_Member extends Jet_Widgets_Base {

	public function get_name() {
		return 'jw-team-member';
	}

	public function get_title() {
		return esc_html__( 'Team Memeber', 'jet-widgets' );
	}

	public function get_icon() {
		return 'jetwidgets-icon-25';
	}

	public function get_categories() {
		return array( 'jet-widgets' );
	}

	protected function _register_controls() {
		$css_scheme = apply_filters(
			'jet-widgets/team-member/css-scheme',
			array(
				'instance'         => '.jet-team-member',
				'instance_inner'   => '.jet-team-member__inner',
				'image'            => '.jet-team-member__image',
				'cover'            => '.jet-team-member__cover',
				'figure'           => '.jet-team-member__figure',
				'content'          => '.jet-team-member__content',
				'name'             => '.jet-team-member__name',
				'position'         => '.jet-team-member__position',
				'desc'             => '.jet-team-member__desc',
				'socials'          => '.jet-team-member__socials',
				'socials_item'     => '.jet-team-member__socials-item',
				'socials_icon'     => '.jet-team-member__socials-icon',
				'socials_label'    => '.jet-team-member__socials-label',
				'button_container' => '.jet-team-member__button-container',
				'button'           => '.jet-team-member__button',
			)
		);

		$this->start_controls_section(
			'section_content',
			array(
				'label' => esc_html__( 'Content', 'jet-widgets' ),
			)
		);

		$this->add_control(
			'member_image',
			array(
				'label'   => esc_html__( 'Member Image', 'jet-widgets' ),
				'type'    => Controls_Manager::MEDIA,
				'default' => array(
					'url' => Utils::get_placeholder_image_src(),
				),
			)
		);

		$this->add_control(
			'member_first_name',
			array(
				'label'   => esc_html__( 'First Name', 'jet-widgets' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'John', 'jet-widgets' ),
			)
		);

		$this->add_control(
			'member_last_name',
			array(
				'label'   => esc_html__( 'Last Name', 'jet-widgets' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Borthwick', 'jet-widgets' ),
			)
		);

		$this->add_control(
			'member_name_html_tag',
			array(
				'label'   => esc_html__( 'Name HTML Tag', 'jet-widgets' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'h1'   => esc_html__( 'H1', 'jet-widgets' ),
					'h2'   => esc_html__( 'H2', 'jet-widgets' ),
					'h3'   => esc_html__( 'H3', 'jet-widgets' ),
					'h4'   => esc_html__( 'H4', 'jet-widgets' ),
					'h5'   => esc_html__( 'H5', 'jet-widgets' ),
					'h6'   => esc_html__( 'H6', 'jet-widgets' ),
					'div'  => esc_html__( 'div', 'jet-widgets' ),
					'span' => esc_html__( 'span', 'jet-widgets' ),
					'p'    => esc_html__( 'p', 'jet-widgets' ),
				),
				'default' => 'h3',
			)
		);

		$this->add_control(
			'member_position',
			array(
				'label'   => esc_html__( 'Position', 'jet-widgets' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'Position', 'jet-widgets' ),
			)
		);

		$this->add_control(
			'member_description',
			array(
				'label'   => esc_html__( 'Description', 'jet-widgets' ),
				'type'    => Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Team member personal information', 'jet-widgets' ),
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'social_icon',
			array(
				'label'       => esc_html__( 'Icon', 'jet-widgets' ),
				'type'        => Controls_Manager::ICON,
				'label_block' => true,
				'file'        => '',
				'default'     => '',
			)
		);

		$repeater->add_control(
			'social_label',
			array(
				'label' => esc_html__( 'Label', 'jet-widgets' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( 'Label', 'jet-widgets' ),
			)
		);

		$repeater->add_control(
			'social_link',
			array(
				'label' => esc_html__( 'Link', 'jet-widgets' ),
				'type' => Controls_Manager::TEXT,
				'default' => esc_html__( '#', 'jet-widgets' ),
			)
		);

		$repeater->add_control(
			'label_visible',
			array(
				'label'        => esc_html__( 'Label visible', 'jet-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'jet-widgets' ),
				'label_off'    => esc_html__( 'No', 'jet-widgets' ),
				'return_value' => 'yes',
				'default'      => 'false',
			)
		);

		$this->add_control(
			'social_list',
			array(
				'type'    => Controls_Manager::REPEATER,
				'fields'  => array_values( $repeater->get_controls() ),
				'default' => array(
					array(
						'social_icon'   => 'fa fa-facebook',
						'social_label'  => esc_html__( 'Facebook', 'jet-widgets' ),
						'social_link'   => '#',
						'label_visible' => 'false',
					),
					array(
						'social_icon'   => 'fa fa-google-plus',
						'social_label'  => esc_html__( 'google+', 'jet-widgets' ),
						'social_link'   => '#',
						'label_visible' => 'false',
					),
					array(
						'social_icon'   => 'fa fa-twitter',
						'social_label'  => esc_html__( 'Twitter', 'jet-widgets' ),
						'social_link'   => '#',
						'label_visible' => 'false',
					),
				),
				'title_field' => '{{{ social_label }}}',
			)
		);

		$this->add_control(
			'button_text',
			array(
				'label'   => esc_html__( 'Button Text', 'jet-widgets' ),
				'type'    => Controls_Manager::TEXT,
				'default' => esc_html__( 'More', 'jet-widgets' ),
			)
		);

		$this->add_control(
			'button_url',
			array(
				'label'       => esc_html__( 'Button Link', 'jet-widgets' ),
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
			'section_team_member_general_style',
			array(
				'label'      => esc_html__( 'General', 'jet-widgets' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'cover_like_hint',
			array(
				'label'        => esc_html__( 'Overlay like a hint', 'jet-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'jet-widgets' ),
				'label_off'    => esc_html__( 'No', 'jet-widgets' ),
				'return_value' => 'yes',
				'default'      => 'false',
			)
		);

		$this->add_responsive_control(
			'cover_height',
			array(
				'label'      => esc_html__( 'Overlay Height', 'jet-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px', 'em', '%',
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
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['cover'] => 'height: {{SIZE}}{{UNIT}};',
				),
				'condition' => array(
					'cover_like_hint' => 'yes',
				),
			)
		);

		$this->add_control(
			'use_hint_corner',
			array(
				'label'        => esc_html__( 'Use hint corner', 'jet-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'jet-widgets' ),
				'label_off'    => esc_html__( 'No', 'jet-widgets' ),
				'return_value' => 'yes',
				'default'      => 'false',
				'condition' => array(
					'cover_like_hint' => 'yes',
				),
			)
		);

		$this->add_control(
			'hint_corner_color',
			array(
				'label'   => esc_html__( 'Corner Color', 'jet-widgets' ),
				'type'    => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['cover'] . ':after' => 'border-color: {{VALUE}} transparent transparent transparent;',
				),
				'condition' => array(
					'cover_like_hint' => 'yes',
					'use_hint_corner' => 'yes',
				),
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
				'label'       => esc_html__( 'Border', 'jet-widgets' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'  => '{{WRAPPER}} ' . $css_scheme['instance_inner'],
			)
		);

		$this->add_responsive_control(
			'container_border_radius',
			array(
				'label'      => __( 'Border Radius', 'jet-widgets' ),
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
				'label'      => __( 'Padding', 'jet-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['instance_inner'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'container_margin',
			array(
				'label'      => __( 'Margin', 'jet-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['instance_inner'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
		 * Image Style Section
		 */
		$this->start_controls_section(
			'section_team_member_image_style',
			array(
				'label'      => esc_html__( 'Image', 'jet-widgets' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'custom_image_size',
			array(
				'label'        => esc_html__( 'Custom size', 'jet-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'jet-widgets' ),
				'label_off'    => esc_html__( 'No', 'jet-widgets' ),
				'return_value' => 'yes',
				'default'      => 'false',
			)
		);

		$this->add_responsive_control(
			'image_width',
			array(
				'label'      => esc_html__( 'Width', 'jet-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px', 'em', '%',
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
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['image'] => 'width: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} ' . $css_scheme['figure'] => 'width: {{SIZE}}{{UNIT}};',
				),
				'condition' => array(
					'custom_image_size' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'image_height',
			array(
				'label'      => esc_html__( 'Height', 'jet-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px', 'em', '%',
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
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['image'] => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} ' . $css_scheme['figure'] => 'height: {{SIZE}}{{UNIT}};',
				),
				'condition' => array(
					'custom_image_size' => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'image_border',
				'label'       => esc_html__( 'Border', 'jet-widgets' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'  => '{{WRAPPER}} ' . $css_scheme['image'],
			)
		);

		$this->add_responsive_control(
			'image_border_radius',
			array(
				'label'      => __( 'Border Radius', 'jet-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['image'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} ' . $css_scheme['figure'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'image_padding',
			array(
				'label'      => __( 'Padding', 'jet-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['image'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'image_margin',
			array(
				'label'      => __( 'Margin', 'jet-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['image'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name' => 'image_box_shadow',
				'exclude' => array(
					'box_shadow_position',
				),
				'selector' => '{{WRAPPER}} ' . $css_scheme['image'],
			)
		);

		$this->end_controls_section();

		/**
		 * Name Style Section
		 */
		$this->start_controls_section(
			'section_team_member_name_style',
			array(
				'label'      => esc_html__( 'Name', 'jet-widgets' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'name_cover_location',
			array(
				'label'        => esc_html__( 'Display in cover', 'jet-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'jet-widgets' ),
				'label_off'    => esc_html__( 'No', 'jet-widgets' ),
				'return_value' => 'yes',
				'default'      => 'false',
			)
		);

		$this->start_controls_tabs( 'tabs_name_style' );

		$this->start_controls_tab(
			'tab_first_name_style',
			array(
				'label' => esc_html__( 'First name', 'jet-widgets' ),
			)
		);

		$this->add_control(
			'first_name_color',
			array(
				'label'  => esc_html__( 'Color', 'jet-widgets' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['name'] . ' .jet-team-member__name-first' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'first_name_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} ' . $css_scheme['name'] . ' .jet-team-member__name-first',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_last_name_style',
			array(
				'label' => esc_html__( 'Last name', 'jet-widgets' ),
			)
		);

		$this->add_control(
			'last_name_color',
			array(
				'label'  => esc_html__( 'Color', 'jet-widgets' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['name'] . ' .jet-team-member__name-last' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'last_name_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} ' . $css_scheme['name'] . ' .jet-team-member__name-last',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'name_padding',
			array(
				'label'      => __( 'Padding', 'jet-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['name'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'separator' => 'before',
			)
		);

		$this->add_responsive_control(
			'name_margin',
			array(
				'label'      => __( 'Margin', 'jet-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['name'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'name_text_alignment',
			array(
				'label'   => esc_html__( 'Text Alignment', 'jet-widgets' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => array(
					'left'    => array(
						'title' => esc_html__( 'Left', 'jet-widgets' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'jet-widgets' ),
						'icon'  => 'fa fa-align-center',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'jet-widgets' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['name'] => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Position Style Section
		 */
		$this->start_controls_section(
			'section_team_member_position_style',
			array(
				'label'      => esc_html__( 'Position', 'jet-widgets' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'position_cover_location',
			array(
				'label'        => esc_html__( 'Display in cover', 'jet-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'jet-widgets' ),
				'label_off'    => esc_html__( 'No', 'jet-widgets' ),
				'return_value' => 'yes',
				'default'      => 'false',
			)
		);

		$this->add_control(
			'position_color',
			array(
				'label'  => esc_html__( 'Color', 'jet-widgets' ),
				'type'   => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['position'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'position_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} ' . $css_scheme['position'],
			)
		);

		$this->add_responsive_control(
			'position_padding',
			array(
				'label'      => __( 'Padding', 'jet-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['position'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'position_margin',
			array(
				'label'      => __( 'Margin', 'jet-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['position'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'position_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'jet-widgets' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => array(
					'flex-start'    => array(
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
					'{{WRAPPER}} ' . $css_scheme['position'] => 'align-self: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'position_text_alignment',
			array(
				'label'   => esc_html__( 'Text Alignment', 'jet-widgets' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => array(
					'left'    => array(
						'title' => esc_html__( 'Left', 'jet-widgets' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'jet-widgets' ),
						'icon'  => 'fa fa-align-center',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'jet-widgets' ),
						'icon'  => 'fa fa-align-right',
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['position'] => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Description Style Section
		 */
		$this->start_controls_section(
			'section_team_member_desc_style',
			array(
				'label'      => esc_html__( 'Description', 'jet-widgets' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'desc_cover_location',
			array(
				'label'        => esc_html__( 'Display in cover', 'jet-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'jet-widgets' ),
				'label_off'    => esc_html__( 'No', 'jet-widgets' ),
				'return_value' => 'yes',
				'default'      => 'false',
			)
		);

		$this->add_control(
			'desc_color',
			array(
				'label'  => esc_html__( 'Color', 'jet-widgets' ),
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
				'scheme'   => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} ' . $css_scheme['desc'],
			)
		);

		$this->add_responsive_control(
			'desc_padding',
			array(
				'label'      => __( 'Padding', 'jet-widgets' ),
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
				'label'      => __( 'Margin', 'jet-widgets' ),
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
				'label'   => esc_html__( 'Alignment', 'jet-widgets' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => array(
					'flex-start'    => array(
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
					'{{WRAPPER}} ' . $css_scheme['desc'] => 'align-self: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'desc_text_alignment',
			array(
				'label'   => esc_html__( 'Text Alignment', 'jet-widgets' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => array(
					'left'    => array(
						'title' => esc_html__( 'Left', 'jet-widgets' ),
						'icon'  => 'fa fa-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'jet-widgets' ),
						'icon'  => 'fa fa-align-center',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'jet-widgets' ),
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
		 * Social List Style Section
		 */
		$this->start_controls_section(
			'section_social_list_style',
			array(
				'label'      => esc_html__( 'Social', 'jet-widgets' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'social_list_cover_location',
			array(
				'label'        => esc_html__( 'Display in cover', 'jet-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'jet-widgets' ),
				'label_off'    => esc_html__( 'No', 'jet-widgets' ),
				'return_value' => 'yes',
				'default'      => 'false',
			)
		);

		$this->add_responsive_control(
			'social_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'jet-widgets' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => array(
					'flex-start'    => array(
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
					'{{WRAPPER}} ' . $css_scheme['socials'] => 'align-self: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'social_items_spacing',
			array(
				'label' => esc_html__( 'Items Spacing', 'jet-widgets' ),
				'type'  => Controls_Manager::SLIDER,
				'range' => array(
					'px' => array(
						'min' => 0,
						'max' => 50,
					),
				),
				'selectors' => array(
					'body:not(.rtl) {{WRAPPER}} ' . $css_scheme['socials_item'] . ':not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}};',
					'body.rtl {{WRAPPER}} ' . $css_scheme['socials_item'] . ':not(:last-child)' => 'margin-left: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'social_icon_heading',
			array(
				'label'     => esc_html__( 'Icon', 'jet-widgets' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->start_controls_tabs( 'tabs_social_icon_style' );

		$this->start_controls_tab(
			'tab_social_icon_normal',
			array(
				'label' => esc_html__( 'Normal', 'jet-widgets' ),
			)
		);

		$this->add_control(
			'social_icon_color',
			array(
				'label' => esc_html__( 'Icon Color', 'jet-widgets' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['socials_icon'] . ' i' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'social_icon_bg_color',
			array(
				'label' => esc_html__( 'Icon Background Color', 'jet-widgets' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['socials_icon'] . ' .inner' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'social_icon_font_size',
			array(
				'label'      => esc_html__( 'Icon Font Size', 'jet-widgets' ),
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
					'{{WRAPPER}} ' . $css_scheme['socials_icon'] . ' i' => 'font-size: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'social_icon_size',
			array(
				'label'      => esc_html__( 'Icon Box Size', 'jet-widgets' ),
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
					'{{WRAPPER}} ' . $css_scheme['socials_icon'] . ' .inner' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'social_icon_border',
				'label'       => esc_html__( 'Border', 'jet-widgets' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['socials_icon'] . ' .inner',
			)
		);

		$this->add_control(
			'social_icon_box_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'jet-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['socials_icon'] . ' .inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'social_icon_box_margin',
			array(
				'label'      => __( 'Margin', 'jet-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['socials_icon'] . ' .inner' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'social_icon_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['socials_icon'] . ' .inner',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_social_icon_hover',
			array(
				'label' => esc_html__( 'Hover', 'jet-widgets' ),
			)
		);

		$this->add_control(
			'social_icon_color_hover',
			array(
				'label' => esc_html__( 'Icon Color', 'jet-widgets' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['socials_icon'] . ':hover i' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'social_icon_bg_color_hover',
			array(
				'label' => esc_html__( 'Icon Background Color', 'jet-widgets' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['socials_icon'] . ':hover .inner' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'social_icon_font_size_hover',
			array(
				'label'      => esc_html__( 'Icon Font Size', 'jet-widgets' ),
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
					'{{WRAPPER}} ' . $css_scheme['socials_icon'] . ':hover i' => 'font-size: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'social_icon_size_hover',
			array(
				'label'      => esc_html__( 'Icon Box Size', 'jet-widgets' ),
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
					'{{WRAPPER}} ' . $css_scheme['socials_icon'] . ':hover .inner' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'social_icon_border_hover',
				'label'       => esc_html__( 'Border', 'jet-widgets' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['socials_icon'] . ':hover .inner',
			)
		);

		$this->add_control(
			'social_icon_box_border_radius_hover',
			array(
				'label'      => esc_html__( 'Border Radius', 'jet-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['socials_icon'] . ':hover .inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'social_icon_box_margin_hover',
			array(
				'label'      => __( 'Margin', 'jet-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['socials_icon'] . ':hover .inner' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'social_icon_box_shadow_hover',
				'selector' => '{{WRAPPER}} ' . $css_scheme['socials_icon'] . ':hover .inner',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'social_label_heading',
			array(
				'label'     => esc_html__( 'Label', 'jet-widgets' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'social_label_typography',
				'selector' => '{{WRAPPER}} ' . $css_scheme['socials_label'],
			)
		);

		$this->add_control(
			'social_label_color',
			array(
				'label' => esc_html__( 'Color', 'jet-widgets' ),
				'type'  => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['socials_label']  => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'social_label_hover_color',
			array(
				'label' => esc_html__( 'Hover Color', 'jet-widgets' ),
				'type'  => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['socials_item'] . ' a:hover ' . $css_scheme['socials_label']  => 'color: {{VALUE}};',
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
				'label'      => esc_html__( 'Action Button', 'jet-widgets' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'button_cover_location',
			array(
				'label'        => esc_html__( 'Display in cover', 'jet-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'jet-widgets' ),
				'label_off'    => esc_html__( 'No', 'jet-widgets' ),
				'return_value' => 'yes',
				'default'      => 'false',
			)
		);

		$this->add_responsive_control(
			'button_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'jet-widgets' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => array(
					'flex-start'    => array(
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
					'{{WRAPPER}} ' . $css_scheme['button_container'] => 'justify-content: {{VALUE}};',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			array(
				'label' => esc_html__( 'Normal', 'jet-widgets' ),
			)
		);

		$this->add_control(
			'button_bg_color',
			array(
				'label' => esc_html__( 'Background Color', 'jet-widgets' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => array(
					'type'  => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				),
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'button_color',
			array(
				'label'     => esc_html__( 'Text Color', 'jet-widgets' ),
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
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}}  ' . $css_scheme['button'],
			)
		);

		$this->add_responsive_control(
			'button_padding',
			array(
				'label'      => esc_html__( 'Padding', 'jet-widgets' ),
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
				'label'      => __( 'Margin', 'jet-widgets' ),
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
				'label'      => esc_html__( 'Border Radius', 'jet-widgets' ),
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
				'label'       => esc_html__( 'Border', 'jet-widgets' ),
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
				'label' => esc_html__( 'Hover', 'jet-widgets' ),
			)
		);

		$this->add_control(
			'primary_button_hover_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'jet-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] . ':hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'button_hover_color',
			array(
				'label'     => esc_html__( 'Text Color', 'jet-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['button'] . ':hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'button_hover_typography',
				'selector' => '{{WRAPPER}}  ' . $css_scheme['button'] . ':hover',
			)
		);

		$this->add_responsive_control(
			'button_hover_padding',
			array(
				'label'      => esc_html__( 'Padding', 'jet-widgets' ),
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
				'label'      => __( 'Margin', 'jet-widgets' ),
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
				'label'      => esc_html__( 'Border Radius', 'jet-widgets' ),
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
				'label'       => esc_html__( 'Border', 'jet-widgets' ),
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
			'section_team_member_overlay_style',
			array(
				'label'      => esc_html__( 'Overlay', 'jet-widgets' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'show_on_hover',
			array(
				'label'        => esc_html__( 'Show on hover', 'jet-widgets' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'jet-widgets' ),
				'label_off'    => esc_html__( 'No', 'jet-widgets' ),
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
				'label'      => __( 'Padding', 'jet-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['cover'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'overlay_margin',
			array(
				'label'      => __( 'Margin', 'jet-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['cover'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; width: calc( 100% - {{LEFT}}{{UNIT}} - {{RIGHT}}{{UNIT}} );',
					'{{WRAPPER}} ' . $css_scheme['instance'] . ':not(.jet-team-member--cover-hint) ' . $css_scheme['cover'] => 'height: calc( 100% - {{TOP}}{{UNIT}} - {{BOTTOM}}{{UNIT}} );',
				),
			)
		);

		$this->add_responsive_control(
			'overlay_border_radius',
			array(
				'label'      => __( 'Border Radius', 'jet-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['cover'] . ':before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'label'      => esc_html__( 'Content Order and Alignment', 'jet-widgets' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'name_order',
			array(
				'label'   => esc_html__( 'Name Order', 'jet-widgets' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 1,
				'min'     => 1,
				'max'     => 5,
				'step'    => 1,
				'selectors' => array(
					'{{WRAPPER}} '. $css_scheme['name'] => 'order: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'position_order',
			array(
				'label'   => esc_html__( 'Position Order', 'jet-widgets' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 2,
				'min'     => 1,
				'max'     => 5,
				'step'    => 1,
				'selectors' => array(
					'{{WRAPPER}} '. $css_scheme['position'] => 'order: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'desc_order',
			array(
				'label'   => esc_html__( 'Description Order', 'jet-widgets' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 3,
				'min'     => 1,
				'max'     => 5,
				'step'    => 1,
				'selectors' => array(
					'{{WRAPPER}} '. $css_scheme['desc'] => 'order: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'social_order',
			array(
				'label'   => esc_html__( 'Social Order', 'jet-widgets' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 4,
				'min'     => 1,
				'max'     => 5,
				'step'    => 1,
				'selectors' => array(
					'{{WRAPPER}} '. $css_scheme['socials'] => 'order: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'button_order',
			array(
				'label'   => esc_html__( 'Button Order', 'jet-widgets' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 5,
				'min'     => 1,
				'max'     => 5,
				'step'    => 1,
				'selectors' => array(
					'{{WRAPPER}} '. $css_scheme['button_container'] => 'order: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'cover_alignment',
			array(
				'label'   => esc_html__( 'Cover Content Vertical Alignment', 'jet-widgets' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'center',
				'options' => array(
					'flex-start'    => esc_html__( 'Top', 'jet-widgets' ),
					'center'        => esc_html__( 'Center', 'jet-widgets' ),
					'flex-end'      => esc_html__( 'Bottom', 'jet-widgets' ),
				),
				'selectors'  => array(
					'{{WRAPPER}} '. $css_scheme['cover']  => 'justify-content: {{VALUE}};',
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

	public function __get_member_image() {

		$image = $this->get_settings( 'member_image' );

		if ( empty( $image['id'] ) && empty( $image['url'] ) ) {
			return;
		}

		$format = apply_filters( 'jet-widgets/team-member/image-format', '<figure class="jet-team-member__figure"><img class="jet-team-member__img-tag" src="%s" alt=""></figure>' );

		return sprintf( $format, $image['url'] );

	}

	public function __generate_name( $cover_location = false ) {
		$first_name = $this->get_settings( 'member_first_name' );
		$last_name  = $this->get_settings( 'member_last_name' );
		$is_cover   = filter_var( $this->get_settings( 'name_cover_location' ), FILTER_VALIDATE_BOOLEAN );

		$first_name_html = '';
		$last_name_html = '';

		if ( ( $cover_location && ! $is_cover ) || ( ! $cover_location && $is_cover ) ) {
			return;
		}

		if ( empty( $first_name ) && empty( $last_name ) ) {
			return;
		}

		if ( ! empty( $first_name ) ) {
			$first_name_html = sprintf( '<span class="jet-team-member__name-first">%s</span>', $first_name );
		}

		if ( ! empty( $last_name ) ) {

			$last_name_html = sprintf( '<span class="jet-team-member__name-last"> %s</span>', $last_name );
		}

		$name_tag = $this->get_settings( 'member_name_html_tag' );

		$format = apply_filters( 'jet-widgets/team-member/name-format', '<%3$s class="jet-team-member__name">%1$s%2$s</%3$s>' );

		return sprintf( $format, $first_name_html, $last_name_html, $name_tag );

	}

	public function __generate_position( $cover_location = false ) {
		$position = $this->get_settings( 'member_position' );
		$is_cover = filter_var( $this->get_settings( 'position_cover_location' ), FILTER_VALIDATE_BOOLEAN );

		if ( ( $cover_location && ! $is_cover ) || ( ! $cover_location && $is_cover ) ) {
			return;
		}

		if ( empty( $position ) ) {
			return false;
		}

		$format = apply_filters( 'jet-widgets/team-member/position-format', '<div class="jet-team-member__position"><span>%1$s</span></div>' );

		return sprintf( $format, $position );
	}

	public function __generate_description( $cover_location = false ) {
		$desc = $this->get_settings( 'member_description' );
		$is_cover = filter_var( $this->get_settings( 'desc_cover_location' ), FILTER_VALIDATE_BOOLEAN );

		if ( ( $cover_location && ! $is_cover ) || ( ! $cover_location && $is_cover ) ) {
			return;
		}

		if ( empty( $desc ) ) {
			return false;
		}

		$format = apply_filters( 'jet-widgets/team-member/description-format', '<p class="jet-team-member__desc">%s</p>' );

		return sprintf( $format, $desc );
	}

	public function __generate_action_button( $cover_location = false ) {
		$button_url = $this->get_settings( 'button_url' );
		$button_text = $this->get_settings( 'button_text' );
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

		$this->add_render_attribute( 'url', 'class', array(
			'elementor-button',
			'elementor-size-md',
			'jet-team-member__button',
		) );

		if ( is_array( $button_url ) ) {
			$this->add_render_attribute( 'url', 'href', $button_url['url'] );

			if ( $button_url['is_external'] ) {
				$this->add_render_attribute( 'url', 'target', '_blank' );
			}

			if ( ! empty( $button_url['nofollow'] ) ) {
				$this->add_render_attribute( 'url', 'rel', 'nofollow' );
			}
		} else {
			$this->add_render_attribute( 'url', 'href', $button_url );
		}

		$format = apply_filters( 'jet-widgets/team-member/description-format', '<div class="jet-team-member__button-container"><a %1$s>%2$s</a></div>' );

		return sprintf( $format, $this->get_render_attribute_string( 'url' ), $button_text );
	}

	public function __generate_social_icon_list( $cover_location = false ) {
		$social_icon_list = $this->get_settings( 'social_list' );
		$is_cover = filter_var( $this->get_settings( 'social_list_cover_location' ), FILTER_VALIDATE_BOOLEAN );

		if ( ( $cover_location && ! $is_cover ) || ( ! $cover_location && $is_cover ) ) {
			return;
		}

		if ( empty( $social_icon_list ) ) {
			return false;
		}

		$icon_list = '';

		foreach ( $social_icon_list as $key => $icon_data ) {
			$label = '';
			$icon  = '';

			if ( ! empty( $icon_data[ 'social_link' ] ) ) {

				if ( ! empty( $icon_data[ 'social_icon' ] ) ) {
					$icon = sprintf( '<div class="jet-team-member__socials-icon"><div class="inner"><i class="%s"></i></div></div>', $icon_data[ 'social_icon' ] );
				}

				if ( filter_var( $icon_data['label_visible'], FILTER_VALIDATE_BOOLEAN ) ) {
					$label = sprintf( '<span class="jet-team-member__socials-label">%s</span>', $icon_data[ 'social_label' ] );
				}

				$icon_list .= sprintf( '<div class="jet-team-member__socials-item"><a href="%1$s">%2$s%3$s</a></div>', $icon_data[ 'social_link' ], $icon, $label );
			}
		}

		$format = apply_filters( 'jet-widgets/team-member/social-list-format', '<div class="jet-team-member__socials">%1$s</div>' );

		return sprintf( $format, $icon_list );
	}

}
