<?php

/**
 * Plugin Name:       WP Hello World
 * Plugin URI:        #
 * Description:       This plugin is outputs "hello world" in the newest post via browser console..
 * Version:           1.0.0
 * Author:            WP Hello World WordPress Team
 * Author URI:        #
 * License:           GPL-2.0+
 * License URI:       #
 * Text Domain:       wp-hello-world
 */


// If this file is called directly, abort.
if (! defined('WPINC')) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0
 * Rename this for your plugin and update it as you release new versions.
 */

define('WP_HELLOW_ORLD_VERSION', '1.0.0');

define('WP_HELLO_WORLD_NAME', 'WP Hello World');


class WpHelloWorldPublic {

	public function __construct($plugin_name, $version){
		$this->plugin_name = $plugin_name;
		$this->version = $version;

		add_shortcode('wc_calender_month', array($this, 'wc_calender_month_function'));
		add_shortcode('wc_calender_list', array($this, 'wc_calender_list_function'));
		add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
	}

	public function GetLatestPostId() {
		$post_id = '';
		$recent_post = wp_get_recent_posts(array('numberposts' => 1, 'post_status' => 'publish'));
		if (!empty($recent_post)) {
			$post_id = $recent_post[0]['ID'];
		}

		return $post_id;
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__).'js/wp-hello-world.js', array('jquery'), $this->version, false);
		if (is_singular('post')){
			wp_localize_script($this->plugin_name, 'myPost', array('latest_post' => $this->GetLatestPostId(), 'current_post' => get_the_ID()));
		}
	}
}
$wp_hello_world = new WpHelloWorldPublic(WP_HELLOW_ORLD_VERSION, WP_HELLO_WORLD_NAME);
