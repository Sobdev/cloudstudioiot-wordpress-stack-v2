<?php
/**
 * Heading Widget
 *
 * @package CloudStudio\ElementorWidgets
 * @since 2.0.0
 */

namespace CloudStudio\ElementorWidgets\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

/**
 * Heading Widget Class
 */
class Heading_Widget extends Widget_Base {
	/**
	 * Get widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name(): string {
		return 'cloudstudio-heading';
	}

	/**
	 * Get widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title(): string {
		return esc_html__( 'Heading', 'cloudstudio-elementor-widgets' );
	}

	/**
	 * Get widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon(): string {
		return 'eicon-t-letter';
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
		return [ 'heading', 'title', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'cloudstudio' ];
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
			'title',
			[
				'label'       => esc_html__( 'Title', 'cloudstudio-elementor-widgets' ),
				'type'        => Controls_Manager::TEXTAREA,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => esc_html__( 'Enter your title', 'cloudstudio-elementor-widgets' ),
				'default'     => esc_html__( 'This is a heading', 'cloudstudio-elementor-widgets' ),
			]
		);

		$this->add_control(
			'html_tag',
			[
				'label'   => esc_html__( 'HTML Tag', 'cloudstudio-elementor-widgets' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'div'  => 'div',
					'span' => 'span',
					'p'    => 'p',
				],
				'default' => 'h2',
			]
		);

		$this->add_control(
			'link',
			[
				'label'       => esc_html__( 'Link', 'cloudstudio-elementor-widgets' ),
				'type'        => Controls_Manager::URL,
				'dynamic'     => [
					'active' => true,
				],
				'placeholder' => esc_html__( 'https://your-link.com', 'cloudstudio-elementor-widgets' ),
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
					'justify' => [
						'title' => esc_html__( 'Justified', 'cloudstudio-elementor-widgets' ),
						'icon'  => 'eicon-text-align-justify',
					],
				],
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .cloudstudio-heading' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// Style Section
		$this->start_controls_section(
			'section_style',
			[
				'label' => esc_html__( 'Style', 'cloudstudio-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'title_color',
			[
				'label'     => esc_html__( 'Text Color', 'cloudstudio-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .cloudstudio-heading__text' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name'     => 'typography',
				'selector' => '{{WRAPPER}} .cloudstudio-heading__text',
			]
		);

		$this->add_group_control(
			Group_Control_Text_Shadow::get_type(),
			[
				'name'     => 'text_shadow',
				'selector' => '{{WRAPPER}} .cloudstudio-heading__text',
			]
		);

		$this->add_control(
			'blend_mode',
			[
				'label'     => esc_html__( 'Blend Mode', 'cloudstudio-elementor-widgets' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => [
					''            => esc_html__( 'Normal', 'cloudstudio-elementor-widgets' ),
					'multiply'    => 'Multiply',
					'screen'      => 'Screen',
					'overlay'     => 'Overlay',
					'darken'      => 'Darken',
					'lighten'     => 'Lighten',
					'color-dodge' => 'Color Dodge',
					'color-burn'  => 'Color Burn',
					'hard-light'  => 'Hard Light',
					'soft-light'  => 'Soft Light',
					'difference'  => 'Difference',
					'exclusion'   => 'Exclusion',
					'hue'         => 'Hue',
					'saturation'  => 'Saturation',
					'color'       => 'Color',
					'luminosity'  => 'Luminosity',
				],
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .cloudstudio-heading__text' => 'mix-blend-mode: {{VALUE}};',
				],
				'separator' => 'before',
			]
		);

		$this->end_controls_section();

		// Decoration Section
		$this->start_controls_section(
			'section_decoration',
			[
				'label' => esc_html__( 'Decoration', 'cloudstudio-elementor-widgets' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'decoration_style',
			[
				'label'   => esc_html__( 'Style', 'cloudstudio-elementor-widgets' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					''          => esc_html__( 'None', 'cloudstudio-elementor-widgets' ),
					'underline' => esc_html__( 'Underline', 'cloudstudio-elementor-widgets' ),
					'overline'  => esc_html__( 'Overline', 'cloudstudio-elementor-widgets' ),
					'both'      => esc_html__( 'Both', 'cloudstudio-elementor-widgets' ),
				],
				'default' => '',
			]
		);

		$this->add_control(
			'decoration_color',
			[
				'label'     => esc_html__( 'Color', 'cloudstudio-elementor-widgets' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#0073aa',
				'selectors' => [
					'{{WRAPPER}} .cloudstudio-heading__decoration' => 'background-color: {{VALUE}};',
				],
				'condition' => [
					'decoration_style!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'decoration_width',
			[
				'label'      => esc_html__( 'Width', 'cloudstudio-elementor-widgets' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range'      => [
					'px' => [
						'min' => 0,
						'max' => 500,
					],
					'%'  => [
						'min' => 0,
						'max' => 100,
					],
				],
				'default'    => [
					'unit' => 'px',
					'size' => 60,
				],
				'selectors'  => [
					'{{WRAPPER}} .cloudstudio-heading__decoration' => 'width: {{SIZE}}{{UNIT}};',
				],
				'condition'  => [
					'decoration_style!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'decoration_height',
			[
				'label'     => esc_html__( 'Height', 'cloudstudio-elementor-widgets' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 1,
						'max' => 20,
					],
				],
				'default'   => [
					'size' => 3,
				],
				'selectors' => [
					'{{WRAPPER}} .cloudstudio-heading__decoration' => 'height: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'decoration_style!' => '',
				],
			]
		);

		$this->add_responsive_control(
			'decoration_spacing',
			[
				'label'     => esc_html__( 'Spacing', 'cloudstudio-elementor-widgets' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'default'   => [
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .cloudstudio-heading__decoration--overline' => 'margin-bottom: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .cloudstudio-heading__decoration--underline' => 'margin-top: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'decoration_style!' => '',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render widget output on the frontend.
	 */
	protected function render(): void {
		$settings = $this->get_settings_for_display();

		if ( empty( $settings['title'] ) ) {
			return;
		}

		$this->add_render_attribute( 'wrapper', 'class', 'cloudstudio-heading' );

		$html_tag = $settings['html_tag'];
		$title    = $settings['title'];

		$this->add_render_attribute( 'title', 'class', 'cloudstudio-heading__text' );
		$this->add_inline_editing_attributes( 'title' );

		$decoration_style = $settings['decoration_style'];
		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<?php if ( $decoration_style === 'overline' || $decoration_style === 'both' ) : ?>
				<div class="cloudstudio-heading__decoration cloudstudio-heading__decoration--overline"></div>
			<?php endif; ?>

			<?php
			$title_html = sprintf( '<%1$s %2$s>%3$s</%1$s>', $html_tag, $this->get_render_attribute_string( 'title' ), $title );

			if ( ! empty( $settings['link']['url'] ) ) {
				$this->add_link_attributes( 'link', $settings['link'] );
				$title_html = sprintf( '<a %1$s>%2$s</a>', $this->get_render_attribute_string( 'link' ), $title_html );
			}

			echo $title_html;
			?>

			<?php if ( $decoration_style === 'underline' || $decoration_style === 'both' ) : ?>
				<div class="cloudstudio-heading__decoration cloudstudio-heading__decoration--underline"></div>
			<?php endif; ?>
		</div>
		<?php
	}

	/**
	 * Render widget output in the editor.
	 */
	protected function content_template(): void {
		?>
		<#
		if ( settings.title ) {
			view.addRenderAttribute( 'wrapper', 'class', 'cloudstudio-heading' );
			view.addRenderAttribute( 'title', 'class', 'cloudstudio-heading__text' );
			view.addInlineEditingAttributes( 'title' );

			var decorationStyle = settings.decoration_style;
			#>
			<div {{{ view.getRenderAttributeString( 'wrapper' ) }}}>
				<# if ( decorationStyle === 'overline' || decorationStyle === 'both' ) { #>
					<div class="cloudstudio-heading__decoration cloudstudio-heading__decoration--overline"></div>
				<# } #>

				<{{ settings.html_tag }} {{{ view.getRenderAttributeString( 'title' ) }}}>
					{{{ settings.title }}}
				</{{ settings.html_tag }}>

				<# if ( decorationStyle === 'underline' || decorationStyle === 'both' ) { #>
					<div class="cloudstudio-heading__decoration cloudstudio-heading__decoration--underline"></div>
				<# } #>
			</div>
			<#
		}
		#>
		<?php
	}
}
