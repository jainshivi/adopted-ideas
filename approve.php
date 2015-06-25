<?php

require_once('../../../wp-load.php');

$bp_id = str_replace("m-", "", $_GET['message']);

global $wpdb;

/**
 * The purpose of this query is to get the actual message id and not the thread id for identification of the
 * suggeste ideas in the ideas table. There was an issue which is documented on github that caused
 * the bp_id not to work so the id was necessary. Unfortunately, since we cannot edit code outside
 * the scope of this plugin, we must settle for an extraneous sql query.
 * @var [type]
 */
$message_info = $wpdb->get_row( "SELECT id, sender_id, subject FROM wp_20hgjnxdv0_bp_messages_messages WHERE thread_id='$bp_id'", ARRAY_A);

$id = $message_info['id'];
$senderId = $message_info['sender_id'];
$ideaSubject = $message_info['subject'];

$subject = "Idea approved";
$content = "Your suggested idea, $ideaSubject, has been approved.";

$data = array(
	'recipients'=>$senderId,
	'subject'=>$subject,
	'content'=>$content
);

messages_new_message($data);

$wpdb->update($wpdb->prefix . 'adoptedideaswidget',
	array(
		'approved'=>'1',
		'bp_id'=>'0',
		'time'=>date("Y-m-d H:i:s")
	),
	array('bp_id'=>$id)
);

messages_delete_thread($bp_id);


header("Location: ".$_SERVER['HTTP_REFERER']);


