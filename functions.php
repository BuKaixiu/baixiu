<?php 
	require_once 'config.php';
/**
 * 封装大家公用的函数
 */
session_start();

// JS 判断方式：typeof fn === function
// php 判断的方式： function_exists('fn名');

/**
 * 获取当前登陆用户信息，如果没有获取到则自动跳转到登陆页面
 * 定义函数时一定要注意函数名与内置函数冲突问题
 * @Author   zhengkai
 * @DateTime 2018-12-10T18:40:19+0800
 * @return   [type]
 */
function bx_get_current_user () {
	if (empty($_SESSION['current_login_user'])) {
		// 没有当前登陆信息，意味着没有登陆
		header('LOCATION: /admin/login.php');
		exit(); // 没有必要再执行之后的代码
	}
	return $_SESSION['current_login_user'];
}

/**
 * connectDatabase
 * @Author   zhengkai
 * @DateTime 2018-12-13T15:02:18+0800
 * @return   [type]                   [description]
 */
function connectDatabase() {
	$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if (!$conn) {
		exit('<h1>连接数据库失败</h1>');
	}
	return $conn;
}
/**
 * 通过一个数据库查询获取多条数据
 * @Author   zhengkai
 * @DateTime 2018-12-11T14:37:35+0800
 * @return $resultcuu
 */
function bx_fetch ($sql) {
	$conn = connectDatabase();
	$query = mysqli_query($conn,$sql);
	if (!$query) {
		// 查询失败
		return false;
	}
	while ($rows = mysqli_fetch_assoc($query)) {
		$result[] = $rows;
	}
	mysqli_free_result($query);
	mysqli_close($conn);
	return $result;
}
/**
 * 获取单条数据
 * @Author   zhengkai
 * @DateTime 2018-12-11T15:34:56+0800
 * @param    [type]                   $sql [description]
 * @return   [type]                   $row [description]
 */
function bx_fetch_one($sql) {
	$rows = bx_fetch($sql);
	return isset($rows[0]) ? $rows[0] : null;
}

/**
 * [bx_execute description]
 * @Author   zhengkai
 * @DateTime 2018-12-13T16:27:36+0800
 * @param    [type]                   $sql [description]
 * @return   [type]                        [description]
 */
function bx_execute($sql) {
	$conn = connectDatabase();
	$query = mysqli_query($conn, $sql);
	if (!$query) {
		return false;
	}
	// 获取受影响的行数
	$affected = mysqli_affected_rows($conn);
	mysqli_close($conn);
	return $affected;
}