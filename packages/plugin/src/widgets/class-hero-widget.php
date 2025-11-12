<?php
/**
 * Hero Widget
 *
 * @package CloudStudio\ElementorWidgets
 * @since 2.0.0
 */

namespace CloudStudio\ElementorWidgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Icons_Manager;

/**
 * Hero Widget Class
 */
class Hero_Widget extends Widget_Base {
	/**
	 * Get widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name(): string {
		return 'cloudstudio-hero';
	}

	/**
	 * Get widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title(): string {
		return esc_html__( 'Hero Section', 'cloudstudio-elementor-widgets' );
	}

	/**
	 * Get widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon(): string {
		return 'eicon-image-box';
	}

	/**
	 * Get widget categories.
	 *
	 * @return array Widget categories.
	 */
	public function get_categories(): array {
		return [ 'cloudstudio' ];
	}

	/**
	 * Get widget keywords.
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords(): array {
		return [ 'hero', 'banner', 'header', 'jumbotron', 'cloudstudio' ];
	}

	/**
	 * Register widget controls.
	 */
	protected function register_controls(): void {
		// Content Section
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Content', 'cloudstudio-elementor-widgets' ),
			]
		);

		$this->add_control(
			'badge_text',
			[
				'label'       => esc_html__( 'Badge Text', 'cloudstudio-elementor-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => '',
				'placeholder' => esc_html__( 'New', 'cloudstudio-elementor-widgets' ),
			]
		);

		$this->add_control(
			'title',
			[
				'label'       => esc_html__( 'Title', 'cloudstudio-elementor-widgets' ),
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => esc_html__( 'Enter your title', 'cloudstudio-elementor-widgets' ),
				'default'     => esc_html__( 'Welcome to Cloud Studio', 'cloudstudio-elementor-widgets' ),
			]
		);

		$this->add_control(
			'title_tag',
			[
				'label'   => esc_html__( 'Title HTML Tag', 'cloudstudio-elementor-widgets' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4',
					'h5' => 'H5',
					'h6' => 'H6',
				],
				'default' => 'h1',
			]
		);

		$this->add_control(
			'subtitle',
			[
				'label'       => esc_html__( 'Subtitle', 'cloudstudio-elementor-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Your IoT Platform', 'cloudstudio-elementor-widgets' ),
				'placeholder' => esc_html__( 'Enter your subtitle', 'cloudstudio-elementor-widgets' ),
			]
		);

		$this->add_control(
			'description',
			[
				'label'       => esc_html__( 'Description', 'cloudstudio-elementor-widgets' ),
				'type'        => Controls_Manager::TEXTAREA,
				'rows'        => 5,
				'default'     => esc_html__( 'Build powerful IoT solutions with our cutting-edge platform. Connect, monitor, and control your devices from anywhere.', 'cloudstudio-elementor-widgets' ),
				'placeholder' => esc_html__( 'Enter your description', 'cloudstudio-elementor-widgets' ),
			]
		);

		$this->add_responsive_control(
			'align',
			[
				'label'     => esc_html__( 'Alignment', 'cloudstudio-elementor-widgets' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => esc_html__( 'Left', 'cloudstudio-elementor-widgets' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'cloudstudio-elementor-widgets' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'cloudstudio-elementor-widgets' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default'   => 'center',
				'selectors' => [
					'{{WRAPPER}} .cloudstudio-hero__content' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// Buttons Section
		$this->start_controls_section(
			'section_buttons',
			[
				'label' => esc_html__( 'Buttons', 'cloudstudio-elementor-widgets' ),
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'button_text',
			[
				'label'       => esc_html__( 'Text', 'cloudstudio-elementor-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Get Started', 'cloudstudio-elementor-widgets' ),
				'placeholder' => esc_html__( 'Get Started', 'cloudstudio-elementor-widgets' ),
			]
		);

		$repeater->add_control(
			'button_link',
			[
				'label'       => esc_html__( 'Link', 'cloudstudio-elementor-widgets' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => esc_html__( 'https://your-link.com', 'cloudstudio-elementor-widgets' ),
				'default'     => [
					'url' => '#',
				],
			]
		);

		$repeater->add_control(
			'button_type',
			[
				'label'   => esc_html__( 'Type', 'cloudstudio-elementor-widgets' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'primary'   => esc_html__( 'Primary', 'cloudstudio-elementor-widgets' ),
					'secondary' => esc_html__( 'Secondary', 'cloudstudio-elementor-widgets' ),
					'outline'   => esc_html__( 'Outline', 'cloudstudio-elementor-widgets' ),
				],
				'default' => 'primary',
			]
		);

		$repeater->add_control(
			'button_icon',
			[
				'label' => esc_html__( 'Icon', 'cloudstudio-elementor-widgets' ),
				'type'  => Controls_Manager::ICONS,
			]
		);

		$repeater->add_control(
			'button_icon_position',
			[
				'label'   => esc_html__( 'Icon Position', 'cloudstudio-elementor-widgets' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'left'  => esc_html__( 'Left', 'cloudstudio-elementor-widgets' ),
					'right' => esc_html__( 'Right', 'cloudstudio-elementor-widgets' ),
				],
				'default' => 'right',
			]
		);

		$this->add_control(
			'buttons',
			[
				'label'       => esc_html__( 'Buttons', 'cloudstudio-elementor-widgets' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
					[
						'button_text' => esc_html__( 'Get Started', 'cloudstudio-elementor-widgets' ),
						'button_type' => 'primary',
					],
					[
						'button_text' => esc_html__( 'Learn More', 'cloudstudio-elementor-widgets' ),
						'button_type' => 'outline',
					],
				],
				'title_field' => '{{{ button_text }}}',
			]
		);

		$this->end_controls_section();

		// Background Section
		$this->start_controls_section(
			'section_background',
			[
				'label' => esc_html__( 'Background', 'cloudstudio-elementor-widgets' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'background',
				'types'    => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .cloudstudio-hero',
			]
		);

		$this->add_control(
			'background_overlay',
			[
				'label'     => esc_html__( 'Background Overlay', 'cloudstudio-elementor-widgets' ),
				'type'      => Controls_Manager::SWITCHER,
				'default'   => 'yes',
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'      => 'background_overlay_background',
				'types'     => [ 'classic', 'gradient' ],
				'selector'  => '{{WRAPPER}} .cloudstudio-hero__overlay',
				'condition' => [
					'background_overlay' => 'yes',
				],
			]
		);

		$this->add_control(
			'background_overlay_opacity',
			[
				'label'     => esc_html__( 'Opacity', 'cloudstudio-elementor-widgets' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min'  => 0,
						'max'  => 1,
						'step' => 0.01,
					],
				],
				'default'   => [
					'size' => 0.5,
				],
				'selectors' => [
					'{{WRAPPER}} .cloudstudio-hero__overlay' => 'opacity: {{SIZE}};',
				],
				'condition' => [
					'background_overlay' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		// Style - Container
		$this->start_controls_section(
			'section_style_container',
			[
				'label' => esc_html__( 'Container', 'cloudstudio-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'min_height',
			[
				'label'      => esc_html__( 'Min Height', 'cloudstudio-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'vh', 'em' ],
				'range'      => [
					'px' => [
						'min' => 100,
						'max' => 1000,
					],
					'vh' => [
						'min' => 10,
						'max' => 100,
					],
				],
				'default'    => [
					'unit' => 'vh',
					'size' => 70,
				],
				'selectors'  => [
					'{{WRAPPER}} .cloudstudio-hero' => 'min-height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'container_padding',
			[
				'label'      => esc_html__( 'Padding', 'cloudstudio-elementor-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'default'    => [
					'top'      => '80',
					'right'    => '20',
					'bottom'   => '80',
					'left'     => '20',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .cloudstudio-hero__inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Style - Badge
		$this->start_controls_section(
			'section_style_badge',
			[
				'label'     => esc_html__( 'Badge', 'cloudstudio-elementor-widgets' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'badge_text!' => '',
				],
			]
		);

		$this->add_control(
			'badge_color',
			[
				'label'     => esc_html__( 'Text Color', 'cloudstudio-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .cloudstudio-hero__badge' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'badge_background',
			[
				'label'     => esc_html__( 'Background Color', 'cloudstudio-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0073aa',
				'selectors' => [
					'{{WRAPPER}} .cloudstudio-hero__badge' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'badge_typography',
				'selector' => '{{WRAPPER}} .cloudstudio-hero__badge',
			]
		);

		$this->add_responsive_control(
			'badge_padding',
			[
				'label'      => esc_html__( 'Padding', 'cloudstudio-elementor-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'default'    => [
					'top'      => '5',
					'right'    => '15',
					'bottom'   => '5',
					'left'     => '15',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .cloudstudio-hero__badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'badge_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'cloudstudio-elementor-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'      => '20',
					'right'    => '20',
					'bottom'   => '20',
					'left'     => '20',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .cloudstudio-hero__badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'badge_spacing',
			[
				'label'     => esc_html__( 'Bottom Spacing', 'cloudstudio-elementor-widgets' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default'   => [
					'size' => 20,
				],
				'selectors' => [
					'{{WRAPPER}} .cloudstudio-hero__badge' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Style - Title
		$this->start_controls_section(
			'section_style_title',
			[
				'label' => esc_html__( 'Title', 'cloudstudio-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Text Color', 'cloudstudio-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .cloudstudio-hero__title' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .cloudstudio-hero__title',
			]
		);

		$this->add_responsive_control(
			'title_spacing',
			[
				'label'     => esc_html__( 'Bottom Spacing', 'cloudstudio-elementor-widgets' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default'   => [
					'size' => 20,
				],
				'selectors' => [
					'{{WRAPPER}} .cloudstudio-hero__title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Style - Subtitle
		$this->start_controls_section(
			'section_style_subtitle',
			[
				'label'     => esc_html__( 'Subtitle', 'cloudstudio-elementor-widgets' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'subtitle!' => '',
				],
			]
		);

		$this->add_control(
			'subtitle_color',
			[
				'label'     => esc_html__( 'Text Color', 'cloudstudio-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#e0e0e0',
				'selectors' => [
					'{{WRAPPER}} .cloudstudio-hero__subtitle' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'subtitle_typography',
				'selector' => '{{WRAPPER}} .cloudstudio-hero__subtitle',
			]
		);

		$this->add_responsive_control(
			'subtitle_spacing',
			[
				'label'     => esc_html__( 'Bottom Spacing', 'cloudstudio-elementor-widgets' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default'   => [
					'size' => 15,
				],
				'selectors' => [
					'{{WRAPPER}} .cloudstudio-hero__subtitle' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Style - Description
		$this->start_controls_section(
			'section_style_description',
			[
				'label'     => esc_html__( 'Description', 'cloudstudio-elementor-widgets' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => [
					'description!' => '',
				],
			]
		);

		$this->add_control(
			'description_color',
			[
				'label'     => esc_html__( 'Text Color', 'cloudstudio-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#e0e0e0',
				'selectors' => [
					'{{WRAPPER}} .cloudstudio-hero__description' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'description_typography',
				'selector' => '{{WRAPPER}} .cloudstudio-hero__description',
			]
		);

		$this->add_responsive_control(
			'description_max_width',
			[
				'label'      => esc_html__( 'Max Width', 'cloudstudio-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%', 'em' ],
				'range'      => [
					'px' => [
						'min' => 200,
						'max' => 1200,
					],
					'%'  => [
						'min' => 10,
						'max' => 100,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 700,
				],
				'selectors'  => [
					'{{WRAPPER}} .cloudstudio-hero__description' => 'max-width: {{SIZE}}{{UNIT}}; margin-left: auto; margin-right: auto;',
				],
			]
		);

		$this->add_responsive_control(
			'description_spacing',
			[
				'label'     => esc_html__( 'Bottom Spacing', 'cloudstudio-elementor-widgets' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default'   => [
					'size' => 30,
				],
				'selectors' => [
					'{{WRAPPER}} .cloudstudio-hero__description' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		// Style - Buttons
		$this->start_controls_section(
			'section_style_buttons',
			[
				'label' => esc_html__( 'Buttons', 'cloudstudio-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'buttons_gap',
			[
				'label'     => esc_html__( 'Gap Between Buttons', 'cloudstudio-elementor-widgets' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'default'   => [
					'size' => 15,
				],
				'selectors' => [
					'{{WRAPPER}} .cloudstudio-hero__buttons' => 'gap: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'selector' => '{{WRAPPER}} .cloudstudio-hero__button',
			]
		);

		$this->add_responsive_control(
			'button_padding',
			[
				'label'      => esc_html__( 'Padding', 'cloudstudio-elementor-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'default'    => [
					'top'      => '15',
					'right'    => '30',
					'bottom'   => '15',
					'left'     => '30',
					'unit'     => 'px',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .cloudstudio-hero__button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'cloudstudio-elementor-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'      => '5',
					'right'    => '5',
					'bottom'   => '5',
					'left'     => '5',
					'unit'     => 'px',
					'isLinked' => true,
				],
				'selectors'  => [
					'{{WRAPPER}} .cloudstudio-hero__button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->start_controls_tabs( 'button_style_tabs' );

		// Normal State
		$this->start_controls_tab(
			'button_style_normal',
			[
				'label' => esc_html__( 'Normal', 'cloudstudio-elementor-widgets' ),
			]
		);

		$this->add_control(
			'button_primary_color',
			[
				'label'     => esc_html__( 'Primary Text Color', 'cloudstudio-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .cloudstudio-hero__button--primary' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_primary_background',
			[
				'label'     => esc_html__( 'Primary Background', 'cloudstudio-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0073aa',
				'selectors' => [
					'{{WRAPPER}} .cloudstudio-hero__button--primary' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_secondary_color',
			[
				'label'     => esc_html__( 'Secondary Text Color', 'cloudstudio-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .cloudstudio-hero__button--secondary' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'button_secondary_background',
			[
				'label'     => esc_html__( 'Secondary Background', 'cloudstudio-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#555555',
				'selectors' => [
					'{{WRAPPER}} .cloudstudio-hero__button--secondary' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_outline_color',
			[
				'label'     => esc_html__( 'Outline Text Color', 'cloudstudio-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .cloudstudio-hero__button--outline' => 'color: {{VALUE}}; border-color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_tab();

		// Hover State
		$this->start_controls_tab(
			'button_style_hover',
			[
				'label' => esc_html__( 'Hover', 'cloudstudio-elementor-widgets' ),
			]
		);

		$this->add_control(
			'button_primary_color_hover',
			[
				'label'     => esc_html__( 'Primary Text Color', 'cloudstudio-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .cloudstudio-hero__button--primary:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_primary_background_hover',
			[
				'label'     => esc_html__( 'Primary Background', 'cloudstudio-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#005a87',
				'selectors' => [
					'{{WRAPPER}} .cloudstudio-hero__button--primary:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_secondary_color_hover',
			[
				'label'     => esc_html__( 'Secondary Text Color', 'cloudstudio-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .cloudstudio-hero__button--secondary:hover' => 'color: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->add_control(
			'button_secondary_background_hover',
			[
				'label'     => esc_html__( 'Secondary Background', 'cloudstudio-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#333333',
				'selectors' => [
					'{{WRAPPER}} .cloudstudio-hero__button--secondary:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_outline_color_hover',
			[
				'label'     => esc_html__( 'Outline Color', 'cloudstudio-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0073aa',
				'selectors' => [
					'{{WRAPPER}} .cloudstudio-hero__button--outline:hover' => 'color: {{VALUE}}; border-color: {{VALUE}}; background-color: transparent;',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	/**
	 * Render widget output on the frontend.
	 */
	protected function render(): void {
		$settings = $this->get_settings_for_display();
		?>
		<div class="cloudstudio-hero">
			<?php if ( $settings['background_overlay'] === 'yes' ) : ?>
				<div class="cloudstudio-hero__overlay"></div>
			<?php endif; ?>

			<div class="cloudstudio-hero__inner">
				<div class="cloudstudio-hero__content">
					<?php if ( ! empty( $settings['badge_text'] ) ) : ?>
						<div class="cloudstudio-hero__badge">
							<?php echo esc_html( $settings['badge_text'] ); ?>
						</div>
					<?php endif; ?>

					<?php if ( ! empty( $settings['title'] ) ) : ?>
						<<?php echo esc_attr( $settings['title_tag'] ); ?> class="cloudstudio-hero__title">
							<?php echo esc_html( $settings['title'] ); ?>
						</<?php echo esc_attr( $settings['title_tag'] ); ?>>
					<?php endif; ?>

					<?php if ( ! empty( $settings['subtitle'] ) ) : ?>
						<div class="cloudstudio-hero__subtitle">
							<?php echo esc_html( $settings['subtitle'] ); ?>
						</div>
					<?php endif; ?>

					<?php if ( ! empty( $settings['description'] ) ) : ?>
						<div class="cloudstudio-hero__description">
							<?php echo esc_html( $settings['description'] ); ?>
						</div>
					<?php endif; ?>

					<?php if ( ! empty( $settings['buttons'] ) ) : ?>
						<div class="cloudstudio-hero__buttons">
							<?php foreach ( $settings['buttons'] as $index => $button ) : ?>
								<?php
								$button_key = 'button_' . $index;
								$this->add_render_attribute(
									$button_key,
									[
										'class' => [
											'cloudstudio-hero__button',
											'cloudstudio-hero__button--' . $button['button_type'],
										],
									]
								);

								if ( ! empty( $button['button_link']['url'] ) ) {
									$this->add_link_attributes( $button_key, $button['button_link'] );
								}
								?>
								<a <?php echo $this->get_render_attribute_string( $button_key ); ?>>
									<?php if ( ! empty( $button['button_icon']['value'] ) && $button['button_icon_position'] === 'left' ) : ?>
										<span class="cloudstudio-hero__button-icon cloudstudio-hero__button-icon--left">
											<?php Icons_Manager::render_icon( $button['button_icon'], [ 'aria-hidden' => 'true' ] ); ?>
										</span>
									<?php endif; ?>

									<span class="cloudstudio-hero__button-text">
										<?php echo esc_html( $button['button_text'] ); ?>
									</span>

									<?php if ( ! empty( $button['button_icon']['value'] ) && $button['button_icon_position'] === 'right' ) : ?>
										<span class="cloudstudio-hero__button-icon cloudstudio-hero__button-icon--right">
											<?php Icons_Manager::render_icon( $button['button_icon'], [ 'aria-hidden' => 'true' ] ); ?>
										</span>
									<?php endif; ?>
								</a>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Render widget output in the editor.
	 */
	protected function content_template(): void {
		?>
		<#
		var buttonTypes = {
			'primary': 'cloudstudio-hero__button--primary',
			'secondary': 'cloudstudio-hero__button--secondary',
			'outline': 'cloudstudio-hero__button--outline'
		};
		#>
		<div class="cloudstudio-hero">
			<# if ( settings.background_overlay === 'yes' ) { #>
				<div class="cloudstudio-hero__overlay"></div>
			<# } #>

			<div class="cloudstudio-hero__inner">
				<div class="cloudstudio-hero__content">
					<# if ( settings.badge_text ) { #>
						<div class="cloudstudio-hero__badge">{{{ settings.badge_text }}}</div>
					<# } #>

					<# if ( settings.title ) { #>
						<{{ settings.title_tag }} class="cloudstudio-hero__title">
							{{{ settings.title }}}
						</{{ settings.title_tag }}>
					<# } #>

					<# if ( settings.subtitle ) { #>
						<div class="cloudstudio-hero__subtitle">{{{ settings.subtitle }}}</div>
					<# } #>

					<# if ( settings.description ) { #>
						<div class="cloudstudio-hero__description">{{{ settings.description }}}</div>
					<# } #>

					<# if ( settings.buttons.length ) { #>
						<div class="cloudstudio-hero__buttons">
							<# _.each( settings.buttons, function( button, index ) { #>
								<a href="{{ button.button_link.url }}" class="cloudstudio-hero__button {{ buttonTypes[button.button_type] }}">
									<# if ( button.button_icon.value && button.button_icon_position === 'left' ) { #>
										<span class="cloudstudio-hero__button-icon cloudstudio-hero__button-icon--left">
											<i class="{{ button.button_icon.value }}"></i>
										</span>
									<# } #>

									<span class="cloudstudio-hero__button-text">{{{ button.button_text }}}</span>

									<# if ( button.button_icon.value && button.button_icon_position === 'right' ) { #>
										<span class="cloudstudio-hero__button-icon cloudstudio-hero__button-icon--right">
											<i class="{{ button.button_icon.value }}"></i>
										</span>
									<# } #>
								</a>
							<# }); #>
						</div>
					<# } #>
				</div>
			</div>
		</div>
		<?php
	}
}
