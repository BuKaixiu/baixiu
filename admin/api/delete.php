<?php 
	// var_dump($_GET);
	require_once '../../functions.php';
	$id = $_GET['id'];
	$action = $_GET['action'];
	$table = $_GET['table'];
	bx_get_current_user();
	bx_execute("delete from {$table} where id = '{$id}'");
	header("LOCATION: ../../{$action }");
?>