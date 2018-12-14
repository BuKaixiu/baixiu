<?php 
	// var_dump($_GET);
	require_once '../../functions.php';
	if (empty($_GET['id'])) {
		exit('缺少必要参数');
	}
	// 不会出现传递过来的是字符串
	$id = $_GET['id'];

	$action = $_GET['action'];
	$table = $_GET['table'];
	bx_get_current_user();
	$rows = bx_execute("delete from {$table} where id in ({$id});");
	// if ($rows > 0) {
	// 	header("LOCATION: ../../{$action }");
	// }
	header("LOCATION: ../../{$action }");
?>