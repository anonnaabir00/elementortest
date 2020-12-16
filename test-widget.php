<?php
class Elementor_Test_Widget extends \Elementor\Widget_Base {

	public function get_name() {
        return "TestWidget";
    }

	public function get_title() {
        return __("TestWidget" , "elementortest" );
    }

	public function get_icon() {
        return "fa fa-image";
    }

	public function get_categories() {
        return array('general','basic');
    }

	protected function _register_controls() {
        $this->start_controls_section(
			'content_section',
			[
				'label' => __( 'Content', 'elementortest' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'heading',
			[
				'label' => __( 'Type Something', 'elementortest' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'Hello world', 'elementortest' ),
			]
		);

		$this->end_controls_section();

	}
    }

	protected function render() {
        $settings = $this->get_settings_for_display();
        $heading = $settings['heading'];
        echo "<h1>".esc_html($heading)."</h1>";
    }

	protected function _content_template() {}

}