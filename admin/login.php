<?php 
  require_once '../config.php';
  session_start();
  function login() {
    global $user;
    // 1.接收效验
    if (empty($_POST['email'])) {
      $GLOBALS['message'] = '请输入用户名';
      return;
    }
    if (empty($_POST['password'])) {
      $GLOBALS['message'] = '请输入密码';
    }

    $email = $_POST['email'];
    $password = $_POST['password'];
    // 当客户端提交过来的完整表单信息就应该开始对其进行数据校验
    // if ($email !== 'bukaixiu@gmail.com') {
    //   $GLOBALS['message'] = '用户名错误';
    //   return;
    // }

    // if ($password !== 'buxiu520') {
    //   $GLOBALS['message'] = '密码错误';
    //   return;
    // }

    // 数据库
    // 1.连接数据库
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if (!$conn) {
      $GLOBALS['message'] = '连接失败';
      return;
    }
    // 2.查询
    $query = mysqli_query($conn, "select * from users where email = '{$email}' limit 1;");
    if (!$query) {
      $GLOBALS['message'] = '登陆失败请稍请重试';
      return;
    }
    $user = mysqli_fetch_assoc($query);
    if (!$user) {
      $GLOBALS['message'] = '用户不存在';
      return;
    }
    // var_dump($user);
    if ($user['password'] !== $password) {
      $GLOBALS['message'] = '密码错误';
      return;
    }
    // 2.持久化
    // 3.响应
    // 为了后面能直接拿到当前登陆用户的信息，这里直接将用户信息放到 session 中
    $_SESSION['current_login_user'] = $user;
    header('LOCATION: /admin/index.php');
  }
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    login();
  }
 ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Sign in &laquo; Admin</title>
  <link rel="stylesheet" href="/static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="/static/assets/css/admin.css">
  <link rel="stylesheet" href="/static/assets/vendors/animate/animate.min.css">
</head>
<body>
  <div class="login">
    <!-- 可以在 form 上添加 novalidate 取消浏览器自带的校验功能 -->
    <!-- autocomplete 关闭客户端自动提示功能 -->
    <form class="login-wrap<?php echo isset($message) ? ' shake animated' : '' ?>" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" novalidate autocomplete="off">
      <img class="avatar" src="<?php echo isset($user) ? $user['avatar'] : '/static/assets/img/default.png' ?>">
      <!-- 有错误信息时展示 -->
      <?php if (isset($message)): ?>
        <div class="alert alert-danger">
          <strong>错误！</strong><?php echo $message; ?>
        </div>
      <?php endif ?>
      <div class="form-group">
        <label for="email" class="sr-only">邮箱</label>
        <input id="email" type="email" name="email" class="form-control" placeholder="邮箱" value="<?php echo isset($_POST['email']) ? $_POST['email'] : '' ?>" autofocus>
      </div>
      <div class="form-group">
        <label for="password" class="sr-only">密码</label>
        <input id="password" name="password" type="password" class="form-control" placeholder="密码">
      </div>
      <button class="btn btn-primary btn-block">登 录</button>
    </form>
  </div>
  <script src="/static/assets/vendors/jquery/jquery.js"></script>
  <script>
    $(function ($) {
      // 1.单独作用域
      // 2. 确保页面加载后执行

      // 目标：在用户输入自己的邮箱过后，页面上展示这个邮箱对应的头像
      // 实现：
      //      - 时机：邮箱文本框失去焦点,并且能够拿到文本框中填写的邮箱时
      //      - 事情：获取这个文本框中填写的邮箱对应的头像地址展示到上面的 img 元素上
      var emailFormat = /^[a-zA-Z0-9]+@[a-zA-Z0-9]+\.[a-z]+$/;
      $('#email').on('blur', function () {
        var value = $(this).val();
        // 忽略掉文本框为空或者不是一个邮箱
        if (!value || !emailFormat.test(value)) return;
        // 用户输入了一个合理的邮箱地址
        // 获取邮箱对应的头像地址
        // 因为客户端的 JS 无法之间操作数据库，应该通过 JS 发送 AJAX 请求 告诉服务端某个接口， 让这个接口帮助客户端获取头像地址

        $.get('/admin/api/avatar.php', { email: value }, function (res) {
          // 希望 res => 这个邮箱对应的头像地址
          console.log(res);
          if (!res) return;
          // 展示到 img 元素上
          // $('.avatar').fadeOut().attr('src', res).fadeIn();
          $('.avatar').fadeOut(function () {
            // 等到淡出完成
            $(this).on('load', function () {
              $(this).fadeIn();
            }).attr('src', res);
          })
        });

      })
    }) 
  </script>
</body>
</html>
