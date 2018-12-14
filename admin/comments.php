<?php 
  require_once '../functions.php';
  bx_get_current_user();
  $comments = bx_fetch("select * from comments;");
  // var_dump($comments);
 ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Comments &laquo; Admin</title>
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
        <h1>所有评论</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <div class="btn-batch" style="display: inline-block;">
          <a class="btn btn-danger btn-sm" href="javascript:;" style="display: none">批量批准</a>
          <a class="btn btn-danger btn-sm" href="javascript:;" style="display: none">批量拒绝</a>
          <a class="btn btn-danger btn-sm" id="delete_All" href="/admin/api/delete.php" style="display: none">批量删除</a>
        </div>
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
            <th>作者</th>
            <th>评论</th>
            <th>评论在</th>
            <th>提交于</th>
            <th>状态</th>
            <th class="text-center" width="100">操作</th>
          </tr>
        </thead>
        <tbody id="tb">
         <?php foreach ($comments as $value): ?>
            <tr class="danger">
            <td class="text-center"><input type="checkbox" data-id="<?php echo $value['id'] ?>" data-action="<?php echo $_SERVER['PHP_SELF'] ?>" data-table="<?php echo 'comments'?>"></td>
            <td><?php echo $value['author']; ?></td>
            <td><?php echo $value['content'] ?></td>
            <td>
              <?php 
              $post_id = $value['post_id'];
              echo bx_fetch_one("select title as num from posts where id = '{$post_id}';")['num']; ?>
              </td>
            <td><?php echo $value['created']; ?></td>
            <td>
            <?php if ($value['status'] === 'approved'): ?>
              <?php echo '已批准' ?>
            <?php elseif ($value['status'] === 'held'): ?>
              <?php echo "带审核"; ?>
            <?php elseif ($value['status'] === 'rejected'): ?>
              <?php echo "未批准" ?>
            <?php endif ?> 
            </td>
            <td class="text-center">
              <a href="/admin/api/delete.php?id=<?php echo $value['id'] ?>&action=<?php echo $_SERVER['PHP_SELF'] ?>&table=<?php echo 'comments'?>" class="btn btn-info btn-xs">编辑</a>
                  <a href="/admin/api/delete.php?id=<?php echo $value['id'] ?>&action=<?php echo $_SERVER['PHP_SELF'] ?>&table=<?php echo 'comments'?>" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr>
         <?php endforeach ?>
        </tbody>
      </table>
    </div>
  </div>
  <?php $current_page = 'comments' ?>
 <?php  include 'inc/sidebar.php'; ?>

  <script src="/static/assets/vendors/jquery/jquery.js"></script>
  <script src="/static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <?php include 'inc/checked.php' ?>
  <script>NProgress.done()</script>
</body>
</html>
