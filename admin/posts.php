<?php 
  require_once '../functions.php';
  bx_get_current_user();
  $post = bx_fetch("select * from posts");
  $categories = bx_fetch("select name from categories");
  // var_dump($categories);
 ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Posts &laquo; Admin</title>
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
        <h1>所有文章</h1>
        <a href="post-add.php" class="btn btn-primary btn-xs">写文章</a>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
       <a class="btn btn-danger btn-sm" id="delete_All" href="/admin/api/delete.php" style="display: none">批量删除</a>
        <form class="form-inline">
          <select name="" class="form-control input-sm">
            <option value="">所有分类</option>
            <?php foreach ($categories as $var): ?>
              <option value=""><?php echo $var['name'] ?></option>
            <?php endforeach ?>
          </select>
          <select name="" class="form-control input-sm">
            <option value="">所有状态</option>
            <option value="">草稿</option>
            <option value="">已发布</option>
          </select>
          <button class="btn btn-default btn-sm">筛选</button>
        </form>
        <ul class="pagination pagination-sm pull-right">
          <li><a href="#">上一页</a></li>
          <li><a href="#">1</a></li>
          <li><a href="#">2</a></li>
          <li><a href="#">3</a></li>
          <li><a href="#">下一页</a></li>
        </ul>
      </div>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th class="text-center" width="40"><input id="checkAll" type="checkbox"></th>
            <th>标题</th>
            <th>作者</th>
            <th>分类</th>
            <th class="text-center">发表时间</th>
            <th class="text-center">状态</th>
            <th class="text-center" width="100">操作</th>
          </tr>
        </thead>
        <tbody id="tb">
          <?php foreach ($post as $var): ?>
          <tr>
            <td class="text-center"><input type="checkbox" data-id="<?php echo $var['id'] ?>" data-action="<?php echo $_SERVER['PHP_SELF'] ?>" data-table="<?php echo 'posts'?>"></td>
            <td><?php echo $var['title'] ?></td>
            <td><?php echo bx_fetch_one("select nickname as num from users where id = {$var['user_id']};")['num']; ?></td>
            <td><?php echo bx_fetch_one("select name as num from categories where id = {$var['category_id']};")['num']; ?></td>
            <td class="text-center"><?php echo $var['created'] ?></td>
            <td class="text-center">
              <?php if ($var['status'] === 'published'): ?>
                <?php echo "已发布" ?>
              <?php elseif ($var['status'] === 'drafted'): ?>
                <?php echo "草稿"; ?>
              <?php endif ?>
            </td>
            <td class="text-center">
              <a href="/admin/api/delete.php?id=<?php echo $var['id'] ?>&action=<?php echo $_SERVER['PHP_SELF'] ?>&table=<?php echo 'posts'?>" class="btn btn-info btn-xs">编辑</a>
                  <a href="/admin/api/delete.php?id=<?php echo $var['id'] ?>&action=<?php echo $_SERVER['PHP_SELF'] ?>&table=<?php echo 'posts'?>" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
  </div>
  <?php $current_page = 'posts' ?>
  <?php  include 'inc/sidebar.php'; ?>

  <script src="/static/assets/vendors/jquery/jquery.js"></script>
  <script src="/static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <?php include 'inc/checked.php' ?>
  <script>NProgress.done()</script>
</body>
</html>
