<?php

require_once('../../../wp-load.php');

$data = array(
	'recipients'=>$_POST['author'],
	'subject'=>'Ideas',
	'content'=>$_POST['text']
);

$bp_id = messages_new_message($data);

global $wpdb;

$wpdb->insert($wpdb->prefix . 'adoptedideaswidget',
	array(
		'time' => date("Y-m-d H:i:s"),
		'userid' => $_POST['user'],
		'campaignid' => $_POST['post'],
		'content' => $_POST['text'],
		'approved' => '0',
		'bp_id' => $bp_id
	)
);