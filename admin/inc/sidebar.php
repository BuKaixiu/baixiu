<?php 
$current_page = isset($current_page) ? $current_page : ''; 
// session_start();
// $current_user = $_SESSION['current_login_user']; 

// require_once '../../config.php';
//  物理路径
// 因为这个 sidebar.php 是被 index.php 载入执行， 所以 这里的相当路径是相对于index.php
// 如果希望根治这问题，可以采用物理路径
require_once dirname(__FILE__) . '/../../functions.php';
$current_user = bx_get_current_user();
// $current_user = bx_get_current_user();
?>
<div class="aside">
    <div class="profile">
      <img class="avatar" src="<?php echo $current_user['avatar']; ?>">
      <h3 class="name"><?php echo $current_user['slug']; ?></h3>
    </div>  
    <ul class="nav">
      <li <?php echo $current_page === 'index' ? 'class="active"' : '' ?>>
        <a href="/admin/index.php"><i class="fa fa-dashboard"></i>仪表盘</a>
      </li>
      <?php $menu_post = array('posts', 'post-add', 'categories'); ?>
      <li <?php echo in_array($current_page, $menu_post) ? 'class="active"' : '' ?>>
        <a href="#menu-posts" <?php echo in_array($current_page, $menu_post) ? '' : 'class="collapsed"' ?> data-toggle="collapse">
          <i class="fa fa-thumb-tack"></i>文章<i class="fa fa-angle-right"></i>
        </a>
        <ul id="menu-posts" class="collapse<?php echo in_array($current_page, $menu_post) ? ' in' : '' ?>"a>
          <li <?php echo $current_page === 'posts' ? 'class="active"' : '' ?>><a href="/admin/posts.php">所有文章</a></li>
          <li <?php echo $current_page === 'post-add' ? 'class="active"' : '' ?>><a href="/admin/post-add.php">写文章</a></li>
          <li <?php echo $current_page === 'categories' ? 'class="active"' : '' ?>><a href="/admin/categories.php">分类目录</a></li>
        </ul>
      </li>
      <li <?php echo $current_page === 'comments' ? 'class="active"' : '' ?>>
        <a href="/admin/comments.php"><i class="fa fa-comments"></i>评论</a>
      </li>
      <li <?php echo $current_page === 'users' ? 'class="active"' : '' ?>>
        <a href="/admin/users.php"><i class="fa fa-users"></i>用户</a>
      </li>
      <?php $menu_settings = array('nav-menus', 'slides', 'settings'); ?>
      <li <?php echo in_array($current_page, $menu_settings) ? 'class="active"' : ''; ?>>
        <a href="#menu-settings" <?php echo in_array($current_page, $menu_post) ? '' : 'class="collapsed"' ?>  data-toggle="collapse">
          <i class="fa fa-cogs"></i>设置<i class="fa fa-angle-right"></i>
        </a>
        <ul id="menu-settings" class="collapse<?php echo in_array($current_page, $menu_settings) ? ' in' : '' ?>">
          <li <?php echo $current_page === 'nav-menus' ? 'class="active"' : '' ?>><a href="/admin/nav-menus.php">导航菜单</a></li>
          <li <?php echo $current_page === 'slides' ? 'class="active"' : '' ?>><a href="/admin/slides.php">图片轮播</a></li>
          <li <?php echo $current_page === 'settings' ? 'class="active"' : '' ?>><a href="/admin/settings.php">网站设置</a></li>
        </ul>
      </li>
    </ul>
  </div>