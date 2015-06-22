<?php

require_once('../../../wp-load.php');

$data = array(
	'recipients'=>$_POST['author'],
	'subject'=>$_POST['subject'],
	'content'=>$_POST['text']
);

$bp_id = messages_new_message($data);

global $wpdb;
$id = $wpdb->get_var( "SELECT id FROM wp_20hgjnxdv0_bp_messages_messages WHERE thread_id='$bp_id'");


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