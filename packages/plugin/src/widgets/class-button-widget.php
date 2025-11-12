<?php
/**
 * Button Widget
 *
 * @package CloudStudio\ElementorWidgets
 * @since 2.0.0
 */

namespace CloudStudio\ElementorWidgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

/**
 * Button Widget Class
 */
class Button_Widget extends Widget_Base {
	/**
	 * Get widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name(): string {
		return 'cloudstudio-button';
	}

	/**
	 * Get widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title(): string {
		return esc_html__( 'Button', 'cloudstudio-elementor-widgets' );
	}

	/**
	 * Get widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon(): string {
		return 'eicon-button';
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
		return [ 'button', 'cta', 'link', 'cloudstudio' ];
	}

	/**
	 * Register widget controls.
	 */
	protected function register_controls(): void {
		// Content Section.
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'cloudstudio-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'button_text',
			[
				'label'       => esc_html__( 'Text', 'cloudstudio-elementor-widgets' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Click Here', 'cloudstudio-elementor-widgets' ),
				'placeholder' => esc_html__( 'Enter button text', 'cloudstudio-elementor-widgets' ),
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'button_link',
			[
				'label'       => esc_html__( 'Link', 'cloudstudio-elementor-widgets' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'cloudstudio-elementor-widgets' ),
				'default'     => [
					'url'         => '#',
					'is_external' => false,
					'nofollow'    => false,
				],
				'dynamic'     => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'button_icon',
			[
				'label'       => esc_html__( 'Icon', 'cloudstudio-elementor-widgets' ),
				'type'        => Controls_Manager::ICONS,
				'label_block' => true,
			]
		);

		$this->add_control(
			'icon_position',
			[
				'label'     => esc_html__( 'Icon Position', 'cloudstudio-elementor-widgets' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'right',
				'options'   => [
					'left'  => esc_html__( 'Left', 'cloudstudio-elementor-widgets' ),
					'right' => esc_html__( 'Right', 'cloudstudio-elementor-widgets' ),
				],
				'condition' => [
					'button_icon[value]!' => '',
				],
			]
		);

		$this->end_controls_section();

		// Style Section.
		$this->start_controls_section(
			'style_section',
			[
				'label' => esc_html__( 'Button Style', 'cloudstudio-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'selector' => '{{WRAPPER}} .cloudstudio-button',
			]
		);

		$this->start_controls_tabs( 'button_style_tabs' );

		// Normal State.
		$this->start_controls_tab(
			'button_normal',
			[
				'label' => esc_html__( 'Normal', 'cloudstudio-elementor-widgets' ),
			]
		);

		$this->add_control(
			'button_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'cloudstudio-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .cloudstudio-button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'cloudstudio-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0073aa',
				'selectors' => [
					'{{WRAPPER}} .cloudstudio-button' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Hover State.
		$this->start_controls_tab(
			'button_hover',
			[
				'label' => esc_html__( 'Hover', 'cloudstudio-elementor-widgets' ),
			]
		);

		$this->add_control(
			'button_hover_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'cloudstudio-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .cloudstudio-button:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_background_color',
			[
				'label'     => esc_html__( 'Background Color', 'cloudstudio-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#005a87',
				'selectors' => [
					'{{WRAPPER}} .cloudstudio-button:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_responsive_control(
			'button_padding',
			[
				'label'      => esc_html__( 'Padding', 'cloudstudio-elementor-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'default'    => [
					'top'    => 12,
					'right'  => 24,
					'bottom' => 12,
					'left'   => 24,
					'unit'   => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .cloudstudio-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'before',
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'button_border',
				'selector' => '{{WRAPPER}} .cloudstudio-button',
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'cloudstudio-elementor-widgets' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'default'    => [
					'top'    => 4,
					'right'  => 4,
					'bottom' => 4,
					'left'   => 4,
					'unit'   => 'px',
				],
				'selectors'  => [
					'{{WRAPPER}} .cloudstudio-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'button_box_shadow',
				'selector' => '{{WRAPPER}} .cloudstudio-button',
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render widget output on the frontend.
	 */
	protected function render(): void {
		$settings = $this->get_settings_for_display();

		$this->add_render_attribute(
			'button',
			[
				'class' => [ 'cloudstudio-button', 'elementor-button' ],
				'role'  => 'button',
			]
		);

		if ( ! empty( $settings['button_link']['url'] ) ) {
			$this->add_link_attributes( 'button', $settings['button_link'] );
		}

		?>
		<div class="cloudstudio-button-wrapper">
			<a <?php echo $this->get_render_attribute_string( 'button' ); ?>>
				<?php if ( ! empty( $settings['button_icon']['value'] ) && 'left' === $settings['icon_position'] ) : ?>
					<?php \Elementor\Icons_Manager::render_icon( $settings['button_icon'], [ 'aria-hidden' => 'true' ] ); ?>
				<?php endif; ?>
				
				<span class="cloudstudio-button-text">
					<?php echo esc_html( $settings['button_text'] ); ?>
				</span>
				
				<?php if ( ! empty( $settings['button_icon']['value'] ) && 'right' === $settings['icon_position'] ) : ?>
					<?php \Elementor\Icons_Manager::render_icon( $settings['button_icon'], [ 'aria-hidden' => 'true' ] ); ?>
				<?php endif; ?>
			</a>
		</div>
		<?php
	}
}
