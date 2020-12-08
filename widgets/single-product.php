<?php
namespace ElementorWcSPC\Widgets;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Scheme_Typography;
use Elementor\Utils;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * WooCommerce Single Product
 *
 * Elementor widget for wooCommerce Single Product.
 *
 * @since 1.0.0
 */
class Wc_E_Single_Product extends Widget_Base {


	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);

		wp_register_style( 'single-product', plugins_url( '../assets/css/single-product.css', __FILE__ ) );
	}

	/**
	 * Retrieve the widget name.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'wc-single-product';
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Single Product', 'wc-elementor-spc' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-single-product';
	}

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'general' ];
	}

	/**
	 * Retrieve the list of scripts the widget depended on.
	 *
	 * Used to set scripts dependencies required to run the widget.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 *
	 * @return array Widget scripts dependencies.
	 */
	public function get_script_depends() {
		return [ 'wc-elementor-spc' ];
	}

    /**
     * Overriding default function to add custom html class.
     *
     * @return string
     */
    public function get_html_wrapper_class() {
        $html_class = parent::get_html_wrapper_class();
        $html_class .= ' ' . $this->get_name();
        return rtrim( $html_class );
	}

	public function get_style_depends() {
		return [ 'single-product' ];
	}

	/**
	 * Register the widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function _register_controls() {
		$this->start_controls_section(
			'section_product',
			[
                'label' => __( 'Product & Product Image', 'wc-elementor-spc' ),
                'tab' => Controls_Manager::TAB_CONTENT,
			]
        );

        $this->add_control(
			'image',
			[
				'label' => __( 'Image', 'wc-elementor-spc' ),
				'type' => Controls_Manager::MEDIA,
				'default' => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'dynamic' => [
					'active' => true,
				]
			]
        );

        $this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail',
				'default' => 'large',
				'separator' => 'none',
			]
		);

        $this->add_control(
			'product',
			[
				'label' => __( 'Product', 'wc-elementor-spc' ),
				'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => false,
                'label_block' => true,
				'options' => $this->productList(),
				'default' => '',
			]
		);

		$this->end_controls_section();

        $this->start_controls_section(
			'_section_product_settings',
			[
                'label' => __( 'Product settings', 'wc-elementor-spc' ),
                'tab' => Controls_Manager::TAB_CONTENT,
			]
        );

        $this->add_control(
			'show_badge',
			[
				'label' => __( 'Show Badge', 'wc-elementor-spc' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'your-plugin' ),
				'label_off' => __( 'No', 'your-plugin' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
        );

        $this->add_control(
			'show_ratings',
			[
				'label' => __( 'Show Ratings', 'wc-elementor-spc' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'your-plugin' ),
				'label_off' => __( 'No', 'your-plugin' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
        );

        $this->add_control(
			'show_category',
			[
				'label' => __( 'Show Category', 'wc-elementor-spc' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'your-plugin' ),
				'label_off' => __( 'No', 'your-plugin' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
        );

        $this->add_control(
			'show_price',
			[
				'label' => __( 'Show Price', 'wc-elementor-spc' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'your-plugin' ),
				'label_off' => __( 'No', 'your-plugin' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
        );

        $this->add_control(
			'show_quick_view',
			[
				'label' => __( 'Show Quick View', 'wc-elementor-spc' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'Yes', 'your-plugin' ),
				'label_off' => __( 'No', 'your-plugin' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
        );


        $this->end_controls_section();


        /* Style for Product Starts */

		$this->start_controls_section(
			'_section_product_style',
			[
				'label' => __( 'Common/Layout', 'wc-elementor-spc' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_control(
			'_product_alignment',
			[
				'label' => __( 'Alignment', 'wc-elementor-spc' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left'  => [
						'title' => __( 'Left', 'wc-elementor-spc' ),
						'icon' => 'eicon-text-align-left'
					],
					'center'  => [
						'title' => __( 'Center', 'wc-elementor-spc' ),
						'icon' => 'eicon-text-align-center'
					],
					'right'  => [
						'title' => __( 'Right', 'wc-elementor-spc' ),
						'icon' => 'eicon-text-align-right'
					],
					'justify'  => [
						'title' => __( 'Justify', 'wc-elementor-spc' ),
						'icon' => 'eicon-text-align-justify'
					]
				],
				'default' => 'left',
				'toggle' => false,
			]
        );

        $this->add_responsive_control(
			'_product_padding',
			[
				'label' => __( 'Padding', 'wc-elementor-spc' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-widget-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

        $this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => '_product_border',
				'selector' => '{{WRAPPER}} .elementor-widget-container',
			]
		);

		$this->add_responsive_control(
			'_product_border_radius',
			[
				'label' => __( 'Border Radius', 'wc-elementor-spc' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .elementor-widget-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

        $this->add_control(
			'_product_bg_color',
			[
				'label' => __( 'Background Color', 'wc-elementor-spc' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-widget-container' => 'background-color: {{VALUE}};',
				],
			]
		);

        $this->end_controls_section();
        /* Style for Product Ends */

        /* Style for Image Starts */
        $this->start_controls_section(
			'_section_product_img_style',
			[
				'label' => __( 'Image', 'wc-elementor-spc' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

        $this->add_responsive_control(
			'image_spacing',
			[
				'label' => __( 'Bottom Spacing', 'wc-elementor-spc' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'selectors' => [
					'{{WRAPPER}} .wc-single-product-figure' => 'margin-bottom: {{SIZE}}{{UNIT}} !important;',
				],
			]
        );

        $this->add_responsive_control(
			'image_badge_padding',
			[
				'label' => __( 'Padding', 'wc-elementor-spc' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .wc-single-product-figure' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

        $this->add_responsive_control(
			'image_border_radius',
			[
				'label' => __( 'Border Radius', 'wc-elementor-spc' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .wc-single-product-figure img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

        $this->end_controls_section();
        /* Style for Image Ends */

		/* Style for QuickView Starts */
		$this->start_controls_section(
			'_section_product_quick_view_style',
			[
				'label' => __( 'Quick View', 'wc-elementor-spc' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'qv_position_toggle',
			[
				'label' => __( 'Position', 'wc-elementor-spc' ),
				'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
				'label_off' => __( 'Default', 'wc-elementor-spc' ),
				'label_on' => __( 'Custom', 'wc-elementor-spc' ),
				'return_value' => 'yes',
			]
		);

		$this->start_popover();

		$this->add_responsive_control(
			'qv_offset_left',
			[
				'label' => __( 'Right', 'wc-elementor-spc' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'condition' => [
					'position_toggle' => 'yes'
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .quick-view' => 'right: {{SIZE}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'qv_offset_top',
			[
				'label' => __( 'Top', 'wc-elementor-spc' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'condition' => [
					'position_toggle' => 'yes'
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .quick-view' => 'top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_popover();

		$this->end_controls_section();
		/* Style for QuickView Ends */

        /* Style for Badge Starts */
        $this->start_controls_section(
			'_section_product_badge_style',
			[
				'label' => __( 'Sale Badge', 'wc-elementor-spc' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'sale_badge_padding',
			[
				'label' => __( 'Padding', 'wc-elementor-spc' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .sale-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'position_toggle',
			[
				'label' => __( 'Position', 'wc-elementor-spc' ),
				'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
				'label_off' => __( 'Default', 'wc-elementor-spc' ),
				'label_on' => __( 'Custom', 'wc-elementor-spc' ),
				'return_value' => 'yes',
			]
		);

		$this->start_popover();

		$this->add_responsive_control(
			'sale_badge_offset_left',
			[
				'label' => __( 'Left', 'wc-elementor-spc' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'condition' => [
					'position_toggle' => 'yes'
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .sale-badge' => 'left: {{SIZE}}{{UNIT}};'
				]
			]
		);

		$this->add_responsive_control(
			'sale_badge_offset_top',
			[
				'label' => __( 'Top', 'wc-elementor-spc' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'condition' => [
					'position_toggle' => 'yes'
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'selectors' => [
					'{{WRAPPER}} .sale-badge' => 'top: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_popover();

		$this->add_control(
			'sale_badge_color',
			[
				'label' => __( 'Text Color', 'wc-elementor-spc' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .sale-badge' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'sale_badge_bg_color',
			[
				'label' => __( 'Background Color', 'wc-elementor-spc' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .sale-badge' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'sale_badge_border',
				'selector' => '{{WRAPPER}} .sale-badge',
			]
		);

		$this->add_responsive_control(
			'sale_badge_border_radius',
			[
				'label' => __( 'Border Radius', 'wc-elementor-spc' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .sale-badge' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'sale_badge_typography',
				'label' => __( 'Typography', 'wc-elementor-spc' ),
				'exclude' => [
					'line_height'
				],
				'default' => [
					'font_size' => ['']
				],
				'selector' => '{{WRAPPER}} .sale-badge',
				'scheme' => Scheme_Typography::TYPOGRAPHY_3,
			]
		);

        $this->end_controls_section();
        /* Style for Badge Ends */


        $this->start_controls_section(
			'_section_product_content_style',
			[
				'label' => __( 'Content', 'wc-elementor-spc' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[
				'label' => __( 'Content Padding', 'wc-elementor-spc' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .wc-single-product-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
        );

        /* Style for Title Starts */
        $this->add_control(
			'_heading_title',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Title', 'wc-elementor-spc' ),
				'separator' => 'before'
			]
		);

		$this->add_control(
			'title_tag',
			[
				'label' => __( 'HTML Tag', 'wc-elementor-spc' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'h1'  => [
						'title' => __( 'H1', 'wc-elementor-spc' ),
						'icon' => 'eicon-editor-h1'
					],
					'h2'  => [
						'title' => __( 'H2', 'wc-elementor-spc' ),
						'icon' => 'eicon-editor-h2'
					],
					'h3'  => [
						'title' => __( 'H3', 'wc-elementor-spc' ),
						'icon' => 'eicon-editor-h3'
					],
					'h4'  => [
						'title' => __( 'H4', 'wc-elementor-spc' ),
						'icon' => 'eicon-editor-h4'
					],
					'h5'  => [
						'title' => __( 'H5', 'wc-elementor-spc' ),
						'icon' => 'eicon-editor-h5'
					],
					'h6'  => [
						'title' => __( 'H6', 'wc-elementor-spc' ),
						'icon' => 'eicon-editor-h6'
					]
				],
				'default' => 'h2',
				'toggle' => false,
			]
		);

		$this->add_responsive_control(
			'title_spacing',
			[
				'label' => __( 'Bottom Spacing', 'wc-elementor-spc' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'selectors' => [
					'{{WRAPPER}} .sp-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __( 'Text Color', 'wc-elementor-spc' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .sp-title' => 'color: {{VALUE}}',
				],
			]
        );

        $this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'label' => __( 'Typography', 'wc-elementor-spc' ),
				'selector' => '{{WRAPPER}} .sp-title',
				'scheme' => Scheme_Typography::TYPOGRAPHY_2,
			]
        );
        /* Style for Title Ends */

        /* Style for Category Starts */
		$this->add_control(
			'_heading_category',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Category', 'wc-elementor-spc' ),
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
			'category_spacing',
			[
				'label' => __( 'Bottom Spacing', 'wc-elementor-spc' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'selectors' => [
					'{{WRAPPER}} .sp-category' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'category_color',
			[
				'label' => __( 'Text Color', 'wc-elementor-spc' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .sp-category span a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'category_typography',
				'label' => __( 'Typography', 'wc-elementor-spc' ),
				'selector' => '{{WRAPPER}} .sp-category span a',
				'scheme' => Scheme_Typography::TYPOGRAPHY_3,
			]
        );
        /* Style for Category Starts */


        /* Style for Price Starts */
        $this->add_control(
			'_heading_price',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Price', 'wc-elementor-spc' ),
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
			'price_spacing',
			[
				'label' => __( 'Bottom Spacing', 'wc-elementor-spc' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'selectors' => [
					'{{WRAPPER}} .price-wrap' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'price_color',
			[
				'label' => __( 'Text Color', 'wc-elementor-spc' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .sp-price' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'price_typography',
				'label' => __( 'Typography', 'wc-elementor-spc' ),
				'selector' => '{{WRAPPER}} .sp-price',
				'scheme' => Scheme_Typography::TYPOGRAPHY_3,
			]
        );
        /* Style for Price Starts */


        /* Style for Rating Starts */
        $this->add_control(
			'_heading_rating',
			[
				'type' => Controls_Manager::HEADING,
				'label' => __( 'Rating', 'wc-elementor-spc' ),
				'separator' => 'before'
			]
		);

		$this->add_responsive_control(
			'rating_spacing',
			[
				'label' => __( 'Bottom Spacing', 'wc-elementor-spc' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'selectors' => [
					'{{WRAPPER}} .sp-rating' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'rating_color',
			[
				'label' => __( 'Icon Color', 'wc-elementor-spc' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .sp-rating i' => 'color: {{VALUE}};',
				],
			]
		);

        $this->add_control(
			'rating_size',
			[
				'label' => __( 'Icon Size', 'wc-elementor-spc' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
						'step' => 1,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 16,
				],
				'selectors' => [
					'{{WRAPPER}} .sp-rating i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
        );
        /* Style for Rating Starts */
        $this->end_controls_section();


        /* Style for Add to Cart Starts */
        $this->start_controls_section(
			'_section_style_button',
			[
				'label' => __( 'Add to Cart', 'wc-elementor-spc' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'button_padding',
			[
				'label' => __( 'Padding', 'wc-elementor-spc' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .sp-add-cart' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'button_typography',
				'selector' => '{{WRAPPER}} .sp-add-cart',
				'scheme' => Scheme_Typography::TYPOGRAPHY_4,
			]
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'button_border',
				'selector' => '{{WRAPPER}} .sp-add-cart',
			]
		);

		$this->add_control(
			'button_border_radius',
			[
				'label' => __( 'Border Radius', 'wc-elementor-spc' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .sp-add-cart' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'separator',
			[
				'type' => Controls_Manager::DIVIDER,
				'style' => 'thick',
			]
		);

		$this->start_controls_tabs( '_state_tabs_button' );

		$this->start_controls_tab(
			'_state_tab_normal',
			[
				'label' => __( 'Normal', 'wc-elementor-spc' ),
			]
		);

		$this->add_control(
			'button_color',
			[
				'label' => __( 'Text Color', 'wc-elementor-spc' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} .sp-add-cart' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_bg_color',
			[
				'label' => __( 'Background Color', 'wc-elementor-spc' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .sp-add-cart' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'_state_tab_hover',
			[
				'label' => __( 'Hover', 'wc-elementor-spc' ),
			]
		);

		$this->add_control(
			'button_hover_color',
			[
				'label' => __( 'Text Color', 'wc-elementor-spc' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .sp-add-cart:hover, {{WRAPPER}} .sp-add-cart:focus' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_bg_color',
			[
				'label' => __( 'Background Color', 'wc-elementor-spc' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .sp-add-cart:hover, {{WRAPPER}} .sp-add-cart:focus' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'button_hover_border_color',
			[
				'label' => __( 'Border Color', 'wc-elementor-spc' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .sp-add-cart:hover, {{WRAPPER}} .sp-add-cart:focus' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->end_controls_section();
        /* Style for Add to Cart Starts */
	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( $settings['product'] ) {
			$productData = wc_get_product( $settings['product'] );

			$discount = (  (  ( $productData->get_regular_price() - $productData->get_sale_price() ) / $productData->get_regular_price() ) * 100 );
			$badge    = ( $discount > 0 ) ? "-" . $discount . "%" : "0%";
			$rating   = ceil( $productData->get_average_rating() );
			$category = wc_get_product_category_list( $settings['product'] );
			$title    = $productData->get_name();
			$price    = wc_price( $productData->get_price() );
			$cartLink = "/?add-to-cart=" . $settings['product'];

		} else {
			$badge    = "-30%";
			$rating   = 3;
			$category = "Category";
			$title    = "Product Title";
			$price    = wc_price( 100 );
			$cartLink = "#";
		}

		$this->add_render_attribute(
			'title',
			'class',
			['sp-title']
		);

		$this->add_render_attribute(
			'badge_text',
			'class',
			['sale-badge']
		);

		$this->add_render_attribute(
			'show_quick_view',
			'class',
			['quick-view']
		);

		$this->add_render_attribute(
			'product_rating',
			'class',
			['sp-rating']
		);

		$this->add_render_attribute(
			'product_category',
			'class',
			['sp-category']
		);

		$this->add_render_attribute(
			'product_price',
			'class',
			( $settings['show_price'] != 'yes' ) ? ['sp-price hidden'] : ['sp-price']
		);

		$this->add_render_attribute(
			'product_add_cart',
			[
				'class' => ['sp-add-cart'],
				'href'  => $cartLink,
			]
		);

        ?>

        <?php if ( $settings['image']['url'] || $settings['image']['id'] ) : ?>
			<figure class="wc-single-product-figure">
				<?php echo Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail', 'image' ); ?>
				<?php if ( $settings['show_badge'] == 'yes' ) : ?>
					<div <?php echo $this->get_render_attribute_string( 'badge_text' ); ?>><?=$badge?></div>
                <?php endif; ?>

                <?php if ( $settings['show_quick_view'] == 'yes' ) : ?>
					<div <?php echo $this->get_render_attribute_string( 'show_quick_view' ); ?>>
						<span class="like eicon-heart" title="Add to favorite"></span>
						<span class="preview eicon-frame-expand" title="Quick view product"></span>
					</div>
                <?php endif; ?>
			</figure>
		<?php endif; ?>

		<div class="wc-single-product-body align-<?=$settings['_product_alignment']?>">
			<?php if ( $settings['show_ratings'] == 'yes' ) : ?>
				<div <?php echo $this->get_render_attribute_string( 'product_rating' ); ?>>
				<?php
					for($i = 0; $i<5; $i++){
						$isEmpty = " empty";
						if($rating != 0){
							if($i < $rating){
								$isEmpty = "";
							}
						}
						echo "<i class='eicon-star {$isEmpty}'></i>";
					}
				?>
				</div>
			<?php endif; ?>
			<?php if ( $settings['show_category'] == 'yes' ) : ?>
				<div <?php echo $this->get_render_attribute_string( 'product_category' ); ?>>
					<span><a href="#"><?=$category?></a></span>
				</div>
			<?php endif; ?>
			<?php
				printf( '<%1$s %2$s>%3$s</%1$s>',
					tag_escape( $settings['title_tag'] ),
					$this->get_render_attribute_string( 'title' ),
					$title
					);
			?>
			<div class="price-wrap">
				<div <?php echo $this->get_render_attribute_string( 'product_price' ); ?>><?=$price?></div>
				<a <?php echo $this->get_render_attribute_string( 'product_add_cart' ); ?>><i class="eicon-cart-solid"></i>Add to Cart</a>
			</div>
		</div>

        <?php
	}

	/**
	 * Render the widget output in the editor.
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function _content_template() {
		?>
		<#

		view.addRenderAttribute(
			'product_body',
			'class',
			['wc-single-product-body align-'+settings._product_alignment]
		);

		view.addRenderAttribute(
			'show_badge',
			'class',
			['sale-badge']
		);

		view.addRenderAttribute(
			'show_quick_view',
			'class',
			['quick-view']
		);

		view.addRenderAttribute(
			'product_rating',
			'class',
			['sp-rating']
		);

		view.addRenderAttribute(
			'product_category',
			'class',
			['sp-category']
		);

		view.addRenderAttribute(
			'product_price',
			'class',
			(settings.show_price)?['sp-price']:['sp-price hidden']
		);

		view.addRenderAttribute(
			'product_add_cart',
			{
				'class':['sp-add-cart'],
				'href':'/?add-to-cart='+settings.product
			}
		);

		view.addRenderAttribute( 'title', 'class', 'sp-title' );

		if ( settings.image.url || settings.image.id ) {
			var image = {
				id: settings.image.id,
				url: settings.image.url,
				size: settings.thumbnail_size,
				dimension: settings.thumbnail_custom_dimension,
				model: view.getEditModel()
			};

			var image_url = elementor.imagesManager.getImageUrl( image ); #>
			<figure class="wc-single-product-figure">
				<img src="{{ image_url }}">
				<# if (settings.show_badge == 'yes') { #>
					<div {{{ view.getRenderAttributeString( 'show_badge' ) }}}>-30%</div>
				<# } #>

				<# if (settings.show_quick_view == 'yes') { #>
					<div {{{ view.getRenderAttributeString( 'show_quick_view' ) }}}>
						<span class="like eicon-heart" title="Add to favorite"></span>
						<span class="preview eicon-frame-expand" title="Quick view product"></span>
					</div>
				<# } #>
			</figure>
		<# } #>

		<div {{{ view.getRenderAttributeString( 'product_body' ) }}}>
			<# if (settings.show_ratings == 'yes') { #>
				<div {{{ view.getRenderAttributeString( 'product_rating' ) }}}>
					<i class="eicon-star"></i>
					<i class="eicon-star"></i>
					<i class="eicon-star"></i>
					<i class="eicon-star empty"></i>
					<i class="eicon-star empty"></i>
				</div>
			<# } #>

			<# if (settings.show_category == 'yes') { #>
				<div {{{ view.getRenderAttributeString( 'product_category' ) }}}>
					<span><a href="#">Category Name</a></span>
				</div>
			<# } #>


			<{{ settings.title_tag }} {{{ view.getRenderAttributeString( 'title' ) }}}>Product Title</{{ settings.title_tag }}>


			<div class="price-wrap">
				<div {{{ view.getRenderAttributeString( 'product_price' ) }}}>$29</div>
				<a {{{ view.getRenderAttributeString( 'product_add_cart' ) }}}><i class="eicon-cart-solid"></i>Add to Cart</a>
			</div>
		</div>

		<?php
    }

    private function productList(){
        global $wpdb;

        $sql = "SELECT product.ID as product_id, product.post_title as product_name
        FROM {$wpdb->prefix}posts as product
        WHERE (product.post_type = 'product' OR product.post_type = 'product_variation')
        ORDER BY product_id ASC";

        $products = $wpdb->get_results($sql,"OBJECT_K");

        $productArray = [];
        foreach ($products as $key => $product) {
            $productArray[$key] = __( $product->product_name, 'wc-elementor-spc' );
        }
        return $productArray;
    }
}
