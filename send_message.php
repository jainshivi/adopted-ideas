<?php

require_once('../../../wp-load.php');

$content = $_POST['text'];

$data = array(
	'recipients'=>$_POST['author'],
	'subject'=>$_POST['subject'],
	'content'=>$content
);


$data_confirmation = array (
	'recipients'=>$_POST['user'],
	'subject'=>"Idea sent",
	'content'=>$_POST['text']);

$bp_id = messages_new_message($data);

// When a message is sent to the user who is sending the message,
// there may be no email that is sent.
messages_new_message($data_confirmation);

global $wpdb;

/**
 * The purpose of this query is to get the actual message id and not the thread id for identification of the
 * suggeste ideas in the ideas table. There was an issue which is documented on github that caused
 * the bp_id not to work so the id was necessary. Unfortunately, since we cannot edit code outside
 * the scope of this plugin, we must settle for an extraneous sql query.
 * @var [type]
 */
$id = $wpdb->get_var( "SELECT id FROM ".$wpdb->prefix."bp_messages_messages WHERE thread_id='$bp_id' ORDER BY id ASC LIMIT 1");

//update message with $bp_id
$content_with_link = $content."\n\n<a style='color:blue' href='".plugins_url()."/adopted-ideas/approve.php?message=$bp_id'>Adopt The Idea</a>";

$wpdb->update($wpdb->prefix . 'bp_messages_messages',
	array(
		'message'=>$content_with_link
	),
	array('id'=>$id)
);


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


// returning the result to the caller
if ($bp_id) {
	echo 1;
} else {
	echo 0;
}


?>