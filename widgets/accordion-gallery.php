<?php


class hostarlingAccordiongallery extends \Elementor\Widget_Base{
	public function get_name(){
		return 'accordion-gallery';
	}

	public function get_title(){
		return __('Accordion Gallery', 'elementor');
	}

	public function get_icon(){
		return 'hostarling-icon accordion-gallery';
	}

	public function get_categories(){
		return ['hostarling-widgets'];
	}

	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);

		wp_register_script( 'script-handle', plugins_url( '../js/accordion-gallery.js', __FILE__ ), array( 'jquery', 'elementor-frontend' ), rand(), true );
	}

	public function get_script_depends() {
		return [ 'script-handle' ];
	}

	protected function register_controls_gallery() {
		$this->add_control(
			'gallery_items',
			[
				'label' => __( 'Add Images', 'hostarling-elementor-kit' ),
				'type' => \Elementor\Controls_Manager::GALLERY,
				'default' => [],
			]
		);
	}

	protected function register_controls_images_height() {
        $this->add_responsive_control(
                'images_height',
	        [
		        'label' => __( 'Height', 'hostarling-elementor-kit' ),
		        'type' => \Elementor\Controls_Manager::SLIDER,
		        'size_units' => [ 'vh', '%', 'px' ],
		        'range' => [
			        'vh' => [
				        'min' => 0,
				        'max' => 100,
			        ],
			        '%' => [
				        'min' => 0,
				        'max' => 100,
                        'step' => 1
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
			        '{{WRAPPER}} .gallery-wrap' => 'height: {{SIZE}}{{UNIT}} !important',
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
			'loop_animation',
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
	            'loop_delay',
            [
	            'type' => \Elementor\Controls_Manager::NUMBER,
	            'label' => __( 'Delay in seconds', 'hostarling-elementor-kit' ),
	            'min' => 1,
	            'max' => 100,
	            'step' => 1,
	            'default' => 3,
	            'condition' => [
		            'loop_animation' => 'on'
	            ],

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
		$this->register_controls_gallery();

		$this->register_controls_images_height();

		$this->register_controls_loop_animation();

		$this->register_controls_delay();

		// end content section
		$this->end_controls_section();


	}


	protected function render(){
		$settings = $this->get_settings_for_display();

		// Get image url
		$gallery_items = '';
		foreach ( $settings['gallery_items'] as $image ) :
			$gallery_items .= '<div class="item" style="background-image: url('. $image['url'] .') "></div>';
		endforeach;

		$html = '
			<div id="accordion_gallery" class="gallery-wrap" style="height: '. $settings['images_height']['size'] . $settings['images_height']['unit'] . ' ">
			    '. $gallery_items .'
			  </div>	
		';

		if( $settings['loop_animation'] === 'on' ){
		    $html .= '<input type="hidden" value="'. $settings['loop_delay'] .'" id="accordion_gallery_time_out">';
        } else {
		    $html .= '<input type="hidden" value="off" id="loop_animation">';
        }

		echo $html;
	}

	protected function _content_template() {
		?>
		<div id="accordion_gallery" class="gallery-wrap" style="height: {{{settings.images_height.size}}}{{{settings.images_height.unit}}};">
			<# _.each( settings.gallery_items, function( image ) { #>
				<div class="item" style="background-image: url({{ image.url }}) "></div>
			<# }); #>
		</div>

        <# if ( 'on' === settings.loop_animation ) { #>
            <input type="hidden" value="{{{ settings.loop_delay }}}" id="accordion_gallery_time_out">
        <# } else { #>
            <input type="hidden" value="off" id="loop_animation">
        <# } #>

		<?php
	}


}

?>

