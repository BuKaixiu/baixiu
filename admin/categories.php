<?php 
  require_once '../functions.php';  
  bx_get_current_user();
  function addCategories() {
    if (empty($_POST['name'])) {
      $GLOBALS['message'] = '请输入名称';
      return;
    }
    if (empty($_POST['slug'])) {
      $GLOBALS['message'] = '请输入别名';
      return;
    }
    $catName = $_POST['name'];
    $catSlug = $_POST['slug'];
    $rows = bx_execute("insert into categories values (null, '{$catSlug}', '{$catName}')");
    $GLOBALS['success'] = $rows > 0 ? true : false;
    $GLOBALS['message'] = $rows <= 0 ? '添加失败' : '添加成功';
  }
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    addCategories();
  }
  // 如果修改操作与操作在一起，那么一定是先做修改在做查询，时效性强
  $categories = bx_fetch('select * from categories;');
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">  
  <title>Categories &laquo; Admin</title>
  <link rel="stylesheet" href="/static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="/static/assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="/static/assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="/static/assets/css/admin.css">
  <script src="/static/assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <?php include 'inc/navbar.php'; ?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>分类目录</h1>
      </div>
     <!-- 有错误信息时展示 -->
      <?php if (isset($message)): ?>
      <?php if ($success): ?>
      <div class="alert alert-success">
        <strong>成功！</strong><?php echo $message; ?>
      </div>
      <?php else: ?>
      <div class="alert alert-danger">
        <strong>错误！</strong><?php echo $message; ?>
      </div>
      <?php endif ?>
      <?php endif ?>
      <div class="row">
        <div class="col-md-4">
          <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off">
            <h2>添加新分类目录</h2>
            <div class="form-group">
              <label for="name">名称</label>
              <input id="name" class="form-control" name="name" type="text" placeholder="分类名称">
            </div>
            <div class="form-group">
              <label for="slug">别名</label>
              <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
              <p class="help-block">https://zce.me/category/<strong>slug</strong></p>
            </div>
            <div class="form-group">
              <button class="btn btn-primary">添加</button>
            </div>
          </form>
        </div>
        <div class="col-md-8">
          <div class="page-action">
            <!-- show when multiple checked -->
            <a class="btn btn-danger btn-sm" id="delete_All" href="javascript:;" style="display: none">批量删除</a>
          </div>
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th class="text-center" width="40"><input id="checkAll" type="checkbox"></th>
                <th>名称</th>
                <th>Slug</th>
                <th class="text-center" width="100">操作</th>
              </tr>
            </thead>
            <tbody id="tb">
              <?php foreach ($categories as $var): ?>
              <tr>
                <td class="text-center"><input type="checkbox"></td>
                <td><?php echo $var['name'] ?></td>
                <td><?php echo $var['slug'] ?></td>
                <td class="text-center">
                  <a href="/admin/api/delete.php?id=<?php echo $var['id'] ?>&action=<?php echo $_SERVER['PHP_SELF'] ?>&table=<?php echo 'categories'?>" class="btn btn-info btn-xs">编辑</a>
                  <a href="/admin/api/delete.php?id=<?php echo $var['id'] ?>&action=<?php echo $_SERVER['PHP_SELF'] ?>&table=<?php echo 'categories'?>" class="btn btn-danger btn-xs">删除</a>
                </td>
              </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <?php $current_page = 'categories'; ?>
  <?php  include 'inc/sidebar.php'; ?>

  <script src="/static/assets/vendors/jquery/jquery.js"></script>
  <script src="/static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <?php include 'inc/checked.php' ?>
  <script>NProgress.done()</script>
</body>
</html>
