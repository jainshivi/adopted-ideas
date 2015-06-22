<?php

require_once('../../../wp-load.php');

$bp_id = str_replace("m-", "", $_GET['message']);

global $wpdb;
$id = $wpdb->get_var( "SELECT id FROM wp_20hgjnxdv0_bp_messages_messages WHERE thread_id='$bp_id'");
/**
 * solution is to update the sql query so that it only
 * queries ONE record, the most recent one.
 * TODO
 * find this sql code on some document and find out how it does the update process
 * then request that it only updates one not all.
 */


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


