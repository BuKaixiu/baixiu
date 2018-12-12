<?php 
require_once '../functions.php';

// 判断用户是否登陆一定是最先去做
bx_get_current_user();

// 获取页面所需要的数据
// 重复的操作进行封装
// 文章
$posts_count = bx_fetch_one('select count(1) as num from posts;')['num'];
// 草稿
$posts_drafted_count = bx_fetch_one("select count(1) as num from posts where status = 'drafted';")['num'];
// 分类
$categories_count = bx_fetch_one('select count(1) as num from categories;')['num'];
// 评论
$comments_app_count = bx_fetch_one("select count(1) as num from comments where status = 'approved';")['num'];
// 待审评论
$comments_held_count = bx_fetch_one("select count(1) as num from comments where status = 'held';")['num'];
 ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Dashboard &laquo; Admin</title>
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
      <div class="jumbotron text-center">
        <h1>One Belt, One Road</h1>
        <p>Thoughts, stories and ideas.</p>
        <p><a class="btn btn-primary btn-lg" href="post-add.php" role="button">写文章</a></p>
      </div>
      <div class="row">
        <div class="col-md-4">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">站点内容统计：</h3>
            </div>
            <ul class="list-group">
              <li class="list-group-item"><strong><?php echo $posts_count; ?></strong>篇文章（<strong><?php echo $posts_drafted_count; ?></strong>篇草稿）</li>
              <li class="list-group-item"><strong><?php echo $categories_count; ?></strong>个分类</li>
              <li class="list-group-item"><strong><?php echo $comments_app_count; ?></strong>条评论（<strong><?php echo $comments_held_count; ?></strong>条待审核）</li>
            </ul>
          </div>
        </div>
        <div class="col-md-4">
          <canvas id="chart" width="400" height="400"></canvas>
        </div>
        <div class="col-md-4"></div>
      </div>
    </div>
  </div>
  <?php $current_page = 'index' ?>
  // include 表示代码粘到这里
  <?php  include 'inc/sidebar.php'; ?>
  <script src="/static/assets/vendors/jquery/jquery.js"></script>
  <script src="/static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src="/static/assets/vendors/chart/chart.js"></script>
  <script>NProgress.done()</script>
  <script>
    var ctx = document.getElementById('chart').getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'pie',
      data: {
        labels: ["文章", "草稿", "分类", "评论", "未审核评论"],
        datasets: [{
            label: '# of Votes',
            data: [<?php echo $posts_count ?>, <?php echo $posts_drafted_count ?>, <?php echo $categories_count ?>, <?php echo $comments_app_count ?>, <?php echo $comments_held_count ?>],
            backgroundColor: [
              'rgba(255, 99, 132, 0.2)',
              'rgba(54, 162, 235, 0.2)',
              'rgba(255, 206, 86, 0.2)',
              'rgba(75, 192, 192, 0.2)',
              'rgba(153, 102, 255, 0.2)'
            ],
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)'
            ],
            borderWidth: 1,
        }]
      },
    });
  </script>
</body>
</html>
