<?php

require_once('../../../wp-load.php');

$bp_id = str_replace("m-", "", $_GET['message']);

global $wpdb;

/**
 * solution is to update the sql query so that it only
 * queries ONE record, the most recent one.
 * 
 */

$wpdb->update($wpdb->prefix . 'adoptedideaswidget',
	array(
		'approved'=>'1',
		'bp_id'=>'0',
		'time'=>date("Y-m-d H:i:s")
	),
	array('bp_id'=>$bp_id)
);

messages_delete_thread($bp_id);

header("Location: ".$_SERVER['HTTP_REFERER']);