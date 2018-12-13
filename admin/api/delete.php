<?php 
	require_once '../../functions.php';
	$id = $_GET['id'];
	bx_get_current_user();
	bx_execute("delete from categories where id = '{$id}'");
	header("LOCATION: ../../admin/categories.php");
?>