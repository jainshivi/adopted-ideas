<?php

require_once('../../../wp-load.php');

$data = array(
	'recipients'=>$_POST['author'],
	'subject'=>$_POST['subject'],
	'content'=>$_POST['text']
);

/*$data_confirmation = array (
	'recipients'=>$_POST['user'],
	'subject'=>$_POST['subject'],
	'content'=>$_POST['text']);
*/

$data_confirmation = array (
	'recipients'=>$_POST['user'],
	'subject'=>"Idea sent",
	'content'=>$_POST['text']);

$bp_id = messages_new_message($data);
messages_new_message($data_confirmation);

global $wpdb;

/**
 * The purpose of this query is to get the actual message id and not the thread id for identification of the
 * suggeste ideas in the ideas table. There was an issue which is documented on github that caused
 * the bp_id not to work so the id was necessary. Unfortunately, since we cannot edit code outside
 * the scope of this plugin, we must settle for an extraneous sql query.
 * @var [type]
 */
$id = $wpdb->get_var( "SELECT id FROM wp_20hgjnxdv0_bp_messages_messages WHERE thread_id='$bp_id' ORDER BY id ASC LIMIT 1");


$wpdb->insert($wpdb->prefix . 'adoptedideaswidget',
	array(
		'time' => date("Y-m-d H:i:s"),
		'userid' => $_POST['user'],
		'campaignid' => $_POST['post'],
		'content' => $_POST['text'],
		'approved' => '0',
		'bp_id' => $id
	)
);