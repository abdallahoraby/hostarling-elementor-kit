<?php


class hostarlingHexaGallery extends \Elementor\Widget_Base{

	public function get_name(){
		return 'hexa-gallery';
	}

	public function get_title(){
		return __('Hexa Gallery', 'elementor');
	}

	public function get_icon(){
		return 'hostarling-icon hexa-gallery';
	}

	public function get_categories(){
		return ['hostarling-widgets'];
	}


	protected function register_controls_gallery() {
		$this->add_control(
			'hexa_gallery_items',
			[
				'label' => __( 'Add Images', 'hostarling-elementor-kit' ),
				'type' => \Elementor\Controls_Manager::GALLERY,
				'default' => [],
			]
		);
	}





	protected function _register_controls() {

		// start content section

		$this->start_controls_section(
			'hexa_section_content',
			[
				'label' => __( 'Content', 'hostarling-elementor-kit' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		// import our controls
		$this->register_controls_gallery();


		// end content section
		$this->end_controls_section();


	}


	protected function render(){
		$settings = $this->get_settings_for_display();

		// Get image url
		$gallery_items = '';
		foreach ( $settings['hexa_gallery_items'] as $image ) :
			$gallery_items .= '<div class="hex-cell"><img src="'. $image['url'] .'"/></div>';
		endforeach;

		$html = '<div class="hexa" style="--n-rows: 3; --n-cols: 6">';

		$html .= $gallery_items;

		$html .= '</div>';

		echo $html;
	}

	protected function _content_template() {
		?>
		<!-- number of rows and minimum number of columns, you can adjust as you please-->
		<!-- image urls, you can replace with your own-->
		<div class="hexa" style="--n-rows: 3; --n-cols: 6">
			<# _.each( settings.hexa_gallery_items, function( image ) { #>
				<div class="hex-cell"><img src="{{ image.url }}"/></div>
			<# }); #>
		</div>
		<?php
	}


}

?>

