<?php


class hostarlingCube3DGallery extends \Elementor\Widget_Base{
	public function get_name(){
		return 'cube-3d-gallery';
	}

	public function get_title(){
		return __('3D Cube Gallery', 'elementor');
	}

	public function get_icon(){
		return 'hostarling-icon cube-3d-gallery';
	}

	public function get_categories(){
		return ['hostarling-widgets'];
	}

	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);

		wp_register_script( 'script-handle-cube3d', plugins_url( '../js/cube3d-gallery.js', __FILE__ ), array( 'jquery', 'elementor-frontend' ), rand(), true );
	}

	public function get_script_depends() {
		return [ 'script-handle-cube3d' ];
	}


	protected function register_controls_gallery_items() {

		$gallery_repeater = new \Elementor\Repeater();

		$gallery_repeater->add_control(
			'accordion_image',
			[
				'label' => __( 'Choose Image', 'hostarling-elementor-kit' ),
				'type' => \Elementor\Controls_Manager::MEDIA,
			]
		);


		$gallery_repeater->add_control(
			'accordion_title', [
				'label' => __( 'Title', 'hostarling-elementor-kit' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Title One' , 'hostarling-elementor-kit' ),
				'label_block' => true,
			]
		);


		$gallery_repeater->add_control(
			'accordion_link',
			[
				'label' => __( 'Link', 'hostarling-elementor-kit' ),
				'type' => \Elementor\Controls_Manager::URL,
				'placeholder' => __( 'https://your-link.com', 'hostarling-elementor-kit' ),
				'show_external' => true,
				'default' => [
					'url' => '',
					'is_external' => true,
					'nofollow' => true,
				],
			]
		);

		$gallery_repeater->add_control(
			'accordion_title_color',
			[
				'label' => __( 'Title Color', 'hostarling-elementor-kit' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#000',
				'selectors' => [
					'{{CURRENT_ITEM}} a' => 'color: {{VALUE}};'
				],
			]
		);

		$gallery_repeater->add_control(
			'accordion_title_background',
			[
				'label' => __( 'Title Background Color', 'hostarling-elementor-kit' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{CURRENT_ITEM}} a' => 'background: {{VALUE}};'
				],
			]
		);


		$this->add_control(
			'gallery_list',
			[
				'label' => __( 'Repeater List', 'hostarling-elementor-kit' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $gallery_repeater->get_controls(),
				'default' => [
					[
						'accordion_image' => '',
						'accordion_title' => 'Title One'
					]
				],
				'title_field' => '{{{ accordion_title }}}',
			]
		);

	}

	protected function register_controls_image_height() {
		$this->add_responsive_control(
			'accordion_images_height',
			[
				'label' => __( 'Image Height', 'hostarling-elementor-kit' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'vh', 'px' ],
				'range' => [
					'vh' => [
						'min' => 0,
						'max' => 100,
					],
					'px' => [
						'min' => 0,
						'max' => 2000,
						'step' => 1
					]
				],
				'default' => [
					'unit' => 'vh',
					'size' => 50,
				],
				'selectors' => [
					'{{WRAPPER}} .card' => 'height: {{SIZE}}{{UNIT}} !important',
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => 50,
					'unit' => 'vh',
				],
				'tablet_default' => [
					'size' => 50,
					'unit' => 'vh',
				],
				'mobile_default' => [
					'size' => 50,
					'unit' => 'vh',
				],
			]
		);
	}

	protected function register_controls_loop_animation() {
		$this->add_control(
			'loop_two_animation',
			[
				'label' => __( 'Loop Animation', 'hostarling-elementor-kit' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'hostarling-elementor-kit' ),
				'label_off' => __( 'Off', 'hostarling-elementor-kit' ),
				'return_value' => 'on',
				'default' => 'off',
			]
		);
	}

	protected function register_controls_delay() {
		$this->add_control(
			'loop_two_delay',
			[
				'type' => \Elementor\Controls_Manager::NUMBER,
				'label' => __( 'Delay in seconds', 'hostarling-elementor-kit' ),
				'min' => 1,
				'max' => 100,
				'step' => 1,
				'default' => 3,
				'condition' => [
					'loop_two_animation' => 'on'
				],

			]
		);

	}

	protected function register_controls_title_font() {
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'gallery_two_title_typography',
				'label' => __( 'Typography', 'hostarling-elementor-kit' ),
				'selector' => '{{WRAPPER}} .card__head',
			]
		);
	}


	protected function _register_controls() {

		// start content section

		$this->start_controls_section(
			'section_content',
			[
				'label' => __( 'Content', 'hostarling-elementor-kit' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		// import our controls
		$this->register_controls_gallery_items();

		$this->register_controls_image_height();

		$this->register_controls_loop_animation();

		$this->register_controls_delay();

		$this->register_controls_title_font();


		// end content section
		$this->end_controls_section();


	}


	protected function render(){
		$settings = $this->get_settings_for_display();



	}

	protected function _content_template() {
		?>

		<div class="container flip_card">
			<div class="card">
				<div class="item front-side">
					<img src="https://webdevtrick.com/wp-content/uploads/gadget.jpg" />
				</div>
				<div class="item back-side">
					<img src="https://webdevtrick.com/wp-content/uploads/cons.jpg" />
				</div>
			</div>
			<div class="card">
				<div class="item front-side">
					<img src="https://webdevtrick.com/wp-content/uploads/design.jpg" />
				</div>
				<div class="item back-side">
					<img src="https://webdevtrick.com/wp-content/uploads/programming.jpg" />
				</div>
			</div>
			<div class="card">
				<div class="item front-side">
					<img src="https://webdevtrick.com/wp-content/uploads/auto.jpg" />
				</div>
				<div class="item back-side">
					<img src="https://webdevtrick.com/wp-content/uploads/hardware.jpg" />
				</div>
			</div>
		</div>

		<?php
	}


}

?>

