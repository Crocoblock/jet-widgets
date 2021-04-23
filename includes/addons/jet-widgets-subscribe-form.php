<?php
/**
 * Class: Jet_Widgets_Subscribe_Form
 * Name: Subscribe
 * Slug: jw-subscribe-form
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
use Elementor\Utils;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Jet_Widgets_Subscribe_Form extends Jet_Widgets_Base {

	/**
	 * Request config
	 *
	 * @var array
	 */
	public $config = array();

	public function get_name() {
		return 'jw-subscribe-form';
	}

	public function get_title() {
		return esc_html__( 'Subscribe', 'jetwidgets-for-elementor' );
	}

	public function get_icon() {
		return 'jetwidgets-icon-35';
	}

	public function get_categories() {
		return array( 'jet-widgets' );
	}

	protected function _register_controls() {

		$css_scheme = apply_filters(
			'jet-widgets/subscribe-form/css-scheme',
			array(
				'instance'    => '.jw-subscribe-form',
				'input'       => '.jw-subscribe-form__input',
				'submit'      => '.jw-subscribe-form__submit',
				'submit_icon' => '.jw-subscribe-form__submit-icon',
				'message'     => '.jw-subscribe-form__message',
			)
		);

		$this->start_controls_section(
			'section_instagram_settings',
			array(
				'label' => esc_html__( 'Settings', 'jetwidgets-for-elementor' ),
			)
		);

		$this->add_control(
			'submit_button_text',
			array(
				'label'       => esc_html__( 'Submit Text', 'jetwidgets-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter Submit Button Text', 'jetwidgets-for-elementor' ),
				'default'     => esc_html__( 'Subscribe', 'jetwidgets-for-elementor' ),
			)
		);

		$this->add_control(
			'submit_placeholder',
			array(
				'label'       => esc_html__( 'Input Placeholder', 'jetwidgets-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Enter Your Mail', 'jetwidgets-for-elementor' ),
			)
		);

		$this->add_control(
			'use_redirect_url',
			array(
				'label'        => esc_html__( 'Use Redirect Url?', 'jetwidgets-for-elementor' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'jetwidgets-for-elementor' ),
				'label_off'    => esc_html__( 'No', 'jetwidgets-for-elementor' ),
				'return_value' => 'yes',
				'default'      => 'false',
			)
		);

		$this->add_control(
			'redirect_url',
			array(
				'label'       => esc_html__( 'Redirect Url', 'jetwidgets-for-elementor' ),
				'type'        => Controls_Manager::TEXT,
				'placeholder' => esc_html__( 'Enter Redirect Url', 'jetwidgets-for-elementor' ),
				'default'     => '#',
				'condition'   => array(
					'use_redirect_url' => 'yes',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * General Style Section
		 */
		$this->start_controls_section(
			'section_general_style',
			array(
				'label'      => esc_html__( 'General', 'jetwidgets-for-elementor' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'layout',
			array(
				'label'   => esc_html__( 'Layout', 'jetwidgets-for-elementor' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'inline',
				'options' => array(
					'inline' => esc_html__( 'Inline', 'jetwidgets-for-elementor' ),
					'block'  => esc_html__( 'Block', 'jetwidgets-for-elementor' ),
				)
			)
		);

		$this->add_responsive_control(
			'container_width',
			array(
				'label'      => esc_html__( 'Width', 'jetwidgets-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px', 'em', '%',
				),
				'range'      => array(
					'px' => array(
						'min' => 100,
						'max' => 1000,
					),
					'%' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['instance'] => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'container_padding',
			array(
				'label'      => esc_html__( 'Padding', 'jetwidgets-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['instance'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'container_margin',
			array(
				'label'      => __( 'Margin', 'jetwidgets-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['instance'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'container_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'jetwidgets-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['instance'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_container_style' );

		$this->start_controls_tab(
			'tab_container',
			array(
				'label' => esc_html__( 'Normal', 'jetwidgets-for-elementor' ),
			)
		);

		$this->add_control(
			'container_bg_color',
			array(
				'label' => esc_html__( 'Background Color', 'jetwidgets-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['instance'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'container_border',
				'label'       => esc_html__( 'Border', 'jetwidgets-for-elementor' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['instance'],
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'container_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['instance'],
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_container_error',
			array(
				'label' => esc_html__( 'Error', 'jetwidgets-for-elementor' ),
			)
		);

		$this->add_control(
			'container_error_bg_color',
			array(
				'label' => esc_html__( 'Background Color', 'jetwidgets-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['instance'] . '.jw-subscribe-form--response-error' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'container_error_border',
				'label'       => esc_html__( 'Border', 'jetwidgets-for-elementor' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['instance'] . '.jw-subscribe-form--response-error',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'container_error_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['instance'] . '.jw-subscribe-form--response-error',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/**
		 * Input Style Section
		 */
		$this->start_controls_section(
			'section_input_style',
			array(
				'label'      => esc_html__( 'Input', 'jetwidgets-for-elementor' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_responsive_control(
			'input_width',
			array(
				'label'      => esc_html__( 'Width', 'jetwidgets-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px', 'em', '%',
				),
				'range'      => array(
					'px' => array(
						'min' => 100,
						'max' => 1000,
					),
					'%' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['input'] => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'input_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'jetwidgets-for-elementor' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => array(
					'flex-start' => array(
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
				'condition' => array(
					'layout' => 'block',
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['input']  => 'align-self: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'input_padding',
			array(
				'label'      => esc_html__( 'Padding', 'jetwidgets-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['input'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'input_margin',
			array(
				'label'      => __( 'Margin', 'jetwidgets-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['input'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'input_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'jetwidgets-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['input'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_input_style' );

		$this->start_controls_tab(
			'tab_input',
			array(
				'label' => esc_html__( 'Normal', 'jetwidgets-for-elementor' ),
			)
		);

		$this->add_control(
			'input_bg_color',
			array(
				'label' => esc_html__( 'Background Color', 'jetwidgets-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['input'] => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'input_color',
			array(
				'label'     => esc_html__( 'Text Color', 'jetwidgets-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['input'] => 'color: {{VALUE}}',
					'{{WRAPPER}} ' . $css_scheme['input'] . '::-webkit-input-placeholder' => 'color: {{VALUE}}',
					'{{WRAPPER}} ' . $css_scheme['input'] . '::-moz-input-placeholder' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'input_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} ' . $css_scheme['input'],
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'input_border',
				'label'       => esc_html__( 'Border', 'jetwidgets-for-elementor' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['input'],
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'input_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['input'],
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_input_focus',
			array(
				'label' => esc_html__( 'Focus', 'jetwidgets-for-elementor' ),
			)
		);

		$this->add_control(
			'input_focus_bg_color',
			array(
				'label' => esc_html__( 'Background Color', 'jetwidgets-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['input'] . ':focus' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'input_focus_color',
			array(
				'label'     => esc_html__( 'Text Color', 'jetwidgets-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['input'] . ':focus' => 'color: {{VALUE}}',
					'{{WRAPPER}} ' . $css_scheme['input'] . ':focus::-webkit-input-placeholder' => 'color: {{VALUE}}',
					'{{WRAPPER}} ' . $css_scheme['input'] . ':focus::-moz-input-placeholder' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'input_focus_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} ' . $css_scheme['input'] . ':focus',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'input_focus_border',
				'label'       => esc_html__( 'Border', 'jetwidgets-for-elementor' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['input'] . ':focus',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'input_focus_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['input'] . ':focus',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_input_error',
			array(
				'label' => esc_html__( 'Error', 'jetwidgets-for-elementor' ),
			)
		);

		$this->add_control(
			'input_error_bg_color',
			array(
				'label' => esc_html__( 'Background Color', 'jetwidgets-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['input'] . '.mail-invalid' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'input_error_color',
			array(
				'label'     => esc_html__( 'Text Color', 'jetwidgets-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['input'] . '.mail-invalid' => 'color: {{VALUE}}',
					'{{WRAPPER}} ' . $css_scheme['input'] . '.mail-invalid::-webkit-input-placeholder' => 'color: {{VALUE}}',
					'{{WRAPPER}} ' . $css_scheme['input'] . '.mail-invalid::-moz-input-placeholder' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'input_error_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} ' . $css_scheme['input'] . '.mail-invalid',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'input_error_border',
				'label'       => esc_html__( 'Border', 'jetwidgets-for-elementor' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} ' . $css_scheme['input'] . '.mail-invalid',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'input_error_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['input'] . '.mail-invalid',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/**
		 * Submit Button Style Section
		 */
		$this->start_controls_section(
			'section_submit_button_style',
			array(
				'label'      => esc_html__( 'Submit Button', 'jetwidgets-for-elementor' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
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
				'render_type'  => 'template',
			)
		);

		$this->_add_advanced_icon_control(
			'button_icon',
			array(
				'label'       => esc_html__( 'Icon', 'jetwidgets-for-elementor' ),
				'type'        => Controls_Manager::ICON,
				'label_block' => true,
				'file'        => '',
				'default'     => 'fa fa-send',
				'fa5_default' => array(
					'value'   => 'fas fa-paper-plane',
					'library' => 'fa-solid',
				),
				'condition' => array(
					'add_button_icon' => 'yes',
				),
				'render_type' => 'template',
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
					'{{WRAPPER}} ' . $css_scheme['submit_icon'] => 'font-size: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} ' . $css_scheme['submit_icon'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'button_icon_margin',
			array(
				'label'      => esc_html__( 'Icon Margin', 'jetwidgets-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'condition' => array(
					'add_button_icon' => 'yes',
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['submit_icon'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'button_width',
			array(
				'label'      => esc_html__( 'Width', 'jetwidgets-for-elementor' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array(
					'px', 'em', '%',
				),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 1000,
					),
					'%' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['submit'] => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'button_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'jetwidgets-for-elementor' ),
				'type'    => Controls_Manager::CHOOSE,
				'options' => array(
					'flex-start' => array(
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
				'condition' => array(
					'layout' => 'block',
				),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['submit']  => 'align-self: {{VALUE}};',
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

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'button_bg',
				'selector' => '{{WRAPPER}} ' . $css_scheme['submit'],
				'fields_options' => array(
					'background' => array(
						'default' => 'classic',
					),
					'color' => array(
						'label'  => _x( 'Background Color', 'Background Control', 'jetwidgets-for-elementor' ),
						'scheme' => array(
							'type'  => Scheme_Color::get_type(),
							'value' => Scheme_Color::COLOR_1,
						),
					),
					'color_b' => array(
						'label' => _x( 'Second Background Color', 'Background Control', 'jetwidgets-for-elementor' ),
					),
				),
				'exclude' => array(
					'image',
					'position',
					'attachment',
					'attachment_alert',
					'repeat',
					'size',
				),
			)
		);

		$this->add_control(
			'button_color',
			array(
				'label'     => esc_html__( 'Text Color', 'jetwidgets-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['submit'] => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'button_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}}  ' . $css_scheme['submit'],
			)
		);

		$this->add_responsive_control(
			'button_padding',
			array(
				'label'      => esc_html__( 'Padding', 'jetwidgets-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['submit'] => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} ' . $css_scheme['submit'] => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} ' . $css_scheme['submit'] => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'selector'    => '{{WRAPPER}} ' . $css_scheme['submit'],
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'button_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['submit'],
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			array(
				'label' => esc_html__( 'Hover', 'jetwidgets-for-elementor' ),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'button_hover_bg',
				'selector' => '{{WRAPPER}} ' . $css_scheme['submit'] . ':hover',
				'fields_options' => array(
					'background' => array(
						'default' => 'classic',
					),
					'color' => array(
						'label' => _x( 'Background Color', 'Background Control', 'jetwidgets-for-elementor' ),
					),
					'color_b' => array(
						'label' => _x( 'Second Background Color', 'Background Control', 'jetwidgets-for-elementor' ),
					),
				),
				'exclude' => array(
					'image',
					'position',
					'attachment',
					'attachment_alert',
					'repeat',
					'size',
				),
			)
		);

		$this->add_control(
			'button_hover_color',
			array(
				'label'     => esc_html__( 'Text Color', 'jetwidgets-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['submit'] . ':hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'button_icon_hover_color',
			array(
				'label'     => esc_html__( 'Icon Color', 'jetwidgets-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ' . $css_scheme['submit'] . ':hover ' . $css_scheme['submit_icon'] => 'color: {{VALUE}}',
				),
				'condition' => array(
					'add_button_icon' => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'button_hover_typography',
				'selector' => '{{WRAPPER}}  ' . $css_scheme['submit'] . ':hover',
			)
		);

		$this->add_responsive_control(
			'button_hover_padding',
			array(
				'label'      => esc_html__( 'Padding', 'jetwidgets-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ' . $css_scheme['submit'] . ':hover' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} ' . $css_scheme['submit'] . ':hover' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} ' . $css_scheme['submit'] . ':hover' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'selector'    => '{{WRAPPER}} ' . $css_scheme['submit'] . ':hover',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'button_hover_box_shadow',
				'selector' => '{{WRAPPER}} ' . $css_scheme['submit'] . ':hover',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		/**
		 * Message Style Section
		 */
		$this->start_controls_section(
			'section_message_style',
			array(
				'label'      => esc_html__( 'Message', 'jetwidgets-for-elementor' ),
				'tab'        => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			)
		);

		$this->add_control(
			'message_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'jetwidgets-for-elementor' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'center',
				'options' => array(
					'flex-start' => array(
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
					'{{WRAPPER}} ' . $css_scheme['message'] . ' .jw-subscribe-form__message-inner' => 'justify-content: {{VALUE}};',
				),
			)
		);

		$this->start_controls_tabs( 'tabs_message_style' );

		$this->start_controls_tab(
			'tab_message_success',
			array(
				'label' => esc_html__( 'Success', 'jetwidgets-for-elementor' ),
			)
		);

		$this->add_control(
			'message_success_bg_color',
			array(
				'label' => esc_html__( 'Background Color', 'jetwidgets-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .jw-subscribe-form--response-success ' . $css_scheme['message'] . ' span' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'message_success_color',
			array(
				'label'     => esc_html__( 'Text Color', 'jetwidgets-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .jw-subscribe-form--response-success ' . $css_scheme['message'] . ' span' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'message_success_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .jw-subscribe-form--response-success ' . $css_scheme['message'] . ' span',
			)
		);

		$this->add_responsive_control(
			'message_success_padding',
			array(
				'label'      => esc_html__( 'Padding', 'jetwidgets-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .jw-subscribe-form--response-success ' . $css_scheme['message'] . ' span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'message_success_margin',
			array(
				'label'      => __( 'Margin', 'jetwidgets-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .jw-subscribe-form--response-success ' . $css_scheme['message'] . ' span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'message_success_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'jetwidgets-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .jw-subscribe-form--response-success ' . $css_scheme['message'] . ' span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'message_success_border',
				'label'       => esc_html__( 'Border', 'jetwidgets-for-elementor' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .jw-subscribe-form--response-success ' . $css_scheme['message'] . ' span',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'message_success_box_shadow',
				'selector' => '{{WRAPPER}} .jw-subscribe-form--response-success ' . $css_scheme['message'] . ' span',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_message_error',
			array(
				'label' => esc_html__( 'Error', 'jetwidgets-for-elementor' ),
			)
		);

		$this->add_control(
			'message_error_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'jetwidgets-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .jw-subscribe-form--response-error ' . $css_scheme['message'] . ' span' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'message_error_color',
			array(
				'label'     => esc_html__( 'Text Color', 'jetwidgets-for-elementor' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .jw-subscribe-form--response-error ' . $css_scheme['message'] . ' span' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'message_error_typography',
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .jw-subscribe-form--response-error ' . $css_scheme['message'] . ' span',
			)
		);

		$this->add_responsive_control(
			'message_error_padding',
			array(
				'label'      => esc_html__( 'Padding', 'jetwidgets-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .jw-subscribe-form--response-error ' . $css_scheme['message'] . ' span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'message_error_margin',
			array(
				'label'      => __( 'Margin', 'jetwidgets-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .jw-subscribe-form--response-error ' . $css_scheme['message'] . ' span' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'message_error_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'jetwidgets-for-elementor' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .jw-subscribe-form--response-error ' . $css_scheme['message'] . ' span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'        => 'message_error_border',
				'label'       => esc_html__( 'Border', 'jetwidgets-for-elementor' ),
				'placeholder' => '1px',
				'default'     => '1px',
				'selector'    => '{{WRAPPER}} .jw-subscribe-form--response-error ' . $css_scheme['message'] . ' span',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'message_error_box_shadow',
				'selector' => '{{WRAPPER}} .jw-subscribe-form--response-error ' . $css_scheme['message'] . ' span',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	/**
	 * Generate setting json
	 *
	 * @return string
	 */
	public function generate_setting_json() {
		$module_settings = $this->get_settings();

		$settings = array(
			'redirect'     => filter_var( $module_settings['use_redirect_url'], FILTER_VALIDATE_BOOLEAN ),
			'redirect_url' => $module_settings['redirect_url'],
		);

		$settings = json_encode( $settings );

		return htmlspecialchars( $settings );
	}

	protected function render() {

		$this->__context = 'render';

		$this->__open_wrap();
		include $this->__get_global_template( 'index' );
		$this->__close_wrap();
	}

}
