<?php
/*
Plugin Name: Adopted Ideas Widget
Plugin URI: http://tjstalcup.com
Description: Creates a Widget that will be shown in the sidebar of a page allowing users to suggest an idea
Author: TJ Stalcup
Version: 1.0
Author URI: http://tjstalcup.com
*/

// Block direct requests
if (!defined('ABSPATH')) {
	die('1');
}

add_action('widgets_init', function(){
	register_widget('Adopted_Ideas_Widget');
});

/**
* Adds Adopted_Ideas_Widget
*/
class Adopted_Ideas_Widget extends WP_Widget {
	/**
	* Register widget with WordPress.
	*/
	function __construct(){
		parent::__construct(
			'Adopted_Ideas_Widget',
			__('Adopted Ideas Widget','text_domain'),
			array('description'=>__('Creates a Widget that will be shown in the sidebar of a page allowing users to suggest an idea','text_domain'),)
		);
	}

	/**
	* Front-end display of widget
	*/
	public function widget($args,$instance){
		wp_enqueue_script('aiw-js', plugins_url('aiw.js', __FILE__));
		wp_enqueue_style('aiw', plugins_url('aiw.css', __FILE__));
		$template = locate_template(array('aiw_template.php'));
		if($template=='') $template = 'aiw_template.php';
		include($template);
	}
}

global $wpdb;
$table_name = $wpdb->prefix . 'adoptedideaswidget';
$charset_collate = $wpdb->get_charset_collate();
$sql = "CREATE TABLE IF NOT EXISTS $table_name (
		id int(11) NOT NULL AUTO_INCREMENT,
		time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		userid int(11) NOT NULL,
		campaignid int(11) NOT NULL,
		content text NOT NULL,
		approved int(1) DEFAULT 0 NOT NULL,
		bp_id int(11) NOT NULL,
		UNIQUE KEY id (id)
) $charset_collate;";
require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
dbDelta($sql);

function add_bp_action(){
	/*echo '<script>
		jQuery("td.thread-options").each(function(){
			var message = jQuery(this).parent().attr("id");
			jQuery(this).append(" | <a class=\"adopt_the_idea\" href=\"'. plugins_url() . '/adopted-ideas/approve.php?message="+message+"\">Adopt The Idea</a>");
		});
	</script>';*/
}

add_action('bp_after_member_messages_loop', 'add_bp_action');